import os

# --- 1. UPDATE LAB 4 CONTROLLER ---
lab4_controller = '''<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Lab4Controller extends Controller
{
    public function bt1_connect() {
        try {
            $pdo = DB::connection()->getPdo();
            return "Kết nối CSDL thành công! Cơ sở dữ liệu hiện tại là: " . DB::connection()->getDatabaseName();
        } catch (\Exception $e) {
            return "Kết nối thất bại: " . $e->getMessage();
        }
    }

    public function bt2_setup() {
        try {
            // BT08: Thêm cột birthday
            DB::statement("
                CREATE TABLE IF NOT EXISTS students (
                    id INT AUTO_INCREMENT PRIMARY KEY, 
                    name VARCHAR(100) NOT NULL,
                    email VARCHAR(100) UNIQUE,
                    phone VARCHAR(20),
                    birthday DATE NULL
                )
            ");
            DB::statement("DELETE FROM students");

            // BT10: Chuyển toàn bộ các truy vấn sang Prepared Statement (Laravel DB::insert đã sử dụng Prepared Statement ngầm định)
            // PDO: $stmt = $pdo->prepare("INSERT INTO ..."); $stmt->execute([...]);
            DB::insert("INSERT INTO students (name, email, phone, birthday) VALUES (?, ?, ?, ?)", ['Nguyen Van A', 'a@example.com', '0123456789', '2000-01-01']);
            DB::insert("INSERT INTO students (name, email, phone, birthday) VALUES (?, ?, ?, ?)", ['Tran Thi B', 'b@example.com', '0987654321', '2001-02-02']);
            DB::insert("INSERT INTO students (name, email, phone, birthday) VALUES (?, ?, ?, ?)", ['Le Van C', 'c@example.com', '0911111111', '2002-03-03']);

            return redirect()->route('lab4.bt3')->with('success', 'Tạo bảng và dữ liệu mẫu thành công (Đã thêm cột birthday)!');
        } catch (\Exception $e) {
            return "Có lỗi xảy ra: " . $e->getMessage();
        }
    }

    public function bt3_list(Request $request) {
        // BT09: Tìm kiếm sinh viên theo tên
        $keyword = $request->query('keyword', '');
        
        // BT11: Thêm tính năng sắp xếp danh sách theo tên hoặc email.
        $sort = $request->query('sort', 'id'); // Cột cần sắp xếp
        $dir = $request->query('dir', 'desc'); // Chiều sắp xếp (asc/desc)

        $students = DB::table('students')
            ->where('name', 'LIKE', "%{$keyword}%")
            ->orderBy($sort, $dir)
            ->paginate(5);

        return view('lab4.list_students', compact('students', 'keyword', 'sort', 'dir'));
    }

    public function bt4_add() { return view('lab4.add_student'); }

    public function bt4_store(Request $request) {
        $request->validate(['name' => 'required', 'email' => 'required|email|unique:students,email']);
        DB::insert("INSERT INTO students (name, email, phone, birthday) VALUES (?, ?, ?, ?)", [
            $request->name, $request->email, $request->phone, $request->birthday
        ]);
        return redirect()->route('lab4.bt3')->with('success', 'Thêm sinh viên thành công!');
    }

    public function bt5_delete($id) {
        DB::delete("DELETE FROM students WHERE id = ?", [$id]);
        return redirect()->route('lab4.bt3')->with('success', 'Xóa sinh viên thành công!');
    }

    public function bt6_edit($id) {
        $student = DB::selectOne("SELECT * FROM students WHERE id = ?", [$id]);
        if (!$student) return redirect()->route('lab4.bt3')->with('error', 'Không tìm thấy sinh viên!');
        return view('lab4.edit_student', compact('student'));
    }

    public function bt6_update(Request $request, $id) {
        $request->validate(['name' => 'required', 'email' => 'required|email']);
        DB::update("UPDATE students SET name = ?, email = ?, phone = ?, birthday = ? WHERE id = ?", [
            $request->name, $request->email, $request->phone, $request->birthday, $id
        ]);
        return redirect()->route('lab4.bt3')->with('success', 'Cập nhật thông tin thành công!');
    }
}
'''

