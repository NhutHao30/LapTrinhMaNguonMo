<?php
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
