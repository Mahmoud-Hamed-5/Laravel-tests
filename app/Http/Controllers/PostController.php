<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public $pp = 0;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $posts = Post::all();
        return view('posts.index')->with('posts',$posts);
    }

    public function trashedPosts()
    {
        $posts = Post::onlyTrashed()->get();
        return view('posts.trashed',$posts);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'content' => 'required',
            'photo' => 'required|image'
        ]);

        $photo = $request->photo;
        $newPhoto = time().$photo->getClientOriginalName();
        $photo->move('uploads/posts',$newPhoto);

        $post = Post::create([
            'user_id' => Auth::id(),

            'title' => $request->title,
            'content' => $request->content,
            'photo' => 'uploads/posts/'.$newPhoto,
            'slug' => Str::slug($request->title)

        ]);
        return redirect()->back();
    }

    public function show($slug)
    {
        $post = Post::where('slug',$slug)->first();
        return view('posts.show',$post);
    }

    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit',$post);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $this->validate($request,[
            'title' => 'required',
            'content' => 'required',
            'photo' => 'required|image'
        ]);

        if($request->has('photo'))
        {
            $photo = $request->photo;
            $newPhoto = time().$photo->getClientOriginalName();
            $photo->move('uploads/posts',$newPhoto);
            $post->photo = 'uploads/posts/'.$newPhoto;
        }

        $post->title = $request->title;
        $post->content = $request->content;
        $post->save;

        return redirect()->back();
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect()->back();
    }

    public function hdelete($id)
    {
        Post::withTrashed()->where('id' , $id)->first()->forceDelete();
        return redirect()->back();
    }

    public function restore($id)
    {
        Post::withoutTrashed()->where('id' , $id)->first()->restore();
        return redirect()->back();
    }


    public function isliked($post_id)
    {
    //     $user_id = Auth::id();
    //     $p = DB::table('likes')
    //         ->select('user_id', 'post_id')
    //         ->where('user_id', '=', $user_id)
    //         ->where('post_id', '=', $post_id)
    //         ->first();

    //    return ($p != null);
        return Post::isliked($post_id);
    }


    public function like($post_id)
    {
        $user_id = Auth::id();

        $post = Post::find($post_id);
        $l = $post->likes + 1;
        $post->likes = $l;
        $post->save();
        //$post->user()->attach();
       // DB::table('likes')->insert();
        DB::insert('insert into likes (user_id, post_id) values (?, ?)', [$user_id, $post_id]);
        //$a = "ddd";
       // return $post->likes;
       //$s = 'number of likes is: ' . $l;

       return $l;
    }

    public function dislike($post_id)
    {
        $user_id = Auth::id();
        $post = Post::find($post_id);

        $l = $post->likes - 1;
        $post->likes = $l;
        $post->save();
        DB::table('likes')->where('user_id', $user_id)->where('post_id', $post_id)->delete();
        //$a = "ddd";
       // return $post->likes;
       //$s = 'number of likes is: ' . $l;
       return $l;
    }

}
