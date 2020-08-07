 <!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Orders</h1>
        <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">New Order</h6>
        </div>
        <div class="card-body">
        <form id="insert_form">
            <div class="form-group row">
                <label for="order_name" class="col-sm-2 col-form-label">Order Date</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="order_date">
                </div>
            </div>
            <div class="form-group row">
                <label for="order_name" class="col-sm-2 col-form-label">Customer Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="cus_name" name="Customer Name">
                </div>
            </div>
            <div class="form-group">
                <label for="#" class="col-form-label">Select Products</label>
                <span id="error"></span>
                <table class="table table-bordered" id="item_table">
                    <tr>
                        <th width="30%">Enter Product Name</th>
                        <th width="15%">Total Qty</th>
                        <th width="15%">Enter Quantity</th>
                        <th width="15%">Price</th>
                        <th width="5%"><button type="button" name="add" 
                        class="btn btn-success btn-sm add">
                        <span class="fas fa-plus-circle"></span></button></th>
                    </tr>
                </table>
                <div align="center">
                    <input type="submit" name="submit" class="btn btn-info" value="insert">
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<script type="text/javascript">
    $(document).ready(function(){
        //Date Picker
        $('#order_date').datepicker({
            "autoclose": true
        });
        $("#order_date").datepicker("setDate", new Date());
        //Product Add
        $(document).on('click', '.add', function(){
            var html = '';
            html += '<tr>';
            html += '<td><select class="form-control product_name" name="product_name[]">';
            html += '<option value="0" selected>Select Product</option>';
            html += '<option disabled>──────────</option>';
            html += '<?php foreach($products as $row): ?><option value="<?php echo $row['product_id'];?>"><?php echo $row['product_name']; ?></option><?php endforeach ?>';
            html += '</select></td>';
            html += '<td><input type="text" class="form-control total_qty" name="total_qty" disabled></td>';
            html += '<td><input type="text" class="form-control product_qty" name="product_qty[]"></td>';
            html += '<td><input type="text" class="form-control price" name="price" disabled></td>';
            html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove">';
            html += '<span class="fa fa-minus-circle"></span></button></td></tr>';
            $('#item_table').append(html);
        });
        // Remove Field
        $(document).on('click', '.remove', function(){
            $(this).closest('tr').remove();
        });
        $(document).on('change', '.product_name', function(){
            var val=$(this).val();
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>orders/qty_price/'+val,
                dataType: 'json',
                success:function(data){
                    $('.total_qty').val(data.qty);
                    $('.price').val(data.price);
                }
            });
        });
        // Multiple Insert
        $('#insert_form').on('submit', function(event){
            event.preventDefault();
            var error = '';
            $('.product_name').each(function(){
                var count = 1;
                if($(this).val() == ''){
                    error +="<p>Enter Item Name at "+count+" Row</p>";
                    return false;
                }
                count = count + 1;
            });
            $('.product_qty').each(function(){
                var count = 1;
                if($(this).val() == ''){
                    error +="<p>Enter Item Quantity at "+count+" Row</p>";
                    return false;
                }
                count = count + 1;
            });
            var form_data = $(this).serialize();

            if(error == ''){
                $.ajax({
                    url: "<?php echo base_url() ?>orders/insert",
                    method: "POST",
                    data: form_data,
                    success: function(data){
                        if(data == 'ok'){
                            $('#item_table').find("tr:gt(0)").remove();
                            $('#error').html('<div class="alert alert-success">Item Details Save</div>');
                        }
                    }
                });
            }else{
                $('#error').html('<div class="alert alert-danger">'+error+'</div>');
            }
        });
    });

</script>