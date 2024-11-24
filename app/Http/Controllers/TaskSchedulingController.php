<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cage;
use App\Models\User;
use App\Models\Chicken;
use App\Models\CullingPlan;
use App\Models\FeedingPlan;
use App\Models\CageSchedule;
use Illuminate\Http\Request;
use App\Models\CollectionPlan;
use App\Models\TaskScheduling;
use App\Models\AssignedEmployee;
use Illuminate\Support\Facades\DB;

class TaskSchedulingController extends Controller
{
    // List all task schedulings
    public function index()
    {
        $taskSchedulings = TaskScheduling::with(['assignedEmployees', 'cageSchedules'])->paginate(10);
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

        // Fetch related plans separately
        $collectionPlan = CollectionPlan::find($taskScheduling->collectionplanID);
        $feedingPlan = FeedingPlan::find($taskScheduling->feedingplanID);
        $cullingPlan = CullingPlan::find($taskScheduling->cullingplanID);

        // Fetch assigned employees separately
        $assignedEmployees = AssignedEmployee::where('scheduleID', $scheduleID)
        ->get()
        ->map(function ($assignedEmployee) {
            return User::find($assignedEmployee->userID);
        });

        // Fetch cage schedules separately
        $cageSchedules = CageSchedule::where('scheduleID', $scheduleID)
        ->get()
        ->map(function ($cageSchedule) {
            return Cage::find($cageSchedule->cageID);
        });

        return view('taskSchedulingDetails', compact(
            'taskScheduling',
            'collectionPlan',
            'feedingPlan',
            'cullingPlan',
            'assignedEmployees',
            'cageSchedules'
        ));
    }


