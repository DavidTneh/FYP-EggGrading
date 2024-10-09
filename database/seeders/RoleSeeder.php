<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::collection('role')->insert([
            ['roleName' => 'Admin', 'roleDescription' => 'Full system access'],
            ['roleName' => 'Employee', 'roleDescription' => 'Limited access based on assigned tasks'],
        ]);
    }
}
