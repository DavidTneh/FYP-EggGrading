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
            $table->boolean('status')->default(true);
            $table->string('session_id')->nullable();
            $table->timestamp('reset_time')->nullable(); // Correct way to add reset_time column
            $table->timestamps(); // created_at and updated_at
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

