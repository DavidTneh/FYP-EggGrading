<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CollectionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('collectionplan')->insert([
            ['time' => '06:00:00', 'frequency' => 'Daily', 'repeat' => true],
            ['time' => '18:00:00', 'frequency' => 'Daily', 'repeat' => true],
        ]);
    }

}
