<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    // GET /api/categories?search=abc&limit=20
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:50',
            'limit'  => 'nullable|integer|min:1|max:100',
        ]);

        $items = $this->categoryService->getCategories(
            search: $request->get('search'),
            limit: (int)($request->get('limit', 20))
        );

        return response()->json($items);
    }

    // POST /api/categories
    // body: { "name": "ReactJS", "description": "..." }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:50|unique:categories,name',
            'description' => 'nullable|string|max:255',
        ]);

        $category = $this->categoryService->createIfNotExists(
            $validated['name'],
            $validated['description'] ?? null
        );

        return response()->json($category, 201);
    }
}
