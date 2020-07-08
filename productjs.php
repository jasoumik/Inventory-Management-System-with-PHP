<script>
      $(document).ready(function(){
        $('#add_button').click(function(){
        $('#pdtModal').modal('show');
         $('#pdt_form')[0].reset();
         $('.modal-title').html("<i class='fa fa-plus'></i> Add Product");
          $('#action').val("Add");
         $('#btn_action').val("Add");
        });
        $('#category_id').change(function(){
           var category_id = $('#category_id').val();
           var btn_action = 'load_brand';
           $.ajax({
               url:"product_action.php",
               method : "POST",
               data : {category_id:category_id,btn_action:btn_action},
               success:function(data){
                   $('#brand_id').html(data);
               }
           })
        });
        var pdtdataTable= $('#pdt_data').DataTable({
           "processing": true,
           "serverSide":true,
           "order":[],
           "ajax":{
               url:"product_fetch.php",
               type:"POST"
           },
           "columnDefs":[{
               "target":[7,8,9],
               "orderable":false
           }],
           "pageLength": 25
       });

       $(document).on('submit','#pdt_form',function(event){
           event.preventDefault();
           $('#action').attr('disabled','disabled');
           var form_data = $(this).serialize();
           $.ajax({
               url:"product_action.php",
               method : "POST",
               data : form_data,
               success:function(data){
                   $('#pdt_form')[0].reset();
                   $('#pdtModal').modal('hide');
                   $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                   $('#action').attr('disabled',false);
                   pdtdataTable.ajax.reload();
               }
           })
       });

       $(document).on('click','.view',function(){
           var pdt_id = $(this).attr("id");
           var btn_action = 'pdt_dtls';
           $.ajax({
               url:"product_action.php",
               method : "POST",
               data : {pdt_id:pdt_id,btn_action:btn_action},
               success:function(data){
                   $('#viewModal').modal('show');
                   $('#pdt_dtls').html(data);
               }
           })
       });
       $(document).on('click','.update',function(){
           var pdt_id = $(this).attr("id");
           var btn_action = 'fetch_single';
           $.ajax({
               url : "product_action.php",
               method : "POST",
               data:{pdt_id:pdt_id,btn_action:btn_action},
               dataType:"json",
               success:function(data){
                $('#pdtModal').modal('show');
                $('#category_id').val(data.category_id);
                $('#brand_id').html(data.brand_select_box);
                $('#brand_id').val(data.brand_id);
                $('#pdt_name').val(data.pdt_name);
                $('#pdt_des').val(data.pdt_des);
                $('#pdt_qnty').val(data.pdt_qnty);
                $('#pdt_unit').val(data.pdt_unit);
                $('#pdt_base_price').val(data.pdt_base_price);
                $('#pdt_tax').val(data.pdt_tax);
                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Product");
                $('#pdt_id').val(pdt_id);
                $('#action').val("Edit");
                $('#btn_action').val("Edit");
               }
           })
       });

       $(document).on('click','.delete',function(){
           var pdt_id = $(this).attr("id");
           var status = $(this).attr('status');
           var btn_action = 'delete';
           if(confirm("Are you Sure?"))
           {
            $.ajax({
               url : "product_action.php",
               method : "POST",
               data:{pdt_id:pdt_id,status:status,btn_action:btn_action},
               success:function(data){
                $('#alert_action').fadeIn().html('<div class="alert alert-danger">'+data+'</div>');
                pdtdataTable.ajax.reload();
               }
           })
           }else{
               return false;
           }
           
       });
    });
</script>