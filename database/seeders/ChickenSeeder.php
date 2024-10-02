<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ChickenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chicken')->insert([
            ['breedID' => 1, 'dob' => '2022-06-15', 'cageID' => 1],
            ['breedID' => 2, 'dob' => '2022-06-20', 'cageID' => 2],
        ]);
    }

}
