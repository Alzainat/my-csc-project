<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MyCoursesController extends Controller
{
    public function index()
    {
        $student = Auth::user();

        $courses = $student->enrolledCourses()
            ->with('teacher')
            ->get();

        return view('student.my-courses', compact('courses'));
    }
}
