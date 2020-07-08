<?php
include('db.php');
if(isset($_POST['btn_action'])){
    if($_POST['btn_action']=='load_brand'){
        echo fill_brand_list($connect,$_POST['category_id']);
    }
    if($_POST['btn_action']=='Add'){
        $qry="
        INSERT INTO product(category_id,brand_id,
        product_name,product_desc,product_qnty,product_unit,
        product_base_price,product_tax,product_entry_by,product_status,product_date)
        VALUES(:category_id,:brand_id,
        :product_name,:product_desc,:product_qnty,:product_unit,
        :product_base_price,:product_tax,:product_entry_by,:product_status,:product_date)
        ";
        $stm=$connect->prepare($qry);
        $stm->execute(
            array(
                ':category_id'   => $_POST["category_id"],
                ':brand_id'   => $_POST["brand_id"],
                ':product_name'   => $_POST["pdt_name"],
                ':product_desc'   => $_POST["pdt_des"],
                ':product_qnty'   => $_POST["pdt_qnty"],
                ':product_unit'   => $_POST["pdt_unit"],
                ':product_base_price'   => $_POST["pdt_base_price"],
                ':product_tax'   => $_POST["pdt_tax"],
                ':product_entry_by'   => $_SESSION["user_id"],
                ':product_status'   =>'active',
                ':product_date'   => date("Y-m-d")
            )
        );
        $result = $stm->fetchAll();
        if(isset($result)){
           echo 'New Product Added'; 
        }
    }
    if($_POST['btn_action']=='pdt_dtls'){
        $qry="SELECT * FROM product
       INNER JOIN brand ON brand.brand_id=product.brand_id
       INNER JOIN category ON category.category_id=product.category_id
        INNER JOIN user_details ON user_details.user_id=product.product_entry_by
        WHERE product.product_id ='".$_POST["pdt_id"]."'
        ";
        $stm=$connect->prepare($qry);
        $stm->execute();
        $result= $stm->fetchAll();
        $output = '
        <div class="table-responsive">
         <table class="table table-bordered">
        ';
        foreach($result as $row){
            $status ='';
            if($row["product_status"]=='active'){
                $status= '<span class="label label-success">Active</span>';
            }
            else {
                $status= '<span class="label label-danger">Inactive</span>';
            }
            $output .=
            '<tr>
            <td>Product Name</td>
            <td>'.$row["product_name"].'</td>
            </tr> 
            <tr>
            <td>Product Description</td>
            <td>'.$row["product_desc"].'</td>
            </tr>
            <tr>
            <td>Category</td>
            <td>'.$row["category_name"].'</td>
            </tr>
            <tr>
            <td>Brand</td>
            <td>'.$row["brand_name"].'</td>
            </tr>
            <tr>
            <td>Available Quantity</td>
            <td>'.$row["product_qnty"].' '.$row["product_unit"].'</td>
            </tr>
            <tr>
            <td>Base Price</td>
            <td>'.$row["product_base_price"].' </td>
            </tr>
            <tr>
            <td>Tax (%)</td>
            <td>'.$row["product_tax"].' </td>
            </tr>
            <tr>
            <td>Entry By</td>
            <td>'.$row["user_name"].' </td>
            </tr>
            <td>Status</td>
            <td>'.$status.' </td>
            </tr>';
        }
        $output .= ' </table>
        </div>';
        echo $output;
    }
    if($_POST['btn_action'] == 'fetch_single')
        {
        $qry = "
        SELECT * FROM product WHERE product_id = :product_id
        ";
        $stm = $connect->prepare($qry);
        $stm->execute(
        array(
            ':product_id' => $_POST["pdt_id"]
        )
        );
        $result = $stm->fetchAll();
        foreach($result as $row)
        {
        $output['category_id'] = $row['category_id'];
        $output['brand_id'] = $row['brand_id'];
        $output["brand_select_box"] = fill_brand_list($connect, $row["category_id"]);
        $output['pdt_name'] = $row['product_name'];
        $output['pdt_des'] = $row['product_desc'];
        $output['pdt_qnty'] = $row['product_qnty'];
        $output['pdt_unit'] = $row['product_unit'];

        $output['pdt_base_price'] = $row['product_base_price'];
        $output['pdt_tax'] = $row['product_tax'];
        }
        echo json_encode($output);
        }
        if($_POST['btn_action'] == 'Edit'){
                $qry = "
                UPDATE product 
                set category_id = :category_id, 
                brand_id = :brand_id,
                product_name = :product_name,
                product_desc = :product_description, 
                product_qnty = :product_quantity, 
                product_unit = :product_unit, 
                product_base_price = :product_base_price, 
                product_tax = :product_tax 
                WHERE product_id = :product_id
                ";
                $stm = $connect->prepare($qry);
                $stm->execute(
                array(
                    ':category_id'   => $_POST['category_id'],
                    ':brand_id'    => $_POST['brand_id'],
                    ':product_name'   => $_POST['pdt_name'],
                    ':product_description' => $_POST['pdt_des'],
                    ':product_quantity'  => $_POST['pdt_qnty'],
                    ':product_unit'   => $_POST['pdt_unit'],
                    ':product_base_price' => $_POST['pdt_base_price'],
                    ':product_tax'   => $_POST['pdt_tax'],
                    ':product_id'   => $_POST['pdt_id']
                )
                );
                $result = $stm->fetchAll();
                if(isset($result))
                {
                echo 'Product Details Edited';
                }
                }
                if($_POST['btn_action'] == 'delete')
                {
                $status = 'active';
                if($status == 'active')
                {
                $status = 'inactive';
                }
                $qry = "
                UPDATE product 
                SET product_status = :product_status 
                WHERE product_id = :product_id
                ";
                $stm = $connect->prepare($qry);
                $stm->execute(
                array(
                    ':product_status' => $status,
                    ':product_id'  => $_POST["pdt_id"]
                )
                );
                $result = $stm->fetchAll();
                if(isset($result)){
                echo 'Product status change to ' . $status;
             }
          }
        }
?>