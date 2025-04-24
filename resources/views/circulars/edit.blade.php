@extends('layouts.main')

@section('title', 'แก้ไขหนังสือแจ้งเวียน')

@section('content')

<style>
    /* green-theme.css */
    :root {
        --primary-color: #27ae60;
        /* สีเขียวหลัก */
        --secondary-color: #2ecc71;
        /* สีเขียวอ่อน */
        --success-color: #16a085;
        /* สีเขียวเทอร์ควอยซ์ */
        --danger-color: #e74c3c;
        /* สีแดง (คงเดิมสำหรับข้อผิดพลาด) */
        --warning-color: #f39c12;
        /* สีส้ม (คงเดิมสำหรับคำเตือน) */
        --light-color: #ecf0f1;
        /* สีพื้นหลังอ่อน */
        --dark-color: #2c3e50;
        /* สีเข้มสำหรับข้อความ */
        --white-color: #ffffff;
        /* สีขาว */
        --gray-color: #95a5a6;
        /* สีเทา */
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

    /* โครงสร้างหลัก */
    .container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 15px;
    }

    .form-card {
        background-color: var(--white-color);
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border-top: 4px solid var(--primary-color);
    }

    .form-header {
        padding: 1.5rem;
        background: linear-gradient(135deg, var(--primary-color), rgb(25, 61, 41));
        color: white;
    }


    .form-header h2 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .form-body {
        padding: 2rem;
        background-color: #f9f9f9;
    }

    /* ปุ่มและฟอร์ม elements */
    .btn {
        border-radius: 6px;
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-primary:hover {
        background-color: #219653;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-outline-secondary {
        border: 1px solid var(--gray-color);
        color: var(--gray-color);
        background: transparent;
    }

    .btn-outline-secondary:hover {
        background-color: var(--gray-color);
        color: white;
    }

    .btn-outline-danger {
        border: 1px solid var(--danger-color);
        color: var(--danger-color);
        background: transparent;
    }

    .btn-outline-danger:hover {
        background-color: var(--danger-color);
        color: white;
    }

    /* ฟอร์ม elements */
    .form-label {
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control,
    .form-select {
        border-radius: 6px;
        padding: 0.6rem 1rem;
        border: 1px solid #ddd;
        transition: all 0.3s;
        background-color: white;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 0.25rem rgba(46, 204, 113, 0.25);
        outline: none;
    }

    .select2-container--default .select2-selection--single {
        height: auto;
        padding: 0.6rem 1rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        background-color: white;
    }

    /* Alert messages */
    .alert {
        border-radius: 6px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid;
        background-color: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .alert-success {
        border-left-color: var(--success-color);
        color: var(--success-color);
        background-color: rgba(39, 174, 96, 0.1);
    }

    .alert-danger {
        border-left-color: var(--danger-color);
        color: var(--danger-color);
        background-color: rgba(231, 76, 60, 0.1);
    }

    /* การ์ดและกล่อง */
    .highlight-box {
        background-color: white;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border: 1px solid #e0e0e0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .file-input-wrapper {
        margin-bottom: 1rem;
    }

    .file-input-label {
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        transition: all 0.3s;
        background-color: white;
        border: 1px dashed var(--secondary-color);
        color: var(--secondary-color);
    }

    .file-input-label:hover {
        background-color: rgba(46, 204, 113, 0.1);
        border-style: solid;
    }

    /* รูปภาพ */
    .img-thumbnail {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 0.25rem;
        transition: transform 0.3s;
        background-color: white;
    }

    .img-thumbnail:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Modal */
    .modal-content {
        border-radius: 10px;
        overflow: hidden;
        border: none;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        padding: 1.25rem 1.5rem;
        background-color: var(--primary-color);
        color: white;
    }

    .modal-body {
        padding: 1.5rem;
        background-color: #f9f9f9;
    }

    .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid #eee;
        background-color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-header h2 {
            font-size: 1.5rem;
        }

        .form-body {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
            gap: 1rem;
        }

        .btn {
            width: 100%;
        }
    }

    /* Animation */
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

    .form-card {
        animation: fadeIn 0.5s ease-out;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: var(--primary-color);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #219653;
    }

    /* ไอคอนเพิ่มเติม */
    .fas {
        margin-right: 8px;
        color: var(--primary-color);
    }

    /* เอฟเฟกต์เมื่อ hover */
    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .input-group-text {
        background-color: var(--primary-color);
        color: white;
        border: none;
    }

    .form-label {
        font-size: 18px;
    }
</style>

<div class="container">
    <div class="form-card">
        <!-- Form Header -->
        <div class="form-header bg-primary text-white">
            <h2><i class="fas fa-edit me-2"></i> แก้ไขหนังสือแจ้งเวียน</h2>
        </div>

        <div class="form-body p-4">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <div>
                        <strong>พบข้อผิดพลาดในการกรอกข้อมูล</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form method="POST" action="{{ route('circulars.update', ['id' => $circular->book_id]) }}" enctype="multipart/form-data" id="circular-form">

                @csrf
                @method('PUT')

                @php
                use Carbon\Carbon;
                $thaiDate = Carbon::parse($circular->rec_date)->locale('th')->addYears(543)->translatedFormat('j F Y');
                @endphp

                <!-- วันที่ -->
                <div class="form-group mb-4">
                    <label for="thai_date" class="form-label fw-bold">
                        <i class="fas fa-calendar-alt me-2"></i>วันที่สร้าง
                    </label>
                    <input type="text" id="thai_date" class="form-control bg-light" value="{{ $thaiDate }}" readonly>
                    <input type="hidden" name="date" value="{{ $circular->rec_date }}">
                </div>

                <!-- หมวดหนังสือ -->
                <div class="form-group mb-4">
                    <label for="category" class="form-label fw-bold">
                        <i class="fas fa-tags me-2"></i>หมวดหนังสือ <span class="text-danger">*</span>
                    </label>
                    <select id="category" name="category" class="form-select select2">
                        <option value="">-- กรุณาเลือกหมวดหนังสือ --</option>
                        @foreach ($booktypes->groupBy('booktype') as $key => $group)
                        <option value="{{ $key }}" {{ $circular->booktype == $key ? 'selected' : '' }}>
                            {{ $key }} - {{ $group->first()->booktype_desc }}
                        </option>
                        @endforeach
                    </select>
                </div>


                <!-- เรื่อง -->
                <div class="form-group mb-4">
                    <label for="topic" class="form-label fw-bold">
                        <i class="fas fa-heading me-2"></i>เรื่อง <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="topic" id="topic" class="form-control"
                        value="{{ old('topic', $circular->topic) }}">
                </div>

                <!-- หน่วยงาน -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="unit_id" class="form-label fw-bold">
                                <i class="fas fa-university me-2"></i>หน่วยงานภายใน
                            </label>
                            <select id="unit_id" name="unit_id" class="form-select select2" data-placeholder="เลือกหน่วยงานภายใน">
                                <option value=""></option> {{-- สำหรับ Allow Clear --}}
                                @foreach ($departments as $id => $name)
                                <option value="{{ $id }}" {{ $circular->unit_id == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="book_name" class="form-label fw-bold">
                                <i class="fas fa-external-link-alt me-2"></i>หน่วยงานภายนอก
                            </label>
                            <input type="text" id="book_name" name="book_name" class="form-control"
                                value="{{ old('book_name', $circular->unit_out_name) }}"
                                placeholder="กรอกชื่อหน่วยงานภายนอก (ถ้ามี)">
                        </div>
                    </div>
                </div>

                <!-- จำนวนหน้า -->
                <div class="form-group mb-4">
                    <label for="page_no" class="form-label fw-bold">
                        <i class="fas fa-file-alt me-2"></i>จำนวนหน้า
                    </label>
                    <input type="number" id="page_no" name="page_no" class="form-control"
                        value="{{ old('page_no', $circular->page_no) }}" min="1"
                        placeholder="ระบุจำนวนหน้า">
                </div>

                <!-- PDF -->
                <!-- PDF -->
                <div class="form-group mb-4">
                    <label for="pdf_file" class="form-label fw-bold">
                        <i class="fas fa-file-pdf me-2"></i>ไฟล์ PDF
                    </label>

                    <div class="file-input-wrapper">
                        <label class="file-input-label">
                            <span id="file-label-text">
                                {{ $circular->file_name ? 'เปลี่ยนไฟล์ PDF' : 'เลือกไฟล์ PDF' }}
                            </span>
                            <i class="fas fa-upload"></i>
                            <input
                                type="file"
                                id="pdf_file"
                                name="pdf_file"
                                class="form-control"
                                accept=".pdf"
                                onchange="updateFileName(this)">
                        </label>
                        <div id="file-name" class="file-name text-success mt-2">
                            @if ($circular->file_name)
                            📄 ไฟล์เดิม: <strong>{{ $circular->file_name }}</strong>
                            @endif
                        </div>
                    </div>

                    @if (!empty($circular->file_name))
                    <div class="mt-2">
                        <a href="{{ route('circulars.openPdf', ['id' => $circular->book_id]) }}"
                            target="_blank"
                            class="btn btn-outline-success btn-sm">
                            <i class="fas fa-file-pdf"></i> ดูไฟล์ PDF ที่แนบไว้
                        </a>
                    </div>
                    @endif

                    <small class="form-text text-danger d-block mt-2">
                        รองรับเฉพาะไฟล์ PDF และขนาดไม่เกิน 6MB หากเกินระบบจะไม่ยอมให้แนบ
                    </small>
                </div>


                <!-- hilight -->
                <div class="form-group mb-4">
                    <label for="hilight" class="form-label fw-bold">
                        <i class="fas fa-highlighter me-2"></i>ข้อความไฮไลท์
                    </label>
                    <input type="text" id="hilight" name="hilight" class="form-control"
                        value="{{ old('hilight', $circular->hilight) }}"
                        placeholder="ข้อความที่จะแสดงเป็นไฮไลท์">
                </div>

                <!-- priority -->
                <div class="form-group mb-4">
                    <label for="piority" class="form-label fw-bold">
                        <i class="fas fa-exclamation-circle me-2"></i>ระดับความสำคัญ
                    </label>
                    <select name="piority" id="piority" class="form-select">
                        @for ($i = 0; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('piority', $circular->piority) == $i ? 'selected' : '' }}>
                            {{ $i }} - {{ $i == 0 ? 'ปกติ' : ($i == 5 ? 'สำคัญมาก' : 'สำคัญระดับ '.$i) }}
                            </option>
                            @endfor
                    </select>
                </div>

                <!-- display_days -->
                <div class="form-group mb-4">
                    <label for="display_days" class="form-label fw-bold">
                        <i class="fas fa-calendar-day me-2"></i>จำนวนวันที่แสดง
                    </label>
                    <select name="display_days" id="display_days" class="form-select">
                        <option value="0" {{ old('display_days', $circular->day_show) == 0 ? 'selected' : '' }}>
                            0 วัน (ไม่แสดง)
                        </option>
                        @for ($i = 1; $i <= 100; $i++)
                            <option value="{{ $i }}" {{ old('display_days', $circular->day_show) == $i ? 'selected' : '' }}>
                            {{ $i }} วัน
                            </option>
                            @endfor
                    </select>
                </div>

                <!-- รูปภาพ -->
                <div class="form-group mb-4">
                    <label for="pic_upload" class="form-label fw-bold">
                        <i class="fas fa-image me-2"></i>รูปภาพประกอบ
                    </label>
                    <div class="file-input-wrapper mb-2">
                        <div class="input-group">
                            <label class="input-group-text bg-primary text-white cursor-pointer" for="pic_upload">
                                <i class="fas fa-upload me-2"></i>อัพโหลด
                            </label>
                            <input type="file" name="pic_upload" id="pic_upload"
                                class="form-control d-none"
                                accept="image/jpeg,image/jpg,image/png"
                                onchange="updateImageName(this)">
                            <input type="text" id="image-filename" class="form-control"
                                placeholder="เลือกรูปภาพใหม่ (ถ้ามี)" readonly>
                        </div>
                    </div>

                    <!-- แสดงภาพที่มีอยู่ -->
                    @php
                    $decodedImage = base64_decode($circular->pic_upload);
                    $mime = $decodedImage ? (new finfo(FILEINFO_MIME_TYPE))->buffer($decodedImage) : null;
                    @endphp

                    @if ($decodedImage && str_starts_with($mime, 'image/'))
                    <div class="mt-3">
                        <p class="mb-2 fw-bold">ภาพปัจจุบัน:</p>
                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ route('circulars.viewImage', ['id' => $circular->book_id]) }}">
                                <img src="data:{{ $mime }};base64,{{ $circular->pic_upload }}"
                                    alt="ภาพประกอบ"
                                    class="img-thumbnail"
                                    style="max-width: 200px;">
                            </a>
                        </div>
                    </div>
                    @endif

                    <small class="form-text text-muted">
                        รองรับเฉพาะไฟล์ JPG, JPEG, PNG และต้องไม่เกิน 2MB
                    </small>
                </div>


                <!-- ปุ่ม -->
                <div class="form-actions d-flex justify-content-between mt-5">
                    <a href="{{ route('circulars.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>ย้อนกลับ
                    </a>
                    <div class="d-flex gap-2">
                        <button type="reset" class="btn btn-outline-danger" onclick="resetForm()">
                            <i class="fas fa-undo me-2"></i>ล้างค่า
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>บันทึกการแก้ไข
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('scripts')

@section('scripts')
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select2 init
        $('#unit_id').select2({
            theme: 'bootstrap-5',
            placeholder: $('#unit_id').data('placeholder') || 'เลือกข้อมูล',
            allowClear: true,
            width: '100%'
        });

        const unitSelect = $('#unit_id');
        const externalAgencyInput = document.getElementById('book_name');

        function toggleAgencyFields() {
            const hasUnit = unitSelect.val()?.trim() !== '';
            const hasExternal = externalAgencyInput?.value.trim() !== '';

            externalAgencyInput.disabled = hasUnit;
            if (hasUnit) externalAgencyInput.value = '';

            unitSelect.prop('disabled', hasExternal);
            if (hasExternal) unitSelect.val(null).trigger('change');
        }

        toggleAgencyFields();
        unitSelect.on('change', toggleAgencyFields);
        externalAgencyInput.addEventListener('input', toggleAgencyFields);

        // แสดง/ซ่อนส่วนอัปโหลดภาพ
        function toggleImageUpload() {
            const checkbox = document.getElementById('show-on-web');
            const imageGroup = document.getElementById('image-upload-group');
            imageGroup.style.display = checkbox.checked ? 'block' : 'none';
        }

        document.getElementById('show-on-web').addEventListener('change', toggleImageUpload);
        toggleImageUpload();

        // แสดงชื่อไฟล์รูป
        window.updateImageName = function(input) {
            const fileName = input.files[0]?.name || 'เลือกรูปภาพ';
            document.getElementById('image-filename').value = fileName;
        }

        // ตรวจสอบขนาดไฟล์รูป
        document.getElementById('pic_upload')?.addEventListener('change', function() {
            const file = this.files[0];
            if (file && file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'ขนาดรูปใหญ่เกินไป!',
                    html: `<strong>ขนาดของคุณคือ ${(file.size / (1024 * 1024)).toFixed(2)} MB</strong><br>ระบบรองรับไม่เกิน <b>2MB</b>`,
                    confirmButtonText: 'ตกลง',
                    confirmButtonColor: '#e11d48',
                });
                this.value = '';
                document.getElementById('image-filename').value = '';
            }
        });

        // Dynamic Enable/Disable Fields
        const newsType = document.querySelector('input[name="news_type[]"][value="ทั่วไป"]');
        const hilight = document.getElementById('hilight');
        const displayDays = document.getElementById('display_days');
        const piority = document.getElementById('piority');

        function toggleRequiredFields() {
            const required = newsType.checked;
            [hilight, displayDays, piority].forEach(input => {
                input.required = required;
                input.classList.toggle('is-invalid', required);
            });
        }

        newsType.addEventListener('change', toggleRequiredFields);
        toggleRequiredFields();

        // ปุ่ม Reset Form + Alert
        document.querySelector('button[type="reset"]')?.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'ยืนยันการล้างข้อมูล?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonText: 'ยกเลิก',
                confirmButtonText: 'ล้างข้อมูล'
            }).then(result => {
                if (result.isConfirmed) {
                    document.getElementById('circular-form').reset();
                    $('#unit_id').val(null).trigger('change');
                    document.getElementById('image-filename').value = '';
                    Swal.fire('ล้างข้อมูลแล้ว!', '', 'success');
                }
            });
        });
    });
</script>
<script>
    function updateFileName(input) {
        const file = input.files[0];
        const fileNameDiv = document.getElementById('file-name');
        const labelText = document.getElementById('file-label-text');

        if (file) {
            const fileSizeMB = file.size / (1024 * 1024);
            if (file.type !== "application/pdf") {
                fileNameDiv.innerHTML = '<span class="text-danger">❌ กรุณาเลือกไฟล์ PDF เท่านั้น</span>';
                input.value = ""; // เคลียร์ไฟล์
                return;
            }
            if (fileSizeMB > 6) {
                fileNameDiv.innerHTML = '<span class="text-danger">❌ ขนาดไฟล์เกิน 6MB</span>';
                input.value = ""; // เคลียร์ไฟล์
                return;
            }

            fileNameDiv.innerHTML = `📄 ไฟล์ที่เลือก: <strong>${file.name}</strong> (${fileSizeMB.toFixed(2)} MB)`;
            labelText.innerText = "เปลี่ยนไฟล์ PDF";
        } else {
            fileNameDiv.innerHTML = "";
            labelText.innerText = "เลือกไฟล์ PDF";
        }
    }
</script>
@endsection


@endsection