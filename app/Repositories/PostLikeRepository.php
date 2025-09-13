<?php

namespace App\Repositories;

use App\Models\PostLike;

class PostLikeRepository
{
    public function create($userId, $postId)
    {
        return PostLike::firstOrCreate([
            'user_id' => $userId,
            'post_id' => $postId,
        ]);
    }

    public function delete($userId, $postId)
    {
        return PostLike::where('user_id', $userId)
                       ->where('post_id', $postId)
                       ->delete();
    }

    public function exists($userId, $postId): bool
    {
        return PostLike::where('user_id', $userId)
                       ->where('post_id', $postId)
                       ->exists();
    }

    public function countByPost($postId): int
    {
        return PostLike::where('post_id', $postId)->count();
    }
}
