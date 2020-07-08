<?php
include('db.php');
if(!isset($_SESSION["type"])){
    header('location:login.php');
}
if($_SESSION["type"] != 'master')
{
 header("location:index.php");
}
include('header.php');
?>
<span id="alert_action"></span>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
        
                        <h2 class="panel-title">
                            Product List
                        </h2>
                    </div>
                
                
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
                   <button class="btn btn-info btn-l" name="add"
                   id="add_button" data-toggle="modal" data-target="#pdtModal">ADD</button>
                    </div>
             
                </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 table-responsive">
                            <table id="pdt_data" 
                            class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Entry By</th>
                                <th>Status</th>
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


<div id="pdtModal" class="modal fade">
         <div class="modal-dialog">
          <form method="post" id="pdt_form">
           <div class="modal-content">
           <div class="modal-header">
           <h4 class="modal-title"><i class="fa fa-plus"></i> Add Product</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
      
           </div>
           <div class="modal-body">
           <div class="form-group">
           <label>Select Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
           <option value="">Select Category</option>
           <?php echo fill_category_list($connect);?>
       </select>
      </div>
      <div class="form-group">
           <label>Select Brand</label>
            <select name="brand_id" id="brand_id" class="form-control" required>
           <option value="">Select Brand</option>
       </select>
      </div>
            <div class="form-group">
       <label>Enter Product Name</label>
       <input type="text" name="pdt_name" id="pdt_name" class="form-control" required >
      </div>
      <div class="form-group">
       <label>Enter Product Description</label>
       <textarea name="pdt_des" id="pdt_des" class="form-control" rows="5" required ></textarea>
      </div>
      <div class="form-group">
       <label>Enter Product Quantity</label>
       <div class="input-group">
       <input type="text" name="pdt_qnty" id="pdt_qnty" class="form-control" 
       required pattern="[+-]?([0-9]*[.])?[0-9]+" >
       <span class="input-group-addon">
       <select name="pdt_unit" id="pdt_unit" class="form-control" required>
       <option value="">Select Unit</option>
        <option value="Bags">Bags</option>
        <option value="Bottles">Bottles</option>
        <option value="Box">Box</option>
        <option value="Dozens">Dozens</option>
        <option value="Feet">Feet</option>
        <option value="Gallon">Gallon</option>
        <option value="Grams">Grams</option>
        <option value="Inch">Inch</option>
        <option value="Kg">Kg</option>
        <option value="Liters">Liters</option>
        <option value="Meter">Meter</option>
        <option value="Nos">Nos</option>
        <option value="Packet">Packet</option>
        <option value="Rolls">Rolls</option>
       </select>
       </span>
      </div>
      </div>
         <div class="form-group">
        <label>Enter Product Base Price</label>
         <input type="text" name="pdt_base_price" id="pdt_base_price" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" >
         </div>
      <div class="form-group">
       <label>Enter Product Tax(15%)</label>
       <input type="text" name="pdt_tax" id="pdt_tax" class="form-control" 
       required pattern="[+-]?([0-9]*[.])?[0-9]+" >
      </div>
           </div>
           <div class="modal-footer">
            <input type="hidden" name="pdt_id" id="pdt_id" >
            <input type="hidden" name="btn_action" id="btn_action" >
            <input type="submit" name="action" id="action" class="btn btn-info" value="Add" >
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
          </div>
          </form>

         </div>
        </div>

<!-- view modal -->
        <div id="viewModal" class="modal fade">
         <div class="modal-dialog">
          <form method="post" id="pdt_form">
           <div class="modal-content">
           <div class="modal-header">
           <h4 class="modal-title"><i class="fa fa-plus"></i>Product Details</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
      
           </div>
           <div class="modal-body">
          <div id="pdt_dtls">

          </div>
           </div>
           <div class="modal-footer">
            
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
          </div>
          </form>

         </div>
        </div>
<?php
include('productjs.php');
?>
<?php
include('footer.php');
?>