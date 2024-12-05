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
                'ageThreshold' => 60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'vaccinationtypeID' => 2,
                'vaccinationPerChicken' => 2,
                'ageThreshold' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
