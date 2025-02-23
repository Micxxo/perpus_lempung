<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{
    public function showVerifyPage()
    {
        return view('emails.verify-email');
    }

    public function emailVerificationVerify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        $user = Auth::user();
        if ($user->role_id == 3) {
            return redirect('/pengguna');
        }

        return redirect('/buku');
    }

    public function resendEmail(Request $request)
    {
        if (!$request->user()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($request->user()->hasVerifiedEmail()) {
            return back()->with('error', 'Email sudah terverifikasi.');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Link Verfikasi Berhasil di Kirim!');
    }
}
