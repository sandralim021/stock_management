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
    <!-- /.container-fluid -->
    <script type="text/javascript" language="javascript">
         $(document).ready(function(){
            var dataTable = $('#order_data').DataTable({
			   "order":[],
			   "ajax":{
				   url:"<?php echo base_url() . 'orders/fetch_orders'; ?>",  
			   }
            });
         });
    </script>