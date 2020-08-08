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
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="order_date">
                </div>
            </div>
            <div class="form-group row">
                <label for="order_name" class="col-sm-2 col-form-label">Customer Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="cus_name" name="Customer Name">
                </div>
            </div>
            <div class="form-group">
                <label for="#" class="col-form-label">Select Products</label>
                <span id="error"></span>
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Enter Product Name</th>
                        <th width="15%">Total Qty</th>
                        <th width="15%">Enter Quantity</th>
                        <th width="15%">Price</th>
                        <th width="15%">Total Price</th>
                        <th width="5%"><button type="button" name="add" 
                        class="btn btn-success btn-sm add">
                        <span class="fas fa-plus-circle"></span></button></th>
                    </tr>
                    <tbody id="item_table">
                    
                    </tbody>
                </table>
            </div>
            <div class="form-group row">
                <label for="sub_total" class="col-sm-2 col-form-label">Sub Total</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" id="sub_total" name="sub_total" value="0" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="discount" class="col-sm-2 col-form-label">Discount</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" id="discount" name="discount">
                </div>
            </div>
            <div class="form-group row">
                <label for="net_total" class="col-sm-2 col-form-label">Net Total</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" id="net_total" name="net_total" value="0" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="paid" class="col-sm-2 col-form-label">Paid</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" id="paid" name="paid">
                </div>
            </div>
            <div class="form-group row">
                <label for="due" class="col-sm-2 col-form-label" readonly>Due</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" id="due" name="due" value="0" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="payment_type" class="col-sm-2 col-form-label">Payment Method</label>
                <div class="col-sm-6">
                    <select name="payment_type" class="form-control" id="payment_type">
                        <option value="1">Cash</option>
                        <option value="2">Card</option>
                        <option value="3">Draft</option>
                        <option value="4">Cheque</option>
                    </select>
                </div>
            </div>
            <div align="center">
                <input type="submit" name="submit" class="btn btn-info" value="Print Invoice">
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
            html += '<td><input type="text" class="form-control total_qty" name="total_qty[]" disabled></td>';
            html += '<td><input type="text" class="form-control product_qty" name="product_qty[]"></td>';
            html += '<td><input type="text" class="form-control price" name="price[]" disabled></td>';
            html += '<input type="hidden" class="form-control total_price" name="total_price[]" value="0">';
            html += '<td id="display_price">Php 0</td>';
            html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove">';
            html += '<span class="fa fa-minus-circle"></span></button></td></tr>';
            $('#item_table').append(html);
        });
        // Remove Field
        $(document).on('click', '.remove', function(){
            var total_price = $(this).closest('tr').find('.total_price').val();
            var sub_total = $('#sub_total').val();
            var total = sub_total - total_price;
            $('#sub_total').val(total);
            $(this).closest('tr').remove();
        });
        // Select Product Action
        $("#item_table").delegate(".product_name","change", function(){
            var val = $(this).val();
            var tr = $(this).parent().parent();
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>orders/qty_price/'+val,
                dataType: 'json',
                success:function(data){
                    tr.find(".total_qty").val(data.qty);
                    tr.find(".price").val(data.price);
                }
            });
        });
        //Price Function
        $("#item_table").delegate(".product_qty","keyup", function(){
            var qty = $(this);
            var tr = $(this).parent().parent();
            var sub_total = $('#sub_total').val();
            //Calculation
            if(isNaN(qty.val())) {
			    alert("Please enter a valid quantity");
			    qty.val(0);
		    }else{
                if ((qty.val() - 0) > (tr.find(".total_qty").val()-0)) {
                    alert("Sorry ! This much of quantity is not available");
                    var updated_sub = sub_total - tr.find(".total_price").val();
                    $('#sub_total').val(updated_sub);
                    // Values To 0
                    qty.val(0);
                    tr.find("#display_price").html("Php "+0);
                    tr.find(".total_price").val(0);
                }else{
                   total_price = qty.val() * tr.find(".price").val();
                   tr.find("#display_price").html("Php "+total_price);
                   tr.find(".total_price").val(total_price);
                   calculate(0,0);
                }
            }
            
        });
        function calculate(dis,paid){
            var sub_total = 0;
            var discount = dis;
            $('.total_price').each(function (){
                sub_total = sub_total + ($(this).val() * 1);
            });
            var net_total = sub_total - (sub_total * dis / 100);
            $('#sub_total').val(sub_total);
            $('#net_total').val(net_total);
        }
        $('#discount').keyup(function (){
            var discount = $(this).val();
            calculate(discount,0);
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
                            $('#item_table > tr').empty();
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