<?php
require 'include/header.php';
require 'include/connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: dashboard.php');
    exit();
}

$post_id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM posts WHERE id = :id");
$stmt->bindParam(':id', $post_id);

if ($stmt->execute()) {
    echo "<script> alert('Post deleted successfully!');</script>";
    header('Location: dashboard.php');
    exit();
} else {
    echo "<script> alert('Failed to delete post');</script>";
}
?>
<?php require'include/footer.php'?>
