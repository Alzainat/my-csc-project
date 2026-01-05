<?php

namespace App\Http\Controllers\Student;
use App\Notifications\StudentRequestedCourse;
use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CourseRegistrationController extends Controller
{
    public function store(Course $course)
    {
        $course->students()->syncWithoutDetaching([
            Auth::id() => ['status' => 'pending']
        ]);

        $course->teacher->notify(
        new StudentRequestedCourse(auth()->user(), $course)
    );

        return back()->with('success', 'Registration request sent');
    }
}
