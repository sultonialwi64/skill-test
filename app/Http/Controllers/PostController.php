<?php

namespace App\Http\Controllers;
use App\Http\Requests\StorePostRequest;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Penting untuk authorize()

class PostController extends Controller
{
    use AuthorizesRequests;

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

  
    public function create()
    {
        return "posts.create";
    }

    public function store(StorePostRequest $request)
    {
      
      // Mengambil data langsung dari request yang sudah tervalidasi
    $post = $request->user()->posts()->create([
        'title'        => $request->title,
        'content'      => $request->body, // 'body' dari input form masuk ke kolom 'content' DB
        'published_at' => $request->published_at ?? now(), // Default ke waktu sekarang jika kosong
        'is_draft'     => $request->boolean('is_draft'), // Mengambil nilai boolean (true/false)
    ]);

    // Mengembalikan response JSON dengan status 201 (Created)
    return response()->json($post, 201);
    }

    
    public function edit(Post $post)
{
    $this->authorize('update', $post); 
    return "posts.edit";
}

    public function update(Request $request, Post $post)
    {
       
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'body' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        $post->update([
            'title' => $validated['title'],
            'content' => $validated['body'],
            'published_at' => $validated['published_at'],
            'is_draft' => $request->boolean('is_draft'),
        ]);

        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        
        $this->authorize('delete', $post);
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}