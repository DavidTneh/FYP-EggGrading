<?php

namespace App\Http\Controllers;

use App\Models\CageSchedule;
use Illuminate\Http\Request;
use App\Models\CollectionPlan;
use App\Models\TaskScheduling;
use App\Models\AssignedEmployee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CollectionPlanController extends Controller
{
    // Display a listing of collection plans
    public function index()
    {
        $collectionPlans = CollectionPlan::paginate(10); // Adjust the number as needed
        return view('collectionPlanManagement', compact('collectionPlans'));
    }

    // Show the form for creating a new collection plan
    public function create()
    {
        return view('addCollectionPlan');
    } 

    // Store a newly created collection plan in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'time' => 'required|date_format:H:i:s',
            'frequency' => 'required|string|max:255',
            'repeat' => 'required|int'
        ]);

        CollectionPlan::create($validated);

        return redirect()->route('collectionplan.index')->with('success', 'Collection plan created successfully.');
    }

    // Display the specified collection plan
    public function show(CollectionPlan $collectionPlan)
    {
        return view('collectionplan.show', compact('collectionPlan'));
    }

    // Show the form for editing the specified collection plan
    public function edit($collectionplanID)
    {

        $collectionPlan = CollectionPlan::findOrFail($collectionplanID);

        return view('updateCollectionPlan', compact('collectionPlan'));
    }

    // Update the specified collection plan in the database
    public function update(Request $request)
    {
        $request->validate([
            // 'time' => 'required|date_format:H:i:s',
            'frequency' => 'required|string|max:255',
            'repeat' => 'required|boolean'
        ]);

        $id = $request->input('collectionplanID');

        // Process the time input
        $time = $request->input('time');
        if (strlen($time) === 5) {
            $time .= ':00'; // Add seconds if not present
        }

        // Update the collection plan using the update method
        CollectionPlan::where('collectionplanID', $id)->update([
            'time' => $time,
            'frequency' => $request->input('frequency'),
            'repeat' => $request->input('repeat')
        ]);

        return redirect()->route('collectionplan.index')->with('success', 'Collection plan updated successfully.');
    }

    public function showDelete($collectionplanID)
    {
        $plan = CollectionPlan::findOrFail($collectionplanID);

        // Fetch all related tasks, assigned employees, and cage schedules
        $tasks = TaskScheduling::where('collectionplanID', $collectionplanID)->get();

        // Fetch all assigned employees and cage schedules for each related task
        $relatedData = [];
        foreach ($tasks as $task) {
            $relatedData[] = [
                'task' => $task,
                'assignedEmployees' => AssignedEmployee::where('scheduleID', $task->scheduleID)->get(),
                'cageSchedules' => CageSchedule::where('scheduleID', $task->scheduleID)->get(),
            ];
        }

        return view('deleteCollectionPlan', compact('plan', 'tasks', 'relatedData'));
    }



    public function destroy(Request $request)
    {
        try {
            $id = $request->input('collectionplanID');
            Log::info("Attempting to delete CollectionPlan with ID: $id");

            // Find the collection plan by ID
            $collectionPlan = CollectionPlan::findOrFail($id);
            $collectionPlan->delete();
            // Get all tasks associated with this collection plan
            $tasks = TaskScheduling::where('collectionplanID', $id)->get();

            foreach ($tasks as $task) {
                Log::info("Deleting records associated with Task ID: " . $task->scheduleID);
                AssignedEmployee::where('scheduleID', $task->scheduleID)->delete();
                CageSchedule::where('scheduleID', $task->scheduleID)->delete();
            }

            // Delete all associated tasks in taskscheduling
            TaskScheduling::where('collectionplanID', $id)->delete();
            Log::info("Associated tasks deleted.");

            CollectionPlan::where('collectionplanID', $id)->delete();

            Log::info("CollectionPlan with ID $id deleted successfully.");

            return redirect()->route('collectionplan.index')->with('success', 'Collection plan deleted successfully.');
        } catch (\Exception $e) {
            Log::error("Failed to delete Collection Plan: " . $e->getMessage());
            return response()->json(['error' => 'Failed to delete Collection Plan: ' . $e->getMessage()], 500);
        }
    }


}
