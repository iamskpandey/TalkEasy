<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TalkEasy - Discover a New Way to Learn Languages</title>
    @vite(['resources/css/homepage.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="hero-container">
        <nav class="navbar">
            <div class="logo">
                <h1>TalkEasy</h1>
            </div>
            <div class="nav-links">
                <a href="#">Home</a>
                <a href="courses">Courses</a>
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
                <h1>Learn a Language the <span class="highlight">Natural Way</span></h1>
                <p>Connect and practice real conversations, and achieve fluency faster with TalkEasy's innovative language learning platform.</p>
                <div class="hero-buttons">
                    <a href="{{ route('register') }}" class="get-started-btn">Get Started Free</a>
                    <a href="#how-it-works" class="how-it-works-btn"><i class="fas fa-play-circle"></i> How It Works</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1471&q=80" alt="People learning languages together">
            </div>
        </div>
    </div>

    <div class="features-section" id="features">
        <div class="section-header">
            <h2>Why Choose TalkEasy?</h2>
            <p>Our unique approach makes language learning effective and enjoyable</p>
        </div>
        <div class="features-container">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <h3>Practise</h3>
                <p>Practice with various exercise created for easy learnings.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Progress Tracking</h3>
                <p>Monitor your improvement with detailed analytics and personalized feedback.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-certificate"></i>
                </div>
                <h3>Remember Longer</h3>
                <p>Solve various quizzes to reinforce your learning.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <h3>50+ Languages</h3>
                <p>Learn popular languages like Spanish, French, German, and many more.</p>
            </div>
        </div>
    </div>

    <div class="how-it-works" id="how-it-works">
        <div class="section-header">
            <h2>How TalkEasy Works</h2>
            <p>Our simple three-step process to language mastery</p>
        </div>
        <div class="steps-container">
            <div class="step">
                <div class="step-number">1</div>
                <h3>Sign Up & Choose</h3>
                <p>Create your account and select the language you want to learn.</p>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <h3>Learn & Practice</h3>
                <p>Complete interactive lessons and practice with our quizzes and exercises.</p>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <h3>Master the Language</h3>
                <p>Engage in immersive conversations and real-life scenarios to achieve fluency.</p>
            </div>
        </div>
    </div>

    <div class="testimonials-section">
        <div class="section-header">
            <h2>Success Stories</h2>
            <p>Hear from our community of language learners</p>
        </div>
        <div class="testimonials-container">
            <div class="testimonial-card">
                <div class="testimonial-text">
                    <p>"TalkEasy transformed my language learning journey. In just three months, I was having conversations in Spanish."</p>
                </div>
                <div class="testimonial-author">
                    <img src="{{asset('images/man.png')}}" alt="Krishna Yadav">
                    <div>
                        <h4>Krishna Yadav</h4>
                        <span>Spanish Learner</span>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-text">
                    <p>"I tried many language apps before, but TalkEasy is the only platform that helped me actually speak confidently."</p>
                </div>
                <div class="testimonial-author">
                    <img src="{{asset('images/man.png')}}" alt="Shiv Shankar">
                    <div>
                        <h4>Shiv Shankar</h4>
                        <span>French Learner</span>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-text">
                    <p>"I wanted to learn German, and TalkEasy made it possible! I am now confidently conversing with native speakers."</p>
                </div>
                <div class="testimonial-author">
                    <img src="{{asset('images/women.png')}}" alt="Radha Kumari">
                    <div>
                        <h4>Radha Kumari</h4>
                        <span>German Learner</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="languages-section">
        <div class="section-header">
            <h2>Languages You Can Learn</h2>
            <p>Choose from over 50 languages to start your learning journey</p>
        </div>
        <div class="languages-grid">
            <div class="language-item">Spanish</div>
            <div class="language-item">French</div>
            <div class="language-item">German</div>
            <div class="language-item">Italian</div>
            <div class="language-item">Chinese</div>
            <div class="language-item">Japanese</div>
            <div class="language-item">Korean</div>
            <div class="language-item">Russian</div>
            <div class="language-item">Portuguese</div>
            <div class="language-item">Arabic</div>
            <div class="language-item">Hindi</div>
            <div class="language-item">Turkish</div>
            <div class="language-item">And many more...</div>
        </div>
    </div>

    <div class="cta-section">
        <div class="cta-content">
            <h2>Ready to Start Your Language Journey?</h2>
            <p>Join thousands of successful language learners worldwide</p>
            <a href="{{ route('register') }}" class="cta-button">Create Your Free Account</a>
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
                    <li><a href="#">Home</a></li>
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
    </script>
</body>
</html>