<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function showBooksPage()
    {
        return view('book');
    }


    public function getAllJson(Request $request)
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

    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $books = Book::query()
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('authors', 'like', '%' . $search . '%');
                });
            })
            ->paginate(10);

        return view('book', compact('books', 'search', 'status'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|integer|digits:4',
            'authors' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'coppies' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $status = $validatedData['coppies'] > 0 ? 'available' : 'out-stock';

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
        }


        try {
            $book = new Book();
            $book->name = $request->name;
            $book->year = $request->year;
            $book->authors = $request->authors;
            $book->genre = $request->genre;
            $book->coppies = $request->coppies;
            $book->description = $request->description;
            $book->image = $imagePath;
            $book->status = $status;
            $book->save();

            return redirect()->route('buku')->with('success', 'Buku berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('buku')->with('error', 'Terjadi kesalahan saat menambahkan buku: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $book = Book::findOrFail($id);

            if ($book->image && file_exists(public_path('storage/' . $book->image))) {
                unlink(public_path('storage/' . $book->image));
            }

            $book->delete();

            return redirect()->route('buku')->with('success', 'Buku berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('buku')->with('error', 'Terjadi kesalahan saat menghapus buku: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|integer|digits:4',
            'authors' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'coppies' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $book = Book::findOrFail($id);

            if ($request->hasFile('image')) {
                if ($book->image && file_exists(public_path('storage/' . $book->image))) {
                    unlink(public_path('storage/' . $book->image));
                }

                $book->image = $request->file('image')->store('books', 'public');
            }

            $book->name = $request->name;
            $book->year = $request->year;
            $book->authors = $request->authors;
            $book->genre = $request->genre;
            $book->coppies = $request->coppies;
            $book->description = $request->description;
            $book->status = $request->coppies > 0 ? 'available' : 'out-stock';

            $book->save();

            return redirect()->route('buku')->with('success', 'Buku berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('buku')->with('error', 'Terjadi kesalahan saat memperbarui buku: ' . $e->getMessage());
        }
    }
}
