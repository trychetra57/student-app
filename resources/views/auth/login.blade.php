<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LEARN Academy</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Battambang:wght@100;300;400;700;900&family=Moul&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #eff7ff 0%, #dee8ed 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Open Sans', 'Battambang', sans-serif;
        }
        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        .login-header {
            background: linear-gradient(135deg, #125875 0%, #0d3f54 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        .login-header h1 {
            font-size: 2rem;
            margin-bottom: 10px;
            font-weight: 700;
        }
        .login-header p {
            margin: 0;
            opacity: 0.9;
        }
        .login-body {
            padding: 40px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #d7dce1;
            padding: 12px 15px;
            font-size: 1rem;
        }
        .form-control:focus {
            border-color: #fcfcfd;
            box-shadow: 0 0 0 0.2rem rgba(61, 139, 253, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #ff7350 0%, #e05e3c 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-weight: 600;
            width: 100%;
            margin-top: 10px;
            color: white;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #e05e3c 0%, #c74a2a 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(255, 115, 80, 0.4);
        }
        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .remember-me input {
            margin-right: 8px;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }
        .register-link p {
            margin: 0;
            color: #666;
        }
        .register-link a {
            color: #125875;
            font-weight: 600;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .alert {
            border-radius: 8px;
            border: none;
            margin-bottom: 20px;
        }
        .form-check {
            padding-left: 0;
        }
        .form-check-input {
            margin-right: 8px;
        }
        .form-check-input:checked {
            background-color: #f9fafb;
            border-color: #f5f6f7;
        }
        .form-check-label {
            margin-bottom: 0;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div style="font-size: 3rem; margin-bottom: 12px; color: #ff7350;"><i class="fas fa-graduation-cap"></i></div>
                <h1>LEARN Academy</h1>
                <p>Login to your account</p>
            </div>

            <div class="login-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-times-circle"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <strong>Login Failed</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" novalidate>
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" 
                               placeholder="your@email.com" required autofocus>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword"
                                    style="border-color: #d7dce1; background: #f8f9fa;"
                                    onclick="togglePasswordVisibility()" title="Show/Hide password">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check remember-me">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-login btn-lg">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </form>

                <div class="register-link">
                    <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
                </div>
                
                @if(app()->environment('local'))
                <div class="mt-4 pt-3 border-top">
                    <div class="d-flex align-items-center justify-content-between p-3 rounded bg-light border" style="background-color: #f8f9fa;">
                        <div class="text-secondary small fw-semibold">
                            <i class="fas fa-laptop-code me-1"></i> Dev Access
                        </div>
                        <form action="{{ route('quick-login') }}" method="POST" class="d-flex align-items-center m-0 gap-2">
                            @csrf
                            <select name="role" class="form-select form-select-sm shadow-none" style="width: 140px; font-size: 0.85rem; border-color: #dee2e6;">
                                <option value="super_admin">Super Admin</option>
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                                <option value="teacher">Teacher</option>
                                <option value="student">Student</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-dark px-3 fw-medium" style="font-size: 0.85rem;">
                                Login
                            </button>
                        </form>
                    </div>
                </div>
                @endif

            </div>
        </div>

        <div style="text-align: center; margin-top: 30px; color: white;">
            <p><small>&copy; 2026 Student Management System. All rights reserved.</small></p>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
