<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lab 5 - Advanced MySQL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5 mb-5 bg-light">
    <nav class="navbar navbar-dark bg-primary mb-4 rounded px-3 shadow">
        <a class="navbar-brand fw-bold" href="#">LAB 5: MySQL Nâng Cao (JOIN, GROUP BY, Subquery)</a>
        <div class="d-flex">
            <a href="{{ route('lab5.setup') }}" class="btn btn-warning me-2 fw-bold text-dark">Chạy Setup CSDL Lab 5</a>
            <a href="/lab4/students" class="btn btn-outline-light">Về Lab 4</a>
        </div>
    </nav>

    @if(session('success'))
        <div class="alert alert-success fw-bold">{{ session('success') }}</div>
    @endif

    <div class="row">
        <!-- BT01 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white fw-bold">BT01: Số lượng sản phẩm từng loại</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><th>Loại Hàng</th><th>Số lượng SP</th></tr>
                        @foreach($bt01 as $r) <tr><td>{{$r->category_name}}</td><td>{{$r->total_products}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- BT02 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white fw-bold">BT02: Tổng doanh thu từng ngày</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><th>Ngày</th><th>Doanh Thu (VNĐ)</th></tr>
                        @foreach($bt02 as $r) <tr><td>{{$r->order_date}}</td><td>{{number_format($r->total_revenue)}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- BT03 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white fw-bold">BT03: Loại hàng có > 5 sản phẩm</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><th>Loại Hàng</th><th>Số lượng SP</th></tr>
                        @foreach($bt03 as $r) <tr><td>{{$r->category_name}}</td><td>{{$r->total_products}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- BT04 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white fw-bold">BT04: Khách hàng mua > 1.000.000đ</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><th>Tên KH</th><th>Tổng tiền (VNĐ)</th></tr>
                        @foreach($bt04 as $r) <tr><td>{{$r->name}}</td><td>{{number_format($r->total_spent)}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- BT05 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white fw-bold">BT05: Sản phẩm đắt nhất từng loại</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><th>Loại Hàng</th><th>Sản phẩm</th><th>Giá</th></tr>
                        @foreach($bt05 as $r) <tr><td>{{$r->category_name}}</td><td>{{$r->name}}</td><td>{{number_format($r->price)}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- BT06 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white fw-bold">BT06: SP chưa từng được đặt hàng</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><th>Mã SP</th><th>Tên SP</th></tr>
                        @foreach($bt06 as $r) <tr><td>{{$r->product_id}}</td><td>{{$r->name}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- BT07 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-info text-dark fw-bold">BT07: KH mua nhiều SP nhất</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><th>Tên KH</th><th>Tổng SL mua</th></tr>
                        @foreach($bt07 as $r) <tr><td>{{$r->name}}</td><td>{{$r->total_items}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- BT08 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white fw-bold">BT08 (Ôn luyện): Doanh thu theo Loại hàng</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><th>Loại hàng</th><th>Số lượng bán</th><th>Doanh thu</th></tr>
                        @foreach($bt08 as $r) <tr><td>{{$r->category_name}}</td><td>{{$r->total_qty}}</td><td>{{number_format($r->total_revenue)}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- BT09 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white fw-bold">BT09 (Ôn luyện): 3 SP Bán chạy nhất</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><th>Tên Sản Phẩm</th><th>Đã Bán</th></tr>
                        @foreach($bt09 as $r) <tr><td>{{$r->name}}</td><td>{{$r->total_sold}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- BT10 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white fw-bold">BT10 (Ôn luyện): Top 5 KH Chi Tiêu Nhiều Nhất</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><th>Tên KH</th><th>Tổng Tiền Mua</th></tr>
                        @foreach($bt10 as $r) <tr><td>{{$r->name}}</td><td>{{number_format($r->total_spent)}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- BT11 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white fw-bold">BT11 (Ôn luyện): Loại Hàng Doanh Thu Cao Nhất</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><th>Loại Hàng</th><th>Doanh Thu Đỉnh</th></tr>
                        @foreach($bt11 as $r) <tr><td>{{$r->category_name}}</td><td>{{number_format($r->total_revenue)}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- BT12 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white fw-bold">BT12 (Ôn luyện): Số lần đặt hàng của TẤT CẢ SP</div>
                <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                    <table class="table table-sm">
                        <tr><th>Sản phẩm</th><th>Đã đặt (số lượng)</th></tr>
                        @foreach($bt12 as $r) <tr><td>{{$r->name}}</td><td>{{$r->total_ordered}}</td></tr> @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>