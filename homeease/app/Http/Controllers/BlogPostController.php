<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;

class BlogPostController extends Controller
{
    public function index()
    {
        $blogPosts = BlogPost::withCount('likes', 'comments')->get();
        return response()->json($blogPosts);
    }

    public function show($id)
    {
        $blogPost = BlogPost::with(['likes', 'comments'])->findOrFail($id);
        return response()->json($blogPost);
    }
    
    // delete, edit, create, update

    public function like($id)
    {
        $blogPost = BlogPost::findOrFail($id);
        $blogPost->likes()->create([
            'blogger_id' => auth()->id()
        ]);
        $blogPost->increment('likes');
        return response()->json(['message' => 'Blog post liked']);
    }

    public function comment($id, Request $request)
    {
        $blogPost = BlogPost::findOrFail($id);
        $blogPost->comments()->create([
            'blogger_id' => auth()->id(),
            'content' => $request->input('content')
        ]);
        $blogPost->increment('comments');
        return response()->json(['message' => 'Comment added']);
    }
    
    // public function viewComments

    // public function topBloggers()
    // {
    //     $topBloggers = Blogger::whereHas('likes')->withCount('likes')->orderBy('likes_count', 'desc')->take(10)->get();
    //     return response()->json($topBloggers);
    // }

    
}
