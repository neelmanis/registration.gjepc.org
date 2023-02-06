<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="" type="image/x-icon">

    <title>Admin |  Panel</title>
    <!-- <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $global['web_assets']; ?>images/favicon-32x32.png"> -->
    <link href="<?php echo  base_url();?>assets/admin/css/pages/dashboard1.css" rel="stylesheet">
    <link href="<?php echo  base_url();?>assets/admin/node_modules/css-chart/css-chart.css" rel="stylesheet">
    <link href="<?php echo  base_url();?>assets/admin/css/style.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/css/pages/widget-page.css" rel="stylesheet">
    <link href="<?php echo  base_url();?>assets/admin/css/pages/tab-page.css" rel="stylesheet">
    <link href="<?php echo  base_url();?>assets/admin/node_modules/switchery/dist/switchery.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/admin/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/css/responsive.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" type="text/css" />      
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" rel="stylesheet" type="text/css" />
    
    <?php if( $viewFile == "milestone/add" || $viewFile == "milestone/update" ){ ?>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
    <?php }else{ ?>
      <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <?php } ?>

    <script src="<?php echo  base_url();?>assets/admin/node_modules/jquery/jquery-3.2.1.min.js"></script>    
    <script type="text/javascript"> var CI_ROOT = "<?php echo base_url(); ?>"; </script>
    <style>
     .skin-green .topbar {
        background: #1aa4aa;
      }
    
      .topbar .top-navbar .profile-pic span {
        color: white;
      }

      .navbar-brand span{
        font-size: 21px;
        font-weight: 600;
      }
    
      .logo_abs{
        position: absolute;
        left: 0px;
        width: 221px;
        height: 67px;
        top: 0px;
        right: 0px;
      }
    
      .logo_sm{
        max-height: 60px; width: 71px;
      }
    
      .error{
        color:#F00; margin:2px 0px; font-size:13px; display:none;
      }
    
      .form-control{
        border: solid;
        border-color: #BCB7B7;
        text-transform: none;
      }

      .form-card-header{
        background-color: #004884;
        /* background-color: #ea5297; */
        /* background-color: #38102b; */
      }
    
      .form-control.profile-form {
        border: 1px solid;
        border-color: #3c1c1c;
        text-transform: none;
      }
   
      .inner-header{
        background-color: #71072e
      }
    
      .bg-info {background-color: #e8b720!important;}
      .text-white{font-weight: bold; font-size: 20px;}
      .label{
        width: 100px;
        display: inline-block;
        text-align: center;
        font-size: smaller;
        padding-top: 8px;
        height: 30px;
      }
      .area-info{
        text-align: center;
      }
    
      .icon-menu{
        color:#fdfdfe;
      }
    
      .submenu-name{
        font-size:small;
      }
    
      .color_dot {
        height: 25px;
        width: 25px;
        /* background-color: #bbb; */
        border-radius: 50%;
        display: inline-block;
      }
    
      .btn-circle {
        border-radius: 100%;
        width: 30px;
        height: 30px;
        padding: 5px;
      }

      .form-control:disabled, .form-control[readonly] {
        opacity: 1;
      }

      .color-table.green-table thead th {
        background-color: #326063;
        color: #fff;
      }

      .color-table.purple-table thead th {
        background-color: #134563;
        color: #fff;
      }

      .dropdown-item.active, .dropdown-item:active {
        color: #fff;
        text-decoration: none;
        background-color: #31a2a7;
      }

      #preloader{position:fixed; top:0; background-color:#fff; z-index:99999; width:100%; height:100%; overflow:hidden; }
      .ring {position: relative; width: 150px; height: 150px; background: transparent; border:1px solid #ddd; border-radius: 100px;
      text-align: center; line-height: 150px; font-size: 14px; color: #000;}
      .ring:before {content: ''; position: absolute; top: -2px; left: -2px; width: 150px; height: 150px; border:2px solid transparent;
      border-top:2px solid #000; border-right:2px solid #000; border-radius:50%; animation:animateLoader 2s linear infinite;}
      .ring span {display: block; position: absolute; top: calc(50% - 2px); left: 50%; width: 50%; height: 4px; background: transparent;
      transform-origin: left; animation: animate 2s linear infinite;}
      .ring span:before {content: ''; position: absolute; width: 16px; height: 16px; border-radius: 50%; background: #1dc6ef; top: -6px;
      right: -8px;}
      @keyframes animateLoader { 0% {transform:rotate(0deg);} 100% { transform:rotate(360deg);} }
      @keyframes animate { 0% {transform:rotate(45deg);} 100% { transform:rotate(405deg);} }

      .ring img{ max-width:80px; margin-top:20px;}

      .skin-green .sidebar-nav>ul>li.active>a {
        color: #004884;
        border-left: 3px solid #004884;
      }

      .skin-green .page-titles .breadcrumb .breadcrumb-item.active, .skin-green .sidebar-nav ul li a.active, .skin-green .sidebar-nav ul li a.active i, .skin-green .sidebar-nav ul li a:hover, .skin-green .sidebar-nav ul li a:hover i, .skin-green .sidebar-nav>ul>li.active>a i {
        color: #004884;
      }
    </style>

  </head>

  <body class="skin-green fixed-layout">

    <div id="preloader" class="vh-100">
      <div class="d-flex justify-content-center h-100">
        <div id="status" class="m-auto">
          <div class="ring">loading...<span></span> </div>    
        </div>
      </div>
    </div>

    <div id="main-wrapper">
      <?php $this->load->view('includes/admin/header.php'); ?>
      <?php $this->load->view('includes/admin/side-menu.php'); ?>

      <div class="page-wrapper">
        <div class="container-fluid">
          <?php
            if(!isset($module)){
              $module = $this->uri->segment(1);
            }

            if(!isset($viewFile)){
              $viewFile = $this->uri->segment(2);
            }
            
            if( $module != '' && $viewFile != '' ){
              $path = $module. '/' . $viewFile;
              echo $this->load->view($path);
            }
          ?>
        </div>
      </div>
      
      <!-- COMMON AJAX MODAL START-->
      <div class="modal fade" id="app-modal" tabindex="-1" role="dialog" aria-labelledby="app-modal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="app-modal-content">
              
            </div>
            
          </div>
        </div>
      </div>
        <!-- COMMON AJAX MODAL END-->
      <div class="clearfix" style="height:50px;"></div>
      <?php $this->load->view('includes/admin/footer.php'); ?>
    </div>
    
    <script src="<?php echo  base_url();?>assets/admin/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo  base_url();?>assets/admin/node_modules/popper/popper.min.js"></script>
    <script src="<?php echo  base_url();?>assets/admin/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="<?php echo  base_url();?>assets/admin/js/waves.js"></script>
    <script src="<?php echo  base_url();?>assets/admin/js/sidebarmenu.js"></script>
    <script src="<?php echo  base_url();?>assets/admin/js/custom.min.js"></script>
    <script src="<?php echo  base_url();?>assets/admin/node_modules/raphael/raphael-min.js"></script>
    <script src="<?php echo  base_url();?>assets/admin/node_modules/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="<?php echo  base_url();?>assets/admin/js/dashboard1.js"></script>
    <script src="<?php echo  base_url();?>assets/admin/node_modules/switchery/dist/switchery.min.js"></script>

    <script src="<?php echo base_url('assets/admin/datatables/js/jquery.dataTables.min.js')?>"></script>
    <script src="<?php echo base_url('assets/admin/datatables/js/dataTables.bootstrap.min.js')?>"></script>
    
    <script src="<?php echo  base_url();?>assets/admin/js/main.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" type="text/javascript"></script>
    
    <?php if( $viewFile == "milestone/add" || $viewFile == "milestone/update" ){ ?>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
    <?php }else{ ?>
      <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/js/gijgo.min.js" type="text/javascript"></script>
    <?php } ?>
    
    <script src="<?php echo base_url(); ?>assets/utils/js/sweetalert.min.js"></script>

    <script src="//cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
    
    <script src="<?php echo base_url(); ?>assets/utils/js/admin/utility.js?<?php echo $global['version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/utils/js/admin/datatable.js?<?php echo $global['version']; ?>"></script>

    <?php if(isset($scriptFile) && ! empty($scriptFile)){ ?>
      <script src="<?php echo base_url(); ?>assets/utils/js/admin/<?php echo $scriptFile.'.js?'.$global['version']; ?>"></script>
    <?php } ?>

    <script>
      $(document).ready(function(){
        $("#status").fadeOut();       
        $("#preloader").delay(1000).fadeOut("slow");
      }) ;
    </script>
    
  </body>
</html>