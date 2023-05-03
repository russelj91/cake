<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_contacts.php');
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

<section class="messages">
<div class="container my-5">
   <h1 class="title">Messsages </h1>

   <div class="table-responsive">
  <table class="table">
    <thead>
      <tr>
        <th>User ID</th>
        <th>Name</th>
        <th>Number</th>
        <th>Email</th>
        <th>Message</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
        if(mysqli_num_rows($select_message) > 0){
          while($fetch_message = mysqli_fetch_assoc($select_message)){
      ?>
      <tr>
        <td><?php echo $fetch_message['user_id']; ?></td>
        <td><?php echo $fetch_message['name']; ?></td>
        <td><?php echo $fetch_message['number']; ?></td>
        <td><?php echo $fetch_message['email']; ?></td>
        <td><?php echo $fetch_message['message']; ?></td>
        <td><a href="admin_contacts.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('delete this message?');" class="delete-btn btn">Delete</a></td>
      </tr>
      <?php
          }
        }else{
          echo '<tr><td colspan="6" class="text-center">you have no messages!</td></tr>';
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