<?php

namespace App\Repositories;

use App\Models\PostView;

class PostViewRepository
{
    public function markAsRead($userId, $postId)
    {
        return PostView::updateOrCreate(
            ['user_id' => $userId, 'posts_id' => $postId],
            ['isRead' => true]
        );
    }

    public function getReadPosts($userId)
    {
        return PostView::with('post')
            ->where('user_id', $userId)
            ->where('isRead', true)
            ->get();
    }

    public function getReadPostIds($userId)
    {
        return PostView::where('user_id', $userId)
            ->where('isRead', true)
            ->pluck('posts_id')
            ->toArray();
    }

}