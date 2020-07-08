<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <!-- <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">   
    
</head>
<body style="background-image:url('style.jpg')" >
   <br>
   <div class="container">
       <h2 align="center" style="color: white;">Inventory Management System</h2>
       <nav class="navbar navbar-inverse">
           <div class="container-fluid">
               <div class="navbar-header">
                   <a href="index.php" class="navbar-brand">Home</a>
               </div>
               <ul class="nav navbar-nav">
                   <?php
                   if($_SESSION['type']=='master'){ ?>
                      <li><a href="user.php"><b>User</b></a></li>
                      <li><a href="category.php"><b>Category</b></a></li>
                      <li><a href="brand.php"><b>Brand</b></a></li>
                      <li><a href="product.php"><b>Product</b></a></li>
                      
                      <?php 
                   }
                   ?>
                   <li><a href="order.php"><b>Order</b></a></li> 
               </ul>
               <ul class="nav navbar-nav navbar-right">
                 <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                         <span class="label label-pill label-danger count"></span>
                        <?php echo $_SESSION["user_name"];?>
                        </a>
                        <ul class="dropdown-menu">
                        <li><a href="profile.php">Profile</a></li>
                      <li><a href="logout.php">Logout</a></li>
                        </ul>
                 </li>
               </ul>
           </div>
       </nav>
 
