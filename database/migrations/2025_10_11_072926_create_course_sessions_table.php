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
        Schema::create('course_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('chapter');
            $table->unsignedInteger('duration');
            $table->unsignedBigInteger('course_id')->index();
            $table->longText('description')->nullable();
            $table->string('file')->nullable();
            $table->timestamp('chunked_at')->nullable();
            $table->boolean('should_chunk')->default(true);
            $table->boolean('visibility')->default(true);
            $table->timestamps();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_sessions');
    }
};
