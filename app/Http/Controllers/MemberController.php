<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function showCreatePage()
    {
        return view('member.create');
    }

    public function store(Request $request)
    {

        $userId = Auth::id();

        try {
            $member = new Member();
            $member->user_id = $userId;
            $member->save();

            $user = User::findOrFail($userId);
            $user->is_member = true;
            $user->save();

            return redirect()->route('profil')->with('success', 'Registrasi member berhasil!');
        } catch (\Exception $e) {
            return redirect()->route('profil')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
