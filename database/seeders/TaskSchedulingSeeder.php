<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaskSchedulingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('taskScheduling')->insert([
            ['taskName' => 'Egg Collection', 'taskDescription' => 'Collect eggs from Cage A', 'collectionplanID' => 1, 'feedingplanID' => 1, 'cullingplanID' => 1, 'status' => 'Scheduled'],
            ['taskName' => 'Feeding', 'taskDescription' => 'Feed chickens in Cage B', 'collectionplanID' => 2, 'feedingplanID' => 2, 'cullingplanID' => 2, 'status' => 'Scheduled'],
        ]);
    }

}
