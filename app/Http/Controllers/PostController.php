<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttachmentRequest;
use App\Models\Blog;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post', [
            'except' => ['create', 'store']
        ]);
        $this->middleware('can:create,App\Models\Post,blog')->only(['create','store']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Blog $blog)
    {
        return view('blogs.posts.index', [
            'posts' => $blog->posts()->latest()->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Blog $blog)
    {
        return view('blogs.posts.create', [
            'blog' => $blog
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request, Blog $blog)
    {
        $post = $blog->posts()->create(
            $request->only(['title', 'content'])
        );
        $this->attachments($request, $post);
        return to_route('posts.show', $post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('blogs.posts.show', [
            'post' => $post->loadCount('comments'),
            'comments' => $post->comments()->doesntHave('parent')->with(['user', 'replies.user'])->get()
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('blogs.posts.edit', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, Post $post)
    {
        $post->update($request->only(['title', 'content']));
        $this->attachments($request, $post);
        return to_route('posts.show', $post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return to_route('blogs.posts.index', $post->blog);
    }

    private function attachments(Request $request, $post)
    {
        if ($request->hasFile('attachments')) {
            app(AttachmentController::class)->store($request, $post);
        }
    }
}
