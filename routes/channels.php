<?php

use App\Models\Course;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('course.{courseId}', function ($user, $courseId) {
    $course = Course::find($courseId);
    if (! $course) return false;

    // Teacher
    if ($course->teacher_id === $user->id) {
        return true;
    }

    // Approved student
    return $course->students()
        ->where('users.id', $user->id)
        ->wherePivot('status', 'approved')
        ->exists();
});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
