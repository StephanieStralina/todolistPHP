<?php
$conn = new mysqli("localhost", "root", "", "todolist");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} elseif ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["add-task"])) {
    $task = $_POST["task"];
    echo $task;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
</head>
<body>
    <div class="container">
        <h1>To-Do List</h1>
        <form action="index.php" method="POST">
            <input type="text" name="task" placeholder="Enter task here">
            <button type="submit" name="add-task">Add Task</button>
        </form>
    </div>
</body>
</html>