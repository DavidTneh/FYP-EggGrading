<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('taskScheduling', function (Blueprint $table) {
            $table->increments('scheduleID');
            $table->string('taskName');
            $table->text('taskDescription');
            $table->unsignedInteger('collectionplanID');
            $table->foreign('collectionplanID')->references('collectionplanID')->on('collectionplan');
            $table->unsignedInteger('feedingplanID');
            $table->foreign('feedingplanID')->references('feedingplanID')->on('feedingplan');
            $table->unsignedInteger('cullingplanID');
            $table->foreign('cullingplanID')->references('cullingplanID')->on('cullingplan');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('taskScheduling');
    }

};
