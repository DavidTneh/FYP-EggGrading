<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('task_status_logs', function (Blueprint $table) {
            $table->increments('task_status_logID'); // Primary key using increments
            $table->unsignedInteger('scheduleID'); // Match the data type with `taskScheduling.scheduleID`
            $table->date('log_date'); // Log date
            $table->enum('collectionStatus', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->enum('feedingStatus', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->enum('cullingStatus', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->timestamps();

            // Add the foreign key constraint
            $table->foreign('scheduleID')
                ->references('scheduleID')
                ->on('taskScheduling')
                ->onDelete('cascade'); // Add onDelete for proper relationship behavior
        });
    }

    public function down()
    {
        Schema::dropIfExists('task_status_logs');
    }
};
