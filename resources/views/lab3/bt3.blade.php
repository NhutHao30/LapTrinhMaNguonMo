@extends('lab3.layout')
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
            let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
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
@endsection