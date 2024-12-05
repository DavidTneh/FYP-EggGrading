<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('taskScheduling', function (Blueprint $table) {
            $table->increments('scheduleID'); // Primary key using increments
            $table->string('taskName');
            $table->text('taskDescription');
            $table->unsignedInteger('collectionplanID'); // Foreign key referencing collectionplan
            $table->foreign('collectionplanID')->references('collectionplanID')->on('collectionplan')->onDelete('cascade');
            $table->unsignedInteger('feedingplanID'); // Foreign key referencing feedingplan
            $table->foreign('feedingplanID')->references('feedingplanID')->on('feedingplan')->onDelete('cascade');
            $table->unsignedInteger('cullingplanID'); // Foreign key referencing cullingplan
            $table->foreign('cullingplanID')->references('cullingplanID')->on('cullingplan')->onDelete('cascade');
            $table->string('collectionStatus')->default('pending'); // Default status: 'pending'
            $table->string('feedingStatus')->default('pending'); // Default status: 'pending'
            $table->string('cullingStatus')->default('pending'); // Default status: 'pending'
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('taskScheduling');
    }
};
