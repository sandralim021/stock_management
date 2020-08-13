    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Reports</h1>
         <!-- Generate Report -->
         <div class="card shadow mb-4">
            <div class="card-header">
                Generate Report
            </div>
            <div class="card-body">
            <form id="generate_form" action="<?php echo base_url(); ?>reports/fetch" method="POST" target="_blank">
                <div class="form-group row justify-content-center">
                    <label for="start_date" class="col-sm-2 col-form-label">Start Date</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="start_date" name="start_date" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <label for="end_date" class="col-sm-2 col-form-label">End Date</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="end_date" name="end_date" autocomplete="off">
                    </div>
                </div>
                <div align="center">
                    <button type="submit" id="btn_save" name="btn_save" class="btn btn-primary">Generate</button>
                </div>
            </form>
            </div>
        </div>
        
    </div>
    <!-- /.container-fluid -->
    <script type="text/javascript" language="javascript">
        $(document).ready(function (){
            $('#start_date').datepicker({
                "autoclose": true
            });
            $("#start_date").datepicker("setDate", new Date());
            $('#end_date').datepicker({
                "autoclose": true
            });
            $("#end_date").datepicker("setDate", new Date());

            
        });
    </script>