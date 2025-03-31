<?php
session_start();
require_once 'connect.php';

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: feed.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$content = $_POST['content'];
$image_url = null;

// Handle image upload
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/posts/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    $file_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $file_name = uniqid() . '.' . $file_ext;
    $file_path = $upload_dir . $file_name;
    
    if (move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {
        $image_url = $file_path;
    }
}

$stmt = $conn->prepare("INSERT INTO posts (user_id, content, image_url) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $content, $image_url);
$stmt->execute();
$stmt->close();
$conn->close();

header("Location: feed.php");
exit();
?>