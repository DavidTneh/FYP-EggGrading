<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeedingPlanSeeder extends Seeder
{
    public function run()
    {
        DB::table('feedingplan')->insert([
            [
                'time' => '07:00:00',
                'frequency' => 'Daily',
                'is_repeating' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'time' => '14:00:00',
                'frequency' => 'Weekly',
                'is_repeating' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