with open(r'd:\IT\HocKy_7\LapTrinhMaNguonMo\Buoi2_080726\buoi2\app\Http\Controllers\Lab4Controller.php', 'w', encoding='utf-8') as f:
    f.write(lab4_controller)


# --- 2. UPDATE LAB 4 VIEWS ---
list_students = '''@extends('lab4.layout')
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
@endsection'''

add_student = '''@extends('lab4.layout')
@section('title', 'Thêm Sinh Viên Mới')
@section('content')
    <form method="post" action="{{ route('lab4.bt4_store') }}" class="w-50 mx-auto">
        @csrf
        <div class="mb-3"><label class="form-label fw-bold">Họ tên:</label><input type="text" name="name" class="form-control" required value="{{ old('name') }}"></div>
        <div class="mb-3"><label class="form-label fw-bold">Email:</label><input type="email" name="email" class="form-control" required value="{{ old('email') }}"></div>
        <div class="mb-3"><label class="form-label fw-bold">Số điện thoại:</label><input type="text" name="phone" class="form-control" value="{{ old('phone') }}"></div>
        <div class="mb-3"><label class="form-label fw-bold">Ngày sinh (BT08):</label><input type="date" name="birthday" class="form-control" value="{{ old('birthday') }}"></div>
        <button type="submit" class="btn btn-success w-100">Lưu Thông Tin</button>
    </form>
@endsection'''

edit_student = '''@extends('lab4.layout')
@section('title', 'Cập nhật Sinh Viên')
@section('content')
    <form method="post" action="{{ route('lab4.bt6_update', $student->id) }}" class="w-50 mx-auto">
        @csrf
        <div class="mb-3"><label class="form-label fw-bold">Họ tên:</label><input type="text" name="name" class="form-control" required value="{{ old('name', $student->name) }}"></div>
        <div class="mb-3"><label class="form-label fw-bold">Email:</label><input type="email" name="email" class="form-control" required value="{{ old('email', $student->email) }}"></div>
        <div class="mb-3"><label class="form-label fw-bold">Số điện thoại:</label><input type="text" name="phone" class="form-control" value="{{ old('phone', $student->phone) }}"></div>
        <div class="mb-3"><label class="form-label fw-bold">Ngày sinh (BT08):</label><input type="date" name="birthday" class="form-control" value="{{ old('birthday', $student->birthday) }}"></div>
        <button type="submit" class="btn btn-warning w-100">Cập Nhật</button>
    </form>
@endsection'''

base_dir_4 = r'd:\IT\HocKy_7\LapTrinhMaNguonMo\Buoi2_080726\buoi2\resources\views\lab4'
with open(os.path.join(base_dir_4, 'list_students.blade.php'), 'w', encoding='utf-8') as f: f.write(list_students)
with open(os.path.join(base_dir_4, 'add_student.blade.php'), 'w', encoding='utf-8') as f: f.write(add_student)
with open(os.path.join(base_dir_4, 'edit_student.blade.php'), 'w', encoding='utf-8') as f: f.write(edit_student)

