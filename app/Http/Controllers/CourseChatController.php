<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseChatController extends Controller
{
    public function fetch(Course $course)
    {
        $this->authorizeCourse($course);

        return $course->messages()
            ->with('user')
            ->orderBy('created_at')
            ->get();
    }

    public function send(Request $request, Course $course)
    {
        $this->authorizeCourse($course);

        $request->validate([
            'message' => 'required|string'
        ]);

        $course->messages()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return response()->json(['success' => true]);
    }

    private function authorizeCourse(Course $course)
    {
        $user = auth()->user();

        // Teacher صاحب الكورس
        if ($course->teacher_id === $user->id) {
            return;
        }

        // Student approved بالكورس
        $isApprovedStudent = $course->students()
            ->wherePivot('status', 'approved')
            ->where('users.id', $user->id)
            ->exists();

        if (! $isApprovedStudent) {
            abort(403);
        }
    }
}