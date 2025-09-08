<?php   

namespace App\Http\Controllers;

use App\Services\PostViewService;

class PostViewController extends Controller
{
    protected $postViewService;

    public function __construct(PostViewService $postViewService)
    {
        $this->postViewService = $postViewService;
    }

    // POST /api/posts/{id}/read
    public function markAsRead($id)
    {
        $view = $this->postViewService->markPostAsRead($id);
        return response()->json([
            'message' => 'Đã đánh dấu bài viết là đã đọc',
            'data' => $view
        ]);
    }

    // GET /api/posts/read
    public function getReadPosts()
    {
        return response()->json(
            $this->postViewService->getUserReadPosts()
        );
    }
}