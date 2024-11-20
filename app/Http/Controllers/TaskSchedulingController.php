<?php

namespace App\Http\Controllers;

use App\Models\CullingPlan;
use App\Models\FeedingPlan;
use Illuminate\Http\Request;
use App\Models\CollectionPlan;
use App\Models\TaskScheduling;

class TaskSchedulingController extends Controller
{

    // List all task schedulings
    public function index()
    {
        $taskSchedulings = TaskScheduling::paginate(10);
        return view('taskSchedulingManagement', compact('taskSchedulings'));
    }

    public function view(Request $request)
    {
        $request->validate([
            'scheduleID' => 'required|exists:taskscheduling,scheduleID',
        ]);

        $scheduleID = $request->input('scheduleID');

        // Fetch the main task scheduling
        $taskScheduling = TaskScheduling::findOrFail($scheduleID);

        $collectionPlanID = $taskScheduling->collectionplanID;
        $feedingPlanID = $taskScheduling->feedingplanID;
        $cullingPlanID = $taskScheduling->cullingplanID;


        // Fetch related data manually
        $collectionPlan = CollectionPlan::findOrFail($collectionPlanID);
        $feedingPlan = FeedingPlan::findOrFail($feedingPlanID);
        $cullingPlan = CullingPlan::findOrFail($cullingPlanID);

        // Pass all data separately
        return view('taskSchedulingDetails',
            compact('taskScheduling', 'collectionPlan', 'feedingPlan', 'cullingPlan')
        );
    }




    // Show the form for creating a new task scheduling
    public function create()
    {
        $collectionPlans = CollectionPlan::all();
        $feedingPlans = FeedingPlan::all();
        $cullingPlans = CullingPlan::all();
        return view('addTaskScheduling', compact('collectionPlans', 'feedingPlans', 'cullingPlans'));
    }

    // Store a new task scheduling
    public function store(Request $request)
    {
        $request->validate([
            'taskName' => 'required|string|max:255',
            'taskDescription' => 'required|string|max:1000',
            'collectionPlanID' => 'required|exists:collectionplan,collectionplanID',
            'feedingPlanID' => 'required|exists:feedingplan,feedingplanID',
            'cullingPlanID' => 'required|exists:cullingplan,cullingplanID',
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        TaskScheduling::create($request->all());

        return redirect()->route('task-schedulings.index')->with('success', 'Task Scheduling created successfully.');
    }

    // Show the form for editing a task scheduling
    public function edit(Request $request)
    {
        $scheduleID = $request->input('scheduleID');
        $taskScheduling = TaskScheduling::findOrFail($scheduleID);

        $collectionPlans = CollectionPlan::all();
        $feedingPlans = FeedingPlan::all();
        $cullingPlans = CullingPlan::all();

        return view('updateTaskScheduling', compact('taskScheduling', 'collectionPlans', 'feedingPlans', 'cullingPlans'));
    }

    // Update a task scheduling
    public function update(Request $request)
    {
        $request->validate([
            'scheduleID' => 'required|exists:taskscheduling,scheduleID',
            'taskName' => 'required|string|max:255',
            'taskDescription' => 'required|string|max:1000',
            'collectionPlanID' => 'required|exists:collectionplan,collectionplanID',
            'feedingPlanID' => 'required|exists:feedingplan,feedingplanID',
            'cullingPlanID' => 'required|exists:cullingplan,cullingplanID',
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        $taskScheduling = TaskScheduling::findOrFail($request->input('scheduleID'));

        $taskScheduling->update($request->except('scheduleID'));

        return redirect()->route('task-schedulings.index')->with('success', 'Task Scheduling updated successfully.');
    }

    public function showDelete(Request $request)
    {
        $request->validate([
            'scheduleID' => 'required|exists:taskscheduling,scheduleID',
        ]);

        $scheduleID = $request->input('scheduleID');

        // Fetch the task scheduling with associated plans manually
        $taskScheduling = TaskScheduling::findOrFail($scheduleID);

        // Manually fetch related plans
        $collectionPlan = CollectionPlan::find($taskScheduling->collectionplanID);
        $feedingPlan = FeedingPlan::find($taskScheduling->feedingplanID);
        $cullingPlan = CullingPlan::find($taskScheduling->cullingplanID);

        // Pass all data to the view
        return view('deleteTaskScheduling', compact('taskScheduling', 'collectionPlan', 'feedingPlan', 'cullingPlan'));
    }


    // Delete a task scheduling
    public function destroy(Request $request)
    {
        $scheduleID = $request->input('scheduleID');
        $taskScheduling = TaskScheduling::findOrFail($scheduleID);

        $taskScheduling->delete();

        return redirect()->route('task-schedulings.index')->with('success', 'Task Scheduling deleted successfully.');
    }
}
