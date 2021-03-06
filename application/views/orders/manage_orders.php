    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Manage Orders</h1>
            <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Orders List</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="order_data" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th>Contact Number</th>
                                <th>Order Date</th>
                                <th>Total Payment</th>
                                <th>Payment Type</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="selected_data">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Payment Modal -->
    <div class="modal fade" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Manage Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="payment_form">
                    <input type="hidden" name="order_id" id="order_id" value="0">
                        <div class="form-group row">
                        <label for="order_name" class="col-sm-4 col-form-label">Order Date</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="order_date" name="order_date" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cus_name" class="col-sm-4 col-form-label">Customer Name</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="cus_name" name="cus_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cus_contact" class="col-sm-4 col-form-label">Customer Contact</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="cus_contact" name="cus_contact">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Sub Total</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="sub_total" name="sub_total" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Discount</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="discount" name="discount">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Net Total</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="net_total" name="net_total" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Paid</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="paid" name="paid">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Due</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="due" name="due" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="payment_type" class="col-sm-4 col-form-label">Payment Type</label>
                        <div class="col-sm-6">
                            <select name="payment_type" class="form-control" id="payment_type">
                                <option value="Cash">Cash</option>
                                <option value="Card">Card</option>
                                <option value="Draft">Draft</option>
                                <option value="Cheque">Cheque</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn_save">Save Changes</button>
            </div>
            </div>
        </div>
    </div>

    <!-- /.container-fluid -->
    <script type="text/javascript" language="javascript">
         $(document).ready(function(){
             //Date Picker
            $('#order_date').datepicker({
                "autoclose": true,
                "format": 'yy-mm-dd',
            });
            $("#order_date").datepicker("setDate", new Date());
            var dataTable = $('#order_data').DataTable({
			   "order":[],
			   "ajax":{
				   url:"<?php echo base_url() . 'orders/fetch_orders'; ?>",  
			   }
            });
            //Reset Modal When Closed
            $(".modal").on("hidden.bs.modal", function(){
                $("#payment_form")[0].reset();
                $("#payment_form .form-control").removeClass('is-invalid').removeClass('is-valid');
            });
            // Payment Modal
			$('#selected_data').on('click', '.payment-edit', function(){
                var id = $(this).attr('data');
                $('#payment_modal').modal('show');
                $('#payment_form').attr('action', '<?php echo base_url(); ?>orders/update_payment/'+id);
                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '<?php echo base_url() ?>orders/edit_payment/'+id,
                    async: false,
                    dataType: 'json',
                    success: function(data){
                        $('input[name=order_date]').val(data.order_date);
                        $('input[name=cus_name]').val(data.customer_name);
                        $('input[name=cus_contact]').val(data.customer_contact);
                        $('input[name=order_id]').val(data.order_id);
                        $('input[name=sub_total]').val(data.sub_total);
                        $('input[name=discount]').val(data.discount);
                        $('input[name=net_total]').val(data.net_total);
                        $('input[name=paid]').val(data.paid);
                        $('input[name=due]').val(data.due);
                        $('select[name=payment_type]').val(data.payment_type);
                    },
                    error: function(){
                        alert('Could not Edit Data');
                    }
				});
			});

            function calculate(dis,paid){
                var sub_total = $('#sub_total').val();
                var net_total = $('#net_total').val();
                var discount = dis;
                var paid_amt = paid;
                var due = $('#due').val();
                net_total = sub_total - (sub_total * dis / 100);
                due = net_total - paid_amt;
                $('#net_total').val(net_total);
                $('#due').val(due);
            }
            $('#discount').keyup(function (){
                var discount = $(this).val();
                var paid = $('#paid').val();
                calculate(discount,paid);
            });
            $('#paid').keyup(function (){
                var paid = $(this).val();
                var discount = $('#discount').val();
                calculate(discount,paid);
            });
            // Save Changes
            $('#btn_save').click(function(){
                var url = $('#payment_form').attr('action');
                var data = $('#payment_form').serialize();
                $(".invalid-feedback").remove();
                $.ajax({
                    url: url,
                    data: data, // /converting the form data into array and sending it to server
                    method: 'post',
                    dataType: 'json',
                    success: function(response){
                        dataTable.ajax.reload(null, false); 
                        if(response.success === true){
                            toastr["success"](response.messages);
                            toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                            }
                            $('#payment_modal').modal('hide');
                            // reset the form
                            $("#payment_form")[0].reset();
                        }else{
                            if(response.messages instanceof Object) {
                                $.each(response.messages, function(index, value) {
                                var id = $("#"+index);
                                id.closest('.form-control')
                                .removeClass('is-invalid')
                                .removeClass('is-valid')
                                .addClass(value.length > 0 ? 'is-invalid' : 'is-valid');
                                
                                id.after(value);

                            });
                            }
                        }
                    }
                });
                
            });
         });

    </script>