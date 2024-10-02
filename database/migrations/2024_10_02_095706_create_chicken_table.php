<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chicken', function (Blueprint $table) {
            $table->increments('chickenID');
            $table->unsignedInteger('breedID');
            $table->foreign('breedID')->references('breedID')->on('chickenBreeds');
            $table->date('dob');
            $table->unsignedInteger('cageID');
            $table->foreign('cageID')->references('cageID')->on('cage');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chicken');
    }

};
