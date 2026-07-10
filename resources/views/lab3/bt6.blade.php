@extends('lab3.layout')
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
@endsection