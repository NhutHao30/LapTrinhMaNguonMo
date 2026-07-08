@extends('lab2.layout')
@section('title', 'Bài tập 7: Quản lý thư viện')
@section('content')
    <p><strong>Sách thường:</strong> {{ $book->getInfo() }}</p>
    <p><strong>Sách điện tử (Ebook):</strong> {{ $ebook->getInfo() }}</p>
    <div class="alert alert-success">
        Hành động: {{ $ebook->download() }}
    </div>
@endsection
