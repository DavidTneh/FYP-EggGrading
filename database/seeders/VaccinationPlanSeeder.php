<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VaccinationPlanSeeder extends Seeder
{
    public function run()
    {
        DB::table('vaccinationplan')->insert([
            [
                'vaccinationtypeID' => 1,
                'vaccinationPerChicken' => 1,
                'cageID' => 1,
                'totalVaccinationRequired' => 50,
                'date' => '2024-10-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'vaccinationtypeID' => 2,
                'vaccinationPerChicken' => 2,
                'cageID' => 2,
                'totalVaccinationRequired' => 30,
                'date' => '2024-11-10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
