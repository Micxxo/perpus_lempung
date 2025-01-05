<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Fine;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FineController extends Controller
{
    public function showFinesPage(Request $request)
    {
        $fineSearch = $request->input('fine_search');
        $fineStatus = $request->input('fine_status');
        $fineBookStatus = $request->input('fine_book_status');

        $fines = Fine::query()
            ->whereHas('loan', function ($query) use ($fineSearch) {
                $query->whereHas('book', function ($query) use ($fineSearch) {
                    $query->where('name', 'like', "%{$fineSearch}%");
                })->orWhereHas('member', function ($query) use ($fineSearch) {
                    $query->whereHas('user', function ($query) use ($fineSearch) {
                        $query->where('username', 'like', "%{$fineSearch}%");
                    });
                });
            })->when($fineStatus, function ($query, $filter) {
                if ($filter == 'success') {
                    $query->where('is_done', 1);
                } elseif ($filter == 'proccess') {
                    $query->where('is_done', 0);
                }
            })->when($fineBookStatus, function ($query, $filter) {
                $query->where('status', $filter);
            })
            ->orderBy('created_at', 'desc')
            ->with(['loan.book', 'loan.member.user', 'creator'])
            ->paginate(15);

        $loans = Loan::with(['member.user'])
            ->where('status', '!=', 'fine')
            ->get();

        return view('fines', compact('fineSearch', 'fines', 'loans', 'fineStatus', 'fineBookStatus'));
    }

    public function store(Request $request)
    {
        $loanId = $request->input('loan_id');
        $user = Auth::user();

        $validatedData = $request->validate([
            'status' => 'required|string|in:pay_for_book,change_book,paying_fine',  //
            'date' => 'required|date',
            'is_done' => 'required|boolean',
        ]);

        try {
            $fine = new Fine();
            $fine->loan_id = $loanId;
            $fine->status = $request->status;
            $fine->date = $request->date;
            $fine->is_done = $request->is_done;
            $fine->description = $request->description;
            $fine->created_by = $user->id;
            $fine->save();

            $loan = Loan::with('book')->findOrFail($loanId);

            $loan->status = 'fine';
            $loan->save();

            $book = $loan->book;
            if ($book) {
                if ($request->status !== 'pay_for_book') {
                    $book->coppies += 1;
                    if ($book->coppies > 0) {
                        $book->status = 'available';
                    }
                    $book->save();
                }
            }

            return redirect()->back()->with('success', 'Denda berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambah denda: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $fineId)
    {

        $validatedData = $request->validate([
            'status' => 'required|string|in:pay_for_book,change_book,paying_fine',  //
            'date' => 'required|date',
            'is_done' => 'required|boolean',
        ]);

        try {
            $fine = Fine::findOrFail($fineId);

            $fine->status = $request->status;
            $fine->date = $request->date;
            $fine->is_done = $request->is_done;
            $fine->description = $request->description;

            $fine->save();

            return redirect()->route('denda')->with('success', 'Denda berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('denda')->with('error', 'Terjadi kesalahan saat memperbarui denda: ' . $e->getMessage());
        }
    }


    public function destroy($fineId)
    {

        try {
            $fine = Fine::findOrFail($fineId);
            $fine->delete();

            return redirect()->route('denda')->with('success', 'Denda berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('denda')->with('error', 'Terjadi kesalahan saat menghapus denda: ' . $e->getMessage());
        }
    }
}
