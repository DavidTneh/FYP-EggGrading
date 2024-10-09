<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TaskSchedulingSeeder extends Seeder
{
    public function run()
    {
        DB::collection('taskScheduling')->insert([
            ['taskName' => 'Egg Collection', 'taskDescription' => 'Collect eggs from Cage A', 'status' => 'Pending'],
        ]);
    }
}
