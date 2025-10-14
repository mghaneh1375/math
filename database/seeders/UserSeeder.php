<?php

namespace Database\Seeders;

use App\Enums\AccountStatus;
use App\Enums\UserLevel;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'firstname' => 'ادمین',
            'lastname' => 'ادمین',
            'username' => 'admin',
            'password' => Hash::make('123456'),
            'level' => UserLevel::ADMIN->name,
            'status' => AccountStatus::ACTIVE->name,
            'grade_id' => Grade::first()->id
        ]);

        User::create([
            'firstname' => 'کاربر1',
            'lastname' => 'کاربر1',
            'username' => 'user1',
            'password' => Hash::make('123456'),
            'level' => UserLevel::STUDENT->name,
            'status' => AccountStatus::ACTIVE->name,
            'grade_id' => Grade::first()->id
        ]);
        
    }
}
