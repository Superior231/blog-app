<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeArticle extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'article_id', 'user_id', 'like'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
