<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseAttach;
use App\Models\CourseLesson;
use App\Models\CourseSeoTag;
use App\Models\CourseTag;
use App\Models\Lesson;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = database_path('seeders/files/1.png');
        $storedPath1 = Storage::putFile('public/course_pics', new File($filePath));
        $storedPath2 = Storage::putFile('public/course_attaches', new File($filePath));

        $course = Course::create([
            'title' => 'courese 1',
            'description' => 'desc 1',
            'price' => 2000000,
            'priority' => 1,
            'img' => $storedPath1,
        ]);

        CourseTag::create([
            'value' => 'tag1',
            'course_id' => $course->id
        ]);
        CourseTag::create([
            'value' => 'tag2',
            'course_id' => $course->id
        ]);

        CourseSeoTag::create([
            'key' => 'meta',
            'value' => 'val1',
            'course_id' => $course->id
        ]);
        
        CourseSeoTag::create([
            'key' => 'description',
            'value' => 'val2',
            'course_id' => $course->id
        ]);

        CourseLesson::create([
            'lesson_id' => Lesson::first()->id,
            'course_id' => $course->id
        ]);

        CourseAttach::create([
            'title' => 'title1',
            'file' => $storedPath2,
            'course_id' => $course->id
        ]);
    }
}
