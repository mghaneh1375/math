<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            'هفتم' => ['ریاضی', 'هندسه'],
            'هشتم' => ['ریاضی', 'هندسه'],
            'نهم' => ['ریاضی', 'هندسه'],
            'دهم ریاضی' => ['حسابان', 'هندسه', 'جبر'],
            'دهم انسانی' => ['ریاضی'],
        ];
        
        foreach($items as $key => $value) { 
            $grade = Grade::whereName($key)->first();
            foreach($value as $lesson) {
                Lesson::create([
                    'name' => $lesson,
                    'grade_id' => $grade->id
                ]);
            }
        }     
    }
}
