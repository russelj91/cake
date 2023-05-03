<?php

@include 'config.php';



if(isset($_POST['add_to_wishlist'])){

   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   
   $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_wishlist_numbers) > 0){
       $message[] = 'already added to wishlist';
   }elseif(mysqli_num_rows($check_cart_numbers) > 0){
       $message[] = 'already added to cart';
   }else{
       mysqli_query($conn, "INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
       $message[] = 'product added to wishlist';
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
       $message[] = 'already added to cart';
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
      <link rel="stylesheet" href="design/style.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
      <title>CakesPH</title>

</head>
<body>
<?php @include 'header.php'; ?>

<section class="home">
   <div class="container text-center">
   <div class=" py-5 text-start ">
      <h1 class="fw-bold text-secondary display-5 pt-5 mt-5">CakesPH</h1>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat odio neque harum, 
         <br/>atque non minima ratione nulla ipsum corrupti blanditiis!<br /> Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit, doloribus..</p>
      <a href="#about" class="btn text-light">My Services</a>
   
   </div>
   </div>


</section>

<section class="products">
   <div class="container text-center">
   <h1 class="fw-bold mt-5 pt-5">Newly Added Cakes</h1>

   <div class="container rounded shadow py-5">
   <div class="row">
      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
     <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4 d-flex">
  <div class="card">
    <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>">
      <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" class="card-img-top">
    </a>
    <div class="card-body">
      <h5 class="card-title"><?php echo $fetch_products['name']; ?></h5>
      <p class="card-text text-success">₱: <?php echo $fetch_products['price']; ?></p>
      <form action="" method="POST">

        <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
        <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
        <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
        <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">

      </form>
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

</div>


   </div>
</section>


<section>
   <div  class="container my-5 py-5">
   <h2 class="text-center my-5 py-5" id="about">About</h2>
    <div class="row">
        <div class="col-md-6 ">
            <div class="image">
            <img src="images/pexels-karolina-grabowska-4040691.jpg" alt="" width="550px" class="img-fluid rounded">
            </div>
        </div>
        <div class="col-md-6">
        <div class="content">
            <h3>CakesPH</h3>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis 
               deleniti enim id, voluptate obcaecati facilis. Non ut reprehenderit sed nobis.</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam velit ipsa modi, quos non atque sint dolorem ipsam laborum amet?.</p>
            <a href="shop.php" class="btn text-light my-1">Shop Now</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 order-md-2">
        <div class="image">
        <img src="images/cake.jpeg" alt="" width="550px" class="img-fluid rounded">
        </div>
    </div>

    <div class="col-md-6 my-5 py-5">
        <div class="content">
            <h3>Services offered</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia sed sint temporibus aliquid cum velit nulla dolorem, cumque unde perspiciatis?
               </p>
               <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus, dolor nesciunt adipisci animi eum vero
                   expedita assumenda a neque, consequuntur dicta quis aliquid ullam. Temporibus tenetur sapiente optio inventore rem!</p>
            <a href="contact.php" class="btn text-light my-1">Contact Us</a>
        </div>
    </div>
</div>

<div class="row my-5">
   <div class="container">
      Lorem ipsum dolor sit amet consectetur, adipisicing elit. Laboriosam sequi dolorem rerum vero, eos atque delectus incidunt, culpa expedita, nesciunt eaque dignissimos iure. Nostrum sapiente odit, dolore nihil quis atque.
       Voluptatibus animi reprehenderit inventore explicabo optio, tempore perferendis eum aut hic porro, delectus suscipit modi quia qui fuga, doloribus alias!
            </div>
      </div>
      </section>




<?php @include 'footer.php'; ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
<script src="js/script.js"></script>

</body>
</html>