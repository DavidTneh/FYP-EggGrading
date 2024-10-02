<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            ['name' => 'Admin User', 'email' => 'admin@example.com', 'phoneNo' => '123456789', 'dob' => '1980-01-01', 'password' => bcrypt('password'), 'roleID' => 1, 'address' => '123 Admin St', 'image' => null],
            ['name' => 'Employee User', 'email' => 'employee@example.com', 'phoneNo' => '987654321', 'dob' => '1990-01-01', 'password' => bcrypt('password'), 'roleID' => 2, 'address' => '456 Employee St', 'image' => null],
        ]);
    }

}
