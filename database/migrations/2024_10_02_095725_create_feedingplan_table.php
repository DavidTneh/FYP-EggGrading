<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('feedingplan', function (Blueprint $table) {
            $table->increments('feedingplanID');
            $table->time('time')->comment('Time for feeding tasks');
            $table->string('frequency')->comment('Frequency (e.g., Daily, Weekly)');
            $table->boolean('is_repeating')->default(false)->comment('Indicates if the feeding repeats');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedingplan');
    }
};
