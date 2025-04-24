@extends('layouts.main')

@section('title', 'โปรไฟล์ของฉัน')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg p-4 border-0" style="max-width: 720px; margin: auto;">
        <h4 class="mb-4 text-center text-success"><i class="bi bi-person-circle me-2"></i>โปรไฟล์ของฉัน</h4>

        @if($user)
        <dl class="row">
            <dt class="col-sm-4">ชื่อ-นามสกุล:</dt>
            <dd class="col-sm-8">{{ $user['prefix_short'] }}{{ $user['fname'] }} {{ $user['lname'] }}</dd>

            <dt class="col-sm-4">ชื่อผู้ใช้:</dt>
            <dd class="col-sm-8">{{ $user['username'] ?? '-' }}</dd>

            <dt class="col-sm-4">ตำแหน่ง:</dt>
            <dd class="col-sm-8">{{ $user['position_name'] ?? '-' }}</dd>

            <dt class="col-sm-4">หน่วยงาน:</dt>
            <dd class="col-sm-8">{{ $user['T_Work_name'] ?? '-' }}</dd>

            <dt class="col-sm-4">กลุ่มงานย่อย:</dt>
            <dd class="col-sm-8">{{ $user['T_Worku_name'] ?? '-' }}</dd>

            <dt class="col-sm-4">เบอร์โทร:</dt>
            <dd class="col-sm-8">{{ $user['tel_o'] ?? '-' }}</dd>

            <dt class="col-sm-4">อีเมล:</dt>
            <dd class="col-sm-8">{{ $user['email_cmu'] ?? '-' }}</dd>
        </dl>
        @else
        <div class="alert alert-danger text-center">ไม่พบข้อมูลผู้ใช้</div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('circulars.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> กลับหน้าหลัก
            </a>
        </div>
    </div>
</div>
@endsection