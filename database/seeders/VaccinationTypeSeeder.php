<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VaccinationTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('vaccinationtype')->insert([
            [
                'vaccineName' => 'Vaccine A',
                'methodConsume' => 'Oral',
                'description' => 'Used for general protection',
                'criteria' => 'For healthy chickens only',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'vaccineName' => 'Vaccine B',
                'methodConsume' => 'Injection',
                'description' => 'Used for specific diseases',
                'criteria' => 'For chickens at risk',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
