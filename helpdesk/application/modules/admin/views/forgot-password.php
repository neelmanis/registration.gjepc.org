<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/ico" sizes="16x16" href="">

    <title>Adraas</title>

    <link href="<?php echo base_url(); ?>assets/admin/css/pages/login-register-lock.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/css/style.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/admin/node_modules/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    
    <script> var CI_ROOT = "<?php echo base_url(); ?>"; </script>
    
    <style>
      .darkBlueBg {
        background: #88ab4c;
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

      .banner{
        /* overflow: hidden; */
        background: #47296d;
      }

      .svgLogo{
        position: relative;
        width: 38%;
        left: -50px;
        top: 160px;
        pointer-events: none;
      }

      #captcha img{
        width:100% !important;
      }

      a {
        color: #0c0b5a;
      }

      a:hover {
        color: #34d0c9;
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
          <div class="ring">Adraas<span></span> </div>    
        </div>
      </div>
    </div>

    <section id="wrapper">

      <div class="login-register darkBlueBg">
        <div class="login-box card">
          <div class="card-body login-box">
            <form id="reset_password" class="form-material">
              <h3 class="box-title m-b-20" style="text-align:center;">PASSWORD RECOVERY</h3>

              <div class="form-group row">
                <div class="col-12">
                  <label class="control-label"><strong>Enter Username</strong></label>
                  <input class="form-control" type="text" id="username" name="username">
                  <label for="username" class="error"></label>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-6" id="captcha">
                  <?php echo $captcha['image']; ?>
                </div>
                <div class="col-md-6">
                  <input class="form-control" type="text" id="captcha" name="captcha" placeholder="Enter captcha">
                  <label for="captcha" class="error"></label>
                </div>
              </div>

              
              <?php $_SESSION["token"] = md5(uniqid(mt_rand(), true)); ?>
              <input type="hidden" name="csrfToken" id="csrfreg" value="<?php echo $_SESSION["token"];?>">
              
              <div class="form-group text-center">
                <div class="col-xs-12">
                  <input type="submit" class="btn btn-block btn-outline-success btn-rounded" value="Verify">
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
    <script src="<?php echo base_url(); ?>assets/utils/js/admin/password-recovery.js?<?php echo $global['version']; ?>"></script>

    <script>
      $(document).ready(function(){
        $("#status").fadeOut();       
        $("#preloader").delay(1000).fadeOut("slow");
      }) ;
    </script>

  </body>
</html>