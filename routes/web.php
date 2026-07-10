<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Lab2Controller;
use App\Http\Controllers\Lab3Controller;

Route::get('/', function () {
    return view('welcome');
});

// --- LAB 2 ---
Route::prefix('lab2')->group(function () {
    Route::get('/', [Lab2Controller::class, 'index'])->name('lab2.index');
    Route::get('/bt1', [Lab2Controller::class, 'bt1'])->name('lab2.bt1');
    Route::get('/bt2', [Lab2Controller::class, 'bt2'])->name('lab2.bt2');
    Route::get('/bt3', [Lab2Controller::class, 'bt3'])->name('lab2.bt3');
    Route::get('/bt4', [Lab2Controller::class, 'bt4'])->name('lab2.bt4');
    Route::get('/bt5', [Lab2Controller::class, 'bt5'])->name('lab2.bt5');
    Route::get('/bt6', [Lab2Controller::class, 'bt6'])->name('lab2.bt6');
    Route::get('/bt7', [Lab2Controller::class, 'bt7'])->name('lab2.bt7');
    Route::get('/bt8', [Lab2Controller::class, 'bt8'])->name('lab2.bt8');
});

// --- LAB 3: TƯƠNG TÁC JS & AJAX VỚI BACKEND PHP ---
Route::prefix('lab3')->group(function () {
    // Các Route trả về giao diện (View) HTML chứa mã Javascript
    Route::get('/', [Lab3Controller::class, 'index'])->name('lab3.index');
    Route::get('/bt1', [Lab3Controller::class, 'bt1'])->name('lab3.bt1');
    Route::get('/bt2', [Lab3Controller::class, 'bt2'])->name('lab3.bt2');
    Route::get('/bt3', [Lab3Controller::class, 'bt3'])->name('lab3.bt3');
    Route::get('/bt4', [Lab3Controller::class, 'bt4'])->name('lab3.bt4');
    Route::get('/bt5', [Lab3Controller::class, 'bt5'])->name('lab3.bt5');
    Route::get('/bt6', [Lab3Controller::class, 'bt6'])->name('lab3.bt6');
    Route::get('/bt7', [Lab3Controller::class, 'bt7'])->name('lab3.bt7');
    Route::get('/bt8', [Lab3Controller::class, 'bt8'])->name('lab3.bt8');
    Route::get('/bt9', [Lab3Controller::class, 'bt9'])->name('lab3.bt9');

    // Các Route API: Nơi Javascript Fetch() gọi lên để lấy/gửi dữ liệu (không trả về HTML, chỉ trả về chuỗi/JSON)
    Route::get('/bt4-time', [Lab3Controller::class, 'bt4_time']);       // Trả về giờ hiện tại (text)
    Route::post('/bt5-hello', [Lab3Controller::class, 'bt5_hello']);    // Nhận POST tên và trả về lời chào (text)
    Route::get('/bt6-products', [Lab3Controller::class, 'bt6_products']);// Trả về danh sách sản phẩm (JSON)
    Route::get('/bt7-search', [Lab3Controller::class, 'bt7_search']);   // Tìm kiếm SP theo từ khóa (JSON)
    Route::get('/bt8-chat', [Lab3Controller::class, 'bt8_get_chat']);   // Lấy lịch sử tin nhắn (JSON)
    Route::post('/bt8-chat', [Lab3Controller::class, 'bt8_post_chat']); // Lưu tin nhắn mới (JSON)
    Route::get('/bt9-weather', [Lab3Controller::class, 'bt9_weather']); // Lấy thời tiết theo thành phố (JSON)
    
    // BÀI TẬP ÔN LUYỆN
    Route::get('/bt10', [Lab3Controller::class, 'bt10'])->name('lab3.bt10');
    Route::get('/bt10-todos', [Lab3Controller::class, 'bt10_get_todos']);
    Route::post('/bt10-todos', [Lab3Controller::class, 'bt10_save_todos']);
    
    Route::get('/bt11', [Lab3Controller::class, 'bt11'])->name('lab3.bt11');
    Route::get('/bt11-rates', [Lab3Controller::class, 'bt11_rates']);
    
    Route::get('/bt12', [Lab3Controller::class, 'bt12'])->name('lab3.bt12');
    Route::post('/bt12-register', [Lab3Controller::class, 'bt12_register']);
});


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


// --- LAB 5: MYSQL NÂNG CAO ---
use App\Http\Controllers\Lab5Controller;
Route::prefix('lab5')->group(function () {
    Route::get('/', [Lab5Controller::class, 'index'])->name('lab5.index');
    Route::get('/setup', [Lab5Controller::class, 'setup'])->name('lab5.setup');
});
