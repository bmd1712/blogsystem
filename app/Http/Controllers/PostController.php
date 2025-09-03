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

    // GET /api/posts
    public function index()
    {
        $posts = $this->postService->getAllPosts();
        return response()->json($posts);
    }

    // GET /api/posts/{id}
    public function show($id)
    {
        $post = $this->postService->getPostById($id);
        return response()->json($post);
    }
}
