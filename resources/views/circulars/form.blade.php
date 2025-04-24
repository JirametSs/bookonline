@php $isEdit = isset($circular); @endphp

<form method="POST" action="{{ $isEdit ? route('circulars.update', $circular->id) : route('circulars.store') }}"
    enctype="multipart/form-data">
    @csrf
    @if($isEdit)
    @method('PUT')
    @endif

    <!-- เรื่อง -->
    <div class="form-group">
        <label for="title">เรื่อง</label>
        <input type="text" name="title" id="title" class="form-control"
            value="{{ old('title', $isEdit ? $circular->title : '') }}" required>
    </div>

    <!-- หมวด -->
    <div class="form-group">
        <label for="category">หมวด</label>
        <select name="category" id="category" class="form-select" required>
            <option value="">--- กรุณาเลือกหมวด ---</option>
            @foreach ($booktypes->groupBy('booktype') as $key => $group)
            <option value="{{ $key }}"
                {{ old('category', $isEdit ? $circular->category : '') == $key ? 'selected' : '' }}>
                {{ $key }} - {{ $group->first()->booktype_desc }}
            </option>
            @endforeach
        </select>
    </div>

    <!-- หน่วยงาน -->
    <div class="form-group">
        <label for="department">หน่วยงาน</label>
        <select name="department" id="department" class="form-select" required>
            <option value="">--- กรุณาเลือกหน่วยงาน ---</option>
            @foreach ($departments as $id => $name)
            <option value="{{ $id }}"
                {{ old('department', $isEdit ? $circular->department : '') == $id ? 'selected' : '' }}>
                {{ $name }}
            </option>
            @endforeach
        </select>
    </div>

    <!-- วันที่ -->
    <div class="form-group">
        <label for="date">วันที่</label>
        <input type="date" name="date" id="date" class="form-control"
            value="{{ old('date', $isEdit ? $circular->date : now()->format('Y-m-d')) }}">
    </div>

    <!-- จำนวนหน้า -->
    <div class="form-group">
        <label for="pages">จำนวนหน้า</label>
        <input type="number" name="pages" id="pages" class="form-control"
            value="{{ old('pages', $isEdit ? $circular->pages : 1) }}">
    </div>

    <!-- แนบ PDF -->
    <div class="form-group">
        <label for="pdf_file">แนบ PDF</label>
        <input type="file" name="pdf_file" id="pdf_file" class="form-control" accept="application/pdf">
        @if ($isEdit && $circular->pdf_path)
        <small class="text-muted">ไฟล์ปัจจุบัน: {{ basename($circular->pdf_path) }}</small>
        @endif
    </div>

    <!-- ปุ่ม -->
    <div class="form-group mt-3">
        <button type="submit" class="btn btn-primary">
            {{ $isEdit ? 'อัปเดต' : 'บันทึก' }}
        </button>
        <a href="{{ route('circulars.index') }}" class="btn btn-secondary">ย้อนกลับ</a>
    </div>
</form>