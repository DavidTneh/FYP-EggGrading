<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CullingPlan;

class CullingPlanController extends Controller
{
    // Display a listing of culling plans
    public function index()
    {
        $cullingPlans = CullingPlan::paginate(10); // Adjust the number as needed
        return view('cullingPlanManagement', compact('cullingPlans'));
    }

    // Show the form for creating a new culling plan
    public function create()
    {
        return view('addCullingPlan');
    }

    // Store a newly created culling plan in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'eliminateAgeThreshold' => 'required|integer',
            'reasons' => 'required|string',
            'healthStatus' => 'required|string|max:255',
            'notes' => 'nullable|string'
        ]);

        CullingPlan::create($validated);

        return redirect()->route('cullingplan.index')->with('success', 'Culling plan created successfully.');
    }

    // Display the specified culling plan
    public function show(CullingPlan $cullingPlan)
    {
        return view('cullingplan.show', compact('cullingPlan'));
    }

    // Show the form for editing the specified culling plan
    public function edit($cullingplanID)
    {
        $cullingPlan = CullingPlan::findOrFail($cullingplanID);
        return view('updateCullingPlan', compact('cullingPlan'));
    }

    // Update the specified culling plan in the database
    public function update(Request $request)
    {
        $request->validate([
            'eliminateAgeThreshold' => 'required|integer',
            'reasons' => 'required|string',
            'healthStatus' => 'required|string|max:255',
            'notes' => 'nullable|string'
        ]);

        $id = $request->input('cullingplanID');

        // Update the culling plan
        CullingPlan::where('cullingplanID', $id)->update([
            'eliminateAgeThreshold' => $request->input('eliminateAgeThreshold'),
            'reasons' => $request->input('reasons'),
            'healthStatus' => $request->input('healthStatus'),
            'notes' => $request->input('notes')
        ]);

        return redirect()->route('cullingplan.index')->with('success', 'Culling plan updated successfully.');
    }

    // Show confirmation page for deleting the specified culling plan
    public function showDelete($cullingplanID)
    {
        $plan = CullingPlan::findOrFail($cullingplanID);
        return view('deleteCullingPlan', compact('plan'));
    }

    // Delete the specified culling plan from the database
    public function destroy(Request $request)
    {
        $id = $request->input('cullingplanID');
        CullingPlan::where('cullingplanID', $id)->delete();

        return redirect()->route('cullingplan.index')->with('success', 'Culling plan deleted successfully.');
    }
}
