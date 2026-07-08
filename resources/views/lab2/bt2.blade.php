@extends('lab2.layout')
@section('title', 'Bài tập 2: Class Student')
@section('content')
    <p><strong>Thông tin Sinh viên:</strong> {{ $student->getInfo() }}</p>
    <p class="text-muted mt-3"><i>Lưu ý: Đối tượng sẽ được tự động giải phóng (destructor) khi PHP kết thúc request.</i></p>
@endsection
