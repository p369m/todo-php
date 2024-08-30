<?php
include '../includes/session.php';
include '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $status = $_POST['status'];
    $due_date = $_POST['due_date'];

    $sql = "UPDATE tasks SET title = ?, description = ?, category = ?, status = ?, due_date = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $description, $category, $status, $due_date, $id]);

    header("Location: ../dashboard.php");
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM tasks WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$task = $stmt->fetch();
?>

<form method="POST" action="edit_task.php">
    <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
    <input type="text" name="title" value="<?php echo $task['title']; ?>" required>
    <textarea name="description"><?php echo $task['description']; ?></textarea>
    <input type="text" name="category" value="<?php echo $task['category']; ?>">
    <select name="status">
        <option value="Pending" <?php if ($task['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
        <option value="In Progress" <?php if ($task['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
        <option value="Completed" <?php if ($task['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
    </select>
    <input type="date" name="due_date" value="<?php echo $task['due_date']; ?>">
    <button type="submit">Update Task</button>
</form>
