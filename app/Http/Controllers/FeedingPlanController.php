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
    public function index()
    {
        $feedingPlans = FeedingPlan::paginate(10); // Adjust the number as needed
        return view('feedingPlanManagement', compact('feedingPlans'));
    }

    public function create()
    {
        return view('addFeedingPlan');
    }

    public function store(Request $request)
    {   
        $validated = $request->validate([
            'time' => 'required|date_format:H:i:s',
            'frequency' => 'required|string|max:255',
            'is_repeating' => 'required|boolean',
        ]);
        
        FeedingPlan::create($validated);

        return redirect()->route('feedingplan.index')->with('success', 'Feeding plan created successfully.');
    }

    public function show(FeedingPlan $feedingPlan)
    {
        return view('feedingplan.show', compact('feedingPlan'));
    }

    public function edit($feedingplanID)
    {
        $feedingPlan = FeedingPlan::findOrFail($feedingplanID);

        return view('updateFeedingPlan', compact('feedingPlan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            // 'time' => 'required|date_format:H:i:s',
            'frequency' => 'required|string|max:255',
            'is_repeating' => 'required|boolean',    
        ]);
        
        $id = $request->input('feedingplanID');

        // Process the time input
        $time = $request->input('time');
        if (strlen($time) === 5) {
            $time .= ':00'; // Add seconds if not present
        }
        
        FeedingPlan::where('feedingplanID', $id)->update([
            'time' => $time,
            'frequency' => $request->input('frequency'),
            'is_repeating' => $request->input('is_repeating')
        ]);

        return redirect()->route('feedingplan.index')->with('success', 'Feeding plan updated successfully.');
    }

    public function showDelete($feedingplanID)
    {
        $plan = FeedingPlan::findOrFail($feedingplanID);

        $tasks = TaskScheduling::where('feedingplanID', $feedingplanID)->get();

        $relatedData = [];
        foreach ($tasks as $task) {
            $relatedData[] = [
                'task' => $task,
                'assignedEmployees' => AssignedEmployee::where('scheduleID', $task->scheduleID)->get(),
                'cageSchedules' => CageSchedule::where('scheduleID', $task->scheduleID)->get(),
            ];
        }

        return view('deleteFeedingPlan', compact('plan', 'tasks', 'relatedData'));
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->input('feedingplanID');
            Log::info("Attempting to delete FeedingPlan with ID: $id");

            $tasks = TaskScheduling::where('feedingplanID', $id)->get();

            foreach ($tasks as $task) {
                Log::info("Deleting records associated with Task ID: " . $task->scheduleID);
                AssignedEmployee::where('scheduleID', $task->scheduleID)->delete();
                CageSchedule::where('scheduleID', $task->scheduleID)->delete();
            }

            TaskScheduling::where('feedingplanID', $id)->delete();

            $feedingPlan = FeedingPlan::findOrFail($id);
            $feedingPlan->delete();
            Log::info("Associated tasks deleted.");

            return redirect()->route('feedingplan.index')->with('success', 'Feeding plan deleted successfully.');
        } catch (\Exception $e) {
            Log::error("Failed to delete Feeding Plan: " . $e->getMessage());
            return response()->json(['error' => 'Failed to delete Feeding Plan: ' . $e->getMessage()], 500);
        }
    }
}
