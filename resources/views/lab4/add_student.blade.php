@extends('lab4.layout')
@section('title', 'Thêm Sinh Viên Mới')
@section('content')
    <form method="post" action="{{ route('lab4.bt4_store') }}" class="w-50 mx-auto">
        @csrf
        <div class="mb-3"><label class="form-label fw-bold">Họ tên:</label><input type="text" name="name" class="form-control" required value="{{ old('name') }}"></div>
        <div class="mb-3"><label class="form-label fw-bold">Email:</label><input type="email" name="email" class="form-control" required value="{{ old('email') }}"></div>
        <div class="mb-3"><label class="form-label fw-bold">Số điện thoại:</label><input type="text" name="phone" class="form-control" value="{{ old('phone') }}"></div>
        <div class="mb-3"><label class="form-label fw-bold">Ngày sinh (BT08):</label><input type="date" name="birthday" class="form-control" value="{{ old('birthday') }}"></div>
        <button type="submit" class="btn btn-success w-100">Lưu Thông Tin</button>
    </form>
@endsection