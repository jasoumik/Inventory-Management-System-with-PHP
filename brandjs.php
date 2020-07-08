<script>
     $(document).ready(function(){
        $('#add_button').click(function(){
            $('#brandModal').modal('show');
         $('#brand_form')[0].reset();
         $('.modal-title').html("<i class='fa fa-plus'></i> Add brand");
          $('#action').val("Add");
         $('#btn_action').val("Add");
        });
        var branddataTable= $('#brand_data').DataTable({
           "processing": true,
           "serverSide":true,
           "order":[],
           "ajax":{
               url:"brand_fetch.php",
               type:"POST"
           },
           "columnDefs":[{
               "target":[4,5],
               "orderable":false
           }],
           "pageLength":10
       });
       $(document).on('submit','#brand_form',function(event){
           event.preventDefault();
           $('#action').attr('disabled','disabled');
           var form_data = $(this).serialize();
           $.ajax({
               url:"brand_action.php",
               method : "POST",
               data : form_data,
               success:function(data){
                   $('#brand_form')[0].reset();
                   $('#brandModal').modal('hide');
                   $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                   $('#action').attr('disabled',false);
                   branddataTable.ajax.reload();
               }
           })
       });
       $(document).on('click','.update',function(){
           var brand_id = $(this).attr("id");
           var btn_action = 'fetch_single';
           $.ajax({
               url : "brand_action.php",
               method : "POST",
               data:{brand_id:brand_id,btn_action:btn_action},
               dataType:"json",
               success:function(data){
                  $('#brandModal').modal('show');
                  $('#category_id').val(data.category_id);
                  $('#brand_name').val(data.brand_name);
                  $('.modal-title').html("<i class='fa fa-pencil-square-o'></i>Edit brandegory");
                  $('#brand_id').val(brand_id);
                  $('#action').val('Edit');
                  $('#btn_action').val('Edit');
               }
           })
       });
       $(document).on('click','.delete',function(){
           var brand_id = $(this).attr("id");
           var status = $(this).attr('status');
           var btn_action = 'delete';
           if(confirm("Are you Sure?"))
           {
            $.ajax({
               url : "brand_action.php",
               method : "POST",
               data:{brand_id:brand_id,status:status,btn_action:btn_action},
               success:function(data){
                $('#alert_action').fadeIn().html('<div class="alert alert-danger">'+data+'</div>');
                branddataTable.ajax.reload();
               }
           })
           }else{
               return false;
           }
           
       });

    });
</script>