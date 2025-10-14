<?php

namespace App\Http\Controllers;

use App\Models\CourseSession;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCourseSessionRequest;
use App\Http\Requests\FileUploadRequest;
use App\Http\Resources\AdminCourseSessionDigestResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseSessionController extends Controller
{
    private static $FOLDER = "public/session_raw_videos";
    private static $TEMP_FOLDER = "public/uploads_temp";
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course, Request $request)
    {
        return view('admin.course.session.list', [
            'course' => $course,
            'items' => AdminCourseSessionDigestResource::collection($course->sessions()->withCount(['attaches'])->get())->toArray($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        return view('admin.course.session.create', ['course' => $course]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Course $course, CreateCourseSessionRequest $request)
    {
        if($request->has('link')) {
            $request['file'] = $request['link'];
            $request['should_chunk'] = false;
        }

        $request['course_id'] = $course->id;
        CourseSession::create($request->toArray());
        return redirect()->route('course.session.index', ['course' => $course->id]);
    }

    public function fileUploader(CourseSession $session) {
        return view('admin.course.session.fileUploader', ['course' => $session->course->title, 'session' => $session]);
    }

    public function doFileUploader(CourseSession $session, FileUploadRequest $request) {

        $chunk = $request->file('file');
        $chunkIndex = $request->chunkIndex;
        $totalChunks = $request->totalChunks;
        $fileName = $request->fileName;

        // مسیر موقت برای ذخیره چانک‌ها
        $tempDir = storage_path(self::$TEMP_FOLDER . $fileName);
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        // ذخیره چانک با نام شماره چانک
        $chunk->move($tempDir, $chunkIndex);

        // اگر همه چانک‌ها آپلود شد، فایل اصلی رو می‌سازیم
        $uploadedChunks = scandir($tempDir);
        $uploadedChunks = array_diff($uploadedChunks, ['.', '..']);

        if (count($uploadedChunks) == $totalChunks) {
            $finalPath = storage_path(self::$TEMP_FOLDER . $fileName);
            $out = fopen($finalPath, 'wb');

            for ($i = 0; $i < $totalChunks; $i++) {
                $chunkPath = $tempDir . '/' . $i;
                $in = fopen($chunkPath, 'rb');
                stream_copy_to_stream($in, $out);
                fclose($in);
            }
            fclose($out);

            // حذف چانک‌های موقت بعد از ادغام
            foreach ($uploadedChunks as $chunkFile) {
                unlink($tempDir . '/' . $chunkFile);
            }
            rmdir($tempDir);

            $session->file = $fileName;
            $session->should_chunk = true;
            $session->chunk_at = null;
            $session->save();

            return response()->json(['message' => 'File uploaded successfully', 'file' => $fileName]);
        }

        return response()->json(['message' => 'Chunk ' . $chunkIndex . ' uploaded']);
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseSession $session)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseSession $session)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseSession $session)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseSession $session)
    {
        if($session->file != null && 
            !str_starts_with($session->file, 'http') &&
            str_starts_with($session->file, self::$FOLDER)
        )
            Storage::delete($session);

        if(sizeof($session->attaches) > 0) {
            $controller = new CourseSessionAttachController();
            foreach($session->attaches as $attach) {
                $controller->destroy($attach);
            }
        }

        $session->delete();
    }
}
