<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\TaskScheduling;
use App\Models\TaskStatusLog;

class UpdateTaskStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_task_status_synchronizes_taskScheduling()
    {
        // Arrange: Create a TaskScheduling record
        $task = TaskScheduling::create([
            'scheduleID' => 2,
            'taskName' => 'Weekly Maintenance',
            'collectionStatus' => 'pending',
            'feedingStatus' => 'pending',
            'cullingStatus' => 'pending',
            'status' => 'pending',
        ]);

        // Act: Send a POST request to update task status
        $response = $this->post(route('update.taskStatus'), [
            'scheduleID' => 2,
            'log_date' => '2024-12-17',
            'collectionStatus' => 'completed',
            'feedingStatus' => 'in_progress',
            'cullingStatus' => 'pending',
            'status' => 'in_progress',
        ]);

        // Assert: Check the database for updates
        $this->assertDatabaseHas('task_status_logs', [
            'scheduleID' => 2,
            'log_date' => '2024-12-17',
            'collectionStatus' => 'completed',
            'feedingStatus' => 'in_progress',
            'cullingStatus' => 'pending',
            'status' => 'in_progress',
        ]);

        $this->assertDatabaseHas('taskScheduling', [
            'scheduleID' => 2,
            'collectionStatus' => 'completed',
            'feedingStatus' => 'in_progress',
            'cullingStatus' => 'pending',
            'status' => 'in_progress',
        ]);

        $response->assertRedirect(); // Ensure a redirect on success
    }
}
