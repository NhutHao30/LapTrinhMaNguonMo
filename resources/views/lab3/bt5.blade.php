@extends('lab3.layout')
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
@endsection