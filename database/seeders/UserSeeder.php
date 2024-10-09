<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $adminRole = DB::collection('role')->where('roleName', 'Admin')->first();
        $employeeRole = DB::collection('role')->where('roleName', 'Employee')->first();

        DB::collection('user')->insert([
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'phoneNo' => '1234567890',
                'dob' => '1990-01-01',
                'password' => Hash::make('password'),
                'roleID' => $adminRole['_id'], // Using the ObjectId from the role collection
                'address' => '123 Main Street',
                'image' => null,
                'status' => true,
                'session_id' => null,
                'reset_time' => null
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'phoneNo' => '0987654321',
                'dob' => '1992-05-15',
                'password' => Hash::make('password'),
                'roleID' => $employeeRole['_id'], // Using the ObjectId from the role collection
                'address' => '456 Elm Street',
                'image' => null,
                'status' => true,
                'session_id' => null,
                'reset_time' => null
            ]
        ]);
    }
}
