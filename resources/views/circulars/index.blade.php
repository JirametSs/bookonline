@extends('layouts.main')

@section('title', 'หนังสือแจ้งเวียน')

@section('head')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap');

    :root {
        --green-main: #1b5e20;
        --green-light: #66bb6a;
        --green-dark: #0f3d15;
        --bg-glass: rgba(255, 255, 255, 0.95);
        --text-color: #263238;
        --muted-color: #607d8b;
        --shadow-deep: 0 10px 28px rgba(0, 0, 0, 0.08);
        --radius: 16px;
        --glass-blur: blur(10px);
        --glass-color: rgba(255, 255, 255, 0.85);
    }

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

    h2 {
        font-size: 3rem;
        font-weight: 800;
        text-align: center;
        color: white;
        margin-top: 3rem;
        margin-bottom: 2.5rem;
        text-shadow: 2px 4px 10px rgba(0, 0, 0, 0.25);
        animation: fadeInDown 1s ease;
        letter-spacing: 0.5px;
    }

    h2::after {
        content: "";
        display: block;
        width: 180px;
        height: 5px;
        margin: 1rem auto 0;
        background: linear-gradient(to right, var(--green-light), var(--green-main));
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(76, 175, 80, 0.4);
    }

    .top-controls {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        padding: 1.5rem 2rem;
        margin: 2rem auto;
        max-width: 100%;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 1rem;
        animation: fadeIn 0.5s ease-out;
    }

    .top-controls form {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 1rem;
        width: 100%;
        max-width: 1200px;
    }

    .top-controls input[type="text"],
    .top-controls select {
        padding: 0.6rem 1rem;
        border: 1px solid #c8e6c9;
        border-radius: 12px;
        background: #ffffff;
        min-width: 180px;
        font-size: 0.95rem;
        color: #2e7d32;
        transition: all 0.3s ease-in-out;
    }

    .top-controls input:focus,
    .top-controls select:focus {
        border-color: #66bb6a;
        box-shadow: 0 0 0 3px rgba(102, 187, 106, 0.2);
        outline: none;
    }

    .btn-search-mini,
    .btn-clear-mini {
        padding: 0.55rem 1rem;
        font-size: 0.9rem;
        border-radius: 12px;
        border: none;
        transition: all 0.3s ease;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-search-mini {
        background-color: #2e7d32;
        color: white;
    }

    .btn-search-mini:hover {
        background-color: #1b5e20;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .btn-clear-mini {
        background-color: #e0f2f1;
        color: #00695c;
    }

    .btn-clear-mini:hover {
        background-color: #b2dfdb;
        transform: translateY(-1px);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {

        .top-controls input,
        .top-controls select,
        .btn-search-mini,
        .btn-clear-mini {
            min-width: 100%;
        }

        .top-controls form {
            flex-direction: column;
        }
    }


    .table-responsive {
        background: var(--bg-glass, rgba(255, 255, 255, 0.95));
        padding: 2rem 3rem;
        margin: 2rem auto;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
        max-width: 96vw;
    }

    table.table {
        font-size: 0.95rem;
        min-width: 1200px;
        border-collapse: separate;
        border-spacing: 0;
    }

    table.table thead th {
        background-color: #e8f5e9;
        color: #1b5e20;
        font-weight: bold;
        padding: 1rem;
        text-align: center;
        vertical-align: middle;
        border-bottom: 2px solid #c8e6c9;
    }

    table.table tbody td {
        background: white;
        padding: 0.75rem 1rem;
        vertical-align: middle;
        text-align: center;
    }

    table.table tbody tr.hilight {
        background: #f0fdf4;
        font-weight: none;
    }

    .badge.bg-success {
        font-size: 0.85rem;
        padding: 0.5em 0.75em;
        border-radius: 1rem;
    }

    .btn {
        font-size: 0.85rem;
        padding: 0.35rem 0.75rem;
    }

    table.dataTable {
        width: 100%;
        border-collapse: collapse;
    }

    table.dataTable thead th {
        background: #e8f5e9;
        color: var(--green-dark);
        padding: 1.1rem;
        border-bottom: 2px solid #c8e6c9;
        text-align: center;
        font-weight: bold;
    }

    table.dataTable tbody td {
        background: white;
        padding: 1rem;
        border-top: 1px solid #eeeeee;
        text-align: center;
        font-size: 0.95rem;
        color: var(--text-color);
    }

    table.dataTable tbody tr {
        transition: all 0.3s ease;
    }

    table.dataTable tbody tr:hover {
        background: #f1f8e9;
        transform: scale(1.01);
        box-shadow: 0 6px 18px rgba(76, 175, 80, 0.15);
        position: relative;
        z-index: 1;
    }

    .badge-status {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        border-radius: 999px;
        font-weight: 600;
        display: inline-block;
        animation: pulse 2s infinite;
    }

    .badge-paid {
        background: #dcedc8;
        color: var(--green-dark);
    }

    .badge-pending {
        background: #fff3cd;
        color: #d39e00;
    }

    .badge-unpaid {
        background: #ffcdd2;
        color: #b71c1c;
    }

    .empty-notice {
        background: var(--bg-glass);
        border: 2px dashed var(--green-light);
        border-radius: var(--radius);
        padding: 3rem;
        margin: 3rem auto;
        text-align: center;
        color: var(--green-main);
        font-weight: 600;
        font-size: 1.1rem;
        box-shadow: var(--shadow-deep);
        animation: fadeIn 1s ease;
        max-width: 800px;
    }

    .leaf {
        position: fixed;
        top: -10%;
        animation: fall 18s linear infinite;
        opacity: 0.5;
        z-index: -1;
        pointer-events: none;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.08));
    }

    .top-controls,
    .table-responsive {
        background: var(--glass-color);
        backdrop-filter: var(--glass-blur);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }


    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    @keyframes fall {
        to {
            transform: translateY(120vh) rotate(360deg);
        }
    }

    .col-sm-12 {
        max-width: 1900px;
    }

    .sorting {
        max-width: 100px;
    }

    .flex-nowrap {
        flex-wrap: nowrap !important;
    }

    .btn-search-mini,
    .btn-clear-mini {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.5rem 1.4rem;
        font-size: 0.9rem;
        font-weight: 600;
        border-radius: 999px;
        border: none;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.25s ease-in-out;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .btn-search-mini {
        background-color: #32694f;
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 0.55rem 1.2rem;
        font-size: 0.95rem;
        font-weight: 500;
        transition: all 0.3s ease-in-out;
    }

    .btn-search-mini:hover {
        background-color: #285a42;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        transform: translateY(-1px);
    }

    .btn-clear-mini {
        background: linear-gradient(135deg, #f5f5f5, #e0e0e0);
        color: #37474f;
        border: 1px solid #cfd8dc;
    }

    .btn-clear-mini:hover {
        transform: translateY(-1px);
        background: linear-gradient(135deg, #eceff1, #cfd8dc);
        box-shadow: 0 6px 18px rgba(97, 97, 97, 0.25);
    }

    .btn-search-mini i,
    .btn-clear-mini i {
        font-size: 1rem;
    }

    .btn-search-mini {
        background-color: #047857;
        color: #fff;
        border: none;
        padding: 0.6rem 1.2rem;
        font-size: 1rem;
        font-weight: 500;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 12px rgba(4, 120, 87, 0.3);
        transition: all 0.3s ease;
    }

    .btn-search-mini i {
        font-size: 1.1rem;
    }

    .btn-search-mini:hover {
        background-color: #065f46;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(6, 95, 70, 0.4);
    }

    .btn-search-mini:active {
        transform: translateY(0);
        box-shadow: 0 2px 6px rgba(6, 95, 70, 0.2);
    }

    .top-controls input,
    .top-controls select {
        height: 44px;
    }

    .d-block w-100 carousel-img-fixed {
        border-radius: 16px;
        overflow: hidden;
        width: 100%;
        max-width: 900px;
        height: 320px;
        margin: 2rem auto;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .carousel-img-fixed {
        width: 100%;
        height: 312px;
        object-fit: cover;
        object-position: center;
    }

    .carousel-caption {
        background: rgba(0, 0, 0, 0.55);
        border-radius: 12px;
        padding: 0.75rem 1rem;
    }

    @media (max-width: 768px) {
        #highlightCarousel {
            max-width: 560px;
            height: 312px;
        }

        .carousel-img-fixed {
            height: 312px;
        }
    }

    @media (max-width: 576px) {
        #highlightCarousel {
            width: 100%;
        }
    }

    .dataTables_wrapper .form-select {
        color: #212529 !important;
    }

    /* ทำให้ข้อความใน table เป็นสีดำ */
    table.dataTable,
    table.dataTable th,
    table.dataTable td {
        color: #212529 !important;
    }

    /* ทำให้ฟิลเตอร์ คำค้นหา และข้อความอื่นๆ ใน DataTable เป็นสีดำ */
    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        color: #212529 !important;
    }

    /* ปรับ placeholder สีเทาเข้มใน input ค้นหา */
    .dataTables_filter input::placeholder {
        color: #6c757d;
    }

    .carousel-img-fixed {
        max-height: 312px;
        width: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
        border-radius: 12px;
        /* เสริมความเนียนตา */
    }

    /* ปุ่มที่เลือกอยู่ */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background-color: #047857 !important;
        color: white !important;
        border: 1px solid #047857 !important;
        border-radius: 6px;
    }

    /* ปุ่มอื่น ๆ */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        background-color: white !important;
        color: #047857 !important;
        border: 1px solid #d1fae5 !important;
        border-radius: 6px;
        margin: 0 2px;
    }

    /* Hover ของปุ่มอื่น ๆ */
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #d1fae5 !important;
        color: #065f46 !important;
        border-color: #a7f3d0 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #047857 !important;
        color: white !important;
        border: none !important;
        border-radius: 6px;
    }

    .d-block w-100 carousel-img-fixed {
        width: 1000px;
        height: 320px;
    }

    .page-link {
        color: #047857;
        background-color: #ffffff;
        border: 1px solid #d1fae5;
        padding: 0.5rem 0.9rem;
        margin: 0 0.2rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease-in-out;
    }

    .page-link:hover {
        color: #ffffff;
        background-color: #047857;
        border-color: #047857;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(4, 120, 87, 0.3);
    }

    .page-item.active .page-link {
        color: #ffffff;
        background-color: #065f46;
        border-color: #065f46;
        font-weight: 600;
        box-shadow: 0 4px 14px rgba(6, 95, 70, 0.3);
    }


    a {
        color: #047857;
        text-decoration: none;
        position: relative;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    a::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -2px;
        width: 100%;
        height: 2px;
        background-color: #047857;
        transform: scaleX(0);
        transform-origin: bottom right;
        transition: transform 0.3s ease;
    }

    a:hover {
        color: #065f46;
    }

    a:hover::after {
        transform: scaleX(1);
        transform-origin: bottom left;
    }
