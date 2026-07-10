@extends('lab3.layout')
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
@endsection