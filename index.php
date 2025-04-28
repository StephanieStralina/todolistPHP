<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "todolist");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Add Task
if (isset($_POST["add-task"])) {
    $task = $_POST["task"];
    $conn -> query("INSERT INTO tasks (task) VALUES ('$task')");
    header("Location: index.php");
    exit();
}

//Delete Task
if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    $conn -> query("DELETE FROM tasks WHERE id ='$id'");
    header("Location: index.php");
    exit();
}

//Complete Task
if (isset($_GET["complete"])) {
    $id = $_GET["complete"];
    $conn -> query("UPDATE tasks SET status='Complete' WHERE id='$id'");
    header("Location: index.php");
    exit();
}

//Switch Task to In Progress
if (isset($_GET["progress"])) {
    $id = $_GET["progress"];
    $conn -> query("UPDATE tasks SET status='In Progress' WHERE id='$id'");
    header("Location: index.php");
    exit();
}

//Load Tasks to Display
$result = $conn->query("SELECT * FROM tasks ORDER BY id DESC");

$tasks = [
    'Not Started' => [],
    'In Progress' => [],
    'Complete' => []
];

while ($row = $result->fetch_assoc()) {
$tasks[$row['status']][] = $row;
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
            <input type="text" name="task" placeholder="Enter task here" id="">
            <button type="submit" name="add-task">Add Task</button>
        </form>
        <!-- Not Started Tasks -->
        <h3>Not Started</h3>
        <ul>
            <?php foreach ($tasks['Not Started'] as $task): ?>
                <li>
                    <?php echo ($task["task"]); ?>
                    <div class="actions">
                        <a href="index.php?complete=<?php echo $task['id']; ?>">Complete</a>
                        <a href="index.php?progress=<?php echo $task['id']; ?>">In Progress</a>
                        <a href="index.php?delete=<?php echo $task['id']; ?>">Delete</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
            
            <!-- In Progress Tasks -->
            <h3>In Progress</h3>
            <ul>
                <?php foreach ($tasks['In Progress'] as $task): ?>
                    <li>
                        <?php echo ($task["task"]); ?>
                        <div class="actions">
                            <a href="index.php?complete=<?php echo $task['id']; ?>">Complete</a>
                            <a href="index.php?delete=<?php echo $task['id']; ?>">Delete</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        
        <!-- Completed Tasks -->
        <h3>Complete</h3>
        <ul>
            <?php foreach ($tasks['Complete'] as $task): ?>
                <li>
                    <?php echo ($task["task"]); ?>
                    <div class="actions">
                        <a href="index.php?delete=<?php echo $task['id']; ?>">Delete</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>