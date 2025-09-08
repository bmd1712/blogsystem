<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    public function getAll($perPage = 10)
    {
        return Post::with(['category', 'tags', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function findById($id)
    {
        return Post::with(['category', 'tags', 'user'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Post::create($data);
    }

    public function update($id, array $data)
    {
        $post = Post::findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        return $post->delete();
    }

    /**
     * Lấy bài viết chưa đọc cho newsfeed
     */
    public function getUnreadPosts(array $excludeIds, $perPage = 10)
    {
        return Post::with(['category', 'tags', 'user'])
            ->when(!empty($excludeIds), function ($query) use ($excludeIds) {
                $query->whereNotIn('id', $excludeIds);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Lấy bài viết của user (profile)
     */
    public function getUserPosts($userId, $perPage = 10)
    {
        return Post::with(['category', 'tags'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}
