<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\TeacherDashboardController;
use App\Http\Controllers\Teacher\CourseController;
use App\Http\Controllers\Teacher\CourseRequestController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use App\Http\Controllers\Student\CourseRegistrationController;
use App\Http\Controllers\CourseChatController;
use App\Http\Controllers\Student\MyCoursesController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/courses/{course}/chat', [CourseChatController::class, 'fetch']);
    Route::post('/courses/{course}/chat', [CourseChatController::class, 'send']);
});

/*
|--------------------------------------------------------------------------
| Authenticated user routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Teacher routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'teacher'])->prefix('teacher')->group(function () {

    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])
        ->name('teacher.dashboard');

    Route::get('/courses', [CourseController::class, 'index'])
        ->name('teacher.courses.index');

    Route::get('/courses/create', [CourseController::class, 'create'])
        ->name('teacher.courses.create');

    Route::post('/courses', [CourseController::class, 'store'])
        ->name('teacher.courses.store');

    Route::post('/requests/{course}/{student}/approve', [CourseRequestController::class, 'approve'])
        ->name('teacher.requests.approve');

    Route::post('/requests/{course}/{student}/reject', [CourseRequestController::class, 'reject'])
        ->name('teacher.requests.reject');
});

/*
|--------------------------------------------------------------------------
| Student routes
|--------------------------------------------------------------------------
*/

    Route::middleware(['auth', 'student'])->group(function () {
    Route::get('/courses', [StudentCourseController::class, 'index'])
        ->name('student.courses.index');

    Route::post('/courses/{course}/register',
        [CourseRegistrationController::class, 'store']
    )->name('student.courses.register');    
});
Route::middleware(['auth','student'])->group(function () {
    Route::get('/my-courses',
        [MyCoursesController::class, 'index']
    )->name('student.my-courses');
});

Route::middleware('auth')->group(function () {

    Route::get('/courses/{course}/chat', 
        [\App\Http\Controllers\CourseChatController::class, 'fetch']
    );

    Route::post('/courses/{course}/chat', 
        [\App\Http\Controllers\CourseChatController::class, 'send']
    );

});


require __DIR__.'/auth.php';