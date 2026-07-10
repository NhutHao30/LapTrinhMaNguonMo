@extends('lab3.layout')
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
@endsection