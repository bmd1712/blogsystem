<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    
    public function feed(Request $request)
    {
        $limit = $request->query('limit', 10);
        return response()->json(
            $this->postService->getAllPosts($limit)
        );
    }

    //post view
    public function newsfeed(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        return response()->json($this->postService->getUnreadPosts($perPage));
    }

    // GET /api/users/{userId}/posts
    public function userPosts(Request $request, $userId)
    {
        $perPage = $request->input('per_page', 10);
        return response()->json($this->postService->getUserPosts($userId, $perPage));
    }

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

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = $this->postService->createPost($validated, $request->input('tags', []));

        return response()->json([
            'message' => 'Bài viết đã được tạo thành công',
            // 'data'    => $post,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'       => 'sometimes|string|max:255',
            'content'     => 'sometimes|string',
            'image'       => 'nullable|string|max:2048',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $post = $this->postService->updatePost($id, $validated, $request->input('tags', []));
        return response()->json($post);
    }

    public function destroy($id)
    {
        $this->postService->deletePost($id);
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
