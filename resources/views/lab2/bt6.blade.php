@extends('lab2.layout')
@section('title', 'Bài tập 6: BankAccount')
@section('content')
    <div class="mb-3">
        <strong>Thông tin ban đầu:</strong> {{ $initialInfo }}
    </div>
    
    <h5>Lịch sử giao dịch:</h5>
    <ul>
        @foreach($logs as $log)
            <li>{{ $log }}</li>
        @endforeach
    </ul>

    <div class="mt-3 alert alert-success">
        <strong>Thông tin cuối:</strong> {{ $finalInfo }}
    </div>
@endsection
