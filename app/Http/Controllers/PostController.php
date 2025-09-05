<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;


class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    // GET /api/posts
    public function index()
    {
        return response()->json($this->postService->getAllPosts());
    }

    // GET /api/posts/{id}
    public function show($id)
    {
        return response()->json($this->postService->getPostById($id));
    }

    // POST /api/posts
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'tags'        => 'nullable|array',
        ]);

        // Xử lý image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        // Gọi service -> service sẽ tự gán user_id = Auth::id()
        $post = $this->postService->createPost($validated, $request->input('tags', []));

        return response()->json([
            'message' => 'Bài viết đã được tạo thành công',
            'data'    => $post,
        ], 201);
    }

    // PUT /api/posts/{id}
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'       => 'sometimes|string|max:5000',
            'content'     => 'sometimes|string',
            'image'       => 'nullable|string|max:500',
            'user_id'     => 'sometimes|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $post = $this->postService->updatePost($id, $validated);
        return response()->json($post);
    }

    // DELETE /api/posts/{id}
    public function destroy($id)
    {
        $this->postService->deletePost($id);
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
