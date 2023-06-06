<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\User;
use App\Models\Comment;
use App\Models\Like;


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

    public function edit($id)
    {
        $blogPost = BlogPost::findOrFail($id);
        // Additional logic for fetching any related data, if needed

        return view('blogposts.edit', compact('blogPost'));
    }

    public function update(Request $request, $id)
    {
        $blogPost = BlogPost::findOrFail($id);

        // Validate the input data
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        // Update the blog post with the validated data
        $blogPost->update($validatedData);

        // Redirect or return a response
        return redirect()->route('blogposts.show', $blogPost->id)
            ->with('success', 'Blog post updated successfully.');
    }

    public function destroy($id)
    {
        $blogPost = BlogPost::findOrFail($id);
        $blogPost->delete();

        // Redirect or return a response
        return redirect()->route('blogposts.index')
            ->with('success', 'Blog post deleted successfully.');
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
    public function viewComments($id)
    {
        $blogPost = BlogPost::findOrFail($id);
        $comments = $blogPost->comments()->with('user')->get();

        return response()->json($comments);
    }

    // public function topBloggers()
    // {
    //     $topBloggers = Blogger::whereHas('likes')->withCount('likes')->orderBy('likes_count', 'desc')->take(10)->get();
    //     return response()->json($topBloggers);
    // }

    
}
