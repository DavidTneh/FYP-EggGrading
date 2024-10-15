<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('user')->insert([
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phoneNo' => '0123456789',
                'dob' => '1990-01-01',
                'password' => Hash::make('password'),
                'roleID' => 1,
                'address' => '123 Main St',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'phoneNo' => '0987654321',
                'dob' => '1995-05-05',
                'password' => Hash::make('password'),
                'roleID' => 2,
                'address' => '456 Second St',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
