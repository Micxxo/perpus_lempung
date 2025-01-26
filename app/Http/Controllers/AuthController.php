<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginPage()
    {
        return view('login');
    }

    public function showRegisterPage()
    {
        return view('register');
    }



    function registerMember(Request $request)
    {

        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);


        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role_id = 1;
        $user->is_member = 0;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('login')->with('email', $request->email)->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role_id === 3) {
                return redirect()->route('pengguna')->with('success', 'Login berhasil!');
            }

            return redirect()->route('buku')->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }
}
