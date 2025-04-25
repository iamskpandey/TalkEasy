<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TalkEasy - Language Courses</title>
    @vite(['resources/css/homepage.css','resources/css/courses.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        button.enroll-btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        
        button.enroll-btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="hero-container courses-hero full-width-section">
        <nav class="navbar">
            <div class="logo">
                <h1>TalkEasy</h1>
            </div>
            <div class="nav-links">
                <a href="{{ route('homepage') }}">Home</a>
                <a href="{{ route('courses') }}" class="active">Courses</a>
                <a href="{{ route('contact') }}">Contact</a>
            </div>
            <div class="auth-buttons">
                <a href="{{ route('login') }}" class="login-btn">Log In</a>
                <a href="{{ route('register') }}" class="signup-btn">Sign Up</a>
            </div>
            <div class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </div>
        </nav>

        <div class="hero-content">
            <div class="hero-text">
                <h1>Explore Our <span class="highlight">Language Courses</span></h1>
                <p>Discover courses designed by expert linguists and native speakers to help you achieve fluency in your target language.</p>
            </div>
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1546410531-bb4caa6b424d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1171&q=80" alt="Global language learning" class="hero-img">
            </div>
        </div>
    </div>

    <div class="courses-section full-width-section">
        <div class="container">            <div class="section-header">
                <h2>Featured Courses</h2>
                <p>Our most popular language learning programs</p>
            </div>
            <div class="courses-grid">
                @forelse ($courses as $course)
                <div class="course-card">
                    <div class="course-image">
                        @if($course->image_path)
                            <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}">
                        @else
                            <img src="{{asset('images/courses.png')}}" alt="{{ $course->title }}">
                        @endif
                        <div class="course-badge {{ $course->language_level }}">{{ ucfirst($course->language_level) }}</div>
                    </div>
                    <div class="course-content">
                        <div class="course-info">
                            <span><i class="fas fa-globe"></i> {{ $course->title }}</span>
                            <span><i class="fas fa-clock"></i> {{ $course->duration }} Weeks</span>
                        </div>
                        <h3>{{ $course->title }}</h3>
                        <p>{{ $course->short_description }}</p>
                        <div class="course-footer">
                            <div class="instructor">
                                <img src="{{asset('images/man.png')}}" alt="Instructor">
                                <span>{{ $course->instructor }}</span>
                            </div>
                            <div class="course-price">
                                <span class="price">₹{{ number_format($course->price, 0) }}</span>
                                @auth
                                    <form action="{{ route('user.course.enroll', $course->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="enroll-btn">Enroll Now</button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="enroll-btn">Login to Enroll</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="course-card">
                    <div class="course-image">
                        <img src="https://images.unsplash.com/photo-1534595038511-9f219fe0c979?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80" alt="Spanish Course">
                        <div class="course-badge beginner">Beginner</div>
                    </div>
                    <div class="course-content">
                        <div class="course-info">
                            <span><i class="fas fa-globe"></i> Spanish</span>
                            <span><i class="fas fa-clock"></i> 8 Weeks</span>
                            <span><i class="fas fa-users"></i> 2,845 Students</span>
                        </div>
                        <h3>Spanish for Beginners: The Complete Method</h3>
                        <p>Master Spanish fundamentals with our comprehensive beginner course featuring interactive exercises and real-world conversations.</p>
                        <div class="course-footer">
                            <div class="instructor">
                                <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Instructor">
                                <span>Priya Sharma</span>
                            </div>
                            <div class="course-price">
                                <span class="price">₹4,999</span>
                                <a href="#" class="enroll-btn">Enroll Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
            
            <div class="courses-cta">
                <button class="load-more-btn">Load More Courses</button>
            </div>
        </div>
    </div>
    <div class="faq-section full-width-section">
        <div class="container">
            <div class="section-header">
                <h2>Frequently Asked Questions</h2>
                <p>Common questions about our language courses</p>
            </div>
            <div class="faq-container">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How long do I have access to a course after purchasing?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>You'll have lifetime access to all course materials after purchasing. This includes any future updates or additional resources added to the course.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Do I need any special equipment for the courses?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>You just need a computer or mobile device with an internet connection. For conversation practice, a microphone is recommended. Some advanced courses may require a webcam for live sessions.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Are there any prerequisites for intermediate or advanced courses?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, intermediate and advanced courses require prior knowledge of the language. We provide a free assessment test to help you determine your current level and recommend suitable courses.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Can I get a certificate upon course completion?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, all our courses offer completion certificates. For certain languages, we also offer proficiency certification exams at additional cost that are recognized by many educational institutions and employers.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What is your refund policy?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>We offer a 30-day money-back guarantee. If you're not satisfied with a course within the first 30 days, you can request a full refund with no questions asked.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cta-section full-width-section">
        <div class="cta-content">
            <h2>Ready to Start Your Language Journey?</h2>
            <p>Choose from over 50 languages and begin your path to fluency today</p>
            <a href="{{ route('register') }}" class="cta-button">Browse All Courses</a>
        </div>
    </div>


    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>TalkEasy</h3>
                <p>Your journey to language mastery begins here. Connect, learn, and grow with our global community.</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="{{ route('courses') }}">Courses</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact Us</h3>
                <p><i class="fas fa-envelope"></i> hello@talkeasy.com</p>
                <p><i class="fas fa-phone"></i> +91 98765 43210</p>
                <p><i class="fas fa-map-marker-alt"></i> Phagwara, Punjab</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 TalkEasy. All rights reserved.</p>
            <div class="footer-bottom-links">
                <a href="#">Facebook</a>
                <a href="#">Twitter</a>
                <a href="#">Instagram</a>
            </div>
        </div>
    </footer>

    <script>
        document.querySelector('.mobile-menu-btn').addEventListener('click', function() {
            document.querySelector('.nav-links').classList.toggle('active');
        });

        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const faqItem = question.parentElement;
                faqItem.classList.toggle('active');
                
                document.querySelectorAll('.faq-item').forEach(item => {
                    if (item !== faqItem && item.classList.contains('active')) {
                        item.classList.remove('active');
                    }
                });
            });
        });

        document.querySelectorAll('.filter-select').forEach(select => {
            select.addEventListener('change', () => {
                console.log('Filter changed:', select.id, select.value);
            });
        });

        document.querySelector('.load-more-btn').addEventListener('click', function() {
            this.innerHTML = 'Loading...';
            setTimeout(() => {
                this.innerHTML = 'No More Courses Available';
                this.disabled = true;
            }, 1500);
        });
    </script>
</body>
</html>