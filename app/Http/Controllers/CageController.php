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
            'name' => 'required|string|max:255|unique:cage,name',
            'width' => 'required|numeric|min:0.1',
            'length' => 'required|numeric|min:0.1',
            'height' => 'required|numeric|min:0.1',
            'capacity' => 'required|integer|min:1',
            'type' => 'required|string',
            'status' => 'required|string|in:Active,Inactive,Maintenance',
            'availability' => 'required|integer|min:0|max:1',
        ]);

        try {
            $size = "{$request->input('width')} x {$request->input('length')} x {$request->input('height')}";

            Cage::create([
                'name' => $request->input('name'),
                'size' => $size,
                'capacity' => $request->input('capacity'),
                'type' => $request->input('type'),
                'status' => $request->input('status'),
                'availability' => $request->input('availability'),
            ]);

            return redirect()->route('cages.index')->with('success', 'Cage added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while adding the cage. Please try again.']);
        }
    }

    // Show the form to edit an existing cage
    public function edit($cageID)
    {
        $cage = Cage::findOrFail($cageID);

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

        try {
            $cage = Cage::findOrFail($request->input('cageID'));
            $size = "{$request->input('width')} x {$request->input('length')} x {$request->input('height')}";

            $cage->update([
                'name' => $request->input('name'),
                'size' => $size,
                'capacity' => $request->input('capacity'),
                'type' => $request->input('type'),
                'status' => $request->input('status'),
            ]);

            return redirect()->route('cages.index')->with('success', 'Cage updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while updating the cage. Please try again.']);
        }
    }

    public function showDelete($cageID)
    {
        try {
            $cage = Cage::findOrFail($cageID);
            $chickens = Chicken::where('cageID', $cageID)->get();
            $eggs = Egg::where('cageID', $cageID)->get();
            $cageSchedules = CageSchedule::where('cageID', $cageID)->get();

            return view('deleteCage', compact('cage', 'chickens', 'eggs','cageSchedules'));
        } catch (\Exception $e) {
            return redirect()->route('cages.index')->withErrors(['error' => 'An error occurred while retrieving cage details.']);
        }
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'cageID' => 'required|exists:cage,cageID',
        ]);

        try {
            $cageID = $request->input('cageID');
            $cage = Cage::findOrFail($cageID);

            Chicken::where('cageID', $cageID)->delete();
            Egg::where('cageID', $cageID)->delete();
            VaccinationPlan::where('cageID', $cageID)->delete();
            CageSchedule::where('cageID', $cageID)->delete();

            $cage->delete();

            return redirect()->route('cages.index')->with('success', 'Cage and all related data deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while deleting the cage. Please try again.']);
        }
    }
}
