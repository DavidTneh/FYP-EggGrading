<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VaccinationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vaccinationtype')->insert([
            ['vaccineName' => 'Newcastle Disease Vaccine', 'methodConsume' => 'Oral', 'description' => 'Prevents Newcastle Disease', 'criteria' => 'Applicable for all breeds'],
            ['vaccineName' => 'Avian Influenza Vaccine', 'methodConsume' => 'Injection', 'description' => 'Prevents Avian Influenza', 'criteria' => 'For chickens above 6 weeks'],
        ]);
    }

}
