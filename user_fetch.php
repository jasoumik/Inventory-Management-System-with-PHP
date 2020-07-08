<?php
include('db.php');
$qry='';
$output=array();

$qry .="SELECT * FROM user_details
WHERE user_type ='user' AND
";
if(isset($_POST["search"]["value"])){
    $qry .='(user_mail LIKE "%'.$_POST["search"]["value"].'%" ';
    $qry .='OR user_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $qry .='OR user_status LIKE "%'.$_POST["search"]["value"].'%") ';
}
if(isset($_POST["order"])){
    $qry .='ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else{
    $qry .='ORDER BY user_id DESC ';
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
    if($row["user_status"]=='active'){
        $status= '<span class="label label-success">Active</span>';
    }
    else {
        $status= '<span class="label label-danger">Inactive</span>';
    }
    $sub_array=array();
    $sub_array[] = $row['user_id'];
    $sub_array[] =$row['user_mail'];
    $sub_array[] = $row['user_name'];
    $sub_array[] = $status;
    $sub_array[] = '<button type="button" name="update" id="'.$row["user_id"].'" 
    class="btn btn-warning btn-xs update">Update</button>';
    $sub_array[] = '<button type="button" name="delete" id="'.$row["user_id"].'" 
    class="btn btn-danger btn-xs delete" data-status="'.$row["user_status"].'">Delete</button>';
    $data[]=$sub_array;

}
$output=array(
    "draw" => intval($_POST["draw"]),
    "recordsTotal" => $filtered_rows,
    "recordsFiltered" => get_total_records($connect),
    "data" => $data
);
echo json_encode($output);
?>