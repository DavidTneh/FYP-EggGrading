<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EggGradeSeeder extends Seeder
{
    public function run()
    {
        DB::table('egggrade')->insert([
            [
                'name' => 'Grade A',
                'grade' => 'A',
                'description' => 'Large eggs',
                'estimatedWeightRange' => '60g-70g',
                'price' => 1.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Grade B',
                'grade' => 'B',
                'description' => 'Medium eggs',
                'estimatedWeightRange' => '50g-60g',
                'price' => 1.20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
