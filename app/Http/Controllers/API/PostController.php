<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResourceCollection;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = auth()->user()->posts()->when(request()->has('search_string') && request('search_string') != null, function($q) {
                $q->where('title', 'like', '%'.request()->search_string.'%');
            })
            ->paginate(request('limit', 10), ['*'], 'page', request('page', 1));

        return new PostResourceCollection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $Request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        $post = new Post;

        $imageName = time().'.'.$request->image->getClientOriginalExtension();

        $request->image->move(storage_path('app/public/images'), $imageName);

        return auth()->user()->posts()->create(array_merge($data, ['image'=>$imageName]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePostRequest $request, Post $post)
    {
        $data = $request->validated();

        $post->title = $data['title'];
        $post->content = $data['content'];
        
        if(request()->has('image')) {
            if($post->image) {
                $image_path = storage_path('app/public/images/').$post->image;  // Value is not URL but directory file path
                if(file_exists($image_path)) {
                    unlink($image_path);
                }
            }

            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(storage_path('app/public/images'), $imageName);

            $post->image = $imageName;
        }

        return $post->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        return $post->delete();
    }

    public function tooglePublish(Post $post)
    {
        $post->is_published = !$post->is_published;

        return $post->update();
    }
}
