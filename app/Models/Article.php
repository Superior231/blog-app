<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category',
        'title',
        'slug',
        'thumbnail',
        'body'
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function like_articles()
    {
        return $this->hasMany(LikeArticle::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function whitelists()
    {
        return $this->hasMany(Whitelist::class);
    }
}
