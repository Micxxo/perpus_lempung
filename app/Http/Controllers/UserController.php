<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showProfilePage()
    {
        $user = Auth::user();
        return view('profil',  compact('user'));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'username' => 'nullable|string|max:255|unique:users,username,' . $id,
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'is_member' => 'nullable|boolean',
        ]);

        $user = User::findOrFail($id);

        if ($request->filled('username')) {
            $user->username = $request->username;
        }
        if ($request->filled('email')) {
            $user->email = $request->email;
        }
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        if ($request->has('is_member')) {
            $user->is_member = $request->is_member;
        }

        // Simpan perubahan
        $user->save();

        return redirect()->route('profil')->with('success', 'Data user berhasil diperbarui.');
    }
}
