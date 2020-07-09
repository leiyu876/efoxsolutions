<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PageController extends Controller
{
    public function welcome()
    {
        $posts = Post::published()->latest()->paginate(request('limit', 12), ['*'], 'page', request('page', 1));

        return view('welcome', compact('posts'));
    }

    public function post(Post $post)
    {
        if(!$post->is_published) return redirect()->route('welcome');

        return view('post', compact('post'));
    }
}
