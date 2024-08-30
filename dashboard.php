<?php
include 'includes/session.php';
include 'includes/functions.php';

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $status = $_POST['status'];
    $due_date = $_POST['due_date'];

    $sql = "INSERT INTO tasks (user_id, title, description, category, status, due_date) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $title, $description, $category, $status, $due_date]);
}

$sql = "SELECT * FROM tasks WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$tasks = $stmt->fetchAll();
?>

<h1>Welcome, <?php echo $_SESSION['username']; ?></h1>

<form method="POST" action="dashboard.php">
    <input type="text" name="title" placeholder="Task Title" required>
    <textarea name="description" placeholder="Description"></textarea>
    <input type="text" name="category" placeholder="Category">
    <select name="status">
        <option value="Pending">Pending</option>
        <option value="In Progress">In Progress</option>
        <option value="Completed">Completed</option>
    </select>
    <input type="date" name="due_date">
    <button type="submit">Add Task</button>
</form>

<h2>Your Tasks</h2>
<ul>
    <?php foreach ($tasks as $task): ?>
        <li><?php echo $task['title'] . " - " . $task['status']; ?>
            <a href="tasks/edit_task.php?id=<?php echo $task['id']; ?>">Edit</a>
            <a href="tasks/delete_task.php?id=<?php echo $task['id']; ?>">Delete</a>
        </li>
    <?php endforeach; ?>
</ul>

<a href="logout.php">Logout</a>
