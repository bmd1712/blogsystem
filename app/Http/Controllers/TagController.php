<?php

namespace App\Http\Controllers;

use App\Services\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __construct(
        protected TagService $tagService
    ) {}

    // GET /api/tags?search=abc&limit=20
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:50',
            'limit'  => 'nullable|integer|min:1|max:100',
        ]);

        $items = $this->tagService->getTags(
            search: $request->get('search'),
            limit: (int)($request->get('limit', 20))
        );

        return response()->json($items);
    }

    // POST /api/tags
    // body: { "tag": "Laravel" }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tag' => 'required|string|max:50|unique:tags,tag',
        ]);

        $tag = $this->tagService->createIfNotExists($validated['tag']);

        return response()->json($tag, 201);
    }
}
