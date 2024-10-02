<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cage')->insert([
            ['name' => 'Cage A', 'size' => 'Large', 'capacity' => 100, 'type' => 'Outdoor', 'status' => 'Available', 'availability' => 'Yes'],
            ['name' => 'Cage B', 'size' => 'Medium', 'capacity' => 50, 'type' => 'Indoor', 'status' => 'Occupied', 'availability' => 'No'],
        ]);
    }

}
