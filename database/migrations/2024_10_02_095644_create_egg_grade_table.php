<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('eggGrade', function (Blueprint $table) {
            $table->increments('eggGradeID');
            $table->string('name');
            $table->string('grade');
            $table->text('description');
            $table->string('estimatedWeightRange');
            $table->decimal('price', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('eggGrade');
    }

};
