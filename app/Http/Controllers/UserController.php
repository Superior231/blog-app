<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\CommentReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $user_total = User::where('roles', 'user')->count();
        $admin_total = User::where('roles', 'admin')->count();
        $user_approved = User::where('status', 'Approved')->count();
        $user_banned = User::where('status', 'Banned')->count();
        $report_count = CommentReport::all()->count();

        return view('pages.users.index', [
            'title' => 'Blog App - Users',
            'active' => 'users',
            'users' => $users,
            'user_total' => $user_total,
            'admin_total' => $admin_total,
            'user_approved' => $user_approved,
            'user_banned' => $user_banned,
            'report_count' => $report_count
        ]);
    }

    /**
     * Generate unique slug user{random_string}
     */
    private function generateUniqueSlug()
    {
        do {
            $randomString = Str::lower(Str::random(10));
            $slug = 'user' . $randomString;
        } while (User::where('slug', $slug)->exists());
        
        return $slug;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'avatar' => 'image|mimes:jpg,jpeg,png,webp|max:5048',
            'roles' => 'required|string|in:admin,user',
        ], [
            'email.unique' => 'Email already exists!',
            'name.max' => 'Name cannot be more than 30 characters.',
            'avatar.max' => 'Avatar size cannot be more than 5MB.',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        // Generate username random (unique)
        $slug = $this->generateUniqueSlug();
        $validatedData['slug'] = $slug;

        $user = User::create($validatedData);

        if ($user) {
            return redirect()->route('users.index')->with('success', 'User created successfully!');
        } else {
            return redirect()->route('users.index')->with('error', 'Failed to create user!');
        }
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        $request->validate([
            'email' => [
                'required',
                Rule::unique('users')->ignore($id),
            ],
            'name' => [
                'required',
                'max:30',
            ],
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
            'email.unique' => 'Email salready exists.',
            'name.max' => 'Name cannot be more than 30 characters.',
            'avatar.max' => 'Avatar size cannot be more than 5MB.',
            'slug.min' => 'Username must be at least 5 characters.',
            'slug.max' => 'Username cannot be more than 30 characters.',
            'slug.regex' => 'Username can only contain lowercase letters, numbers, underscores, and dashes.',
            'slug.unique' => 'Username already exists.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.max' => 'Password cannot be more than 255 characters.',
        ]);


        if ($request->input('slug') !== $user->slug) {
            if ($user->slug_changed == true) {
                return redirect()->route('users.index')->with('error', 'You can only change your username once!');
            }
            $user->slug = $request->input('slug');
            $user->slug_changed = true;
        }
        
        $user->name = $request->input('name', $user->name);
        $user->email = $request->input('email', $user->email);
        $user->roles = $request->input('roles', $user->roles);
        $user->avatar = $request->input('avatar', $user->avatar);
        $user->gender = $request->input('gender', $user->gender);
        $user->description = $request->input('description', $user->description);
        $user->facebook = $request->input('facebook', $user->facebook);
        $user->twitter = $request->input('twitter', $user->twitter);
        $user->instagram = $request->input('instagram', $user->instagram);
        $user->status = $request->input('status', $user->status);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

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
            return redirect()->route('users.index')->with('success', 'User updated successfully!');
        } else {
            return redirect()->route('users.index')->with('error', 'Failed to updated user!');
        }
    }

    public function destroy(string $id)
    {
        $user = User::find($id);

        // Hapus avatar
        if ($user->avatar) {
            Storage::delete('public/avatars/' . $user->avatar);
        }

        $user->delete();

        if ($user) {
            return redirect()->route('users.index')->with('success', 'User deleted successfully!');
        } else {
            return redirect()->route('users.index')->with('error', 'Failed to delete user!');
        }
    }
}
