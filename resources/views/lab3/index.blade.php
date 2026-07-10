@extends('lab3.layout')
@section('title', 'Danh sách Bài tập Lab 3 (JS & AJAX)')
@section('content')
    <div class="list-group mb-4">
        <a href="{{ route('lab3.bt1') }}" class="list-group-item list-group-item-action">Bài tập 1: JavaScript cơ bản</a>
        <a href="{{ route('lab3.bt2') }}" class="list-group-item list-group-item-action">Bài tập 2: DOM Manipulation</a>
        <a href="{{ route('lab3.bt3') }}" class="list-group-item list-group-item-action">Bài tập 3: Event Handling</a>
        <a href="{{ route('lab3.bt4') }}" class="list-group-item list-group-item-action">Bài tập 4: AJAX cơ bản (Time)</a>
        <a href="{{ route('lab3.bt5') }}" class="list-group-item list-group-item-action">Bài tập 5: AJAX POST (Hello)</a>
        <a href="{{ route('lab3.bt6') }}" class="list-group-item list-group-item-action">Bài tập 6: Lấy danh sách sản phẩm (JSON)</a>
        <a href="{{ route('lab3.bt7') }}" class="list-group-item list-group-item-action">Bài tập 7: Tìm kiếm sản phẩm</a>
        <a href="{{ route('lab3.bt8') }}" class="list-group-item list-group-item-action">Bài tập 8: Ứng dụng Chat đơn giản</a>
        <a href="{{ route('lab3.bt9') }}" class="list-group-item list-group-item-action">Bài tập 9: Ứng dụng Dự báo thời tiết</a>
    </div>

    <h5 class="text-danger border-bottom pb-2">Bài Tập Ôn Luyện</h5>
    <div class="list-group">
        <a href="{{ route('lab3.bt10') }}" class="list-group-item list-group-item-action list-group-item-warning">Bài tập 10: Ứng dụng To-do list (JSON)</a>
        <a href="{{ route('lab3.bt11') }}" class="list-group-item list-group-item-action list-group-item-warning">Bài tập 11: Tỷ giá ngoại tệ (Real API)</a>
        <a href="{{ route('lab3.bt12') }}" class="list-group-item list-group-item-action list-group-item-warning">Bài tập 12: Form đăng ký (JS + Database)</a>
    </div>
@endsection