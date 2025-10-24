<?php

namespace App\Http\Controllers;

use App\Enums\UserLevel;
use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\AdminCourseDigestResource;
use App\Http\Resources\CoursePublicResource;
use App\Http\Resources\PublicDetailedCourseResource;
use App\Http\Resources\PurchasedCourseResource;
use App\Models\PublicSeoTag;
use App\Models\Purchase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    private static $FOLDER = 'public/course_pics';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->user()->level == UserLevel::ADMIN->name)
            return view('admin.course.list', [
                'items' => AdminCourseDigestResource::collection(Course::withCount(['purchases', 'sessions', 'attaches'])
                    ->orderBy('priority', 'asc')
                    ->orderBy('created_at', 'desc')
                    ->get()
                )->toArray($request)
            ]);

        return view('public.course.list', [
            'items' => CoursePublicResource::collection(Course::visible()->orderBy('priority', 'asc')->get()->toArray($request))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.course.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCourseRequest $request)
    {
        $path = $request->file('img_file')->store(self::$FOLDER);
        $request['img'] = $path;
        Course::create($request->toArray());
        return redirect()->route('course.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, Request $request)
    {
        if(
            $request->user() != null &&
            (
                Purchase::whereCourseId($course->id)->whereUserId($request->user()->id)->count() > 0 ||
                SubscriptionController::hasAccess($request->user()->id, $course->lessons()->distinct()->pluck('grade_id'))
            )
        ) {
            return view('public.course.show', [
                'item' => PurchasedCourseResource::make($course->with([
                    'sessions' => function ($query) {
                        $query->ready()->with(['attaches']);
                    },
                    'attaches', 'tags', 'seo_tags', 'lessons'
                ])->whereId($course->id)->first())->toArray($request),
                'seo_tags' => PublicSeoTag::all(),
                'is_owner' => true,
            ]);
        }
        return view('public.course.show', [
                'item' => PublicDetailedCourseResource::make($course->with([
                    'sessions' => function ($query) {
                        $query->ready()->withCount(['attaches']);
                    }, 'tags', 'seo_tags', 'lessons'
                ])->withCount(['attaches'])->whereId($course->id)->first())->toArray($request),
                'seo_tags' => PublicSeoTag::all(),
                'is_owner' => false,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return view('admin.course.create', ['item' => $course]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        if($request->has('img_file')) {
            $path = $request->file('img_file')->store(self::$FOLDER);
            Storage::delete($course->img);
            $course->img = $path;
        }

        $course->title = $request->title;
        $course->duration = $request->duration;
        $course->description = $request->description;
        $course->price = $request->price;
        $course->rate = $request->rate;
        $course->priority = $request->priority;
        $course->visibility = $request->visibility;
        $course->save();

        return redirect()->route('course.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        try {
            $attaches = $course->attaches;
            $img = $course->img;
            $result = $course->delete();
            if($result != null && $result) {
                Storage::delete($img);
                $courseAttachController = new CourseAttachController();
                foreach($attaches as $attach) {
                    $courseAttachController->destroy($attach);
                }
            }
        }
        catch(Exception $e) {
            abort(409, 'به دلیل داشتن خریدار در این دوره، امکان حذف آن وجود ندارد');
        }
    }

    
    /**
     * Display a listing of the resource.
     */
    public function myCourses(Request $request)
    {
        return view('student.course.list', [
            'courses' => CoursePublicResource::collection(
                Purchase::whereUserId($request->user()->id)
                    ->with('course')
                    ->get()
                    ->map(function ($a) {
                        return $a->course;
                    })
            )->toArray($request)]);
    }
}
