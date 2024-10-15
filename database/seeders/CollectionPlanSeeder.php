<?php

namespace Database\Seeders;

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
                'repeat' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'time' => '12:00:00',
                'frequency' => 'Weekly',
                'repeat' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
