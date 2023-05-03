<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

<nav class="navbar navbar-expand-lg">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mx-auto">
      <li class="nav-item">
        <a class="nav-link" href="admin_page.php">Records</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin_products.php">List of Products</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin_orders.php">Orders and Records</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin_users.php">List of Users</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin_contacts.php">Messages</a>
      </li>
    </ul>

  </div>
  
</nav>




</header>