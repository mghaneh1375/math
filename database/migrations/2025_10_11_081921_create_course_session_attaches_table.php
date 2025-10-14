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
        Schema::create('course_session_attaches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_session_id')->index();
            $table->string('file');
            $table->string('title', 300);
            $table->foreign('course_session_id')->references('id')->on('course_sessions')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_session_attaches');
    }
};
