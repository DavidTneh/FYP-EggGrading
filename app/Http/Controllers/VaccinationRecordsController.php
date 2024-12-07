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

class VaccinationRecordsController extends Controller
{
    // List all vaccination records
    // public function index()
    // {
    //     // Join vaccination_records with chicken to group data properly
    //     $vaccinationRecordsGrouped = VaccinationRecords::with(['chicken','chicken.breed', 'chicken.cage', 'vaccinationplan', 'user'])
    //     ->selectRaw(
    //         'chicken.cageID, chicken.breedID, COUNT(vaccination_records.chickenID) as quantity, vaccinationplanID, date_administered, administered_by, status, notes'
    //     )
    //     ->leftJoin('chicken', 'vaccination_records.chickenID', '=', 'chicken.chickenID') // Use LEFT JOIN to ensure all records are included
    //     ->groupBy(
    //         'chicken.cageID',
    //         'chicken.breedID',
    //         'vaccinationplanID',
    //         'date_administered',
    //         'administered_by',
    //         'status',
    //         'notes'
    //     )
    //     ->get();

    //     dd($vaccinationRecordsGrouped);

    //     return view('vaccinationRecordManagement', compact('vaccinationRecordsGrouped'));
    // }


    public function index()
    {
        // Retrieve all chickens with related vaccination records grouped by cage and breed
        $chickens = Chicken::with([
            'breed',
            'cage',
            'vaccinationRecords.vaccinationplan.vaccinationType',
            'vaccinationRecords.user',
        ])->get();

        // Group chickens by cageID and then by breedID
        $vaccinationRecordsGrouped = $chickens->groupBy('cageID')->map(function ($cageGroup) {
            return $cageGroup->groupBy('breedID');
        });

        // Retrieve all breeds for the upgrade functionality
        $breeds = ChickenBreeds::all();
        
        // Pass grouped chickens and available breeds to the view
        return view('vaccinationRecordManagement',
            compact('vaccinationRecordsGrouped', 'breeds')
        );
    }




    // Show the form for creating a new vaccination record
    public function create()
    {
        $cages = Cage::with(['chickens.breed'])->get(); // List all cages
        $vaccinationPlans = VaccinationPlan::all(); // List all vaccination plans
        $employees = User::where('roleID', 2)->get(); // Assuming roleID 2 is for employees

        return view('addVaccinationRecord', compact('cages','vaccinationPlans', 'employees'));
    }