# --- 3. LAB 5 CONTROLLER ---
lab5_controller = '''<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class Lab5Controller extends Controller
{
    public function setup() {
        try {
            DB::statement("DROP TABLE IF EXISTS order_details");
            DB::statement("DROP TABLE IF EXISTS orders");
            DB::statement("DROP TABLE IF EXISTS customers");
            DB::statement("DROP TABLE IF EXISTS products");
            DB::statement("DROP TABLE IF EXISTS categories");

            // Tạo các bảng cho Lab 5
            DB::statement("CREATE TABLE categories (category_id INT AUTO_INCREMENT PRIMARY KEY, category_name VARCHAR(100) NOT NULL)");
            DB::statement("CREATE TABLE products (product_id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(150) NOT NULL, price DECIMAL(10,2) NOT NULL, category_id INT, FOREIGN KEY (category_id) REFERENCES categories(category_id))");
            DB::statement("CREATE TABLE customers (customer_id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100) NOT NULL, email VARCHAR(150) UNIQUE)");
            DB::statement("CREATE TABLE orders (order_id INT AUTO_INCREMENT PRIMARY KEY, order_date DATE NOT NULL, customer_id INT, FOREIGN KEY (customer_id) REFERENCES customers(customer_id))");
            DB::statement("CREATE TABLE order_details (order_id INT, product_id INT, quantity INT NOT NULL, price DECIMAL(10,2) NOT NULL, PRIMARY KEY (order_id, product_id), FOREIGN KEY (order_id) REFERENCES orders(order_id), FOREIGN KEY (product_id) REFERENCES products(product_id))");

            // Bơm dữ liệu mẫu
            DB::insert("INSERT INTO categories (category_name) VALUES ('Điện thoại'), ('Laptop'), ('Phụ kiện')");
            DB::insert("INSERT INTO products (name, price, category_id) VALUES 
                ('iPhone 15 Pro Max', 33990000, 1), ('Samsung Galaxy S24 Ultra', 28990000, 1), 
                ('MacBook Air M2', 28990000, 2), ('Dell XPS 13', 26990000, 2), 
                ('Tai nghe AirPods Pro 2', 5490000, 3), ('Chuột Logitech MX Master 3S', 2490000, 3), 
                ('Cáp sạc USB-C', 199000, 3), ('iPad Pro 12.9', 30990000, 1), 
                ('Asus ZenBook', 18990000, 2), ('Bàn phím cơ Keychron K2', 2390000, 3)");
            DB::insert("INSERT INTO customers (name, email) VALUES 
                ('Nguyễn Văn A', 'a.nguyen@example.com'), ('Trần Thị B', 'b.tran@example.com'), ('Lê Văn C', 'c.le@example.com')");
            DB::insert("INSERT INTO orders (order_date, customer_id) VALUES 
                ('2025-08-01', 1), ('2025-08-02', 2), ('2025-08-03', 3), ('2025-08-05', 1)");
            DB::insert("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES 
                (1,1,1,33990000), (1,5,2,5490000), (2,3,1,28990000), (3,2,1,28990000), 
                (3,6,1,2490000), (4,4,1,26990000), (4,7,3,199000)");

            return redirect()->route('lab5.index')->with('success', 'Đã khởi tạo Database cho Lab 5 thành công!');
        } catch (\Exception $e) {
            return "Lỗi setup CSDL Lab 5: " . $e->getMessage();
        }
    }

    public function index() {
        // --- CHÚ THÍCH GIẢI THÍCH CODE (LAB 5) ---

        // BT01: LEFT JOIN và GROUP BY đếm số sản phẩm mỗi loại
        $bt01 = DB::select("SELECT c.category_name, COUNT(p.product_id) AS total_products FROM categories c LEFT JOIN products p ON c.category_id = p.category_id GROUP BY c.category_name");
        
        // BT02: SUM và JOIN tính doanh thu ngày
        $bt02 = DB::select("SELECT o.order_date, SUM(od.quantity * od.price) AS total_revenue FROM orders o JOIN order_details od ON o.order_id = od.order_id GROUP BY o.order_date");

        // BT03: HAVING lọc kết quả sau khi GROUP BY
        $bt03 = DB::select("SELECT c.category_name, COUNT(p.product_id) AS total_products FROM categories c JOIN products p ON c.category_id = p.category_id GROUP BY c.category_name HAVING COUNT(p.product_id) > 5");

        // BT04: JOIN nhiều bảng và tính tổng chi tiêu
        $bt04 = DB::select("SELECT c.customer_id, c.name, SUM(od.quantity * od.price) AS total_spent FROM customers c JOIN orders o ON c.customer_id = o.customer_id JOIN order_details od ON o.order_id = od.order_id GROUP BY c.customer_id, c.name HAVING total_spent > 1000000");

        // BT05: SUBQUERY tìm sản phẩm đắt nhất mỗi nhóm
        $bt05 = DB::select("SELECT c.category_name, p.name, p.price FROM products p JOIN categories c ON p.category_id = c.category_id WHERE p.price = (SELECT MAX(p2.price) FROM products p2 WHERE p2.category_id = p.category_id)");

        // BT06: IS NULL tìm sản phẩm chưa từng bán
        $bt06 = DB::select("SELECT p.product_id, p.name FROM products p LEFT JOIN order_details od ON p.product_id = od.product_id WHERE od.product_id IS NULL");

        // BT07: ORDER BY kết hợp LIMIT lấy Top 1
        $bt07 = DB::select("SELECT c.customer_id, c.name, SUM(od.quantity) AS total_items FROM customers c JOIN orders o ON c.customer_id = o.customer_id JOIN order_details od ON o.order_id = od.order_id GROUP BY c.customer_id, c.name ORDER BY total_items DESC LIMIT 1");

        // BT08 (Ôn tập): Số lượng và doanh thu từng loại SP
        $bt08 = DB::select("SELECT c.category_name, SUM(od.quantity) as total_qty, SUM(od.quantity * od.price) as total_revenue FROM categories c JOIN products p ON c.category_id = p.category_id JOIN order_details od ON p.product_id = od.product_id GROUP BY c.category_name");

        // BT09 (Ôn tập): 3 SP bán chạy nhất
        $bt09 = DB::select("SELECT p.name, SUM(od.quantity) as total_sold FROM products p JOIN order_details od ON p.product_id = od.product_id GROUP BY p.name ORDER BY total_sold DESC LIMIT 3");

        // BT10 (Ôn tập): Top 5 KH chi tiêu nhiều nhất
        $bt10 = DB::select("SELECT c.name, SUM(od.quantity * od.price) as total_spent FROM customers c JOIN orders o ON c.customer_id = o.customer_id JOIN order_details od ON o.order_id = od.order_id GROUP BY c.name ORDER BY total_spent DESC LIMIT 5");

        // BT11 (Ôn tập): Loại hàng doanh thu cao nhất
        $bt11 = DB::select("SELECT c.category_name, SUM(od.quantity * od.price) as total_revenue FROM categories c JOIN products p ON c.category_id = p.category_id JOIN order_details od ON p.product_id = od.product_id GROUP BY c.category_name ORDER BY total_revenue DESC LIMIT 1");

        // BT12 (Ôn tập): Dùng COALESCE thay thế NULL bằng 0 cho SP chưa ai mua
        $bt12 = DB::select("SELECT p.name, COALESCE(SUM(od.quantity), 0) as total_ordered FROM products p LEFT JOIN order_details od ON p.product_id = od.product_id GROUP BY p.name");

        return view('lab5.index', compact('bt01', 'bt02', 'bt03', 'bt04', 'bt05', 'bt06', 'bt07', 'bt08', 'bt09', 'bt10', 'bt11', 'bt12'));
    }
}
'''

