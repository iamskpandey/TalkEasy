<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Course - TalkEasy Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/create-course.css', 'resources/js/app.js'])
</head>
<body>
    <div class="navbar">
        <h1><i class="fas fa-chalkboard-teacher"></i> TalkEasy Admin</h1>
        <div class="navbar-links">
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <h1>Create New Course</h1>
            <p>Design a comprehensive language learning experience for TalkEasy students</p>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="title">Course Title *</label>
                <input type="text" class="input-field" id="title" name="title" value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label for="description">Course Description *</label>
                <textarea class="input-field" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="short_description">Short Description *</label>
                <textarea class="input-field" id="short_description" name="short_description" rows="2" required>{{ old('short_description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="language_level">Language Level *</label>
                <select class="input-field" id="language_level" name="language_level" required>
                    <option value="">Select level</option>
                    <option value="beginner">Beginner (A1-A2)</option>
                    <option value="intermediate">Intermediate (B1-B2)</option>
                    <option value="advanced">Advanced (C1-C2)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="language">Language *</label>
                <select class="input-field" id="language" name="language" required>
                    <option value="">Select language</option>
                    <option value="english">English</option>
                    <option value="spanish">Spanish</option>
                    <option value="french">French</option>
                    <option value="german">German</option>
                    <option value="chinese">Chinese</option>
                    <option value="japanese">Japanese</option>
                    <option value="russian">Russian</option>
                    <option value="arabic">Arabic</option>
                    <option value="italian">Italian</option>
                    <option value="portuguese">Portuguese</option>
                </select>
            </div>

            <div class="form-group">
                <label for="instructor">Instructor *</label>
                <input type="text" class="input-field" id="instructor" name="instructor" value="{{ old('instructor') }}" required>
            </div>

            <div class="form-group">
                <label for="duration">Duration (weeks) *</label>
                <input type="number" class="input-field" id="duration" name="duration" min="1" value="4" required>
            </div>

            <div class="form-group">
                <label for="price">Price (USD) *</label>
                <input type="number" step="0.01" min="0" class="input-field" id="price" name="price" value="0" required>
            </div>

            <div class="form-group">
                <label for="image">Course Cover Image</label>
                <div class="file-input-container">
                    <label for="image" class="file-input-label">Choose an image</label>
                    <input type="file" id="image" name="image" class="file-input" accept="image/*">
                </div>
                <img id="preview-image" class="img-preview">
            </div>

            <h3>Course Content</h3>
            
            <div id="sections-container">
                <div class="section-box" data-section="1">
                    <div class="section-title">
                        <span>Section 1</span>
                        <button type="button" class="btn btn-remove">Remove</button>
                    </div>
                    
                    <div class="form-group">
                        <label>Section Title *</label>
                        <input type="text" class="input-field" name="sections[1][title]" required>
                    </div>
                    
                    <div class="lessons-container">
                        <div class="lesson-box" data-lesson="1">
                            <div class="section-title">
                                <span>Lesson 1</span>
                                <button type="button" class="btn btn-remove">Remove</button>
                            </div>
                            
                            <div class="form-group">
                                <label>Lesson Title *</label>
                                <input type="text" class="input-field" name="sections[1][lessons][1][title]" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Lesson Content *</label>
                                <textarea class="input-field" name="sections[1][lessons][1][content]" rows="3" required></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Upload Media (optional)</label>
                                <div class="file-input-container">
                                    <label class="file-input-label">Choose file</label>
                                    <input type="file" name="sections[1][lessons][1][media]" class="file-input">
                                </div>
                            </div>
                        </div>
                        
                        <button type="button" class="btn btn-add" data-section-id="1">Add Lesson</button>
                    </div>
                </div>
            </div>
            
            <button type="button" id="add-section-btn" class="btn btn-add">Add New Section</button>
            
            <div class="submit-container">
                <button type="submit" class="btn btn-submit">Create Course</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let sectionCount = 1;
            
            document.getElementById('image').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById('preview-image');
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                }
            });
            
            document.getElementById('add-section-btn').addEventListener('click', function() {
                sectionCount++;
                
                const sectionHTML = `
                    <div class="section-box" data-section="${sectionCount}">
                        <div class="section-title">
                            <span>Section ${sectionCount}</span>
                            <button type="button" class="btn btn-remove">Remove</button>
                        </div>
                        
                        <div class="form-group">
                            <label>Section Title *</label>
                            <input type="text" class="input-field" name="sections[${sectionCount}][title]" required>
                        </div>
                        
                        <div class="lessons-container">
                            <div class="lesson-box" data-lesson="1">
                                <div class="section-title">
                                    <span>Lesson 1</span>
                                    <button type="button" class="btn btn-remove">Remove</button>
                                </div>
                                
                                <div class="form-group">
                                    <label>Lesson Title *</label>
                                    <input type="text" class="input-field" name="sections[${sectionCount}][lessons][1][title]" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Lesson Content *</label>
                                    <textarea class="input-field" name="sections[${sectionCount}][lessons][1][content]" rows="3" required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>Upload Media (optional)</label>
                                    <div class="file-input-container">
                                        <label class="file-input-label">Choose file</label>
                                        <input type="file" name="sections[${sectionCount}][lessons][1][media]" class="file-input">
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-add" data-section-id="${sectionCount}">Add Lesson</button>
                        </div>
                    </div>
                `;
                
                document.getElementById('sections-container').insertAdjacentHTML('beforeend', sectionHTML);
                setupEventListeners();
            });
            
            function setupEventListeners() {
                document.querySelectorAll('.section-box .btn-remove').forEach(btn => {
                    btn.onclick = function() {
                        const section = this.closest('.section-box');
                        if (document.querySelectorAll('.section-box').length > 1) {
                            section.remove();
                        } else {
                            alert('You need at least one section');
                        }
                    };
                });
                
                document.querySelectorAll('.lesson-box .btn-remove').forEach(btn => {
                    btn.onclick = function() {
                        const lesson = this.closest('.lesson-box');
                        const container = lesson.closest('.lessons-container');
                        
                        if (container.querySelectorAll('.lesson-box').length > 1) {
                            lesson.remove();
                        } else {
                            alert('You need at least one lesson per section');
                        }
                    };
                });
                
                document.querySelectorAll('.btn-add[data-section-id]').forEach(btn => {
                    btn.onclick = function() {
                        const sectionId = this.dataset.sectionId;
                        const container = this.closest('.lessons-container');
                        const lessonCount = container.querySelectorAll('.lesson-box').length + 1;
                        
                        const lessonHTML = `
                            <div class="lesson-box" data-lesson="${lessonCount}">
                                <div class="section-title">
                                    <span>Lesson ${lessonCount}</span>
                                    <button type="button" class="btn btn-remove">Remove</button>
                                </div>
                                
                                <div class="form-group">
                                    <label>Lesson Title *</label>
                                    <input type="text" class="input-field" name="sections[${sectionId}][lessons][${lessonCount}][title]" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Lesson Content *</label>
                                    <textarea class="input-field" name="sections[${sectionId}][lessons][${lessonCount}][content]" rows="3" required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>Upload Media (optional)</label>
                                    <div class="file-input-container">
                                        <label class="file-input-label">Choose file</label>
                                        <input type="file" name="sections[${sectionId}][lessons][${lessonCount}][media]" class="file-input">
                                    </div>
                                </div>
                            </div>
                        `;
                        
                        this.insertAdjacentHTML('beforebegin', lessonHTML);
                        setupEventListeners();
                    };
                });
                
                document.querySelectorAll('.file-input').forEach(input => {
                    input.onchange = function() {
                        const label = this.previousElementSibling;
                        if (this.files.length > 0) {
                            label.textContent = this.files[0].name;
                        }
                    };
                });
            }
            
            setupEventListeners();
        });
    </script>
</body>
</html>
