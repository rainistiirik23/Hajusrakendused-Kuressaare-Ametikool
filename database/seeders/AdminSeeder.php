<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userName = config('app.username');
        $email = config('app.email');
        $password = config('app.password');

        DB::table('users')->insert([
            'name' => $userName,
            'email' => $email,
            'is_admin' => true,
            'password' => Hash::make($password),
        ]);
    }
}
