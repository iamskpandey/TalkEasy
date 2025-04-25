@extends('user.layout')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h2>Dashboard</h2>
    <p>Welcome back, {{ $user->name }}</p>
</div>

<div class="stats-cards">
    <div class="stat-card">
        <div class="stat-card-content">
            <h3>My Courses</h3>
            <p class="stat-number">{{ $totalCourses }}</p>
        </div>
        <div class="stat-card-icon">
            <i class="fas fa-graduation-cap"></i>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-content">
            <h3>Completed</h3>
            <p class="stat-number">{{ $completedCourses }}</p>
        </div>
        <div class="stat-card-icon">
            <i class="fas fa-check-circle"></i>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-content">
            <h3>Average Progress</h3>
            <p class="stat-number">{{ round($averageProgress) }}%</p>
        </div>
        <div class="stat-card-icon">
            <i class="fas fa-chart-line"></i>
        </div>
    </div>
</div>

@if($activeEnrollments->isNotEmpty())
<div class="page-header">
    <h3>In Progress</h3>
</div>

<div class="course-cards">
    @foreach($activeEnrollments as $enrollment)
    <div class="course-card">
        <div class="course-image">
            @if($enrollment->image_path)
            <img src="{{ asset('storage/' . $enrollment->image_path) }}" alt="{{ $enrollment->title }}">
            @else
            <img src="https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&h=300" alt="{{ $enrollment->title }}">
            @endif
            <div class="course-level {{ $enrollment->language_level }}">{{ ucfirst($enrollment->language_level) }}</div>
        </div>
        <div class="course-content">
            <h3 class="course-title">{{ $enrollment->title }}</h3>
            <div class="course-info">
                <span><i class="fas fa-globe"></i> {{ ucfirst($enrollment->language) }}</span>
                <span><i class="fas fa-user"></i> {{ $enrollment->instructor }}</span>
            </div>
            
            @php
                $progress = $enrollment->progress->first() ? $enrollment->progress->first()->progress_percentage : 0;
            @endphp
            
            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ $progress }}%"></div>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span>Progress: {{ $progress }}%</span>
            </div>
            
            <div class="course-actions">
                @php
                    $firstLesson = $enrollment->sections->flatMap->lessons->first();
                @endphp
                @if($firstLesson)
                    <a href="{{ route('user.lesson.content', [$enrollment->id, $firstLesson->id]) }}" class="btn btn-primary">Continue Learning</a>
                @else
                    <a href="{{ route('user.course.progress', $enrollment->id) }}" class="btn btn-primary">View Course</a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="empty-state">
    <div style="text-align: center; padding: 40px 0;">
        <i class="fas fa-graduation-cap" style="font-size: 3rem; color: #6c757d; margin-bottom: 15px;"></i>
        <h3>No Courses Yet</h3>
        <p>You haven't enrolled in any courses yet. Browse our catalog to find your perfect course.</p>
        <a href="{{ route('courses') }}" class="btn btn-primary" style="margin-top: 15px;">Explore Courses</a>
    </div>
</div>
@endif

@if($recentlyAccessed->isNotEmpty())
<div class="page-header">
    <h3>Recently Accessed</h3>
</div>

<div class="course-cards">
    @foreach($recentlyAccessed as $course)
    <div class="course-card">
        <div class="course-image">
            @if($course->image_path)
            <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}">
            @else
            <img src="https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&h=300" alt="{{ $course->title }}">
            @endif
            <div class="course-level {{ $course->language_level }}">{{ ucfirst($course->language_level) }}</div>
        </div>
        <div class="course-content">
            <h3 class="course-title">{{ $course->title }}</h3>
            <div class="course-info">
                <span><i class="fas fa-globe"></i> {{ ucfirst($course->language) }}</span>
                <span><i class="fas fa-user"></i> {{ $course->instructor }}</span>
            </div>
            
            @php
                $progress = $course->progress->where('user_id', $user->id)->first() 
                    ? $course->progress->where('user_id', $user->id)->first()->progress_percentage 
                    : 0;
            @endphp
            
            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ $progress }}%"></div>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span>Progress: {{ $progress }}%</span>
            </div>
            
            <div class="course-actions">
                @php
                    $firstLesson = $course->sections->flatMap->lessons->first();
                @endphp
                @if($firstLesson)
                    <a href="{{ route('user.lesson.content', [$course->id, $firstLesson->id]) }}" class="btn btn-primary">Continue Learning</a>
                @else
                    <a href="{{ route('user.course.progress', $course->id) }}" class="btn btn-primary">View Course</a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection 