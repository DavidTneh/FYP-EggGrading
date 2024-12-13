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
            [
                'name' => 'Grade C',
                'grade' => 'C',
                'description' => 'Small eggs',
                'estimatedWeightRange' => '45g-50g',
                'price' => 1.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Grade D',
                'grade' => 'D',
                'description' => 'Extra small eggs',
                'estimatedWeightRange' => '40g-45g',
                'price' =>  0.80,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Grade E',
                'grade' => 'E',
                'description' => 'Tiny eggs',
                'estimatedWeightRange' => '35g-40g',
                'price' => 0.60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Grade F',
                'grade' => 'F',
                'description' => 'Super Tiny eggs',
                'estimatedWeightRange' => '35g-20g',
                'price' => 0.40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
