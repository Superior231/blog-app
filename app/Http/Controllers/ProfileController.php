<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $articles = Article::where('user_id', $user->id)->paginate(10);

        return view('pages.profile.index', [
            'title' => 'Blog App - My Profile',
            'active' => 'my profile',
            'user' => $user,
            'articles' => $articles
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
        $user = User::find($id);
        
        $request->validate([
            'name' => 'required|max:30',
            'avatar' => 'image|mimes:jpg,jpeg,png,webp|max:5048',
            'slug' => [
                'required',
                'string',
                'min:5',
                'max:30',
                'regex:/^[a-z0-9_-]+$/', // lowercase, number, underscore, and dash
                Rule::unique('users')->ignore($id),
            ],
            'password' => 'nullable|min:8|max:255',
        ], [
            'name.max' => 'Name cannot be more than 30 characters.',
            'avatar.max' => 'Avatar size cannot be more than 5MB.',
            'slug.min' => 'Username must be at least 5 characters.',
            'slug.max' => 'Username cannot be more than 30 characters.',
            'slug.regex' => 'Username can only contain lowercase letters, numbers, underscores, and dashes.',
            'slug.unique' => 'Username already exists.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.max' => 'Password cannot be more than 255 characters.',
        ]);

        // Cek apakah pengguna yang terautentikasi adalah pemilik dari data yang ingin diperbarui
        if (Auth::id() !== (int) $id) {
            return redirect()->route('profile.index')->with('error', 'Oops... Something went wrong!');
        }
    
        if (!$user) {
            return redirect()->route('profile.index')->with('error', 'User not found!');
        }


        if ($request->input('slug') !== $user->slug) {
            if ($user->slug_changed == true) {
                return redirect()->route('profile.index')->with('error', 'You can only change your username once!');
            }
            $user->slug = $request->input('slug');
            $user->slug_changed = true;
        }
        
        $user->name = $request->input('name', $user->name);
        $user->gender = $request->input('gender', $user->gender);
        $user->description = $request->input('description', $user->description);
        $user->facebook = $request->input('facebook', $user->facebook);
        $user->twitter = $request->input('twitter', $user->twitter);
        $user->instagram = $request->input('instagram', $user->instagram);
        $user->youtube = $request->input('youtube', $user->youtube);
        $user->linkedin = $request->input('linkedin', $user->linkedin);
        $user->github = $request->input('github', $user->github);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        
        // Avatar
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists('avatars/' . $user->avatar)) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }
        
            $file = $request->file('avatar');
            $fileName = time() . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
            $image = Image::make($file)->resize(1200, 1200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('webp', 80);
            
            Storage::disk('public')->put('avatars/' . $fileName, (string) $image);
            $user->avatar = $fileName;
        }

        // Banner
        if ($request->hasFile('banner')) {
            if ($user->banner && Storage::disk('public')->exists('banners/' . $user->banner)) {
                Storage::disk('public')->delete('banners/' . $user->banner);
            }
        
            $file = $request->file('banner');
            $fileName = time() . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
            $image = Image::make($file)->resize(1200, 1200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('webp', 80);
            
            Storage::disk('public')->put('banners/' . $fileName, (string) $image);
            $user->banner = $fileName;
        }
        
        $user->save();

        if ($user) {
            return redirect()->route('profile.index')->with('success', 'Profile updated successfully!');
        } else {
            return redirect()->route('profile.index')->with('error', 'Failed to update profile!');
        }
    }

    public function deleteAvatar($id)
    {
        // Cek apakah pengguna yang terautentikasi adalah pemilik dari data yang ingin diperbarui
        if (Auth::id() !== (int) $id) {
            return redirect()->route('profile.index')->with('error', 'Oops... Something went wrong!');
        }
    
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('profile.index')->with('error', 'User not found!');
        }

        // Hapus file avatar jika ada
        if (!empty($user->avatar)) {
            Storage::delete('public/avatars/' . $user->avatar);
            $user->avatar = null;
        }

        $user->save();

        if ($user) {
            return redirect()->route('profile.index')->with('success', 'Avatar deleted successfully!');
        } else {
            return redirect()->route('profile.index')->with('error', 'Failed to delete avatar!');
        }
    }

    public function deleteBanner($id)
    {
        // Cek apakah pengguna yang terautentikasi adalah pemilik dari data yang ingin diperbarui
        if (Auth::id() !== (int) $id) {
            return redirect()->route('profile.index')->with('error', 'Oops... Something went wrong!');
        }
    
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('profile.index')->with('error', 'User not found!');
        }

        // Hapus file banner jika ada
        if (!empty($user->banner)) {
            Storage::delete('public/banners/' . $user->banner);
            $user->banner = null;
        }

        $user->save();

        if ($user) {
            return redirect()->route('profile.index')->with('success', 'Banner deleted successfully!');
        } else {
            return redirect()->route('profile.index')->with('error', 'Failed to delete banner!');
        }
    }

    public function profileArticle()
    {
        $user = Auth::user();
        $articles = Article::where('user_id', $user->id)->paginate(9);

        return view('pages.profile.article', [
            'title' => 'Blog App - My Profile Articles',
            'active' => 'my profile',
            'articles' => $articles,
            'user' => $user
        ]);
    }

    public function author($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $author_name = $user->name;
        $description = Str::limit(strip_tags($user->description ?? 'No description yet.'), 150);
        $avatar = $user->avatar_google
                        ?? asset('storage/avatars/' . $user->avatar)
                        ?? "https://ui-avatars.com/api/?background=random&name=" . urlencode($user->name);

        $articles = Article::where('user_id', $user->id)->paginate(10);

        // Cek apakah user sudah login atau belum
        $isFollowing = null;
        if (Auth::check()) {
            $isFollowing = Follow::where('follower_id', Auth::user()->id)
                                ->where('followed_id', $user->id)
                                ->exists();
        }

        return view('pages.profile.index', [
            'title' => $user->name . ' (@' . $user->slug . ') - Profile',
            'active' => 'author',
            'user' => $user,
            'isFollowing' => $isFollowing,
            'description' => $description,
            'author_name' => $author_name,
            'avatar' => $avatar,
            'articles' => $articles
        ]);
    }

    public function authorArticle($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $author_name = $user->name;
        $description = Str::limit(strip_tags($user->description ?? 'No description yet.'), 150);
        $avatar = $user->avatar_google
                        ?? asset('storage/avatars/' . $user->avatar)
                        ?? "https://ui-avatars.com/api/?background=random&name=" . urlencode($user->name);

        return view('pages.profile.article', [
            'title' => $user->name . ' (@' . $user->slug . ') - Articles',
            'active' => 'author',
            'user' => $user,
            'description' => $description,
            'author_name' => $author_name,
            'avatar' => $avatar
        ]);
    }
}
