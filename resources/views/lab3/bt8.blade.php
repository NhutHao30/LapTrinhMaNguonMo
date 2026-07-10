@extends('lab3.layout')
@section('title', 'Bài tập 8: Ứng dụng Chat đơn giản')
@section('content')
    <div class="bg-light p-3 border rounded mb-3" style="height: 300px; overflow-y: auto;" id="chatBox">
        <!-- Tin nhắn sẽ hiện ở đây -->
    </div>
    
    <div class="input-group">
        <input type="text" id="msg" class="form-control" placeholder="Nhập tin nhắn...">
        <button onclick="send()" class="btn btn-success">Gửi</button>
    </div>

    <script>
        function loadChat() {
            fetch('/lab3/bt8-chat')
                .then(res => res.json())
                .then(data => {
                    let html = data.map(m => `<div class="mb-2 p-2 bg-white rounded shadow-sm border">${m}</div>`).join('');
                    document.getElementById("chatBox").innerHTML = html;
                });
        }

        function send() {
            let msgInput = document.getElementById("msg");
            if (msgInput.value.trim() === '') return;
            
            let formData = new FormData();
            formData.append('msg', msgInput.value);
            
            fetch('/lab3/bt8-chat', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(() => {
                msgInput.value = '';
                loadChat();
                let chatBox = document.getElementById("chatBox");
                setTimeout(() => chatBox.scrollTop = chatBox.scrollHeight, 100); 
            });
        }
        
        setInterval(loadChat, 2000);
        loadChat();
        
        // Gửi khi ấn Enter
        document.getElementById('msg').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                send();
            }
        });
    </script>
@endsection