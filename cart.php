<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
    header('location:cart.php');
}

if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    header('location:cart.php');
};

if(isset($_POST['update_quantity'])){
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
    $message[] = 'cart quantity updated!';
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


<section class="shopping-cart my-5 py-5">

<div class="container my-5 py-5">
    <h1 class="title">Your orders</h1>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
                $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']);
                $grand_total += $sub_total;
    ?>
         <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4 d-flex">
            <div class="card h-100">
                <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" class="card-img-top image" alt="" width="150px">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $fetch_cart['name']; ?></h5>
                    <p class="card-text">₱<?php echo $fetch_cart['price']; ?></p>
                    <form action="" method="post">
                        <input type="hidden" value="<?php echo $fetch_cart['id']; ?>" name="cart_id">
                        <div class="input-group mb-3">
                            <input type="number" min="1" value="<?php echo $fetch_cart['quantity']; ?>" name="cart_quantity" class="form-control qty">
                            <button type="submit" class="btn text-light option-btn" name="update_quantity">Update</button>
                        </div>
                    </form>
                    <p class="card-text">Sub-total: <span>₱<?php echo $sub_total; ?></span></p>
                    <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="btn text-light" onclick="return confirm('Delete this from cart?');">Delete</a>
                <a href="view_page.php?pid=<?php echo $fetch_cart['pid']; ?>" class="btn text-light">View</a>
                </div>
            </div>
        </div>
    <?php
            }
        } else {
            echo '<p class="empty">Your cart is empty.</p>';
        }
    ?>
    </div>
    <div class="more-btn">
        <a href="cart.php?delete_all" class="delete-btn btn text-light my-2<?php echo ($grand_total > 1)?'':'disabled' ?>" onclick="return confirm('Delete all from cart?');">Delete all</a>
    </div>

    <div class="cart-total mt-5">
        <p class="fw-bold">Total: <span class="fw-normal bg-info p-2 rounded">₱: <?php echo $grand_total; ?></span></p>
        <div class="d-grid gap-2 d-md-block">
            <a href="shop.php" class="btn text-light">Shop</a>
            <a href="checkout.php" class="btn text-light <?php echo ($grand_total > 1)?'':'disabled' ?>">Proceed to checkout</a>
        </div>
    </div>
</div>

</section>








<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
</body>
</html>