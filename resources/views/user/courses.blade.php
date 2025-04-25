@extends('user.layout')

@section('title', 'My Courses')

@section('content')
<div class="page-header">
    <h2>My Courses</h2>
    <p>Manage your enrolled courses</p>
</div>

<!-- Active Courses -->
<div class="section-header">
    <h3>In Progress</h3>
</div>

@if($activeEnrollments->isNotEmpty())
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
            <div class="course-info">
                <span><i class="fas fa-clock"></i> 
                    @if(is_string($enrollment->pivot->enrolled_at))
                        Enrolled: {{ $enrollment->pivot->enrolled_at }}
                    @else
                        Enrolled: {{ $enrollment->pivot->enrolled_at->format('M d, Y') }}
                    @endif
                </span>
                <span><i class="fas fa-calendar"></i> {{ $enrollment->duration }} weeks</span>
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

<div class="pagination-container" style="display: flex; justify-content: center; margin-top: 20px;">
    {{ $activeEnrollments->links() }}
</div>
@else
<div class="empty-state">
    <div style="text-align: center; padding: 40px 0;">
        <i class="fas fa-graduation-cap" style="font-size: 3rem; color: #6c757d; margin-bottom: 15px;"></i>
        <h3>No Courses In Progress</h3>
        <p>You don't have any active courses. Browse our catalog to find your perfect course.</p>
        <a href="{{ route('courses') }}" class="btn btn-primary" style="margin-top: 15px;">Explore Courses</a>
    </div>
</div>
@endif

<div class="section-header" style="margin-top: 40px;">
    <h3>Completed</h3>
</div>

@if($completedEnrollments->isNotEmpty())
<div class="course-cards">
    @foreach($completedEnrollments as $enrollment)
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
            <div class="course-info">
                <span><i class="fas fa-clock"></i> 
                    @if(is_string($enrollment->pivot->completed_at))
                        Completed: {{ $enrollment->pivot->completed_at }}
                    @else
                        Completed: {{ $enrollment->pivot->completed_at->format('M d, Y') }}
                    @endif
                </span>
                <span><i class="fas fa-award"></i> 100% Complete</span>
            </div>
            
            <div class="progress-bar">
                <div class="progress-fill" style="width: 100%"></div>
            </div>
            
            <div class="course-actions">
                @php
                    $firstLesson = $enrollment->sections->flatMap->lessons->first();
                @endphp
                @if($firstLesson)
                    <a href="{{ route('user.lesson.content', [$enrollment->id, $firstLesson->id]) }}" class="btn btn-outline">Review Course</a>
                @else
                    <a href="{{ route('user.course.progress', $enrollment->id) }}" class="btn btn-outline">Review Course</a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="pagination-container" style="display: flex; justify-content: center; margin-top: 20px;">
    {{ $completedEnrollments->links() }}
</div>
@else
<div class="empty-state">
    <div style="text-align: center; padding: 40px 0;">
        <i class="fas fa-trophy" style="font-size: 3rem; color: #6c757d; margin-bottom: 15px;"></i>
        <h3>No Completed Courses Yet</h3>
        <p>Keep learning! You haven't completed any courses yet.</p>
    </div>
</div>
@endif
@endsection 