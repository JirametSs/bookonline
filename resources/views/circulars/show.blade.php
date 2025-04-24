@extends('layouts.main')

@section('title', 'ดูรายละเอียดหนังสือเวียน')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">รายละเอียดหนังสือเวียน</h2>

    <p><strong>เรื่อง:</strong> {{ $circular->topic }}</p>
    <p><strong>เลขที่หนังสือ:</strong> {{ $circular->book_no }}</p>
    <p><strong>หน่วยงาน:</strong> {{ $circular->unit_name }}</p>

    @if ($circular->file_name)
    <iframe src="{{ route('circulars.pdfView', $circular->book_id) }}" width="100%" height="600px"></iframe>
    @else
    <p class="text-danger">ไม่มีไฟล์แนบ</p>
    @endif

    <a href="{{ route('circulars.index') }}" class="btn btn-secondary mt-3">กลับ</a>
</div>
@endsection