<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow(Request $request)
    {
        $followerId = Auth::user()->id;
        $followingId = $request->followed_id;

        // Cek apakah pengguna sudah mengikuti pengguna lain
        if (!Follow::where('follower_id', $followerId)->where('followed_id', $followingId)->first()) {
            Follow::create([
                'follower_id' => $followerId,
                'followed_id' => $followingId,
            ]);
            return redirect()->back()->with('success', 'Anda berhasil follow!');
        }

        return redirect()->back()->with('error', 'Anda sudah mengikuti pengguna ini!');
    }

    public function unfollow($id)
    {
        $followerId = Auth::user()->id;
        $followingId = $id;

        // Cek apakah pengguna mengikuti pengguna lain
        $follow = Follow::where('follower_id', $followerId)->where('followed_id', $followingId)->first();

        if ($follow) {
            $follow->delete();
            return redirect()->back()->with('success', 'Anda berhasil unfollow!');
        }

        return redirect()->back()->with('error', 'Anda belum mengikuti pengguna ini!');
    }

    public function removeFollower($id)
    {
        $followerId = $id; // ID pengikut yang ingin dihapus
        $userId = Auth::user()->id; // ID pengguna yang ingin menghapus pengikutnya

        // Cek apakah pengguna mengikut pengikut tertentu
        $follow = Follow::where('follower_id', $followerId)->where('followed_id', $userId)->first();

        if ($follow) {
            $follow->delete();
            return redirect()->back()->with('success', 'Follower berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Follower tidak ditemukan!');
    }
}
