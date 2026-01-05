<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::user();

        $courses = Course::where('teacher_id', $teacher->id)
            ->with('students')
            ->get();

        return view('teacher.dashboard', compact('courses'));
    }
}
