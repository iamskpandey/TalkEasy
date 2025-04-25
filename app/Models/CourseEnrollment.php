<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseEnrollment extends Pivot
{
    protected $table = 'course_enrollments';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'course_id',
        'status',
        'enrolled_at',
        'completed_at'
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
