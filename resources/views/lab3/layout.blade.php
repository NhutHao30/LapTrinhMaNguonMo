<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lab 3 - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card { border-radius: 10px; overflow: hidden; }
        .card-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    </style>
</head>
<body class="container mt-5 mb-5">
    <nav class="mb-4 d-flex justify-content-between">
        <a href="{{ route('lab3.index') }}" class="btn btn-secondary">🏠 Quay lại danh sách Lab 3</a>
        <a href="/lab2" class="btn btn-outline-secondary">Chuyển sang Lab 2</a>
    </nav>
    <div class="card shadow">
        <div class="card-header text-white">
            <h4 class="m-0">@yield('title')</h4>
        </div>
        <div class="card-body">
            @yield('content')
        </div>
    </div>
</body>
</html>