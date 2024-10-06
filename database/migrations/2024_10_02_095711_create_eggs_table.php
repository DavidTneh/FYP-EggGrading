<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('eggs', function (Blueprint $table) {
            $table->increments('eggsID');
            $table->string('type');
            $table->unsignedInteger('eggGradeID');
            $table->foreign('eggGradeID')->references('eggGradeID')->on('eggGrade');
            $table->text('description');
            $table->unsignedInteger('cageID');
            $table->foreign('cageID')->references('cageID')->on('cage');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('eggs');
    }

};
