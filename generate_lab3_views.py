import os

routes_content = '''
Route::prefix('lab3')->group(function () {
    Route::get('/', [Lab3Controller::class, 'index'])->name('lab3.index');
    Route::get('/bt1', [Lab3Controller::class, 'bt1'])->name('lab3.bt1');
    Route::get('/bt2', [Lab3Controller::class, 'bt2'])->name('lab3.bt2');
    Route::get('/bt3', [Lab3Controller::class, 'bt3'])->name('lab3.bt3');
    Route::get('/bt4', [Lab3Controller::class, 'bt4'])->name('lab3.bt4');
    Route::get('/bt4-time', [Lab3Controller::class, 'bt4_time']);
    Route::get('/bt5', [Lab3Controller::class, 'bt5'])->name('lab3.bt5');
    Route::post('/bt5-hello', [Lab3Controller::class, 'bt5_hello']);
    Route::get('/bt6', [Lab3Controller::class, 'bt6'])->name('lab3.bt6');
    Route::get('/bt6-products', [Lab3Controller::class, 'bt6_products']);
    Route::get('/bt7', [Lab3Controller::class, 'bt7'])->name('lab3.bt7');
    Route::get('/bt7-search', [Lab3Controller::class, 'bt7_search']);
    Route::get('/bt8', [Lab3Controller::class, 'bt8'])->name('lab3.bt8');
    Route::get('/bt8-chat', [Lab3Controller::class, 'bt8_get_chat']);
    Route::post('/bt8-chat', [Lab3Controller::class, 'bt8_post_chat']);
    Route::get('/bt9', [Lab3Controller::class, 'bt9'])->name('lab3.bt9');
    Route::get('/bt9-weather', [Lab3Controller::class, 'bt9_weather']);
});
'''

# Append routes to web.php
with open(r'd:\IT\HocKy_7\LapTrinhMaNguonMo\Buoi2_080726\buoi2\routes\web.php', 'a', encoding='utf-8') as f:
    f.write(routes_content)

# Create Views
base_dir = r'd:\IT\HocKy_7\LapTrinhMaNguonMo\Buoi2_080726\buoi2\resources\views\lab3'
os.makedirs(base_dir, exist_ok=True)

layout = '''<!DOCTYPE html>
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
</html>'''

index = '''@extends('lab3.layout')
@section('title', 'Danh sách Bài tập Lab 3 (JS & AJAX)')
@section('content')
    <div class="list-group">
        <a href="{{ route('lab3.bt1') }}" class="list-group-item list-group-item-action">Bài tập 1: JavaScript cơ bản</a>
        <a href="{{ route('lab3.bt2') }}" class="list-group-item list-group-item-action">Bài tập 2: DOM Manipulation</a>
        <a href="{{ route('lab3.bt3') }}" class="list-group-item list-group-item-action">Bài tập 3: Event Handling</a>
        <a href="{{ route('lab3.bt4') }}" class="list-group-item list-group-item-action">Bài tập 4: AJAX cơ bản (Time)</a>
        <a href="{{ route('lab3.bt5') }}" class="list-group-item list-group-item-action">Bài tập 5: AJAX POST (Hello)</a>
        <a href="{{ route('lab3.bt6') }}" class="list-group-item list-group-item-action">Bài tập 6: Lấy danh sách sản phẩm (JSON)</a>
        <a href="{{ route('lab3.bt7') }}" class="list-group-item list-group-item-action">Bài tập 7: Tìm kiếm sản phẩm</a>
        <a href="{{ route('lab3.bt8') }}" class="list-group-item list-group-item-action">Bài tập 8: Ứng dụng Chat đơn giản</a>
        <a href="{{ route('lab3.bt9') }}" class="list-group-item list-group-item-action">Bài tập 9: Ứng dụng Dự báo thời tiết</a>
    </div>
@endsection'''

bt1 = '''@extends('lab3.layout')
@section('title', 'Bài tập 1: JavaScript cơ bản')
@section('content')
    <h3 id="msg" class="text-primary"></h3>
    <div id="info" class="alert alert-info"></div>
    
    <div class="mt-4">
        <label>Kiểm tra tuổi:</label>
        <div class="input-group w-50">
            <input type="number" id="age" class="form-control" placeholder="Nhập tuổi">
            <button onclick="checkAge()" class="btn btn-primary">Kiểm tra</button>
        </div>
        <p id="result" class="mt-2 fw-bold text-danger"></p>
    </div>

    <script>
        document.getElementById("msg").innerText = "Hello JavaScript";
        
        let name = "An";
        let age = 20;
        console.log(name, age);
        document.getElementById("info").innerHTML = `Tên: <strong>${name}</strong>, Tuổi: <strong>${age}</strong>`;

        function checkAge() {
            let a = document.getElementById("age").value;
            if (a >= 18) {
                document.getElementById("result").innerText = "Bạn đã đủ tuổi";
            } else {
                document.getElementById("result").innerText = "Bạn chưa đủ tuổi";
            }
        }
    </script>
@endsection'''

