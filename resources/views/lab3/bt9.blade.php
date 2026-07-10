@extends('lab3.layout')
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
@endsection