</style>

@endsection

@section('content')

<div class="natural-bg"></div>

@if ($circulars && $circulars->isEmpty())
<div class="empty-notice">ยังไม่มีหนังสือเด่นประจำวัน</div>
@endif

@if (session('success'))
<div class="alert alert-success text-center fw-bold" style="background-color: #d1e7dd; color: #0f5132; border-radius: 10px; padding: 1rem; margin-bottom: 1.5rem;">
    {{ session('success') }}
</div>
@endif
@if($highlightBooks->isNotEmpty())
<div id="highlightCarousel" class="carousel slide mb-5 shadow" data-bs-ride="carousel">

    <!-- Indicators -->
    <div class="carousel-indicators">
        @foreach($highlightBooks as $index => $book)
        <button type="button"
            data-bs-target="#highlightCarousel"
            data-bs-slide-to="{{ $index }}"
            class="{{ $loop->first ? 'active' : '' }}"
            aria-current="{{ $loop->first ? 'true' : 'false' }}"
            aria-label="Slide {{ $index + 1 }}">
        </button>
        @endforeach
    </div>

    <!-- Slides -->
    <div class="carousel-inner">
        @foreach($highlightBooks as $book)
        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
            @if ($book->pic_upload)
            <img src="data:image/jpeg;base64,{{ $book->pic_upload }}"
                class="d-block w-100 carousel-img-fixed" style="height: 300px;" ,
                alt="รูปหนังสือเด่น">

            @else
            <div class="d-flex align-items-center justify-content-center bg-light text-dark" style="height: 400px;">
                <strong>ไม่มีรูปภาพ</strong>
            </div>
            @endif

            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                <h5 class="fw-bold">{{ $book->hilight ?? 'หัวข้อเด่น' }}</h5>
                <p><i class="fas fa-eye me-1"></i> เปิดอ่าน {{ number_format($book->no_read ?? 0) }} ครั้ง</p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#highlightCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">ก่อนหน้า</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#highlightCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">ถัดไป</span>
    </button>
