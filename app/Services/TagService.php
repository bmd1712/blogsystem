<?php

namespace App\Services;

use App\Repositories\TagRepository;
use App\Models\Tag;

class TagService
{
    public function __construct(
        protected TagRepository $tags
    ) {}

    public function getTags(?string $search = null, int $limit = 20)
    {
        return $this->tags->search($search, $limit);
    }

    public function createIfNotExists(string $tag): Tag
    {
        if ($existing = $this->tags->findByName($tag)) {
            return $existing;
        }
        return $this->tags->create(['tag' => $tag]);
    }
}
