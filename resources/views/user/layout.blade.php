<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - TalkEasy</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css'])
    
    <style>
        :root {
            --primary-color: #4A6FDC;
            --secondary-color: #384B94;
            --accent-color: #FF7D54;
            --light-gray: #f5f7fa;
            --dark-gray: #343a40;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-gray);
            color: #333;
            line-height: 1.6;
        }
        
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 250px;
            background-color: var(--primary-color);
            color: white;
            transition: all 0.3s;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 10;
        }
        
        .sidebar-collapsed {
            width: 70px;
        }
        
        .logo {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .logo h1 {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }
        
        .logo span {
            font-size: 0.8rem;
            background-color: var(--accent-color);
            padding: 3px 8px;
            border-radius: 10px;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .menu-item:hover, .menu-item.active {
            background-color: var(--secondary-color);
        }
        
        .menu-item i {
            font-size: 1.2rem;
            margin-right: 10px;
            width: 25px;
            text-align: center;
        }
        
        .sidebar-collapsed .menu-item span {
            display: none;
        }
        
        .sidebar-footer {
            margin-top: auto;
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-footer a {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            padding: 10px 0;
        }
        
        .sidebar-footer a i {
            margin-right: 10px;
            width: 25px;
            text-align: center;
        }
        
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }
        
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .toggle-sidebar {
            font-size: 1.3rem;
            cursor: pointer;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
        }
        
        .user-profile img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        .content-wrapper {
            padding: 30px;
            height: 100%;
            overflow-y: auto;
        }
        
        .page-header {
            margin-bottom: 30px;
        }
        
        .page-header h2 {
            font-size: 1.8rem;
            color: var(--dark-gray);
            margin-bottom: 5px;
        }
        
        .page-header p {
            color: #6c757d;
        }
        
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .stat-card-content h3 {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 10px;
        }
        
        .stat-number {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--dark-gray);
        }
        
        .stat-card-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.5rem;
        }
        
        .course-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .course-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }
        
        .course-card:hover {
            transform: translateY(-5px);
        }
        
        .course-image {
            height: 160px;
            background-color: #e9ecef;
            position: relative;
        }
        
        .course-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .course-level {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            background-color: white;
        }
        
        .course-level.beginner {
            background-color: #d4edda;
            color: #155724;
        }
        
        .course-level.intermediate {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .course-level.advanced {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .course-content {
            padding: 20px;
        }
        
        .course-title {
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: var(--dark-gray);
        }
        
        .course-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        
        .course-info span {
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .progress-bar {
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            margin-bottom: 10px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background-color: var(--primary-color);
            border-radius: 4px;
        }
        
        .course-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        
        .btn {
            padding: 8px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background-color 0.3s;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
        }
        
        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }
        
        .btn-outline:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .lessons-list {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 30px;
        }
        
        .lessons-section {
            border-bottom: 1px solid #e9ecef;
        }
        
        .lessons-section:last-child {
            border-bottom: none;
        }
        
        .section-header {
            padding: 15px 20px;
            background-color: #f8f9fa;
            cursor: pointer;
        }
        
        .section-title {
            font-size: 1.1rem;
            color: var(--dark-gray);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .section-lessons {
            padding: 10px 0;
        }
        
        .lesson-item {
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f8f9fa;
            transition: background-color 0.3s;
        }
        
        .lesson-item:hover {
            background-color: #f8f9fa;
        }
        
        .lesson-item:last-child {
            border-bottom: none;
        }
        
        .lesson-title {
            display: flex;
            align-items: center;
        }
        
        .lesson-title i {
            margin-right: 10px;
            width: 25px;
            text-align: center;
            color: var(--primary-color);
        }
        
        .lesson-status {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .completed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .in-progress {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .not-started {
            background-color: #e9ecef;
            color: #6c757d;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -250px;
                height: 100vh;
            }
            
            .sidebar.active {
                left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .stats-cards, .course-cards {
                grid-template-columns: 1fr;
            }
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            border-left: 4px solid;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: var(--success-color);
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-color: var(--danger-color);
        }
        
        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border-color: #0c5460;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar" id="sidebar">
            <div class="logo">
                <h1>TalkEasy</h1>
                <span>Student</span>
            </div>
            <div class="sidebar-menu">
                <a href="{{ route('user.dashboard') }}" class="menu-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('user.courses') }}" class="menu-item {{ request()->routeIs('user.courses') ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap"></i>
                    <span>My Courses</span>
                </a>
                <a href="{{ route('courses') }}" class="menu-item">
                    <i class="fas fa-search"></i>
                    <span>Find Courses</span>
                </a>
                <a href="{{ route('user.profile') }}" class="menu-item {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    <span>My Profile</span>
                </a>
            </div>
            <div class="sidebar-footer">
                <a href="{{ route('homepage') }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <div class="main-content">
            <div class="top-bar">
                <div class="toggle-sidebar" id="toggle-sidebar">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="user-profile">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=random" alt="User">
                    <span>{{ Auth::user()->name }}</span>
                </div>
            </div>

            <div class="content-wrapper">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script>
        document.getElementById('toggle-sidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('sidebar-collapsed');
        });
        
        document.querySelectorAll('.section-header').forEach(header => {
            header.addEventListener('click', function() {
                this.parentElement.querySelector('.section-lessons').classList.toggle('active');
                this.querySelector('i').classList.toggle('fa-chevron-down');
                this.querySelector('i').classList.toggle('fa-chevron-up');
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html> 