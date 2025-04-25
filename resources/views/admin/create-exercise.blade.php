<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Exercise - TalkEasy Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/create-exercise.css', 'resources/js/app.js'])
</head>
<body>
    <div class="navbar">
        <h1><i class="fas fa-graduation-cap"></i> TalkEasy Admin</h1>
        <div class="navbar-links">
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <h1>Create New Exercise</h1>
            <p>Design language learning exercises to help students practice and improve their skills</p>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif        <form method="POST" action="{{ route('admin.exercises.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="course_id">Course *</label>
                <select name="course_id" id="course_id" class="input-field" required onchange="loadLessons()">
                    <option value="">Select a course</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }} ({{ ucfirst($course->language) }} - {{ ucfirst($course->language_level) }})</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="lesson_id">Lesson *</label>
                <select name="lesson_id" id="lesson_id" class="input-field" required>
                    <option value="">Select a course first</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="title">Exercise Title *</label>
                <input type="text" class="input-field" id="title" name="title" value="{{ old('title') }}" required placeholder="Enter a descriptive title for this exercise">
            </div>

            <div class="form-group">
                <label for="description">Exercise Description *</label>
                <textarea class="input-field" id="description" name="description" rows="3" required placeholder="Describe what students will learn/practice with this exercise">{{ old('description') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="language_level">Language Level *</label>
                        <select class="input-field" id="language_level" name="language_level" required>
                            <option value="">Select language level</option>
                            <option value="beginner" {{ old('language_level') == 'beginner' ? 'selected' : '' }}>Beginner (A1-A2)</option>
                            <option value="intermediate" {{ old('language_level') == 'intermediate' ? 'selected' : '' }}>Intermediate (B1-B2)</option>
                            <option value="advanced" {{ old('language_level') == 'advanced' ? 'selected' : '' }}>Advanced (C1-C2)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="skill_focus">Skill Focus *</label>
                        <select class="input-field" id="skill_focus" name="skill_focus" required>
                            <option value="">Select primary skill</option>
                            <option value="vocabulary" {{ old('skill_focus') == 'vocabulary' ? 'selected' : '' }}>Vocabulary</option>
                            <option value="grammar" {{ old('skill_focus') == 'grammar' ? 'selected' : '' }}>Grammar</option>
                            <option value="reading" {{ old('skill_focus') == 'reading' ? 'selected' : '' }}>Reading</option>
                            <option value="listening" {{ old('skill_focus') == 'listening' ? 'selected' : '' }}>Listening</option>
                            <option value="speaking" {{ old('skill_focus') == 'speaking' ? 'selected' : '' }}>Speaking</option>
                            <option value="writing" {{ old('skill_focus') == 'writing' ? 'selected' : '' }}>Writing</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="estimated_time">Estimated Completion Time (minutes) *</label>
                <input type="number" class="input-field" id="estimated_time" name="estimated_time" min="1" max="120" value="{{ old('estimated_time', 15) }}" required>
            </div>

            <div class="form-group">
                <label for="instructions">Instructions for Students *</label>
                <textarea class="input-field" id="instructions" name="instructions" rows="3" required placeholder="Clear instructions for students on how to complete the exercise">{{ old('instructions') }}</textarea>
            </div>            <div class="form-group">
                <label>Exercise Type</label>
                <div class="type-display">
                    <div class="type-option active">
                        <i class="fas fa-keyboard"></i>
                        <h4>Fill in the Blanks</h4>
                        <p>Text passages with blank spaces that students need to fill in with the correct words</p>
                    </div>
                </div>
                <input type="hidden" name="exercise_type" id="exercise_type" value="fill-in-blank" required>
            </div>            <!-- Fill in the Blanks Section -->
            <div id="fill-in-blank-section" class="question-section">
                <h3>Fill in the Blanks Questions</h3>
                <p>Create text passages with blank spaces that students need to fill in with the correct words</p>
                
                <div class="form-group">
                    <label>Instructions</label>
                    <p>Use [blank:answer] format to create blanks. Example: "The cat sat on the [blank:mat]."</p>
                </div>
                
                <div class="form-group">
                    <label>Case Sensitive</label>
                    <div class="form-check">
                        <input type="checkbox" name="case_sensitive" id="case_sensitive" value="1" {{ old('case_sensitive') ? 'checked' : '' }}>
                        <label for="case_sensitive">Answers are case sensitive</label>
                    </div>
                </div>
                
                <div id="questions-container">
                    <div class="exercise-box fill-blank-question" data-question="1">
                        <div class="box-title">
                            <span>Question 1</span>
                            <button type="button" class="btn btn-remove remove-question-btn"><i class="fas fa-trash"></i> Remove</button>
                        </div>
                        <div class="form-group">
                            <label>Text Passage with Blanks *</label>
                            <textarea class="input-field fill-blank-textarea" name="questions[1][text_with_blanks]" rows="6" placeholder="Write your text here using [blank:answer] format for each blank space." required>{{ old('questions.1.text_with_blanks') }}</textarea>
                        </div>
                    </div>
                </div>
                
                <button type="button" id="add-question-btn" class="btn btn-add"><i class="fas fa-plus"></i> Add New Question</button>
            </div>
            
            <div class="submit-container">
                <button type="submit" class="btn btn-submit"><i class="fas fa-save"></i> Create Exercise</button>
            </div>
        </form>
    </div>    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let questionCount = 1;
            
            const validateBlankFormat = (textarea) => {
                const text = textarea.value;
                const blankPattern = /\[blank:[^\[\]]+\]/g;
                
                if (!text.match(blankPattern)) {
                    textarea.setCustomValidity('Please include at least one blank using the [blank:answer] format');
                    return false;
                } else {
                    textarea.setCustomValidity('');
                    return true;
                }
            };
            
            document.querySelectorAll('.fill-blank-textarea').forEach(textarea => {
                textarea.addEventListener('input', function() {
                    validateBlankFormat(this);
                });
            });
            
            document.getElementById('add-question-btn').addEventListener('click', function() {
                questionCount++;
                
                const questionHTML = `
                    <div class="exercise-box fill-blank-question" data-question="${questionCount}">
                        <div class="box-title">
                            <span>Question ${questionCount}</span>
                            <button type="button" class="btn btn-remove remove-question-btn"><i class="fas fa-trash"></i> Remove</button>
                        </div>
                        <div class="form-group">
                            <label>Text Passage with Blanks *</label>
                            <textarea class="input-field fill-blank-textarea" name="questions[${questionCount}][text_with_blanks]" rows="6" placeholder="Write your text here using [blank:answer] format for each blank space." required></textarea>
                        </div>
                    </div>
                `;
                
                document.getElementById('questions-container').insertAdjacentHTML('beforeend', questionHTML);
                
                const newTextarea = document.querySelector(`[name="questions[${questionCount}][text_with_blanks]"]`);
                newTextarea.addEventListener('input', function() {
                    validateBlankFormat(this);
                });
                
                setupRemoveButtons();
            });
            
            function setupRemoveButtons() {
                document.querySelectorAll('.remove-question-btn').forEach(btn => {
                    btn.onclick = function() {
                        const questionBox = this.closest('.fill-blank-question');
                        if (document.querySelectorAll('.fill-blank-question').length > 1) {
                            questionBox.remove();
                        } else {
                            alert('You need at least one question');
                        }
                    };
                });
            }
            
            setupRemoveButtons();
            
            document.querySelector('form').addEventListener('submit', function(event) {
                let isValid = true;
                
                document.querySelectorAll('.fill-blank-textarea').forEach(textarea => {
                    if (!validateBlankFormat(textarea)) {
                        isValid = false;
                    }
                });
                
                if (!isValid) {
                    event.preventDefault();
                    alert('Please ensure all questions include at least one blank using the [blank:answer] format');
                }
            });
        });

        function loadLessons() {
            const courseId = document.getElementById('course_id').value;
            const lessonSelect = document.getElementById('lesson_id');
            
            lessonSelect.innerHTML = '<option value="">Loading lessons...</option>';
            
            if (!courseId) {
                lessonSelect.innerHTML = '<option value="">Select a course first</option>';
                return;
            }
            
            fetch(`/admin/courses/${courseId}/lessons`)
                .then(response => response.json())
                .then(data => {
                    if (data.lessons && data.lessons.length > 0) {
                        lessonSelect.innerHTML = '<option value="">Select a lesson</option>';
                        
                        data.lessons.forEach(lesson => {
                            const option = document.createElement('option');
                            option.value = lesson.id;
                            option.textContent = lesson.title;
                            lessonSelect.appendChild(option);
                        });
                    } else {
                        lessonSelect.innerHTML = '<option value="">No lessons available</option>';
                    }
                })
                .catch(error => {
                    console.error('Error loading lessons:', error);
                    lessonSelect.innerHTML = '<option value="">Error loading lessons</option>';
                });
        }
    </script>
</body>
</html>
