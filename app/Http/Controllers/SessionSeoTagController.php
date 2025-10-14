<?php

namespace App\Http\Controllers;

use App\Models\SessionSeoTag;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSeoTagRequest;
use App\Models\CourseSession;

class SessionSeoTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CourseSession $session)
    {
        return view('admin.course.session.seo_tag.list', ['course' => $session->course, 'session' => $session, 'items' => $session->seo_tags]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CourseSession $session)
    {
        return view('admin.course.session.seo_tag.create', ['course' => $session->course->title, 'session' => $session]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseSession $session, CreateSeoTagRequest $request)
    {
        SessionSeoTag::create([
            'session_id' => $session->id,
            'key' => $request->key,
            'value' => $request->value
        ]);
        return redirect()->route('session.session_seo_tag.index', ['session' => $session->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SessionSeoTag $session_seo_tag)
    {
        $session_seo_tag->delete();
    }
}
