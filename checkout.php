<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['order'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, 'flat no. '. $_POST['flat'].', '. $_POST['street'].', '. $_POST['city'].', '. $_POST['country'].' - '. $_POST['pin_code']);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products[] = '';

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($cart_query) > 0){
        while($cart_item = mysqli_fetch_assoc($cart_query)){
            $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }

    $total_products = implode(', ',$cart_products);

    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

    if($cart_total == 0){
        $message[] = 'your cart is empty!';
    }elseif(mysqli_num_rows($order_query) > 0){
        $message[] = 'order placed already!';
    }else{
        mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
        mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        $message[] = 'order placed successfully!';
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="design/style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
<title>CakeshopPh</title>


</head>
<body>
   
<?php @include 'header.php'; ?>




   


<section class="checkout">
    <div class="container my-5 py-5 rounded shadow">
    <section class="display-order">
        <div class="container mt-5">
        <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
    ?>    
    <p> <?php echo $fetch_cart['name'] ?> <span>(<?php echo '₱'.$fetch_cart['price'].' x '.$fetch_cart['quantity']  ?>)</span> </p>
    <?php
        }
        }else{
            echo '<p class="empty">your cart is empty</p>';
        }
    ?>
    <div class="grand-total">Total : <span>₱<?php echo $grand_total; ?></span></div>
</div>
</section>
<form action="" method="POST">
    <h3>place your order</h3>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Your Name:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="number">Your Number:</label>
                <input type="number" class="form-control" id="number" name="number" min="0" placeholder="Enter your number">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="email">Your Email:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="method">Payment Method:</label>
                <select class="form-control" id="method" name="method">
                    <option value="cash on delivery">Cash on Delivery</option>
                    <option value="credit card">Cash on Pick up</option>
                    <option value="paypal">GCash</option>
                    <option value="paytm">Bank Transfer</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="flat">Address Line 01:</label>
                <input type="text" class="form-control" id="flat" name="flat" placeholder="e.g. flat no.">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="street">Address Line 02:</label>
                <input type="text" class="form-control" id="street" name="street" placeholder="e.g. street name">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="e.g. Digos City">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="state">Province:</label>
                <input type="text" class="form-control" id="state" name="state" placeholder="e.g. Davao del sur">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="country">Country:</label>
                <input type="text" class="form-control" id="country" name="country" placeholder="e.g. Philippines">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="pin_code">Pin Code:</label>
                <input type="number" class="form-control" id="pin_code" name="pin_code" min="0" placeholder="e.g. 123456">
            </div>
        </div>
    </div>

    <button type="submit" name="order" class="btn text-light m-2">Order Now</button>
    </form>
    </div>
</section>






<?php @include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
<script src="js/script.js"></script>

</body>
</html>