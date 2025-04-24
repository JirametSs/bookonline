@extends('layouts.main')

@section('title', 'กำหนดสิทธิ์')

@section('content')
<style>
    body {
        background: linear-gradient(120deg, rgba(10, 25, 47, 0.9), rgba(36, 144, 72, 0.9)),
        url("{{ asset('images/hero-bg-abstract.jpg') }}") no-repeat center center fixed;
        background-size: cover;
        font-family: 'Prompt', sans-serif;
        color: #ffffff;
        min-height: 100vh;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        color: #1b4332;
        overflow: hidden;
        backdrop-filter: blur(5px);
    }

    .card-header {
        background-color: #047857;
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
        padding: 1.25rem 2rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }


    .card-header h4 {
        font-weight: 600;
        font-size: 1.6rem;
        margin-bottom: 0;
        color: #ffffff;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .table th,
    .table td {
        vertical-align: middle !important;
        text-align: center;
        font-size: 0.95rem;
        padding: 0.75rem;
    }

    .table thead {
        background-color: #e8f5e9;
    }

    .table th {
        font-weight: 600;
        color: #1b5e20;
    }

    .badge {
        font-size: 0.85rem;
        padding: 0.45em 1em;
        border-radius: 2rem;
        font-weight: 500;
    }

    .badge-admin {
        background-color: #2e7d32 !important;
        color: #fff;
    }

    .badge-user {
        background-color: #e8f5e9 !important;
        color: #1b5e20;
    }

    .btn {
        border-radius: 0.5rem;
        padding: 0.5rem 1.2rem;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.2s ease-in-out;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .btn-outline-light {
        border-color: rgba(255, 255, 255, 0.3);
    }

    .btn-outline-light:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .btn-danger {
        background-color: #e53935;
        color: #fff;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c62828;
        transform: translateY(-1px);
    }

    .btn-info {
        background-color: #0288d1;
        color: #fff;
    }

    .btn-info:hover {
        background-color: #0277bd;
    }

    .btn-success {
        background-color: #388e3c;
        color: #fff;
    }

    .btn-success:hover {
        background-color: #2e7d32;
    }

    .alert {
        border-radius: 0.5rem;
        border: none;
        padding: 1rem;
    }

    .alert-success {
        background-color: rgba(40, 167, 69, 0.15);
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .alert-danger {
        background-color: rgba(220, 53, 69, 0.15);
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    .modal-header {
        background: linear-gradient(135deg, #1b5e20, #2e7d32);
    }

    .table-responsive {
        border-radius: 0.75rem;
        overflow: hidden;
    }

    .table {
        margin-bottom: 0;
    }

    .table tbody tr:hover {
        background-color: rgba(200, 230, 201, 0.3);
    }

    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .btn {
            width: 100%;
            margin-top: 0.5rem;
        }
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-user-shield me-2"></i>กำหนดสิทธิ์ผู้ใช้งาน</h4>
                    <a href="{{ route('validate.createAdmin') }}" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-user-plus me-1"></i> เพิ่มผู้ใช้ใหม่
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <h5 class="mb-0">เกิดข้อผิดพลาด</h5>
                        </div>
                        <ul class="mb-0 mt-2 ps-3">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('validate.update') }}">
                        @csrf

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th>หน่วยงาน</th>
                                        <th>สิทธิ์</th>
                                        <th>การดำเนินการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($admins as $admin)
                                    <tr>
                                        <td>{{ $admin->fname }} {{ $admin->lname }}</td>
                                        <td>{{ $admin->unit_name ?? '-' }}</td>
                                        <td>
                                            <span class="badge {{ $admin->user_group ? 'badge-admin' : 'badge-user' }}">
                                                {{ $admin->user_group ? 'Admin' : 'User' }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-danger btn-sm"
                                                data-delete-url="{{ route('validate.destroy', $admin->idx) }}"
                                                onclick="confirmDelete(this)">
                                                <i class="fas fa-trash-alt me-1"></i> ลบ
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">ไม่พบรายการผู้ใช้งาน</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('circulars.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> ย้อนกลับ
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(button) {
        const deleteUrl = button.getAttribute('data-delete-url');

        Swal.fire({
            title: 'ยืนยันการลบ',
            text: "คุณต้องการลบผู้ใช้นี้ใช่หรือไม่? การดำเนินการนี้ไม่สามารถยกเลิกได้!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash-alt me-1"></i>ลบ',
            cancelButtonText: '<i class="fas fa-times me-1"></i>ยกเลิก',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';

                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';

                form.appendChild(csrf);
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 5000);
</script>
@endsection