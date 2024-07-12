<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $myArticles = Article::where('user_id', Auth::user()->id)->count();

        return view('pages.profile', [
            'title' => 'Blog App - My Profile',
            'active' => 'my profile',
            'user' => $user,
            'myArticles' => $myArticles
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => [
                'required',
                'max:20',
                Rule::unique('users')->ignore($id),
            ],
            'avatar' => 'image|mimes:jpg,jpeg,png,webp|max:5048',
        ], [
            'name.max' => 'Nama tidak boleh lebih dari 20 karakter.',
            'avatar.max' => 'Ukuran avatar tidak boleh lebih dari 5MB.',
        ]);
        
        $user = User::find($id);
        $user->name = $request->input('name', $user->name);
        $user->avatar = $request->input('avatar', $user->avatar);
        

        if ($request->hasFile('avatar')) {
            // Hapus file avatar lama jika ada
            if ($user->avatar) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }

            // Upload and update avatar
            $file = $request->file('avatar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/avatars', $fileName); // Menyimpan file ke folder 'storage/avatars'
            $user->avatar = $fileName;
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
        $user = User::find($id);

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
}
