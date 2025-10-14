<?php

namespace App\Http\Controllers;

use App\Models\CourseSeoTag;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSeoTagRequest;
use App\Models\Course;

class CourseSeoTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        return view('admin.course.seo_tag.list', ['course' => $course, 'items' => $course->seo_tags]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        return view('admin.course.seo_tag.create', ['course' => $course]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSeoTagRequest $request, Course $course)
    {
        CourseSeoTag::create([
            'course_id' => $course->id,
            'key' => $request->key,
            'value' => $request->value
        ]);
        return redirect()->route('course.seo_tag.index', ['course' => $course->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseSeoTag $seoTag)
    {
        $seoTag->delete();
    }
}
