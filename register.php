<?php
 require 'include/header.php';

require 'include/connect.php';
if(isset($_POST['register'])){ 
    
        if(empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])){
            echo "<script> alert('all entries must be filled');</script>";
        }
    

 else{
        
   
            $username=$_POST['username'];
            $email=$_POST['email'];
            $password=password_hash($_POST['password'],PASSWORD_BCRYPT);
            $stmt=$conn->prepare("INSERT INTO info (username,email,password) VALUES (:username,:email,:password)");
            $stmt->bindParam(':username',$username);
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':password',$password);
            if($stmt->execute()){
                $_SESSION['username']=$username;
                $_SESSION['email']=$email;
                header('Location:login.php');
                exit();
            }
            else{
                echo "<script> alert('invalid username or password');</script>"; 
            }
        }
    
    }
?>

<main class="w-50 m-auto">
<form action="register.php" method="post">
    <div class="card mt-3">
        <div class="row-justify-content-center">
            <div class="card-body">
                <div class="mb-3">
                    <label for="" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control">
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
                <p class="text-center mt-2">already have an account? <a href="login.php">login</a></p>
            </div>
        </div>
    </div>
</form>
</main>
<?php require 'include/footer.php' ?>