</div>
@endif

@php
session()->keep(['saved_success']);
@endphp


<h2>หนังสือแจ้งเวียน<br>คณะแพทยศาสตร์ มหาวิทยาลัยเชียงใหม่</h2>

<div class="top-controls flex-nowrap">
    @php
    use Carbon\Carbon;
    $now = Carbon::now();
    $months = ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน',
    'กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
    $currentMonth = $months[$now->month - 1];
    $currentYear = $now->year + 543;
    @endphp

    <form method="GET" action="{{ route('circulars.index') }}" class="d-flex flex-wrap justify-content-center gap-2">
        <input type="text" name="keyword" placeholder="คำค้นหา" value="{{ old('keyword', $keyword) }}">

        <select name="month">
            <option value="">เดือน</option>
            @foreach ($months as $month)
            <option value="{{ $month }}"
                {{ old('month', $selectedMonth) == $month ? 'selected' : '' }}>
                {{ $month }}
            </option>
            @endforeach
        </select>

        <select name="year">
            <option value="">ปี</option>
            @for ($y = 2017; $y <= now()->year; $y++)
                @php $buddhistYear = $y + 543; @endphp
                <option value="{{ $buddhistYear }}"
                    {{ old('year', $selectedYear) == $buddhistYear ? 'selected' : '' }}>
                    {{ $buddhistYear }}
                </option>
                @endfor
        </select>


        <select name="category">
            <option value="">--- ทุกหมวด ---</option>
            @foreach ($booktypes->groupBy('booktype') as $key => $group)
            <option value="{{ $key }}" {{ old('category', $selectedCategory) == $key ? 'selected' : '' }}>
                {{ $key }} - {{ $group->first()->booktype_desc }}
            </option>
            @endforeach
        </select>
        <button type="submit" class="btn-search-mini">
            <i class="bi bi-search"></i> ค้นหา
        </button>


        <a href="{{ route('circulars.index') }}" class="btn-clear-mini">
            <i class="fas fa-sync-alt"></i> ล้างค่า
        </a>

    </form>
