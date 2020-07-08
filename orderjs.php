<script type="text/javascript">
    $(document).ready(function(){
        $('#ordr_date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });
        $('#add_button').click(function(){
        $('#ordrModal').modal('show');
         $('#ordr_form')[0].reset();
         $('.modal-title').html("<i class='fa fa-plus'></i> Create Order");
          $('#action').val("Add");
         $('#btn_action').val("Add");
         $('#span_pdt_dtls').html('');
         add_pdt_row();
        });
        function add_pdt_row(count=''){
            var html = '';
            html += '<span id="row'+count+'"><div class="row">';
            html += '<div class="col-md-7">';
            html += '<select name="product_id[]" id="product_id'+count+'" class="form-control selectpicker" data-live-search="true" required>';
            html += '<?php echo fill_pdt_list($connect); ?>';
            html += '</select><input type="hidden" name="hidden_product_id[]" id="hidden_product_id'+count+'" />';
            html += '</div>';
            html += '<div class="col-md-3">';
            html += '<input type="text" name="quantity[]" class="form-control" required />';
            html += '</div>';
            html += '<div class="col-md-2">';
            if(count == '')
            {
                html += '<button type="button" name="add_more" id="add_more" class="btn btn-success btn-xs">+</button>';
            }
            else
            {
                html += '<button type="button" name="remove" id="'+count+'" class="btn btn-danger btn-xs remove">-</button>';
            }
            html += '</div>';
            html += '</div></div></span>';
            $('#span_pdt_dtls').append(html);
            $('.selectpicker').selectpicker();
        }
        var count=0;
        $(document).on('click','#add_more',function(){
         count=count+1;
         add_pdt_row(count);
        });
        $(document).on('click','.remove',function(){
            var row_no = $(this).attr("id");
         $('#row'+row_no).remove();
        });
     var orderdataTable = $('#order_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],  
        "ajax":{
         url:"order_fetch.php",
         type:"POST"
      },
      <?php
      if($_SESSION["type"]=='master'){
      ?>
   
   "columnDefs":[{
     "targets":[4,5,6,7,8,9],
     "orderable":false,
    }],
    <?php
      }
      else{
    ?>
    "columnDefs":[{
     "targets":[4,5,6,7,8],
     "orderable":false,
    }],
    <?php
      }
    ?>
   "pageLength": 10
     });
     $(document).on('submit','#ordr_form',function(event){
           event.preventDefault();
           $('#action').attr('disabled','disabled');
           var form_data = $(this).serialize();
           $.ajax({
               url:"order_action.php",
               method : "POST",
               data : form_data,
               success:function(data){
                   $('#ordr_form')[0].reset();
                   $('#ordrModal').modal('hide');
                   $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                   $('#action').attr('disabled',false);
                   orderdataTable.ajax.reload();
               }
           })
       });
       $(document).on('click','.update',function(){
           var invent_ordr_id =$(this).attr("id");
           var btn_action='fetch_single';
           $.ajax({
               url:"order_action.php",
               method : "POST",
               data : {invent_ordr_id:invent_ordr_id,btn_action:btn_action},
               dataType:"json",
               success:function(data){
                   $('#ordrModal').modal('show');
                   $('#ordr_name').val(data.ordr_name);
                   $('#ordr_date').val(data.ordr_date);
                   $('#ordr_adrs').val(data.ordr_adrs);
                   $('#span_pdt_dtls').html(data.pdt_dtls);
                   $('#payment_status').val(data.payment_status);
                   $('.modal-title').html("<i class='fa fa-plus'></i> Edit Order");
                   $('#ordr_id').val(invent_ordr_id);
                   $('#action').val("Edit");
                   $('#btn_action').val("Edit");
               }
           })
       });
            $(document).on('click', '.delete', function(){
                var inventory_order_id = $(this).attr("id");
                var status = $(this).data("status");
                var btn_action = "delete";
                if(confirm("Are you sure?"))
                {
                    $.ajax({
                    url:"order_action.php",
                    method:"POST",
                    data:{inventory_order_id:inventory_order_id, status:status, btn_action:btn_action},
                    success:function(data)
                    {
                    $('#alert_action').fadeIn().html('<div class="alert alert-danger">'+data+'</div>');
                    orderdataTable.ajax.reload();
                    }
                    })
                }
                else
                {
                    return false;
                }
         });

    });
</script>