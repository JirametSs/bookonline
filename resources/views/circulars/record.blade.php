@extends('layouts.main')

@section('title', 'รายการหนังสือแจ้งเวียนล่าสุด')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap');

    :root {
        --primary: #0d9488;
        --primary-light: #5eead4;
        --primary-dark: #065f46;
        --secondary: #f59e0b;
        --accent: #ef4444;
        --text-dark: #1e293b;
        --text-light: #f8fafc;
        --bg-light: #f0fdfa;
        --bg-dark: #134e4a;
        --card-bg: rgba(255, 255, 255, 0.95);
        --border: rgba(0, 0, 0, 0.05);
        --shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
    }

    /* Base */
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

    /* Container */
    .dataTables-container {
        background-color: var(--card-bg);
        border-radius: 16px;
        box-shadow: var(--shadow);
        padding: 2rem;
        margin-top: 2rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    /* Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-title i {
        color: var(--primary);
        font-size: 1.5rem;
    }

    /* Buttons */
    .btn-datatable {
        padding: 0.65rem 1.5rem;
        border-radius: 10px;
        font-weight: 500;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary-dt {
        background: linear-gradient(to right, var(--primary), var(--primary-dark));
        color: #fff;
        box-shadow: 0 4px 16px rgba(13, 148, 136, 0.3);
    }

    .btn-primary-dt:hover {
        background: linear-gradient(to right, var(--primary-light), var(--primary));
        transform: scale(1.03);
    }

    /* Table */
    #circularsTable {
        width: 100%;
        background-color: var(--card-bg);
        border-radius: 12px;
        overflow: hidden;
        border-collapse: separate;
        border-spacing: 0;
    }

    #circularsTable thead th {
        background: var(--primary-dark);
        color: white;
        padding: 1rem;
        font-weight: 700;
        text-align: center;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    #circularsTable tbody td {
        padding: 1rem;
        border-bottom: 1px solid var(--border);
        color: var(--text-dark);
    }

    #circularsTable tbody tr:nth-child(even) {
        background-color: rgba(240, 253, 250, 0.6);
    }

    #circularsTable tbody tr:hover {
        background-color: rgba(0, 168, 140, 0.05);
        transform: scale(1.01);
    }

    /* Badges */
    .badge {
        padding: 0.4rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
        background-color: #e2e8f0;
        color: var(--text-dark);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .badge-notice {
        background-color: var(--secondary);
        color: white;
    }

    /* Links */
    .document-link {
        color: var(--primary-dark);
        font-weight: 500;
        text-decoration: none;
        transition: 0.2s ease;
    }

    .document-link:hover {
        color: var(--primary);
        text-decoration: underline;
    }

    /* Download Button */
    .btn-download {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: var(--primary);
        color: white;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s ease;
    }

    .btn-download:hover {
        background-color: var(--primary-dark);
        transform: scale(1.1);
    }

    /* DataTable Elements */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--primary-dark);
        color: white !important;
    }

    .dataTables_wrapper .dataTables_filter input,
    .dataTables_length select {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 0.45rem 1rem;
        transition: all 0.3s ease;
    }

    .dataTables_filter input:focus,
    .dataTables_length select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.2);
        outline: none;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .page-title {
            font-size: 1.6rem;
        }

        .dataTables-container {
            padding: 1.5rem;
        }
    }
</style>

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<div class="container py-4">
    <div class="dataTables-container">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-file-alt me-2"></i>
                รายการหนังสือแจ้งเวียนล่าสุด(สถานะแจ้งเวียน)
            </h1>
            <a href="{{ route('circulars.index') }}" class="btn-datatable btn-primary-dt">
                <i class="fas fa-arrow-left me-1"></i>
                ย้อนกลับ
            </a>
        </div>

        <table id="circularsTable" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>เรื่อง</th>
                    <th>หน่วยงาน</th>
                    <th>หมวด</th>
                    <th>สถานะ</th>
                    <th>หน้า</th>
                    <th>วันที่</th>
                    <th>อ่านแล้ว</th>
                    <th>ดาวน์โหลด</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($circulars as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <a href="{{ route('circulars.show', $item->book_id) }}" class="document-link">
                            {{ $item->topic }}
                        </a>
                    </td>
                    <td>{{ $item->unit_name ?? $item->unit_out_name ?? 'ไม่ระบุ' }}</td>
                    <td>{{ $item->category_name ?? '-' }}</td>
                    <td>
                        @if($item->notice === '1')
                        <span class="badge badge-notice">แจ้งเวียน</span>
                        @else
                        <span class="badge badge-default">-</span>
                        @endif
                    </td>
                    <td>{{ $item->page_no }}</td>
                    <td data-order="{{ $item->rec_date }}">
                        {{ \Carbon\Carbon::parse($item->rec_date)->format('d/m/Y') }}
                    </td>
                    <td>{{ $item->no_read ?? 0 }}</td>
                    <td>
                        @if ($item->file_name)
                        <a href="{{ route('circulars.read', $item->book_id) }}" class="btn-download" title="ดาวน์โหลด">
                            <i class="fas fa-download"></i>
                        </a>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#circularsTable').DataTable({
            language: {
                lengthMenu: 'แสดง _MENU_ รายการต่อหน้า',
                zeroRecords: 'ไม่พบข้อมูล',
                info: 'แสดงหน้า _PAGE_ จาก _PAGES_',
                infoEmpty: 'ไม่มีข้อมูล',
                infoFiltered: '(กรองจากทั้งหมด _MAX_ รายการ)',
                search: 'ค้นหา:',
                paginate: {
                    first: 'แรก',
                    last: 'สุดท้าย',
                    next: 'ถัดไป',
                    previous: 'ก่อนหน้า'
                },
            },
            responsive: true,
            order: [
                [6, 'desc']
            ],
            columnDefs: [{
                    orderable: false,
                    targets: [8]
                },
                {
                    className: 'dt-center',
                    targets: [0, 4, 5, 7, 8]
                }
            ],
            initComplete: function() {
                $('.dataTables_length select').addClass('form-select form-select-sm');
            },
        });
    });
</script>
@endsection