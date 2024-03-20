<?php
if(isset($message)){
   foreach($message as $msg){ // Use a different variable here to avoid confusion
      echo '
      <div class="message">
         <span>'.$msg.'</span> <!-- Changed variable to $msg -->
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">
    <div class="flex">
        <a href="landing_page.php" class="logo"><img src="images/flowery.png" height="90" width="150"></a>
        <nav class="navbar">
            <ul>
                <li><a href="landing_page.php">home</a></li>
                <li><a href="#">pages +</a>
                    <ul>
                        <li><a href="landing_page_about.php">about</a></li>
                        <li><a href="landing_page_contact.php">contact</a></li>
                    </ul>
                </li>
                
                <!-- Corrected the typo in the link for the shop page -->
                <li><a href="landing_page_shop.php">shop</a></li>
                <li><a href="login.php">orders</a></li>

                <li><a href="#">account +</a>
                    <ul>
                        <li><a href="login.php">login</a></li>
                        <li><a href="register.php">register</a></li>
                        <li><a href="admin_login.php">admin</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
            <a href="login.php"><i class="fas fa-heart"></i></a>
            <a href="login.php"><i class="fas fa-shopping-cart"></i></a>
        </div>
        <div class="account-box">
            <a href="register.php" class="btn">Create Account</a>
        </div>
    </div>
</header>
