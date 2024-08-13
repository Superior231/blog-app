<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $myArticles = Article::where('user_id', Auth::user()->id)->count();

        return view('pages.profile.profile', [
            'title' => 'Blog App - My Profile',
            'active' => 'my profile',
            'nav_tab_active' => 'profile',
            'user' => $user,
            'myArticles' => $myArticles
        ]);
    }

    public function edit($slug)
    {
        $user = User::where('slug', $slug)->first();

        return view('pages.profile.edit', [
            'title' => 'Blog App - Edit Profile',
            'active' => 'my profile',
            'user' => $user
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:20',
            'avatar' => 'image|mimes:jpg,jpeg,png,webp|max:5048',
        ], [
            'name.max' => 'Nama tidak boleh lebih dari 20 karakter.',
            'avatar.max' => 'Ukuran avatar tidak boleh lebih dari 5MB.',
        ]);

        // Cek apakah pengguna yang terautentikasi adalah pemilik dari data yang ingin diperbarui
        if (Auth::id() !== (int) $id) {
            return redirect()->route('profile.index')->with('error', 'Oops... Terjadi kesalahan!');
        }
    
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('profile.index')->with('error', 'Pengguna tidak ditemukan!');
        }


        $user->name = $request->input('name', $user->name);
        $user->gender = $request->input('gender', $user->gender);
        $user->description = $request->input('description', $user->description);
        $user->facebook = $request->input('facebook', $user->facebook);
        $user->twitter = $request->input('twitter', $user->twitter);
        $user->instagram = $request->input('instagram', $user->instagram);
        
        // Avatar
        if ($request->hasFile('avatar')) {
            // Hapus file avatar lama jika ada
            if ($user->avatar) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }

            // Upload and update avatar
            $file = $request->file('avatar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/avatars', $fileName);
            $user->avatar = $fileName;
        }

        // Banner
        if ($request->hasFile('banner')) {
            // Hapus file banner lama jika ada
            if ($user->banner) {
                Storage::disk('public')->delete('banners/' . $user->banner);
            }

            // Upload and update banner
            $file = $request->file('banner');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/banners', $fileName);
            $user->banner = $fileName;
        }
        
        $user->save();

        if ($user) {
            return redirect()->route('profile.index')->with('success', 'Akun berhasil diedit!');
        } else {
            return redirect()->route('profile.index')->with('error', 'Akun gagal diedit!');
        }
    }

    public function deleteAvatar($id)
    {
        // Cek apakah pengguna yang terautentikasi adalah pemilik dari data yang ingin diperbarui
        if (Auth::id() !== (int) $id) {
            return redirect()->route('profile.index')->with('error', 'Oops... Terjadi kesalahan!');
        }
    
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('profile.index')->with('error', 'Pengguna tidak ditemukan!');
        }

        // Hapus file avatar jika ada
        if (!empty($user->avatar)) {
            Storage::delete('public/avatars/' . $user->avatar);
            $user->avatar = null;
        }

        $user->save();

        if ($user) {
            return redirect()->route('profile.index')->with('success', 'Avatar berhasil dihapus!');
        } else {
            return redirect()->route('profile.index')->with('error', 'Avatar gagal dihapus!');
        }
    }

    public function deleteBanner($id)
    {
        // Cek apakah pengguna yang terautentikasi adalah pemilik dari data yang ingin diperbarui
        if (Auth::id() !== (int) $id) {
            return redirect()->route('profile.index')->with('error', 'Oops... Terjadi kesalahan!');
        }
    
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('profile.index')->with('error', 'Pengguna tidak ditemukan!');
        }

        // Hapus file banner jika ada
        if (!empty($user->banner)) {
            Storage::delete('public/banners/' . $user->banner);
            $user->banner = null;
        }

        $user->save();

        if ($user) {
            return redirect()->route('profile.index')->with('success', 'Banner berhasil dihapus!');
        } else {
            return redirect()->route('profile.index')->with('error', 'Banner gagal dihapus!');
        }
    }

    public function profileArticle()
    {
        $user = Auth::user();
        $articles = Article::where('user_id', $user->id)->paginate(9);

        return view('pages.profile.article', [
            'title' => 'Blog App - My Profile Articles',
            'active' => 'my profile',
            'nav_tab_active' => 'article',
            'articles' => $articles,
            'user' => $user
        ]);
    }

    public function author($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();

        // Cek apakah user sudah login atau belum
        $isFollowing = null;
        if (Auth::check()) {
            $isFollowing = Follow::where('follower_id', Auth::user()->id)
                                ->where('followed_id', $user->id)
                                ->exists();
        }

        return view('pages.profile.profile', [
            'title' => $user->name . ' (@' . $user->slug . ') - Profile',
            'active' => 'author',
            'nav_tab_active' => 'profile',
            'user' => $user,
            'isFollowing' => $isFollowing
        ]);
    }

    public function authorArticle($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();

        return view('pages.profile.article', [
            'title' => $user->name . ' (@' . $user->slug . ') - Article',
            'active' => 'author',
            'nav_tab_active' => 'article',
            'user' => $user
        ]);
    }
}
