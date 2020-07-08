<?php
include("db.php");
if(!isset($_SESSION["type"])){
    header("Location:login.php");
}

$qry="
SELECT * FROM user_details WHERE user_id = '".$_SESSION["user_id"]."'
";
$stm=$connect->prepare($qry);
$stm->execute();
$result = $stm->fetchAll();
$name='';
$email='';
$user_id='';
foreach($result as $row){
    $name = $row["user_name"];
    $email = $row["user_mail"];
}
include('header.php');
?>
<div class="panel panel-default">
    <div class="panel-heading">
        Edit Your Profile
    </div>
    <div class="panel-body">
        <form action="" method="post" id="edit_profile">
            <span id="msg"></span>
            <div class="form-group">
               <label for="">Name</label> 
               <input type="text" name="user_name" id="user_name" class="form-control"
               value="<?php echo $name;?>" required>
            </div>
            <div class="form-group">
               <label for="">Email</label> 
               <input type="text" name="user_email" id="user_email" class="form-control"
               value="<?php echo $email;?>" required>
            </div>
            <hr>
            <label for="">Leave this Blank if you dont want to change</label>
            <div class="form-group">
               <label for="">New Password</label> 
               <input type="text" name="user_new_password"
                id="user_new_password" class="form-control"
               >
            </div>
            <div class="form-group">
               <label for="">Re-Enter Password</label> 
               <input type="text" name="user_reenter_password"
                id="user_reenter_password" class="form-control"
               >
               <span id="error_password"></span>
            </div>
            <div class="form-group">
                   <input type="submit" name="edit_profile" 
                   id="edit_profile_submit" class="btn btn-info" value="Edit Profile">
               </div>
        </form>
    </div>
</div>
<?php
include("profilejs.php");
?>