</div>

<p class="text-center text-white"><strong>วันที่บันทึก:</strong> {{ now()->format('d F Y') }}</p>

@if ($circulars->isNotEmpty())
<div class="table-responsive">
    <table id="datatable" class="table table-bordered table-striped table-hover align-middle text-center w-100">
        <thead>
            <tr>
                <th>No.</th>
                <th>เรื่อง</th>
                <th>หน่วยงาน</th>
                <th>หมวด</th>
                <th>หน้า</th>
                <th>วันที่</th>
                <th>เปิดอ่าน</th>
                @if(session('role') === 'admin')
                <th style="width: 160px;">การจัดการ</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($circulars as $c)
            <tr class="{{ $loop->index < 3 ? 'hilight' : '' }}">
                <td>{{ $loop->iteration + ($circulars->firstItem() - 1) }}</td>
                <td style="text-align: left;">
                    @if ($c->file_name)
                    <a href="{{ route('circulars.pdfView', $c->book_id) }}">
                        <i class="fas fa-file-pdf text-danger me-1"></i> {{ $c->topic }}
                    </a>
                    @else
                    {{ $c->topic }}
                    @endif
                </td>
                <td>
                    @if ($c->unit_id)
                    {{ $c->unit_name ?? 'ไม่ระบุ' }}
                    @else
                    {{ $c->unit_out_name ?? 'ไม่ระบุ' }}
                    @endif
                </td>
                <td>{{ $c->category_name ?? $c->category }}</td>
                <td>{{ $c->page_no }}</td>
                <td>
                    @if ($c->rec_date)
                    {{ \Carbon\Carbon::parse($c->rec_date)->addYears(543)->locale('th')->translatedFormat('j F Y') }}
                    @else
                    -
                    @endif
                </td>
                <td>
                    <span class="badge bg-success text-white">
                        <i class="fas fa-eye me-1"></i> {{ number_format($c->no_read ?? 0) }}
                    </span>
                </td>
                @if(session('role') === 'admin')
                <td style="width: 160px;">
                    <a href="{{ route('circulars.edit', $c->book_id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> แก้ไข
                    </a>

                    <form id="delete-form-{{ $c->book_id }}" action="{{ route('circulars.destroy', $c->book_id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>

                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ $c->book_id }}')">
                        <i class="fas fa-trash-alt me-1"></i> ลบ
                    </button>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-3 text-center text-white" id="stats-box">
    <p>⏳ กำลังโหลดข้อมูลสถิติ...</p>
