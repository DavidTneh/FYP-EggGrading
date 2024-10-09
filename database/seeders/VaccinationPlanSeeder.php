<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class VaccinationPlanSeeder extends Seeder
{
    public function run()
    {
        $vaccine = DB::collection('vaccinationtype')->where('vaccineName', 'Newcastle Disease Vaccine')->first();
        $cage = DB::collection('cage')->where('name', 'Cage A')->first();

        DB::collection('vaccinationplan')->insert([
            [
                'vaccinationtypeID' => $vaccine['_id'], // Using ObjectId from vaccinationtype
                'vaccinationPerChicken' => 1,
                'cageID' => $cage['_id'], // Using ObjectId from cage
                'totalVaccinationRequired' => 20,
                'date' => '2024-10-15'
            ]
        ]);
    }
}
