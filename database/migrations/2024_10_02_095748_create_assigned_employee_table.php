<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assignedEmployee', function (Blueprint $table) {
            $table->increments('assignedID');
            $table->unsignedInteger('userID');
            $table->foreign('userID')->references('userID')->on('user');
            $table->unsignedInteger('scheduleID');
            $table->foreign('scheduleID')->references('scheduleID')->on('taskScheduling');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assignedEmployee');
    }

};
