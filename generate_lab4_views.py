import os

# Append routes to web.php
routes_content = '''

// --- LAB 4: TƯƠNG TÁC CƠ SỞ DỮ LIỆU MYSQL / PDO ---
use App\Http\Controllers\Lab4Controller;
Route::prefix('lab4')->group(function () {
    Route::get('/connect', [Lab4Controller::class, 'bt1_connect'])->name('lab4.bt1');
    Route::get('/setup', [Lab4Controller::class, 'bt2_setup'])->name('lab4.bt2');
    
    Route::get('/students', [Lab4Controller::class, 'bt3_list'])->name('lab4.bt3'); // Danh sách (BT3 + BT7)
    
    Route::get('/students/add', [Lab4Controller::class, 'bt4_add'])->name('lab4.bt4_add'); // Form thêm
    Route::post('/students/add', [Lab4Controller::class, 'bt4_store'])->name('lab4.bt4_store'); // Xử lý thêm
    
    Route::get('/students/delete/{id}', [Lab4Controller::class, 'bt5_delete'])->name('lab4.bt5'); // Xóa
    
    Route::get('/students/edit/{id}', [Lab4Controller::class, 'bt6_edit'])->name('lab4.bt6_edit'); // Form sửa
    Route::post('/students/edit/{id}', [Lab4Controller::class, 'bt6_update'])->name('lab4.bt6_update'); // Xử lý sửa
});
'''

with open(r'd:\IT\HocKy_7\LapTrinhMaNguonMo\Buoi2_080726\buoi2\routes\web.php', 'a', encoding='utf-8') as f:
    f.write(routes_content)

# Create Views
base_dir = r'd:\IT\HocKy_7\LapTrinhMaNguonMo\Buoi2_080726\buoi2\resources\views\lab4'
os.makedirs(base_dir, exist_ok=True)

layout = '''<!DOCTYPE html>
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
                        <a class="nav-link" href="{{ route('lab4.bt3') }}">Danh sách SV (BT3+BT7)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="{{ route('lab4.bt2') }}">Chạy Setup DB (BT2)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-info" href="{{ route('lab4.bt1') }}">Test Kết nối (BT1)</a>
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
</html>'''

list_students = '''@extends('lab4.layout')
@section('title', 'Danh sách Sinh Viên (Bài tập 3 & 7)')
@section('content')

    <div class="d-flex justify-content-between mb-3">
        <!-- Nút Thêm Mới -->
        <a href="{{ route('lab4.bt4_add') }}" class="btn btn-success">+ Thêm Sinh Viên</a>

        <!-- Form tìm kiếm (BT7) -->
        <form method="get" action="{{ route('lab4.bt3') }}" class="d-flex">
            <input type="text" name="keyword" value="{{ $keyword }}" class="form-control me-2" placeholder="Nhập tên cần tìm...">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </form>
    </div>

    <!-- Bảng dữ liệu (BT3) -->
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $row)
                <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->phone }}</td>
                    <td>
                        <!-- Nút Sửa (BT6) -->
                        <a href="{{ route('lab4.bt6_edit', $row->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                        <!-- Nút Xóa (BT5) -->
                        <a href="{{ route('lab4.bt5', $row->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Không có dữ liệu sinh viên. Hãy bấm "Chạy Setup DB" ở trên thanh menu.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Hiển thị thanh Phân trang của Laravel (BT7) -->
    <div class="d-flex justify-content-center mt-4">
        {{ $students->appends(['keyword' => $keyword])->links('pagination::bootstrap-5') }}
    </div>

@endsection'''

add_student = '''@extends('lab4.layout')
@section('title', 'Thêm Sinh Viên Mới (Bài tập 4)')
@section('content')

    <!-- Form sử dụng POST để gửi dữ liệu lên server -->
    <form method="post" action="{{ route('lab4.bt4_store') }}" class="w-50 mx-auto">
        <!-- CỰC KỲ QUAN TRỌNG TRONG LARAVEL: Thẻ @csrf bảo vệ khỏi tấn công CSRF -->
        @csrf

        <div class="mb-3">
            <label class="form-label fw-bold">Họ tên:</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Email:</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Số điện thoại:</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>

        <button type="submit" class="btn btn-success w-100">Lưu Thông Tin</button>
    </form>

@endsection'''

edit_student = '''@extends('lab4.layout')
@section('title', 'Cập nhật Sinh Viên (Bài tập 6)')
@section('content')

    <form method="post" action="{{ route('lab4.bt6_update', $student->id) }}" class="w-50 mx-auto">
        @csrf
        
        <div class="mb-3">
            <label class="form-label fw-bold">Họ tên:</label>
            <!-- Lấy dữ liệu cũ đổ vào ô input (thông qua $student->name) -->
            <input type="text" name="name" class="form-control" required value="{{ old('name', $student->name) }}">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Email:</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email', $student->email) }}">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Số điện thoại:</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $student->phone) }}">
        </div>

        <button type="submit" class="btn btn-warning w-100">Cập Nhật</button>
    </form>

@endsection'''

files = {
    'layout.blade.php': layout,
    'list_students.blade.php': list_students,
    'add_student.blade.php': add_student,
    'edit_student.blade.php': edit_student,
}

for name, content in files.items():
    with open(os.path.join(base_dir, name), 'w', encoding='utf-8') as f:
        f.write(content)

print('Lab 4 completed successfully!')
