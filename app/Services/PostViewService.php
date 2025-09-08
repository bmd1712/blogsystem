<?php

namespace App\Services;

use App\Repositories\PostViewRepository;
use Illuminate\Support\Facades\Auth;

class PostViewService
{
    protected $postViewRepository;

    public function __construct(PostViewRepository $postViewRepository)
    {
        $this->postViewRepository = $postViewRepository;
    }

    public function markPostAsRead($postId)
    {
        $userId = Auth::id();
        return $this->postViewRepository->markAsRead($userId, $postId);
    }

    public function getUserReadPosts()
    {
        $userId = Auth::id();
        return $this->postViewRepository->getReadPosts($userId);
        
    }
}