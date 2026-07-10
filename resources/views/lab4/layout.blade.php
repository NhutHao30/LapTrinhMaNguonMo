<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lab 4 - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5 mb-5">
    
    <!-- Navigation Menu -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 rounded">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('lab4.bt3') }}">LAB 4 (DB)</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('lab4.bt3') }}">Danh sách SV</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="{{ route('lab4.bt2') }}">Chạy Setup DB</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-info" href="{{ route('lab4.bt1') }}">Test Kết nối</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="/lab2" class="btn btn-outline-light btn-sm me-2">Về Lab 2</a>
                    <a href="/lab3" class="btn btn-outline-light btn-sm">Về Lab 3</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hiển thị thông báo (Thành công / Lỗi) -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Nội dung trang -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="m-0">@yield('title')</h4>
        </div>
        <div class="card-body">
            @yield('content')
        </div>
    </div>
</body>
</html>