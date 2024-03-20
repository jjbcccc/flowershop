<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_wishlist'])){

   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   
   $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_wishlist_numbers) > 0){
       $message[] = 'Already added to wishlist';
   }elseif(mysqli_num_rows($check_cart_numbers) > 0){
       $message[] = 'Already added to cart';
   }else{
       mysqli_query($conn, "INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
       $message[] = 'Product added to wishlist';
   }

}

if(isset($_POST['add_to_cart'])){

   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
       $message[] = 'Already added to cart';
   }else{

       $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

       if(mysqli_num_rows($check_wishlist_numbers) > 0){
           mysqli_query($conn, "DELETE FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
       }

       mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
       $message[] = 'product added to cart';
   }

}

?>





<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">


   <link rel="stylesheet" href="css/carousel.css">



</head>
<body>
   
<?php @include 'header.php'; ?>


<main>
  <ul class='slider'>
  <li class='item' style="background-image: url('carousell/pinktulips.jpg')">
      <div class='content'>
      <h2 class='title'>"Pink Tulips"</h2>
<h5>In the language of flowers, each bloom bears a message of life's 
   fleeting nature paired with its own timeless beauty. The pink tulip, with its soft 
   petals and sturdy stem, speaks of care and a gentle strength.</h5>
          
   <a href="about.php"><button>About us</button></a>
      </div>
    </li>



    <li class='item' style="background-image: url('carousell/violetrose.jpg')">
      <div class='content'>
        <h2 class='title'>"Violet Rose"</h2>
        <h5>In the floral lexicon, the "Violet Rose" symbolizes enchantment and deep, 
         abiding love, offering a timeless gesture of affection.</h5>
         <a href="about.php"><button>About us</button></a>
      </div>
    </li>



    <li class='item' style="background-image: url('carousell/lavander.jpg')">
      <div class='content'>
        <h2 class='title'>"Lavander"</h2>
        <h5>Lavender signifies calmness and serenity, 
      embodying purity, silence, and grace, offering peace 
     and tranquility with its delicate fragrance and hue.</h5>
     <a href="about.php"><button>About us</button></a>
      </div>
    </li>



    <li class='item' style="background-image: url('carousell/violetrose.jpg')">
      <div class='content'>
        <h2 class='title'>"Violet Rose"</h2>
        <h5>In the floral lexicon, the "Violet Rose" symbolizes enchantment and deep, 
         abiding love, offering a timeless gesture of affection.</h5>
         <a href="about.php"><button>About us</button></a>
      </div>
    </li>

    <li class='item' style="background-image: url('carousell/lavander.jpg')">
      <div class='content'>
        <h2 class='title'>"Lavander"</h2>
        <h5>Lavender signifies calmness and serenity, 
      embodying purity, silence, and grace, offering peace 
     and tranquility with its delicate fragrance and hue.</h5>
     <a href="about.php"><button>About us</button></a>
      </div>
    </li>


    <li class='item' style="background-image: url('carousell/pinktulips.jpg')">
      <div class='content'>
      <h2 class='title'>"Pink Tulips"</h2>
<h5>In the language of flowers, each bloom bears a message of life's 
   fleeting nature paired with its own timeless beauty. The pink tulip, with its soft 
   petals and sturdy stem, speaks of care and a gentle strength.</h5>
          
   <a href="about.php"><button>About us</button></a>
      </div>
    </li>

  </ul>
  <nav class='nav'>
    <ion-icon class='btn prev' name="arrow-back-outline"></ion-icon>
    <ion-icon class='btn next' name="arrow-forward-outline"></ion-icon>
  </nav>
</main>





<section class="products">

   <h1 class="title">latest collection</h1>

   <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <form action="" method="POST" class="box">
         <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <input type="number" name="product_quantity" value="1" min="0" class="qty">
         <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
         <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
         <input type="submit" value="add to wishlist" name="add_to_wishlist" class="option-btn">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>

   </div>

   <div class="more-btn">
      <a href="shop.php" class="option-btn">load more</a>
   </div>

</section>






<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

<script src="js/carousel.js"></script>









<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>