<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Models\Category;

class CategoryService
{
    public function __construct(
        protected CategoryRepository $categories
    ) {}

    public function getCategories(?string $search = null, int $limit = 20)
    {
        return $this->categories->search($search, $limit);
    }

    public function createIfNotExists(string $name, ?string $description = null): Category
    {
        if ($existing = $this->categories->findByName($name)) {
            return $existing;
        }
        return $this->categories->create([
            'name' => $name,
            'description' => $description,
        ]);
    }
}
