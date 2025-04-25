<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\CourseProgress;
use Illuminate\Support\Facades\Auth;
use App\Models\Exercise;
use App\Models\Quiz;

class UserDashboardController extends Controller
{
    public function __construct()
    {
    }
    
    public function index()
    {
        $user = Auth::user();
        
        $activeEnrollments = $user->activeEnrollments()->with(['progress' => function($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->get();
        
        $recentlyAccessed = CourseProgress::where('user_id', $user->id)
            ->orderBy('last_accessed_at', 'desc')
            ->with('course')
            ->take(3)
            ->get()
            ->pluck('course')
            ->unique('id');
            
        $totalCourses = $user->enrolledCourses()->count();
        $completedCourses = $user->completedEnrollments()->count();
        $averageProgress = $user->courseProgress()
            ->avg('progress_percentage') ?? 0;
            
        return view('user.dashboard', compact(
            'user', 
            'activeEnrollments', 
            'recentlyAccessed',
            'totalCourses',
            'completedCourses',
            'averageProgress'
        ));
    }
    
    public function courses()
    {
        $user = Auth::user();
        
        $activeEnrollments = $user->activeEnrollments()
            ->withPivot(['enrolled_at'])
            ->with(['progress' => function($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->paginate(10);
            
        $completedEnrollments = $user->completedEnrollments()
            ->withPivot(['completed_at'])
            ->paginate(10);
            
        return view('user.courses', compact('activeEnrollments', 'completedEnrollments'));
    }
    
    public function courseProgress($courseId)
    {
        $user = Auth::user();
        $course = Course::with(['sections.lessons' => function($query) use ($user) {
            $query->with(['progress' => function($q) use ($user) {
                $q->where('user_id', $user->id);
            }]);
        }])->findOrFail($courseId);
        
        $enrollment = CourseEnrollment::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->first();
            
        if (!$enrollment) {
            return redirect()->route('user.courses')
                ->with('error', 'You are not enrolled in this course');
        }
        
        $overallProgress = CourseProgress::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->whereNull('lesson_id')
            ->first();
            
        if (!$overallProgress) {
            $overallProgress = new CourseProgress([
                'user_id' => $user->id,
                'course_id' => $courseId,
                'progress_percentage' => 0
            ]);
            $overallProgress->save();
        }
        
        return view('user.course-progress', compact('course', 'enrollment', 'overallProgress'));
    }
    
    public function updateLessonProgress(Request $request, $courseId, $lessonId)
    {
        $user = Auth::user();
        
        $progress = CourseProgress::firstOrNew([
            'user_id' => $user->id,
            'course_id' => $courseId,
            'lesson_id' => $lessonId
        ]);
        
        $progress->last_accessed_at = now();
        
        if ($request->has('completed') && $request->completed) {
            $progress->completed = true;
            $progress->completed_at = now();
        }
        
        $progress->save();
        
        $this->updateOverallCourseProgress($user->id, $courseId);
        
        return response()->json([
            'success' => true,
            'progress' => $progress
        ]);
    }
    
    private function updateOverallCourseProgress($userId, $courseId)
    {
        $course = Course::with('sections.lessons')->find($courseId);
        $totalLessons = 0;
        
        foreach ($course->sections as $section) {
            $totalLessons += $section->lessons->count();
        }
        
        $completedLessons = CourseProgress::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->where('completed', true)
            ->whereNotNull('lesson_id')
            ->count();
            
        $progressPercentage = $totalLessons > 0 
            ? round(($completedLessons / $totalLessons) * 100) 
            : 0;
            
        $overallProgress = CourseProgress::firstOrNew([
            'user_id' => $userId,
            'course_id' => $courseId,
            'lesson_id' => null,
            'section_id' => null,
        ]);
        
        $overallProgress->progress_percentage = $progressPercentage;
        
        if ($progressPercentage >= 100) {
            $enrollment = CourseEnrollment::where('user_id', $userId)
                ->where('course_id', $courseId)
                ->first();
                
            if ($enrollment && $enrollment->status !== 'completed') {
                $enrollment->status = 'completed';
                $enrollment->completed_at = now();
                $enrollment->save();
                
                $overallProgress->completed = true;
                $overallProgress->completed_at = now();
            }
        }
        
        $overallProgress->save();
    }
    
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }
    
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        
        $user->save();
        
        return redirect()->route('user.profile')
            ->with('success', 'Profile updated successfully');
    }
    
    public function enrollCourse($courseId)
    {
        $user = Auth::user();
        $course = Course::findOrFail($courseId);
        
        $existingEnrollment = CourseEnrollment::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->first();
            
        if ($existingEnrollment) {
            return redirect()->route('user.dashboard')
                ->with('info', 'You are already enrolled in this course');
        }
        
        $enrollment = new CourseEnrollment([
            'user_id' => $user->id,
            'course_id' => $courseId,
            'status' => 'active',
            'enrolled_at' => now()
        ]);
        
        $enrollment->save();
        
        $progress = new CourseProgress([
            'user_id' => $user->id,
            'course_id' => $courseId,
            'progress_percentage' => 0
        ]);
        
        $progress->save();
        
        return redirect()->route('user.dashboard')
            ->with('success', 'Successfully enrolled in ' . $course->title);
    }
    
    public function lessonContent($courseId, $lessonId)
    {
        $user = Auth::user();
        $course = Course::with(['sections.lessons' => function($query) use ($user) {
            $query->with(['progress' => function($q) use ($user) {
                $q->where('user_id', $user->id);
            }]);
        }])->findOrFail($courseId);
        
        $lesson = $course->sections->flatMap->lessons->firstWhere('id', $lessonId);
        
        if (!$lesson) {
            return redirect()->route('user.course.progress', $courseId)
                ->with('error', 'Lesson not found');
        }
        
        $enrollment = CourseEnrollment::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->first();
            
        if (!$enrollment) {
            return redirect()->route('user.dashboard')
                ->with('error', 'You are not enrolled in this course');
        }
        
        $progress = CourseProgress::firstOrNew([
            'user_id' => $user->id,
            'course_id' => $courseId,
            'lesson_id' => $lessonId
        ]);
        
        if (!$progress->exists) {
            $progress->progress_percentage = 0;
            $progress->save();
        }
        
        $progress->last_accessed_at = now();
        $progress->save();
        
        $exercises = collect();
        $quizzes = collect();

        try {
            if (class_exists('App\\Models\\Exercise') && class_exists('App\\Models\\Quiz')) {
                $exercises = Exercise::where('lesson_id', $lessonId)->get();
                $quizzes = Quiz::where('lesson_id', $lessonId)->get();
            }
        } catch (\Exception $e) {
        }
        
        return view('user.lesson-content', compact(
            'course', 
            'lesson', 
            'progress', 
            'exercises', 
            'quizzes'
        ));
    }
}
