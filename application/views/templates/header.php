<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?php echo $title; ?></title> 
  <!-- Custom fonts for this template-->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="<?php echo base_url() ?>assets/sb_admin/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="<?php echo base_url() ?>assets/sb_admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <link href="<?php echo base_url() ?>assets/sb_admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="<?php echo base_url() ?>assets/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url() ?>assets/sb_admin/vendor/jquery/jquery.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url() ?>assets/sb_admin/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="<?php echo base_url() ?>assets/sb_admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url() ?>assets/sb_admin/js/sb-admin-2.min.js"></script>
  <!-- Page level plugins -->
  <script src="<?php echo base_url() ?>assets/sb_admin/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url() ?>assets/sb_admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <!-- Page level custom scripts -->
  <script src="<?php echo base_url() ?>assets/sb_admin/js/demo/datatables-demo.js"></script>
  <script src="<?php echo base_url() ?>assets/datepicker/js/bootstrap-datepicker.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url() ?>dashboard">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">STOCK MANAGEMENT</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item <?php if($this->uri->segment(1)=="dashboard"){echo "active";}?>">
        <a class="nav-link" href="<?php echo base_url() ?>dashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Modules
      </div>
      <!-- Nav Item - Brands -->
      <li class="nav-item  <?php if($this->uri->segment(1)=="brands"){echo "active";}?>">
        <a class="nav-link" href="<?php echo base_url() ?>brands">
          <i class="fa fa-circle"></i>
          <span>Brands</span></a>
      </li>
      <!-- Nav Item - Categories -->
      <li class="nav-item <?php if($this->uri->segment(1)=="categories"){echo "active";}?>">
        <a class="nav-link" href="<?php echo base_url() ?>categories">
          <i class="fa fa-list-alt"></i>
          <span>Categories</span></a>
      </li>
      <!-- Nav Item - Products -->
      <li class="nav-item <?php if($this->uri->segment(1)=="products"){echo "active";}?>">
        <a class="nav-link" href="<?php echo base_url() ?>products">
          <i class="fas fa-tag" aria-hidden="true"></i>
          <span>Products</span></a>
      </li>
      <!-- Nav Item - Orders -->
      <li class="nav-item <?php if($this->uri->segment(1)=="orders"){echo "active";}?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse_order_pages" aria-expanded="true" aria-controls="collapse_order_pages">
          <i class="fas fa-shopping-cart"></i>
          <span>Orders</span>
        </a>
        <div id="collapse_order_pages" class="collapse <?php if($this->uri->segment(1)=="orders"){echo "show";}?>" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Order Options:</h6>
            <a class="collapse-item <?php if($this->uri->segment(2)=="add_order"){echo "active";}?>" href="<?php echo base_url() ?>orders/add_order">Add Order</a>
            <a class="collapse-item <?php if($this->uri->segment(2)=="manage_orders"){echo "active";}?>" href="<?php echo base_url() ?>orders/manage_orders">Manage Orders</a>
          </div>
        </div>
      </li>
       <!-- Nav Item - Reports -->
      <li class="nav-item <?php if($this->uri->segment(1)=="reports"){echo "active";}?>">
        <a class="nav-link" href="<?php echo base_url() ?>reports">
          <i class="fas fa-chart-bar" aria-hidden="true"></i>
          <span>Reports</span></a>
      </li>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $this->session->userdata('full_name')?></span>
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?php echo base_url() ?>profile">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->