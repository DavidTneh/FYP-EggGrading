<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vaccinationplan', function (Blueprint $table) {
            $table->increments('vaccinationplanID'); // Primary Key
            $table->unsignedInteger('vaccinationtypeID'); // Foreign Key
            $table->foreign('vaccinationtypeID')->references('vaccinationtypeID')->on('vaccinationtype');
            $table->integer('vaccinationPerChicken');
            $table->unsignedInteger('cageID'); // Foreign Key
            $table->foreign('cageID')->references('cageID')->on('cage');
            $table->integer('totalVaccinationRequired');
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vaccinationplan');
    }

};
