<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function search(?string $q = null, int $limit = 20)
    {
        $query = Category::query()->orderBy('name');
        if ($q) {
            $query->where('name', 'LIKE', "%{$q}%");
        }
        return $query->limit($limit)->get();
    }

    public function findByName(string $name): ?Category
    {
        return Category::where('name', $name)->first();
    }

    public function create(array $data): Category
    {
        return Category::create($data);
    }
}
