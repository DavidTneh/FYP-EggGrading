<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chicken;
use App\Models\VaccinationPlan;
use App\Models\VaccinationRecords;
use Illuminate\Support\Facades\DB;

class VaccinationRecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch some chickens, vaccination plans, and employees
        $chickens = Chicken::all();
        $vaccinations = VaccinationPlan::all();
        $employees = DB::table('user')->where('roleID', 2)->pluck('userID'); // Assuming `userID` is the primary key in users table

        if ($chickens->isEmpty() || $vaccinations->isEmpty() || $employees->isEmpty()) {
            $this->command->warn('No chickens, vaccinations, or employees available for seeding vaccination records.');
            return;
        }

        // Generate vaccination records
        foreach ($chickens as $chicken) {
            // Select random vaccinations and employees
            $randomVaccination = $vaccinations->random();
            $randomEmployee = $employees->random();

            // Create a vaccination record for each chicken
            VaccinationRecords::create([
                'chickenID' => $chicken->chickenID,
                'vaccinationplanID' => $randomVaccination->vaccinationplanID,
                'date_administered' => now()->subDays(rand(1, 30)), // Random past date
                'administered_by' => $randomEmployee, // Assuming `userID` is the foreign key
                'notes' => 'Routine vaccination completed.', // Example note
            ]);
        }

        $this->command->info('Vaccination records seeded successfully.');
    }
}
