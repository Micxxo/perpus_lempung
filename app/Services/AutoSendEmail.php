<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class AutoSendEmail
{
    public function __invoke()
    {
        DB::table('roles')->insert([
            'name' => 'tes',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
