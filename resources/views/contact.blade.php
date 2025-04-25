<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TalkEasy - Contact Us</title>
    @vite(['resources/css/contact.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="hero-container contact-hero">
        <nav class="navbar">
            <div class="logo">
                <h1>TalkEasy</h1>
            </div>
            <div class="nav-links">
                <a href="{{ route('homepage') }}">Home</a>
                <a href="{{ route('courses') }}">Courses</a>
                <a href="{{ route('contact') }}" class="active">Contact</a>
            </div>
            <div class="auth-buttons">
                <a href="{{ route('login') }}" class="login-btn">Log In</a>
                <a href="{{ route('register') }}" class="signup-btn">Sign Up</a>
            </div>
            <div class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </div>
        </nav>
    </div>

    <div class="contact-container">
        <div class="contact-grid">
            <div class="contact-info">
                <h1>Get in <span class="highlight">Touch</span></h1>
                <p>Have questions about our courses or need assistance? We're here to help you on your language learning journey.</p>
            </div>
            
            <div class="contact-form-section">
                <h2>Send Us a Message</h2>
                
                <form action="#" method="POST" class="contact-form">
                    @csrf
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Your Name</label>
                            <input type="text" id="name" name="name" required placeholder="Enter your name">
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Your Email</label>
                            <input type="email" id="email" name="email" required placeholder="Enter your email">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" required placeholder="Enter your subject">
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Your Message</label>
                        <textarea id="message" name="message" required placeholder="Type your message here..."></textarea>
                    </div>
                    
                    <button type="submit" class="send-btn">
                        Send Message <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
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
                    <li><a href="{{ route('homepage') }}">Home</a></li>
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