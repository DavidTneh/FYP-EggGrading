<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChickenBreedSeeder extends Seeder
{
    public function run()
    {
        DB::table('chickenbreeds')->insert([
            [
                'name' => 'Breed A',
                'gender' => 'Female',
                'origin' => 'USA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Breed B',
                'gender' => 'Male',
                'origin' => 'UK',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
