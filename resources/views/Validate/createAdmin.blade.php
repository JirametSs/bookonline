@extends('layouts.main')

@section('title', 'เพิ่มผู้ใช้ใหม่')

@section('content')

<style>
    :root {
        --green-main: #047857;
        --green-light: #10b981;
        --text-dark: #1f2937;
        --bg-light: #f0fdf4;
        --border: #e5e7eb;
        --radius: 0.75rem;
        --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    body {
        font-family: 'Prompt', sans-serif;
        background: linear-gradient(120deg, rgba(4, 120, 87, 0.9), rgba(34, 94, 67, 0.95)),
        url("{{ asset('images/hero-bg-abstract.jpg') }}") no-repeat center center fixed;
        background-size: cover;
        color: var(--text-dark);
        margin: 0;
        padding: 0;
    }

    .card {
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow);
        background: #fff;
        border: none;
    }

    .card-header {
        background: linear-gradient(135deg, #047857, #065f46);
        color: white;
        padding: 1.5rem 2rem;
    }

    .card-header h4 {
        margin: 0;
        font-weight: 600;
    }

    .card-body {
        padding: 2rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .form-control,
    .form-select {
        border-radius: var(--radius);
        padding: 0.75rem 1rem;
        border: 1px solid var(--border);
        background-color: #fff;
        transition: border-color 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--green-light);
        outline: none;
        box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.2);
    }

    .form-check-input:checked {
        background-color: var(--green-main);
        border-color: var(--green-main);
    }

    .btn-success {
        background-color: var(--green-main);
        border: none;
        transition: 0.3s ease-in-out;
    }

    .btn-success:hover {
        background-color: var(--green-light);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(4, 120, 87, 0.2);
    }

    .btn-secondary {
        border: 1px solid #ccc;
        background: white;
        color: #555;
    }

    .btn-secondary:hover {
        background: #f1f5f9;
        color: #000;
    }

    .alert {
        border-radius: var(--radius);
        padding: 1rem;
        margin-bottom: 1.25rem;
    }

    .alert-danger {
        background-color: #fee2e2;
        color: #b91c1c;
    }

    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
    }

    .form-text {
        font-size: 0.875rem;
        color: #6b7280;
    }

    @media (max-width: 768px) {
        .card {
            margin: 0 1rem;
        }
    }
</style>



<div class="container py-5">
    <div class="card shadow-lg border-0 mx-auto" style="max-width: 650px;">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0"><i class="fas fa-user-plus me-2"></i> เพิ่มผู้ใช้ใหม่</h4>
        </div>
        <div class="card-body">

            {{-- แสดงข้อความแจ้งเตือน --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <form action="{{ route('validate.store') }}" method="POST" id="userForm">
                @csrf

                {{-- Autocomplete ชื่อ-สกุล --}}
                <div class="mb-3">
                    <label for="personName" class="form-label"><i class="fas fa-user me-2"></i> ชื่อ-สกุล <span class="text-danger">*</span></label>
                    <input type="text" id="personName" class="form-control" placeholder="พิมพ์ชื่อพนักงาน..." required>
                    <input type="hidden" name="username" id="username">
                    <div class="form-text">กรุณาพิมพ์ชื่อพนักงานเพื่อค้นหา</div>
                </div>

                {{-- ประเภทหน่วยงาน --}}
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-building me-2"></i> ประเภทหน่วยงาน <span class="text-danger">*</span></label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="unit_type" id="unit_internal" value="internal" checked>
                        <label class="form-check-label" for="unit_internal">หน่วยงานภายใน</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="unit_type" id="unit_external" value="external">
                        <label class="form-check-label" for="unit_external">หน่วยงานภายนอก (กรอกเอง)</label>
                    </div>
                </div>

                {{-- หน่วยงานภายใน --}}
                <div class="mb-3" id="internal_unit_group">
                    <label for="unit_post_display" class="form-label">หน่วยงาน</label>
                    <input type="text" id="unit_post_display" class="form-control" placeholder="จะแสดงอัตโนมัติเมื่อเลือกชื่อพนักงาน" disabled>
                    <div class="form-text">ระบบจะดึงข้อมูลหน่วยงานอัตโนมัติจากฐานข้อมูล</div>
                </div>

                {{-- หน่วยงานภายนอก --}}
                <div class="mb-3 d-none" id="external_unit_group">
                    <label for="external_unit_input" class="form-label">ชื่อหน่วยงานภายนอก <span class="text-danger">*</span></label>
                    <input type="text" name="T_Worku_name" id="external_unit_input" class="form-control" placeholder="เช่น โรงพยาบาลเชียงรายประชานุเคราะห์">
                    <div class="form-text">กรุณากรอกชื่อหน่วยงานให้ชัดเจน</div>
                </div>

                {{-- ฟิลด์จริงที่ใช้ส่ง --}}
                <input type="hidden" name="T_Worku_name" id="unit_post">

                {{-- สิทธิ์การใช้งาน --}}
                <div class="mb-4">
                    <label class="form-label"><i class="fas fa-key me-2"></i> สิทธิ์การใช้งาน <span class="text-danger">*</span></label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="role" id="role_admin" value="admin" required>
                        <label class="form-check-label" for="role_admin"><i class="fas fa-shield-alt me-1"></i> ผู้ดูแลระบบ (Admin)</label>
                    </div>
                </div>

                {{-- ปุ่ม --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('validate.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> ย้อนกลับ
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> บันทึกข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
    $(document).ready(function() {
        $("#personName").autocomplete({
            minLength: 2,
            source: "{{ route('validate.get_nameEmp') }}",
            select: function(event, ui) {
                event.preventDefault();
                $("#personName").val(ui.item.label);
                $("#username").val(ui.item.value);
                $("#unit_post").val(ui.item.unit_name);
                $("#unit_post_display").val(ui.item.unit_name);
            },
            focus: function(event, ui) {
                event.preventDefault();
                $("#personName").val(ui.item.label);
            },
            change: function(event, ui) {
                if (!ui.item) {
                    $("#personName").val('');
                    $("#username").val('');
                    $("#unit_post_display").val('');
                    $("#unit_post").val('');
                }
            }
        });

        $('input[name="unit_type"]').change(function() {
            if ($(this).val() === 'external') {
                $('#internal_unit_group').addClass('d-none');
                $('#external_unit_group').removeClass('d-none');
                $('#unit_post').val('');
            } else {
                $('#internal_unit_group').removeClass('d-none');
                $('#external_unit_group').addClass('d-none');
                $('#external_unit_input').val('');
            }
        });

        $('#external_unit_input').on('input', function() {
            $('#unit_post').val($(this).val());
        });

        $('#userForm').submit(function(e) {
            let isValid = true;

            if (!$('#username').val()) {
                alert('กรุณาเลือกชื่อพนักงานจากระบบ');
                isValid = false;
            }

            if ($('#unit_external').is(':checked') && !$('#external_unit_input').val()) {
                alert('กรุณากรอกชื่อหน่วยงานภายนอก');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    });
</script>
@endsection