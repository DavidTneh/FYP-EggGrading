<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('collectionplan', function (Blueprint $table) {
            $table->increments('collectionplanID');
            $table->time('time')->comment('Time for collection tasks');
            $table->string('frequency')->comment('Frequency (e.g., Daily, Weekly)');
            $table->boolean('is_repeating')->default(false)->comment('Indicates if the collection repeats');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('collectionplan');
    }
};
