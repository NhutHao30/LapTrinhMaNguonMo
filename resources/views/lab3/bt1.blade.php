@extends('lab3.layout')
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
@endsection