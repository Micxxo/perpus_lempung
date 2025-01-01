<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateLoanStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loan:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update loan status based on the return_date field';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();

        $lateLoans = DB::table('loans')
            ->where('return_date', '<', $today)
            ->whereNotIn('status', ['late', 'fine'])
            ->update(['status' => 'late']);

        $deadlineLoans = DB::table('loans')
            ->where('return_date', '=', $today)
            ->whereNotIn('status', ['deadline', 'fine'])
            ->update(['status' => 'deadline']);

        $this->info("Loan statuses updated successfully. Late: $lateLoans, Deadline: $deadlineLoans");

        return Command::SUCCESS;
    }
}
