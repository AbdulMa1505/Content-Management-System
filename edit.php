<?php
require 'include/header.php';
require 'include/connect.php';

// Ensure the post ID is present in the URL
if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit();
}

$post_id = $_GET['id'];

// Fetch the post data
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = :id");
$stmt->bindParam(':id', $post_id);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);

// If no post is found, redirect to dashboard
if (!$post) {
    header('Location: dashboard.php');
    exit();
}

// Update post if form is submitted
if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $post_id = $_POST['id']; // Get post ID from hidden input

    $stmt = $conn->prepare("UPDATE posts SET title = :title, body = :body WHERE id = :id");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':body', $body);
    $stmt->bindParam(':id', $post_id);

    if ($stmt->execute()) {
        echo "<script> alert('Post updated successfully!');</script>";
        header('Location: dashboard.php');
        exit();
    } else {
        echo "<script> alert('Failed to update post');</script>";
    }
}
?>

<!-- Edit Form -->
<form action="edit.php?id=<?php echo $post_id; ?>" method="post">
    <!-- Hidden input for post ID -->
    <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($post['title']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="body" class="form-label">Body</label>
        <textarea name="body" class="form-control" rows="5" required><?php echo htmlspecialchars($post['body']); ?></textarea>
    </div>
    <button name="update" class="btn btn-primary">Update Post</button>
</form>

<?php require 'include/footer.php'; ?>
