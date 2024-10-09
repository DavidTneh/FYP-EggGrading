<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // or other necessary imports

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            VaccinationTypeSeeder::class,
            ChickenBreedSeeder::class,
            CageSeeder::class,
            EggGradeSeeder::class,
            VaccinationPlanSeeder::class,
            ChickenSeeder::class,
            EggSeeder::class,
            CollectionPlanSeeder::class,
            FeedingPlanSeeder::class,
            CullingPlanSeeder::class,
            TaskSchedulingSeeder::class,
            CageScheduleSeeder::class,
            AssignedEmployeeSeeder::class,
        ]);
    }
}
