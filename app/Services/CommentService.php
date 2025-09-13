<?php

namespace App\Services;

use App\Repositories\CommentRepository;

class CommentService
{
    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getCommentsForPost($postId)
    {
        return $this->commentRepository->getByPost($postId);
    }

    public function addComment($userId, $postId, $content)
    {
        return $this->commentRepository->create([
            'user_id' => $userId,
            'post_id' => $postId,
            'content' => $content,
        ]);
    }

    public function deleteComment($commentId)
    {
        return $this->commentRepository->delete($commentId);
    }
}
