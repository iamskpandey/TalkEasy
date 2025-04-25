@extends('user.layout')

@section('title', $course->title)

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2>{{ $course->title }}</h2>
            <p>{{ $course->short_description }}</p>
        </div>
        <div>
            <span class="badge {{ $course->language_level }}" style="padding: 5px 15px; border-radius: 20px; font-size: 0.9rem;">
                {{ ucfirst($course->language_level) }}
            </span>
        </div>
    </div>
</div>

<div class="course-overview" style="margin-bottom: 30px;">
    <div class="row" style="display: flex; gap: 20px;">
        <div class="col" style="flex: 3;">
            <div style="background-color: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                    <div>
                        <h3 style="margin-bottom: 5px;">Course Progress</h3>
                        <p>Track your learning journey</p>
                    </div>
                    <div style="display: flex; align-items: center;">
                        <span style="font-size: 1.5rem; font-weight: bold; margin-right: 10px;">{{ $overallProgress->progress_percentage }}%</span>
                        <div style="width: 50px; height: 50px; border-radius: 50%; display: flex; justify-content: center; align-items: center; background-color: {{ $overallProgress->progress_percentage == 100 ? '#28a745' : '#4A6FDC' }}; color: white;">
                            @if($overallProgress->progress_percentage == 100)
                            <i class="fas fa-check"></i>
                            @else
                            <i class="fas fa-book-reader"></i>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="progress-bar" style="height: 10px; margin-bottom: 20px;">
                    <div class="progress-fill" style="width: {{ $overallProgress->progress_percentage }}%; background-color: {{ $overallProgress->progress_percentage == 100 ? '#28a745' : '#4A6FDC' }};"></div>
                </div>
                
                <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                    <div style="flex: 1; text-align: center; padding: 15px; background-color: #f8f9fa; border-radius: 8px;">
                        <h4 style="font-size: 0.9rem; color: #6c757d; margin-bottom: 5px;">Instructor</h4>
                        <p style="font-weight: bold;">{{ $course->instructor }}</p>
                    </div>
                    <div style="flex: 1; text-align: center; padding: 15px; background-color: #f8f9fa; border-radius: 8px;">
                        <h4 style="font-size: 0.9rem; color: #6c757d; margin-bottom: 5px;">Language</h4>
                        <p style="font-weight: bold;">{{ ucfirst($course->language) }}</p>
                    </div>
                    <div style="flex: 1; text-align: center; padding: 15px; background-color: #f8f9fa; border-radius: 8px;">
                        <h4 style="font-size: 0.9rem; color: #6c757d; margin-bottom: 5px;">Duration</h4>
                        <p style="font-weight: bold;">{{ $course->duration }} weeks</p>
                    </div>
                </div>
                
                <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; margin-top: 15px;">
                    <h4 style="margin-bottom: 10px;">Course Description</h4>
                    <p>{{ $course->description }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<h3 style="margin-bottom: 15px;">Course Content</h3>

<div class="lessons-list">
    @foreach($course->sections as $section)
    <div class="lessons-section">
        <div class="section-header">
            <div class="section-title">
                <span>{{ $section->title }}</span>
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
        
        <div class="section-lessons">
            @foreach($section->lessons as $lesson)
            @php
                $lessonProgress = $lesson->progress->where('user_id', Auth::id())->first();
                $statusClass = !$lessonProgress ? 'not-started' : ($lessonProgress->completed ? 'completed' : 'in-progress');
                $statusIcon = !$lessonProgress ? 'circle' : ($lessonProgress->completed ? 'check-circle' : 'play-circle');
            @endphp
            <div class="lesson-item">
                <div class="lesson-title">
                    <i class="fas fa-{{ $statusIcon }}"></i>
                    <span>{{ $lesson->title }}</span>
                </div>
                
                <div class="lesson-actions">
                    @if($lessonProgress && $lessonProgress->completed)
                    <a href="{{ route('user.lesson.content', [$course->id, $lesson->id]) }}" class="btn btn-sm btn-outline" 
                           style="padding: 3px 10px; font-size: 0.8rem;">
                        Review Lesson
                    </a>
                    @else
                    <a href="{{ route('user.lesson.content', [$course->id, $lesson->id]) }}" class="btn btn-sm btn-primary" 
                           style="padding: 3px 10px; font-size: 0.8rem;">
                        {{ $lessonProgress ? 'Continue' : 'Start' }}
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script>
    function markLessonProgress(courseId, lessonId, completed) {
        fetch(`/dashboard/course/${courseId}/lesson/${lessonId}/progress`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ completed: completed })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const firstSection = document.querySelector('.section-lessons');
        if (firstSection) {
            firstSection.classList.add('active');
            firstSection.previousElementSibling.querySelector('i').classList.remove('fa-chevron-down');
            firstSection.previousElementSibling.querySelector('i').classList.add('fa-chevron-up');
        }
    });
</script>
@endsection

@section('styles')
<style>
    .section-lessons {
        display: none;
    }
    
    .section-lessons.active {
        display: block;
    }
    
    .badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .badge.beginner {
        background-color: #d4edda;
        color: #155724;
    }
    
    .badge.intermediate {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .badge.advanced {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .btn-sm {
        padding: 5px 10px;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
    }
</style>
@endsection 