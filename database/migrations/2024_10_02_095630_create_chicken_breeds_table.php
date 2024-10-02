<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chickenBreeds', function (Blueprint $table) {
            $table->increments('breedID');
            $table->string('name');
            $table->string('gender');
            $table->string('origin');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chickenBreeds');
    }

};
