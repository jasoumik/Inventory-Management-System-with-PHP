<script>
    $(document).ready(function(){
        $('#add_button').click(function(){
         $('#user_form')[0].reset();
         $('.modal-title').html("<i class='fa fa-plus'></i> Add User");
          $('#action').val("Add");
         $('#btn_action').val("Add");
 });
       var userdataTable= $('#user_data').DataTable({
           "processing": true,
           "serverSide":true,
           "order":[],
           "ajax":{
               url:"user_fetch.php",
               type:"POST"
           },
           "columnDefs":[{
               "target":[4,5],
               "orderable":false
           }],
           "pageLength": 25
       });

       $(document).on('submit','#user_form',function(event){
           event.preventDefault();
           $('#action').attr('disabled','disabled');
           var form_data = $(this).serialize();
           $.ajax({
               url:"user_action.php",
               method : "POST",
               data : form_data,
               success:function(data){
                   $('#user_form')[0].reset();
                   $('#userModal').modal('hide');
                   $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                   $('#action').attr('disabled',false);
                   userdataTable.ajax.reload();
               }
           })
       });

       $(document).on('click','.update',function(){
           var user_id = $(this).attr("id");
           var btn_action = 'fetch_single';
           $.ajax({
               url : "user_action.php",
               method : "POST",
               data:{user_id:user_id,btn_action:btn_action},
               dataType:"json",
               success:function(data){
                  $('#userModal').modal('show');
                  $('#user_name').val(data.user_name);
                  $('#user_email').val(data.user_email);
                  $('.modal-title').html("<i class='fa fa-pencil-square-o'></i>Edit User");
                  $('#user_id').val(user_id);
                  $('#action').val('Edit');
                  $('#btn_action').val('Edit');
                  $('#user_password').attr('required',false);
               }
           })
       });
       $(document).on('click','.delete',function(){
           var user_id = $(this).attr("id");
           var status = $(this).attr('status');
           var btn_action = 'delete';
           if(confirm("Are you Sure?"))
           {
            $.ajax({
               url : "user_action.php",
               method : "POST",
               data:{user_id:user_id,status:status,btn_action:btn_action},
               success:function(data){
                $('#alert_action').fadeIn().html('<div class="alert alert-danger">'+data+'</div>');
                userdataTable.ajax.reload();
               }
           })
           }else{
               return false;
           }
           
       });
    
    });
</script>