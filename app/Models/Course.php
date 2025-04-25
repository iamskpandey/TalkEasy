<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CourseEnrollment;

class Course extends Model
{
    protected $fillable = [
        'title',
        'description',
        'short_description',
        'language_level',
        'language',
        'instructor',
        'duration',
        'price',
        'image_path'
    ];

    public function sections()
    {
        return $this->hasMany(CourseSection::class)->orderBy('order');
    }
    
    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }
    
    public function enrolledUsers()
    {
        return $this->belongsToMany(User::class, 'course_enrollments')
                    ->using(CourseEnrollment::class)
                    ->withPivot('status', 'enrolled_at', 'completed_at')
                    ->withTimestamps();
    }
    
    public function progress()
    {
        return $this->hasMany(CourseProgress::class);
    }
    
    public function activeEnrollments()
    {
        return $this->enrolledUsers()->wherePivot('status', 'active');
    }
    
    public function completedEnrollments()
    {
        return $this->enrolledUsers()->wherePivot('status', 'completed');
    }
}
