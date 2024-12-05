<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cullingplan', function (Blueprint $table) {
            $table->increments('cullingplanID');
            $table->integer('eliminateAgeThreshold')->comment('Threshold in days to determine culling date');
            $table->text('reasons')->comment('Reasons for culling');
            $table->string('healthStatus')->comment('Health status criteria for culling');
            $table->text('notes')->nullable()->comment('Additional notes');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cullingplan');
    }
};
