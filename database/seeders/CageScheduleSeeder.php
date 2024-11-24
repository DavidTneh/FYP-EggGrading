<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CageScheduleSeeder extends Seeder
{
    public function run()
    {
        DB::table('cageschedule')->insert([
            [
                'cageID' => 1,
                'scheduleID' => 1,
                'start_date' => '2024-11-20',
                'culling_date' => '2025-01-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cageID' => 2,
                'scheduleID' => 2,
                'start_date' => '2024-11-21',
                'culling_date' => '2025-02-21',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
