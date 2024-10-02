<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('userID'); // Primary Key
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phoneNo');
            $table->date('dob');
            $table->string('password');
            $table->unsignedInteger('roleID'); // Foreign Key
            $table->foreign('roleID')->references('roleID')->on('role')->onDelete('cascade');
            $table->text('address');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user');
    }

};
