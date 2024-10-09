<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class EggSeeder extends Seeder
{
    public function run()
    {
        $eggGrade = DB::collection('eggGrade')->where('name', 'Grade A')->first();
        $cage = DB::collection('cage')->where('name', 'Cage A')->first();

        DB::collection('eggs')->insert([
            ['type' => 'Chicken Egg', 'eggGradeID' => $eggGrade['_id'], 'description' => 'Large, brown', 'cageID' => $cage['_id']],
        ]);
    }
}
