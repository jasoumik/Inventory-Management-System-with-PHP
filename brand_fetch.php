<?php
include('db.php');
$qry='';
$output=array();

$qry .="SELECT * FROM brand
INNER JOIN category ON category.category_id=brand.category_id
";
if(isset($_POST["search"]["value"])){
    $qry .='WHERE brand.brand_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $qry .='OR category.category_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $qry .='OR brand.brand_status LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"])){
    $qry .='ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else{
    $qry .='ORDER BY brand.brand_id DESC ';
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
    if($row["brand_status"]=='active'){
        $status= '<span class="label label-success">Active</span>';
    }
    else {
        $status= '<span class="label label-danger">Inactive</span>';
    }
    $sub_array=array();
    $sub_array[] = $row['brand_id'];
    $sub_array[] = $row['category_name'];
    $sub_array[] = $row['brand_name'];
    $sub_array[] = $status;
    $sub_array[] = '<button type="button" name="update" id="'.$row["brand_id"].'" 
    class="btn btn-warning btn-xs update">Update</button>';
    $sub_array[] = '<button type="button" name="delete" id="'.$row["brand_id"].'" 
    class="btn btn-danger btn-xs delete" data-status="'.$row["brand_status"].'">Delete</button>';
    $data[]=$sub_array;

}
$output=array(
    "draw" => intval($_POST["draw"]),
    "recordsTotal" => $filtered_rows,
    "recordsFiltered" => get_total_brand_records($connect),
    "data" => $data
);
echo json_encode($output);
?>