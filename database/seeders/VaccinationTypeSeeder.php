<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class VaccinationTypeSeeder extends Seeder
{
    public function run()
    {
        DB::collection('vaccinationtype')->insert([
            [
                'vaccineName' => 'Newcastle Disease Vaccine',
                'methodConsume' => 'Oral',
                'description' => 'Protects against Newcastle disease',
                'criteria' => 'All chickens older than 4 weeks',
            ],
            [
                'vaccineName' => 'Fowl Pox Vaccine',
                'methodConsume' => 'Injection',
                'description' => 'Protects against fowl pox',
                'criteria' => 'All chickens older than 8 weeks',
            ]
        ]);
    }
}
