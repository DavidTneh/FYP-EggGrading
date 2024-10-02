<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('role', function (Blueprint $table) {
            $table->increments('roleID'); // Primary Key
            $table->string('roleName');
            $table->string('roleDescription');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('role');
    }

};
