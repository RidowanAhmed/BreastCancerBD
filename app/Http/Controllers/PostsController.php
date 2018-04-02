<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $posts = Post::query()->orderBy('id', 'desc')->paginate(6);
        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        return view('post.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $user = Auth::user();
        $user->posts()->create($request->all());
        return redirect('/stories');
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
//        $post = Post::findBySlugOrFail($slug);
//        return view('post.show', compact('post'));
        return view('post.show', [
            'post' => Post::findBySlugOrFail($slug)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = Post::findBySlugOrFail($slug);
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $slug)
    {
        $post = Post::findBySlugOrFail($slug);
        Session::flash('msg', "Post " . $post->title . " updated");
        $post->update($request->all());
        return redirect()->route('stories.show', $post->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($slug)
    {
        $post = Post::findBySlugOrFail($slug);
        Session::flash('msg', $post->title . " deleted");
        $post->delete();
        return redirect('/stories');
    }

}
