<?php
include('db.php');
if(isset($_POST['user_name'])){
    if($_POST["user_new_password"]!=''){
        $qry="
        UPDATE user_details SET 
        user_name='".$_POST["user_name"]."',
        user_mail='".$_POST["user_email"]."',
        user_pass='".$_POST["user_new_password"]."'
        WHERE user_id= '".$_SESSION["user_id"]."'
        ";
    }
    else {
        $qry="
        UPDATE user_details SET 
        user_name='".$_POST["user_name"]."',
        user_mail='".$_POST["user_email"]."'
        WHERE user_id= '".$_SESSION["user_id"]."'
        ";
    }
    $stm=$connect->prepare($qry);
    $stm->execute();
    $result =$stm->fetchAll();
    if(isset($result)){
        echo '<div class="alert alert-success">Profile Edited Successfully</div>';
    }
}
?>