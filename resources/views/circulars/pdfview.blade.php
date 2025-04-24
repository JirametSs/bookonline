@extends('layouts.main')

@section('title', 'แสดงหนังสือเวียน')

@section('content')
<div class="container py-4">
    <h3 class="mb-3">
        <i class="fas fa-book-open me-2"></i> {{ $circular->topic }}
    </h3>

    @if ($circular->file_name)
    <div class="ratio ratio-16x9 shadow-sm rounded" style="min-height: 80vh;">
        <iframe src="{{ route('circulars.openPdf', $circular->book_id) }}"
            style="width: 100%; height: 100%; border: none;" allowfullscreen>
        </iframe>
    </div>
    @else
    <div class="alert alert-danger mt-3">
        <i class="fas fa-exclamation-circle me-2"></i> ไม่พบไฟล์ PDF สำหรับหนังสือเวียนนี้
    </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('circulars.downloadPdf', $circular->book_id) }}" class="btn btn-success">
            <i class="fas fa-download me-1"></i> ดาวน์โหลด PDF
        </a>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> กลับ
        </a>
    </div>
</div>
@endsection