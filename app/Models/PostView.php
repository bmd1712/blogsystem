<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostView extends Model
{
    protected $fillable = ['user_id', 'posts_id', 'isRead'];

    public function post()
    {
        return $this->belongsTo(Post::class, 'posts_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}