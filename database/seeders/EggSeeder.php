<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EggSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('eggs')->insert([
            ['type' => 'Fertilized', 'eggGradeID' => 1, 'description' => 'High-quality fertilized eggs', 'cageID' => 1, 'receivedDate' => now(), 'last_updated' => now()],
            ['type' => 'Unfertilized', 'eggGradeID' => 2, 'description' => 'Standard-quality unfertilized eggs', 'cageID' => 2, 'receivedDate' => now(), 'last_updated' => now()],
        ]);
    }

}
