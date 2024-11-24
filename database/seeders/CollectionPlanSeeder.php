<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollectionPlanSeeder extends Seeder
{
    public function run()
    {
        DB::table('collectionplan')->insert([
            [
                'time' => '08:00:00',
                'frequency' => 'Daily',
                'is_repeating' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'time' => '12:00:00',
                'frequency' => 'Weekly',
                'is_repeating' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
