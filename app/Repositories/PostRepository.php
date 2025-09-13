<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Auth;


use App\Models\Post;

class PostRepository
{
    public function getAll($perPage = 10)
    {
        return Post::with(['category', 'tags', 'user'])
            ->withCount('comments', 'likes') // chỉ trả về số lượng
            ->when(Auth::check(), function ($query) {
                $query->withExists(['likes as is_liked' => function ($q) {
                    $q->where('user_id', Auth::id());
                }]);
            })
            ->latest()
            ->paginate($perPage);
    }

    public function findById($id, $limit = 3)
    {
        return Post::with([ 'category', 
                            'tags',
                            'user', 
                            'comments' => function ($query) use ($limit) {
                                $query->latest()->take($limit)->with('user');
                             }])
                            ->findOrFail($id);
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


    //Lấy bài viết chưa đọc cho newsfeed

    public function getUnreadPosts(array $excludeIds, $perPage = 10)
    {
        return Post::with(['category', 'tags', 'user'])
            ->when(!empty($excludeIds), function ($query) use ($excludeIds) {
                $query->whereNotIn('id', $excludeIds);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    
    //Lấy bài viết của user (profile)
    public function getUserPosts($userId, $perPage = 10)
    {
        return Post::with(['category', 'tags', 'user'])
            ->where('user_id', $userId)
            ->withCount('comments')
            ->latest()
            ->paginate($perPage);
    }
}
