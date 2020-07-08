<?php
include('db.php');
if(isset($_POST['btn_action'])){
    if($_POST['btn_action']=='Add'){
        $qry="
        INSERT INTO category(category_name, category_status)
        VALUES(:category_name,:category_status)
        ";
        $stm=$connect->prepare($qry);
        $stm->execute(
            array(
                ':category_name'   => $_POST["cat_name"],
            
               ':category_status'  => 'active'
            )
        );
        $result = $stm->fetchAll();
        if(isset($result)){
           echo 'New Category Added'; 
        }
    }

    if($_POST['btn_action']=='fetch_single'){
        $qry="
        SELECT * FROM category WHERE category_id = :category_id
        ";
        $stm=$connect->prepare($qry);
        $stm->execute(
            array(
                ':category_id' => $_POST["cat_id"]
            )
        );
       $result =$stm->fetchAll();
       foreach($result as $row){
           $output['cat_name'] =$row['category_name'];
       }
       echo json_encode($output);
    }
    if($_POST['btn_action'] == 'Edit')
    {

      $qry = "
      UPDATE category SET 
       category_name = '".$_POST["cat_name"]."'

       WHERE category_id = '".$_POST["cat_id"]."'
      ";
     
     $stm = $connect->prepare($qry);
     $stm->execute();
     $result = $stm->fetchAll();
     if(isset($result))
     {
      echo 'Category Edited';
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
      UPDATE category SET category_status = :category_status 
       WHERE category_id = :category_id
      ";
    
     
     $stm = $connect->prepare($qry);
     $stm->execute(
         array(
             ':category_status' => $status,
             ':category_id'  =>$_POST["cat_id"]
         )
     );
     $result = $stm->fetchAll();
     if(isset($result))
     {
      echo 'Category Status Changed To ' .$status;
     }
    }
}