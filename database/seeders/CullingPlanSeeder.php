<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CullingPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cullingplan')->insert([
            ['eliminateAgeThreshold' => 365, 'reasons' => 'Low egg production', 'healthStatus' => 'Poor', 'notes' => 'Requires culling'],
            ['eliminateAgeThreshold' => 730, 'reasons' => 'Age limit reached', 'healthStatus' => 'Normal', 'notes' => 'Regular culling'],
        ]);
    }

}
