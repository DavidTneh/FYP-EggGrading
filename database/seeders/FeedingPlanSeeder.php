<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FeedingPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('feedingplan')->insert([
            ['time' => '07:00:00', 'frequency' => 'Daily', 'repeat' => true],
            ['time' => '19:00:00', 'frequency' => 'Daily', 'repeat' => true],
        ]);
    }

}
