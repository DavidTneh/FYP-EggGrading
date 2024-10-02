<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cage', function (Blueprint $table) {
            $table->increments('cageID');
            $table->string('name');
            $table->string('size');
            $table->integer('capacity');
            $table->string('type');
            $table->string('status');
            $table->string('availability');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cage');
    }

};
