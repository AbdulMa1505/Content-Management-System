<?php
require 'include/header.php';
 require 'include/connect.php';
if(isset($_POST['login'])){
    // validation
    if(empty($_POST['username']) || empty($_POST['password'])){
        echo "<script> alert('all entries must be filled');</script>";
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare the statement
        $stmt = $conn->prepare("SELECT * FROM info WHERE username=:username");
        $stmt->bindParam(':username', $username);

        // Execute the statement
        if($stmt->execute()){
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Check if user exists and verify password
            if($user && password_verify($password, $user['password'])){
                $_SESSION['username']=$user['username'];
                $_SESSION['email']=$user['email'];
                header('Location:index.php');
                exit();
            } else {
                echo "<script> alert('Invalid username or password');</script>"; 
            }
        } else {
            echo "<script> alert('Query execution failed');</script>";
        }
    }
}
?>


<main class="w-50 m-auto">
<form action="login.php" method="post">
    <div class="card mt-3">
        <div class="row-justify-content-center">
            <!-- <div class="card-header text-center">Login</div> -->
            <div class="card-body">
                <div class="mb-3">
                    <label for="" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" >
                </div>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button name="login" class="btn btn-primary">Login</button>
                </div>
                <p class="text-center mt-2">forgot password? <a href="resetPassword.php">click here</a></p>
                <p class="text-center mt-2">don't have an account? <a href="register.php">register</a></p>
            </div>
        </div>
    </div>
</form>
</main>
<?php require 'include/footer.php' ?>