@extends('lab2.layout')
@section('title', 'Bài tập 4: Abstract class & Interface')
@section('content')
    <ul>
        <li><strong>Chó:</strong> {{ $dog->makeSound() }} - {{ $dog->run() }}</li>
        <li><strong>Mèo:</strong> {{ $cat->makeSound() }}</li>
    </ul>
@endsection
