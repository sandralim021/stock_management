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
                    <input type="text" class="form-control" id="order_date" name="order_date" autocomplete="off">
                    <div class="invalid-feedback"> The Order Date field is required </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="order_name" class="col-sm-2 col-form-label">Customer Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="cus_name" name="cus_name">
                    <div class="invalid-feedback"> The Customer Name field is required </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="order_name" class="col-sm-2 col-form-label">Customer Contact</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="cus_contact" name="cus_contact">
                    <div class="invalid-feedback"> The Customer Contact field is required </div>
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
                    <tr>
                        <td>
                            <select class="form-control product_name" name="product_name[]" id="product_name">
                                <option value="0" selected>Select Product</option>
                                <option disabled>──────────</option>
                                <?php foreach($products as $row): ?><option value="<?php echo $row['product_id'];?>"><?php echo $row['product_name']; ?></option><?php endforeach ?>
                            </select>
                        </td>
                        <td><input type="text" class="form-control total_qty" name="total_qty[]" disabled></td>
                        <td>
                            <input type="text" class="form-control product_qty" name="product_qty[]" id="product_qty">
                        </td>
                        <td><input type="text" class="form-control price" name="price[]" readonly></td>
                        <td>Php. <span class="total_price">0</span></td>
                        <td></td>
                    </tr>
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
            html += '<td><select class="form-control product_name" name="product_name[]" id="product_name">';
            html += '<option value="0" selected>Select Product</option>';
            html += '<option disabled>──────────</option>';
            html += '<?php foreach($products as $row): ?><option value="<?php echo $row['product_id'];?>"><?php echo $row['product_name']; ?></option><?php endforeach ?>';
            html += '</select>';
            html += '<p class="invalid-feedback"> Product Name Field is required!! </p></td>'
            html += '<td><input type="text" class="form-control total_qty" name="total_qty[]" disabled></td>';
            html += '<td><input type="text" class="form-control product_qty" name="product_qty[]" id="product_qty">';
            html += '<p class="invalid-feedback"> Product Qty Field is required!! </p></td>'
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

            var orderDate = $('#order_date').val();
            var customerName = $('#cus_name').val();
            var customerContact = $('#cus_contact').val();
            // form validation 
			if(orderDate == "") {
                $('#order_date').closest('.form-control').addClass('is-invalid');
        
			} else {
                $('#order_date').closest('.form-control').removeClass('is-invalid');
                $('#order_date').closest('.form-control').addClass('is-valid');
            }

            // form validation 
			if(customerName == "") {
                $('#cus_name').closest('.form-control').addClass('is-invalid');
                
			} else {
                $('#cus_name').closest('.form-control').removeClass('is-invalid');
                $('#cus_name').closest('.form-control').addClass('is-valid');
            }

            // form validation 
			if(customerContact == "") {
				$('#cus_contact').closest('.form-control').addClass('is-invalid');
			} else {
                $('#cus_contact').closest('.form-control').removeClass('is-invalid');
                $('#cus_contact').closest('.form-control').addClass('is-valid');
            }
            // array validation
			var productName = document.getElementsByName('product_name[]');				
			var validateProduct;
            for (var x = 0; x < productName.length; x++) {       						
                if(productName[x].value){	    		    		    	
                    validateProduct = true;
                } else {      	
                    validateProduct = false;
                }          
            }
             // array validation
			var productQty = document.getElementsByName('product_qty[]');				
			var validateProductQty;
            for (var x = 0; x < productQty.length; x++) {       						
                if(productQty[x].value){	    		    		    	
                    validateProductQty = true;
                } else {      	
                    validateProductQty = false;
                }          
            }

            if(validateProduct == false || validateProductQty == false){
                $('#error').html('<div class="alert alert-danger">Please Fill Up All Product Information On The Table</div>');
            }
            
            var form_data = $(this).serialize();
            if((orderDate && customerName && customerContact) && (validateProduct == true && validateProductQty == true)){
                $.ajax({
                    url: "<?php echo base_url() ?>orders/insert_order",
                    method: "POST",
                    data: form_data,
                    dataType: 'json',
                    success: function(response){
                        if(response.success === true){
                            $("#insert_form")[0].reset();
                            $('#item_table > tr').empty();
                            $("#order_date").datepicker("setDate", new Date());
                            $("#insert_form .form-control").removeClass('is-invalid').removeClass('is-valid');
                            $('#error').html('');
                            Swal.fire({
                                title: 'Success',
                                text: response.messages,
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#565D63',
                                confirmButtonText: 'Print Invoice',
                                cancelButtonText: 'Ok'
                                }).then((result) => {
                                if (result.value) {
                                   window.open('<?php echo base_url() ?>orders/invoice/'+response.order_id);
                                }
                            })
                        }
                    }
                });
            }else{
                
            }
        });
    });

</script>