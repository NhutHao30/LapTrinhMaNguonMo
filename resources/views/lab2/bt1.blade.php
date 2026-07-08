@extends('lab2.layout')
@section('title', 'Bài tập 1: Class Car')
@section('content')
    <p><strong>Xe 1:</strong> {{ $car1->getInfo() }}</p>
    <p><strong>Xe 2:</strong> {{ $car2->getInfo() }}</p>
@endsection
