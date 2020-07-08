<?php
include('db.php');
if(isset($_POST['btn_action'])){
    
    if($_POST['btn_action']=='Add'){
        $qry="
        INSERT INTO inventory_order(user_id,
        invent_ordr_total,invent_ordr_date,invent_ordr_name,invent_ordr_adrs,
        payment_status,invent_ordr_status,invent_ordr_created_date)
        VALUES(:user_id,
        :invent_ordr_total,:invent_ordr_date,:invent_ordr_name,:invent_ordr_adrs,
        :payment_status,:invent_ordr_status,:invent_ordr_created_date)
        ";
        $stm=$connect->prepare($qry);
        $stm->execute(
            array(
                ':user_id'   => $_SESSION["user_id"],
                ':invent_ordr_total'   =>0,
                ':invent_ordr_date'   => $_POST["ordr_date"],
                ':invent_ordr_name'   => $_POST["ordr_name"],
                ':invent_ordr_adrs'   => $_POST["ordr_adrs"],
                ':payment_status'   => $_POST["payment_status"],
                ':invent_ordr_status'   =>'active',
                ':invent_ordr_created_date'   => date("Y-m-d")
            )
        );
        $result = $stm->fetchAll();
        $stm=$connect->query("SELECT LAST_INSERT_ID()");
        $invnt_order_id =$stm->fetchColumn();
        if(isset($invnt_order_id)){
           $total_amnt=0; 
        
        for ($count=0; $count<count($_POST["product_id"]) ; $count++) { 
            $pdt_dtls = fetch_pdt_dtls($_POST['product_id'][$count],$connect);
            $sub_qry="INSERT INTO inventory_order_product(inventory_order_id,product_id,
            quantity,price,tax)
            VALUES(:inventory_order_id,:product_id,:quantity,:price,:tax)
            ";
            $stm=$connect->prepare($sub_qry);
            $stm->execute( 
                array(
                ':inventory_order_id'=>$invnt_order_id,
                ':product_id'=>$_POST['product_id'][$count],
                ':quantity'=>$_POST['quantity'][$count],

                ':price'=>$pdt_dtls['price'],
                ':tax'=>$pdt_dtls['tax']
                )
            );
            $base_price = $pdt_dtls['price']*$_POST['quantity'][$count];
            $tax = ($base_price/100)*$pdt_dtls['tax'];
            $total_amnt = $total_amnt + ($base_price+$tax);
        }
        $update_qry="UPDATE inventory_order
        SET invent_ordr_total ='".$total_amnt."'
        WHERE invent_ordr_id='".$invnt_order_id."'
        ";
        $stm=$connect->prepare($update_qry);
        $stm->execute();
        $result = $stm ->fetchAll();
        if(isset($result)){
            echo 'Order Created ';
            echo '<br />';
            echo $total_amnt;
            echo '<br />';
            echo $invnt_order_id;
        }
    }
}
    if($_POST['btn_action'] == 'fetch_single')
        {
        $qry = "
        SELECT * FROM inventory_order WHERE invent_ordr_id = :invent_ordr_id
        ";
        $stm = $connect->prepare($qry);
        $stm->execute(
        array(
            ':invent_ordr_id' => $_POST["invent_ordr_id"]
        )
        );
        $result = $stm->fetchAll();
        $output=array();
        foreach($result as $row)
        {
        $output['ordr_name'] = $row['invent_ordr_name'];
        $output['ordr_date'] = $row['invent_ordr_date'];
        $output['ordr_adrs'] = $row['invent_ordr_adrs'];
        $output['payment_status'] = $row['payment_status'];
        }
        $sub_qry=" SELECT * FROM inventory_order_product 
        WHERE inventory_order_id = '".$_POST["invent_ordr_id"]."' 
        ";
        $stm = $connect->prepare($sub_qry);
        $stm->execute();
        $sub_result = $stm->fetchAll();
        $product_details='';
        $count =0;
        foreach($sub_result as $sub_row)
        {
            $product_details .='<script>$(document).ready(function(){$("#product_id'.$count.'").selectpicker("val", '.$sub_row["product_id"].');$(".selectpicker").selectpicker();});</script><span id="row'.$count.'"><div class="row"><div class="col-md-7"><select name="product_id[]" id="product_id'.$count.'"class="form-control selectpicker" data-live-search="true" required>'.fill_pdt_list($connect).'</select><input type="hidden" name="hidden_product_id[]" id="hidden_product_id'.$count.'" value="'.$sub_row["product_id"].'"></div><div class="col-md-3"><input type="text" name="quantity[]" class="form-control" value="'.$sub_row["quantity"].'" required ></div><div class="col-md-2">';
            if($count == '')
            {
                $product_details .='<button type="button" name="add_more" id="add_more" class="btn btn-success btn-xs">+</button>';
            }
            else
            {
                $product_details .= '<button type="button" name="remove" id="'.$count.'" class="btn btn-danger btn-xs remove">-</button>';
            }
            $product_details .= '</div></div></div></span>';
            $count=$count+1;
    
        }
        $output['pdt_dtls'] = $product_details;
        echo json_encode($output);
        }
        if($_POST['btn_action'] == 'Edit'){
                $delete_qry = "DELETE FROM inventory_order_product 
                WHERE inventory_order_id = '".$_POST["ordr_id"]."' 
                ";
                $stm = $connect->prepare($delete_qry);
                $stm->execute();
                $delete_result = $stm->fetchAll();
                if(isset($delete_result))
                {
                    $total_amnt=0; 
        
                    for ($count=0; $count<count($_POST["product_id"]) ; $count++) { 
                        $pdt_dtls = fetch_pdt_dtls($_POST['product_id'][$count],$connect);
                        $sub_qry="INSERT INTO inventory_order_product(inventory_order_id,product_id,
                        quantity,price,tax)
                        VALUES(:inventory_order_id,:product_id,:quantity,:price,:tax)
                        ";
                        $stm=$connect->prepare($sub_qry);
                        $stm->execute( 
                            array(
                            ':inventory_order_id'=>$_POST["ordr_id"],
                            ':product_id'=>$_POST['product_id'][$count],
                            ':quantity'=>$_POST['quantity'][$count],
            
                            ':price'=>$pdt_dtls['price'],
                            ':tax'=>$pdt_dtls['tax']
                            )
                        );
                        $base_price = $pdt_dtls['price']*$_POST['quantity'][$count];
                        $tax = ($base_price/100)*$pdt_dtls['tax'];
                        $total_amnt = $total_amnt + ($base_price+$tax);
                    }
                    $update_qry="UPDATE inventory_order 
                    SET invent_ordr_name = :inventory_order_name, 
                    invent_ordr_date = :inventory_order_date, 
                    invent_ordr_adrs = :inventory_order_address, 
                    invent_ordr_total = :inventory_order_total, 
                    payment_status = :payment_status
                    WHERE invent_ordr_id = :inventory_order_id
                    ";
                    $stm=$connect->prepare($update_qry);
                    $stm->execute(
                     array(
                      ':inventory_order_name'   => $_POST["ordr_name"],
                      ':inventory_order_date'   => $_POST["ordr_date"],
                      ':inventory_order_address'  => $_POST["ordr_adrs"],
                      ':inventory_order_total'  => $total_amnt,
                      ':payment_status'    => $_POST["payment_status"],
                      ':inventory_order_id'   => $_POST["ordr_id"]
                     )
                    );
                   
                   
                    $result = $stm ->fetchAll();
                    if(isset($result)){
                        echo 'Order Edited ';
                        echo '<br />';
                        echo $total_amnt;
                    
                    }
                }
                }
                if($_POST['btn_action'] == 'delete')
                {
                 $status = 'active';
                 if($_POST['status'] == 'active')
                 {
                  $status = 'inactive';
                 }
                 $qry = "
                 UPDATE inventory_order 
                 SET invent_ordr_status = :inventory_order_status 
                 WHERE invent_ordr_id = :inventory_order_id
                 ";
                 $stm = $connect->prepare($qry);
                 $stm->execute(
                  array(
                   ':inventory_order_status' => $status,
                   ':inventory_order_id'  => $_POST["inventory_order_id"]
                  )
                 );
                 $result = $stm->fetchAll();
                 if(isset($result))
                 {
                  echo 'Order status changed to ' . $status;
                 }
                }
  }
?>