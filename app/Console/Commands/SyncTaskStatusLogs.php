<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\TaskScheduling;
use App\Models\TaskStatusLog;
use Carbon\Carbon;

class SyncTaskStatusLogs extends Command
{
    protected $signature = 'sync:task-status-logs';
    protected $description = 'Synchronize Task Status Logs with TaskScheduling Table';

    public function handle()
    {
        $today = Carbon::now();
        Log::info("Task Synchronization started: {$today->toDateString()}");

        // Fetch tasks that need synchronization
        $tasks = TaskScheduling::with([
            'collectionPlan:collectionplanID,frequency',
            'feedingPlan:feedingplanID,frequency' // Exclude cullingPlan frequency check
        ])
            ->where('status', '!=', 'completed') // Fetch only tasks that are not completed
            ->orWhere('cullingStatus', '!=', 'completed')
            ->get();

        Log::info("Total Tasks to process: {$tasks->count()}");

        foreach ($tasks as $task) {
            $this->synchronizeTaskLogs($task, $today);
        }

        $this->info("Task Status Logs successfully synchronized.");
        Log::info("Task Synchronization completed.");
    }

    /**
     * Synchronize the task logs.
     *
     * @param TaskScheduling $task
     * @param Carbon $today
     * @return void
     */
    private function synchronizeTaskLogs($task, $today)
    {
        // Safeguard for missing relationships
        $collectionFrequency = optional($task->collectionPlan)->frequency;
        $feedingFrequency = optional($task->feedingPlan)->frequency;

        $logData = [
            'collectionStatus' => $task->collectionStatus ?? 'pending',
            'feedingStatus'    => $task->feedingStatus ?? 'pending',
            'cullingStatus'    => $task->cullingStatus ?? 'pending',
            'status'           => $task->status ?? 'in-progress',
        ];

        // Synchronize Collection and Feeding Plans
        $logUpdated = false;

        if ($this->shouldRunTask($collectionFrequency, $today)) {
            $this->updateLog($task, $today, $logData, 'Collection Plan');
            $logUpdated = true;
        }

        if ($this->shouldRunTask($feedingFrequency, $today)) {
            $this->updateLog($task, $today, $logData, 'Feeding Plan');
            $logUpdated = true;
        }

        // Mark task as completed if cullingStatus is 'completed'
        if ($task->cullingStatus === 'completed') {
            $task->update(['status' => 'completed']);
            Log::info("Task ID: {$task->scheduleID} marked as completed (Culling Status).");
        } elseif (!$logUpdated) {
            Log::info("Task ID: {$task->scheduleID} skipped. No plans due for today.");
        }
    }

    /**
     * Update the TaskStatusLog.
     *
     * @param TaskScheduling $task
     * @param Carbon $today
     * @param array $logData
     * @param string $planType
     * @return void
     */
    private function updateLog($task, $today, $logData, $planType)
    {
        TaskStatusLog::updateOrCreate(
            ['scheduleID' => $task->scheduleID, 'log_date' => $today->toDateString()],
            $logData
        );
        Log::info("Task ID: {$task->scheduleID} synchronized for {$planType}.");
    }

    /**
     * Check if a task should run today based on frequency.
     *
     * @param string|null $frequency
     * @param Carbon $today
     * @return bool
     */
    private function shouldRunTask($frequency, $today)
    {
        return match (strtolower($frequency)) {
            'daily'    => true,
            'weekly'   => $today->isMonday(),
            'biweekly' => $today->weekOfYear % 2 === 1,
            'monthly'  => $today->isFirstOfMonth(),
            default    => false,
        };
    }
}
