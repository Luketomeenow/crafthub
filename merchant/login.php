<?php 
    session_start();
    include 'dbcon.php'
?>
<?php 
if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    //for user
    $select = "SELECT * FROM `crafthub_user` WHERE `email` = '$email' AND `user_pass` = '$password'";

    $result = mysqli_query($connection, $select);

    if (!$result) {
        die("Query Failed: ". mysqli_error($connection));
    }

    if(mysqli_num_rows($result) > 0){

      if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $row['user_id'];
            echo "<script> alert('You Successfully Login!') 
                    window.location.href = 'homepage.php';
                    </script>";
      }else{
        echo "<script> alert('Account does not exists') </script>";
      }
  }else{
        //for  merchant
    $select1 = "SELECT * FROM `crafthub_merchant` WHERE `username` = '$email' AND `password` = '$password'";

    $result1 = mysqli_query($connection, $select1);

    if (!$result1) {
        die("Query Failed: ". mysqli_error($connection));
    }

    if(mysqli_num_rows($result1) > 0){

        if(mysqli_num_rows($result1) == 1){
        $row1 = mysqli_fetch_assoc($result1);
            $_SESSION['merchant_id'] = $row1['merchant_id'];
            echo "<script> alert('Successfully Login!') 
                    window.location.href = 'merchant/mdashboard.php';
                    </script>";
        }else{
        echo "<script> alert('Account does not exists') </script>";
        }
    }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
    <title>CraftHub: An Online Marketplace</title>
</head>
<body>
    <!--=============== LOGIN CONTENT FORM ===============-->
    <div class="login">
        <img src="images/craftsbg.png" alt="login image" class="login__img">

        <form action="login.php" method="POST" class="login__form">
            <h1 class="login__title">CraftHub Login</h1>
            <div class="login__content">
                <div class="login__box">
                    <i class="ri-user-3-line login__icon"></i>
                    <div class="login__box-input">
                        <input type="text" required class="login__input" name="email" id="login-email" placeholder=" ">
                        <label for="login-email" class="login__label">Email</label>
                    </div>
                </div>
                <div class="login__box">
                    <i class="ri-lock-2-line login__icon"></i>
                    <div class="login__box-input">
                        <input type="password" required class="login__input" name="password" id="login-pass" placeholder=" ">
                        <label for="login-pass" class="login__label">Password</label>
                        <i class="ri-eye-off-line login__eye" id="login-eye"></i>
                    </div>
                </div>
            </div>
          
            <button type="submit" name="submit" class="login__button">Login</button>
            <p class="login__register">
                Don't have an account? <a href="register.php">Register</a>
            </p>
        </form>
    </div>
    <!--=============== END OF LOGIN CONTENT ===============-->

<script src="js/login.js"></script>
</body>
</html>
