<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lab 2 - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <nav class="mb-4">
        <a href="{{ route('lab2.index') }}" class="btn btn-secondary">Quay lại danh sách Lab 2</a>
    </nav>
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>@yield('title')</h4>
        </div>
        <div class="card-body">
            @yield('content')
        </div>
    </div>
</body>
</html>
