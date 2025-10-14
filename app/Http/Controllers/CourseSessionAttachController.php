<?php

namespace App\Http\Controllers;

use App\Models\CourseSessionAttach;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAttachRequest;
use App\Models\CourseSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseSessionAttachController extends Controller
{
    private static $FOLDER = 'public/session_attaches';
    /**
     * Display a listing of the resource.
     */
    public function index(CourseSession $session)
    {
        return view('admin.course.session.attach.list', [
            'items' => $session->attaches, 'session' => $session, 'course' => $session->course
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CourseSession $session)
    {
        return view('admin.course.session.attach.create', [
            'session' => $session, 'course' => $session->course
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseSession $session, Request $request)
    {
        $path = $request->file('file')->store(self::$FOLDER);
        CourseSessionAttach::create([
            'title' => $request->title,
            'file' => $path,
            'course_session_id' => $session->id
        ]);

        return redirect()->route('session.session_attach.index', ['session' => $session->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseSessionAttach $session_attach)
    {
        return view('admin.course.session.attach.create', [
            'session' => $session_attach->session, 'course' => $session_attach->session->course,
            'item' => $session_attach
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttachRequest $request, CourseSessionAttach $session_attach)
    {
        if($request->has('file')) {
            $path = $request->file('file')->store(self::$FOLDER);
            Storage::delete($session_attach->file);
            $session_attach->file = $path;
        }

        $session_attach->title = $request->title;
        $session_attach->save();
        return redirect()->route('session.session_attach.index', ['session' => $session_attach->session->id]);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseSessionAttach $session_attach)
    {
        Storage::delete($session_attach->file);
        $session_attach->delete();
    }
}
