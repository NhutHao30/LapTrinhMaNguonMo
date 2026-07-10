@extends('lab3.layout')
@section('title', 'Bài tập 10: To-do List (Lưu JSON)')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="input-group mb-3">
            <input type="text" id="taskName" class="form-control form-control-lg" placeholder="Nhập công việc mới...">
            <button class="btn btn-primary px-4" onclick="addTask()">Thêm</button>
        </div>
        <ul id="todoList" class="list-group"></ul>
    </div>
</div>

<script>
    let todos = [];

    function renderTasks() {
        const list = document.getElementById('todoList');
        list.innerHTML = '';
        todos.forEach((task, index) => {
            const li = document.createElement('li');
            li.className = "list-group-item d-flex justify-content-between align-items-center" + (task.completed ? " text-decoration-line-through text-muted bg-light" : "");
            
            li.innerHTML = `
                <div style="cursor:pointer; flex-grow:1" onclick="toggleTask(${index})">
                    <input type="checkbox" ${task.completed ? 'checked' : ''} class="me-2 form-check-input" style="cursor:pointer">
                    <span class="fs-5">${task.name}</span>
                </div>
                <button class="btn btn-danger btn-sm" onclick="deleteTask(${index})">Xóa</button>
            `;
            list.appendChild(li);
        });
    }

    function loadTasks() {
        fetch('/lab3/bt10-todos')
            .then(res => res.json())
            .then(data => {
                todos = data;
                renderTasks();
            });
    }

    function saveTasks() {
        fetch('/lab3/bt10-todos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ todos: todos })
        });
    }

    function addTask() {
        const input = document.getElementById('taskName');
        const name = input.value.trim();
        if (name) {
            todos.push({ name: name, completed: false });
            input.value = '';
            renderTasks();
            saveTasks();
        }
    }

    function toggleTask(index) {
        todos[index].completed = !todos[index].completed;
        renderTasks();
        saveTasks();
    }

    function deleteTask(index) {
        todos.splice(index, 1);
        renderTasks();
        saveTasks();
    }
    
    document.getElementById('taskName').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') addTask();
    });

    loadTasks();
</script>
@endsection