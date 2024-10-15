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
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cageID' => 2,
                'scheduleID' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
