<?php
 require 'include/header.php';

require 'include/connect.php';
if (isset($_POST['register'])) { 
    
    if ( empty($_POST['email']) || empty($_POST['password']) || empty($_POST['name'])) {
        echo "<script> alert('All entries must be filled');</script>";
    } else {
        
        $name = $_POST['name']; 
       
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO admin (name, email, password) VALUES (:name,:email, :password)");
        $stmt->bindParam(':name', $name); 
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            header('Location: AdminLogin.php');
            exit();
        } else {
            echo "<script> alert('Failed to register');</script>"; 
        }
    }
}
    
?>

<main class="w-50 m-auto">
<form action="adminRegister.php" method="post">
    <div class="card mt-3">
        <div class="row-justify-content-center">
            <div class="card-header">Admin Register</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="" class="form-label">Username</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" >
                </div>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button name="register" class="btn btn-primary">register</button>
                </div>
                <p class="text-center mt-2">already have an account? <a href="adminLogin.php">login</a></p>
            </div>
        </div>
    </div>
</form>
</main>
<?php require 'include/footer.php' ?>