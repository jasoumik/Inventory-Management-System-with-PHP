<?php
include('db.php');
if(isset($_SESSION['type'])){
   header("Location:index.php") ;
}
$msg= '';
if(isset($_POST["login"])){
    $qry="
    SELECT * FROM user_details WHERE user_mail = :user_email
    ";
    $smt=$connect->prepare($qry);
    $smt->execute(
        array(
            'user_email'=> $_POST["user_email"]
        )
    );
    $count = $smt->rowCount();
    if($count>0){
       $result=$smt->fetchAll();
       foreach($result as $row){
           if(isset($_POST['user_password'],$row["user_pass"])){
                if($row['user_status']=='active'){
                     $_SESSION['type']=$row['user_type'];
                     $_SESSION['user_id']= $row['user_id'];
                     $_SESSION['user_name']=$row['user_name'];
                     header("Location:index.php");
                }else {
                    $msg="<label>Account is disabled,Contact Master</label>";
                }
           }else {
               $msg ="<label>Wrong Password</label>";
           }
       }
    }
    else {
        $msg="<label>Wrong Email Address</label>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body style="background-image:url('style.jpg')">
   <br>
   <div class="container">
       <h2 align="center" style="color: white;">
           Inventory Management System
       </h2>
       <br>
       <div class="panel panel-default">
           <div class="panel-heading" style="color: white;">
               Login
           </div>
           <div class="panel-body">
           <form action="" method="post">
               <?php echo $msg ?>
               <div class="form-group">
                   <label for="" style="color: white;">User Email</label>
                   <input type="text" name="user_email" class="form-control" required>
               </div>
               <div class="form-group">
                   <label for="" style="color: white;">Password</label>
                   <input type="text" name="user_password" class="form-control" required>
               </div>
               <div class="form-group">
                   <input type="submit" name="login" class="btn btn-info" value="Login">
               </div>
           </form>
           </div>
        
       </div>
      <br>
      <br>
      <a href="https://jasoumik.com" target="_blank" style="background-image:url('stylenew.jpg')">DM : www.jasoumik.com 2020</a>
   </div> 
</body>
</html>