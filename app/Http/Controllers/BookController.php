<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $books = Book::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('authors', 'like', "%{$search}%");
                });
            })
            ->get();

        $message = $books->isEmpty() ? 'Buku tidak ditemukan' : 'Berhasil memuat data buku';

        return response()->json([
            'message' => $message,
            'data' => $books,
        ]);
    }
}
