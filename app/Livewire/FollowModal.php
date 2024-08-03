<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FollowModal extends Component
{
    public $userId;
    public $searchFollowers = '';
    public $searchFollowing = '';

    public function mount($userId)
    {
        $this->userId = $userId;
    }

    public function render()
    {
        $user = User::find($this->userId);
        $isFollowing = null;
        if (Auth::check()) {
            $isFollowing = Follow::where('follower_id', Auth::user()->id)
                            ->where('followed_id', $user->id)
                            ->exists();
        }

        $followersQuery = $user->followers()
                    ->where(function($followersQuery) {
                        $followersQuery
                            ->where('name', 'like', '%' . $this->searchFollowers . '%')
                            ->orWhere('slug', 'like', '%' . $this->searchFollowers . '%');
                    })->orderBy('name', 'asc');

        $followingQuery = $user->following()
                    ->where(function($followingQuery) {
                        $followingQuery
                            ->where('name', 'like', '%' . $this->searchFollowing . '%')
                            ->orWhere('slug', 'like', '%' . $this->searchFollowing . '%');
                    })->orderBy('name', 'asc');

        $followers = $followersQuery->get();
        $following = $followingQuery->get();

        return view('livewire.follow-modal', [
            'followers' => $followers,
            'following' => $following,
            'isFollowing' => $isFollowing
        ]);
    }
}
