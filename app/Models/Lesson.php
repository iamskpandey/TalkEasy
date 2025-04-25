<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'course_section_id',
        'title',
        'content',
        'media_path',
        'order'
    ];

    public function section()
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id');
    }

    public function progress()
    {
        return $this->hasMany(CourseProgress::class);
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
