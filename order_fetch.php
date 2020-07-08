<?php
include('db.php');
$qry = '';

$output = array();

$qry .= "
 SELECT * FROM inventory_order WHERE 
";

    if($_SESSION['type'] == 'user')
    {
    $qry .= 'user_id = "'.$_SESSION["user_id"].'" AND ';
    }

    if(isset($_POST["search"]["value"]))
    {
    $qry .= '(invent_ordr_id LIKE "%'.$_POST["search"]["value"].'%" ';
    $qry .= 'OR invent_ordr_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $qry .= 'OR invent_ordr_total LIKE "%'.$_POST["search"]["value"].'%" ';
    $qry .= 'OR invent_ordr_status LIKE "%'.$_POST["search"]["value"].'%" ';
    $qry .= 'OR invent_ordr_date LIKE "%'.$_POST["search"]["value"].'%") ';
    }

    if(isset($_POST["order"]))
    {
    $qry .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
    }
    else
    {
    $qry .= 'ORDER BY invent_ordr_id DESC ';
    }

    if($_POST["length"] != -1)
    {
    $qry .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $stm = $connect->prepare($qry);
    $stm->execute();
    $result = $stm->fetchAll();
    $data = array();
    $filtered_rows = $stm->rowCount();
    foreach($result as $row)
    {
    $payment_status = '';

    if($row['payment_status'] == 'cash')
    {
    $payment_status = '<span class="label label-primary">Cash</span>';
    }
    else
    {
    $payment_status = '<span class="label label-warning">Credit</span>';
    }

    $status = '';
    if($row['invent_ordr_status'] == 'active')
    {
    $status = '<span class="label label-success">Active</span>';
    }
    else
    {
    $status = '<span class="label label-danger">Inactive</span>';
    }
    $sub_array = array();
    $sub_array[] = $row['invent_ordr_id'];
    $sub_array[] = $row['invent_ordr_name'];
    $sub_array[] = $row['invent_ordr_total'];
    $sub_array[] = $payment_status;
    $sub_array[] = $status;
    $sub_array[] = $row['invent_ordr_date'];
    if($_SESSION['type'] == 'master')
    {
    $sub_array[] = get_user_name($connect, $row['user_id']);
    }
    $sub_array[] = '<a href="view_order.php?pdf=1&order_id='.$row["invent_ordr_id"].'" class="btn btn-info btn-xs">View PDF</a>';
    $sub_array[] = '<button type="button" name="update" id="'.$row["invent_ordr_id"].'" class="btn btn-warning btn-xs update">Update</button>';
    $sub_array[] = '<button type="button" name="delete" id="'.$row["invent_ordr_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["invent_ordr_status"].'">Delete</button>';
    $data[] = $sub_array;
    }

  

    $output = array(
    "draw"       =>  intval($_POST["draw"]),
    "recordsTotal"   =>  $filtered_rows,
    "recordsFiltered"  =>  get_total_order_records($connect),
    "data"       =>  $data
    ); 

    echo json_encode($output);

?>
