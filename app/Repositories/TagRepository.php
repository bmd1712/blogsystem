<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepository
{
    public function search(?string $q = null, int $limit = 20)
    {
        $query = Tag::query()->orderBy('tag');
        if ($q) {
            $query->where('tag', 'LIKE', "%{$q}%");
        }
        return $query->limit($limit)->get();
    }

    public function findByName(string $tag): ?Tag
    {
        return Tag::where('tag', $tag)->first();
    }

    public function create(array $data): Tag
    {
        return Tag::create($data);
    }
}
