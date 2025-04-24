@extends('layouts.main')

@section('title', 'แก้ไขข้อมูลผู้ใช้')

@section('content')

<style>
    body {
        background: linear-gradient(120deg, rgba(33, 92, 67, 0.9), rgba(50, 105, 79, 0.9)),
        url("{{ asset('images/hero-bg-abstract.jpg') }}") no-repeat center center fixed;
        background-size: cover;
        font-family: 'Prompt', sans-serif;
        color: #ffffff;
        min-height: 100vh;
        margin: 0;
        padding: 0;
    }

    .container {
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    .card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
        background-color: #ffffff;
    }

    .card-header {
        border-top-left-radius: 18px;
        border-top-right-radius: 18px;
        background: linear-gradient(90deg, #4caf50, #81c784);
        color: #ffffff;
        font-weight: 700;
        text-align: center;
        padding: 1.5rem;
        font-size: 1.4rem;
    }

    .form-label {
        font-weight: 600;
        color: #2e3c3a;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #c8e6c9;
        background-color: #f9fdf9;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #66bb6a;
        box-shadow: 0 0 0 0.2rem rgba(102, 187, 106, 0.25);
    }

    .btn-warning {
        background-color: #43a047;
        border-color: #43a047;
        font-weight: 600;
        color: #fff;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
    }

    .btn-warning:hover {
        background-color: #2e7d32;
        border-color: #2e7d32;
    }

    .btn-secondary {
        font-weight: 600;
        color: #ffffff;
        background-color: #78909c;
        border-color: #78909c;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
    }

    .btn-secondary:hover {
        background-color: #546e7a;
        border-color: #546e7a;
    }

    .alert-danger {
        border-radius: 10px;
        font-size: 0.95rem;
        background-color: #fbe9e7;
        color: #c62828;
        border: 1px solid #ef9a9a;
    }

    @media (max-width: 768px) {
        .card {
            margin: 1rem;
        }

        .text-end {
            text-align: center !important;
            margin-top: 1rem;
        }
    }
</style>

<div class="container py-5">
    <div class="card mx-auto" style="max-width: 620px;">
        <div class="card-header">
            <i class="fas fa-user-edit me-2"></i> แก้ไขข้อมูลผู้ใช้
        </div>
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle me-1"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('validate.update', $employee->idx) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">ชื่อ</label>
                    <input type="text" name="fname" class="form-control" value="{{ old('fname', $employee->fname) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">นามสกุล</label>
                    <input type="text" name="lname" class="form-control" value="{{ old('lname', $employee->lname) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">หน่วยงาน</label>
                    <input type="text" name="T_Worku_name" class="form-control" value="{{ old('T_Worku_name', $employee->T_Worku_name) }}">
                </div>

                <div class="text-end">
                    <a href="{{ route('validate.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left me-1"></i> ย้อนกลับ
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i> อัปเดต
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection