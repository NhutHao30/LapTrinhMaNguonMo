import os

base_dir = r'd:\IT\HocKy_7\LapTrinhMaNguonMo\Buoi2_080726\buoi2\resources\views\lab3'

index = '''@extends('lab3.layout')
@section('title', 'Danh sách Bài tập Lab 3 (JS & AJAX)')
@section('content')
    <div class="list-group mb-4">
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

    <h5 class="text-danger border-bottom pb-2">Bài Tập Ôn Luyện</h5>
    <div class="list-group">
        <a href="{{ route('lab3.bt10') }}" class="list-group-item list-group-item-action list-group-item-warning">Bài tập 10: Ứng dụng To-do list (JSON)</a>
        <a href="{{ route('lab3.bt11') }}" class="list-group-item list-group-item-action list-group-item-warning">Bài tập 11: Tỷ giá ngoại tệ (Real API)</a>
        <a href="{{ route('lab3.bt12') }}" class="list-group-item list-group-item-action list-group-item-warning">Bài tập 12: Form đăng ký (JS + Database)</a>
    </div>
@endsection'''

bt10 = '''@extends('lab3.layout')
@section('title', 'Bài tập 10: To-do List (Lưu JSON)')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="input-group mb-3">
            <input type="text" id="taskName" class="form-control form-control-lg" placeholder="Nhập công việc mới...">
            <button class="btn btn-primary px-4" onclick="addTask()">Thêm</button>
        </div>
        <ul id="todoList" class="list-group"></ul>
    </div>
</div>

<script>
    let todos = [];

    function renderTasks() {
        const list = document.getElementById('todoList');
        list.innerHTML = '';
        todos.forEach((task, index) => {
            const li = document.createElement('li');
            li.className = "list-group-item d-flex justify-content-between align-items-center" + (task.completed ? " text-decoration-line-through text-muted bg-light" : "");
            
            li.innerHTML = `
                <div style="cursor:pointer; flex-grow:1" onclick="toggleTask(${index})">
                    <input type="checkbox" ${task.completed ? 'checked' : ''} class="me-2 form-check-input" style="cursor:pointer">
                    <span class="fs-5">${task.name}</span>
                </div>
                <button class="btn btn-danger btn-sm" onclick="deleteTask(${index})">Xóa</button>
            `;
            list.appendChild(li);
        });
    }

    function loadTasks() {
        fetch('/lab3/bt10-todos')
            .then(res => res.json())
            .then(data => {
                todos = data;
                renderTasks();
            });
    }

    function saveTasks() {
        fetch('/lab3/bt10-todos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ todos: todos })
        });
    }

    function addTask() {
        const input = document.getElementById('taskName');
        const name = input.value.trim();
        if (name) {
            todos.push({ name: name, completed: false });
            input.value = '';
            renderTasks();
            saveTasks();
        }
    }

    function toggleTask(index) {
        todos[index].completed = !todos[index].completed;
        renderTasks();
        saveTasks();
    }

    function deleteTask(index) {
        todos.splice(index, 1);
        renderTasks();
        saveTasks();
    }
    
    document.getElementById('taskName').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') addTask();
    });

    loadTasks();
</script>
@endsection'''

