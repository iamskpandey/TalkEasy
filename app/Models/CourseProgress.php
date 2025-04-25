<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseProgress extends Model
{
    protected $table = 'course_progress';

    protected $fillable = [
        'user_id',
        'course_id',
        'section_id',
        'lesson_id',
        'completed',
        'last_accessed_at',
        'completed_at',
        'progress_percentage',
        'quiz_scores',
        'exercise_completion'
    ];

    protected $casts = [
        'completed' => 'boolean',
        'last_accessed_at' => 'datetime',
        'completed_at' => 'datetime',
        'progress_percentage' => 'integer',
        'quiz_scores' => 'array',
        'exercise_completion' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function section()
    {
        return $this->belongsTo(CourseSection::class, 'section_id');
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
