<?php
include('db.php');
$qry='';
$output=array();

$qry .="SELECT * FROM product
INNER JOIN brand ON brand.brand_id=product.brand_id
INNER JOIN category ON category.category_id=product.category_id
INNER JOIN user_details ON user_details.user_id=product.product_entry_by
";
if(isset($_POST["search"]["value"])){
    $qry .='WHERE brand.brand_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $qry .='OR category.category_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $qry .='OR product.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $qry .='OR product.product_qnty LIKE "%'.$_POST["search"]["value"].'%" ';
    $qry .='OR user_details.user_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $qry .='OR product.product_id LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"])){
    $qry .='ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else{
    $qry .='ORDER BY product_id DESC ';
}
if($_POST["length"] !=-1){
    $qry .='LIMIT ' . $_POST['start'] . ', ' .$_POST['length'];
}
$stm=$connect->prepare($qry);
$stm->execute();
$result= $stm->fetchAll();
$data=array();
$filtered_rows=$stm->rowCount();
foreach($result as $row){
    $status ='';
    if($row["product_status"]=='active'){
        $status= '<span class="label label-success">Active</span>';
    }
    else {
        $status= '<span class="label label-danger">Inactive</span>';
    }
    $sub_array=array();
    $sub_array[] = $row['product_id'];
  
    $sub_array[] = $row['category_name'];
    $sub_array[] = $row['brand_name'];
    $sub_array[] = $row['product_name'];
    $sub_array[] = available_pdt_qnty($connect,$row["product_id"]).' '.$row['product_unit'];
    $sub_array[] = $row['user_name'];
    $sub_array[] = $status;
    $sub_array[] = '<button type="button" name="view" id="'.$row["product_id"].'" 
    class="btn btn-info btn-xs view">View</button>';
    $sub_array[] = '<button type="button" name="update" id="'.$row["product_id"].'" 
    class="btn btn-warning btn-xs update">Update</button>';
    $sub_array[] = '<button type="button" name="delete" id="'.$row["product_id"].'" 
    class="btn btn-danger btn-xs delete" data-status="'.$row["product_status"].'">Delete</button>';
    $data[]=$sub_array;

}
$output=array(
    "draw" => intval($_POST["draw"]),
    "recordsTotal" => $filtered_rows,
    "recordsFiltered" => get_total_pdt_records($connect),
    "data" => $data
);
echo json_encode($output);
?>