</div>

@endif

{{-- สคริปต์แสดงใบไม้ร่วง --}}
<style>
    @keyframes fall {
        0% {
            transform: translateY(-10%) rotate(0deg);
        }

        100% {
            transform: translateY(120vh) rotate(360deg);
        }
    }

    .leaf {
        position: fixed;
        top: -10%;
        animation-name: fall;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
        pointer-events: none;
        z-index: -1;
        opacity: 0.6;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        will-change: transform;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const numberOfLeaves = 20;
        const leafImage = "{{ asset('images/leafs.png') }}";

        for (let i = 0; i < numberOfLeaves; i++) {
            const leaf = document.createElement("img");
            leaf.src = leafImage;
            leaf.className = "leaf";

            // Random style
            leaf.style.left = `${Math.random() * 100}%`;
            leaf.style.width = `${20 + Math.random() * 30}px`;
            leaf.style.animationDuration = `${10 + Math.random() * 8}s`;
            leaf.style.animationDelay = `${Math.random() * 5}s`;

            document.body.appendChild(leaf);
        }
    });
</script>


{{-- ดึงข้อมูลผู้ชมจาก API --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch("{{ route('api.visitor-stats') }}")
            .then(response => response.json())
            .then(data => {
                const html = `
                    <p><strong>วันนี้วันที่ ${data.date}</strong> ขณะนี้ท่านอยู่หน้า: <strong>หนังสือทั่วไป</strong></p>
                    <p>จำนวนผู้เข้าชมวันนี้ <strong>${data.today}</strong> | เมื่อวาน <strong>${data.yesterday}</strong></p>
                    <p>ทั้งหมด <strong>${data.total}</strong> รายการ</p>
                `;
                document.getElementById('stats-box').innerHTML = html;
            })
            .catch(() => {
                document.getElementById('stats-box').innerHTML = '<p class="text-danger">⚠️ โหลดข้อมูลสถิติล้มเหลว</p>';
            });
    });
</script>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            responsive: true, // เปิดใช้งาน responsive
            language: {
                search: "ค้นหาข้อมูล:",
                lengthMenu: "แสดง _MENU_ รายการต่อหน้า",
                info: "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                paginate: {
                    previous: "ก่อนหน้า",
                    next: "ถัดไป"
                },
                zeroRecords: "ไม่พบข้อมูลที่ค้นหา",
                infoEmpty: "ไม่มีข้อมูลให้แสดง",
                infoFiltered: "(กรองจากทั้งหมด _MAX_ รายการ)"
            },
            // ปรับการแสดงผลบนมือถือ
            initComplete: function() {
                if ($(window).width() < 768) {
                    this.api().columns().every(function() {
                        var column = this;
                        var title = $(column.header()).text();
                        $(column.header()).attr('data-label', title);
                    });

                    this.api().cells().every(function() {
                        var column = this.column();
                        var title = $(column.header()).text();
                        $(this.node()).attr('data-label', title);
                    });
                }
            },
            // ปรับขนาดฟอนต์ในตาราง
            createdRow: function(row, data, dataIndex) {
                $(row).find('td').css('font-size', '16px');
            }
        });

        // ปรับการแสดงผลเมื่อหน้าจอเปลี่ยนขนาด
        $(window).resize(function() {
            if ($(window).width() < 768) {
                $('#datatable').DataTable().columns().every(function() {
                    var column = this;
                    var title = $(column.header()).text();
                    $(column.header()).attr('data-label', title);
                });

                $('#datatable').DataTable().cells().every(function() {
                    var column = this.column();
                    var title = $(column.header()).text();
                    $(this.node()).attr('data-label', title);
                });
            }
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "หากลบแล้วจะไม่สามารถกู้คืนได้!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
</script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'ยืนยันการลบ',
            text: 'คุณแน่ใจหรือไม่ว่าต้องการลบรายการนี้?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
<script>
    const statsUrl = "{{ route('api.visitor-stats') }}";
</script>

@endsection