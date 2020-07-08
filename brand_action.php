<?php
include('db.php');
if(isset($_POST['btn_action'])){
    if($_POST['btn_action']=='Add'){
        $qry="
        INSERT INTO brand(category_id,brand_name)
        VALUES(:category_id,:brand_name)
        ";
        $stm=$connect->prepare($qry);
        $stm->execute(
            array(
                ':category_id'   => $_POST["category_id"],
                ':brand_name'   => $_POST["brand_name"],
            )
        );
        $result = $stm->fetchAll();
        if(isset($result)){
           echo 'New brand Added'; 
        }
    }

    if($_POST['btn_action']=='fetch_single'){
        $qry="
        SELECT * FROM brand WHERE brand_id = :brand_id
        ";
        $stm=$connect->prepare($qry);
        $stm->execute(
            array(
                ':brand_id' => $_POST["brand_id"]
            )
        );
       $result =$stm->fetchAll();
       foreach($result as $row){
        $output['category_id'] =$row['category_id'];
           $output['brand_name'] =$row['brand_name'];
       }
       echo json_encode($output);
    }
    if($_POST['btn_action'] == 'Edit')
    {

      $qry = "UPDATE brand SET category_id = '".$_POST["category_id"]."',
         brand_name = '".$_POST["brand_name"]."'
       WHERE brand_id = '".$_POST["brand_id"]."'
      ";
     
     $stm = $connect->prepare($qry);
     $stm->execute();
     $result = $stm->fetchAll();
     if(isset($result))
     {
      echo 'Brand Name Edited';
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
      UPDATE brand SET brand_status = :brand_status 
       WHERE brand_id = :brand_id
      ";
    
     
     $stm = $connect->prepare($qry);
     $stm->execute(
         array(
             ':brand_status' => $status,
             ':brand_id'  =>$_POST["brand_id"]
         )
     );
     $result = $stm->fetchAll();
     if(isset($result))
     {
      echo 'Brand Status Changed To ' .$status;
     }
    }
}