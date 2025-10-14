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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedInteger('amount');
            $table->unsignedBigInteger('offer_id');
            $table->unsignedBigInteger('course_id')->index()->nullable();
            $table->unsignedBigInteger('subscription_package_id')->index()->nullable();
            $table->string('ref_code');
            $table->string('tracking_code')->unique();
            $table->enum('status', ['INIT', 'SUCCESS', 'FAIL']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('subscription_package_id')->references('id')->on('subscription_packages')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
