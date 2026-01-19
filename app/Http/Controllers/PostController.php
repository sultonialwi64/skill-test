<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        
        $posts = Post::active()->with('user')->paginate(20);
        
        return response()->json($posts);
    }

    public function show($id)
    {
        
        $post = Post::active()->with('user')->findOrFail($id);
        
        return response()->json($post);
    }
    public function store(Request $request)
{
    // Validasi 
    $validated = $request->validate([
        'title' => 'required|string|max:200',
        'body' => 'required|string',
        'published_at' => 'nullable|date',
    ]);

    // Simpan post baru untuk user yang sedang login
    $post = $request->user()->posts()->create([
        'title' => $validated['title'],
        'content' => $validated['body'], 
        'published_at' => $validated['published_at'] ?? now(),
        'is_draft' => $request->has('is_draft') ? $request->is_draft : false,
    ]);

    return response()->json($post, 201);
}

}
