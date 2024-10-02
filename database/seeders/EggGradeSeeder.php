<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EggGradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('eggGrade')->insert([
            ['name' => 'Grade A', 'grade' => 'A', 'description' => 'Highest quality eggs', 'estimatedWeightRange' => '70-75g', 'price' => 1.50],
            ['name' => 'Grade B', 'grade' => 'B', 'description' => 'Standard quality eggs', 'estimatedWeightRange' => '65-69g', 'price' => 1.00],
        ]);
    }

}
