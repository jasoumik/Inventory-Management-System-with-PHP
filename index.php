<?php
include('db.php');
if(!isset($_SESSION["type"])){
    header("Location:login.php");
}
include('header.php');
?>
 <br>
 <div class="row">
        <?php
        if($_SESSION["type"]=='master'){
        ?> 
        <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Total User</strong></div>
            <div class="panel-body" align="center">
                <h1><?php echo count_total_user($connect); ?></h1>
            </div>
        </div>
        </div>
        <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Total Category</strong></div>
            <div class="panel-body" align="center">
                <h1><?php echo count_total_cat($connect); ?></h1>
            </div>
        </div>
        </div>
        <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Total Brand</strong></div>
            <div class="panel-body" align="center">
                <h1><?php echo count_total_brand($connect); ?></h1>
            </div>
        </div>
        </div>
        <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Total Available Products</strong></div>
            <div class="panel-body" align="center">
                <h1><?php echo count_total_pdt($connect); ?></h1>
            </div>
        </div>
        </div>
        <?php 
        }
        ?> 
        <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Total Order Value</strong></div>
            <div class="panel-body" align="center">
                <h1>US$<?php echo count_total_order_value($connect); ?></h1>
            </div>
        </div>
        </div>
        <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Cash Order Value</strong></div>
            <div class="panel-body" align="center">
                <h1>US$<?php echo count_cash_value($connect); ?></h1>
            </div>
        </div>
        </div>
        <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Credit Order Value</strong></div>
            <div class="panel-body" align="center">
                <h1>US$<?php echo count_credit_value($connect); ?></h1>
            </div>
        </div>
        </div>
        <hr>
        <?php
        if($_SESSION['type']=='master'){
            ?>
            <div class="col-md-12">
                <div class="panel-default">
                    <div class="panel-heading"><strong>Total Value(User Wise)</strong>
                    <div class="panel-body" align="center">
                        <?php echo get_user_wise_total_order($connect); ?>
                    </div>
                    </div>
                </div>
            </div>
            <?php   
        }
        ?>

 </div>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
</head>
<body>
    
</body>
</html>