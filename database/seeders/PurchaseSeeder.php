<?php

namespace Database\Seeders;

use App\Enums\UserLevel;
use App\Models\Course;
use App\Models\Purchase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Purchase::create([
            'user_id' => User::whereLevel(UserLevel::STUDENT)->first()->id,
            'course_id' => Course::first()->id,
            'paid_amount' => 0,
            'paid_at' => Carbon::now()->toDateTimeString()
        ]);
    }
}
