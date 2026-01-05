<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;

class CourseRequestController extends Controller
{
    public function approve(Course $course, User $student)
    {
        $course->students()->updateExistingPivot($student->id, [
            'status' => 'approved'
        ]);

        return back()->with('success', 'Student approved');
    }

    public function reject(Course $course, User $student)
    {
        $course->students()->updateExistingPivot($student->id, [
            'status' => 'rejected'
        ]);

        return back()->with('success', 'Student rejected');
    }
}