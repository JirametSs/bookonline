@extends('layouts.main')

@section('title', 'สมัครสมาชิก')

@section('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
    .register-wrapper {
        min-height: 100vh;
        background: url("{{ asset('images/hero-bg-abstract.jpg') }}") center center / cover no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .register-wrapper::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(120deg, rgba(10, 25, 47, 0.8), rgba(32, 58, 85, 0.8));
        backdrop-filter: blur(6px);
        z-index: 1;
    }

    .register-card {
        position: relative;
        z-index: 2;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 24px;
        padding: 3rem;
        width: 100%;
        max-width: 520px;
        color: #ffffff;
        backdrop-filter: blur(15px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4);
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .register-card h3 {
        text-align: center;
        font-weight: 700;
        margin-bottom: 0.8rem;
        color: #ffffff;
    }

    .register-card p {
        text-align: center;
        color: #cccccc;
        margin-bottom: 2rem;
    }

    .form-label {
        color: #f1f1f1;
        font-weight: 500;
    }

    .form-control {
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
    }

    .form-control:focus {
        background-color: rgba(255, 255, 255, 0.18);
        border-color: #64b5f6;
        color: white;
        box-shadow: 0 0 0 0.15rem rgba(100, 181, 246, 0.3);
    }

    .btn-register {
        background: linear-gradient(to right, #43cea2, #185a9d);
        border: none;
        font-weight: 600;
        color: white;
    }

    .btn-register:hover {
        background: linear-gradient(to right, #2bc0e4, #0f2027);
    }

    .alert {
        font-size: 0.9rem;
        background-color: rgba(255, 0, 0, 0.2);
        border: none;
        color: white;
    }

    .login-link {
        text-align: center;
        margin-top: 1rem;
    }

    .login-link a {
        color: #81d4fa;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .login-link a:hover {
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="register-wrapper">
    <div class="register-card">
        <h3>สมัครสมาชิก</h3>
        <p>กรอกข้อมูลเพื่อสร้างบัญชีของคุณ</p>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">ชื่อ-นามสกุล</label>
                <input type="text" class="form-control rounded-3" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">ชื่อผู้ใช้</label>
                <input type="text" class="form-control rounded-3" id="username" name="username" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">อีเมล</label>
                <input type="email" class="form-control rounded-3" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">รหัสผ่าน</label>
                <input type="password" class="form-control rounded-3" id="password" name="password" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">ยืนยันรหัสผ่าน</label>
                <input type="password" class="form-control rounded-3" id="password_confirmation" name="password_confirmation" required>
            </div>

            <div class="d-grid mt-4">
                <button type=" submit" class="btn btn-register btn-lg rounded-pill shadow-sm">
                    สมัครสมาชิก
                </button>
            </div>

            <div class="login-link">
                <a href="{{ route('login') }}">มีบัญชีแล้ว? เข้าสู่ระบบ</a>
            </div>
        </form>
    </div>
</div>
@endsection