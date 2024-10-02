<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CageScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cageSchedule')->insert([
            ['cageID' => 1, 'scheduleID' => 1],
            ['cageID' => 2, 'scheduleID' => 2],
        ]);
    }

}
