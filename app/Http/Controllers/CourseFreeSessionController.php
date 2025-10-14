<?php

namespace App\Http\Controllers;

use App\Models\CourseFreeSession;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddNewFreeSessionRequest;
use App\Http\Resources\AdminFreeSessionDigest;
use App\Models\Course;
use App\Models\CourseSession;
use Illuminate\Http\Request;

class CourseFreeSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course, Request $request)
    {
        return view('admin.course.free_session.list', [
            'course' => $course,
            'items' => AdminFreeSessionDigest::collection($course->free_sessions)->toArray($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        return view('admin.course.free_session.create', [
            'course' => $course,
            'sessions' => $course->sessions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Course $course, AddNewFreeSessionRequest $request)
    {
        CourseFreeSession::create([
            'course_id' => $course->id,
            'session_id' => $request->session_id
        ]);

        return redirect()->route('course.free_session.index', ['course' => $course->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, CourseSession $session)
    {
        CourseFreeSession::whereCourseId($course->id)->whereSessionId($session->id)->delete();
    }
}
