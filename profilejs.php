<script>
    $(document).ready(function(){
      $('#edit_profile').on('submit',function(event){
       event.preventDefault();
       if($('#user_new_password').val() != ''){
         if($('#user_new_password').val() != $('#user_reenter_password').val()){
             $('#error_password').html(
                 '<label class="text-danger">Password doesnt match</label>'
             );
         } 
         else{
             $('#error_password').html('');
         }
       }
       $('#edit_profile_submit').attr('disabled','disabled');
         var form_data = $(this).serialize();
         $.ajax({
             url:"edit_profile.php",
             method:"POST",
             data : form_data,
             success : function(data){
                 $('#edit_profile_submit').attr('disabled',false);
                 $('#user_new_password').val('');
                 $('#user_reenter_password').val('');
                 $('#msg').html(data);
             }
         })
      });
    });
</script>