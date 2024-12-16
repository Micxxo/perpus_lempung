<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/books', [BookController::class, 'index'])->name('book.index');

Route::get('/', function () {
    return view('landing');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('auth.login');


Route::get('/register', function () {
    return view('register');
});

Route::post('/register', [AuthController::class, 'registerMember'])->name('auth.registerMember');

Route::get('/buku', function () {
    return view('book');
})->name('buku');

Route::get('/peminjaman', function () {
    return view('loan');
})->name('peminjaman');
