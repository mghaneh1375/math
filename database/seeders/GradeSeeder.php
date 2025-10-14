<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Grade::create([
            'name' => 'هفتم'
        ]);
        Grade::create([
            'name' => 'هشتم'
        ]);
        Grade::create([
            'name' => 'نهم'
        ]);
        Grade::create([
            'name' => 'دهم تجربی'
        ]);
        Grade::create([
            'name' => 'دهم انسانی'
        ]);
        Grade::create([
            'name' => 'دهم ریاضی'
        ]);
        Grade::create([
            'name' => 'یازدهم تجربی'
        ]);
        Grade::create([
            'name' => 'یازدهم انسانی'
        ]);
        Grade::create([
            'name' => 'یازدهم ریاضی'
        ]);
    }
}
