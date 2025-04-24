@extends('layouts.main')

@section('title', 'เพิ่มหนังสือแจ้งเวียน')

@section('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}" type="text/css" />
<style>
    :root {
        --primary: #047857;
        --primary-light: #d1fae5;
        --primary-dark: #065f46;
        --secondary: #64748b;
        --text: #1e293b;
        --bg: #f8fafc;
        --border: #e2e8f0;
        --error: #ef4444;
        --radius: 14px;
        --shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
    }

    body {
        background: linear-gradient(130deg, rgba(4, 120, 87, 0.9), rgba(15, 80, 60, 0.95)),
        url("{{ asset('images/hero-bg-abstract.jpg') }}") no-repeat center center fixed;
        background-size: cover;
        font-family: 'Prompt', sans-serif;
        color: var(--text);
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    .container {
        max-width: 1000px;
        margin: 2rem auto;
        padding: 1.5rem;
    }

    .form-card {
        background: #ffffff;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 2.5rem 3rem;
        backdrop-filter: blur(8px);
        animation: fadeIn 0.5s ease-out;
    }

    .form-header {
        color: white;
        padding: 1.75rem 2rem;
        text-align: center;
    }

    .form-header h2 {
        margin: 0;
        font-size: 1.9rem;
        font-weight: 700;
        color: black;
    }

    .form-group {
        margin-bottom: 1.75rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--text);
        margin-bottom: 0.6rem;
        display: block;
        font-size: 1rem;
    }

    .form-control,
    .form-select {
        width: 100%;
        padding: 0.85rem 1.1rem;
        font-size: 1rem;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        background: white;
        transition: all 0.25s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(4, 120, 87, 0.15);
        outline: none;
        transform: translateY(-1px);
    }

    .form-control::placeholder {
        color: #9ca3af;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2.5rem;
    }

    .btn {
        padding: 0.8rem 1.5rem;
        font-weight: 600;
        border-radius: var(--radius);
        font-size: 1rem;
        transition: all 0.2s ease-in-out;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
        border: none;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    .btn-secondary {
        background-color: #f1f5f9;
        color: var(--text);
    }

    .btn-secondary:hover {
        background-color: #e2e8f0;
    }

    .btn-success {
        background-color: #22c55e;
        color: white;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: var(--radius);
        display: flex;
        gap: 1rem;
        align-items: center;
        font-size: 0.95rem;
        box-shadow: var(--shadow);
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background: var(--primary-light);
        color: var(--primary-dark);
        border-left: 5px solid var(--primary);
    }

    .alert-danger {
        background: #fee2e2;
        color: #b91c1c;
        border-left: 5px solid var(--error);
    }

    .file-input-label {
        background-color: #f0fdf4;
        border: 2px dashed #a7f3d0;
        padding: 0.8rem 1.25rem;
        border-radius: var(--radius);
        color: var(--primary-dark);
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .file-input-label:hover {
        background: #d1fae5;
        border-color: var(--primary);
    }

    .img-thumbnail {
        border-radius: var(--radius);
        border: 1px solid var(--border);
        padding: 0.3rem;
        background: white;
        transition: transform 0.3s ease;
        max-width: 200px;
    }

    .img-thumbnail:hover {
        transform: scale(1.05);
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

    /* Select2 custom */
    .select2-container--default .select2-selection--single {
        border: 1.5px solid #81c784 !important;
        border-radius: 12px;
        background-color: #f4fff7;
        padding: 0.65rem 1rem;
        transition: all 0.3s ease;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .select2-container--default .select2-selection--single:focus,
    .select2-container--default .select2-selection--single:active {
        outline: none;
        border-color: #43a047 !important;
        box-shadow: 0 0 0 3px rgba(67, 160, 71, 0.2);
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #1b4332 !important;
        font-weight: 500;
        font-size: 1rem;
        padding-left: 0;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100%;
        right: 10px;
    }

    .select2-container--default .select2-results__option {
        padding: 10px 15px;
        font-size: 0.95rem;
        color: #2f4f4f;
        transition: 0.2s ease;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #a5d6a7 !important;
        color: #1b5e20 !important;
        font-weight: 600;
        border-left: 4px solid #66bb6a;
    }

    .select2-container--default .select2-results__option[aria-selected='true'] {
        background-color: #e8f5e9;
        color: #2e7d32;
    }

    .select2-results__options {
        max-height: 220px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #a5d6a7 transparent;
    }

    .select2-results__options::-webkit-scrollbar {
        width: 6px;
    }

    .select2-results__options::-webkit-scrollbar-thumb {
        background-color: #a5d6a7;
        border-radius: 4px;
    }

    /* ขนาดและสไตล์ให้ select2 และ input เท่ากัน */
    .form-control,
    .select2-container--default .select2-selection--single {
        height: 52px !important;
        border-radius: 12px;
        padding: 0.65rem 1rem;
        font-size: 1rem;
        font-weight: 500;
        background-color: #f9fdf9;
        border: 1.5px solid #a5d6a7 !important;
        transition: all 0.3s ease;
    }

    /* ตัวเลือกที่แสดงใน select2 */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 52px !important;
        color: #263238 !important;
        padding-left: 0.2rem;
    }

    /* ลูกศร dropdown */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 52px !important;
        right: 10px;
    }

    /* input ธรรมดา */
    input[type="text"] {
        height: 52px;
        border-radius: 12px;
        padding: 0.65rem 1rem;
        font-size: 1rem;
        border: 1px solid #e0e0e0;
        background-color: #fefefe;
        transition: all 0.3s ease;
    }

    /* Focus style สำหรับทั้ง input และ select2 */
    input[type="text"]:focus,
    .select2-container--default .select2-selection--single:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(67, 160, 71, 0.15);
        border-color: #43a047 !important;
    }

    .select2-selection__placeholder {
        color: #9ca3af !important;
        /* สีเทาเหมือน placeholder ปกติ */
        line-height: 52px !important;
        /* ให้ตรงกลางแนวตั้ง */
        padding-left: 0.2rem;
        font-size: 1rem;
    }

    .select2-container--default .select2-selection--single {
        height: 52px !important;
        border-radius: 12px;
        padding: 0 1rem;
        display: flex;
        align-items: center;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 52px !important;
        padding-left: 0 !important;
    }
</style>


@endsection

@section('content')
<div class="container">
    <div class="form-card">
        <!-- Form Header -->
        <div class="form-header">
            <h2><i class="fas fa-file-alt"></i> เพิ่มหนังสือแจ้งเวียน</h2>
        </div>

        <div class="form-body">
            <!-- Alerts -->
            @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>กรุณาตรวจสอบข้อมูลให้ถูกต้อง</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('circulars.store') }}" enctype="multipart/form-data" id="circularForm">
                @csrf

                @php
                use Carbon\Carbon;
                $now = Carbon::now();
                $now->locale('th');
                $now->addYears(543);
                $formattedDate = $now->translatedFormat('j F Y');
                @endphp

                <!-- วันที่ -->
                <div class="form-group">
                    <label for="thai_date" class="form-label"><i class="fas fa-calendar-alt"></i> วันที่</label>
                    <input type="text" id="thai_date" name="thai_date_display" class="form-control"
                        value="{{ old('thai_date_display', $formattedDate) }}" readonly>
                    <input type="hidden" name="date" value="{{ Carbon::now()->format('Y-m-d') }}">
                </div>

                <!-- หมวดหนังสือ -->
                <div class="form-group">
                    <label for="category" class="form-label"><i class="fas fa-tags"></i> หมวดหนังสือ</label>
                    <select id="category" name="category" class="form-select" required>
                        <option value="">---- กรุณาเลือกรายการ ----</option>
                        @foreach ($booktypes->groupBy('booktype') as $key => $group)
                        <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                            {{ $key }} - {{ $group->first()->booktype_desc }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- เรื่อง -->
                <div class="form-group">
                    <label for="topic" class="form-label"><i class="fas fa-heading"></i> เรื่อง</label>
                    <input type="text" name="topic" id="topic" class="form-control" value="{{ old('topic') }}" placeholder="กรอกชื่อเรื่องหนังสือ" required>
                </div>

                <div class="section-title">
                    <i class="fas fa-building"></i> ข้อมูลหน่วยงาน
                </div>

                <!-- หน่วยงานภายใน / ภายนอก -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="unit_id" class="form-label"><i class="fas fa-university"></i> หน่วยงานภายใน</label>
                            <select id="unit_id" name="unit_id" class="form-select">
                                <option value="" selected>------เลือกหน่วยงานในคณะ------</option>
                                @foreach ($departments as $id => $name)
                                <option value="{{ $id }}" {{ old('unit_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="book_name" class="form-label">
                                <i class="fas fa-external-link-alt"></i> หน่วยงานภายนอก
                            </label>
                            <input type="text"
                                id="book_name"
                                name="book_name"
                                class="form-control"
                                value="{{ old('book_name', $circular->unit_out_name ?? '') }}"
                                placeholder="กรอกชื่อหน่วยงานภายนอก">
                        </div>
                    </div>


                    <div class="section-title">
                        <i class="fas fa-file-pdf"></i> ข้อมูลเอกสาร
                    </div>

                    <!-- จำนวนหน้า -->
                    <div class="form-group">
                        <label for="page_no" class="form-label"><i class="fas fa-file-alt"></i> จำนวนหน้า</label>
                        <input type="number" id="page_no" name="page_no" class="form-control" value="{{ old('page_no') }}" min="1" placeholder="ระบุจำนวนหน้า" required>
                    </div>

                    <!-- PDF -->
                    <div class="form-group">
                        <label for="pdf_file" class="form-label"><i class="fas fa-file-pdf"></i> ไฟล์ PDF</label>
                        <div class="file-input-wrapper">
                            <label class="file-input-label">
                                <span id="file-label-text">เลือกไฟล์ PDF</span>
                                <i class="fas fa-upload"></i>
                                <input type="file" id="pdf_file" name="pdf_file" class="form-control" accept=".pdf" onchange="updateFileName(this)" required>
                            </label>
                            <div id="file-name" class="file-name"></div>
                        </div>
                        <small class="form-text text-danger">
                            รองรับเฉพาะไฟล์ PDF และขนาดไม่เกิน 6MB หากเกินระบบจะไม่ยอมให้แนบ
                        </small>

                    </div>

                    <div class="section-title">
                        <i class="fas fa-shield-alt"></i> การตั้งค่าการเข้าถึง
                    </div>

                    <!-- สิทธิ์เข้าถึง -->
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-users"></i> สิทธิ์เข้าถึง</label>
                        <div class="highlight-box">
                            @foreach ($bookgroups as $group_id => $group_name)
                            <label class="form-check-inline">
                                <input type="checkbox" name="access_group[]" value="{{ $group_id }}"
                                    {{ is_array(old('access_group')) && in_array($group_id, old('access_group')) ? 'checked' : '' }}>
                                {{ $group_name }}
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="section-title">
                        <i class="fas fa-star"></i> การตั้งค่าเพิ่มเติม
                    </div>

                    <input type="hidden" name="notice" id="notice" value="0">


                    <!-- Highlight -->
                    <div class="form-group">
                        <label for="hilight" class="form-label"><i class="fas fa-highlighter"></i> ข้อความไฮไลท์</label>
                        <input type="text" id="hilight" name="hilight" class="form-control" value="{{ old('hilight') }}" placeholder="ข้อความที่จะแสดงเป็นไฮไลท์">
                    </div>

                    <!-- ความสำคัญ -->
                    <div class="form-group">
                        <label for="piority" class="form-label">
                            <i class="fas fa-exclamation-circle"></i> ระดับความสำคัญ
                        </label>
                        <select name="piority" id="piority" class="form-select">
                            @for ($i = 0; $i <= 5; $i++)
                                <option value="{{ $i }}"
                                {{ old('piority', isset($circular) ? $circular->piority : 0) == $i ? 'selected' : '' }}>
                                {{ $i }} - {{ $i == 0 ? 'ปกติ' : ($i == 5 ? 'สำคัญมาก' : 'สำคัญระดับ '.$i) }}
                                </option>
                                @endfor
                        </select>
                    </div>

                    <!-- จำนวนวันที่แสดง -->
                    <div class="form-group">
                        <label for="display_days" class="form-label">
                            <i class="fas fa-calendar-day"></i> จำนวนวันที่แสดง
                        </label>
                        <select name="display_days" id="display_days" class="form-select">
                            <option value="0" {{ old('display_days') == 0 ? 'selected' : '' }}>0 วัน (ไม่แสดง)</option>
                            @for ($i = 1; $i <= 100; $i++)
                                <option value="{{ $i }}" {{ old('display_days', 0) == $i ? 'selected' : '' }}>
                                {{ $i }} วัน
                                </option>
                                @endfor
                        </select>
                    </div>

                    <!-- รูปภาพ -->
                    <div id="image-upload-group" class="form-group mb-4">
                        <label for="image" class="form-label fw-semibold text-success">
                            <i class="fas fa-image me-1"></i> รูปภาพประกอบ
                        </label>

                        <div class="file-input-wrapper position-relative">
                            <label class="file-input-label d-flex align-items-center gap-2 px-3 py-2 bg-light border rounded shadow-sm" style="cursor:pointer;">
                                <i class="fas fa-upload text-primary"></i>
                                <span id="image-label-text">เลือกรูปภาพ</span>
                                <input type="file" name="image" id="image" class="form-control d-none"
                                    accept="image/jpeg,image/jpg,image/png"
                                    onchange="validateImage(this)">
                            </label>
                            <div id="image-name" class="text-muted mt-2 small"></div>
                        </div>

                        <small id="image-error" class="form-text text-danger">
                            รองรับเฉพาะไฟล์ JPG, JPEG, PNG และต้องไม่เกิน 2MB
                        </small>
                    </div>

                    <div id="image-preview" class="mt-3">
                        <!-- แสดง preview ที่นี่ -->
                    </div>
                </div>

                <!-- ปุ่ม -->
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">
                        <i class="fas fa-eraser"></i> ล้างข้อมูล
                    </button>
                    <a href="{{ route('circulars.index') }}" class="btn btn-success">
                        <i class="fas fa-arrow-left"></i> ย้อนกลับ
                    </a>
                    <button type="submit" class="btn btn-primary" onclick="confirmSubmit(event)">
                        <i class="fas fa-save"></i> บันทึกข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#unit_id').select2({
            placeholder: "เลือกหน่วยงานภายใน",
            allowClear: true,
            width: '100%'
        });

        const unitSelect = $('#unit_id');
        const externalAgencyInput = document.getElementById('book_name');

        function toggleAgencyFields() {
            const hasUnit = unitSelect.val()?.trim() !== '';
            const hasExternal = externalAgencyInput?.value.trim() !== '';

            if (hasUnit) {
                externalAgencyInput.disabled = true;
                externalAgencyInput.value = '';
            } else {
                externalAgencyInput.disabled = false;
            }

            if (hasExternal) {
                unitSelect.prop('disabled', true);
                unitSelect.val(null).trigger('change');
            } else {
                unitSelect.prop('disabled', false);
            }
        }

        toggleAgencyFields();
        unitSelect.on('change', toggleAgencyFields);
        externalAgencyInput?.addEventListener('input', toggleAgencyFields);
        window.updateFileName = function(input) {
            const fileName = input.files[0]?.name || 'เลือกไฟล์ PDF';
            document.getElementById('file-label-text').textContent = fileName;
            document.getElementById('file-name').textContent = `ไฟล์ที่เลือก: ${fileName}`;
            document.getElementById('file-name').style.display = 'block';
        };

        window.updateImageName = function(input) {
            const fileName = input.files[0]?.name || 'เลือกรูปภาพ';
            document.getElementById('image-label-text').textContent = fileName;
            document.getElementById('image-name').textContent = `ไฟล์ที่เลือก: ${fileName}`;
            document.getElementById('image-name').style.display = 'block';
        };

        window.resetForm = function() {
            Swal.fire({
                title: 'ยืนยันการล้างข้อมูล?',
                text: "คุณต้องการล้างข้อมูลทั้งหมดในฟอร์มนี้หรือไม่?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'ใช่, ล้างข้อมูล',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('circularForm').reset();
                    $('#unit_id').val(null).trigger('change');
                    document.getElementById('file-label-text').textContent = 'เลือกไฟล์ PDF';
                    document.getElementById('image-label-text').textContent = 'เลือกรูปภาพ';
                    document.getElementById('file-name').style.display = 'none';
                    document.getElementById('image-name').style.display = 'none';
                    Swal.fire(
                        'ล้างข้อมูลแล้ว!',
                        'ฟอร์มของคุณถูกล้างข้อมูลเรียบร้อย',
                        'success'
                    );
                }
            });
        };

        window.confirmSubmit = function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'ยืนยันการบันทึกข้อมูล?',
                text: "คุณต้องการบันทึกหนังสือแจ้งเวียนนี้หรือไม่?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#005221',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'ใช่, บันทึกเลย!',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('circularForm').submit();
                }
            });
        };

        const accessGroupCheckboxes = document.querySelectorAll('input[name="access_group[]"]');
        const newsTypeCheckboxes = document.querySelectorAll('input[name="news_type[]"]');
        const highlightField = document.getElementById('hilight')?.closest('.form-group');
        const priorityField = document.getElementById('piority')?.closest('.form-group');
        const displayDaysField = document.getElementById('display_days')?.closest('.form-group');

        function updateDependentFields() {
            const accessSelected = Array.from(accessGroupCheckboxes).some(cb => cb.checked);
            const newsSelected = Array.from(newsTypeCheckboxes).some(cb => cb.checked);

            newsTypeCheckboxes.forEach(cb => cb.disabled = !accessSelected);

            const allowExtraFields = accessSelected && newsSelected;
            [highlightField, priorityField, displayDaysField].forEach(field => {});
        }

        accessGroupCheckboxes.forEach(cb => cb.addEventListener('change', updateDependentFields));
        newsTypeCheckboxes.forEach(cb => cb.addEventListener('change', updateDependentFields));
        updateDependentFields();
    });
