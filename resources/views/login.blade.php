@extends('layouts.main')

@section('title', 'เข้าสู่ระบบ')

@section('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
    body {
        background: linear-gradient(145deg, rgba(240, 248, 245, 0.95), rgba(255, 255, 255, 0.85)),
        url("{{ asset('images/p1.jpg') }}") no-repeat center center fixed;
        background-size: cover;
        font-family: 'Prompt', sans-serif;
        color: #ffffff;
        min-height: 100vh;
        margin: 0;
        padding: 0;
    }

    .layout-wrapper {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        position: relative;
    }

    .background-blur {
        position: fixed;
        inset: 0;
        background: no-repeat center center;
        background-size: cover;
        filter: blur(8px);
        transform: scale(1.05);
        z-index: 0;
        opacity: 0;
        transition: background-image 1s ease-in-out, opacity 1s ease-in-out;
    }

    .background-blur.show {
        opacity: 1;
    }



    .login-wrapper {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        position: relative;
        z-index: 1;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 16px;
        padding: 3rem;
        width: 100%;
        max-width: 480px;
        color: #333;
        box-shadow: 0 10px 30px rgba(0, 82, 33, 0.2);
        border: 1px solid #e0e0e0;
        animation: fadeIn 0.8s ease-out;
        position: relative;
        z-index: 2;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(40px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-card h3 {
        text-align: center;
        font-weight: 700;
        margin-bottom: 1.5rem;
        font-size: 1.75rem;
        color: #005221;
        position: relative;
        padding-bottom: 15px;
    }

    .login-card h3::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: #00a651;
    }

    .medcmu-logo {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .medcmu-logo img {
        height: 80px;
    }

    .form-label {
        color: #005221;
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }

    .form-label i {
        margin-right: 8px;
        font-size: 0.9em;
        color: #00a651;
    }

    .form-control {
        background-color: #fff;
        border: 1px solid #ddd;
        color: #333;
        transition: all 0.3s ease;
        padding: 0.75rem 1rem;
        border-radius: 8px !important;
    }

    .form-control:focus {
        border-color: #00a651;
        box-shadow: 0 0 0 0.25rem rgba(0, 166, 81, 0.25);
    }

    .btn-login {
        background: linear-gradient(135deg, #00a651, #00703c);
        border: none;
        font-weight: 600;
        color: white;
        padding: 0.8rem;
        border-radius: 8px !important;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 112, 60, 0.3);
        letter-spacing: 0.5px;
    }

    .btn-login:hover {
        background: linear-gradient(135deg, #00703c, #005221);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 112, 60, 0.4);
    }

    .input-group .btn {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
        color: white;
        background-color: #00a651;
        border: 1px solid #00a651;
    }

    .input-group .btn:hover {
        background-color: #00703c;
        border-color: #00703c;
    }

    .forgot-link {
        text-align: center;
        margin-top: 1.5rem;
    }

    .forgot-link a {
        color: #00a651;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .forgot-link a:hover {
        color: #005221;
        text-decoration: underline;
    }

    .alert {
        font-size: 0.9rem;
        background-color: rgba(220, 53, 69, 0.1);
        border: 1px solid rgba(220, 53, 69, 0.3);
        color: #dc3545;
        border-radius: 8px;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 576px) {
        .login-card {
            padding: 2rem 1.5rem;
            margin: 0 1rem;
        }

        .medcmu-logo img {
            height: 60px;
        }
    }
</style>
@endsection

@section('content')
<div class="layout-wrapper">
    <div class="background-blur" id="blurBg"></div>

    <div class="login-wrapper">
        <div class="login-card">
            <div class="medcmu-logo">
                <img src="{{ asset('images/logo.png') }}" alt="CMU Logo">
            </div>

            <h3><i class="fas fa-user-md me-2"></i>ระบบหนังสือแจ้งเวียนออนไลน์</h3>
            <center>
                <p>คณะแพทยศาสตร์ มหาวิทยาลัยเชียงใหม่</p>
            </center>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="username" class="form-label">
                        <i class="fas fa-user"></i> ชื่อผู้ใช้
                    </label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i> รหัสผ่าน
                    </label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" required>
                        <button class="btn" type="button" id="togglePassword">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i> เข้าสู่ระบบ
                    </button>
                </div>

                {{-- ✅ ปุ่มเข้าสู่หน้าหลัก --}}
                <div class="d-grid mt-2">
                    <a href="{{ route('circulars.index') }}" class="btn btn-outline-success">
                        <i class="fas fa-arrow-left me-2"></i> เข้าสู่หน้าหลัก
                    </a>
                </div>

                <div class="forgot-link mt-3">
                    <a href="#"><i class="fas fa-key me-1"></i>ลืมรหัสผ่าน?</a>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordField = document.getElementById('password');
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;
        this.innerHTML = type === 'password' ?
            '<i class="fa-solid fa-eye"></i>' :
            '<i class="fa-solid fa-eye-slash"></i>';
    });
</script>
@endsection
