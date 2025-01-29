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

    public function showUserPage(Request $request)
    {
        $userSearch = $request->input('students_search');
        $memberFilter = $request->input('member_filter');

        $managerSearch = $request->input('managers_search');
        $supervisorSearch = $request->input('supervisors_search');
        $userId = Auth::id();

        $students = User::where('role_id', 1)
            ->where('id', '!=', $userId)
            ->when($userSearch, function ($query, $search) {
                $query->where('username', 'LIKE', "%{$search}%");
            })
            ->when($memberFilter, function ($query, $filter) {
                if ($filter == 'member') {
                    $query->where('is_member', 1);
                } elseif ($filter == 'not_member') {
                    $query->where('is_member', 0);
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $managers = User::where('role_id', 2)
            ->where('id', '!=', $userId)
            ->when($managerSearch, function ($query, $search) {
                $query->where('username', 'LIKE', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $supervisors = User::where('role_id', 3)
            ->where('id', '!=', $userId)
            ->when($supervisorSearch, function ($query, $search) {
                $query->where('username', 'LIKE', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $user = Auth::user();

        return view('users', compact('user', 'userSearch', 'managerSearch', 'students', 'managers', 'supervisors', 'supervisorSearch', 'memberFilter'));
    }

    function registerMember(Request $request)
    {

        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'nisn' => 'required|string|max:255|unique:users,nisn',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);


        $user = new User();
        $user->username = $request->username;
        $user->nisn = $request->nisn;
        $user->email = $request->email;
        $user->role_id = 1;
        $user->is_member = 0;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Registrasi siswa berhasil.');
    }


    function registerUser(Request $request)
    {

        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'nisn' => 'nullable|string|max:255|unique:users,nisn',
            'role' => 'required|integer',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = new User();

        if ($request->nisn) {
            $user->nisn = $request->nisn;
        }

        $user->username = $request->username;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->is_member = 0;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Registrasi pengguna berhasil.');
    }


    public function update(Request $request)
    {
        $userId = Auth::id();

        $validated = $request->validate([
            'username' => "nullable|string|max:255|unique:users,username,{$userId}",
            'nisn' => "nullable|string|max:255|unique:users,nisn,{$userId}",
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:8|confirmed',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = User::findOrFail($userId);

        if ($request->hasFile('profile')) {
            $imagePath = $request->file('profile')->store('users', 'public');
            $user->profile = $imagePath;
        }

        if ($request->filled('username')) {
            $user->username = $request->username;
        }

        if ($request->filled('nisn')) {
            $user->nisn = $request->nisn;
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

        if ($request->has('role_id')) {
            $user->role_id = $request->role_id;
        }

        $user->save();

        return redirect()->route('profil')->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $user->delete();

            return redirect()->route('pengguna')->with('success', 'Pengguna berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('pengguna')->with('error', 'Terjadi kesalahan saat menghapus pengguna: ' . $e->getMessage());
        }
    }
}
