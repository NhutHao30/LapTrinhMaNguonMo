@extends('lab2.layout')
@section('title', 'Bài tập 8: Quản lý sinh viên')
@section('content')
    <p><strong>Sinh viên:</strong> {{ $student->getInfo() }}</p>
@endsection
