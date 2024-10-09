<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ChickenSeeder extends Seeder
{
    public function run()
    {
        $breed = DB::collection('chickenBreeds')->where('name', 'Rhode Island Red')->first();
        $cage = DB::collection('cage')->where('name', 'Cage A')->first();

        DB::collection('chicken')->insert([
            ['breedID' => $breed['_id'], 'dob' => '2024-01-01', 'cageID' => $cage['_id']],
            ['breedID' => $breed['_id'], 'dob' => '2024-02-01', 'cageID' => $cage['_id']],
        ]);
    }
}
