<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VaccinationPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vaccinationplan')->insert([
            ['vaccinationtypeID' => 1, 'vaccinationPerChicken' => 1, 'cageID' => 1, 'totalVaccinationRequired' => 100, 'date' => now()],
            ['vaccinationtypeID' => 2, 'vaccinationPerChicken' => 2, 'cageID' => 2, 'totalVaccinationRequired' => 50, 'date' => now()],
        ]);
    }

}
