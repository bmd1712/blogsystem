<?php

namespace App\Services;

use App\Repositories\PostRepository;
use App\Services\TagService;
use Illuminate\Support\Facades\Auth;

class PostService
{
    protected $postRepository;
    protected $tagService;

    public function __construct(PostRepository $postRepository, TagService $tagService)
    {
        $this->postRepository = $postRepository;
        $this->tagService = $tagService;
    }

    public function getAllPosts()
    {
        return $this->postRepository->getAll();
    }

    public function getPostById($id)
    {
        return $this->postRepository->findById($id);
    }

    public function createPost(array $data, array $tags = [])
    {
        // Gán user_id cho post
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
