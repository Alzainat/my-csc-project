<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('status', 'active')
            ->with('teacher')
            ->get();

        return view('courses.index', compact('courses'));
    }
}