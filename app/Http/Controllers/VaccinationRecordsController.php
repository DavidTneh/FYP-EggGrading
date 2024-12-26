<?php

namespace App\Http\Controllers;

use App\Models\Cage;
use App\Models\User;
use App\Models\Chicken;
use Illuminate\Http\Request;
use App\Models\ChickenBreeds;
use App\Models\VaccinationPlan;
use App\Models\VaccinationRecord;
use App\Models\VaccinationRecords;
use Illuminate\Support\Facades\Log;

class VaccinationRecordsController extends Controller
{

    public function index()
    {
        try {
            // Retrieve all chickens with related vaccination records grouped by cage and breed
            $chickens = Chicken::with([
                'breed',
                'cage',
                'vaccinationRecords.vaccinationplan.vaccinationType',
                'vaccinationRecords.user',
            ])->get();

            if ($chickens->isEmpty()) {
                return back()->withErrors(['error' => 'No chickens or vaccination records found.']);
            }

            // Group chickens by cageID and then by breedID
            $vaccinationRecordsGrouped = $chickens->groupBy('cageID')->map(function ($cageGroup) {
                return $cageGroup->groupBy('breedID');
            });

            // Retrieve all breeds for the upgrade functionality
            $breeds = ChickenBreeds::all();

            if ($breeds->isEmpty()) {
                return back()->withErrors(['error' => 'No chicken breeds found.']);
            }

            // Pass grouped chickens and available breeds to the view
            return view(
                'vaccinationRecordManagement',
                compact('vaccinationRecordsGrouped', 'breeds')
            );
        } catch (\Exception $e) {
            // Log the exception for debugging (optional)
            Log::error('Failed to load vaccination records: ' . $e->getMessage());

            return back()->withErrors(['error' => 'An error occurred while retrieving vaccination records. Please try again.']);
        }
    }

    // Show the form for creating a new vaccination record
    public function create()
    {
        try {
            $cages = Cage::with(['chickens.breed'])->get(); // List all cages
            $vaccinationPlans = VaccinationPlan::all(); // List all vaccination plans
            $employees = User::where('roleID', 2)->get(); // Assuming roleID 2 is for employees

            // Validation for empty data
            if ($cages->isEmpty()) {
                return back()->withErrors(['error' => 'No cages found. Please add cages before proceeding.']);
            }

            if ($vaccinationPlans->isEmpty()) {
                return back()->withErrors(['error' => 'No vaccination plans found. Please add vaccination plans before proceeding.']);
            }

            if ($employees->isEmpty()) {
                return back()->withErrors(['error' => 'No employees found. Please ensure employees are registered in the system.']);
            }

            return view('addVaccinationRecord', compact('cages', 'vaccinationPlans', 'employees'));
        } catch (\Exception $e) {
            // Log the exception for debugging (optional)
            Log::error('Error loading vaccination record form: ' . $e->getMessage());

            return back()->withErrors(['error' => 'An error occurred while loading the form. Please try again later.']);
        }
    }



