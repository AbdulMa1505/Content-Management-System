<?php
require 'include/header.php';
 require 'include/connect.php';
if(isset($_POST['login'])){
    // user input validation
    if(empty($_POST['name']) || empty($_POST['password'])){
        echo "<script> alert('all entries must be filled');</script>";
    } else {
        $name = $_POST['name'];
        $password = $_POST['password'];

        
        $stmt = $conn->prepare("SELECT * FROM admin WHERE name=:name");
        $stmt->bindParam(':name', $name);

       
        if($stmt->execute()){
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Checking if admin exists and verify password
            if($admin && password_verify($password, $admin['password'])){
                $_SESSION['name']=$admin['name'];
                $_SESSION['email']=$admin['email'];
                header('Location:dashboard.php');
                exit();
            } else {
                echo "<script> alert('Invalid name or password');</script>"; 
            }
        } else {
            echo "<script> alert('Query execution failed');</script>";
        }
    }
}
?>


<main class="w-50 m-auto">
<form action="adminLogin.php" method="post">
    <div class="card mt-3">
        <div class="row-justify-content-center">
            <div class="card-header text-center">Admin Login</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="" class="form-label">Username</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" >
                </div>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button name="login" class="btn btn-primary">Login</button>
                </div>
                <p class="text-center mt-2">forgot password? <a href="resetPassword.php">click here</a></p>
                <p class="text-center mt-2">don't have an account? <a href="AdminRegister.php">register</a></p>
            </div>
        </div>
    </div>
</form>
</main>
<?php require 'include/footer.php' ?>