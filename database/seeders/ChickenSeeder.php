<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChickenSeeder extends Seeder
{
    public function run()
    {
        DB::table('chicken')->insert([
            [
                'breedID' => 1,
                'dob' => '2023-05-01',
                'cageID' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'breedID' => 2,
                'dob' => '2023-06-15',
                'cageID' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
