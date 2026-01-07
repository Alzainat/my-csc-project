<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\PrivateChannel;

class StudentRequestedCourse extends Notification implements ShouldBroadcast
{
    use Queueable;

    public function __construct(
        public $student,
        public $course
    ) {}

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'student_name' => $this->student->name,
            'course_title' => $this->course->title,
            'message' => "{$this->student->name} requested to join {$this->course->title}",
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => "{$this->student->name} requested to join {$this->course->title}",
        ]);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.' . $this->notifiable->id);
    }
}