bt2 = '''@extends('lab3.layout')
@section('title', 'Bài tập 2: DOM Manipulation')
@section('content')
    <button onclick="changeBg()" class="btn btn-warning mb-4">Đổi màu nền Body</button>
    
    <div class="mb-4">
        <label>Lấy nội dung Input:</label>
        <div class="input-group w-50">
            <input type="text" id="txt" class="form-control" placeholder="Nhập gì đó...">
            <button onclick="showText()" class="btn btn-success">Hiển thị</button>
        </div>
        <div id="output" class="mt-2 alert alert-secondary" style="min-height: 40px;"></div>
    </div>

    <div>
        <label>Thêm vào danh sách:</label>
        <div class="input-group w-50">
            <input type="text" id="item" class="form-control">
            <button onclick="addItem()" class="btn btn-info text-white">Thêm</button>
        </div>
        <ul id="list" class="mt-3 list-group w-50"></ul>
    </div>

    <script>
        function changeBg() {
            document.body.style.backgroundColor = "#" + Math.floor(Math.random()*16777215).toString(16);
        }
        function showText() {
            document.getElementById("output").innerText = document.getElementById("txt").value;
        }
        function addItem() {
            let val = document.getElementById("item").value;
            if (val.trim() !== "") {
                let li = document.createElement("li");
                li.className = "list-group-item";
                li.innerText = val;
                document.getElementById("list").appendChild(li);
                document.getElementById("item").value = '';
            }
        }
    </script>
@endsection'''

bt3 = '''@extends('lab3.layout')
@section('title', 'Bài tập 3: Event Handling')
@section('content')
    <div class="mb-4">
        <label class="d-block fw-bold">Đồng hồ:</label>
        <h2 id="clock" class="badge bg-dark fs-3"></h2>
    </div>

    <div class="mb-4">
        <label class="fw-bold d-block">Thay đổi ảnh khi Hover:</label>
        <img id="img" src="https://placehold.co/200x200/000000/FFF?text=Image+1" width="200" class="rounded shadow"
            onmouseover="this.src='https://placehold.co/200x200/FF0000/FFF?text=Image+2'"
            onmouseout="this.src='https://placehold.co/200x200/000000/FFF?text=Image+1'">
    </div>

    <div>
        <label class="fw-bold">Kiểm tra Email:</label>
        <form onsubmit="return validateEmail()" class="d-flex gap-2 w-50">
            <input type="text" id="email" class="form-control" placeholder="Nhập email">
            <button type="submit" class="btn btn-primary">Kiểm tra</button>
        </form>
        <p id="msg" class="mt-2 fw-bold"></p>
    </div>

    <script>
        function validateEmail() {
            let email = document.getElementById("email").value;
            let regex = /^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/;
            let msg = document.getElementById("msg");
            if (regex.test(email)) {
                msg.innerText = "Email hợp lệ";
                msg.className = "mt-2 fw-bold text-success";
            } else {
                msg.innerText = "Email không hợp lệ";
                msg.className = "mt-2 fw-bold text-danger";
            }
            return false; // Prevent form submit
        }
        
        function updateClock() {
            let now = new Date();
            document.getElementById("clock").innerText = now.toLocaleTimeString();
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
@endsection'''

bt4 = '''@extends('lab3.layout')
@section('title', 'Bài tập 4: AJAX cơ bản (Time)')
@section('content')
    <p>Thời gian server (cập nhật tự động mỗi 5 giây qua AJAX Fetch):</p>
    <h1 id="time" class="text-success"></h1>
    
    <script>
        function getTime() {
            fetch('/lab3/bt4-time')
                .then(res => res.text())
                .then(data => {
                    document.getElementById("time").innerText = data;
                })
                .catch(err => console.error("Lỗi lấy thời gian: ", err));
        }
        setInterval(getTime, 5000);
        getTime();
    </script>
@endsection'''

bt5 = '''@extends('lab3.layout')
@section('title', 'Bài tập 5: AJAX POST (Hello)')
@section('content')
    <div class="input-group w-50">
        <input type="text" id="name" class="form-control" placeholder="Nhập tên của bạn">
        <button onclick="sayHello()" class="btn btn-primary">Gửi AJAX POST</button>
    </div>
    <p id="msg" class="mt-3 fw-bold text-primary fs-4"></p>

    <script>
        function sayHello() {
            let formData = new FormData();
            formData.append('name', document.getElementById("name").value);
            
            fetch('/lab3/bt5-hello', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(res => res.text())
            .then(data => {
                document.getElementById("msg").innerText = data;
            });
        }
    </script>
@endsection'''

