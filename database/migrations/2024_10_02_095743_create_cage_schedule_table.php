<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cageSchedule', function (Blueprint $table) {
            $table->increments('cageScheduleID');
            $table->unsignedInteger('cageID');
            $table->foreign('cageID')->references('cageID')->on('cage');
            $table->unsignedInteger('scheduleID');
            $table->foreign('scheduleID')->references('scheduleID')->on('taskScheduling');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cageSchedule');
    }

};
