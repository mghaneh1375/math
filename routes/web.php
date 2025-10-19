<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\CourseAttachController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseFreeSessionController;
use App\Http\Controllers\CourseSeoTagController;
use App\Http\Controllers\CourseSessionAttachController;
use App\Http\Controllers\CourseSessionController;
use App\Http\Controllers\CourseTagController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PublicSeoTagController;
use App\Http\Controllers\SessionSeoTagController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'home'])->name('root');


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'adminAccess']], function() {
        
    Route::get('dashboard', [HomeController::class, 'adminDashboard'])->name('admin_dashboard');

    Route::resource('public_seo_tags', PublicSeoTagController::class)->except(['show', 'update', 'edit']);

    Route::resource('config', ConfigController::class)->only(['index', 'store']);

    Route::resource('course', CourseController::class)->except(['show', 'update']);

    Route::post('course/{course}', [CourseController::class, 'update'])->name('course.update');

    Route::resource('course.attach', CourseAttachController::class)->shallow()->except(['show', 'update']);
    
    Route::post('attach/{attach}', [CourseAttachController::class, 'update'])->name('attach.update');

    Route::resource('session.session_attach', CourseSessionAttachController::class)->shallow()->except(['show', 'update']);

    Route::post('session_attach/{session_attach}', [CourseSessionAttachController::class, 'update'])->name('session_attach.update');

    Route::resource('session.session_seo_tag', SessionSeoTagController::class)->shallow()->except(['show', 'update', 'edit']);

    Route::resource('course.session', CourseSessionController::class)->shallow();

    Route::get('session/{session}/file', [CourseSessionController::class, 'fileUploader'])->name('session.file.index');

    Route::post('session/{session}/file', [CourseSessionController::class, 'doFileUploader'])->name('session.file.store');

    Route::resource('course.free_session', CourseFreeSessionController::class)->shallow()->except(['show', 'update', 'edit', 'destroy']);

    Route::delete('free_session/{course}/{session}', [CourseFreeSessionController::class, 'destroy'])->name('free_session.destroy');

    Route::resource('course.tag', CourseTagController::class)->shallow()->except(['show']);

    Route::resource('course.seo_tag', CourseSeoTagController::class)->shallow()->except(['show', 'update', 'edit']);

    Route::post('upload_img', [HomeController::class, 'uploadImg'])->name('upload_img');

    Route::resource('offer', OfferController::class)->except(['show', 'update', 'edit']);
});


Route::group(['prefix' => 'course', 'middleware' => ['auth']], function() {

    Route::get('list', [CourseController::class, 'myCourses'])->name('my_courses');
    
    Route::get('show/{course}', [CourseController::class, 'show'])->name('course.show');

});

Route::group(['prefix' => 'public', 'middleware' => ['auth']], function() {

    Route::get('list', [CourseController::class, 'index'])->name('public_course_list');

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

});

Route::get('login', [AuthController::class, 'login'])->name('login');