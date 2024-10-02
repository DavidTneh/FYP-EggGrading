<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->insert([
            ['roleName' => 'Admin', 'roleDescription' => 'Administrator with full access'],
            ['roleName' => 'Employee', 'roleDescription' => 'General employee'],
        ]);
    }

}
