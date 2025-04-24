@extends('layouts.main')

@section('title', 'แสดงรูปภาพจาก BLOB')

@section('content')
<style>
    .image-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        max-width: 720px;
        margin: auto;
    }

    .image-card img {
        width: 100%;
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .image-card img:hover {
        transform: scale(1.03);
    }

    .btn-back {
        margin-top: 2rem;
    }
</style>

<div class="container py-5">
    <div class="text-center mb-4">
        <h2 class="text-success fw-bold">ภาพประกอบ</h2>
    </div>

    <div class="image-card">
        @php
        $mime = (new finfo(FILEINFO_MIME_TYPE))->buffer($circular->pic_upload);
        @endphp

        <img src="data:{{ $mime }};base64,{{ $circular->pic_upload }}" alt="ภาพประกอบจากระบบ" />
    </div>

    <div class="text-center btn-back">
        <a href="{{ url()->previous() }}" class="btn btn-outline-success">
            <i class="fas fa-arrow-left me-1"></i> ย้อนกลับ
        </a>
    </div>
</div>
@endsection