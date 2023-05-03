<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['update_order'])){
   $order_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_id'") or die('query failed');
   $message[] = 'payment status has been updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
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
      <title>CakeShop</title>

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="placed-orders">



   <div class="container">
   <h1 class="title">Orders and Records </h1>
   <div class="table-responsive">
  <table class="table">
    <thead>
      <tr>
        <th>User ID</th>
        <th>Placed On</th>
        <th>Name</th>
        <th>Number</th>
        <th>Email</th>
        <th>Address</th>
        <th>Total Products</th>
        <th>Total Price</th>
        <th>Payment Method</th>
        <th>Payment Status</th>
        <th>Update Payment</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
        if(mysqli_num_rows($select_orders) > 0){
          while($fetch_orders = mysqli_fetch_assoc($select_orders)){
      ?>
      <tr>
        <td><?php echo $fetch_orders['user_id']; ?></td>
        <td><?php echo $fetch_orders['placed_on']; ?></td>
        <td><?php echo $fetch_orders['name']; ?></td>
        <td><?php echo $fetch_orders['number']; ?></td>
        <td><?php echo $fetch_orders['email']; ?></td>
        <td><?php echo $fetch_orders['address']; ?></td>
        <td><?php echo $fetch_orders['total_products']; ?></td>
        <td>$<?php echo $fetch_orders['total_price']; ?>/-</td>
        <td><?php echo $fetch_orders['method']; ?></td>
        <td><?php echo $fetch_orders['payment_status']; ?></td>
        <td>
          <form action="" method="post">
            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
            <select name="update_payment" class="form-select">
              <option disabled selected><?php echo $fetch_orders['payment_status']; ?></option>
              <option value="pending">Pending</option>
              <option value="completed">Completed</option>
            </select>
           
            <button type="submit" name="update_order" class="btn text-light my-2">Update</button>
         
          </form>
        </td>
        <td>
          <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" class="btn btn-danger" onclick="return confirm('Delete this order?');">Delete</a>
        </td>
      </tr>
      <?php
          }
        }else{
          echo '<tr><td colspan="12" class="text-center">No orders placed yet!</td></tr>';
        }
      ?>
    </tbody>
  </table>
</div>

</div>


</section>













<script src="js/admin_script.js"></script>

</body>
</html>