bt6 = '''@extends('lab3.layout')
@section('title', 'Bài tập 6: Lấy danh sách sản phẩm (JSON)')
@section('content')
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr><th>Tên Sản phẩm</th><th>Giá (VNĐ)</th></tr>
        </thead>
        <tbody id="tbl">
            <tr><td colspan="2" class="text-center">Đang tải dữ liệu...</td></tr>
        </tbody>
    </table>

    <script>
        fetch('/lab3/bt6-products')
            .then(res => res.json())
            .then(data => {
                let html = "";
                data.forEach(p => {
                    html += `<tr><td>${p.name}</td><td>${p.price.toLocaleString()}</td></tr>`;
                });
                document.getElementById("tbl").innerHTML = html;
            });
    </script>
@endsection'''

bt7 = '''@extends('lab3.layout')
@section('title', 'Bài tập 7: Tìm kiếm sản phẩm')
@section('content')
    <div class="input-group w-50 mb-3">
        <input type="text" id="kw" class="form-control" placeholder="Nhập từ khóa (vd: iphone, samsung)">
        <button onclick="search()" class="btn btn-info text-white">Tìm kiếm AJAX</button>
    </div>
    
    <ul id="result" class="list-group w-50"></ul>

    <script>
        function search() {
            let q = document.getElementById("kw").value;
            fetch('/lab3/bt7-search?q=' + encodeURIComponent(q))
                .then(res => res.json())
                .then(data => {
                    if (data.length === 0) {
                        document.getElementById("result").innerHTML = `<li class="list-group-item text-danger">Không tìm thấy sản phẩm nào!</li>`;
                        return;
                    }
                    document.getElementById("result").innerHTML = data.map(p => 
                        `<li class="list-group-item d-flex justify-content-between align-items-center">
                            ${p.name} <span class="badge bg-primary rounded-pill">${p.price.toLocaleString()} VNĐ</span>
                        </li>`
                    ).join('');
                });
        }
    </script>
@endsection'''

bt8 = '''@extends('lab3.layout')
@section('title', 'Bài tập 8: Ứng dụng Chat đơn giản')
@section('content')
    <div class="bg-light p-3 border rounded mb-3" style="height: 300px; overflow-y: auto;" id="chatBox">
        <!-- Tin nhắn sẽ hiện ở đây -->
    </div>
    
    <div class="input-group">
        <input type="text" id="msg" class="form-control" placeholder="Nhập tin nhắn...">
        <button onclick="send()" class="btn btn-success">Gửi</button>
    </div>

    <script>
        function loadChat() {
            fetch('/lab3/bt8-chat')
                .then(res => res.json())
                .then(data => {
                    let html = data.map(m => `<div class="mb-2 p-2 bg-white rounded shadow-sm border">${m}</div>`).join('');
                    document.getElementById("chatBox").innerHTML = html;
                });
        }

        function send() {
            let msgInput = document.getElementById("msg");
            if (msgInput.value.trim() === '') return;
            
            let formData = new FormData();
            formData.append('msg', msgInput.value);
            
            fetch('/lab3/bt8-chat', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(() => {
                msgInput.value = '';
                loadChat();
                let chatBox = document.getElementById("chatBox");
                setTimeout(() => chatBox.scrollTop = chatBox.scrollHeight, 100); 
            });
        }
        
        setInterval(loadChat, 2000);
        loadChat();
        
        // Gửi khi ấn Enter
        document.getElementById('msg').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                send();
            }
        });
    </script>
@endsection'''

bt9 = '''@extends('lab3.layout')
@section('title', 'Bài tập 9: Ứng dụng Dự báo thời tiết')
@section('content')
    <div class="input-group w-50 mb-3">
        <input type="text" id="city" class="form-control" placeholder="Nhập thành phố (hanoi, danang)">
        <button onclick="getWeather()" class="btn btn-primary">Xem Thời Tiết</button>
    </div>
    
    <div id="weather"></div>

    <script>
        function getWeather() {
            let c = document.getElementById("city").value;
            fetch('/lab3/bt9-weather?city=' + encodeURIComponent(c))
                .then(res => res.json())
                .then(data => {
                    let icon = data.temp > 0 ? "🌤️" : "❓";
                    document.getElementById("weather").innerHTML = 
                        `<div class="card border-info mb-3 w-50">
                            <div class="card-header bg-info text-white text-uppercase fw-bold">${c}</div>
                            <div class="card-body">
                                <h5 class="card-title text-center fs-1">${icon} ${data.temp}°C</h5>
                                <p class="card-text text-center text-muted fs-5">${data.desc}</p>
                            </div>
                        </div>`;
                });
        }
    </script>
@endsection'''

files = {
    'layout.blade.php': layout,
    'index.blade.php': index,
    'bt1.blade.php': bt1,
    'bt2.blade.php': bt2,
    'bt3.blade.php': bt3,
    'bt4.blade.php': bt4,
    'bt5.blade.php': bt5,
    'bt6.blade.php': bt6,
    'bt7.blade.php': bt7,
    'bt8.blade.php': bt8,
    'bt9.blade.php': bt9,
}

for name, content in files.items():
    with open(os.path.join(base_dir, name), 'w', encoding='utf-8') as f:
        f.write(content)

print('Lab 3 Views created successfully!')
