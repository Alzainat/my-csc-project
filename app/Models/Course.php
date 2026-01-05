<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'title',
        'description',
        'price',
        'status',
    ];

    
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    
    public function students()
    {
        return $this->belongsToMany(User::class, 'course_student', 'course_id', 'student_id')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    
    public function messages()
    {
        return $this->hasMany(CourseMessage::class);
    }
}