bt11 = '''@extends('lab3.layout')
@section('title', 'Bài tập 11: Tỷ giá ngoại tệ (Fetch API Thật)')
@section('content')
<div class="alert alert-info">
    Tỷ giá quy đổi từ <strong>USD</strong> sang các đồng tiền khác. (Tự động cập nhật mỗi 10 phút)
    <span id="lastUpdated" class="float-end fw-bold"></span>
</div>
<table class="table table-bordered table-striped table-hover">
    <thead class="table-dark">
        <tr><th>Mã Tiền Tệ</th><th>Tỷ giá (1 USD =)</th></tr>
    </thead>
    <tbody id="rateBody">
        <tr><td colspan="2" class="text-center py-4">
            <div class="spinner-border text-primary" role="status"></div><br>Đang tải dữ liệu API...
        </td></tr>
    </tbody>
</table>

<script>
    function loadRates() {
        fetch('/lab3/bt11-rates')
            .then(res => res.json())
            .then(data => {
                if(data.error) {
                    document.getElementById('rateBody').innerHTML = `<tr><td colspan="2" class="text-danger fw-bold text-center">${data.error}</td></tr>`;
                    return;
                }
                const rates = data.rates;
                const currencies = ['VND', 'EUR', 'JPY', 'GBP', 'AUD', 'CAD', 'SGD', 'CNY', 'THB'];
                let html = '';
                currencies.forEach(cur => {
                    if (rates[cur]) {
                        html += `<tr><td class="fw-bold fs-5">${cur}</td><td class="fs-5">${rates[cur].toLocaleString()}</td></tr>`;
                    }
                });
                document.getElementById('rateBody').innerHTML = html;
                
                let now = new Date();
                document.getElementById('lastUpdated').innerText = "Cập nhật lúc: " + now.toLocaleTimeString();
            })
            .catch(err => {
                document.getElementById('rateBody').innerHTML = `<tr><td colspan="2" class="text-danger fw-bold text-center">Lỗi kết nối mạng</td></tr>`;
            });
    }

    loadRates();
    // 10 phút = 600000 ms
    setInterval(loadRates, 600000);
</script>
@endsection'''

bt12 = '''@extends('lab3.layout')
@section('title', 'Bài tập 12: Đăng ký tài khoản (JS Validate & DB)')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div id="alertBox" class="alert d-none"></div>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form id="regForm" onsubmit="event.preventDefault(); submitForm();">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên đăng nhập</label>
                        <input type="text" id="username" class="form-control" placeholder="Tối thiểu 3 ký tự">
                        <small id="errUsername" class="text-danger"></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="text" id="email" class="form-control" placeholder="Nhập địa chỉ email hợp lệ">
                        <small id="errEmail" class="text-danger"></small>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Mật khẩu</label>
                        <input type="password" id="password" class="form-control" placeholder="Tối thiểu 6 ký tự">
                        <small id="errPassword" class="text-danger"></small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fs-5 py-2">Đăng Ký Ngay</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function submitForm() {
        // Reset lỗi hiển thị
        document.getElementById('errUsername').innerText = '';
        document.getElementById('errEmail').innerText = '';
        document.getElementById('errPassword').innerText = '';
        document.getElementById('alertBox').className = "alert d-none";

        let user = document.getElementById('username').value.trim();
        let email = document.getElementById('email').value.trim();
        let pass = document.getElementById('password').value;

        let isValid = true;

        // JS Validations
        if (user.length < 3) {
            document.getElementById('errUsername').innerText = "Tên đăng nhập phải chứa ít nhất 3 ký tự!";
            isValid = false;
        }
        
        let emailRegex = /^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/;
        if (!emailRegex.test(email)) {
            document.getElementById('errEmail').innerText = "Địa chỉ email không đúng định dạng!";
            isValid = false;
        }

        if (pass.length < 6) {
            document.getElementById('errPassword').innerText = "Mật khẩu phải chứa ít nhất 6 ký tự!";
            isValid = false;
        }

        if (isValid) {
            let formData = new FormData();
            formData.append('username', user);
            formData.append('email', email);
            formData.append('password', pass);

            // Fetch API lưu vào DB
            fetch('/lab3/bt12-register', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                let alertBox = document.getElementById('alertBox');
                alertBox.innerText = data.message;
                alertBox.className = data.status === 'success' ? "alert alert-success fw-bold" : "alert alert-danger fw-bold";
                
                if (data.status === 'success') {
                    document.getElementById('regForm').reset();
                }
            })
            .catch(err => {
                let alertBox = document.getElementById('alertBox');
                alertBox.innerText = "Lỗi kết nối máy chủ!";
                alertBox.className = "alert alert-danger fw-bold";
            });
        }
    }
</script>
@endsection'''

files = {
    'index.blade.php': index,
    'bt10.blade.php': bt10,
    'bt11.blade.php': bt11,
    'bt12.blade.php': bt12,
}

for name, content in files.items():
    with open(os.path.join(base_dir, name), 'w', encoding='utf-8') as f:
        f.write(content)

print('Lab 3 EXTRA completed successfully!')
