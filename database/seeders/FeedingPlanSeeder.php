<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeedingPlanSeeder extends Seeder
{
    public function run()
    {
        DB::table('feedingplan')->insert([
            [
                'time' => '09:00:00',
                'frequency' => 'Daily',
                'repeat' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'time' => '17:00:00',
                'frequency' => 'Weekly',
                'repeat' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
