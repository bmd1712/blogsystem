<?php

namespace App\Http\Controllers;

use App\Services\PostLikeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostLikeController extends Controller
{
    protected $service;

    public function __construct(PostLikeService $service)
    {
        $this->service = $service;
    }

    // Toggle like/unlike
    public function toggle(Request $request, $postId)
    {
        $userId = Auth::id(); // hoặc $request->user()->id nếu dùng Sanctum/JWT

        $result = $this->service->toggleLike($userId, $postId);

        return response()->json([
            'success' => true,
            'liked'   => $result['liked'],
            'count'   => $result['count'],
        ]);
    }

    // Get total likes of a post
    public function count($postId)
    {
        $count = $this->service->getLikesCount($postId);

        return response()->json([
            'post_id' => $postId,
            'likes'   => $count,
        ]);
    }
}
