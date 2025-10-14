<?php

namespace App\Http\Controllers;

use App\Models\CourseTag;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTagRequest;
use App\Models\Course;

class CourseTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        return view('admin.course.tag.list', ['course' => $course, 'items' => $course->tags]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        return view('admin.course.tag.create', ['course' => $course]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTagRequest $request, Course $course)
    {
        CourseTag::create([
            'course_id' => $course->id,
            'value' => $request->value
        ]);
        return redirect()->route('course.tag.index', ['course' => $course->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseTag $tag)
    {
        $tag->delete();
    }
}
