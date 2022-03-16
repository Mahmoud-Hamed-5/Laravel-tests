@extends('layouts.app')

@section('content')
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="js\myjs.js"></script>
</head>

<div class="container">
    <div class="row">
      <div class="col">
        <div class="jumbotron">
            <h2 class="display-5">Add new post</h2>
            <hr class="my-4">
            <div class="col">
                <form action="{{route('post.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label for="exampleFormControlInput1">Title</label>
                      <input type="text" name="title" >
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlTextarea1">Content</label>
                      <textarea class="form-control" name="content" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Photo</label><br>
                        <input type="file"  name="photo">
                      </div>
        <br>
                    <div class="form-group">
                        <button class="btn btn-success" type="submit">Publish</button>
                      </div>

                </form>
            </div>
        </div>
      </div>
    </div>
</div>

<div class="container" >
    <a href="{{route('post.create')}}">Create post</a>
    <div class="row">
        <div class="col-md-8">



              @if ($posts->count() > 0)
              @php
                $c = 1;
                $counter_id = "likes_counter" . $c;

                $b = 1;
                $button_id = "like_button" . $b;
              @endphp
            @foreach ($posts as $post)

            <div class="post-content">
              <div class="post-container">
                <div class="post-detail">
                  <div class="user-info">
                    <h5>
                        <img src="{{URL::asset($post->user->profile->profile_picture)}}" alt="d"
                            class="profile-photo-md pull-left">
                        <a href="timeline.html" class="profile-link">{{$post->user->name}}</a>
                         <span class="following">show</span>
                    </h5>
                    <p class="text-muted">Published: {{$post->created_at->diffForhumans()}}</p>
                  </div>
                    <div class="reaction">
                        <i id={{$counter_id}} class="fa fa-thumbs-up"> {{$post->likes}}</i>
                        {{-- <p id={{$counter_id}} class="btn text-green">
                            {{$post->likes}}</p> --}}
                        {{-- <i id={{$counter_id}} class="fa fa-thumbs-down"> {{$post->likes}}</i> --}}
                    </div>
                  <div class="line-divider"></div>
                  <div class="post-title">
                    <p> {{$post->title}} <i class="em em-anguished"></i>
                        <i class="em em-anguished"></i> <i class="em em-anguished"></i></p>
                  </div>
                  <div class="post-text">
                    <p> {{$post->content}} <i class="em em-anguished"></i>
                        <i class="em em-anguished"></i> <i class="em em-anguished"></i></p>
                  </div>
                  <div class="line-divider"></div>
                  <div class="post-photo">
                    <img src="{{URL::asset($post->photo)}}" alt="{{$post->photo}}"
                    class="img-tumbnail" width="300" height="300">
                  </div>
                  <div class="line-divider"></div>

<div style="margin-top: 10px">
                  <button type="button"
                            onclick="like({{$post->id}} , {{$c}} , {{$b}})">
                            @if ($post->isliked($post->id))
                                <i id={{$button_id}} class="fa-regular fa-2x fa-thumbs-down"></i>
                            @else
                                <i id={{$button_id}} class="fa-regular fa-2x fa-thumbs-up"></i>
                            @endif
                    </button>
</div>



                </div>
              </div>

              @php
                $c = $c+1;
                $counter_id = 'likes_counter' . $c;

                $b = $b + 1;
                $button_id = "like_button" . $b;
                 @endphp
              @endforeach

              @else
                 <div class="alert alert-danger" role="alert"> No posts! </div>
              @endif
            </div>
        </div>
    </div>
</div>



@endsection
