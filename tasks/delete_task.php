<?php
include '../includes/session.php';
include '../includes/functions.php';

$id = $_GET['id'];

$sql = "DELETE FROM tasks WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

header("Location: ../dashboard.php");
exit();
