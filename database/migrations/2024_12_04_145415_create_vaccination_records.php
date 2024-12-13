<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccination_records', function (Blueprint $table) {
            $table->increments('recordID'); // Primary key
            $table->unsignedInteger('chickenID');
            $table->foreign('chickenID')->references('chickenID')->on('chicken')->onDelete('cascade');
            $table->unsignedInteger('vaccinationplanID');
            $table->foreign('vaccinationplanID')->references('vaccinationplanID')->on('vaccinationplan')->onDelete('cascade');
            $table->date('date_administered'); // Date when the vaccination was administered
            $table->unsignedInteger('administered_by');
            $table->foreign('administered_by')->references('userID')->on('user')->onDelete('cascade');;
            $table->text('notes')->nullable(); // Optional notes about the vaccination
            $table->enum('status', ['pending', 'completed'])->default('pending'); // Status of the vaccination
            $table->timestamps(); // Created and updated timestamps

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vaccination_records');
    }
};
