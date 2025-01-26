<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitController;
use App\Mail\MailBookReturnReminder;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
    Route::put('/profil', [UserController::class, 'update'])->name('profil.update');
    Route::post('/profil', [MemberController::class, 'store'])->name('member.store');

    Route::get('/member/daftar', [MemberController::class, 'showCreatePage'])->name('member');


    Route::get('/peminjaman', [LoanController::class, 'showLoanPage'])->name('peminjaman');
    Route::post('/peminjaman', [LoanController::class, 'store'])->name('peminjaman.store');
    Route::post('/peminjaman/denda', [FineController::class, 'store'])->name('peminjaman.createFine');
    Route::delete('/peminjaman', [LoanController::class, 'destroy'])->name('peminjaman.destroy');
    Route::put('/peminjaman', [LoanController::class, 'update'])->name('peminjaman.update');

    Route::get('/kunjungan', [VisitController::class, 'showVisitsPage'])->name('kunjungan');
    Route::post('/kunjungan', [VisitController::class, 'store'])->name('kunjungan.store');
    Route::put('/kunjungan', [VisitController::class, 'update'])->name('kunjungan.update');
    Route::delete('/kunjungan/{id}', [VisitController::class, 'destroy'])->name('kunjungan.destroy');

    Route::get('/denda', [FineController::class, 'showFinesPage'])->name('denda');
    Route::post('/denda', [FineController::class, 'store'])->name('denda.store');
    Route::put('/denda/{id}', [FineController::class, 'update'])->name('denda.update');
    Route::delete('/denda/{id}', [FineController::class, 'destroy'])->name('denda.destroy');

    Route::get('/pengguna', [UserController::class, 'showUserPage'])->name('pengguna');
    Route::post('/pengguna', [UserController::class, 'registerMember'])->name('pengguna.registerMember');
    Route::post('/pengguna/pengurus', [UserController::class, 'registerUser'])->name('pengguna.registerUser');
    Route::delete('/pengguna/{id}', [UserController::class, 'destroy'])->name('pengguna.destroy');

    Route::get('/laporan', [ReportController::class, 'showReportPage'])->name('laporan');
    Route::delete('/laporan/{id}', [ReportController::class, 'destroy'])->name('laporan.destroy');
    Route::put('/laporan/{id}', [ReportController::class, 'update'])->name('laporan.update');
    Route::get('/laporan/detail/{id}', [ReportController::class, 'showDetailPage'])->name('laporan.detail');
    Route::post('/laporan', [ReportController::class, 'store'])->name('laporan.store');
    Route::get('/laporan/cetak/{id}', [ReportController::class, 'generateReportPDF'])->name('laporan.generate');

    Route::post('/invoice/store/{fine}', [InvoiceController::class, 'store'])->name('invoice.store');
    Route::get('/invoice/cetak/{invoice}', [InvoiceController::class, 'generateInvoicePDF'])->name('invoice.generate');
});
