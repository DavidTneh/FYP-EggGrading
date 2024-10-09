<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ChickenBreedSeeder extends Seeder
{
    public function run()
    {
        DB::collection('chickenBreeds')->insert([
            ['name' => 'Rhode Island Red', 'gender' => 'Male', 'origin' => 'USA'],
            ['name' => 'Leghorn', 'gender' => 'Female', 'origin' => 'Italy'],
        ]);
    }
}
