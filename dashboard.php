<?php
require 'include/header.php';
require 'include/connect.php';

// Fetch post data
$stmt = $conn->prepare("SELECT p.*,i.username AS author FROM posts p JOIN info i ON  p.author_id=i.id ORDER BY p.created_at DESC");
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid">  
    <div class="row">
        <div class="col-md-3 px-0" style="position:fixed; left:0; top:0; height:100vh; background-color:#f8f9fa;">
              <div class="sidebar" style="width:100%; height:100%;">
                <h3 class="text-center p-3">Admin <?php echo isset($_SESSION['name']) ?$_SESSION['name']:'Guest';?></h3>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a class="btn btn-outline-secondary" href="index.php">Posts</a>
                        <i class="fa-solid fa-chart-line"></i>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="logout.php" class="btn btn-outline-danger">Logout</a>
                        <i class="fa-solid fa-sign-out-alt"></i>
                    </li>
                </ul>
            </div>
        </div>

        
        <div class="col-md-9 offset-md-3 ps-3"> 
             <main class="main-content">
                <div class="container mt-5">
                    <div class="row">
                        <?php foreach ($posts as $post): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold"><?php echo $post['title']; ?></h5>
                                        <p class="card-text"><?php echo $post['body']; ?></p>
                                        <p class="card-text text-muted">By: <?php echo $post['author']; ?></p>
                                        <p class="card-text text-muted">date: <?php echo $post['created_at']; ?></p>
                                        <div class="d-flex justify-content-end">
                                            <a href="delete.php?id=<?php echo $post['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                            <a href="edit.php?id=<?php echo $post['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>

<?php require 'include/footer.php'; ?>
