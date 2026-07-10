<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class Lab3Controller extends Controller
{
    // --- CÁC HÀM TRẢ VỀ GIAO DIỆN (VIEWS) ---
    public function index() { return view('lab3.index'); }
    public function bt1() { return view('lab3.bt1'); }
    public function bt2() { return view('lab3.bt2'); }
    public function bt3() { return view('lab3.bt3'); }
    public function bt4() { return view('lab3.bt4'); }
    public function bt5() { return view('lab3.bt5'); }
    public function bt6() { return view('lab3.bt6'); }
    public function bt7() { return view('lab3.bt7'); }
    public function bt8() { return view('lab3.bt8'); }
    public function bt9() { return view('lab3.bt9'); }
    
    // --- CÁC HÀM XỬ LÝ API CHO JAVASCRIPT (AJAX/FETCH) ---

    // BT4: Trả về chuỗi văn bản là thời gian hiện tại
    public function bt4_time() { 
        return date("H:i:s"); 
    }

    // BT5: Nhận dữ liệu POST từ form, trả về lời chào
    public function bt5_hello(Request $request) {
        // Lấy biến 'name' gửi từ JS, nếu không có thì mặc định là 'Bạn'
        $name = $request->input('name', 'Bạn');
        // Trả về chuỗi văn bản. htmlspecialchars giúp chống lỗi bảo mật XSS
        return "Xin chào, " . htmlspecialchars($name);
    }

    // BT6: Trả về danh sách mảng dữ liệu dưới định dạng JSON
    public function bt6_products() {
        // response()->json() sẽ tự động chuyển mảng PHP thành chuỗi JSON cho Javascript đọc
        return response()->json([
            ["name" => "Sản phẩm 1", "price" => 10000],
            ["name" => "Sản phẩm 2", "price" => 20000]
        ]);
    }

    // BT7: Tìm kiếm theo từ khóa
    public function bt7_search(Request $request) {
        // Lấy từ khóa 'q' trên thanh địa chỉ url (ví dụ: ?q=iphone), chuyển thành chữ thường
        $keyword = strtolower($request->query('q', ''));
        
        // Mảng dữ liệu giả lập (thực tế sẽ lấy từ Database)
        $products = [
            ["name" => "Iphone 15", "price" => 30000000],
            ["name" => "Samsung S24", "price" => 25000000]
        ];
        
        // Dùng hàm array_filter để lọc ra các sản phẩm có tên chứa từ khóa
        $result = array_filter($products, function($p) use ($keyword) {
            return strpos(strtolower($p['name']), $keyword) !== false;
        });
        
        // Trả về kết quả dưới dạng JSON (array_values giúp reset lại key của mảng)
        return response()->json(array_values($result));
    }

    // BT8: Ứng dụng Chat - Lấy tin nhắn
    public function bt8_get_chat() {
        // Chỉ định đường dẫn tới file lưu tạm chat.txt trong thư mục storage/app/
        $file = storage_path('app/chat.txt');
        
        // Nếu file tồn tại, đọc toàn bộ file thành mảng (mỗi dòng 1 phần tử), bỏ qua dấu enter
        $messages = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES) : [];
        
        return response()->json($messages);
    }

    // BT8: Ứng dụng Chat - Gửi tin nhắn mới
    public function bt8_post_chat(Request $request) {
        $file = storage_path('app/chat.txt');
        // Nếu có tin nhắn được gửi lên
        if ($request->has('msg')) {
            // Nối tin nhắn mới vào cuối file, có thêm \n để xuống dòng
            File::append($file, $request->input('msg') . "\n");
        }
        return response()->json(['status' => 'success']);
    }

    // BT9: Dự báo thời tiết giả lập
    public function bt9_weather(Request $request) {
        // Lấy tên thành phố gửi lên
        $city = strtolower($request->query('city', ''));
        
        $data = [
            "hanoi" => ["temp" => 30, "desc" => "Nắng đẹp"],
            "danang" => ["temp" => 32, "desc" => "Có mây"],
        ];
        
        // Trả về dữ liệu của thành phố đó. Nếu không tìm thấy (??), trả về mảng báo lỗi.
        return response()->json($data[$city] ?? ["temp" => 0, "desc" => "Không có dữ liệu"]);
    }

    // --- BÀI TẬP ÔN LUYỆN (10, 11, 12) ---

    // BT10: To-do list
    public function bt10() { return view('lab3.bt10'); }
    
    // Lấy danh sách To-do từ file JSON
    public function bt10_get_todos() {
        $file = storage_path('app/todos.json');
        if (file_exists($file)) {
            // Đọc và trả file json
            return response()->file($file, ['Content-Type' => 'application/json']);
        }
        return response()->json([]);
    }
    
    // Lưu danh sách To-do xuống file JSON
    public function bt10_save_todos(Request $request) {
        $file = storage_path('app/todos.json');
        // Lưu dữ liệu vào file
        File::put($file, json_encode($request->input('todos', [])));
        return response()->json(['status' => 'success']);
    }

    // BT11: Tỷ giá ngoại tệ
    public function bt11() { return view('lab3.bt11'); }
    public function bt11_rates() {
        // Sử dụng HTTP Client của Laravel để gọi API thật
        try {
            // Thêm withoutVerifying() để bỏ qua lỗi SSL certificate (cURL error 60) thường gặp trên localhost/Windows
            $response = \Illuminate\Support\Facades\Http::withoutVerifying()->get('https://open.er-api.com/v6/latest/USD');
            return $response->json();
        } catch (\Exception $e) {
            // Hiển thị chi tiết lỗi thực sự để dễ debug thay vì báo chung chung
            return response()->json(['error' => 'Lỗi: ' . $e->getMessage()]);
        }
    }

    // BT12: Form đăng ký
    public function bt12() { return view('lab3.bt12'); }
    public function bt12_register(Request $request) {
        try {
            // Đặt toàn bộ trong try-catch để bắt chính xác lỗi thay vì làm ứng dụng crash
            
            // Tạo bảng (Cú pháp MySQL)
            \Illuminate\Support\Facades\DB::statement("
                CREATE TABLE IF NOT EXISTS lab3_accounts (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(50) NOT NULL UNIQUE,
                    password VARCHAR(255) NOT NULL,
                    email VARCHAR(100) NOT NULL UNIQUE
                )
            ");

            $username = $request->input('username');
            $password = bcrypt($request->input('password')); // Mã hóa mật khẩu
            $email = $request->input('email');

            // Thêm vào DB (MySQL/SQLite đều tương thích với câu lệnh này)
            \Illuminate\Support\Facades\DB::insert("INSERT INTO lab3_accounts (username, password, email) VALUES (?, ?, ?)", [$username, $password, $email]);
            
            return response()->json(['status' => 'success', 'message' => 'Đăng ký thành công và lưu vào CSDL!']);
        } catch (\Exception $e) {
            // Trả về chính xác thông báo lỗi từ Database để dễ sửa
            return response()->json(['status' => 'error', 'message' => 'Lỗi DB: ' . $e->getMessage()]);
        }
    }
}
