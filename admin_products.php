<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   $details = mysqli_real_escape_string($conn, $_POST['details']);
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folter = 'uploaded_img/'.$image;

   $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'product name already exist!';
   }else{
      $insert_product = mysqli_query($conn, "INSERT INTO `products`(name, details, price, image) VALUES('$name', '$details', '$price', '$image')") or die('query failed');

      if($insert_product){
         if($image_size > 2000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name, $image_folter);
            $message[] = 'product added successfully!';
         }
      }
   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $select_delete_image = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `wishlist` WHERE pid = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `cart` WHERE pid = '$delete_id'") or die('query failed');
   header('location:admin_products.php');

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
<div class="container">
<section class="add-products">
<div class="row">
   <div class="col-md-5 mx-auto rounded shadow my-5 py-5 text-center">
<form action="" method="POST" enctype="multipart/form-data">
  <h3 class="mb-3">Add New Product</h3>
  <div class="form-group">
    <label for="product-name">Product Name</label>
    <input type="text" class="form-control" id="product-name" required placeholder="Enter product name" name="name">
  </div>
  <div class="form-group">
    <label for="product-price">Product Price</label>
    <input type="number" min="0" class="form-control" id="product-price" required placeholder="Enter product price" name="price">
  </div>
  <div class="form-group">
    <label for="product-details">Product Details</label>
    <textarea name="details" class="form-control" required placeholder="Enter product details" cols="30" rows="10"></textarea>
  </div>
  <div class="form-group my-2">
    <label for="product-image">Product Image</label>
    <input type="file" accept="image/jpg, image/jpeg, image/png" required class="form-control-file" id="product-image" name="image">
  </div>
  <button type="submit" class="btn text-light" name="add_product">Add Product</button>
</form>
</div>
</div>

</section>

<section class="show-products">
<div class="row mt-3">

   <?php
      $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
      if(mysqli_num_rows($select_products) > 0){
         while($fetch_products = mysqli_fetch_assoc($select_products)){
   ?>
   <div class="col-md-3 mb-4">
      <div class="card">
         <img class="card-img-top" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
         <div class="card-body">
            <h5 class="card-title"><?php echo $fetch_products['name']; ?></h5>
            <p class="card-text"><?php echo $fetch_products['details']; ?></p>
            <div class="d-flex justify-content-between align-items-center">
               <div class="price">₱<?php echo $fetch_products['price']; ?></div>
               <div class="btn-group">
                  <a href="admin_update_product.php?update=<?php echo $fetch_products['id']; ?>" class="btn btn-sm btn-outline-secondary">Update</a>
                  <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="btn btn-sm btn-outline-secondary" onclick="return confirm('Delete this product?');">Delete</a>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No products added yet!</p>';
      }
   ?>
 
</div>

   

</section>

   </div>









<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
<script src="js/admin_script.js"></script>

</body>
</html>