    // Store a new vaccination record
    public function store(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'cageID' => 'required|exists:cage,cageID',
                'breedID' => 'required|exists:chickenbreeds,breedID',
                'vaccinationplanID' => 'required|exists:vaccinationplan,vaccinationplanID',
                'administered_by' => 'required|exists:user,userID',
                'status' => 'required|in:completed,pending,skipped',
                'notes' => 'nullable|string',
            ]);

            // Fetch all chickens within the selected cage and breed
            $chickens = Chicken::where('cageID', $request->input('cageID'))
            ->where('breedID', $request->input('breedID'))
            ->get();

            if ($chickens->isEmpty()) {
                return back()->withErrors(['error' => 'No chickens found for the selected cage and breed.']);
            }

            // Retrieve the vaccination plan to get the ageThreshold
            $vaccinationPlan = VaccinationPlan::findOrFail($request->input('vaccinationplanID'));

            if (!$vaccinationPlan || !$vaccinationPlan->ageThreshold) {
                return back()->withErrors(['error' => 'The selected vaccination plan does not have a valid age threshold.']);
            }

            $ageThreshold = $vaccinationPlan->ageThreshold; // Age in weeks

            // Create a vaccination record for each chicken
            foreach ($chickens as $chicken) {
                // Calculate the date_administered dynamically
                $dateAdministered = \Carbon\Carbon::parse($chicken->dob)->addDays($ageThreshold)->toDateString();

                VaccinationRecords::create([
                    'chickenID' => $chicken->chickenID,
                    'vaccinationplanID' => $request->input('vaccinationplanID'),
                    'date_administered' => $dateAdministered,
                    'administered_by' => $request->input('administered_by'),
                    'status' => $request->input('status'),
                    'notes' => $request->input('notes'),
                ]);
            }

            return redirect()->route('vaccination_records.index')->with('success', 'Vaccination records added successfully for the group.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation error messages to the user
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log the exception for debugging (optional)
            Log::error('Error storing vaccination records: ' . $e->getMessage());

            return back()->withErrors(['error' => 'An error occurred while storing the vaccination records. Please try again later.'])->withInput();
        }
    }


    // Show the form for editing a vaccination record
    public function edit($id)
    {
        try {
            // Fetch the vaccination record
            $vaccinationRecord = VaccinationRecords::findOrFail($id);

            // Fetch related data
            $chickens = Chicken::all();
            $vaccinationPlans = VaccinationPlan::all();
            $employees = User::where('roleID', 2)->get();

            // Return the view with the data
            return view('updateVaccinationRecord', compact('vaccinationRecord', 'chickens', 'vaccinationPlans', 'employees'));
        } catch (\Exception $e) {
            // Log the error and redirect with an error message
            Log::error('Error in edit: ' . $e->getMessage());
            return redirect()->route('vaccination_records.index')->withErrors('An error occurred while fetching the vaccination record. Please try again.');
        }
    }


    // Update an existing vaccination record
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'chickenID' => 'required|exists:chicken,chickenID',
            'vaccinationplanID' => 'required|exists:vaccinationplan,vaccinationplanID',
            'date_administered' => 'required|date',
            'administered_by' => 'required|exists:users,userID',
            'status' => 'required|in:completed,pending,skipped',
            'notes' => 'nullable|string|max:500', // Restrict note length
        ], [
            'chickenID.required' => 'The Chicken field is required.',
            'chickenID.exists' => 'The selected Chicken does not exist.',
            'vaccinationplanID.required' => 'The Vaccination Plan field is required.',
            'vaccinationplanID.exists' => 'The selected Vaccination Plan does not exist.',
            'date_administered.required' => 'The Date Administered field is required.',
            'date_administered.date' => 'The Date Administered must be a valid date.',
            'administered_by.required' => 'The Administered By field is required.',
            'administered_by.exists' => 'The selected Administered By user does not exist.',
            'status.required' => 'The Status field is required.',
            'status.in' => 'The Status must be one of: completed, pending, or skipped.',
            'notes.string' => 'The Notes must be a string.',
            'notes.max' => 'The Notes may not be greater than 500 characters.',
        ]);

        try {
            // Fetch the vaccination record
            $vaccinationRecord = VaccinationRecords::findOrFail($id);
            
            // Update the record with validated data
            $vaccinationRecord->update($validatedData);

            return redirect()->route('vaccination_records.index')->with('success', 'Vaccination record updated successfully.');
        } catch (\Exception $e) {
            // Log the error and redirect with an error message
            Log::error('Error in update: ' . $e->getMessage());
            return redirect()->route('vaccination_records.index')->withErrors('An error occurred while updating the vaccination record. Please try again.');
        }
    }


    public function editGroup(Request $request)
    {
        try {
            $request->validate([
                'cageID' => 'required|exists:cage,cageID',
                'breedID' => 'required|exists:chickenbreeds,breedID',
            ], [
                'cageID.required' => 'The Cage ID is required.',
                'cageID.exists' => 'The selected Cage does not exist.',
                'breedID.required' => 'The Breed ID is required.',
                'breedID.exists' => 'The selected Breed does not exist.',
            ]);

            $cageID = $request->input('cageID');
            $breedID = $request->input('breedID');

            // Retrieve all vaccination records for the specified cage and breed
            $vaccinationRecords = VaccinationRecords::with(['chicken.breed', 'chicken.cage', 'vaccinationplan.vaccinationType', 'user'])
            ->whereHas('chicken', function ($query) use ($cageID, $breedID) {
                $query->where('cageID', $cageID)->where('breedID', $breedID);
            })
                ->get();

            if ($vaccinationRecords->isEmpty()) {
                return redirect()->route('vaccination_records.index')->withErrors('No vaccination records found for the specified group.');
            }

            // Fetch related data for dropdowns or reference
            $cages = Cage::all();
            $breeds = ChickenBreeds::all();
            $vaccinationPlans = VaccinationPlan::all();

            return view('updateVaccinationRecord', compact('vaccinationRecords', 'cages', 'breeds', 'vaccinationPlans', 'cageID', 'breedID'));
        } catch (\Exception $e) {
            Log::error('Error in editGroup: ' . $e->getMessage());
            return redirect()->route('vaccination_records.index')->withErrors('An error occurred while fetching the group data. Please try again.');
        }
    }


    public function updateGroup(Request $request)
    {
        $request->validate([
            'cageID' => 'required|exists:cage,cageID',
            'breedID' => 'required|exists:chickenbreeds,breedID',
            // 'new_breedID' => 'required|exists:chickenbreeds,breedID|different:breedID',
            'vaccinationplanID' => 'required|exists:vaccinationplan,vaccinationplanID',
            'status' => 'required|in:pending,completed,in_progress',
            'notes' => 'nullable|string|max:500',
        ], [
            'cageID.required' => 'The Cage ID is required.',
            'cageID.exists' => 'The selected Cage does not exist.',
            'breedID.required' => 'The Breed ID is required.',
            'breedID.exists' => 'The selected Breed does not exist.',
            // 'new_breedID.required' => 'The New Breed ID is required.',
            // 'new_breedID.exists' => 'The selected New Breed does not exist.',
            // 'new_breedID.different' => 'The New Breed must be different from the current Breed.',
            'vaccinationplanID.required' => 'The Vaccination Plan ID is required.',
            'vaccinationplanID.exists' => 'The selected Vaccination Plan does not exist.',
            'status.required' => 'The Status is required.',
            'status.in' => 'The Status must be one of: pending, completed, or in_progress.',
            'notes.string' => 'The Notes must be a valid string.',
            'notes.max' => 'The Notes may not exceed 500 characters.',
        ]);

        try {
            // Retrieve the vaccination plan to get the ageThreshold
            $vaccinationPlan = VaccinationPlan::findOrFail($request->input('vaccinationplanID'));

            if (!$vaccinationPlan->ageThreshold) {
                return back()->withErrors('Vaccination plan does not have a valid age threshold.');
            }

            $ageThreshold = $vaccinationPlan->ageThreshold;

            // Find all chickens in the specified cage and breed
            $chickens = Chicken::where('cageID', $request->input('cageID'))
            ->where('breedID', $request->input('breedID'))
            ->get();

            if ($chickens->isEmpty()) {
                return back()->withErrors('No chickens found for the specified group.');
            }

            // Update vaccination records for each chicken in the group
            foreach ($chickens as $chicken) {
                $dateAdministered = \Carbon\Carbon::parse($chicken->dob)->addDays($ageThreshold)->toDateString();

                VaccinationRecords::where('chickenID', $chicken->chickenID)->update([
                    'vaccinationplanID' => $request->input('vaccinationplanID'),
                    'date_administered' => $dateAdministered,
                    'status' => $request->input('status'),
                    'notes' => $request->input('notes'),
                ]);
            }

            // // Optionally update the chickens' breed
            // Chicken::where('cageID', $request->input('cageID'))
            // ->where('breedID', $request->input('breedID'))
            // ->update(['breedID' => $request->input('new_breedID')]);

            return redirect()->route('vaccination_records.index')->with('success', 'Vaccination records updated successfully for the group.');
        } catch (\Exception $e) {
            Log::error('Error in updateGroup: ' . $e->getMessage());
            return back()->withErrors('An error occurred while updating the group. Please try again.');
        }
    }


    public function destroy($id)
    {
        try {
            // Validate and find the vaccination record
            $vaccinationRecord = VaccinationRecords::findOrFail($id);

            // Attempt to delete the record
            $vaccinationRecord->delete();

            return redirect()->route('vaccination_records.index')->with('success', 'Vaccination record deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error in destroy: ' . $e->getMessage());
            return redirect()->route('vaccination_records.index')->withErrors('An error occurred while deleting the vaccination record. Please try again.');
        }
    }


    public function upgradeGroup(Request $request)
    {
        $request->validate([
            'cageID' => 'required|exists:cage,cageID',
            'breedID' => 'required|exists:chickenbreeds,breedID',
            // 'new_breedID' => 'required|exists:chickenbreeds,breedID|different:breedID',
        ], [
            'cageID.required' => 'The Cage ID is required.',
            'cageID.exists' => 'The selected Cage does not exist.',
            'breedID.required' => 'The Breed ID is required.',
            'breedID.exists' => 'The selected Breed does not exist.',
            // 'new_breedID.required' => 'The New Breed ID is required.',
            // 'new_breedID.exists' => 'The selected New Breed does not exist.',
            // 'new_breedID.different' => 'The New Breed must be different from the current Breed.',
        ]);

        try {
            // Retrieve chickens in the specified group
            $chickens = Chicken::where('cageID', $request->input('cageID'))
            ->where('breedID', $request->input('breedID'))
            ->get();

            if ($chickens->isEmpty()) {
                return back()->withErrors('No chickens found for the specified cage and breed.');
            }

            // // Update the breed for all chickens in the group
            // Chicken::where('cageID', $request->input('cageID'))
            // ->where('breedID', $request->input('breedID'))
            // ->update(['breedID' => $request->input('new_breedID')]);

            return redirect()->route('vaccination_records.index')->with('success', 'Chickens in the group upgraded successfully.');
        } catch (\Exception $e) {
            Log::error('Error in upgradeGroup: ' . $e->getMessage());
            return back()->withErrors('An error occurred while upgrading the group. Please try again.');
        }
    }


    public function deleteGroup(Request $request)
    {
        $request->validate([
            'cageID' => 'required|exists:cage,cageID',
            'breedID' => 'required|exists:chickenbreeds,breedID',
            'date_administered' => 'required|date',
        ], [
            'cageID.required' => 'The Cage ID is required.',
            'cageID.exists' => 'The selected Cage does not exist.',
            'breedID.required' => 'The Breed ID is required.',
            'breedID.exists' => 'The selected Breed does not exist.',
            'date_administered.required' => 'The Date Administered is required.',
            'date_administered.date' => 'The Date Administered must be a valid date.',
        ]);

        try {
            // Find all chickens in the specified cage and breed
            $chickens = Chicken::where('cageID', $request->input('cageID'))
            ->where('breedID', $request->input('breedID'))
            ->get();

            if ($chickens->isEmpty()) {
                return back()->withErrors('No chickens found for the specified cage and breed.');
            }

            // Loop through chickens and delete related vaccination records
            foreach ($chickens as $chicken) {
                VaccinationRecords::where('chickenID', $chicken->chickenID)
                    ->where('date_administered', $request->input('date_administered'))
                    ->delete();
            }

            return redirect()->route('vaccination_records.index')->with('success', 'Vaccination records deleted successfully for the group.');
        } catch (\Exception $e) {
            Log::error('Error in deleteGroup: ' . $e->getMessage());
            return back()->withErrors('An error occurred while deleting the vaccination records. Please try again.');
        }
    }


    public function destroyGroup(Request $request)
    {
        $request->validate([
            'cageID' => 'required|exists:cage,cageID',
            'breedID' => 'required|exists:chickenbreeds,breedID',
        ], [
            'cageID.required' => 'The Cage ID is required.',
            'cageID.exists' => 'The selected Cage does not exist.',
            'breedID.required' => 'The Breed ID is required.',
            'breedID.exists' => 'The selected Breed does not exist.',
        ]);

        try {
            $cageID = $request->input('cageID');
            $breedID = $request->input('breedID');

            // Check if records exist before deleting
            $recordsCount = VaccinationRecords::whereHas('chicken', function ($query) use ($cageID, $breedID) {
                $query->where('cageID', $cageID)->where('breedID', $breedID);
            })->count();

            if ($recordsCount === 0) {
                return back()->withErrors('No vaccination records found for the specified group.');
            }

            // Delete all vaccination records for the specified cage and breed
            VaccinationRecords::whereHas('chicken', function ($query) use ($cageID, $breedID) {
                $query->where('cageID', $cageID)->where('breedID', $breedID);
            })->delete();

            return redirect()->route('vaccination_records.index')->with('success', 'Vaccination group deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error in destroyGroup: ' . $e->getMessage());
            return back()->withErrors('An error occurred while deleting the vaccination group. Please try again.');
        }
    }

    public function listVaccinationRecords(Request $request)
    {
        try {
            // Retrieve grouped data by cageID, breedID, vaccinationplanID, and date_administered
            $vaccinationRecordsGrouped = Chicken::with([
                'breed',
                'cage',
                'vaccinationRecords.vaccinationplan.vaccinationType',
                'vaccinationRecords.user',
            ])
                ->get()
                ->flatMap(function ($chicken) {
                    return $chicken->vaccinationRecords->map(function ($record) use ($chicken) {
                        return [
                            'cageID' => $chicken->cageID,
                            'breedID' => $chicken->breedID,
                            'vaccinationplanID' => $record->vaccinationplanID,
                            'date_administered' => $record->date_administered,
                            'cageName' => $chicken->cage->name ?? 'Unknown Cage',
                            'breedName' => $chicken->breed->name ?? 'Unknown Breed',
                            'vaccinationPlanName' => $record->vaccinationplan->vaccinationType->vaccineName ?? 'Unknown Plan',
                            'totalRecords' => 1, // Initialize to 1 for grouping later
                            'status' => $record->status,
                        ];
                    });
                })
                ->groupBy(function ($item) {
                    return $item['cageID'] . '-' . $item['breedID'] . '-' . $item['vaccinationplanID'] . '-' . $item['date_administered'];
                });

            return view('vaccinationRecords.list', compact('vaccinationRecordsGrouped'));
        } catch (\Exception $e) {
            Log::error('Error in listVaccinationRecords: ' . $e->getMessage());
            return back()->withErrors('An error occurred while retrieving vaccination records. Please try again.');
        }
    }


    public function updateSelectedVaccinationRecords(Request $request)
    {
        $request->validate([
            'selected_groups' => 'required|array', // Expect an array of selected groups
            'selected_groups.*.cageID' => 'required|exists:cage,cageID',
            'selected_groups.*.breedID' => 'required|exists:chickenbreeds,breedID',
            'selected_groups.*.vaccinationplanID' => 'required|exists:vaccinationplan,vaccinationplanID',
            'selected_groups.*.date_administered' => 'required|date',
            'status' => 'required|in:pending,completed',
            'notes' => 'nullable|string',
        ], [
            'selected_groups.required' => 'Please select at least one group to update.',
            'selected_groups.*.cageID.required' => 'Cage ID is required for each group.',
            'selected_groups.*.cageID.exists' => 'Selected Cage does not exist.',
            'selected_groups.*.breedID.required' => 'Breed ID is required for each group.',
            'selected_groups.*.breedID.exists' => 'Selected Breed does not exist.',
            'selected_groups.*.vaccinationplanID.required' => 'Vaccination Plan ID is required for each group.',
            'selected_groups.*.vaccinationplanID.exists' => 'Selected Vaccination Plan does not exist.',
            'selected_groups.*.date_administered.required' => 'Date Administered is required for each group.',
            'selected_groups.*.date_administered.date' => 'Date Administered must be a valid date.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be either "pending" or "completed".',
        ]);

        try {
            foreach ($request->input('selected_groups') as $group) {
                // Retrieve chicken IDs based on the conditions
                $chickens = Chicken::where('cageID', $group['cageID'])
                    ->where('breedID', $group['breedID'])
                    ->pluck('chickenID');

                if ($chickens->isEmpty()) {
                    return back()->withErrors("No chickens found for the selected cage and breed in group.");
                }

                // Update vaccination records matching the conditions
                VaccinationRecords::whereIn('chickenID', $chickens)
                    ->where('vaccinationplanID', $group['vaccinationplanID'])
                    ->where('date_administered', $group['date_administered'])
                    ->update([
                        'status' => $request->input('status'),
                        'notes' => $request->input('notes'),
                    ]);
            }

            return redirect()->route('vaccination.records.list')->with('success', 'Vaccination records updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error in updateSelectedVaccinationRecords: ' . $e->getMessage());
            return back()->withErrors('An error occurred while updating vaccination records. Please try again.');
        }
    }


}
