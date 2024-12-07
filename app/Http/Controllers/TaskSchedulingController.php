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
use App\Models\ChickenBreeds;
use App\Models\TaskStatusLog;
use App\Models\CollectionPlan;
use App\Models\TaskScheduling;
use App\Models\VaccinationPlan;
use App\Models\AssignedEmployee;
use App\Models\VaccinationRecords;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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

        // Fetch cage schedules with start_date and end_date
        $cageSchedules = CageSchedule::where('scheduleID', $scheduleID)
        ->get()
        ->map(function ($cageSchedule) {
            return (object) [
                'cageName' => Cage::find($cageSchedule->cageID)->name ?? 'Unknown',
                'start_date' => $cageSchedule->start_date,
                'end_date' => $cageSchedule->end_date,
            ];
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
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Create the main task scheduling record
        $taskScheduling = TaskScheduling::create([
            'taskName' => $request->input('taskName'),
            'taskDescription' => $request->input('taskDescription'),
            'collectionPlanID' => $request->input('collectionPlanID'),
            'feedingPlanID' => $request->input('feedingPlanID'),
            'cullingPlanID' => $request->input('cullingPlanID'),
            'collectionStatus' => 'pending',
            'feedingStatus' => 'pending',
            'cullingStatus' => 'pending',
            'status' => $request->input('status'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ]);

        // Assign employees
        foreach ($request->input('assignedEmployees') as $userID) {
            AssignedEmployee::create([
                'scheduleID' => $taskScheduling->scheduleID,
                'userID' => $userID,
            ]);
        }

        // Assign cages and calculate culling_date
        foreach ($request->input('cageSchedules') as $cageID) {
            $chickens = Chicken::where('cageID', $cageID)->get();
            $cullingDates = $chickens->map(function ($chicken) use ($taskScheduling) {
                return Carbon::parse($chicken->dob)->addWeeks($taskScheduling->cullingPlan->eliminateAgeThreshold);
            });

            CageSchedule::create([
                'scheduleID' => $taskScheduling->scheduleID,
                'cageID' => $cageID,
                'start_date' => $request->input('start_date'), // Assign start_date
                'end_date' => $request->input('end_date'), // Assign end_date
                'culling_date' => $cullingDates->max(), // Get the latest culling date for the cage
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

        return view('updateTaskScheduling',
                compact(
                    'taskScheduling',
                    'collectionPlans',
                    'feedingPlans',
                    'cullingPlans',
                    'employees',
                    'cages'
                )
            );
    }

    public function update(Request $request)
    {
        $taskScheduling = TaskScheduling::findOrFail($request->input('scheduleID'));

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
            'start_date' => [
                'required',
                'date',
                'after_or_equal:' . date('Y-m-d'),
            ],
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
            ],
        ]);

        // Update main task scheduling record
        $taskScheduling->update($request->only([
            'taskName',
            'taskDescription',
            'collectionPlanID',
            'feedingPlanID',
            'cullingPlanID',
            'status',
        ]));

        // Update assigned employees
        AssignedEmployee::where('scheduleID', $taskScheduling->scheduleID)->delete();
        foreach ($request->input('assignedEmployees') as $userID) {
            AssignedEmployee::create([
                'scheduleID' => $taskScheduling->scheduleID,
                'userID' => $userID,
            ]);
        }

        // Update assigned cages and their schedule dates
        foreach ($taskScheduling->cageSchedules as $cageSchedule) {
            $cageSchedule->update([
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
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

    // public function showCalendar()
    // {
    //     $startOfWeek = \Carbon\Carbon::now()->startOfWeek();
    //     $endOfWeek = \Carbon\Carbon::now()->endOfWeek();


    //     $tasks = DB::table('taskscheduling')
    //     ->join('cageschedule', 'taskscheduling.scheduleID', '=', 'cageschedule.scheduleID')
    //     ->join('cage', 'cageschedule.cageID', '=', 'cage.cageID')
    //     ->leftJoin('assignedemployee', 'taskscheduling.scheduleID', '=', 'assignedemployee.scheduleID')
    //     ->leftJoin('user', 'assignedemployee.userID', '=', 'user.userID')
    //     ->leftJoin('collectionplan', 'taskscheduling.collectionplanID', '=', 'collectionplan.collectionplanID')
    //     ->leftJoin('feedingplan', 'taskscheduling.feedingplanID', '=', 'feedingplan.feedingplanID')
    //     ->leftJoin('cullingplan', 'taskscheduling.cullingplanID', '=', 'cullingplan.cullingplanID')
    //     ->select(
    //         'taskscheduling.taskName',
    //         'taskscheduling.taskDescription',
    //         'taskscheduling.status',
    //         'cage.name as cageName',
    //         'user.name as employeeName',
    //         DB::raw('IFNULL(collectionplan.time, IFNULL(feedingplan.time, "N/A")) as taskTime'),
    //         DB::raw('IFNULL(collectionplan.frequency, IFNULL(feedingplan.frequency, "N/A")) as taskFrequency'),
    //         DB::raw('IFNULL(cullingplan.eliminateAgeThreshold, "N/A") as cullingCriteria'),
    //         'cageschedule.created_at as scheduleDate'
    //     )
    //     ->whereBetween('cageschedule.created_at', [$startOfWeek, $endOfWeek])
    //     ->orderBy('scheduleDate', 'asc')
    //     ->get();


    //     return view('calender', compact('tasks'));
    // }

    public function showCalendar(Request $request)
    {
        $weekOffset = $request->input('week', 0);
        $startOfWeek = Carbon::now()->startOfWeek()->addWeeks($weekOffset);
        $endOfWeek = Carbon::now()->endOfWeek()->addWeeks($weekOffset);

        $tasks = DB::table('taskscheduling')
        ->join('cageschedule', 'taskscheduling.scheduleID', '=', 'cageschedule.scheduleID')
        ->join('cage', 'cageschedule.cageID', '=', 'cage.cageID')
        ->join('chicken', 'cage.cageID', '=', 'chicken.cageID')
        ->join('chickenbreeds', 'chicken.breedID', '=', 'chickenbreeds.breedID')
        ->leftJoin('assignedemployee',
            'taskscheduling.scheduleID',
            '=',
            'assignedemployee.scheduleID'
        )
        ->leftJoin('user', 'assignedemployee.userID', '=', 'user.userID')
        ->leftJoin('collectionplan', 'taskscheduling.collectionplanID', '=', 'collectionplan.collectionplanID')
        ->leftJoin('feedingplan', 'taskscheduling.feedingplanID', '=', 'feedingplan.feedingplanID')
        ->leftJoin('cullingplan', 'taskscheduling.cullingplanID', '=', 'cullingplan.cullingplanID')
        ->leftJoin('vaccination_records', 'chicken.chickenID', '=', 'vaccination_records.chickenID')
        ->leftJoin('vaccinationplan', 'vaccination_records.vaccinationplanID', '=', 'vaccinationplan.vaccinationplanID')
        ->leftJoin('vaccinationtype', 'vaccinationplan.vaccinationtypeID', '=', 'vaccinationtype.vaccinationtypeID')
            ->select(
                'taskscheduling.taskName',
                'taskscheduling.taskDescription',
                'taskscheduling.status',
                'cage.name as cageName',
                'chickenbreeds.name as breedName',
                'user.name as employeeName',
                'cageschedule.start_date',
                'cageschedule.culling_date',
                'collectionplan.time as collectionTime',
                'collectionplan.frequency as collectionFrequency', // Add frequency for Collection Plan
                'collectionplan.is_repeating as collectionRepeating',
                'feedingplan.time as feedingTime',
                'feedingplan.frequency as feedingFrequency', // Add frequency for Feeding Plan
                'feedingplan.is_repeating as feedingRepeating',
                'vaccination_records.date_administered as vaccinationDate',
                'vaccinationtype.vaccineName as vaccineName',
                'vaccinationtype.methodConsume as methodConsume',
                'vaccinationtype.description as vaccineDescription',
                'vaccinationtype.criteria as vaccineCriteria',
                'taskscheduling.scheduleID'
            )

        ->orderBy('cageschedule.start_date', 'asc')
        ->get();

        $normalizedTasks = [];
        foreach ($tasks as $task) {
            $task = (object) $task;

            if (!is_null($task->vaccinationDate)) {
                $vaccinationTimeSlot = $task->vaccinationDate . ' 00:00:00';
                $alreadyExists = collect($normalizedTasks[$vaccinationTimeSlot] ?? [])->contains(function ($existingTask) use ($task) {
                    return $existingTask->cageName === $task->cageName && $existingTask->breedName === $task->breedName && $existingTask->taskType === 'Vaccination';
                });

                if (!$alreadyExists) {
                    $normalizedTasks[$vaccinationTimeSlot][] = (object) array_merge((array) $task, [
                        'taskType' => 'Vaccination',
                        'taskName' => 'Vaccination Record',
                        'taskDescription' => "{$task->vaccineName}: {$task->vaccineDescription}",
                    ]);
                }
            }

            if (!is_null($task->collectionTime)) {
                $this->processRepeatingTask($normalizedTasks, $task, $startOfWeek, $endOfWeek, 'collection');
            }

            if (!is_null($task->feedingTime)) {
                $this->processRepeatingTask($normalizedTasks, $task, $startOfWeek, $endOfWeek, 'feeding');
            }

            if (!is_null($task->culling_date)) {
                $cullingTimeSlot = $task->culling_date . ' 12:00:00';

                // Ensure no duplicates are added for the same cage and culling type
                $alreadyExists = collect($normalizedTasks[$cullingTimeSlot] ?? [])->contains(function ($existingTask) use ($task) {
                    return $existingTask->cageName === $task->cageName && $existingTask->taskType === 'Culling';
                });

                if (!$alreadyExists) {
                    $normalizedTasks[$cullingTimeSlot][] = (object) array_merge((array) $task, [
                        'taskType' => 'Culling',
                        'taskName' => 'Culling Plan',
                        'taskDescription' => 'Scheduled culling task',
                    ]);
                }
            }

        }

        return view('calender', compact('normalizedTasks', 'startOfWeek', 'endOfWeek', 'weekOffset'));
    }



    /**
     * Process a repeating task and add it to the normalizedTasks array.
     */
    private function processRepeatingTask(&$normalizedTasks, $task, $startOfWeek, $endOfWeek, $type)
    {
        $frequency = $type === 'collection' ? $task->collectionFrequency : $task->feedingFrequency;
        $time = $type === 'collection' ? $task->collectionTime : $task->feedingTime;
        $isRepeating = $type === 'collection' ? $task->collectionRepeating : $task->feedingRepeating;

        $startDate = Carbon::parse($task->start_date);
        $currentDate = $startOfWeek->copy();

        while ($currentDate->lte($endOfWeek)) {
            if ($currentDate->gte($startDate) && $this->isTaskDue($currentDate, $frequency, $startDate, $isRepeating)) {
                $timeSlot = $currentDate->format('Y-m-d') . ' ' . $time;

                // Ensure no duplicates are added for the same task type, cage, and time slot
                $alreadyExists = collect($normalizedTasks[$timeSlot] ?? [])->contains(function ($existingTask) use ($task, $type) {
                    return $existingTask->cageName === $task->cageName &&
                    $existingTask->taskType === ucfirst($type);
                });

                if (!$alreadyExists) {
                    $normalizedTasks[$timeSlot][] = (object) array_merge((array) $task, [
                        'taskType' => ucfirst($type),
                        'taskFrequency' => $frequency // Add frequency to the task
                    ]);
                }
            }

            // Increment based on frequency
            if ($frequency === 'Daily') {
                $currentDate->addDay();
            } elseif ($frequency === 'Weekly') {
                $currentDate->addWeek();
            } elseif ($frequency === 'Biweekly') {
                $currentDate->addWeeks(2);
            } elseif ($frequency === 'Monthly') {
                $currentDate->addMonth();
            } else {
                break;
            }
        }
    }



    private function isTaskDue(Carbon $currentDate, $frequency, Carbon $startDate, $isRepeating)
    {
        if (!$isRepeating && $currentDate->gt($startDate)) {
            return false;
        }

        switch (strtolower($frequency)) {
            case 'daily':
                return true;
            case 'weekly':
                return $currentDate->dayOfWeek === $startDate->dayOfWeek;
            case 'biweekly':
                return $currentDate->diffInWeeks($startDate) % 2 === 0 && $currentDate->dayOfWeek === $startDate->dayOfWeek;
            case 'monthly':
                return $currentDate->day === $startDate->day;
            default:
                return false;
        }
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

    public function listAssignedTasks()
    {
        // Get the currently logged-in employee
        $employeeID = Auth::id();

        // Fetch tasks assigned to the employee
        $assignedTasks = AssignedEmployee::where('userID', $employeeID)
        ->join('taskScheduling', 'assignedemployee.scheduleID', '=', 'taskScheduling.scheduleID')
        ->join('cageschedule', 'taskScheduling.scheduleID', '=', 'cageschedule.scheduleID')
        ->join('cage', 'cageschedule.cageID', '=', 'cage.cageID')
        ->select(
            'taskScheduling.scheduleID',
            'taskScheduling.taskName',
            'taskScheduling.taskDescription',
            'taskScheduling.status',
            'cage.name as cageName',
            'cageschedule.start_date',
            'cageschedule.end_date'
        )
        ->get();

        // Fetch vaccination records assigned to the employee
        $assignedVaccinationRecords = VaccinationRecords::with([
            'chicken.breed',
            'chicken.cage',
            'vaccinationplan.vaccinationType',
        ])
        ->where('administered_by', $employeeID) // Filter by the logged-in user
        ->get();

        return view('taskStatusListing',
            compact('assignedTasks', 'assignedVaccinationRecords')
        );
    }



    public function showUpdateTaskStatusForm(Request $request)
    {
        $scheduleID = $request->input('scheduleID');

        // Validate if the scheduleID exists and belongs to the current user
        $employeeID = Auth::id();
        $taskScheduling = AssignedEmployee::where('assignedemployee.userID', $employeeID)
            ->where('assignedemployee.scheduleID', $scheduleID)
            ->join('taskScheduling', 'assignedemployee.scheduleID', '=', 'taskScheduling.scheduleID')
            ->select('taskScheduling.*')
            ->firstOrFail(); // Use firstOrFail to fetch a single task or throw 404 if not found

        
        return view('taskStatusUpdateForm', compact('taskScheduling'));
    }

    public function updateTaskStatus(Request $request)
    {
        Log::info('updateTaskStatus method invoked', $request->all());
        $request->validate([
            'scheduleID' => 'required|exists:taskScheduling,scheduleID',
            'log_date' => 'required|date',
            'collectionStatus' => 'required|in:pending,in_progress,completed',
            'feedingStatus' => 'required|in:pending,in_progress,completed',
            'cullingStatus' => 'required|in:pending,in_progress,completed',
        ]);

        // Insert or update the task status log
        TaskStatusLog::updateOrCreate(
            [
                'scheduleID' => $request->input('scheduleID'),
                'log_date' => $request->input('log_date'),
            ],
            [
                'collectionStatus' => $request->input('collectionStatus'),
                'feedingStatus' => $request->input('feedingStatus'),
                'cullingStatus' => $request->input('cullingStatus'),
            ]
        );

        return redirect()->route('employee.listAssignedTasks')->with('success', 'Task status updated successfully.');
    }

    public function showUpdateVaccinationStatusForm(Request $request)
    {
        $request->validate([
            'cageID' => 'required|exists:cage,cageID',
            'breedID' => 'required|exists:chickenbreeds,breedID',
            'vaccinationplanID' => 'required|exists:vaccinationplan,vaccinationplanID',
            'date_administered' => 'required|date',
        ]);

        // Retrieve vaccination records matching the group criteria
        $vaccinationRecords = VaccinationRecords::with([
            'chicken.breed',
            'chicken.cage',
            'vaccinationplan.vaccinationType',
        ])
        ->whereHas('chicken', function ($query) use ($request) {
            $query->where('cageID', $request->input('cageID'))
            ->where('breedID', $request->input('breedID'));
        })
        ->where('vaccinationplanID', $request->input('vaccinationplanID'))
        ->where('date_administered', $request->input('date_administered'))
        ->get();

        // Ensure records exist for the group
        if ($vaccinationRecords->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'No vaccination records found for the selected criteria.']);
        }

        // Retrieve related information for reference
        $cage = Cage::findOrFail($request->input('cageID'));
        $breed = ChickenBreeds::findOrFail($request->input('breedID'));
        $vaccinationPlan = VaccinationPlan::findOrFail($request->input('vaccinationplanID'));

        return view('updateVaccinationRecordStatus', compact('vaccinationRecords', 'cage', 'breed', 'vaccinationPlan'));
    }



    public function updateVaccinationGroupStatus(Request $request)
    {
        $request->validate([
            'cageID' => 'required|exists:cage,cageID',
            'breedID' => 'required|exists:chickenbreeds,breedID',
            'vaccinationplanID' => 'required|exists:vaccinationplan,vaccinationplanID',
            'date_administered' => 'required|date',
            'status' => 'required|in:pending,completed,skipped',
            'notes' => 'nullable|string',
        ]);

        // Update the vaccination records for the group
        VaccinationRecords::whereHas('chicken', function ($query) use ($request) {
            $query->where('cageID', $request->input('cageID'))
                ->where('breedID', $request->input('breedID'));
        })
            ->where('vaccinationplanID', $request->input('vaccinationplanID'))
            ->where('date_administered', $request->input('date_administered'))
            ->update([
                'status' => $request->input('status'),
                'notes' => $request->input('notes'),
            ]);

        return redirect()->route('employee.listAssignedTasks')
        ->with('success', 'Vaccination records for the group updated successfully.');
    }





}