    // Store a new vaccination record
    public function store(Request $request)
    {
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

        // Retrieve the vaccination plan to get the ageThreshold
        $vaccinationPlan = VaccinationPlan::findOrFail($request->input('vaccinationplanID'));

        if (!$vaccinationPlan || !$vaccinationPlan->ageThreshold) {
            return back()->withErrors('Vaccination plan does not have a valid age threshold.');
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
    }

    // Show the form for editing a vaccination record
    public function edit($id)
    {
        $vaccinationRecord = VaccinationRecords::findOrFail($id);
        $chickens = Chicken::all();
        $vaccinationPlans = VaccinationPlan::all();
        $employees = User::where('roleID', 2)->get();

        return view('updateVaccinationRecord', compact('vaccinationRecord', 'chickens', 'vaccinationPlans', 'employees'));
    }

    // Update an existing vaccination record
    public function update(Request $request, $id)
    {
        $request->validate([
            'chickenID' => 'required|exists:chicken,chickenID',
            'vaccinationplanID' => 'required|exists:vaccinationplan,vaccinationplanID',
            'date_administered' => 'required|date',
            'administered_by' => 'required|exists:users,userID',
            'status' => 'required|in:completed,pending,skipped',
            'notes' => 'nullable|string',
        ]);

        $vaccinationRecord = VaccinationRecords::findOrFail($id);
        $vaccinationRecord->update($request->all());

        return redirect()->route('vaccination_records.index')->with('success', 'Vaccination record updated successfully.');
    }

    public function editGroup(Request $request)
    {
        $cageID = $request->input('cageID');
        $breedID = $request->input('breedID');

        // Retrieve all vaccination records for the specified cage and breed
        $vaccinationRecords = VaccinationRecords::with(['chicken.breed', 'chicken.cage', 'vaccinationplan.vaccinationType', 'user'])
        ->whereHas('chicken', function ($query) use ($cageID, $breedID) {
            $query->where('cageID', $cageID)->where('breedID', $breedID);
        })
        ->get();

        // Fetch related data for dropdowns or reference
        $cages = Cage::all();
        $breeds = ChickenBreeds::all();
        $vaccinationPlans = VaccinationPlan::all();

        return view('updateVaccinationRecord',
            compact('vaccinationRecords', 'cages', 'breeds', 'vaccinationPlans', 'cageID', 'breedID')
        );
    }

    public function updateGroup(Request $request)
    {
        $request->validate([
            'breedID' => 'required|exists:chickenbreeds,breedID',
            'new_breedID' => 'required|exists:chickenbreeds,breedID',
            'vaccinationplanID' => 'required|exists:vaccinationplan,vaccinationplanID',
            'status' => 'required|in:pending,completed,in_progress',
            'notes' => 'nullable|string',
        ]);

        // Retrieve the vaccination plan to get the ageThreshold
        $vaccinationPlan = VaccinationPlan::findOrFail($request->input('vaccinationplanID'));

        if (!$vaccinationPlan || !$vaccinationPlan->ageThreshold) {
            return back()->withErrors('Vaccination plan does not have a valid age threshold.');
        }

        $ageThreshold = $vaccinationPlan->ageThreshold; // Age in weeks

        // Find all chickens in the specified cage and breed
        $chickens = Chicken::where('cageID', $request->input('cageID'))
        ->where('breedID', $request->input('breedID'))
        ->get();

        // Update vaccination records for each chicken in the group
        foreach ($chickens as $chicken) {
            // Recalculate the date_administered based on the chicken's dob and ageThreshold
            $dateAdministered = \Carbon\Carbon::parse($chicken->dob)->addDays($ageThreshold)->toDateString();

            VaccinationRecords::where('chickenID', $chicken->chickenID)->update([
                'vaccinationplanID' => $request->input('vaccinationplanID'),
                'date_administered' => $dateAdministered,
                'status' => $request->input('status'),
                'notes' => $request->input('notes'),
            ]);
        }

        // Optionally update the chickens' breed
        Chicken::where('cageID', $request->input('cageID'))
        ->where('breedID', $request->input('breedID'))
        ->update([
            'breedID' => $request->input('new_breedID'),
        ]);

        return redirect()->route('vaccination_records.index')->with('success', 'Vaccination records updated successfully for the group.');
    }


    // Delete a vaccination record
    public function destroy($id)
    {
        $vaccinationRecord = VaccinationRecords::findOrFail($id);
        $vaccinationRecord->delete();

        return redirect()->route('vaccination_records.index')->with('success', 'Vaccination record deleted successfully.');
    }

    public function upgradeGroup(Request $request)
    {
        $request->validate([
            'cageID' => 'required|exists:cage,cageID',
            'breedID' => 'required|exists:chickenbreeds,breedID',
            'new_breedID' => 'required|exists:chickenbreeds,breedID',
        ]);

        // Update all chickens in the specified group
        Chicken::where('cageID', $request->input('cageID'))
        ->where('breedID', $request->input('breedID'))
        ->update(['breedID' => $request->input('new_breedID')]);

        return redirect()->route('vaccination_records.index')->with('success', 'Chickens in the group upgraded successfully.');
    }



    public function deleteGroup(Request $request)
    { 
        $request->validate([
            'cageID' => 'required|exists:cage,cageID',
            'breedID' => 'required|exists:chickenbreeds,breedID',
        ]);

        // Find all chickens in the specified cage and breed
        $chickens = Chicken::where('cageID', $request->input('cageID'))
        ->where('breedID', $request->input('breedID'))
        ->get();

        // Loop through chickens and delete related vaccination records
        foreach ($chickens as $chicken) {
            VaccinationRecords::where('chickenID', $chicken->chickenID)->where('date_administered', $request->input('date_administered'))->delete();
        }

        return redirect()->route('vaccination_records.index')->with('success', 'Vaccination records deleted successfully for the group.');
    }



    public function destroyGroup(Request $request)
    {
        $request->validate([
            'cageID' => 'required|exists:cage,cageID',
            'breedID' => 'required|exists:chickenbreeds,breedID',
        ]);

        $cageID = $request->input('cageID');
        $breedID = $request->input('breedID');

        // Delete all vaccination records for the specified cage and breed
        VaccinationRecords::whereHas('chicken', function ($query) use ($cageID, $breedID) {
            $query->where('cageID', $cageID)->where('breedID', $breedID);
        })->delete();

        return redirect()->route('vaccination_records.index')->with('success', 'Vaccination group deleted successfully.');
    }

    public function listVaccinationRecords(Request $request)
    {
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
    }

    public function updateSelectedVaccinationRecords(Request $request)
    {
        // Validate the request
        $request->validate([
            'selected_groups' => 'required|array', // Expect an array of selected groups
            'selected_groups.*.cageID' => 'required|exists:cage,cageID',
            'selected_groups.*.breedID' => 'required|exists:chickenbreeds,breedID',
            'selected_groups.*.vaccinationplanID' => 'required|exists:vaccinationplan,vaccinationplanID',
            'selected_groups.*.date_administered' => 'required|date',
            'status' => 'required|in:pending,completed',
            'notes' => 'nullable|string',
        ]);

        foreach ($request->input('selected_groups') as $group) {
            // Retrieve chicken IDs based on the conditions
            $chickens = Chicken::where('cageID', $group['cageID'])
                ->where('breedID', $group['breedID'])
                ->pluck('chickenID');

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
    }



}
