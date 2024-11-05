<?php

namespace App\Http\Controllers;

use App\Models\FeedingPlan;
use App\Models\CageSchedule;
use Illuminate\Http\Request;
use App\Models\TaskScheduling;
use App\Models\AssignedEmployee;
use Illuminate\Support\Facades\Log;


class FeedingPlanController extends Controller
{

    // Display a listing of collection plans
    public function index()
    {
        $feedingPlans = FeedingPlan::paginate(10); // Adjust the number as needed
        return view('feedingPlanManagement', compact('feedingPlans'));
    }

    // Show the form for creating a new collection plan
    public function create()
    {
        return view('addFeedingPlan');
    }

    // Store a newly created feeding plan in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'time' => 'required|date_format:H:i:s',
            'frequency' => 'required|string|max:255',
            'repeat' => 'required|int'
        ]);

        FeedingPlan::create($validated);

        return redirect()->route('feedingplan.index')->with('success', 'Feeding plan created successfully.');
    }

    // Display the specified feeding plan
    public function show(FeedingPlan $feedingPlan)
    {
        return view('feedingplan.show', compact('feedingPlan'));
    }

    // Show the form for editing the specified feeding plan
    public function edit($feedingplanID)
    {

        $feedingPlan = FeedingPlan::findOrFail($feedingplanID);

        return view('updateFeedingPlan', compact('feedingPlan'));
    }

    // Update the specified collection plan in the database
    public function update(Request $request)
    {
        $request->validate([
            // 'time' => 'required|date_format:H:i:s',
            'frequency' => 'required|string|max:255',
            'repeat' => 'required|boolean'
        ]);

        $id = $request->input('feedingplanID');

        // Process the time input
        $time = $request->input('time');
        if (strlen($time) === 5) {
            $time .= ':00'; // Add seconds if not present
        }

        // Update the collection plan using the update method
        FeedingPlan::where('feedingplanID', $id)->update([
            'time' => $time,
            'frequency' => $request->input('frequency'),
            'repeat' => $request->input('repeat')
        ]);

        return redirect()->route('feedingplan.index')->with('success', 'Feeding plan updated successfully.');
    }

    public function showDelete($feedingplanID)
    {

        $plan = FeedingPlan::findOrFail($feedingplanID);
        return view('/deleteFeedingPlan', compact('plan'));
    }


    public function destroy(Request $request)
    {
        try {
            $id = $request->input('feedingplanID');
            Log::info("Attempting to delete FeedingPlan with ID: $id");

            // Find the feeding plan by ID
            $feedingPlan = FeedingPlan::findOrFail($id);
            $feedingPlan->delete();

            // Get all tasks associated with this feeding plan
            $tasks = TaskScheduling::where('feedingplanID', $id)->get();

            foreach ($tasks as $task) {
                Log::info("Deleting records associated with Task ID: " . $task->scheduleID);
                AssignedEmployee::where('scheduleID', $task->scheduleID)->delete();
                CageSchedule::where('scheduleID', $task->scheduleID)->delete();
            }

            // Delete all associated tasks in taskscheduling
            TaskScheduling::where('feedingplanID', $id)->delete();
            Log::info("Associated tasks deleted.");

            FeedingPlan::where('feedingplanID', $id)->delete();
            Log::info("FeedingPlan with ID $id deleted successfully.");

            return redirect()->route('feedingplan.index')->with('success', 'Feeding plan deleted successfully.');
        } catch (\Exception $e) {
            Log::error("Failed to delete Feeding Plan: " . $e->getMessage());
            return response()->json(['error' => 'Failed to delete Feeding Plan: ' . $e->getMessage()], 500);
        }
    }

}
