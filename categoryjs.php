<script>
     $(document).ready(function(){
        $('#add_button').click(function(){
         $('#cat_form')[0].reset();
         $('.modal-title').html("<i class='fa fa-plus'></i> Add Category");
          $('#action').val("Add");
         $('#btn_action').val("Add");
        });
        var catdataTable= $('#cat_data').DataTable({
           "processing": true,
           "serverSide":true,
           "order":[],
           "ajax":{
               url:"category_fetch.php",
               type:"POST"
           },
           "columnDefs":[{
               "target":[3,4],
               "orderable":false
           }],
           "pageLength": 25
       });
       $(document).on('submit','#cat_form',function(event){
           event.preventDefault();
           $('#action').attr('disabled','disabled');
           var form_data = $(this).serialize();
           $.ajax({
               url:"category_action.php",
               method : "POST",
               data : form_data,
               success:function(data){
                   $('#cat_form')[0].reset();
                   $('#catModal').modal('hide');
                   $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                   $('#action').attr('disabled',false);
                   catdataTable.ajax.reload();
               }
           })
       });
       $(document).on('click','.update',function(){
           var cat_id = $(this).attr("id");
           var btn_action = 'fetch_single';
           $.ajax({
               url : "category_action.php",
               method : "POST",
               data:{cat_id:cat_id,btn_action:btn_action},
               dataType:"json",
               success:function(data){
                  $('#catModal').modal('show');
                  $('#cat_name').val(data.cat_name);
                  $('.modal-title').html("<i class='fa fa-pencil-square-o'></i>Edit Category");
                  $('#cat_id').val(cat_id);
                  $('#action').val('Edit');
                  $('#btn_action').val('Edit');
               }
           })
       });
       $(document).on('click','.delete',function(){
           var cat_id = $(this).attr("id");
           var status = $(this).attr('status');
           var btn_action = 'delete';
           if(confirm("Are you Sure?"))
           {
            $.ajax({
               url : "category_action.php",
               method : "POST",
               data:{cat_id:cat_id,status:status,btn_action:btn_action},
               success:function(data){
                $('#alert_action').fadeIn().html('<div class="alert alert-danger">'+data+'</div>');
                catdataTable.ajax.reload();
               }
           })
           }else{
               return false;
           }
           
       });

    });
</script>