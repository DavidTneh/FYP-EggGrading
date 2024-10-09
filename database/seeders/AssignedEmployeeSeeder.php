<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AssignedEmployeeSeeder extends Seeder
{
    public function run()
    {
        $user = DB::collection('user')->where('email', 'jane.smith@example.com')->first();
        $schedule = DB::collection('taskScheduling')->where('taskName', 'Egg Collection')->first();

        DB::collection('assignedEmployee')->insert([
            ['userID' => $user['_id'], 'scheduleID' => $schedule['_id']],
        ]);
    }
}
