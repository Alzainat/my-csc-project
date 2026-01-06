<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class CourseApproved extends Notification
{
    use Queueable;

    public function __construct(public $course) {}

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "You have been approved for {$this->course->title}",
            'course_id' => $this->course->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => "You have been approved for {$this->course->title}",
            'course_id' => $this->course->id,
        ]);
    }
}