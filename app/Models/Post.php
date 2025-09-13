<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'view_count',
        'like_count',
        'user_id',
        'category_id'
    ];

    // Post belongs to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Post belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Post has many Tags (via pivot post_tag)
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id')
                    ->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // quan hệ với bảng post_likes
    public function likes(): HasMany
    {
        return $this->hasMany(PostLike::class, 'post_id');
    }
} 
