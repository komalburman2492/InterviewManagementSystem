<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@yopmail.com',
            'password' => Hash::make('password'),
            'role' => 1,
        ]);

        // Create an interviewer user
        User::create([
            'name' => 'Interviewer User',
            'email' => 'interviewer@yopmail.com',
            'password' => Hash::make('password'),
            'role' => 2,
        ]);

        // Create a candidate user
        User::create([
            'name' => 'Candidate User',
            'email' => 'candidate@yopmail.com',
            'password' => Hash::make('password'),
            'role' => 3,
        ]);
    }
}
