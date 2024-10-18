<?php
require 'include/header.php';
require 'include/connect.php';

// Checking if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location:login.php');
    exit();
}


if (isset($_POST['create'])) {
    
    if (empty($_POST['title']) || empty($_POST['body'])) {
        echo "<script> alert('All entries must be filled');</script>";
    } else {
        
        $title = $_POST['title'];
        $body = $_POST['body'];

        
        $stmt = $conn->prepare("SELECT id FROM info WHERE username = :username");
        $stmt->bindParam(':username', $_SESSION['username']);
        $stmt->execute();
        $author = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($author) {
            $author_id = $author['id'];

            
            $stmt = $conn->prepare("INSERT INTO posts (title, body, author_id) VALUES (:title, :body, :author_id)");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':body', $body);
            $stmt->bindParam(':author_id', $author_id);

            
            if ($stmt->execute()) {
                echo "<script>alert('Post created successfully');</script>";
                header('Location:index.php');
                exit();
            } else {
                echo "<script>alert('Failed to create post');</script>";
            }
        } else {
            echo "<script>alert('Author not found');</script>";
        }
    }
}
?>

<main class="w-50 m-auto mt-5">
    <form action="createPost.php" method="post">
        <div class="card-mt-5">
            <div class="row justify-content-center">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" placeholder="Enter your title" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="body" class="label-control">Body</label>
                        <textarea name="body" class="form-control col-lg-3 col-md-6 col-sm-12 h-100 rounded-2" rows="5"></textarea>
                    </div>
                    <div class="d-grid gap-2 col-lg-3 col-md-6 col-sm-12 mx-auto">
                        <button name="create" type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>

<?php require 'include/footer.php'; ?>
