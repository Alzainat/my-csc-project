<?php
namespace App\Events;

use App\Models\CourseMessage;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class CourseMessageSent implements ShouldBroadcastNow
{
    public function __construct(
        public CourseMessage $message
    ) {}

    public function broadcastOn()
    {
        return new PrivateChannel('course.' . $this->message->course_id);
    }

    public function broadcastAs()
    {
        return 'course.message';
    }
}