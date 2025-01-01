<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Fine;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function showLoanPage(Request $request)
    {
        $bookTitleSearch = $request->input('book_title_search');
        $loanStatus = $request->input('loanStatus');
        $loanCreatedAt = $request->input('loan_created_at');

        $user = Auth::user();
        $relatedMember = Member::where('user_id', $user->id)->first();

        if ($user->role_id === 1 && !$relatedMember) {
            return view('loan', [
                'loans' => [],
                'bookTitleSearch' => $bookTitleSearch,
                'loanStatus' => $loanStatus,
                'loanCreatedAt' => $loanCreatedAt,
                'firstLoan' => null,
                'books' => [],
                'members' => []
            ]);
        }

        $loans = Loan::query()
            ->with(['book', 'member.user'])
            ->when($bookTitleSearch, function ($query) use ($bookTitleSearch) {
                return $query->whereHas('book', function ($q) use ($bookTitleSearch) {
                    $q->where('name', 'like', '%' . $bookTitleSearch . '%');  // Search by book title
                });
            })
            ->when($loanStatus, function ($query) use ($loanStatus) {
                return $query->where('status', $loanStatus);  // Filter by loan status
            })
            ->when($loanCreatedAt, function ($query) use ($loanCreatedAt) {
                return $query->whereDate('created_at', $loanCreatedAt);  // Filter by loanCreatedAt
            })->when($user->role_id === 1, function ($query) use ($relatedMember) {
                return $query->where('member_id', $relatedMember->id);
            })
            ->paginate(5);

        $firstLoan = Loan::query()
            ->with(['book', 'member.user'])
            ->when($bookTitleSearch, function ($query) use ($bookTitleSearch) {
                return $query->whereHas('book', function ($q) use ($bookTitleSearch) {
                    $q->where('name', 'like', '%' . $bookTitleSearch . '%');
                });
            })
            ->when($loanStatus, function ($query) use ($loanStatus) {
                return $query->where('status', $loanStatus);
            })
            ->when($loanCreatedAt, function ($query) use ($loanCreatedAt) {
                return $query->whereDate('created_at', $loanCreatedAt);
            })->when($user->role_id === 1, function ($query) use ($relatedMember) {
                return $query->where('member_id', $relatedMember->id);
            })
            ->first();

        $books = Book::where('status', '!=', 'out-stock')->get();

        $members = Member::with(['user:id,username'])->get();


        return view('loan',  compact('loans', 'bookTitleSearch', 'loanStatus', 'loanCreatedAt', 'firstLoan', 'books', 'members'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'loan_book_name' => 'required|integer',
            'loan_member' => 'required|integer',
            'borrowing_date' => 'required|date',
            'returning_date' => 'required|date',
        ]);

        try {
            $loan = new Loan();
            $loan->book_id = $request->loan_book_name;
            $loan->member_id = $request->loan_member;
            $loan->return_date = $request->returning_date;
            $loan->created_at = $request->borrowing_date;
            $loan->description = $request->loan_description;
            $loan->save();

            // Update book stock
            $book = Book::find($request->loan_book_name);
            if ($book && $book->coppies > 0) {
                $book->coppies -= 1;
                if ($book->coppies == 0) {
                    $book->status = 'out-stock';
                }
                $book->save();
            }

            return redirect()->route('peminjaman')->with('success', 'Peminjaman berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('peminjaman')->with('error', 'Terjadi kesalahan saat menambahkan peminjaman: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $loanId = $request->input('loan_id');

        $validatedData = $request->validate([
            'loan_book_name' => 'required|integer',
            'loan_member' => 'required|integer',
            'loan_status' => 'required|string|max:255',
            'borrowing_date' => 'required|date',
            'returning_date' => 'required|date',
        ]);

        try {
            $loan = Loan::findOrFail($loanId);

            $previousStatus = $loan->status;

            $loan->book_id = $request->loan_book_name;
            $loan->member_id = $request->loan_member;
            $loan->status = $request->loan_status;
            $loan->return_date = $request->returning_date;
            $loan->created_at = $request->borrowing_date;
            $loan->description = $request->loan_description;

            $loan->save();

            // Update book coppies
            $book = Book::find($request->loan_book_name);
            if ($book) {
                // Jika status sebelumnya adalah 'returned' dan status saat ini 'returned'
                if ($previousStatus === 'returned' && $request->loan_status === 'returned') {
                }

                // Jika status sebelumnya adalah 'returned' dan status saat ini bukan 'returned'
                elseif ($previousStatus === 'returned' && $request->loan_status !== 'returned') {
                    $book->coppies -= 1;  // Mengurangi stok
                    if ($book->coppies == 0) {
                        $book->status = 'out-stock';
                    }
                    $book->save();
                }

                // Jika status sebelumnya bukan 'returned' dan status saat ini 'returned'
                elseif ($previousStatus !== 'returned' && $request->loan_status === 'returned') {
                    $book->coppies += 1;  // Menambah stok
                    if ($book->coppies > 0) {
                        $book->status = 'available';
                    }
                    $book->save();
                }

                // Jika status sebelumnya adalah fines
                // elseif ($previousStatus === 'fine' && $request->loan_status !== 'fine') {
                //     $fine = Fine::where('loan_id', $loanId)->delete();
                //     if ($fine) {
                //         if ($fine->status !== 'pay_for_book') {
                //             $book->coppies -= 1;
                //             if ($book->coppies <= 0) {
                //                 $book->status = 'unavailable';
                //             }
                //             $book->save();
                //         }
                //     }
                // }
            }


            return redirect()->route('peminjaman')->with('success', 'Peminjaman berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('peminjaman')->with('error', 'Terjadi kesalahan saat memperbarui peminjaman: ' . $e->getMessage());
        }
    }


    public function destroy(Request $request)
    {
        $loanId = $request->input('loan_id');
        $returnCoppies = $request->input('return_coppies');

        try {
            $loan = Loan::with('book')->findOrFail($loanId);
            $loan->delete();

            if ($returnCoppies) {
                $book = $loan->book;
                if ($book) {
                    $book->coppies += 1;
                    if ($book->coppies > 0) {
                        $book->status = 'available';
                    }
                    $book->save();
                }
            }

            return redirect()->route('peminjaman')->with('success', 'Peminjaman berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('peminjaman')->with('error', 'Terjadi kesalahan saat menghapus peminjaman: ' . $e->getMessage());
        }
    }
}
