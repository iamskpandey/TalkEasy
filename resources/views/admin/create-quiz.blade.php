<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Quiz - TalkEasy Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/create-quiz.css', 'resources/js/app.js'])
</head>
<body>
    <div class="navbar">
        <h1><i class="fas fa-question-circle"></i> TalkEasy Admin</h1>
        <div class="navbar-links">
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <h1>Create New Quiz</h1>
            <p>Design evaluative quizzes to test students' language proficiency and understanding</p>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif        <form method="POST" action="{{ route('admin.quizzes.store') }}" enctype="multipart/form-data">
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
                <label for="title">Quiz Title *</label>
                <input type="text" class="input-field" id="title" name="title" value="{{ old('title') }}" required placeholder="Enter a descriptive title for this quiz">
            </div>

            <div class="form-group">
                <label for="description">Quiz Description *</label>
                <textarea class="input-field" id="description" name="description" rows="3" required placeholder="Describe what this quiz will evaluate">{{ old('description') }}</textarea>
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
                        <label for="time_limit">Time Limit (minutes) *</label>
                        <input type="number" class="input-field" id="time_limit" name="time_limit" min="5" max="180" value="{{ old('time_limit', 30) }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="passing_score">Passing Score (%) *</label>
                        <input type="number" class="input-field" id="passing_score" name="passing_score" min="1" max="100" value="{{ old('passing_score', 70) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="attempts_allowed">Attempts Allowed *</label>
                        <input type="number" class="input-field" id="attempts_allowed" name="attempts_allowed" min="1" max="10" value="{{ old('attempts_allowed', 2) }}" required>
                    </div>
                </div>
            </div>

            <div class="quiz-section">
                <h3>Quiz Questions</h3>
                <p>Add questions to test students' understanding and knowledge</p>
                
                <div id="questions-container">
                    <div class="question-box" data-question="1">
                        <div class="box-title">
                            <span>Question 1</span>
                            <button type="button" class="btn btn-remove remove-question-btn"><i class="fas fa-trash"></i> Remove</button>
                        </div>
                        
                        <div class="form-group">
                            <label>Question Type *</label>
                            <div class="radio-group">
                                <label class="radio-option">
                                    <input type="radio" name="questions[1][type]" value="multiple_choice" checked> 
                                    Multiple Choice
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Question Text *</label>
                            <input type="text" class="input-field" name="questions[1][text]" required placeholder="Write your question here">
                        </div>
                        
                        <div class="form-group">
                            <label>Question Image (Optional)</label>
                            <div class="file-input-container">
                                <label class="file-input-label">Choose an image</label>
                                <input type="file" name="questions[1][image]" class="file-input" accept="image/*">
                            </div>
                            <img class="img-preview" id="preview-1">
                        </div>

                        <div class="form-group">
                            <label>Points *</label>
                            <input type="number" class="input-field" name="questions[1][points]" min="1" max="100" value="10" required>
                        </div>

                        <div class="multiple-choice-options" data-question-id="1">
                            <div class="form-group">
                                <label>Answer Options</label>
                                <p class="help-text">Add at least 2 options and mark the correct one(s)</p>
                            </div>
                            
                            <div class="option-container" data-option="1">
                                <div class="option-header">
                                    <div class="option-label">
                                        <span class="badge badge-primary">Option 1</span>
                                    </div>
                                    <button type="button" class="btn btn-remove remove-option-btn"><i class="fas fa-times"></i></button>
                                </div>
                                
                                <div class="form-group">
                                    <label>Option Text *</label>
                                    <input type="text" class="input-field" name="questions[1][options][1][text]" required>
                                </div>
                                
                                <div class="correct-option">
                                    <input type="checkbox" name="questions[1][options][1][is_correct]" id="correct_1_1">
                                    <label for="correct_1_1">Mark as correct answer</label>
                                </div>
                            </div>
                            
                            <div class="option-container" data-option="2">
                                <div class="option-header">
                                    <div class="option-label">
                                        <span class="badge badge-primary">Option 2</span>
                                    </div>
                                    <button type="button" class="btn btn-remove remove-option-btn"><i class="fas fa-times"></i></button>
                                </div>
                                
                                <div class="form-group">
                                    <label>Option Text *</label>
                                    <input type="text" class="input-field" name="questions[1][options][2][text]" required>
                                </div>
                                
                                <div class="correct-option">
                                    <input type="checkbox" name="questions[1][options][2][is_correct]" id="correct_1_2">
                                    <label for="correct_1_2">Mark as correct answer</label>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-add add-option-btn" data-question-id="1"><i class="fas fa-plus"></i> Add Option</button>
                        </div>

                        <div class="true-false-options" data-question-id="1" style="display: none;">
                            <div class="form-group">
                                <label>Correct Answer *</label>
                                <div class="radio-group">
                                    <label class="radio-option">
                                        <input type="radio" name="questions[1][true_false]" value="true" checked> 
                                        True
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="questions[1][true_false]" value="false"> 
                                        False
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="short-answer-options" data-question-id="1" style="display: none;">
                            <div class="form-group">
                                <label>Correct Answer *</label>
                                <input type="text" class="input-field" name="questions[1][short_answer]" placeholder="Enter the correct answer (case insensitive)">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Explanation (Optional)</label>
                            <textarea class="input-field" name="questions[1][explanation]" rows="2" placeholder="Explain why the correct answer is right (shown after quiz completion)"></textarea>
                        </div>
                    </div>
                </div>
                
                <button type="button" id="add-question-btn" class="btn btn-add"><i class="fas fa-plus"></i> Add New Question</button>
            </div>
            
            <div class="submit-container">
                <button type="submit" class="btn btn-submit"><i class="fas fa-save"></i> Create Quiz</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let questionCount = 1;
            
            document.addEventListener('change', function(e) {
                if (e.target && e.target.classList.contains('file-input')) {
                    const file = e.target.files[0];
                    if (file) {
                        const questionId = e.target.closest('.question-box').dataset.question;
                        const preview = document.getElementById(`preview-${questionId}`);
                        if (preview) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                preview.src = e.target.result;
                                preview.style.display = 'block';
                            }
                            reader.readAsDataURL(file);
                        }
                        
                        const label = e.target.previousElementSibling;
                        if (label) {
                            label.textContent = file.name;
                        }
                    }
                }
            });
            
            document.getElementById('add-question-btn').addEventListener('click', function() {
                questionCount++;
                
                const questionHTML = `
                    <div class="question-box" data-question="${questionCount}">
                        <div class="box-title">
                            <span>Question ${questionCount}</span>
                            <button type="button" class="btn btn-remove remove-question-btn"><i class="fas fa-trash"></i> Remove</button>
                        </div>
                        
                        <div class="form-group">
                            <label>Question Type *</label>
                            <div class="radio-group">
                                <label class="radio-option">
                                    <input type="radio" name="questions[${questionCount}][type]" value="multiple_choice" checked> 
                                    Multiple Choice
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="questions[${questionCount}][type]" value="true_false"> 
                                    True/False
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="questions[${questionCount}][type]" value="short_answer"> 
                                    Short Answer
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Question Text *</label>
                            <input type="text" class="input-field" name="questions[${questionCount}][text]" required placeholder="Write your question here">
                        </div>
                        
                        <div class="form-group">
                            <label>Question Image (Optional)</label>
                            <div class="file-input-container">
                                <label class="file-input-label">Choose an image</label>
                                <input type="file" name="questions[${questionCount}][image]" class="file-input" accept="image/*">
                            </div>
                            <img class="img-preview" id="preview-${questionCount}">
                        </div>

                        <div class="form-group">
                            <label>Points *</label>
                            <input type="number" class="input-field" name="questions[${questionCount}][points]" min="1" max="100" value="10" required>
                        </div>

                        <div class="multiple-choice-options" data-question-id="${questionCount}">
                            <div class="form-group">
                                <label>Answer Options</label>
                                <p class="help-text">Add at least 2 options and mark the correct one(s)</p>
                            </div>
                            
                            <div class="option-container" data-option="1">
                                <div class="option-header">
                                    <div class="option-label">
                                        <span class="badge badge-primary">Option 1</span>
                                    </div>
                                    <button type="button" class="btn btn-remove remove-option-btn"><i class="fas fa-times"></i></button>
                                </div>
                                
                                <div class="form-group">
                                    <label>Option Text *</label>
                                    <input type="text" class="input-field" name="questions[${questionCount}][options][1][text]" required>
                                </div>
                                
                                <div class="correct-option">
                                    <input type="checkbox" name="questions[${questionCount}][options][1][is_correct]" id="correct_${questionCount}_1">
                                    <label for="correct_${questionCount}_1">Mark as correct answer</label>
                                </div>
                            </div>
                            
                            <div class="option-container" data-option="2">
                                <div class="option-header">
                                    <div class="option-label">
                                        <span class="badge badge-primary">Option 2</span>
                                    </div>
                                    <button type="button" class="btn btn-remove remove-option-btn"><i class="fas fa-times"></i></button>
                                </div>
                                
                                <div class="form-group">
                                    <label>Option Text *</label>
                                    <input type="text" class="input-field" name="questions[${questionCount}][options][2][text]" required>
                                </div>
                                
                                <div class="correct-option">
                                    <input type="checkbox" name="questions[${questionCount}][options][2][is_correct]" id="correct_${questionCount}_2">
                                    <label for="correct_${questionCount}_2">Mark as correct answer</label>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-add add-option-btn" data-question-id="${questionCount}"><i class="fas fa-plus"></i> Add Option</button>
                        </div>

                        <div class="true-false-options" data-question-id="${questionCount}" style="display: none;">
                            <div class="form-group">
                                <label>Correct Answer *</label>
                                <div class="radio-group">
                                    <label class="radio-option">
                                        <input type="radio" name="questions[${questionCount}][true_false]" value="true" checked> 
                                        True
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="questions[${questionCount}][true_false]" value="false"> 
                                        False
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="short-answer-options" data-question-id="${questionCount}" style="display: none;">
                            <div class="form-group">
                                <label>Correct Answer *</label>
                                <input type="text" class="input-field" name="questions[${questionCount}][short_answer]" placeholder="Enter the correct answer (case insensitive)">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Explanation (Optional)</label>
                            <textarea class="input-field" name="questions[${questionCount}][explanation]" rows="2" placeholder="Explain why the correct answer is right (shown after quiz completion)"></textarea>
                        </div>
                    </div>
                `;
                
                document.getElementById('questions-container').insertAdjacentHTML('beforeend', questionHTML);
                setupEventListeners();
            });
            
            document.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('add-option-btn') || 
                    (e.target.parentElement && e.target.parentElement.classList.contains('add-option-btn'))) {
                    
                    const btn = e.target.classList.contains('add-option-btn') ? e.target : e.target.parentElement;
                    const questionId = btn.dataset.questionId;
                    const optionsContainer = btn.closest('.multiple-choice-options');
                    const options = optionsContainer.querySelectorAll('.option-container');
                    const optionCount = options.length + 1;
                    
                    const optionHTML = `
                        <div class="option-container" data-option="${optionCount}">
                            <div class="option-header">
                                <div class="option-label">
                                    <span class="badge badge-primary">Option ${optionCount}</span>
                                </div>
                                <button type="button" class="btn btn-remove remove-option-btn"><i class="fas fa-times"></i></button>
                            </div>
                            
                            <div class="form-group">
                                <label>Option Text *</label>
                                <input type="text" class="input-field" name="questions[${questionId}][options][${optionCount}][text]" required>
                            </div>
                            
                            <div class="correct-option">
                                <input type="checkbox" name="questions[${questionId}][options][${optionCount}][is_correct]" id="correct_${questionId}_${optionCount}">
                                <label for="correct_${questionId}_${optionCount}">Mark as correct answer</label>
                            </div>
                        </div>
                    `;
                    
                    btn.insertAdjacentHTML('beforebegin', optionHTML);
                }
            });
            
            function setupQuestionTypeHandlers() {
                document.querySelectorAll('input[name^="questions"][name$="[type]"]').forEach(radio => {
                    radio.addEventListener('change', function() {
                        const questionBox = this.closest('.question-box');
                        const questionId = questionBox.dataset.question;
                        const type = this.value;
                        
                        questionBox.querySelector(`.multiple-choice-options[data-question-id="${questionId}"]`).style.display = 'none';
                        questionBox.querySelector(`.true-false-options[data-question-id="${questionId}"]`).style.display = 'none';
                        questionBox.querySelector(`.short-answer-options[data-question-id="${questionId}"]`).style.display = 'none';
                        
                        if (type === 'multiple_choice') {
                            questionBox.querySelector(`.multiple-choice-options[data-question-id="${questionId}"]`).style.display = 'block';
                        } else if (type === 'true_false') {
                            questionBox.querySelector(`.true-false-options[data-question-id="${questionId}"]`).style.display = 'block';
                        } else if (type === 'short_answer') {
                            questionBox.querySelector(`.short-answer-options[data-question-id="${questionId}"]`).style.display = 'block';
                        }
                    });
                });
            }
            
            function setupEventListeners() {
                document.querySelectorAll('.remove-question-btn').forEach(btn => {
                    btn.onclick = function() {
                        const question = this.closest('.question-box');
                        if (document.querySelectorAll('.question-box').length > 1) {
                            question.remove();
                        } else {
                            alert('You need at least one question');
                        }
                    };
                });
                
                document.querySelectorAll('.remove-option-btn').forEach(btn => {
                    btn.onclick = function() {
                        const option = this.closest('.option-container');
                        const container = option.closest('.multiple-choice-options');
                        
                        if (container.querySelectorAll('.option-container').length > 2) {
                            option.remove();
                        } else {
                            alert('You need at least two options');
                        }
                    };
                });
                
                setupQuestionTypeHandlers();
            }
            
            setupEventListeners();
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
