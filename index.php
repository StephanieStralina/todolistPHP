<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$conn = new mysqli("localhost", "root", "", "todolist");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} elseif ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["add-task"])) {
    $task = $_POST["task"];
    $conn -> query("INSERT INTO tasks (task) VALUES ('$task')");
    header("Location: index.php");
    exit();
}
if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    $conn -> query("DELETE FROM tasks WHERE id ='$id'");
}
$result = $conn->query("SELECT * FROM tasks ORDER BY id DESC");
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
            <input type="text" name="task" placeholder="Enter task here" id="">
            <button type="submit" name="add-task">Add Task</button>
        </form>
        <ul>
            <?php while($row = $result -> fetch_assoc()): ?>
                <li>
                    <?php echo $row["task"]; ?>
                    <div class="actions">
                        <a href="index.php?complete=<?php echo $row['id']; ?>">Complete</a>
                        <a href="index.php?delete=<?php echo $row['id']; ?>">Delete</a>
                    </div>
                </li>
            <?php endwhile ?>
        </ul>
    </div>
</body>
</html>