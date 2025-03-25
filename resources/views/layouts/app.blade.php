<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Мои задачи')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Список задач</a>
    </div>
</nav>

<div class="container mt-4">
    <div class="container mt-5">
        <h2 class="mb-4">Список задач</h2>
        <div class="mb-3">
            <div class="d-flex gap-2">
                <input type="text" id="task-title" class="form-control flex-grow-1"
                       placeholder="Введите название задачи">
                <input type="text" id="task-description" class="form-control flex-grow-1"
                       placeholder="Введите описание задачи">
            </div>

            <button class="btn btn-primary mt-2" onclick="addTask()">Добавить</button>
        </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody id="task-list">
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function () {
            loadTasks();
        });

        function loadTasks() {
            $.ajax({
                url: `/api/tasks`,
                type: 'get',
            }).done(function (response) {
                let rows = '';
                response.data.forEach(task => {
                    rows += `<tr id="task-${task.id}">
                            <td>${task.id}</td>
                            <td><input name='title' type="text" class="form-control" value="${task.title}" onchange="updateTask(${task.id})"></td>
                            <td><input name='description' type="text" class="form-control" value="${task.description}" onchange="updateTask(${task.id})"></td>
                            <td><input name='status' type="text" class="form-control" value="${task.status}" onchange="updateTask(${task.id})" disabled></td>
                            <td><button class="btn btn-danger" onclick="deleteTask(${task.id})">Удалить</button></td>
                        </tr>`;
                });
                $('#task-list').html(rows);
            });
        }

        function addTask() {
            let taskTitle = $('#task-title');
            let taskDescription = $('#task-description');
            $.ajax({
                url: `/api/tasks`,
                type: 'post',
                dataType: 'json',
                data: {
                    title: taskTitle.val(),
                    description: taskDescription.val()
                },
            }).done(function (response) {
                taskTitle.val('')
                taskDescription.val('')
                let taskData = response.data;
                $('#task-list').append(`<tr id="task-${taskData.id}">
                            <td>${taskData.id}</td>
                            <td><input name='title' type="text" class="form-control" value="${taskData.title}" onchange="updateTask(${taskData.id})"></td>
                            <td><input name='description' type="text" class="form-control" value="${taskData.description}" onchange="updateTask(${taskData.id})"></td>
                            <td><input name='status' type="text" class="form-control" value="${taskData.status}" onchange="updateTask(${taskData.id})" disabled></td>
                            <td><button class="btn btn-danger" onclick="deleteTask(${taskData.id})">Удалить</button></td>
                        </tr>`);
            });
        }

        function updateTask(id) {
            let taskTitle = $('#task-' + id).find('input[name="title"]');
            let taskDescription = $('#task-' + id).find('input[name="description"]');
            let taskStatus = $('#task-' + id).find('input[name="status"]');
            $.ajax({
                url: `/api/tasks/${id}`,
                type: 'PUT',
                data: {
                    title: taskTitle.val(),
                    description: taskDescription.val()
                }
            }).done(function (response) {
                let taskData = response.data;
                taskTitle.val(taskData.title);
                taskDescription.val(taskData.description);
                taskStatus.val(taskData.status);
            });
        }

        function deleteTask(id) {
            $.ajax({
                url: `/api/tasks/${id}`,
                type: 'DELETE',
                success: function () {
                    $(`#task-${id}`).remove();
                }
            });
        }
    </script>
</div>
</body>
</html>
