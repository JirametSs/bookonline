@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="text-center mb-5">
        <h3>หนังสือแจ้งเวียน คณะแพทยศาสตร์ มหาวิทยาลัยเชียงใหม่</h3>
        <!-- @if (session('saved_success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i>
            {{ session('saved_success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif -->

        <!-- {{-- @if (session('saved_success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-1"></i>
        {{ session('saved_success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif --}} -->
        @if (session('saved_success'))
        <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
            <div>
                <i class="fas fa-check-circle me-1"></i>
                {{ session('saved_success') }}
                <span id="alert-time" class="ms-2 small text-muted"></span>
            </div>
            <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif



    </div>

    <div class="card shadow-lg border-0">
        <div class="card-header text-white py-3">
            <h5 class="card-title mb-0">จัดการหน่วยงาน</h5>
        </div>

        <div class="card-body">

            {{-- ✅ ฟอร์มแก้ไขหน่วยงาน --}}
            <form id="unitForm" method="POST" action="{{ route('record.update') }}" class="row gy-2 gx-3 align-items-center mb-4">
                @csrf
                <input type="hidden" id="unitIdInput" name="unit_id">

                <div class="col-md-5">
                    <input type="text" id="unitInput" name="unit_name" class="form-control"
                        placeholder="ชื่อหน่วยงาน" value="">
                </div>
                <div class="col-md-auto">
                    <button type="button" class="btn btn-success" id="actionBtn">
                        <i class="fas fa-search me-1"></i> <span id="btnText"> เพิ่ม </span>
                    </button>
                </div>
                <div class="col-md-auto">
                    <a href="{{ route('record.index') }}" class="btn btn-secondary" id="clearBtn">
                        <i class="fas fa-times-circle me-1"></i> Clear
                    </a>
                </div>
                <div class="col-md-auto">
                    <a href="{{ route('circulars.index') }}" class="btn btn-outline-dark">
                        <i class="fas fa-arrow-left me-1"></i> ย้อนกลับหน้าหลัก
                    </a>
                </div>
                <div class="col-md-3 ms-auto">
                    <input type="text" class="form-control" placeholder=" ค้นหาหน่วยงาน..." id="searchUnit">
                </div>
            </form>

            {{-- ✅ ตารางหน่วยงาน --}}
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-primary align-middle">
                        <tr>
                            <th style="width: 15%" class="text-center">รหัสหน่วยงาน</th>
                            <th>ชื่อหน่วยงาน</th>
                            <th style="width: 15%" class="text-center">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($records as $record)
                        <tr class="hover-shadow">
                            <td class="text-center fw-bold">{{ $record->unit_id }}</td>
                            <td>
                                <a href="javascript:void(0);"
                                    class="text-decoration-none text-dark d-block p-2 hover-bg select-unit"
                                    data-id="{{ $record->unit_id }}"
                                    data-name="{{ $record->unit_name }}">
                                    <i class="fas fa-building me-2" style="color: #2e7d32;"></i>
                                    {{ $record->unit_name }}
                                </a>
                            </td>
                            <td class="text-center">
                                <form id="delete-form-{{ $record->unit_id }}" method="POST" action="{{ route('record.delete', $record->unit_id) }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <button type="button" class="btn btn-sm btn-danger px-3" onclick="confirmDelete('{{ $record->unit_id }}')">
                                    <i class="fas fa-trash-alt me-1"></i> ลบ
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4 custom-pagination">
                <nav aria-label="Page navigation">
                    {{ $records->onEachSide(1)->links('pagination::bootstrap-5') }}
                </nav>
            </div>


        </div>

        <div class="card-footer bg-light">
            <div class="text-end text-muted small">
                ข้อมูลอัปเดตล่าสุด: {{ now()->format('d/m/Y H:i') }}
            </div>
        </div>
    </div>
</div>

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

    .hover-bg:hover {
        background-color: #ecfdf5;
        border-radius: 4px;
        transition: background-color 0.2s ease;
    }

    .hover-shadow:hover {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }

    .table th {
        font-weight: 600;
        background-color: #d1fae5;
        color: #064e3b;
    }

    .card {
        border-radius: 10px;
        overflow: hidden;
        border: none;
        background-color: #ffffff;
        color: #1e3d2f;
    }

    .form-control-lg {
        border-radius: 8px;
        border: 1px solid #ced4da;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-success {
        background-color: #059669;
        border-color: #059669;
    }

    .btn-success:hover {
        background-color: #047857;
        border-color: #065f46;
    }

    .btn-warning {
        background-color: #facc15;
        border-color: #eab308;
        color: #374151;
    }

    .btn-warning:hover {
        background-color: #ca8a04;
        border-color: #a16207;
    }

    .custom-pagination .pagination {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
    }

    .custom-pagination .page-link {
        padding: 0.5rem 0.85rem;
        border-radius: 0.5rem;
        color: #065f46;
        background-color: #f0fdf4;
        border: 1px solid #d1fae5;
        transition: all 0.3s ease;
    }

    .custom-pagination .page-link:hover {
        background-color: #047857;
        color: #fff;
    }

    .custom-pagination .page-item.active .page-link {
        background-color: #047857;
        color: #fff;
        font-weight: bold;
        border-color: #047857;
    }

    .custom-pagination .page-item.disabled .page-link {
        background-color: #e2e8f0;
        color: #94a3b8;
        pointer-events: none;
        border-radius: 0.5rem;
    }

    .card-header {
        background-color: #047857;
        color: #ffffff;
        font-weight: bold;
        border-bottom: none;
    }

    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
    }

    .text-primary {
        color: #065f46;
    }

    .custom-pagination nav .pagination {
        display: flex;
        justify-content: center;
        gap: 0.75rem;
    }

    .custom-pagination nav .page-link {
        padding: 0.5rem 0.9rem;
        border-radius: 0.5rem;
        background-color: #f0fdf4;
        color: #065f46;
        border: 1px solid #d1fae5;
        transition: all 0.2s ease;
    }

    .custom-pagination nav .page-link:hover {
        background-color: #047857;
        color: #fff;
    }

    .custom-pagination nav .page-item.active .page-link {
        background-color: #047857;
        color: #fff;
        font-weight: bold;
        border-color: #047857;
    }
</style>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const unitInput = document.getElementById('unitInput');
        const unitIdInput = document.getElementById('unitIdInput');
        const btnText = document.getElementById('btnText');
        const actionBtn = document.getElementById('actionBtn');

        document.querySelectorAll('.select-unit').forEach(el => {
            el.addEventListener('click', function() {
                const unitName = this.dataset.name;
                const unitId = this.dataset.id;

                unitInput.value = unitName;
                unitIdInput.value = unitId;

                btnText.textContent = 'บันทึก';
                actionBtn.classList.remove('btn-success');
                actionBtn.classList.add('btn-warning');
            });
        });

        unitInput.addEventListener('input', function() {
            if (this.value.trim() === '') {
                btnText.textContent = 'ตกลง';
                actionBtn.classList.remove('btn-warning');
                actionBtn.classList.add('btn-success');
                unitIdInput.value = '';
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchUnit');
        const rows = document.querySelectorAll('tbody tr');

        searchInput?.addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            rows.forEach(row => {
                const unitName = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
                row.style.display = unitName.includes(query) ? '' : 'none';
            });
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById("actionBtn").addEventListener("click", function() {
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "คุณต้องการเพิ่มหรือบันทึกข้อมูลนี้ใช่หรือไม่?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'ใช่, ดำเนินการ!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("unitForm").submit();
            }
        });
    });
</script>
<script>
    function confirmDelete(unitId) {
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "การลบหน่วยงานนี้จะไม่สามารถย้อนกลับได้!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${unitId}`).submit();
            }
        });
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('th-TH', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });

        const alertTime = document.getElementById('alert-time');
        if (alertTime) {
            alertTime.innerText = `(เวลา: ${timeString})`;
        }
    });
</script>

@endsection