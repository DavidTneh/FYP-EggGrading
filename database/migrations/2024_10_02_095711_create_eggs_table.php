<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('eggs', function (Blueprint $table) {
            $table->increments('eggsID');
            $table->string('type');
            $table->unsignedInteger('eggGradeID');
            $table->foreign('eggGradeID')->references('eggGradeID')->on('eggGrade')->onDelete('cascade');
            $table->text('description');
            $table->unsignedInteger('cageID');
            $table->foreign('cageID')->references('cageID')->on('cage')->onDelete('cascade');

            // Define created_at and updated_at with default values
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('eggs');
    }
};
