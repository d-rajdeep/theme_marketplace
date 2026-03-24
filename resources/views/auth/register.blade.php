@extends('layouts.app')

@section('title', 'Register - Themeour')

@section('content')
    <div class="auth-page-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2>Create an Account</h2>
                <p>Join Themeour to download premium digital assets</p>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> Oops! Please fix the errors below:
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="input-group">
                    <label for="name"><i class="fas fa-user"></i> Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="John Doe"
                        required autofocus>
                </div>

                <div class="input-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        placeholder="john@example.com" required>
                </div>

                <div class="input-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" placeholder="Minimum 8 characters" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password', 'toggleIcon1')">
                            <i class="far fa-eye" id="toggleIcon1"></i>
                        </button>
                    </div>
                </div>

                <div class="input-group">
                    <label for="password_confirmation"><i class="fas fa-check-circle"></i> Confirm Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="Confirm your password" required>
                        <button type="button" class="toggle-password"
                            onclick="togglePassword('password_confirmation', 'toggleIcon2')">
                            <i class="far fa-eye" id="toggleIcon2"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="auth-btn">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>
            </form>

            <div class="auth-footer">
                Already have an account? <a href="{{ route('login') }}">Login here</a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .auth-page-container {
            min-height: calc(100vh - 300px);
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8fafc;
            padding: 60px 20px;
            font-family: 'Inter', sans-serif;
        }

        .auth-card {
            background: #ffffff;
            width: 100%;
            max-width: 500px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            padding: 40px;
            border: 1px solid #f1f5f9;
            animation: fadeInUp 0.5s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .auth-header h2 {
            font-size: 28px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .auth-header p {
            color: #64748b;
            font-size: 15px;
            margin: 0;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .input-group label i {
            color: #6366f1;
            margin-right: 6px;
        }

        .input-group input[type="text"],
        .input-group input[type="email"],
        .input-group input[type="password"] {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            color: #1e293b;
            transition: all 0.3s ease;
            box-sizing: border-box;
            background-color: #f8fafc;
        }

        .input-group input:focus {
            outline: none;
            border-color: #6366f1;
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 16px;
            padding: 0;
        }

        .toggle-password:hover {
            color: #6366f1;
        }

        .auth-btn {
            width: 100%;
            padding: 14px;
            background: #6366f1;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }

        .auth-btn i {
            margin-right: 8px;
        }

        .auth-btn:hover {
            background: #4f46e5;
        }

        .auth-footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 14px;
            color: #64748b;
        }

        .auth-footer a {
            color: #6366f1;
            text-decoration: none;
            font-weight: 700;
            margin-left: 5px;
        }

        .auth-footer a:hover {
            text-decoration: underline;
            color: #4f46e5;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert ul {
            margin-top: 8px;
            margin-bottom: 0;
            padding-left: 20px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);

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
@endpush
