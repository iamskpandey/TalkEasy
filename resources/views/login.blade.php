<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TalkEasy - Login to Your Language Learning Journey</title>
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-left">
                <div class="login-header">
                    <h1>TalkEasy</h1>
                    <p>Your journey to language mastery begins here</p>
                </div>
                <div class="login-features">
                    <div class="feature">
                        <i class="fas fa-globe"></i>
                        <span>Learn 50+ languages</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-users"></i>
                        <span>Connect and Practise</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-certificate"></i>
                        <span>Earn certificates</span>
                    </div>
                </div>
            </div>
            
            <div class="login-right">
                <div class="login-form-container">
                    <h2>Welcome Back</h2>
                    <p>Please sign in to continue your language learning journey</p>
                    
                    <form action="{{ route('login') }}" method="POST" class="login-form">
                        @csrf
                        
                        @if(session('error'))
                        <div class="alert alert-error">
                            {{ session('error') }}
                        </div>
                        @endif
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <div class="input-with-icon">
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email">
                            </div>
                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-with-icon">
                                <input type="password" id="password" name="password" required placeholder="Enter your password">
                                <i class="far fa-eye toggle-password"></i>
                            </div>
                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-options">
                            <div class="remember-me">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">Remember me</label>
                            </div>
                        </div>
                        
                        <button type="submit" class="login-button">
                            Sign In <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                    <div class="register-link">
                        <p>Don't have an account? <a href="{{ route('register') }}">Sign up now</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.querySelector('.toggle-password').addEventListener('click', function() {
            const passwordInput = document.querySelector('#password');
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
    </script>
</body>
</html>