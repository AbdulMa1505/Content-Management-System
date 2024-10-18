<?php
require 'include/header.php';
include 'include/connect.php';

echo "Logged in: " . $_SESSION['username'];

$stmt = $conn->prepare("SELECT p.*,i.username AS author FROM posts p JOIN info i ON  p.author_id=i.id ORDER BY p.created_at DESC");
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
  <div class="row row-cols-1 row-cols-md-2 g-4">
    <?php foreach ($posts as $post): ?>
      <div class="col">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title fw-bold">Title:<?php echo $post['title']; ?></h5>
            <p class="card-text"><?php echo $post['body']; ?></p>
            <p class="card-text text-muted">By: <?php echo $post['author']; ?></p>
            <p class="text-muted"><?php echo $post['created_at'];?></p>
            <a href="createPost.php" class="btn btn-success">post</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php require 'include/footer.php'; ?>