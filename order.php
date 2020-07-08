<?php
include('db.php');
if(!isset($_SESSION['type'])){
    header('Location:login.php');
}
include('header.php');
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script type="text/javascript" src="https://www.eyecon.ro/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="https://www.eyecon.ro/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>

    <style>
    .datepicker
    {
      z-index: 1600 !important; /* has to be larger than 1050 */
    }
</style>
<span id="alert_action"></span>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
        
                        <h2 class="panel-title">
                           Order List
                        </h2>
                    </div>
                
                
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
                   <button class="btn btn-info btn-l" name="add"
                   id="add_button" data-toggle="modal" data-target="#orderModal">ADD</button>
                    </div>
             
                </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 table-responsive">
                            <table id="order_data" 
                            class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Total Amount</th>
                                <th>Payment Status</th>
                                <th>Order Status</th>
                                <th>Order Date</th>
                               <?php
                               if($_SESSION["type"] == 'master')
                               {
                                echo '<th>Entry BY</th>';
                               }
                               ?>
                               <th></th>
                               <th></th>
                               <th></th>
                            </tr>
                        </thead>
                      
                        </table>
                        </div>
                    </div>
                </div>
            
      </div>
    </div>
</div>
<div id="ordrModal" class="modal fade">
         <div class="modal-dialog">
          <form method="post" id="ordr_form">
           <div class="modal-content">
           <div class="modal-header">
            
      <h4 class="modal-title"><i class="fa fa-plus"></i> Add Order</h4>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
           </div>
           <div class="modal-body">
               <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Enter Receiver Name</label>
                <input type="text" name="ordr_name" id="ordr_name" class="form-control" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Date</label>
                <input type="text" name="ordr_date" id="ordr_date" class="form-control" required>
            </div>
        </div>
        </div>
        <div class="form-group">
                <label for="">Enter Receiver Address</label>
                <textarea type="text" name="ordr_adrs" id="ordr_adrs" 
                class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="">Enter Product Details</label>
                <hr>
                <span id="span_pdt_dtls"></span>
                <hr>
            </div>
            <div class="form-group">
                <label for="">Select Payment Status</label>
                <select name="payment_status" id="payment_status" class="form-control">
                    <option value="cash">Cash</option>
                    <option value="credit">Credit</option>
                </select>
            </div>
           </div>
           <div class="modal-footer">
            <input type="hidden" name="ordr_id" id="ordr_id" >
            <input type="hidden" name="btn_action" id="btn_action" >
            <input type="submit" name="action" id="action" class="btn btn-info" value="Add" >
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
          </div>
          </form>

         </div>
        </div>
<?php
include('orderjs.php');
?>
<?php
include('footer.php');
?>