</script>
<script>
    function updateImageName(input) {
        const label = document.getElementById('image-label-text');
        const preview = document.getElementById('image-preview');
        const fileName = document.getElementById('image-name');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            label.textContent = file.name;
            fileName.textContent = file.name;

            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="img-fluid rounded shadow-sm" style="max-height: 200px;">`;
            };
            reader.readAsDataURL(file);
        } else {
            label.textContent = 'เลือกรูปภาพ';
            fileName.textContent = '';
            preview.innerHTML = '';
        }
    }
</script>
<script>
    const pdfInput = document.getElementById('pdf_file');
    const fileLabelText = document.getElementById('file-label-text');
    const fileNameText = document.getElementById('file-name');

    pdfInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file && file.size > 6 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'ไฟล์ใหญ่เกินไป!',
                html: `
                <strong>ขนาดไฟล์ของคุณคือ ${(file.size / (1024 * 1024)).toFixed(2)} MB</strong><br>
                ระบบรองรับเฉพาะไฟล์ PDF ที่มีขนาดไม่เกิน <b>6MB</b> เท่านั้น
            `,
                confirmButtonText: 'ตกลง',
                confirmButtonColor: '#e11d48',
            });

            this.value = '';
            fileLabelText.textContent = 'เลือกไฟล์ PDF';
            fileNameText.textContent = '';
        }
    });
</script>
<script>
    document.getElementById('image')?.addEventListener('change', function() {
        const file = this.files[0];
        const label = document.getElementById('image-label-text');
        const fileName = document.getElementById('image-name');
        const preview = document.getElementById('image-preview');

        if (file && file.size > 2 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'ขนาดรูปใหญ่เกินไป!',
                html: `
                <strong>ขนาดของคุณคือ ${(file.size / (1024 * 1024)).toFixed(2)} MB</strong><br>
                ระบบรองรับรูปภาพขนาดไม่เกิน <b>2MB</b> เท่านั้น`,
                confirmButtonText: 'ตกลง',
                confirmButtonColor: '#e11d48',
            });

            this.value = '';
            label.textContent = 'เลือกรูปภาพ';
            fileName.textContent = '';
            preview.innerHTML = '';
        }
    });
</script>
<script>
    function toggleImageUpload() {
        const checkbox = document.getElementById('show-on-web');
        const imageGroup = document.getElementById('image-upload-group');
        imageGroup.style.display = checkbox.checked ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        toggleImageUpload();
        document.getElementById('show-on-web').addEventListener('change', toggleImageUpload);
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form'); // ปรับตาม class/id ถ้ามี
        const checkbox = document.querySelector('input[name="news_type[]"][value="ทั่วไป"]');
        const highlight = document.querySelector('input[name="hilight"]');
        const displayDays = document.querySelector('input[name="display_days"]');
        const piority = document.querySelector('input[name="piority"]');
        const image = document.querySelector('input[name="image"]');

        function toggleRequiredFields() {
            const required = checkbox.checked;

            highlight.required = required;
            displayDays.required = required;
            piority.required = required;
            image.required = required;

            [highlight, displayDays, piority, image].forEach(input => {
                if (required) {
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });
        }

        checkbox.addEventListener('change', toggleRequiredFields);
        toggleRequiredFields();
    });
</script>
<script>
    function validateImage(input) {
        const file = input.files[0];
        const errorEl = document.getElementById('image-error');
        const nameEl = document.getElementById('image-name');
        const labelText = document.getElementById('image-label-text');

        // Reset preview/error
        errorEl.classList.add('d-none');
        nameEl.textContent = '';
        labelText.textContent = 'เลือกรูปภาพ';

        if (file) {
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            const maxSize = 2 * 1024 * 1024; // 2MB

            if (!validTypes.includes(file.type) || file.size > maxSize) {
                errorEl.classList.remove('d-none');
                input.value = ''; // reset file
                return;
            }

            labelText.textContent = file.name;
            nameEl.textContent = `${(file.size / 1024).toFixed(1)} KB`;

            // Optional: preview
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').innerHTML = `
                <img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
            `;
            };
            reader.readAsDataURL(file);
        }
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const accessGroupCheckboxes = document.querySelectorAll('input[name="access_group[]"]');
        const noticeHidden = document.getElementById('notice');

        const hilight = document.querySelector('input[name="hilight"]');
        const displayDays = document.querySelector('select[name="display_days"]');
        const piority = document.querySelector('select[name="piority"]');
        const image = document.querySelector('input[name="image"]');

        function toggleNoticeBasedOnAccessGroup() {
            const isNotice = Array.from(accessGroupCheckboxes).some(cb => cb.checked);

            noticeHidden.value = isNotice ? '1' : '0';

            [hilight, displayDays, piority, image].forEach(field => {
                field.required = isNotice;
                if (isNotice) {
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });
        }

        accessGroupCheckboxes.forEach(cb => cb.addEventListener('change', toggleNoticeBasedOnAccessGroup));

        toggleNoticeBasedOnAccessGroup(); // เช็คตอนโหลดหน้า
    });
</script>

@endsection