with open(r'd:\IT\HocKy_7\LapTrinhMaNguonMo\Buoi2_080726\buoi2\app\Http\Controllers\Lab5Controller.php', 'w', encoding='utf-8') as f:
    f.write(lab5_controller)


# --- 4. LAB 5 VIEWS ---
base_dir_5 = r'd:\IT\HocKy_7\LapTrinhMaNguonMo\Buoi2_080726\buoi2\resources\views\lab5'
os.makedirs(base_dir_5, exist_ok=True)

lab5_index = '''<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lab 5 - Advanced MySQL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5 mb-5 bg-light">
    <nav class="navbar navbar-dark bg-primary mb-4 rounded px-3 shadow">
        <a class="navbar-brand fw-bold" href="#">LAB 5: MySQL Nâng Cao (JOIN, GROUP BY, Subquery)</a>
        <div class="d-flex">
            <a href="{{ route('lab5.setup') }}" class="btn btn-warning me-2 fw-bold text-dark">Chạy Setup CSDL Lab 5</a>
            <a href="/lab4/students" class="btn btn-outline-light">Về Lab 4</a>
        </div>
    </nav>

    @if(session('success'))
        <div class="alert alert-success fw-bold">{{ session('success') }}</div>
    @endif

    <div class="row">
        <!-- BT01 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white fw-bold">BT01: Số lượng sản phẩm từng loại</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><th>Loại Hàng</th><th>Số lượng SP</th></tr>
                        @foreach($bt01 as $r) <tr><td>{{$r->category_name}}</td><td>{{$r->total_products}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- BT02 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white fw-bold">BT02: Tổng doanh thu từng ngày</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><th>Ngày</th><th>Doanh Thu (VNĐ)</th></tr>
                        @foreach($bt02 as $r) <tr><td>{{$r->order_date}}</td><td>{{number_format($r->total_revenue)}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- BT03 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white fw-bold">BT03: Loại hàng có > 5 sản phẩm</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><th>Loại Hàng</th><th>Số lượng SP</th></tr>
                        @foreach($bt03 as $r) <tr><td>{{$r->category_name}}</td><td>{{$r->total_products}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- BT04 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white fw-bold">BT04: Khách hàng mua > 1.000.000đ</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><th>Tên KH</th><th>Tổng tiền (VNĐ)</th></tr>
                        @foreach($bt04 as $r) <tr><td>{{$r->name}}</td><td>{{number_format($r->total_spent)}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- BT05 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white fw-bold">BT05: Sản phẩm đắt nhất từng loại</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><th>Loại Hàng</th><th>Sản phẩm</th><th>Giá</th></tr>
                        @foreach($bt05 as $r) <tr><td>{{$r->category_name}}</td><td>{{$r->name}}</td><td>{{number_format($r->price)}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- BT06 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white fw-bold">BT06: SP chưa từng được đặt hàng</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><th>Mã SP</th><th>Tên SP</th></tr>
                        @foreach($bt06 as $r) <tr><td>{{$r->product_id}}</td><td>{{$r->name}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- BT07 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-info text-dark fw-bold">BT07: KH mua nhiều SP nhất</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><th>Tên KH</th><th>Tổng SL mua</th></tr>
                        @foreach($bt07 as $r) <tr><td>{{$r->name}}</td><td>{{$r->total_items}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- BT08 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white fw-bold">BT08 (Ôn luyện): Doanh thu theo Loại hàng</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><th>Loại hàng</th><th>Số lượng bán</th><th>Doanh thu</th></tr>
                        @foreach($bt08 as $r) <tr><td>{{$r->category_name}}</td><td>{{$r->total_qty}}</td><td>{{number_format($r->total_revenue)}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- BT09 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white fw-bold">BT09 (Ôn luyện): 3 SP Bán chạy nhất</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><th>Tên Sản Phẩm</th><th>Đã Bán</th></tr>
                        @foreach($bt09 as $r) <tr><td>{{$r->name}}</td><td>{{$r->total_sold}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- BT10 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white fw-bold">BT10 (Ôn luyện): Top 5 KH Chi Tiêu Nhiều Nhất</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><th>Tên KH</th><th>Tổng Tiền Mua</th></tr>
                        @foreach($bt10 as $r) <tr><td>{{$r->name}}</td><td>{{number_format($r->total_spent)}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- BT11 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white fw-bold">BT11 (Ôn luyện): Loại Hàng Doanh Thu Cao Nhất</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><th>Loại Hàng</th><th>Doanh Thu Đỉnh</th></tr>
                        @foreach($bt11 as $r) <tr><td>{{$r->category_name}}</td><td>{{number_format($r->total_revenue)}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- BT12 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white fw-bold">BT12 (Ôn luyện): Số lần đặt hàng của TẤT CẢ SP</div>
                <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                    <table class="table table-sm">
                        <tr><th>Sản phẩm</th><th>Đã đặt (số lượng)</th></tr>
                        @foreach($bt12 as $r) <tr><td>{{$r->name}}</td><td>{{$r->total_ordered}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>'''

with open(os.path.join(base_dir_5, 'index.blade.php'), 'w', encoding='utf-8') as f:
    f.write(lab5_index)

# --- 5. UPDATE ROUTES/WEB.PHP FOR LAB 5 ---
routes_content = '''

// --- LAB 5: MYSQL NÂNG CAO ---
use App\Http\Controllers\Lab5Controller;
Route::prefix('lab5')->group(function () {
    Route::get('/', [Lab5Controller::class, 'index'])->name('lab5.index');
    Route::get('/setup', [Lab5Controller::class, 'setup'])->name('lab5.setup');
});
'''
with open(r'd:\IT\HocKy_7\LapTrinhMaNguonMo\Buoi2_080726\buoi2\routes\web.php', 'a', encoding='utf-8') as f:
    f.write(routes_content)

print("SUCCESS")
