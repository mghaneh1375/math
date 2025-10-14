<?php

namespace App\Http\Controllers;

use App\Models\CourseAttach;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAttachRequest;
use App\Http\Requests\UpdateAttachRequest;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;

class CourseAttachController extends Controller
{
    private static $FOLDER = 'public/course_attaches';

    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        return view('admin.course.attach.list', ['items' => $course->attaches, 'course' => $course]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        return view('admin.course.attach.create', ['course' => $course]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Course $course, CreateAttachRequest $request)
    {
        $path = $request->file('file')->store(self::$FOLDER);
        CourseAttach::create([
            'title' => $request->title,
            'file' => $path,
            'course_id' => $course->id
        ]);

        return redirect()->route('course.attach.index', ['course' => $course->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseAttach $attach)
    {
        return view('admin.course.attach.create', ['course' => $attach->course, 'item' => $attach]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttachRequest $request, CourseAttach $attach)
    {
        if($request->has('file')) {
            $path = $request->file('file')->store(self::$FOLDER);
            Storage::delete($attach->file);
            $attach->file = $path;
        }

        $attach->title = $request->title;
        $attach->save();
        return redirect()->route('course.attach.index', ['course' => $attach->course->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseAttach $attach)
    {
        Storage::delete($attach->file);
        $attach->delete();
    }
}
