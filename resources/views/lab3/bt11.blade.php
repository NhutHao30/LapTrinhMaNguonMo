@extends('lab3.layout')
@section('title', 'Bài tập 11: Tỷ giá ngoại tệ (Fetch API Thật)')
@section('content')
<div class="alert alert-info">
    Tỷ giá quy đổi từ <strong>USD</strong> sang các đồng tiền khác. (Tự động cập nhật mỗi 10 phút)
    <span id="lastUpdated" class="float-end fw-bold"></span>
</div>
<table class="table table-bordered table-striped table-hover">
    <thead class="table-dark">
        <tr><th>Mã Tiền Tệ</th><th>Tỷ giá (1 USD =)</th></tr>
    </thead>
    <tbody id="rateBody">
        <tr><td colspan="2" class="text-center py-4">
            <div class="spinner-border text-primary" role="status"></div><br>Đang tải dữ liệu API...
        </td></tr>
    </tbody>
</table>

<script>
    function loadRates() {
        fetch('/lab3/bt11-rates')
            .then(res => res.json())
            .then(data => {
                if(data.error) {
                    document.getElementById('rateBody').innerHTML = `<tr><td colspan="2" class="text-danger fw-bold text-center">${data.error}</td></tr>`;
                    return;
                }
                const rates = data.rates;
                const currencies = ['VND', 'EUR', 'JPY', 'GBP', 'AUD', 'CAD', 'SGD', 'CNY', 'THB'];
                let html = '';
                currencies.forEach(cur => {
                    if (rates[cur]) {
                        html += `<tr><td class="fw-bold fs-5">${cur}</td><td class="fs-5">${rates[cur].toLocaleString()}</td></tr>`;
                    }
                });
                document.getElementById('rateBody').innerHTML = html;
                
                let now = new Date();
                document.getElementById('lastUpdated').innerText = "Cập nhật lúc: " + now.toLocaleTimeString();
            })
            .catch(err => {
                document.getElementById('rateBody').innerHTML = `<tr><td colspan="2" class="text-danger fw-bold text-center">Lỗi kết nối mạng</td></tr>`;
            });
    }

    loadRates();
    // 10 phút = 600000 ms
    setInterval(loadRates, 600000);
</script>
@endsection