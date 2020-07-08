<?php
include('db.php');
if(isset($_POST['btn_action'])){
    if($_POST['btn_action']=='Add'){
        $qry="
        INSERT INTO user_details(user_mail, user_pass, user_name, user_type, user_status)
        VALUES(:user_email, :user_password, :user_name, :user_type, :user_status)
        ";
        $stm=$connect->prepare($qry);
        $stm->execute(
            array(
               ':user_email'   => $_POST["user_email"],
               ':user_password'=> $_POST["user_password"],
                ':user_name'   => $_POST["user_name"],
               ':user_type'    => 'user',
               ':user_status'  => 'active'
            )
        );
        $result = $stm->fetchAll();
        if(isset($result)){
           echo 'New User Added'; 
        }
    }
    if($_POST['btn_action']=='fetch_single'){
        $qry="
        SELECT * FROM user_details WHERE user_id = :user_id
        ";
        $stm=$connect->prepare($qry);
        $stm->execute(
            array(
                ':user_id' => $_POST["user_id"]
            )
        );
       $result =$stm->fetchAll();
       foreach($result as $row){
           $output['user_email'] =$row['user_mail'];
           $output['user_name'] =$row['user_name'];
       }
       echo json_encode($output);
    }
    if($_POST['btn_action'] == 'Edit')
    {
     if($_POST['user_password'] != '')
     {
      $qry = "
      UPDATE user_details SET 
       user_name = '".$_POST["user_name"]."', 
       user_mail = '".$_POST["user_email"]."',
       user_pass = '".$_POST["user_password"]."' 
       WHERE user_id = '".$_POST["user_id"]."'
      ";
     }
     else
     {
      $qry = "
      UPDATE user_details SET 
       user_name = '".$_POST["user_name"]."', 
       user_mail = '".$_POST["user_email"]."'
       WHERE user_id = '".$_POST["user_id"]."'
      ";
     }
     $stm = $connect->prepare($qry);
     $stm->execute();
     $result = $stm->fetchAll();
     if(isset($result))
     {
      echo 'User Details Edited';
     }
    }
    if($_POST['btn_action'] == 'delete')
    {
        $status='Active';
     if($status == 'Active')
     {
        $status='Inactive';
    }
      $qry = "
      UPDATE user_details SET 
      user_status = :user_status 
       WHERE user_id = :user_id
      ";
    
     
     $stm = $connect->prepare($qry);
     $stm->execute(
         array(
             ':user_status' => $status,
             ':user_id'  =>$_POST["user_id"]
         )
     );
     $result = $stm->fetchAll();
     if(isset($result))
     {
      echo 'User Status Changed To ' .$status;
     }
    }
}
?>