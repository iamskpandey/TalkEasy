<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\CourseEnrollment;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_instructor',
        'is_admin',
        'language_preference',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'course_enrollments')
            ->using(CourseEnrollment::class)
            ->withPivot('status', 'enrolled_at', 'completed_at')
            ->withTimestamps();
    }

    public function courseProgress()
    {
        return $this->hasMany(CourseProgress::class);
    }

    public function activeEnrollments()
    {
        return $this->enrolledCourses()->wherePivot('status', 'active');
    }

    public function completedEnrollments()
    {
        return $this->enrolledCourses()->wherePivot('status', 'completed');
    }
}
