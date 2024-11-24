<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CullingPlanSeeder extends Seeder
{
    public function run()
    {
        DB::table('cullingplan')->insert([
            [
                'eliminateAgeThreshold' => 30,
                'reasons' => 'Health deterioration',
                'healthStatus' => 'Critical',
                'notes' => 'Cull immediately due to severe illness.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'eliminateAgeThreshold' => 20,
                'reasons' => 'Low productivity',
                'healthStatus' => 'Weak',
                'notes' => 'Cull due to poor egg production.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
