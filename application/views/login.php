<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Stock Management System - Login</title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url() ?>assets/sb_admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url() ?>assets/sb_admin/css/sb-admin-2.min.css" rel="stylesheet">

   <!-- Sweet Alert CSS -->
   <link href="<?php echo base_url() ?>assets/sweetalert2/sweetalert2.min.css" rel="stylesheet">
  
  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url() ?>assets/sb_admin/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>assets/sb_admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url() ?>assets/sb_admin/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url() ?>assets/sb_admin/js/sb-admin-2.min.js"></script>

  <!-- Sweet Alert JS -->
  <script src="<?php echo base_url() ?>assets/sweetalert2/sweetalert2.min.js"></script>

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <form class="user" id="login_form" action="<?php echo base_url(); ?>login">
                    <div class="form-group">
                      <input type="username" name="username" class="form-control form-control-user" id="username" placeholder="Enter Username">
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-user" id="password" placeholder="Enter Password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                    <hr>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
  <script type="text/javascript" language="javascript">
    $(document).ready(function (){
      $('#login_form').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        // perform ajax
        $.ajax({
          url: form.attr('action'),
          type: 'POST',
          dataType: 'json',
          data: form.serialize(), // /converting the form data into array and sending it to server
          async: false,
          success: function (response) {
            if (response.error == false) {
                window.location.href = '<?php echo base_url(); ?>dashboard';
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Invalid Login. Please try again'
            })
            }
          }
        });
      });

    });

  </script>
</body>

</html>
