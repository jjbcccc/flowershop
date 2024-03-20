<?php
@include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

$message = ''; // Initialize message variable to display alerts
$insert_order = false; // Initialize $insert_order to false

if(isset($_POST['order'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, 'flat no. '. $_POST['flat'].', '. $_POST['street'].', '. $_POST['city'].', '. $_POST['state'].', '. $_POST['country'].' - '. $_POST['pin_code']);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products = [];

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($cart_query) > 0){
        while($cart_item = mysqli_fetch_assoc($cart_query)){
            $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }

    $total_products = implode(', ', $cart_products);

    if($cart_total == 0){
        $message = 'Your cart is empty!';
    }else{
        $insert_order = mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')");
        if($insert_order){
            mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
            $message = 'Order placed successfully!';
            // Display receipt logic here, since the order was successful
        } else {
            $message = 'Failed to place order. Please try again.';
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
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>checkout order</h3>
    <p> <a href="home.php">home</a> / checkout </p>
</section>


<!-- Receipt Display Logic -->
<?php if($insert_order): ?>
<div class="receipt-modal">
    <section class="receipt-section">
        <div class="receipt">
            <!-- Position the button container here to have it above the message -->
            
            <h3>Order Receipt</h3>
            <div class="receipt-details">
                <!-- Receipt content goes here -->
                <div class="receipt-row"><span>Ordered On:</span> <?php echo $placed_on; ?></div>
                <div class="receipt-row"><span>Name:</span> <?php echo $name; ?></div>
                <div class="receipt-row"><span>Number:</span> <?php echo $number; ?></div>
                <div class="receipt-row"><span>Email:</span> <?php echo $email; ?></div>
                <div class="receipt-row"><span>Payment Method:</span> <?php echo $method; ?></div>
                <div class="receipt-row"><span>Address:</span> <?php echo $address; ?></div>
                <div class="receipt-row"><span>Ordered Products:</span> <?php echo $total_products; ?></div>
                <div class="receipt-row"><span>Total Price:</span> $<?php echo $cart_total; ?></div>
            </div>

            
            <p class="message"><?php echo $message; ?></p>

            <div class="shop-button-container">
                <button onclick="window.location.href='home.php'">Thankyou for shopping!</button>
            </div>

        </div>
    </section>
    
</div>
<?php endif; ?>










<section class="display-order">
    <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
    ?>    
    <p> <?php echo $fetch_cart['name'] ?> <span>(<?php echo '$'.$fetch_cart['price'].'/-'.' x '.$fetch_cart['quantity']  ?>)</span> </p>
    <?php
        }
        }else{
            echo '<p class="empty">your cart is empty</p>';
        }
    ?>
    <div class="grand-total">grand total : <span>$<?php echo $grand_total; ?>/-</span></div>
</section>

<section class="checkout">

    <form action="" method="POST">

        <h3>place your order</h3>

        <div class="flex">
            <div class="inputBox">
                <span>your name :</span>
                <input type="text" name="name" placeholder="enter your name">
            </div>
            <div class="inputBox">
                <span>your number :</span>
                <input type="number" name="number" min="0" placeholder="enter your number">
            </div>
            <div class="inputBox">
                <span>your email :</span>
                <input type="email" name="email" placeholder="enter your email">
            </div>
            <div class="inputBox">
                <span>payment method :</span>
                <select name="method">
                    <option value="cash on delivery">cash on delivery</option>
                    <option value="credit card">credit card</option>
                    <option value="paypal">paypal</option>
                    <option value="paytm">paytm</option>
                </select>
            </div>
            <div class="inputBox">
                <span>address line 01 :</span>
                <input type="text" name="flat" placeholder="e.g. flat no.">
            </div>
            <div class="inputBox">
                <span>address line 02 :</span>
                <input type="text" name="street" placeholder="e.g.  streen name">
            </div>
            <div class="inputBox">
                <span>city :</span>
                <input type="text" name="city" placeholder="e.g. mumbai">
            </div>
            <div class="inputBox">
                <span>state :</span>
                <input type="text" name="state" placeholder="e.g. maharashtra">
            </div>
            <div class="inputBox">
                <span>country :</span>
                <input type="text" name="country" placeholder="e.g. india">
            </div>
            <div class="inputBox">
                <span>pin code :</span>
                <input type="number" min="0" name="pin_code" placeholder="e.g. 123456">
            </div>
        </div>

        <input type="submit" name="order" value="order now" class="btn">

    </form>

</section>






<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>