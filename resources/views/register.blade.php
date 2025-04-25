<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TalkEasy - Join Our Language Learning Community</title>
    @vite(['resources/css/register.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="register-container">
            <div class="register-left">
                <div class="register-header">
                    <h1>TalkEasy</h1>
                    <p>Start your language learning journey today</p>
                </div>
                <div class="register-features">
                    <div class="feature">
                        <i class="fas fa-rocket"></i>
                        <span>Quick progress tracking</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-headset"></i>
                        <span>Live conversation practice</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-laptop"></i>
                        <span>Learn anywhere, anytime</span>
                    </div>
                </div>
            </div>
            
            <div class="register-right">
                <div class="register-form-container">
                    <h2>Create Your Account</h2>
                    <p>Join thousands of language enthusiasts worldwide</p>
                    
                    <form action="{{ route('register') }}" method="POST" class="register-form">
                        @csrf
                        
                        @if(session('error'))
                        <div class="alert alert-error">
                            {{ session('error') }}
                        </div>
                        @endif
                        
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <div class="input-with-icon">
                                <i class="fas fa-user"></i>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Enter your full name">
                            </div>
                            @error('name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <div class="input-with-icon">
                                <i class="fas fa-envelope"></i>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="Enter your email">
                            </div>
                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group half">
                                <label for="password">Password</label>
                                <div class="input-with-icon">
                                    <i class="fas fa-lock"></i>
                                    <input type="password" id="password" name="password" required placeholder="Create password">
                                    <i class="far fa-eye toggle-password"></i>
                                </div>
                                @error('password')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group half">
                                <label for="password_confirmation">Confirm Password</label>
                                <div class="input-with-icon">
                                    <i class="fas fa-lock"></i>
                                    <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Confirm password">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="language">Primary Language to Learn</label>
                            <div class="input-with-icon">
                                <i class="fas fa-globe"></i>
                                <select id="language" name="language">
                                    <option value="">Select a language</option>
                                    <option value="spanish">Spanish</option>
                                    <option value="french">French</option>
                                    <option value="german">German</option>
                                    <option value="italian">Italian</option>
                                    <option value="japanese">Japanese</option>
                                    <option value="chinese">Chinese</option>
                                    <option value="korean">Korean</option>
                                    <option value="russian">Russian</option>
                                </select>
                            </div>
                            @error('language')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group checkbox-group">
                            <input type="checkbox" id="terms" name="terms" required>
                            <label for="terms">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label>
                            @error('terms')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <button type="submit" class="register-button">
                            Create Account <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                    
                    <div class="login-link">
                        <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.querySelectorAll('.toggle-password').forEach(toggle => {
            toggle.addEventListener('click', function() {
                const passwordInput = this.previousElementSibling;
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                }
            });
        });
    </script>
</body>
</html>