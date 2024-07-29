<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_id',
        'user_id',
        'article_id',
        'body',
    ];

    public function childrens()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentReports() {
        return $this->hasMany(CommentReport::class);
    }

    public function likeComments()
    {
        return $this->hasMany(LikeComment::class)->where('like', true)->count();
    }

    public function dislikeComments()
    {
        return $this->hasMany(LikeComment::class)->where('dislike', true)->count();
    }

    public function liked()
    {
        return LikeComment::where('comment_id', $this->id)->where('user_id', Auth::user()->id)->where('like', true)->exists();
    }

    public function disliked()
    {
        return LikeComment::where('comment_id', $this->id)->where('user_id', Auth::user()->id)->where('dislike', true)->exists();
    }
}
