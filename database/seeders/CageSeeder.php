<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CageSeeder extends Seeder
{
    public function run()
    {
        DB::collection('cage')->insert([
            ['name' => 'Cage A', 'size' => 'Large', 'capacity' => 20, 'type' => 'Layer', 'status' => 'Available', 'availability' => 'True'],
            ['name' => 'Cage B', 'size' => 'Medium', 'capacity' => 15, 'type' => 'Broiler', 'status' => 'Occupied', 'availability' => 'False'],
        ]);
    }
}
