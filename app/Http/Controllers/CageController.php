<?php

namespace App\Http\Controllers;

use App\Models\Egg;
use App\Models\Cage;
use App\Models\Chicken;
use App\Models\CageSchedule;
use Illuminate\Http\Request;
use App\Models\VaccinationPlan;

class CageController extends Controller
{
    // Display the list of cages with pagination
    public function index()
    {
        $cages = Cage::paginate(10);
        return view('cageManagement', compact('cages'));
    }

    // Show the form to create a new cage
    public function create()
    {
        return view('addCage');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'width' => 'required|numeric|min:0.1',
            'length' => 'required|numeric|min:0.1',
            'height' => 'required|numeric|min:0.1',
            'capacity' => 'required|integer|min:1',
            'type' => 'required|string',
            'status' => 'required|string',
            'availability' => 'required|int',
        ]);

        // Combine width, length, and height into a single formatted string
        $size = "{$request->input('width')} x {$request->input('length')} x {$request->input('height')}";

        Cage::create([
            'name' => $request->input('name'),
            'size' => $size, // Store combined dimensions in size column
            'capacity' => $request->input('capacity'),
            'type' => $request->input('type'),
            'status' => $request->input('status'),
            'availability' => $request->input('availability'),
        ]);

        return redirect()->route('cages.index')->with('success', 'Cage added successfully.');
    }


    // Show the form to edit an existing cage
    public function edit($cageID)
    {
        $cage = Cage::findOrFail($cageID);

        // Split the 'size' column value (e.g., "2 x 3 x 4") into width, length, and height
        $dimensions = explode(' x ', $cage->size);
        $width = $dimensions[0] ?? '';
        $length = $dimensions[1] ?? '';
        $height = $dimensions[2] ?? '';

        return view('updateCage', compact('cage', 'width', 'length', 'height'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'cageID' => 'required|exists:cage,cageID',
            'name' => 'required|string|max:255',
            'width' => 'required|numeric|min:0.1',
            'length' => 'required|numeric|min:0.1',
            'height' => 'required|numeric|min:0.1',
            'capacity' => 'required|integer|min:1',
            'type' => 'required|string|max:255',
            'status' => 'required|string|in:Active,Inactive,Maintenance',
        ]);

        $cage = Cage::findOrFail($request->input('cageID'));

        // Combine width, length, and height into the size column
        $size = "{$request->input('width')} x {$request->input('length')} x {$request->input('height')}";

        $cage->update([
            'name' => $request->input('name'),
            'size' => $size,
            'capacity' => $request->input('capacity'),
            'type' => $request->input('type'),
            'status' => $request->input('status'),
        ]);

        return redirect()->route('cages.index')->with('success', 'Cage updated successfully.');
    }


    public function showDelete($cageID)
    {
        $cage = Cage::findOrFail($cageID);

        // Retrieve related data
        $chickens = Chicken::where('cageID', $cageID)->get();
        $eggs = Egg::where('cageID', $cageID)->get();
        $vaccinationPlans = VaccinationPlan::where('cageID', $cageID)->get();
        $cageSchedules = CageSchedule::where('cageID', $cageID)->get();

        // Pass the cage and related data to the view
        return view('deleteCage', compact('cage', 'chickens', 'eggs', 'vaccinationPlans', 'cageSchedules'));
    }

    public function destroy(Request $request)
    {
        $cageID = $request->input('cageID');
        $cage = Cage::findOrFail($cageID);

        // Manually delete related data in all tables that have a foreign key constraint on `cageID`
        Chicken::where('cageID', $cageID)->delete();
        Egg::where('cageID', $cageID)->delete();
        VaccinationPlan::where('cageID', $cageID)->delete();
        CageSchedule::where('cageID', $cageID)->delete();

        $cage->delete();

        // Redirect back to the cages list with a success message
        return redirect()->route('cages.index')->with('success', 'Cage and all related data deleted successfully.');
    }



}
