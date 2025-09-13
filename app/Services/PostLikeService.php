<?php

namespace App\Services;

use App\Repositories\PostLikeRepository;

class PostLikeService
{
    protected $repository;

    public function __construct(PostLikeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function toggleLike($userId, $postId)
    {
        if ($this->repository->exists($userId, $postId)) {
            $this->repository->delete($userId, $postId);
            return ['liked' => false, 'count' => $this->repository->countByPost($postId)];
        } else {
            $this->repository->create($userId, $postId);
            return ['liked' => true, 'count' => $this->repository->countByPost($postId)];
        }
    }

    public function getLikesCount($postId)
    {
        return $this->repository->countByPost($postId);
    }
}
