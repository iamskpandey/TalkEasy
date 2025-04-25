<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

Route::get('/', function () {
    return view('homepage');
})->name('homepage');

Route::get('/courses', function () {
    $courses = \App\Models\Course::with('sections.lessons')->latest()->take(3)->get();
    return view('courses', compact('courses'));
})->name('courses');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');
Route::post('login', [LoginController::class, 'login'])
    ->middleware('guest');
Route::post('logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])
    ->name('register')
    ->middleware('guest');
Route::post('register', [RegisterController::class, 'register'])
    ->middleware('guest');

Route::get('password/reset', function () {
    return view('password.reset');
})->name('password.request');

Route::prefix('dashboard')->name('user.')->middleware(['auth'])->group(function () {
    Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');

    Route::get('/courses', [UserDashboardController::class, 'courses'])->name('courses');
    Route::get('/course/{courseId}/progress', [UserDashboardController::class, 'courseProgress'])->name('course.progress');
    Route::post('/course/{courseId}/lesson/{lessonId}/progress', [UserDashboardController::class, 'updateLessonProgress'])->name('lesson.progress.update');
    Route::get('/course/{courseId}/lesson/{lessonId}', [UserDashboardController::class, 'lessonContent'])->name('lesson.content');

    Route::post('/course/{courseId}/enroll', [UserDashboardController::class, 'enrollCourse'])->name('course.enroll');

    Route::get('/profile', [UserDashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [UserDashboardController::class, 'updateProfile'])->name('profile.update');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/courses', [AdminController::class, 'courses'])->name('courses');
    Route::get('/courses/create', [AdminController::class, 'createCourse'])->name('courses.create');
    Route::post('/courses', [AdminController::class, 'storeCourse'])->name('courses.store');
    Route::get('/courses/{courseId}/lessons', [AdminController::class, 'getCourseLessons'])->name('courses.lessons');

    Route::get('/exercises', [AdminController::class, 'exercises'])->name('exercises');
    Route::get('/exercises/create', [AdminController::class, 'createExercise'])->name('exercises.create');
    Route::post('/exercises', [AdminController::class, 'storeExercise'])->name('exercises.store');

    Route::get('/quizzes', [AdminController::class, 'quizzes'])->name('quizzes');
    Route::get('/quizzes/create', [AdminController::class, 'createQuiz'])->name('quizzes.create');
    Route::post('/quizzes', [AdminController::class, 'storeQuiz'])->name('quizzes.store');
});
