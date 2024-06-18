<?php
session_start();

if (!isset($_SESSION['todo_list'])) {
    $_SESSION['todo_list'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                $task = htmlspecialchars($_POST['task']);
                $_SESSION['todo_list'][] = $task;
                break;
            case 'update':
                $index = intval($_POST['index']);
                $task = htmlspecialchars($_POST['task']);
                $_SESSION['todo_list'][$index] = $task;
                break;
            case 'delete':
                $index = intval($_POST['index']);
                array_splice($_SESSION['todo_list'], $index, 1);
                break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime Themed To-do App</title>
    <link rel="stylesheet" href="index.css">
    <script>
        function enableEditing(index) {
            var taskInput = document.getElementById('task-' + index);
            taskInput.readOnly = false;
            taskInput.focus();
            document.getElementById('edit-btn-' + index).style.display = 'none';
            document.getElementById('save-btn-' + index).style.display = 'inline';
        }

        function disableEditing(index) {
            var taskInput = document.getElementById('task-' + index);
            taskInput.readOnly = true;
            document.getElementById('edit-btn-' + index).style.display = 'inline';
            document.getElementById('save-btn-' + index).style.display = 'none';
        }
    </script>
</head>
<body>
    <header>
        <h1>Anime To-do App</h1>
    </header>
    <main>
        <form method="post" action="">
            <input type="text" name="task" placeholder="New task" required>
            <input type="hidden" name="action" value="create">
            <button type="submit">Add Task</button>
        </form>
        <ul>
            <?php foreach ($_SESSION['todo_list'] as $index => $task): ?>
            <li>
                <form method="post" action="" style="display: inline;">
                    <input type="text" id="task-<?php echo $index; ?>" name="task" value="<?php echo $task; ?>" required readonly>
                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                    <input type="hidden" name="action" value="update">
                    <button type="button" id="edit-btn-<?php echo $index; ?>" onclick="enableEditing(<?php echo $index; ?>)">Edit</button>
                    <button type="submit" id="save-btn-<?php echo $index; ?>" style="display: none;" onclick="disableEditing(<?php echo $index; ?>)">Save</button>
                </form>
                <form method="post" action="" style="display: inline;">
                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                    <input type="hidden" name="action" value="delete">
                    <button type="submit">Delete</button>
                </form>
            </li>
            <?php endforeach; ?>
        </ul>
    </main>
</body>
</html>