<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CageSeeder extends Seeder
{
    public function run()
    {
        DB::table('cage')->insert([
            [
                'name' => 'Cage 1',
                'size' => 'Large',
                'capacity' => 50,
                'type' => 'Standard',
                'status' => 'Active',
                'availability' => 'Available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cage 2',
                'size' => 'Medium',
                'capacity' => 30,
                'type' => 'Standard',
                'status' => 'Active',
                'availability' => 'Occupied',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
