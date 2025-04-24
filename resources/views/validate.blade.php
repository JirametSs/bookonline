@extends('layouts.main')

@section('title', 'กำหนดสิทธิ์')

@section('content')
<div class="container py-5">
    <div class="card">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">กำหนดสิทธิ์</h4>
        </div>
        <div class="card-body">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('validate.update') }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light text-center">
                            <tr>
                                <th>เลขประจำตัวประชาชน (idx)</th>
                                <th>ชื่อ</th>
                                <th>นามสกุล</th>
                                <th>หน่วยงาน</th>
                                <th>สิทธิ์</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $employee->idx }}</td>
                                <td>{{ $employee->fname }}</td>
                                <td>{{ $employee->lname }}</td>
                                <td>{{ $employee->T_Worku_name }}</td>
                                <td>
                                    <select name="permissions[{{ $employee->idx }}]" class="form-select">
                                        <option value="0" {{ !$employee->is_admin ? 'selected' : '' }}>User</option>
                                        <option value="1" {{ $employee->is_admin ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> บันทึกการเปลี่ยนแปลง
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
