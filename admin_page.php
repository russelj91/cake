<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

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
      <title>CakeShop</title>

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="dashboard">
<div class="container my-5 py-5 ">
   <div class="account-box">
      <div class="row text-center">
         <div class="col-md-5 mx-auto py-2 mb-2 rounded shadow">
  <h1 class="fw-bold">Welcome Admin!</h1>
  <a href="logout.php" class="delete-btn btn">logout</a>
</div>
</div>
</div>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-3">
      <?php
        $total_pendings = 0;
        $select_pendings = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
        while($fetch_pendings = mysqli_fetch_assoc($select_pendings)){
           $total_pendings += $fetch_pendings['total_price'];
        };
      ?>
      <div class="card">
        <div class="card-body">
          <h3 class="card-title">₱<?php echo $total_pendings; ?></h3>
          <p class="card-text">Total Pending</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <?php
        $total_completes = 0;
        $select_completes = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
        while($fetch_completes = mysqli_fetch_assoc($select_completes)){
           $total_completes += $fetch_completes['total_price'];
        };
      ?>
      <div class="card">
        <div class="card-body">
          <h3 class="card-title">₱<?php echo $total_completes; ?></h3>
          <p class="card-text">Completed Total</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <?php
        $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
        $number_of_orders = mysqli_num_rows($select_orders);
      ?>
      <div class="card">
        <div class="card-body">
          <h3 class="card-title"><?php echo $number_of_orders; ?></h3>
          <p class="card-text">Orders placed</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <?php
        $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
        $number_of_products = mysqli_num_rows($select_products);
      ?>
      <div class="card">
        <div class="card-body">
          <h3 class="card-title"><?php echo $number_of_products; ?></h3>
          <p class="card-text">Total Products</p>
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-md-3">
      <?php
        $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
        $number_of_users = mysqli_num_rows($select_users);
      ?>
      <div class="card">
        <div class="card-body">
          <h3 class="card-title"><?php echo $number_of_users; ?></h3>
          <p class="card-text">Registered users</p>
        </div>
      </div>
    </div>
 
    <div class="col-md-3">
      <?php
        $select_account = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
        $number_of_account = mysqli_num_rows($select_account);
      ?>
      <div class="card">
        <div class="card-body">
          <h3 class="card-title"><?php echo $number_of_account; ?></h3>
          <p class="card-text">Total accounts</p>
        </div>
      </div>
    </div>
    
    <div class="col-md-3">
      <?php
        $select_messages = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
        $number_of_messages = mysqli_num_rows($select_messages);
      ?>
      <div class="card">
        <div class="card-body">
          <h3 class="card-title"><?php echo $number_of_messages; ?></h3>
          <p class="card-text">New message</p>
        </div>
      </div>
    </div>
    
</div>

         </div>
</section>












<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
<script src="js/admin_script.js"></script>

</body>
</html>