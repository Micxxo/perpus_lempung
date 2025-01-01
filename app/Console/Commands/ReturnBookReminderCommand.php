<?php

namespace App\Console\Commands;

use App\Mail\MailBookReturnReminder;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ReturnBookReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:return-book';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dueDate = Carbon::now()->addDays(2)->startOfDay();
        $bookLoans = Loan::whereDate('return_date', $dueDate)
            ->with(['member.user', 'book'])
            ->get();

        foreach ($bookLoans as $loan) {
            $data = [
                'subject' => 'Peringatan Pengembalian Buku',
                'username' => $loan->member->user->username,
                'book' => $loan->book->name,
                'title' => 'Peringatan Pengembalian Buku',
                'body' => 'Peringatan untuk mengembalikan buku - Perpustakaan Lempuing'
            ];
            Mail::to($loan->member->user->email)->send(new MailBookReturnReminder($data));
        };
    }
}
