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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('grade_id')->index()->nullable();
            $table->unsignedBigInteger('lesson_id')->index()->nullable();
            $table->unsignedBigInteger('course_id')->index()->nullable();
            $table->unique(['grade_id', 'lesson_id', 'course_id']);
            $table->enum('type', ['VALUE', 'PERCENT'])->default('PERCENT');
            $table->unsignedInteger('value');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('expire_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
