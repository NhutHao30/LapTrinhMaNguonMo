<?php
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