    // Show the form for creating a new task scheduling
    public function create()
    {
        $collectionPlans = CollectionPlan::all();
        $feedingPlans = FeedingPlan::all();
        $cullingPlans = CullingPlan::all();
        $employees = User::all(); // Assuming 'User' is the Employee model
        $cages = Cage::all();

        return view('addTaskScheduling', compact('collectionPlans', 'feedingPlans', 'cullingPlans', 'employees', 'cages'));
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
            'assignedEmployees' => 'required|array',
            'assignedEmployees.*' => 'exists:user,userID',
            'cageSchedules' => 'required|array',
            'cageSchedules.*' => 'exists:cage,cageID',
        ]);

        // Create the main task scheduling record
        $taskScheduling = TaskScheduling::create($request->only([
            'taskName',
            'taskDescription',
            'collectionPlanID',
            'feedingPlanID',
            'cullingPlanID',
            'status'
        ]));

        // Assign employees
        foreach ($request->input('assignedEmployees') as $userID) {
            AssignedEmployee::create([
                'scheduleID' => $taskScheduling->scheduleID,
                'userID' => $userID,
            ]);
        }

        // Assign cages
        foreach ($request->input('cageSchedules') as $cageID) {
            CageSchedule::create([
                'scheduleID' => $taskScheduling->scheduleID,
                'cageID' => $cageID,
            ]);
        }

        return redirect()->route('task-schedulings.index')->with('success', 'Task Scheduling created successfully.');
    }

    // Show the form for editing a task scheduling
    public function edit(Request $request)
    {
        $scheduleID = $request->input('scheduleID');
        $taskScheduling = TaskScheduling::with(['assignedEmployees', 'cageSchedules'])->findOrFail($scheduleID);

        $collectionPlans = CollectionPlan::all();
        $feedingPlans = FeedingPlan::all();
        $cullingPlans = CullingPlan::all();
        $employees = User::all();
        $cages = Cage::all();

        return view('updateTaskScheduling', compact('taskScheduling', 'collectionPlans', 'feedingPlans', 'cullingPlans', 'employees', 'cages'));
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
            'assignedEmployees' => 'required|array',
            'assignedEmployees.*' => 'exists:user,userID',
            'cageSchedules' => 'required|array',
            'cageSchedules.*' => 'exists:cage,cageID',
        ]);

        $taskScheduling = TaskScheduling::findOrFail($request->input('scheduleID'));

        // Update main task scheduling record
        $taskScheduling->update($request->only([
            'taskName',
            'taskDescription',
            'collectionPlanID',
            'feedingPlanID',
            'cullingPlanID',
            'status'
        ]));

        // Update assigned employees
        AssignedEmployee::where('scheduleID', $taskScheduling->scheduleID)->delete();
        foreach ($request->input('assignedEmployees') as $userID) {
            AssignedEmployee::create([
                'scheduleID' => $taskScheduling->scheduleID,
                'userID' => $userID,
            ]);
        }

        // Update assigned cages
        CageSchedule::where('scheduleID', $taskScheduling->scheduleID)->delete();
        foreach ($request->input('cageSchedules') as $cageID) {
            CageSchedule::create([
                'scheduleID' => $taskScheduling->scheduleID,
                'cageID' => $cageID,
            ]);
        }

        return redirect()->route('task-schedulings.index')->with('success', 'Task Scheduling updated successfully.');
    }

    public function showDelete(Request $request)
    {
        $request->validate([
            'scheduleID' => 'required|exists:taskscheduling,scheduleID',
        ]);

        $scheduleID = $request->input('scheduleID');

        // Fetch the main task scheduling
        $taskScheduling = TaskScheduling::findOrFail($scheduleID);

        // Fetch related data separately
        $collectionPlan = CollectionPlan::find($taskScheduling->collectionplanID);
        $feedingPlan = FeedingPlan::find($taskScheduling->feedingplanID);
        $cullingPlan = CullingPlan::find($taskScheduling->cullingplanID);

        // Fetch assigned employees related to this task
        $assignedEmployees = AssignedEmployee::where('scheduleID', $scheduleID)
        ->get()
        ->map(function ($assigned) {
            return User::find($assigned->userID);
        });

        // Fetch cages related to this task
        $cageSchedules = CageSchedule::where('scheduleID', $scheduleID)
        ->get()
        ->map(function ($cageSchedule) {
            return Cage::find($cageSchedule->cageID);
        });

        // Pass data to the view
        return view('deleteTaskScheduling',
            compact(
                'taskScheduling',
                'collectionPlan',
                'feedingPlan',
                'cullingPlan',
                'assignedEmployees',
                'cageSchedules'
            )
        );
    }


    // Delete a task scheduling
    public function destroy(Request $request)
    {
        $scheduleID = $request->input('scheduleID');
        $taskScheduling = TaskScheduling::findOrFail($scheduleID);

        // Delete related data
        AssignedEmployee::where('scheduleID', $scheduleID)->delete();
        CageSchedule::where('scheduleID', $scheduleID)->delete();

        // Delete the main task scheduling record
        $taskScheduling->delete();

        return redirect()->route('task-schedulings.index')->with('success', 'Task Scheduling deleted successfully.');
    }

    public function showCalendar()
    {
        $startOfWeek = \Carbon\Carbon::now()->startOfWeek();
        $endOfWeek = \Carbon\Carbon::now()->endOfWeek();


        $tasks = DB::table('taskscheduling')
        ->join('cageschedule', 'taskscheduling.scheduleID', '=', 'cageschedule.scheduleID')
        ->join('cage', 'cageschedule.cageID', '=', 'cage.cageID')
        ->leftJoin('assignedemployee', 'taskscheduling.scheduleID', '=', 'assignedemployee.scheduleID')
        ->leftJoin('user', 'assignedemployee.userID', '=', 'user.userID')
        ->leftJoin('collectionplan', 'taskscheduling.collectionplanID', '=', 'collectionplan.collectionplanID')
        ->leftJoin('feedingplan', 'taskscheduling.feedingplanID', '=', 'feedingplan.feedingplanID')
        ->leftJoin('cullingplan', 'taskscheduling.cullingplanID', '=', 'cullingplan.cullingplanID')
        ->select(
            'taskscheduling.taskName',
            'taskscheduling.taskDescription',
            'taskscheduling.status',
            'cage.name as cageName',
            'user.name as employeeName',
            DB::raw('IFNULL(collectionplan.time, IFNULL(feedingplan.time, "N/A")) as taskTime'),
            DB::raw('IFNULL(collectionplan.frequency, IFNULL(feedingplan.frequency, "N/A")) as taskFrequency'),
            DB::raw('IFNULL(cullingplan.eliminateAgeThreshold, "N/A") as cullingCriteria'),
            'cageschedule.created_at as scheduleDate'
        )
        ->whereBetween('cageschedule.created_at', [$startOfWeek, $endOfWeek])
        ->orderBy('scheduleDate', 'asc')
        ->get();


        return view('calender', compact('tasks'));
    }


    public function getCalendarData()
    {
        $tasks = TaskScheduling::with(['collectionPlan', 'feedingPlan', 'cullingPlan', 'cageSchedules.cage', 'cageSchedules.cage.chickens'])->get();

        $events = [];

        foreach ($tasks as $task) {
            if ($task->collectionPlan) {
                $events[] = [
                    'title' => 'Collection: ' . $task->taskName,
                    'start' => Carbon::parse($task->created_at)->toDateString() . ' ' . $task->collectionPlan->time,
                    'backgroundColor' => '#007bff', // Blue for collection
                    'textColor' => '#ffffff', // White text
                    'description' => $task->taskDescription,
                ];
            }

            if ($task->feedingPlan) {
                $events[] = [
                    'title' => 'Feeding: ' . $task->taskName,
                    'start' => Carbon::parse($task->created_at)->toDateString() . ' ' . $task->feedingPlan->time,
                    'backgroundColor' => '#28a745', // Green for feeding
                    'textColor' => '#ffffff', // White text
                    'description' => $task->taskDescription,
                ];
            }

            if ($task->cullingPlan) {
                foreach ($task->cageSchedules as $cageSchedule) {
                    $cage = $cageSchedule->cage;
                    if ($cage && $cage->chickens->isNotEmpty()) {
                        foreach ($cage->chickens as $chicken) {
                            $cullingDate = Carbon::parse($chicken->dob)->addWeeks($task->cullingPlan->eliminateAgeThreshold);

                            $events[] = [
                                'title' => 'Culling: ' . $task->taskName,
                                'start' => $cullingDate->toDateString(),
                                'backgroundColor' => '#ffc107', // Yellow for culling
                                'textColor' => '#000000', // Black text
                                'description' => "Chicken from Cage: {$cage->name}",
                            ];
                        }
                    }
                }
            }
        }

        return response()->json($events);
    }

}
