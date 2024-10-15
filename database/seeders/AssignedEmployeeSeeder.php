<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignedEmployeeSeeder extends Seeder
{
    public function run()
    {
        DB::table('assignedemployee')->insert([
            [
                'userID' => 1,
                'scheduleID' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userID' => 2,
                'scheduleID' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
