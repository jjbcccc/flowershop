<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, password_hash($_POST['pass'], PASSWORD_DEFAULT));
   $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);

   $check_email = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'");
   if(mysqli_num_rows($check_email) > 0){
      $message[] = 'user already exists!';
   }else{
      mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$pass', '$user_type')") or die('query failed');
      $message[] = 'registered successfully!';
      if($user_type == 'admin'){
         header('location:admin_login.php');
      }else{
         header('location:login.php');
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message"> 
      <span>'.$message.'</span>
      <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
   </div>
   ';
   }
}
?>

<section class="form-container">
<form action="" method="post">
   <h3>register now</h3>
   <input type="text" name="name" class="box" placeholder="enter your username" required>
   <input type="email" name="email" class="box" placeholder="enter your email" required>
   <input type="password" name="pass" class="box" placeholder="enter your password" required>
   <input type="password" name="cpass" class="box" placeholder="confirm your password" required>
   <select name="user_type" class="box">
      <option value="user">User</option>
      <option value="admin">Admin</option>
   </select>
   <input type="submit" name="submit" value="register now" class="btn">
   <p>already have an account? <a href="login.php">login now</a></p>
</form>
</section>

</body>
</html>
