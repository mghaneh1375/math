<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CoursePublicResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    private static $CK_PATH = 'public/ck';

    public function login() {
        return view('login');
    }

    public function logout() {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }

    public function home(Request $request) {
        return view('home', [
            'courses' => CoursePublicResource::collection(
                Course::visible()->hasSession()
                    ->withCount(['sessions' => function ($query) {
                        $query->ready();
                    }])->get()
                )->toArray($request)
        ]);
    }

    public function contactUs() {
        return view('contactUs');
    }

    public function aboutUs() {
        return view('aboutUs');
    }

    public function adminDashboard() {
        return view('admin.dashboard');
    }
    
    public function uploadImg(Request $request) {

        $request->validate([
            'upload' => 'required|image'
        ]);

        $filename = $request->file('upload')->store(self::$CK_PATH);
        return response()->json(['status' => 'ok', 'url' => Storage::url($filename)]);
    }
}
