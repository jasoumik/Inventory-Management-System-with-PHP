<?php
$connect = new PDO("mysql:host=localhost;dbname=inventory","root","root");
session_start();
function get_total_records($connect){
    $qry="
    SELECT * FROM user_details WHERE user_type='user'
    ";
    $stm=$connect->prepare($qry);
    $stm->execute();
    return $stm->rowCount();
}
function get_total_cat_records($connect){
    $qry="
    SELECT * FROM category
    ";
    $stm=$connect->prepare($qry);
    $stm->execute();
    return $stm->rowCount();
}
function get_total_brand_records($connect){
    $qry="
    SELECT * FROM brand
    ";
    $stm=$connect->prepare($qry);
    $stm->execute();
    return $stm->rowCount();
}
function fill_category_list($connect){
    $qry="
    SELECT * FROM category WHERE category_status ='active'
    ORDER BY category_name ASC
    ";
    $stm=$connect->prepare($qry);
    $stm->execute();
    $result =$stm->fetchAll();
    $output ='';
    foreach($result as $row){
        $output .='<option value="'.$row["category_id"].'">'.$row["category_name"].'</option>';
    }
    return $output;
}

function get_total_pdt_records($connect){
    $qry="
    SELECT * FROM product
    ";
    $stm=$connect->prepare($qry);
    $stm->execute();
    return $stm->rowCount();
}
function fill_brand_list($connect,$categpry_id){
    $qry="
    SELECT * FROM brand
    WHERE brand_status='active' AND category_id ='".$categpry_id."'
    ORDER BY brand_name ASC
    ";
    $stm=$connect->prepare($qry);
    $stm->execute();
    $result =$stm->fetchAll();
    $output ='<option value="">Select Brand</option>';
    foreach($result as $row){
        $output .='<option value="'.$row["brand_id"].'">'.$row["brand_name"].'</option>';
    }
    return $output;
}
function get_user_name($connect, $user_id){
    $qry = "
    SELECT user_name FROM user_details WHERE user_id = '".$user_id."'
    ";
    $stm = $connect->prepare($qry);
    $stm->execute();
    $result = $stm->fetchAll();
    foreach($result as $row)
    {
    return $row['user_name'];
    }
}
function get_total_order_records($connect)
{
$stm = $connect->prepare("SELECT * FROM inventory_order");
$stm->execute();
return $stm->rowCount();
}
function fill_pdt_list($connect){
    $qry="
    SELECT * FROM product WHERE product_status ='active'
    ORDER BY product_name ASC
    ";
    $stm=$connect->prepare($qry);
    $stm->execute();
    $result =$stm->fetchAll();
    $output ='';
    foreach($result as $row){
        $output .='<option value="'.$row["product_id"].'">'.$row["product_name"].'</option>';
    }
    return $output;
}
function fetch_pdt_dtls($pdt_id,$connect){
    $qry="
    SELECT * FROM product WHERE product_id='".$pdt_id."'
    ";
    $stm=$connect->prepare($qry);
    $stm->execute();
    $result =$stm->fetchAll();
    foreach($result as $row){
        $output['product_name']=$row['product_name'];
        $output['quantity']=$row['product_qnty'];
        $output['price']=$row['product_base_price'];
        $output['tax']=$row['product_tax'];
    }
    return $output;
}
function available_pdt_qnty($connect,$pdt_id){
    $pdt_data= fetch_pdt_dtls($pdt_id,$connect);
    $qry ="
    SELECT inventory_order_product.quantity FROM inventory_order_product
    INNER JOIN inventory_order ON inventory_order.invent_ordr_id=
    inventory_order_product.inventory_order_id
    WHERE inventory_order_product.product_id ='".$pdt_id."'
    AND inventory_order.invent_ordr_status='active'
    ";
    $stm=$connect->prepare($qry);
    $stm->execute();
    $result =$stm->fetchAll();
    $total=0;
    foreach($result as $row){
       $total=$total+$row['quantity'];
    }
    $available_qnty = intval($pdt_data['quantity'])-intval($total);
    if($available_qnty==0){
        $update_qry="UPDATE product SET
        product_status='inactive'
        WHERE product_id='".$pdt_id."'
        ";
        $stm=$connect->prepare($qry);
        $stm->execute();
    }
    return $available_qnty;
}
function count_total_user($connect){
    $qry="
    SELECT * FROM user_details WHERE user_status='active'
    ";
    $stm=$connect->prepare($qry);
    $stm->execute();
    return $stm->rowCount();
}
function count_total_cat($connect){
    $qry="
    SELECT * FROM category WHERE category_status='active'
    ";
    $stm=$connect->prepare($qry);
    $stm->execute();
    return $stm->rowCount();
}
function count_total_brand($connect){
    $qry="
    SELECT * FROM brand WHERE brand_status='active'
    ";
    $stm=$connect->prepare($qry);
    $stm->execute();
    return $stm->rowCount();
}
function count_total_pdt($connect){
    $qry="
    SELECT * FROM product WHERE product_status='active'
    ";
    $stm=$connect->prepare($qry);
    $stm->execute();
    return $stm->rowCount();
}

