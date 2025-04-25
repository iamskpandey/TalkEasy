@extends('user.layout')

@section('title', $lesson->title)

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <a href="{{ route('user.course.progress', $course->id) }}" class="btn btn-outline" style="margin-bottom: 10px;">
                <i class="fas fa-arrow-left"></i> Back to Course
            </a>
            <h2>{{ $lesson->title }}</h2>
            <p>{{ $course->title }} @if($lesson->section) - {{ $lesson->section->title }} @endif</p>
        </div>
        <div>
            <span class="badge {{ $course->language_level }}" style="padding: 5px 15px; border-radius: 20px; font-size: 0.9rem;">
                {{ ucfirst($course->language_level) }}
            </span>
        </div>
    </div>
</div>

<div class="lesson-container">
    <div class="lesson-navigation">
        <div class="course-sections">
            <h3>Course Content</h3>
            <div class="progress-overview">
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $progress->progress_percentage ?? 0 }}%"></div>
                </div>
                <span>{{ $progress->progress_percentage ?? 0 }}% complete</span>
            </div>

            @foreach($course->sections as $section)
                <div class="section-item {{ $lesson->course_section_id == $section->id ? 'active' : '' }}">
                    <div class="section-header">
                        <span>{{ $section->title }}</span>
                        <i class="fas fa-chevron-{{ $lesson->course_section_id == $section->id ? 'down' : 'right' }}"></i>
                    </div>
                    <div class="section-lessons {{ $lesson->course_section_id == $section->id ? 'show' : '' }}">
                        @foreach($section->lessons as $lessonItem)
                            @php
                                $lessonProgress = $lessonItem->progress && $lessonItem->progress->isNotEmpty() ? $lessonItem->progress->where('user_id', Auth::id())->first() : null;
                                $statusClass = !$lessonProgress ? 'not-started' : ($lessonProgress->completed ? 'completed' : 'in-progress');
                                $statusIcon = !$lessonProgress ? 'circle' : ($lessonProgress->completed ? 'check-circle' : 'play-circle');
                                $isActive = $lessonItem->id == $lesson->id;
                            @endphp
                            <a href="{{ route('user.lesson.content', [$course->id, $lessonItem->id]) }}" 
                               class="lesson-link {{ $isActive ? 'active' : '' }}">
                                <i class="fas fa-{{ $statusIcon }} {{ $statusClass }}"></i>
                                <span>{{ $lessonItem->title }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="lesson-content-main">
        <div class="content-tabs">
            <button class="tab-button active" data-tab="lesson">Lesson</button>
            @if(count($exercises) > 0)
                <button class="tab-button" data-tab="exercises">Exercises</button>
            @endif
            @if(count($quizzes) > 0)
                <button class="tab-button" data-tab="quizzes">Quizzes</button>
            @endif
        </div>

        <div class="tab-content">
            <div class="tab-pane active" id="lesson-tab">
                @if($lesson->media_path)
                <div class="lesson-media">
                    @if(Str::endsWith($lesson->media_path, ['.mp4', '.webm', '.ogg']))
                        <video controls class="video-player">
                            <source src="{{ asset('storage/' . $lesson->media_path) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @elseif(Str::endsWith($lesson->media_path, ['.mp3', '.wav']))
                        <audio controls class="audio-player">
                            <source src="{{ asset('storage/' . $lesson->media_path) }}" type="audio/mpeg">
                            Your browser does not support the audio tag.
                        </audio>
                    @else
                        <img src="{{ asset('storage/' . $lesson->media_path) }}" alt="{{ $lesson->title }}" class="lesson-image">
                    @endif
                </div>
                @endif

                <div class="lesson-text-content">
                    {!! $lesson->content !!}
                </div>
                
                <div class="lesson-actions">
                    <div class="mark-complete">
                        @if($progress && $progress->completed)
                            <button class="btn btn-success" onclick="markLessonComplete({{ $course->id }}, {{ $lesson->id }}, false)">
                                <i class="fas fa-check-circle"></i> Marked as Complete
                            </button>
                        @else
                            <button class="btn btn-primary" onclick="markLessonComplete({{ $course->id }}, {{ $lesson->id }}, true)">
                                <i class="fas fa-check"></i> Mark as Complete
                            </button>
                        @endif
                    </div>
                    
                    <div class="lesson-navigation-buttons">
                        @php
                            $allLessons = $course->sections->flatMap->lessons->sortBy('id');
                            $currentIndex = $allLessons->search(function($item) use ($lesson) {
                                return $item->id === $lesson->id;
                            });
                            
                            $prevLesson = $currentIndex > 0 ? $allLessons[$currentIndex - 1] : null;
                            $nextLesson = $currentIndex < $allLessons->count() - 1 ? $allLessons[$currentIndex + 1] : null;
                        @endphp
                        
                        @if($prevLesson)
                            <a href="{{ route('user.lesson.content', [$course->id, $prevLesson->id]) }}" class="btn btn-outline">
                                <i class="fas fa-arrow-left"></i> Previous Lesson
                            </a>
                        @endif
                        
                        @if($nextLesson)
                            <a href="{{ route('user.lesson.content', [$course->id, $nextLesson->id]) }}" class="btn btn-primary">
                                Next Lesson <i class="fas fa-arrow-right"></i>
                            </a>
                        @else
                            <a href="{{ route('user.course.progress', $course->id) }}" class="btn btn-success">
                                Finish Course <i class="fas fa-flag-checkered"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            @if(count($exercises) > 0)
            <div class="tab-pane" id="exercises-tab">
                <div class="exercises-container">
                    <h3>Practice Exercises</h3>
                    
                    @foreach($exercises as $exercise)
                    <div class="exercise-item">
                        <div class="exercise-header">
                            <h4>{{ $exercise->title }}</h4>
                            <span class="exercise-type">{{ ucfirst($exercise->exercise_type) }}</span>
                        </div>
                        <div class="exercise-description">
                            {!! $exercise->description !!}
                        </div>
                        <div class="exercise-content">
                            @if($exercise->exercise_type == 'fill-in-blank')
                                <div class="fill-blank-exercise">
                                    <h5>{{ $exercise->instructions }}</h5>
                                    @foreach($exercise->fillBlankQuestions as $question)
                                    <div class="fill-blank-question" data-question-id="{{ $question->id }}">
                                        <p>{!! $question->getTextWithBlanksForDisplay() !!}</p>
                                    </div>
                                    @endforeach
                                    <div class="exercise-form">
                                        <button class="btn btn-primary check-fill-blank-answers">Check Answers</button>
                                    </div>
                                </div>
                            @elseif($exercise->exercise_type == 'multiple-choice')
                                <div class="multiple-choice-exercise">
                                    <p>{!! $exercise->question !!}</p>
                                    <div class="options-list">
                                        @php
                                            $options = is_string($exercise->options) ? json_decode($exercise->options) : $exercise->options;
                                        @endphp
                                        @foreach($options as $option)
                                            <div class="option-item">
                                                <input type="radio" name="exercise-{{ $exercise->id }}" id="option-{{ $loop->index }}" value="{{ $option }}">
                                                <label for="option-{{ $loop->index }}">{{ $option }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="btn btn-primary check-answer" data-answer="{{ $exercise->answer }}">Check Answer</button>
                                </div>
                            @elseif($exercise->exercise_type == 'matching')
                                <div class="matching-exercise">
                                    <div class="matching-pairs">
                                        @php
                                            $content = is_string($exercise->content) ? json_decode($exercise->content, true) : $exercise->content;
                                        @endphp
                                        @foreach($content as $pair)
                                            <div class="matching-pair">
                                                <div class="match-item">{{ $pair['left'] }}</div>
                                                <div class="match-connector"></div>
                                                <div class="match-item">{{ $pair['right'] }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if(count($quizzes) > 0)
            <div class="tab-pane" id="quizzes-tab">
                <div class="quizzes-container">
                    <h3>Knowledge Check</h3>
                    
                    @foreach($quizzes as $quiz)
                    <div class="quiz-item">
                        <h4>{{ $quiz->title }}</h4>
                        <p>{{ $quiz->description }}</p>
                        <div class="quiz-info">
                            <span><i class="fas fa-clock"></i> {{ $quiz->time_limit }} minutes</span>
                            <span><i class="fas fa-check-circle"></i> Passing score: {{ $quiz->passing_score }}%</span>
                            <span><i class="fas fa-redo"></i> Attempts allowed: {{ $quiz->attempts_allowed }}</span>
                        </div>
                        
                        <form class="quiz-form" data-quiz-id="{{ $quiz->id }}">
                            <div class="quiz-questions">
                                @foreach($quiz->questions as $question)
                                <div class="quiz-question">
                                    <h5>{{ $loop->iteration }}. {{ $question->text }}</h5>
                                    
                                    @if($question->image_path)
                                    <div class="question-image">
                                        <img src="{{ asset('storage/' . $question->image_path) }}" alt="Question Image">
                                    </div>
                                    @endif
                                    
                                    <div class="question-options">
                                        @if($question->type == 'multiple_choice')
                                            @foreach($question->options as $index => $option)
                                            <div class="option-item">
                                                <input type="radio" name="question_{{ $question->id }}" id="q{{ $question->id }}_option_{{ $index }}" value="{{ $index }}">
                                                <label for="q{{ $question->id }}_option_{{ $index }}">{{ $option }}</label>
                                            </div>
                                            @endforeach
                                        @elseif($question->type == 'true_false')
                                            <div class="option-item">
                                                <input type="radio" name="question_{{ $question->id }}" id="q{{ $question->id }}_true" value="true">
                                                <label for="q{{ $question->id }}_true">True</label>
                                            </div>
                                            <div class="option-item">
                                                <input type="radio" name="question_{{ $question->id }}" id="q{{ $question->id }}_false" value="false">
                                                <label for="q{{ $question->id }}_false">False</label>
                                            </div>
                                        @elseif($question->type == 'short_answer')
                                            <div class="short-answer">
                                                <input type="text" name="question_{{ $question->id }}" class="form-control" placeholder="Your answer">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <button type="submit" class="btn btn-primary submit-quiz">Submit Quiz</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .lesson-container {
        display: flex;
        gap: 30px;
        margin-top: 20px;
    }
    
    .lesson-navigation {
        width: 300px;
        flex-shrink: 0;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 20px;
    }
    
    .lesson-content-main {
        flex-grow: 1;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 20px;
    }
    
    .course-sections h3 {
        margin-bottom: 15px;
    }
    
    .progress-overview {
        margin-bottom: 20px;
    }
    
    .section-item {
        margin-bottom: 10px;
        border-radius: 5px;
        overflow: hidden;
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px;
        background-color: #f8f9fa;
        cursor: pointer;
        font-weight: 600;
        border-radius: 5px;
    }
    
    .section-item.active .section-header {
        background-color: #e9ecef;
    }
    
    .section-lessons {
        display: none;
        padding: 5px 0;
    }
    
    .section-lessons.show {
        display: block;
    }
    
    .lesson-link {
        display: flex;
        align-items: center;
        padding: 8px 15px 8px 30px;
        color: #333;
        text-decoration: none;
        border-radius: 5px;
    }
    
    .lesson-link:hover {
        background-color: #f8f9fa;
    }
    
    .lesson-link.active {
        background-color: #e9ecef;
        font-weight: 600;
    }
    
    .lesson-link i {
        margin-right: 10px;
        width: 18px;
        text-align: center;
    }
    
    .completed {
        color: #28a745;
    }
    
    .in-progress {
        color: #ffc107;
    }
    
    .not-started {
        color: #6c757d;
    }
    
    .content-tabs {
        display: flex;
        border-bottom: 1px solid #dee2e6;
        margin-bottom: 20px;
    }
    
    .tab-button {
        padding: 10px 20px;
        border: none;
        background: none;
        cursor: pointer;
        border-bottom: 2px solid transparent;
        font-weight: 600;
        color: #6c757d;
    }
    
    .tab-button.active {
        color: var(--primary-color);
        border-bottom-color: var(--primary-color);
    }
    
    .tab-content {
        min-height: 400px;
    }
    
    .tab-pane {
        display: none;
    }
    
    .tab-pane.active {
        display: block;
    }
    
    .lesson-media {
        margin-bottom: 20px;
        text-align: center;
    }
    
    .video-player, .audio-player, .lesson-image {
        max-width: 100%;
        border-radius: 5px;
    }
    
    .video-player {
        height: 400px;
        object-fit: contain;
        background-color: #000;
    }
    
    .lesson-text-content {
        line-height: 1.6;
        margin-bottom: 30px;
    }
    
    .lesson-text-content h1, 
    .lesson-text-content h2, 
    .lesson-text-content h3 {
        margin-top: 20px;
        margin-bottom: 10px;
    }
    
    .lesson-text-content p {
        margin-bottom: 15px;
    }
    
    .lesson-text-content ul, 
    .lesson-text-content ol {
        margin-bottom: 15px;
        padding-left: 20px;
    }
    
    .lesson-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #dee2e6;
    }
    
    .lesson-navigation-buttons {
        display: flex;
        gap: 10px;
    }
    
    .exercise-item, .quiz-item {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .exercise-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .exercise-type {
        background-color: var(--primary-color);
        color: white;
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 0.8rem;
    }
    
    .exercise-description {
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #dee2e6;
    }
    
    .exercise-form {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }
    
    .exercise-input {
        flex-grow: 1;
        padding: 8px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }
    
    .options-list {
        margin: 15px 0;
    }
    
    .option-item {
        margin-bottom: 10px;
    }
    
    .matching-pairs {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .matching-pair {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .match-item {
        background-color: white;
        padding: 10px 15px;
        border-radius: 5px;
        border: 1px solid #ced4da;
        width: 45%;
    }
    
    .match-connector {
        height: 2px;
        background-color: #ced4da;
        flex-grow: 1;
    }
    
    .quiz-question {
        margin-bottom: 25px;
        padding: 15px;
        border-radius: 8px;
    }
    
    .quiz-question h5 {
        margin-bottom: 15px;
    }
    
    .quiz-info {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .quiz-info span {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .question-image {
        margin: 10px 0;
        text-align: center;
    }
    
    .question-image img {
        max-width: 100%;
        border-radius: 5px;
        max-height: 300px;
    }
    
    .question-options {
        margin-top: 15px;
    }
    
    .short-answer input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ced4da;
        border-radius: 5px;
    }
    
    @media (max-width: 768px) {
        .lesson-container {
            flex-direction: column;
        }
        
        .lesson-navigation {
            width: 100%;
            margin-bottom: 20px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            
            const tabId = button.getAttribute('data-tab') + '-tab';
            document.querySelectorAll('.tab-pane').forEach(tab => tab.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
        });
    });
    
    document.querySelectorAll('.section-header').forEach(header => {
        header.addEventListener('click', () => {
            const section = header.parentElement;
            const lessons = header.nextElementSibling;
            const icon = header.querySelector('i');
            
            lessons.classList.toggle('show');
            
            if (lessons.classList.contains('show')) {
                icon.classList.remove('fa-chevron-right');
                icon.classList.add('fa-chevron-down');
            } else {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-right');
            }
        });
    });
    
    function markLessonComplete(courseId, lessonId, completed) {
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
    
    document.querySelectorAll('.check-answer').forEach(button => {
        button.addEventListener('click', function() {
            const correctAnswer = this.getAttribute('data-answer');
            let userAnswer = '';
            
            if (this.closest('.fill-blank-exercise')) {
                userAnswer = this.previousElementSibling.value.trim();
            } else if (this.closest('.multiple-choice-exercise')) {
                const selectedOption = this.closest('.multiple-choice-exercise').querySelector('input[type="radio"]:checked');
                if (selectedOption) {
                    userAnswer = selectedOption.value;
                }
            }
            
            if (userAnswer && userAnswer.toLowerCase() === correctAnswer.toLowerCase()) {
              alert('Correct! 🎉');
            } else {
                alert('Try again! The correct answer is: ' + correctAnswer);
            }
        });
    });
    
    document.querySelectorAll('.check-fill-blank-answers').forEach(button => {
        button.addEventListener('click', function() {
            const exercise = this.closest('.fill-blank-exercise');
            const questions = exercise.querySelectorAll('.fill-blank-question');
            let allCorrect = true;
            let totalCorrect = 0;
            let totalBlanks = 0;
            
            questions.forEach(question => {
                const inputs = question.querySelectorAll('.blank-input');
                inputs.forEach(input => {
                    totalBlanks++;
                    const correctAnswer = input.getAttribute('data-answer');
                    const userAnswer = input.value.trim();
                    
                    const isCorrect = userAnswer.toLowerCase() === correctAnswer.toLowerCase();
                    
                    if (isCorrect) {
                        input.style.borderColor = '#28a745';
                        input.style.backgroundColor = '#d4edda';
                        totalCorrect++;
                    } else {
                        input.style.borderColor = '#dc3545';
                        input.style.backgroundColor = '#f8d7da';
                        allCorrect = false;
                    }
                });
            });
            
        
            if (allCorrect) {
                  alert(`Great job! All answers are correct! (${totalCorrect}/${totalBlanks})`);
            } else {
                alert(`You got ${totalCorrect} out of ${totalBlanks} correct. Try again!`);
            }
        });
    });
    
    document.querySelectorAll('.quiz-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const quizId = this.getAttribute('data-quiz-id');
            const questions = this.querySelectorAll('.quiz-question');
            let score = 0;
            let totalQuestions = questions.length;
            let answeredQuestions = 0;
            
            const responses = [];
            
            questions.forEach(question => {
                const questionId = question.querySelector('input, textarea, select').name.replace('question_', '');
                let userAnswer = null;
                let answered = false;
                
                if (question.querySelector('input[type="radio"]')) {
                    const selectedOption = question.querySelector('input[type="radio"]:checked');
                    if (selectedOption) {
                        userAnswer = selectedOption.value;
                        answered = true;
                    }
                } else if (question.querySelector('input[type="text"]')) {
                    userAnswer = question.querySelector('input[type="text"]').value.trim();
                    answered = userAnswer !== '';
                }
                
                if (answered) {
                    answeredQuestions++;
                    
                    responses.push({
                        question_id: questionId,
                        answer: userAnswer
                    });
                    
                    if (Math.random() > 0.3) { 
                        score++;
                        question.style.backgroundColor = '#d4edda';
                    } else {
                        question.style.backgroundColor = '#f8d7da';
                    }
                } else {
                    question.style.backgroundColor = '#fff3cd';
                }
            });
            
            if (answeredQuestions < totalQuestions) {
                alert(`Please answer all questions. (${answeredQuestions}/${totalQuestions} answered)`);
                return;
            }
            
            const percentage = Math.round((score / totalQuestions) * 100);
            
            
            const resultsHtml = `
                <div class="quiz-results">
                    <h3>Quiz Results</h3>
                    <div class="score-display">
                        <div class="score-circle ${percentage >= 70 ? 'passing' : 'failing'}">
                            <span>${percentage}%</span>
                        </div>
                    </div>
                    <p>${percentage >= 70 ? 'Congratulations! You passed the quiz.' : 'You did not pass the quiz. Try again!'}</p>
                    <p>You got ${score} out of ${totalQuestions} questions correct.</p>
                </div>
            `;
            
            this.innerHTML = resultsHtml;
            
            const style = document.createElement('style');
            style.textContent = `
                .quiz-results {
                    text-align: center;
                    padding: 20px;
                }
                .score-display {
                    display: flex;
                    justify-content: center;
                    margin: 20px 0;
                }
                .score-circle {
                    width: 100px;
                    height: 100px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 24px;
                    font-weight: bold;
                }
                .passing {
                    background-color: #d4edda;
                    color: #155724;
                }
                .failing {
                    background-color: #f8d7da;
                    color: #721c24;
                }
            `;
            document.head.appendChild(style);
        });
    });
</script>
@endsection 