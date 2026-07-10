@extends('lab3.layout')
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
@endsection