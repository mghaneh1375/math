<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 11)->unique();
            $table->string('firstname', 100);
            $table->string('lastname', 100);
            $table->string('school_name', 255)->nullable();
            $table->enum('status', ['ACTIVE', 'BLOCK', 'PENDING'])->default('PENDING');
            $table->enum('level', ['ADMIN', 'STUDENT'])->default('STUDENT');
            $table->string('password');
            $table->unsignedBigInteger('grade_id')->index();
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade')->onUpdate('cascade');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
