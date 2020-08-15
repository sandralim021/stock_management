    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Products</h1>
            <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Products List</h6>
                <button type="button" class="btn btn-outline-primary float-sm-right" id="btn_add">
                            Add Records
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="product_data" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th width="10%">Quantity</th>
                                <th width="15%">Alert Quantity</th>
                                <th>Price</th>
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
    
    <!-- Insert / Edit Modal -->
    <div class="modal fade" id="product_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="product_form">
                <div class="form-group">
                        <input type="hidden" id="product_id" name="product_id">
                        <label for="brand_id">Brand</label>
                        <select class="form-control" id="brand_id" name="brand_id">
                            <?php foreach($brands as $row): ?>
                                <option value="<?php echo $row['brand_id'];?>">
                                    <?php echo $row['brand_name']; ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control" id="category_id" name="category_id">
                            <?php foreach($categories as $row): ?>
                                <option value="<?php echo $row['category_id'];?>">
                                    <?php echo $row['category_name']; ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Product Name</label>
                        <input type="text" class="form-control" id="product_name" name="product_name">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Quantity</label>
                            <input type="number" class="form-control" id="qty" name="qty">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Alert Quantity</label>
                            <input type="number" class="form-control" id="alert_qty" name="alert_qty">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Product Price</label>
                            <input type="number" class="form-control" id="price" name="price">
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
    
    <script type="text/javascript" language="javascript">
       $(document).ready(function (){
            var dataTable = $('#product_data').DataTable({
                "order":[],
                "ajax":{
                    url:"<?php echo base_url() . 'products/fetch'; ?>",  
                }
            });
            //Reset Modal When Closed
            $(".modal").on("hidden.bs.modal", function(){
                $("#product_form")[0].reset();
                $("#product_form .form-control").removeClass('is-invalid').removeClass('is-valid');
            });
             //Add New
             $('#btn_add').click(function(){
                $('#product_modal').modal('show');
                $('#product_modal').find('.modal-title').text('Add New Product');
                $('#product_form').attr('action', '<?php echo base_url(); ?>products/insert');

            });
            //Inserting/Updating data
            $('#btn_save').click(function(){
                var url = $('#product_form').attr('action');
                var data = $('#product_form').serialize();
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
                            $('#product_modal').modal('hide');
                            // reset the form
                            $("#product_form")[0].reset();
                            $("#product_form .form-control").removeClass('is-invalid').removeClass('is-valid');

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
                            } else {
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
                                $('#product_modal').modal('hide');
                                }
                            }
                        }
                });
                
            });
            //EDIT Products
			$('#selected_data').on('click', '.item-edit', function(){
                var id = $(this).attr('data');
                $('#product_modal').modal('show');
                $('#product_modal').find('.modal-title').text('Edit Product');
                $('#product_form').attr('action', '<?php echo base_url(); ?>products/update/'+id);
                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '<?php echo base_url() ?>products/edit/'+id,
                    async: false,
                    dataType: 'json',
                    success: function(data){
                        $('input[name=product_id]').val(data.product_id);
                        $('select[name=brand_id]').val(data.brand_id);
                        $('select[name=category_id]').val(data.category_id);
                        $('input[name=product_name]').val(data.product_name);
                        $('input[name=qty]').val(data.qty);
                        $('input[name=alert_qty]').val(data.alert_qty);
                        $('input[name=price]').val(data.price);
                        $('select[name=prod_status]').val(data.prod_status);
                    },
                    error: function(){
                        alert('Could not Edit Data');
                    }
				});
			});
            //DELETE CATEGORY
            $('#selected_data').on('click', '.item-delete', function(){
                var del_id = $(this).attr("data");
                if(del_id == ""){
                    alert("Deleted id required");
                }else{
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger mr-2'
                        },
                        buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, cancel!',
                        reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                            $.ajax({
                                type: 'ajax',
                                method: 'get',
                                async: false,
                                url: '<?php echo base_url(); ?>products/delete/'+del_id,
                                dataType: 'json',
                                success: function(response){
                                    dataTable.ajax.reload(null, false); 
                                    swalWithBootstrapButtons.fire(
                                    'Deleted!',
                                    'Selected data has been deleted.',
                                    'success'
                                    )
                                }
                            });
                        
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            '',
                            'error'
                        )
                    }
                    })

                }
			});	

       });
    </script>