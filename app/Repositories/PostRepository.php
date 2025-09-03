<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    public function getAll()
    {
        return Post::all();
    }

    public function findById($id)
    {
        return Post::findOrFail($id);
    }

    public function create(array $data)
    {
        return Post::create($data);
    }

    public function update($id, array $data)
    {
        $post = Post::findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        return $post->delete();
    }
}
