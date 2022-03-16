<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory, SoftDeletes;


    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'photo',
        'slug'
    ];

    public static function isliked($post_id){
        $user_id = Auth::id();
        $p = DB::table('likes')
            ->select('user_id', 'post_id')
            ->where('user_id', '=', $user_id)
            ->where('post_id', '=', $post_id)
            ->first();

       return ($p != null);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
