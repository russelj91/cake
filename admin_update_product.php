<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   $details = mysqli_real_escape_string($conn, $_POST['details']);

   mysqli_query($conn, "UPDATE `products` SET name = '$name', details = '$details', price = '$price' WHERE id = '$update_p_id'") or die('query failed');

   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folter = 'uploaded_img/'.$image;
   $old_image = $_POST['update_p_image'];
   
   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'image file size is too large!';
      }else{
         mysqli_query($conn, "UPDATE `products` SET image = '$image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($image_tmp_name, $image_folter);
         unlink('uploaded_img/'.$old_image);
         $message[] = 'image updated successfully!';
      }
   }

   $message[] = 'product updated successfully!';

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
      <title>MarigoldPH</title>

</head>
<body>
   
<?php @include 'admin_header.php'; ?>
<div class="container">
<section class="update-product">

<?php

   $update_id = $_GET['update'];
   $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('query failed');
   if(mysqli_num_rows($select_products) > 0){
      while($fetch_products = mysqli_fetch_assoc($select_products)){
?>
<div class="row">
   <div class="col-md my-5">
<div class="card">
   <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" class="card-img-top" alt="">
   <div class="card-body">
      <form action="" method="post" enctype="multipart/form-data">
         <input type="hidden" value="<?php echo $fetch_products['id']; ?>" name="update_p_id">
         <input type="hidden" value="<?php echo $fetch_products['image']; ?>" name="update_p_image">
         <div class="form-group">
            <input type="text" class="form-control" value="<?php echo $fetch_products['name']; ?>" required placeholder="Update product name" name="name">
         </div>
         <div class="form-group">
            <input type="number" min="0" class="form-control" value="<?php echo $fetch_products['price']; ?>" required placeholder="Update product price" name="price">
         </div>
         <div class="form-group">
            <textarea name="details" class="form-control" required placeholder="Update product details" cols="30" rows="5"><?php echo $fetch_products['details']; ?></textarea>
         </div>
         <div class="form-group">
            <input type="file" accept="image/jpg, image/jpeg, image/png" class="form-control-file" name="image">
         </div>
         <div class="form-group">
            <input type="submit" value="Update Product" name="update_product" class="btn btn-secondary">
            <a href="admin_products.php" class="btn btn-secondary">Prvious page</a>
         </div>
      </form>
   </div>
</div>

<?php
      }
   }else{
      echo '<p class="empty">no update product select</p>';
   }
?>
</div>
</div>
</section>



</div>









<script src="js/admin_script.js"></script>

</body>
</html>