<?php
include('db.php');
if(!isset($_SESSION['type'])){
    header('Location:login.php');
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
                           Category List
                        </h2>
                    </div>
                
                
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
                   <button class="btn btn-info btn-l" name="add"
                   id="add_button" data-toggle="modal" data-target="#catModal">ADD</button>
                    </div>
             
                </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 table-responsive">
                            <table id="cat_data" 
                            class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>

                            </tr>
                        </thead>
                      
                        </table>
                        </div>
                    </div>
                </div>
            
      </div>
    </div>
</div>
<div id="catModal" class="modal fade">
         <div class="modal-dialog">
          <form method="post" id="cat_form">
           <div class="modal-content">
           <div class="modal-header">
            
      <h4 class="modal-title"><i class="fa fa-plus"></i> Add Category</h4>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
           </div>
           <div class="modal-body">
            <div class="form-group">
       <label>Enter Category Name</label>
       <input type="text" name="cat_name" id="cat_name" class="form-control" required />
      </div>
           </div>
           <div class="modal-footer">
            <input type="hidden" name="cat_id" id="cat_id" />
            <input type="hidden" name="btn_action" id="btn_action" />
            <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
          </div>
          </form>

         </div>
        </div>
<?php
include('categoryjs.php');
?>
<?php
include('footer.php');
?>