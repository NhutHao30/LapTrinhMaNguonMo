@extends('lab3.layout')
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
        
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
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
@endsection