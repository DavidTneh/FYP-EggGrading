<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AssignedEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('assignedEmployee')->insert([
            ['userID' => 1, 'scheduleID' => 1],
            ['userID' => 2, 'scheduleID' => 2],
        ]);
    }

}
