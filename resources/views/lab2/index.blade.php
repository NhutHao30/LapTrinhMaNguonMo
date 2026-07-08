@extends('lab2.layout')
@section('title', 'Danh sách Bài tập Lab 2')
@section('content')
    <div class="list-group">
        <a href="{{ route('lab2.bt1') }}" class="list-group-item list-group-item-action">Bài tập 1: Class Car</a>
        <a href="{{ route('lab2.bt2') }}" class="list-group-item list-group-item-action">Bài tập 2: Class Student</a>
        <a href="{{ route('lab2.bt3') }}" class="list-group-item list-group-item-action">Bài tập 3: Static và kế thừa</a>
        <a href="{{ route('lab2.bt4') }}" class="list-group-item list-group-item-action">Bài tập 4: Abstract class & Interface</a>
        <a href="{{ route('lab2.bt5') }}" class="list-group-item list-group-item-action">Bài tập 5: Namespace và Autoloading</a>
        <a href="{{ route('lab2.bt6') }}" class="list-group-item list-group-item-action">Bài tập 6: BankAccount</a>
        <a href="{{ route('lab2.bt7') }}" class="list-group-item list-group-item-action">Bài tập 7: Quản lý thư viện</a>
        <a href="{{ route('lab2.bt8') }}" class="list-group-item list-group-item-action">Bài tập 8: Quản lý sinh viên</a>
    </div>
@endsection
