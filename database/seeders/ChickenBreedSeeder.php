<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ChickenBreedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chickenBreeds')->insert([
            ['name' => 'Leghorn', 'gender' => 'Female', 'origin' => 'Italy'],
            ['name' => 'Rhode Island Red', 'gender' => 'Male', 'origin' => 'USA'],
        ]);
    }

}
