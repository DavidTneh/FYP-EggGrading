<?php

namespace App\Http\Controllers;

use App\Models\VaccinationPlan;
use App\Models\VaccinationType;
use App\Models\Cage;
use Illuminate\Http\Request;

class VaccinationPlanController extends Controller
{
    // Display the list of vaccination plans with pagination
    public function index()
    {
        $vaccinationPlans = VaccinationPlan::with(['cage', 'vaccinationtype'])->paginate(10);
        // dd($vaccinationPlans);
        return view('vaccinationplanManagement', compact('vaccinationPlans'));
    }


    // Show the form to create a new vaccination plan
    public function create()
    {
        $vaccinationTypes = VaccinationType::all();
        $cages = Cage::all();
        return view('addVaccinationPlan', compact('vaccinationTypes', 'cages'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'vaccinationtypeID' => 'required|exists:vaccinationtype,vaccinationtypeID',
            'vaccinationPerChicken' => 'required|integer|min:1',
            'cageID' => 'required|integer|exists:cage,cageID',
            'date' => 'required|date',
        ]);

        // Retrieve the selected cage
        $cage = Cage::withCount('chickens')->findOrFail($request->input('cageID'));

        // Calculate total vaccinations required
        $totalVaccinationRequired = $cage->chickens_count * $request->input('vaccinationPerChicken');
        
        // Create a new VaccinationPlan with calculated totalVaccinationRequired
        VaccinationPlan::create([
            'vaccinationtypeID' => $request->input('vaccinationtypeID'),
            'vaccinationPerChicken' => $request->input('vaccinationPerChicken'),
            'cageID' => $request->input('cageID'),
            'totalVaccinationRequired' => $totalVaccinationRequired,
            'date' => $request->input('date')
        ]);

        return redirect()->route('vaccinationplan.index')->with('success', 'Vaccination Plan added successfully.');
    }

    public function edit($vaccinationplanID)
    {
        $plan = VaccinationPlan::findOrFail($vaccinationplanID);
        $vaccinationTypes = VaccinationType::all();
        $cages = Cage::all();

        return view('updateVaccinationPlan', compact('plan', 'vaccinationTypes', 'cages'));
    }

    public function update(Request $request) 
    {
        $request->validate([
            'vaccinationplanID' => 'required|exists:vaccinationplan,vaccinationplanID',
            'vaccinationtypeID' => 'required|exists:vaccinationtype,vaccinationtypeID',
            'vaccinationPerChicken' => 'required|integer|min:1',
            'cageID' => 'required|integer|exists:cage,cageID',
            'date' => 'required|date',
        ]);

        $plan = VaccinationPlan::findOrFail($request->input('vaccinationplanID'));

        // Retrieve the selected cage and count the chickens in it
        $cage = Cage::withCount('chickens')->findOrFail($request->input('cageID'));

        // Calculate the total vaccinations required
        $totalVaccinationRequired = $cage->chickens_count * $request->input('vaccinationPerChicken');

        // Update the vaccination plan with the new values

        $id = $request->input('vaccinationplanID');

        VaccinationPlan::where('vaccinationplanID',$id)->update([
            'vaccinationtypeID' => $request->input('vaccinationtypeID'),
            'vaccinationPerChicken' => $request->input('vaccinationPerChicken'),
            'cageID' => $request->input('cageID'),
            'totalVaccinationRequired' => $totalVaccinationRequired,
            'date' => $request->input('date')
        ]);

        return redirect()->route('vaccinationplan.index')->with('success', 'Vaccination Plan updated successfully.');
    }

    public function showDelete($vaccinationplanID)
    {
        $plan = VaccinationPlan::with(['vaccinationType', 'cage'])->findOrFail($vaccinationplanID);
        return view('deleteVaccinationPlan', compact('plan'));
    }

    public function destroy(Request $request)
    {
        $plan = VaccinationPlan::findOrFail($request->input('vaccinationplanID'));

        $id = $request->input('vaccinationplanID');
        if($plan){
            VaccinationPlan::where('vaccinationplanID',$id)->delete();
        }

        return redirect()->route('vaccinationplan.index')->with('success', 'Vaccination Plan deleted successfully.');
    }
}
