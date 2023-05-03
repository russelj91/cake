<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
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

<section class="heading">
    <div class="container">
        <div class="row mt-2 pt-2 mb-5 pb-5">
       
        </div>
    </div>
</section>
<section class="placed-orders">
    <div class="container my-5 py-5">
        <h1 class="title">Your Orders</h1>

        <div class="row">
        <div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Placed on</th>
                <th>Name</th>
                <th>Number</th>
                <th>Email</th>
                <th>Address</th>
                <th>Payment Method</th>
                <th>Your Orders</th>
                <th>Total Price</th>
                <th>Payment Status</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
            if(mysqli_num_rows($select_orders) > 0){
                while($fetch_orders = mysqli_fetch_assoc($select_orders)){
        ?>
            <tr>
                <td><?php echo $fetch_orders['placed_on']; ?></td>
                <td><?php echo $fetch_orders['name']; ?></td>
                <td><?php echo $fetch_orders['number']; ?></td>
                <td><?php echo $fetch_orders['email']; ?></td>
                <td><?php echo $fetch_orders['address']; ?></td>
                <td><?php echo $fetch_orders['method']; ?></td>
                <td><?php echo $fetch_orders['total_products']; ?></td>
                <td>₱<?php echo $fetch_orders['total_price']; ?></td>
                <td><span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){echo 'tomato'; }else{echo 'green';} ?>"><?php echo $fetch_orders['payment_status']; ?></span></td>
            </tr>
        <?php
                }
            }else{
                echo '<tr><td colspan="9"><p class="empty">no orders placed yet!</p></td></tr>';
            }
        ?>
        </tbody>
    </table>
</div>
        </div>
</div>
        </div>
        </section>








<?php @include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
<script src="js/script.js"></script>

</body>
</html>