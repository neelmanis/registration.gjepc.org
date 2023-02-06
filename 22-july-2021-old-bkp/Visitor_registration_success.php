<?php include('header_include.php');
/*$registration_id = $_SESSION['registration_id'];*/
/*echo $registration_id ;exit;*/
/*print_r($_SESSION['USERID']);*/
$message = $_SESSION['successMessage'];
if(!isset($_SERVER['HTTP_REFERER']))
{

header("location:https://iijs.org");
unset($_SESSION);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to IIJS Registration</title>
    <link rel="shortcut icon" href="images/fav.png" />
    <!--  <link rel="stylesheet" type="text/css" href="css/mystyle.css" />
    -->  <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Cabin'>
    <link rel="stylesheet" type="text/css" href="css/general.css" />
    <link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />
    <link rel="stylesheet" type="text/css" href="css/responsive.css" />
    <link rel="stylesheet" type="text/css" href="css/media_query.css" />
    <link rel="stylesheet" type="text/css" href="css/visitor_reg.css" />
    <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
    <!--NAV-->
    <link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
    <!--<script src="js/jquery.flexnav.js" type="text/javascript"></script>-->
    <script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js"></script>
    <script src="js/common.js"></script>
    <!--NAV-->
    <script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
  </head>
  <body>
    <div class="wrapper">
      <div class="header">
        <?php include('header1.php'); ?>
      </div>
      <div class="new_banner">
        <img src="images/banners/banner.jpg">
      </div>
      <div class="clear"></div>
      <!--container starts-->
      <div class="container_wrap">
        <div class="container">
          <span class="headtxt">IIJS VIRTUAL SHOW 2020 Registration </span>
          <div id="loginForm">
            <div id="formContainer">
              <p id="successMessage" style="margin-top: 50px;font-size: 18px;text-transform: none;text-align: center;line-height: 44px">
              <?php echo $message;  ?>  </p>
            </div>
          </div>
        </div>
        <div class="clear"></div>
      </div>
    </div>
    <!--container ends-->
    <!--footer starts-->
    <div class="footer">
      <?php include ('footer.php'); ?>
    </div>
  </div>
  <!--footer ends-->
  <link rel="stylesheet" type="text/css" href="css/new_style.css" />
</body>
</html>