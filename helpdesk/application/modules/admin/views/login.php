<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="https://gjepc.org/assets/images/fav_icon.webp">
    <title>Helpdesk Admin Login</title>
    <link rel="stylesheet" href="<?php echo $global['web_assets']; ?>css/bootstrap.min.css">
    <link href="<?php echo base_url(); ?>assets/admin/css/pages/login-register-lock.css?v=1.2" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/css/style.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/admin/node_modules/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    
    <script> var CI_ROOT = "<?php echo base_url(); ?>"; </script>
    
    <style>     
     .login-box {
         -webkit-box-shadow: 10px 10px 17px -8px rgba(0,0,0,0.75);
        -moz-box-shadow: 10px 10px 17px -8px rgba(0,0,0,0.75);
        box-shadow: 10px 10px 17px -8px rgba(0,0,0,0.75);
        max-width: 500px;
        border-radius: 11px;
        margin: 0 auto;
        display: inline-block;
      }
      .login-register {
       
          background-size: cover;
          background-repeat: no-repeat;
          background-position: center center;
          height: 100vh; 
          display: flex; 
          align-items: center; 
          justify-content: center;
        }
      .darkBlueBg {
        background: #343a40;
      }

      .error {
        color: #F00;
        font-size: 12px;
        display: none;
      }
    
      .form-control{
        border-color: #BCB7B7;
      }

      .login-box{
        -webkit-box-shadow: 10px 10px 17px -8px rgba(0,0,0,0.75);
        -moz-box-shadow: 10px 10px 17px -8px rgba(0,0,0,0.75);
        box-shadow: 10px 10px 17px -8px rgba(0,0,0,0.75);
      }
      #captcha img{
        width:100% !important;
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
    </style>

  </head>

  <body class="skin-blue card-no-border">

    <div id="preloader" class="vh-100">
      <div class="d-flex justify-content-center h-100">
         <div id="status" class="m-auto">
          <div class="ring"> <img src="<?php echo  base_url("assets/admin/images/gjepc_logo.png");?>" class="img-fluid w-25 mt-0"><span></span> </div>    
        </div>
      </div>
    </div>

    <section id="wrapper">

      <div class="login-register darkBlueBg">
        <div class="card login-box">
          <div class="card-body ">
            <form id="admin_login" class="form-material"  autocomplete="false">
            <div class="form-group mb-2 ">
            <div class="col-md-12 text-center">
            <img src="<?php echo  base_url("assets/admin/images/gjepc_logo.png");?>" class="img-fluid w-25"> 
            <h3 class="box-title text-center mt-2 text-bold"><span style="font-weight: 700;">ADMIN LOGIN </span></h3>
            </div>
            </div>
              <div class="form-group ">
                <div class="col-md-12">
                  <label>Email</label>
                  <input class="form-control" type="text" id="email_id" name="email_id" placeholder="Enter Email" autocomplete="false" autofocus="false">
                  <label for="username" class="error"></label>
                </div>
              </div>
              <div class="form-group ">
                <div class="col-md-12">
                  <label>Password</label>
                  <input class="form-control" type="password" id="password" name="password" placeholder="Enter Password" autocomplete="new-password">
                  <label for="password" class="error"></label>
                </div>
              </div>
              
              <?php $_SESSION["token"] = md5(uniqid(mt_rand(), true)); ?>
              <input type="hidden" name="csrfToken" id="csrfreg" value="<?php echo $_SESSION["token"];?>">
              <div class="form-group text-center">
                <div class="col-xs-12">
                  <input type="submit" class="btn btn-block btn-outline-success btn-rounded" value="Login">
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>

    </section>
    
    <script src="<?php echo base_url(); ?>assets/admin/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/node_modules/popper/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/utils/js/sweetalert.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/utils/js/admin/utility.js?<?php echo $global['version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/utils/js/admin/login.js?<?php echo $global['version']; ?>"></script>
    <script>
      $(document).ready(function(){
        $("#status").fadeOut();       
        $("#preloader").delay(1000).fadeOut("slow");
      }) ;
    </script>
  </body>
</html>