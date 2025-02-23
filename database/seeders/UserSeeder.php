<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'student',
            'email' => 'student@example.com',
            'is_member' => 0,
            'nisn' => '00867547',
            'role_id' => 1,
            'profile' => '',
            'password' => bcrypt('student123'),
            'email_verified_at' => Carbon::now(),
        ]);

        User::create([
            'username' => 'manager',
            'email' => 'manager@example.com',
            'is_member' => 0,
            'role_id' => 2,
            'profile' => '',
            'password' => bcrypt('manager123'),
            'email_verified_at' => Carbon::now(),
        ]);

        User::create([
            'username' => 'supervisor',
            'email' => 'supervisor@example.com',
            'is_member' => 0,
            'role_id' => 3,
            'profile' => '',
            'password' => bcrypt('supervisor123'),
            'email_verified_at' => Carbon::now(),
        ]);
    }
}
