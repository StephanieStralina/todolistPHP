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
    <link href="./output.css" rel="stylesheet">
    <link href="./main.css" rel="stylesheet">
    <title>To-Do List</title>
</head>
<body>
    <div class="flex flex-col items-center">
        <h1 class=" text-4xl font-bold pt-8">To-Do List</h1>
        <form action="index.php" method="POST" class="pt-8">
            <input type="text" name="task" placeholder="Enter task here" id="" class="border border-black-600 rounded-sm p-2">
            <button type="submit" name="add-task" class="border border-black-600 rounded-sm p-2">Add Task</button>
        </form>
        <!-- Not Started Tasks -->
        <div class="pt-8 flex flex-col items-start w-full pl-120">
        <h3 class="text-xl underline">Not Started</h3>
        <ul class="pt-2">
            <?php foreach ($tasks['Not Started'] as $task): ?>
                <li>
                    <span class="italic text-lg">
                        <?php echo ($task["task"]); ?>
                    </span>
                    <div class="underline flex gap-2 text-emerald-500 justify-items-start">
                        <a href="index.php?complete=<?php echo $task['id']; ?>" class="hover:text-blue-300">Complete</a>
                        <a href="index.php?progress=<?php echo $task['id']; ?>" class="hover:text-blue-300">In Progress</a>
                        <a href="index.php?delete=<?php echo $task['id']; ?>" class="hover:text-blue-300">Delete</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>   
        <!-- In Progress Tasks -->
        <h3 class="pt-4 text-xl underline">In Progress</h3>
        <ul class="pt-2">
            <?php foreach ($tasks['In Progress'] as $task): ?>
                <li>
                    <span class="italic text-lg">
                        <?php echo ($task["task"]); ?>
                    </span>
                    <div class="underline flex gap-2 text-emerald-500">
                    <a href="index.php?complete=<?php echo $task['id']; ?>" class="hover:text-blue-300">Complete</a>
                    <a href="index.php?delete=<?php echo $task['id']; ?>" class="hover:text-blue-300">Delete</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <!-- Completed Tasks -->
        <h3 class="pt-4 text-xl underline">Complete</h3>
        <ul class="pt-2">
            <?php foreach ($tasks['Complete'] as $task): ?>
                <li>
                <span class="italic text-lg">
                    <?php echo ($task["task"]); ?>
                </span>
                    <div class="underline flex gap-2 text-emerald-500">
                    <a href="index.php?delete=<?php echo $task['id']; ?>" class="hover:text-blue-300">Delete</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        </div>
    </div>
</body>
</html>