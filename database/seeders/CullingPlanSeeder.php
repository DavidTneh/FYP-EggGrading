<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CullingPlanSeeder extends Seeder
{
    public function run()
    {
        DB::table('cullingplan')->insert([
            [
                'eliminateAgeThreshold' => 24,
                'reasons' => 'Old Age',
                'healthStatus' => 'Poor',
                'notes' => 'Needs to be culled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'eliminateAgeThreshold' => 30,
                'reasons' => 'Disease',
                'healthStatus' => 'Critical',
                'notes' => 'Cull immediately',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
