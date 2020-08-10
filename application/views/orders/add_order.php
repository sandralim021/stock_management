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
            <span id="error"></span>
            <div class="form-group row">
                <label for="order_name" class="col-sm-2 col-form-label">Order Date</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="order_date" name="order_date">
                </div>
            </div>
            <div class="form-group row">
                <label for="order_name" class="col-sm-2 col-form-label">Customer Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="cus_name" name="cus_name">
                </div>
            </div>
            <div class="form-group row">
                <label for="order_name" class="col-sm-2 col-form-label">Customer Contact</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="cus_contact" name="cus_contact">
                </div>
            </div>
            <div class="form-group">
                <label for="#" class="col-form-label">Select Products</label>
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
                    <input type="number" class="form-control" id="paid" name="paid" step="0.01">
                </div>
            </div>
            <div class="form-group row">
                <label for="due" class="col-sm-2 col-form-label" readonly>Due</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" id="due" name="due" value="0" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="payment_type" class="col-sm-2 col-form-label">Payment Type</label>
                <div class="col-sm-6">
                    <select name="payment_type" class="form-control" id="payment_type">
                        <option value="Cash">Cash</option>
                        <option value="Card">Card</option>
                        <option value="Cheque">Cheque</option>
                    </select>
                </div>
            </div>
            <div align="center">
                <input type="submit" name="submit" class="btn btn-info" value="Place Order">
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
            "autoclose": true,
            "format": 'yy-mm-dd',
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
            html += '<td><input type="text" class="form-control price" name="price[]" readonly></td>';
            html += '<td>Php. <span class="total_price">0</span></td>';
            html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove">';
            html += '<span class="fa fa-minus-circle"></span></button></td></tr>';
            $('#item_table').append(html);
        });
        // Remove Field
        $(document).on('click', '.remove', function(){
            var total_price = $(this).closest('tr').find('.total_price').html();
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
                    var updated_sub = sub_total - tr.find(".total_price").html();
                    $('#sub_total').val(updated_sub);
                    // Values To 0
                    qty.val(0);
                    tr.find(".total_price").html(0);
                }else{
                   total_price = qty.val() * tr.find(".price").val();
                   tr.find(".total_price").html(total_price);
                   calculate(0,0);
                }
            }
            
        });
        function calculate(dis,paid){
            var sub_total = 0;
            var net_total = 0;
            var discount = dis;
            var paid_amt = paid;
            var due = 0;
            $('.total_price').each(function (){
                sub_total = sub_total + ($(this).html() * 1);
            });
            net_total = sub_total - (sub_total * dis / 100);
            due = net_total - paid_amt;
            $('#sub_total').val(sub_total);
            $('#net_total').val(net_total);
            $('#due').val(due);
        }
        $('#discount').keyup(function (){
            var discount = $(this).val();
            calculate(discount,0);
        });
        $('#paid').keyup(function (){
            var paid = $(this).val();
            var discount = $('#discount').val();
            calculate(discount,paid);
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
                    url: "<?php echo base_url() ?>orders/insert_order",
                    method: "POST",
                    data: form_data,
                    success: function(data){
                        if(data == 'ok'){
                            $("#insert_form")[0].reset();
                            $('#item_table > tr').empty();
                            $('#error').html('<div class="alert alert-success">Order Details Save</div>');
                        }
                    }
                });
            }else{
                $('#error').html('<div class="alert alert-danger">'+error+'</div>');
            }
        });
    });

</script>