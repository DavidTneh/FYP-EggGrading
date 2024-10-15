<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSchedulingSeeder extends Seeder
{
    public function run()
    {
        DB::table('taskscheduling')->insert([
            [
                'taskName' => 'Egg Collection',
                'taskDescription' => 'Daily egg collection task',
                'collectionplanID' => 1,
                'feedingplanID' => 1,
                'cullingplanID' => 1,
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'taskName' => 'Feeding Task',
                'taskDescription' => 'Scheduled feeding for the chickens',
                'collectionplanID' => 2,
                'feedingplanID' => 2,
                'cullingplanID' => 2,
                'status' => 'Completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
