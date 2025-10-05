<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'slug_changed',
        'email',
        'avatar',
        'avatar_google',
        'banner',
        'roles',
        'gender',
        'description',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'linkedin',
        'github',
        'password',
        'status',
    ];

    protected $casts = [
        'slug_changed' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function commentReports()
    {
        return $this->hasMany(CommentReport::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
    }

    public function whitelists()
    {
        return $this->hasMany(Whitelist::class);
    }
}