function count_total_order_value($connect)
{
 $qry = "
 SELECT sum(invent_ordr_total) as total_order_value FROM inventory_order 
 WHERE invent_ordr_status='active'
 ";
 if($_SESSION['type'] == 'user')
 {
  $qry .= ' AND user_id = "'.$_SESSION["user_id"].'"';
 }
 $stm = $connect->prepare($qry);
 $stm->execute();
 $result = $stm->fetchAll();
 foreach($result as $row)
 {
  return number_format($row['total_order_value'], 2);
 }
}

function count_cash_value($connect)
{
 $qry = "
 SELECT sum(invent_ordr_total) as total_order_value FROM inventory_order 
 WHERE payment_status = 'cash' 
 AND invent_ordr_status='active'
 ";
 if($_SESSION['type'] == 'user')
 {
  $qry .= ' AND user_id = "'.$_SESSION["user_id"].'"';
 }
 $stm = $connect->prepare($qry);
 $stm->execute();
 $result = $stm->fetchAll();
 foreach($result as $row)
 {
  return number_format($row['total_order_value'], 2);
 }
}

function count_credit_value($connect)
{
 $qry = "
 SELECT sum(invent_ordr_total) as total_order_value FROM inventory_order WHERE payment_status = 'credit' AND invent_ordr_status='active'
 ";
 if($_SESSION['type'] == 'user')
 {
  $qry .= ' AND user_id = "'.$_SESSION["user_id"].'"';
 }
 $stm = $connect->prepare($qry);
 $stm->execute();
 $result = $stm->fetchAll();
 foreach($result as $row)
 {
  return number_format($row['total_order_value'], 2);
 }
}
function get_user_wise_total_order($connect){
   $qry='SELECT sum(inventory_order.invent_ordr_total) as order_total,
   SUM(CASE WHEN inventory_order.payment_status="cash" THEN
   inventory_order.invent_ordr_total ELSE 0 END) AS cash_order_total,
   SUM(CASE WHEN inventory_order.payment_status="credit" THEN
   inventory_order.invent_ordr_total ELSE 0 END) AS credit_order_total,
   user_details.user_name FROM inventory_order
   INNER JOIN user_details ON user_details.user_id = inventory_order.user_id
   WHERE inventory_order.invent_ordr_status="active"
   GROUP BY inventory_order.user_id
   '; 
    $stm = $connect->prepare($qry);
    $stm->execute();
    $result = $stm->fetchAll();
    $output='';
    $output .='<div class="table-responsive">
    <table class="table table-bordered table-striped">
    <tr>
    <th>User Name</th>
    <th>Total Order value</th>
    <th>Total Cash Order</th>
    <th>Total Credit Order</th>
    </tr>';
    
   
    $total_order =0;
    $total_cash_order =0;
    $total_credit_order=0;
    foreach($result as $row){
        $output .=' <tr>
        <td>'.$row['user_name'].'</td>
        <td align="right">$ '.$row['order_total'].'</td>
        <td align="right">$ '.$row['cash_order_total'].'</td>
        <td align="right">$ '.$row['credit_order_total'].'</td>
        </tr>';
       
        $total_order=$total_order+$row["order_total"];
        $total_cash_order =$total_cash_order+$row["cash_order_total"];
        $total_credit_order=$total_credit_order+$row["credit_order_total"];
    }
    $output .=' <tr>
    <td align="right">Total</td>
    <td align="right">$ '.$total_order.'</td>
    <td align="right">$ '.$total_cash_order.'</td>
    <td align="right">$ '.$total_credit_order.'</td>
    </tr>
    </table>
    </div>';
   return $output;
}
?>