<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $user_total = User::where('roles', 'user')->count();
        $admin_total = User::where('roles', 'admin')->count();

        return view('pages.users.index', [
            'title' => 'Blog App - Users',
            'active' => 'users',
            'users' => $users,
            'user_total' => $user_total,
            'admin_total' => $admin_total
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'avatar' => 'image|mimes:jpg,jpeg,png,webp|max:5048',
            'roles' => 'required|string|in:admin,user',
        ], [
            'email.unique' => 'Email sudah digunakan!.',
            'name.max' => 'Nama tidak boleh lebih dari 20 karakter.',
            'avatar.max' => 'Ukuran avatar tidak boleh lebih dari 5MB.',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);

        if ($user) {
            return redirect()->route('users.index')->with('success', 'User berhasil dibuat!');
        } else {
            return redirect()->route('users.index')->with('error', 'User gagal dibuat!');
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'email' => [
                'required',
                Rule::unique('users')->ignore($id),
            ],
            'name' => [
                'required',
                'max:20',
                Rule::unique('users')->ignore($id),
            ],
            'avatar' => 'image|mimes:jpg,jpeg,png,webp|max:5048',
        ], [
            'email.unique' => 'Email sudah digunakan!.',
            'name.max' => 'Nama tidak boleh lebih dari 20 karakter.',
            'avatar.max' => 'Ukuran avatar tidak boleh lebih dari 5MB.',
        ]);
        
        $user = User::find($id);
        $user->name = $request->input('name', $user->name);
        $user->email = $request->input('email', $user->email);
        $user->roles = $request->input('roles', $user->roles);
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
            return redirect()->route('users.index')->with('success', 'User berhasil diedit!');
        } else {
            return redirect()->route('users.index')->with('error', 'User gagal diedit!');
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
            return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
        } else {
            return redirect()->route('users.index')->with('error', 'User gagal dihapus!');
        }
    }
}
