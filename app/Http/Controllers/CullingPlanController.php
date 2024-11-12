<?php

namespace App\Http\Controllers;

use App\Models\CullingPlan;
use App\Models\CageSchedule;
use Illuminate\Http\Request;
use App\Models\TaskScheduling;
use App\Models\AssignedEmployee;
use Illuminate\Support\Facades\Log;

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

        // Fetch all related tasks, assigned employees, and cage schedules
        $tasks = TaskScheduling::where('cullingplanID', $cullingplanID)->get();

        $relatedData = [];
        foreach ($tasks as $task) {
            $relatedData[] = [
                'task' => $task,
                'assignedEmployees' => AssignedEmployee::where('scheduleID', $task->scheduleID)->get(),
                'cageSchedules' => CageSchedule::where('scheduleID', $task->scheduleID)->get(),
            ];
        }

        return view('deleteCullingPlan', compact('plan', 'tasks', 'relatedData'));
    }

    // Delete the specified culling plan from the database
    public function destroy(Request $request)
    {
        try {
            $id = $request->input('cullingplanID');
            Log::info("Attempting to delete CullingPlan with ID: $id");

            // Find the culling plan by ID
            $cullingPlan = CullingPlan::findOrFail($id);
            $cullingPlan->delete();

            // Get all tasks associated with this culling plan
            $tasks = TaskScheduling::where('cullingplanID', $id)->get();

            foreach ($tasks as $task) {
                Log::info("Deleting records associated with Task ID: " . $task->scheduleID);
                AssignedEmployee::where('scheduleID', $task->scheduleID)->delete();
                CageSchedule::where('scheduleID', $task->scheduleID)->delete();
            }

            // Delete all associated tasks in taskscheduling
            TaskScheduling::where('cullingplanID', $id)->delete();
            Log::info("Associated tasks deleted.");

            CullingPlan::where('cullingplanID', $id)->delete();
            Log::info("CullingPlan with ID $id deleted successfully.");

            return redirect()->route('cullingplan.index')->with('success', 'Culling plan deleted successfully.');
        } catch (\Exception $e) {
            Log::error("Failed to delete Culling Plan: " . $e->getMessage());
            return response()->json(['error' => 'Failed to delete Culling Plan: ' . $e->getMessage()], 500);
        }
    }
}
