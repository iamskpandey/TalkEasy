<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TalkEasy - Admin Dashboard</title>
    @vite(['resources/css/admin.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <div class="sidebar">
            <div class="logo">
                <h1>TalkEasy</h1>
                <span class="admin-badge">Admin</span>
            </div>
            <div class="sidebar-menu">
                <div class="menu-item active" data-tab="dashboard">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </div>
                <div class="menu-item" data-tab="courses">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Courses</span>
                </div>
                <div class="menu-item" data-tab="exercises">
                    <i class="fas fa-tasks"></i>
                    <span>Exercises</span>
                </div>
                <div class="menu-item" data-tab="quizzes">
                    <i class="fas fa-question-circle"></i>
                    <span>Quizzes</span>
                </div>
                <div class="menu-item" data-tab="users">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </div>
            </div>
            <div class="sidebar-footer">
                <a href="{{ route('homepage') }}" class="view-site">
                    <i class="fas fa-external-link-alt"></i>
                    <span>View Site</span>
                </a>
                <a href="#" class="logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>

        <div class="main-content">

            <div class="tab-content active" id="dashboard-content">
                <div class="page-header">
                    <h2>Dashboard</h2>
                    <p>Welcome to the TalkEasy Admin Panel</p>
                </div>                <div class="stats-cards">
                    <div class="stat-card">
                        <div class="stat-card-content">
                            <h3>Total Courses</h3>
                            <p class="stat-number">{{ number_format($coursesCount) }}</p>
                        </div>
                        <div class="stat-card-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-content">
                            <h3>Total Exercises</h3>
                            <p class="stat-number">{{ number_format($exercisesCount) }}</p>
                        </div>
                        <div class="stat-card-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-content">
                            <h3>Total Quizzes</h3>
                            <p class="stat-number">{{ number_format($quizzesCount) }}</p>
                        </div>
                        <div class="stat-card-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-content">
                            <h3>Active Users</h3>
                            <p class="stat-number">{{ number_format($usersCount) }}</p>
                        </div>
                        <div class="stat-card-icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <div class="quick-actions">
                    <div class="page-header">
                        <h3>Quick Actions</h3>
                    </div>
                    <div class="action-buttons">
                        <a href="{{ route('admin.courses.create') }}" class="action-button">
                            <i class="fas fa-plus-circle"></i>
                            <span>Add New Course</span>
                        </a>
                        <a href="{{ route('admin.exercises.create') }}" class="action-button">
                            <i class="fas fa-plus-circle"></i>
                            <span>Add New Exercise</span>
                        </a>
                        <a href="{{ route('admin.quizzes.create') }}" class="action-button">
                            <i class="fas fa-plus-circle"></i>
                            <span>Add New Quiz</span>
                        </a>
            </div>
        </div>
    </div>
    
            <div class="tab-content" id="courses-content">
                <div class="page-header">
                    <h2>Courses Management</h2>
                    <a href="{{ route('admin.courses.create') }}" class="add-new-btn"><i class="fas fa-plus"></i> Add New Course</a>
                </div>

                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Language</th>
                                <th>Level</th>
                                <th>Instructor</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>                        <tbody>
                            @forelse ($courses as $course)
                            <tr>
                                <td class="course-info">
                                    @if ($course->image_path)
                                    <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}">
                                    @else
                                    <img src="{{asset('images/courses.png')}}" alt="{{ $course->title }}">
                                    @endif
                                    <div>
                                        <p>{{ $course->title }}</p>
                                        <span>Created: {{ $course->created_at->format('M d, Y') }}</span>
                                    </div>
                                </td>
                                <td>{{ $course->language }}</td>
                                <td><span class="badge {{ $course->language_level }}">{{ ucfirst($course->language_level) }}</span></td>
                                <td>{{ $course->instructor ?? 'Not Assigned' }}</td>
                                <td><span class="badge {{ $course->status }}">{{ ucfirst($course->status) }}</span></td>
                                <td class="actions">
                                    <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No courses found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    <button class="pagination-btn"><i class="fas fa-angle-left"></i></button>
                    <button class="pagination-btn active">1</button>
                    <button class="pagination-btn">2</button>
                    <button class="pagination-btn">3</button>
                    <button class="pagination-btn"><i class="fas fa-angle-right"></i></button>
                </div>
            </div>

            <div class="tab-content" id="exercises-content">
                <div class="page-header">
                    <h2>Exercises Management</h2>
                    <a href="{{ route('admin.exercises.create') }}" class="add-new-btn"><i class="fas fa-plus"></i> Add New Exercise</a>
                </div>

                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Exercise Name</th>
                                <th>Course</th>
                                <th>Type</th>
                                <th>Difficulty</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>                        <tbody>
                            @forelse ($exercises as $exercise)
                            <tr>
                                <td class="exercise-info">
                                    <div>
                                        <p>{{ $exercise->title }}</p>
                                        <span>Created: {{ $exercise->created_at->format('M d, Y') }}</span>
                                    </div>
                                </td>
                                <td>{{ $exercise->course->title ?? 'Unknown Course' }}</td>
                                <td>{{ ucfirst($exercise->skill_focus) }}</td>
                                <td>
                                    @php
                                        $difficulty = '';
                                        if ($exercise->language_level == 'beginner') $difficulty = 'easy';
                                        elseif ($exercise->language_level == 'intermediate') $difficulty = 'medium';
                                        elseif ($exercise->language_level == 'advanced') $difficulty = 'hard';
                                    @endphp
                                    <span class="badge {{ $difficulty }}">{{ ucfirst($difficulty ?: 'Easy') }}</span>
                                </td>
                                <td><span class="badge {{ $exercise->status ?? 'published' }}">{{ ucfirst($exercise->status ?? 'Published') }}</span></td>
                                <td class="actions">
                                    <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No exercises found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    <button class="pagination-btn"><i class="fas fa-angle-left"></i></button>
                    <button class="pagination-btn active">1</button>
                    <button class="pagination-btn">2</button>
                    <button class="pagination-btn">3</button>
                    <button class="pagination-btn"><i class="fas fa-angle-right"></i></button>
                </div>
            </div>

            <div class="tab-content" id="quizzes-content">
                <div class="page-header">
                    <h2>Quiz Management</h2>
                    <a href="{{ route('admin.quizzes.create') }}" class="add-new-btn"><i class="fas fa-plus"></i> Add New Quiz</a>
                </div>

                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Quiz Name</th>
                                <th>Course</th>
                                <th>Questions</th>
                                <th>Time Limit</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>                        <tbody>
                            @forelse ($quizzes as $quiz)
                            <tr>
                                <td class="quiz-info">
                                    <div>
                                        <p>{{ $quiz->title }}</p>
                                        <span>Created: {{ $quiz->created_at->format('M d, Y') }}</span>
                                    </div>
                                </td>
                                <td>{{ $quiz->course->title ?? 'Unknown Course' }}</td>
                                <td>{{ $quiz->questions_count ?? 0 }}</td>
                                <td>{{ $quiz->time_limit }} min</td>
                                <td><span class="badge {{ $quiz->status ?? 'published' }}">{{ ucfirst($quiz->status ?? 'Published') }}</span></td>
                                <td class="actions">
                                    <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                                </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No quizzes found</td>
                            </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                <div class="pagination">
                    <button class="pagination-btn"><i class="fas fa-angle-left"></i></button>
                    <button class="pagination-btn active">1</button>
                    <button class="pagination-btn">2</button>
                    <button class="pagination-btn">3</button>
                    <button class="pagination-btn"><i class="fas fa-angle-right"></i></button>
                </div>
            </div>

            <div class="tab-content" id="users-content">
                <div class="page-header">
                    <h2>User Management</h2>
                </div>

                <div class="data-table">
                    <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                <th>Role</th>
                                <th>Joined Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                                </tr>
                        </thead>                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                <td class="user-info">
                                    @if ($user->profile_image)
                                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}">
                                    @else
                                    <img src="{{asset('images/user.png')}}" alt="{{ $user->name }}">
                                    @endif
                                    <div>
                                        <p>{{ $user->name }}</p>
                                    </div>
                                </td>
                                    <td>{{ $user->email }}</td>
                                <td>{{ ucfirst($user->role ?? 'Student') }}</td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td><span class="badge {{ $user->status == 'active' ? 'active-user' : 'inactive-user' }}">{{ ucfirst($user->status ?? 'Active') }}</span></td>
                                <td class="actions">
                                    <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                                </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No users found</td>
                            </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                <div class="pagination">
                    <button class="pagination-btn"><i class="fas fa-angle-left"></i></button>
                    <button class="pagination-btn active">1</button>
                    <button class="pagination-btn">2</button>
                    <button class="pagination-btn">3</button>
                    <button class="pagination-btn"><i class="fas fa-angle-right"></i></button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.menu-item').forEach(i => {
                    i.classList.remove('active');
                });
                
                this.classList.add('active');
                
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.remove('active');
                });
                
                const tabId = this.getAttribute('data-tab') + '-content';
                document.getElementById(tabId).classList.add('active');
            });
        });

        document.querySelector('.toggle-sidebar').addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            
            sidebar.classList.toggle('active');
            
            if (sidebar.classList.contains('active')) {
                mainContent.classList.add('sidebar-expanded');
            } else {
                mainContent.classList.remove('sidebar-expanded');
            }
        });
    </script>
</body>
</html>