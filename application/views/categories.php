    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Categories</h1>
            <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Categories List</h6>
                <button type="button" class="btn btn-outline-primary float-sm-right" id="btn_add">
                            Add Records
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="category_data" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Status</th>
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

    <!-- Categories Modal -->
    <div class="modal fade" id="category_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="category_form">
                    <input type="hidden" name="category_id" id="category_id" value="0">
                    <div class="form-group">
                        <label for="">Category Name</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter Category Name">
                    </div>
                    <div class="form-group">
                        <label for="">Status</label>
                        <select name="cat_status" class="form-control" id="cat_status">
                            <option value="0">Not Active</option>
                            <option value="1">Active</option>
                        </select>
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
        $(document).ready(function(){
           var dataTable = $('#category_data').DataTable({
			   "order":[],
			   "ajax":{
				   url:"<?php echo base_url() . 'categories/fetch'; ?>",  
			   }
            });
            //Reset Modal When Closed
            $(".modal").on("hidden.bs.modal", function(){
                $("#category_form")[0].reset();
                $("#category_form .form-control").removeClass('is-invalid').removeClass('is-valid');
            });
            //Add New
            $('#btn_add').click(function(){
                $('#category_modal').modal('show');
                $('#category_modal').find('.modal-title').text('Add New Category');
                $('#category_form').attr('action', '<?php echo base_url(); ?>categories/insert');

            });
            //Inserting/Updating data
            $('#btn_save').click(function(){
                var url = $('#category_form').attr('action');
                var data = $('#category_form').serialize();
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
                            $('#category_modal').modal('hide');
                            // reset the form
                            $("#category_form")[0].reset();
                            $("#category_form .form-control").removeClass('is-invalid').removeClass('is-valid');

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
                                $('#category_modal').modal('hide');
                                }
                            }
                        }
                });
                
            });
            //EDIT CATEGORY
			$('#selected_data').on('click', '.item-edit', function(){
                var id = $(this).attr('data');
                $('#category_modal').modal('show');
                $('#category_modal').find('.modal-title').text('Edit Category');
                $('#category_form').attr('action', '<?php echo base_url(); ?>categories/update/'+id);
                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '<?php echo base_url() ?>categories/edit/'+id,
                    async: false,
                    dataType: 'json',
                    success: function(data){
                        $('input[name=category_id]').val(data.category_id);
                        $('input[name=category_name]').val(data.category_name);
                        $('select[name=cat_status]').val(data.cat_status);
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
                                url: '<?php echo base_url(); ?>categories/delete/'+del_id,
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