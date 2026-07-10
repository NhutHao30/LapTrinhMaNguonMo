@extends('lab4.layout')
@section('title', 'Danh sách Sinh Viên (Bài 3, 7, 9, 11)')
@section('content')

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('lab4.bt4_add') }}" class="btn btn-success">+ Thêm Sinh Viên</a>

        <!-- Form tìm kiếm (BT09) -->
        <form method="get" action="{{ route('lab4.bt3') }}" class="d-flex">
            <input type="text" name="keyword" value="{{ $keyword }}" class="form-control me-2" placeholder="Nhập tên cần tìm (BT09)...">
            <!-- Giữ lại thông số sắp xếp -->
            <input type="hidden" name="sort" value="{{ $sort }}">
            <input type="hidden" name="dir" value="{{ $dir }}">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </form>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <!-- BT11: Sắp xếp theo tên hoặc email -->
                <th><a href="?sort=name&dir={{ $dir == 'asc' ? 'desc' : 'asc' }}&keyword={{ $keyword }}" class="text-white text-decoration-none">Họ tên ⇅</a></th>
                <th><a href="?sort=email&dir={{ $dir == 'asc' ? 'desc' : 'asc' }}&keyword={{ $keyword }}" class="text-white text-decoration-none">Email ⇅</a></th>
                <th>Số điện thoại</th>
                <th>Ngày sinh (BT08)</th>
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
                    <td>{{ $row->birthday }}</td>
                    <td>
                        <a href="{{ route('lab4.bt6_edit', $row->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                        <a href="{{ route('lab4.bt5', $row->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Xóa?')">Xóa</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Không có dữ liệu.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-4">
        {{ $students->appends(['keyword' => $keyword, 'sort' => $sort, 'dir' => $dir])->links('pagination::bootstrap-5') }}
    </div>
@endsection