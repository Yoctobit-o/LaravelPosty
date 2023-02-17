<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    //
    public function index(){
        $posts = Post::latest()->with(['user','likes'])->paginate(20); // returns all posts in natural database order //laravel collection

     //   return view('posts.index', [
     //       'posts' => $posts
     //   ]);

        return view('posts.index', compact('posts'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'body' => 'required'

        ]);

        $request->user()->posts()->create($request->only('body'));

        return back();
    }

    public function destroy(Post $post){
     
        $this->authorize('delete', $post);
        $post->delete();

        return back();
    }
}
