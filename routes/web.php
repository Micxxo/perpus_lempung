<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// REST API
Route::get('/books', [BookController::class, 'getAllJson'])->name('book.getAllJson');

Route::get('/', function () {
    return view('landing');
});

// AUTH 
Route::get('/login', [AuthController::class, 'showLoginPage'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/register', [AuthController::class, 'showRegisterPage'])->name('register');
Route::post('/register', [AuthController::class, 'registerMember'])->name('auth.registerMember');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware('auth')->group(function () {

    Route::get('/buku', [BookController::class, 'index'])->name('buku');
    Route::post('/buku', [BookController::class, 'store'])->name('buku.store');
    Route::delete('/buku/{id}', [BookController::class, 'destroy'])->name('buku.destroy');
    Route::put('/buku/{id}', [BookController::class, 'update'])->name('buku.update');

    Route::get('/profil', [UserController::class, 'showProfilePage'])->name('profil');
    Route::post('/profil', [MemberController::class, 'store'])->name('member.store');

    Route::get('/member/daftar', [MemberController::class, 'showCreatePage'])->name('member');


    Route::get('/peminjaman', function () {
        return view('loan');
    })->name('peminjaman');
});
