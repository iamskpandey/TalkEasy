<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $fillable = [
        'course_id',
        'lesson_id',
        'title',
        'description',
        'language_level',
        'skill_focus',
        'estimated_time',
        'instructions',
        'exercise_type',
        'case_sensitive'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function fillBlankQuestions()
    {
        return $this->hasMany(FillBlankQuestion::class)->orderBy('order');
    }
}

