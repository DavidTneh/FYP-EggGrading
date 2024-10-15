<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('role')->insert([
            [
                'roleName' => 'Admin',
                'roleDescription' => 'Administrator with full permissions',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'roleName' => 'Employee',
                'roleDescription' => 'Regular employee with limited permissions',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
