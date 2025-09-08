<?php

namespace App\Services;

use App\Repositories\PostRepository;
use App\Repositories\PostViewRepository;
use App\Services\TagService;
use Illuminate\Support\Facades\Auth;

class PostService
{
    protected $postRepository;
    protected $tagService;
    protected $postViewRepository;

    public function __construct(
        PostRepository $postRepository,
        TagService $tagService,
        PostViewRepository $postViewRepository
    ) {
        $this->postRepository = $postRepository;
        $this->tagService = $tagService;
        $this->postViewRepository = $postViewRepository;
    }

    public function getAllPosts($perPage = 10)
    {
        return $this->postRepository->getAll($perPage);
    }

    public function getUnreadPosts($perPage = 10)
    {
        $userId = Auth::id();
        $readIds = $this->postViewRepository->getReadPostIds($userId);

        return $this->postRepository->getUnreadPosts($readIds, $perPage);
    }

    public function getUserPosts($userId, $perPage = 10)
    {
        return $this->postRepository->getUserPosts($userId, $perPage);
    }

    public function getPostById($id)
    {
        return $this->postRepository->findById($id);
    }

    public function createPost(array $data, array $tags = [])
    {
        $data['user_id'] = Auth::id();

        $post = $this->postRepository->create($data);

        if (!empty($tags)) {
            $tagIds = [];
            foreach ($tags as $tagName) {
                $tag = $this->tagService->createIfNotExists($tagName);
                $tagIds[] = $tag->id;
            }
            $post->tags()->sync($tagIds);
        }

        return $post->load(['category', 'tags']);
    }

    public function updatePost($id, array $data, array $tags = [])
    {
        $post = $this->postRepository->update($id, $data);

        if (!empty($tags)) {
            $tagIds = [];
            foreach ($tags as $tagName) {
                $tag = $this->tagService->createIfNotExists($tagName);
                $tagIds[] = $tag->id;
            }
            $post->tags()->sync($tagIds);
        }

        return $post->load(['category', 'tags']);
    }

    public function deletePost($id)
    {
        return $this->postRepository->delete($id);
    }
}
