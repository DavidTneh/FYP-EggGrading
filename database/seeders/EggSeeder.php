<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EggSeeder extends Seeder
{
    public function run()
    {
        DB::table('eggs')->insert([
            [
                'type' => 'Chicken',
                'eggGradeID' => 1,
                'description' => 'Fresh eggs from Cage 1',
                'cageID' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Chicken',
                'eggGradeID' => 2,
                'description' => 'Fresh eggs from Cage 2',
                'cageID' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
