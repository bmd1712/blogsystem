<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository
{
    public function getByPost($postId, $perPage = 10)
    {
        return Comment::with('user')
            ->where('post_id', $postId)
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $data)
    {
        return Comment::create($data);
    }

    public function delete($id)
    {
        return Comment::destroy($id);
    }
}
