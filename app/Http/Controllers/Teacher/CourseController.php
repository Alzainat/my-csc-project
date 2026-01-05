<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('teacher_id', Auth::id())->get();

        return view('teacher.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('teacher.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'nullable|numeric',
        ]);

        Course::create([
            'teacher_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price ?? 0,
            'status' => 'active',
        ]);

        return redirect()->route('teacher.courses.index')
            ->with('success', 'Course created successfully');
    }
}
