<?php include('header_include.php');?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Air Ticket Booking</title>
    <link rel="icon" href="https://gjepc.org/images/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="css/general.css" />
    <link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />
    <link rel="stylesheet" type="text/css" href="css/responsive.css" />
    <link rel="stylesheet" type="text/css" href="css/media_query.css" />
    <link rel="stylesheet" type="text/css" href="css/visitor_reg.css" />
    <link rel="stylesheet" type="text/css" href="css/new_style.css" /> 

    <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
   <!--NAV-->
	<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js"></script>
	<script src="js/common.js"></script> 
	<!--NAV-->
    <!-------------------------Form Validations------------------------------->
    <script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
    
  </head>
  
<body>

<div class="wrapper">
	
    <div class="header">
		<?php include('header1.php'); ?>
		<div class="clear"> </div>
	</div>
    <div class="clear"> </div>
    <!--<div class="new_banner">
    	<img src="images/banners/banner.jpg">
    </div> -->

    <!--container starts-->
    <div class="container_wrap">
    
    	<div class="container">
        
        	<span class="headtxt">IIJS Signature 2020 Airline Booking Form to get travel benefits</span>
            
          	<div id="loginForm">
            	
                <div id="formContainer">
              		<?php 
						if(isset($_SESSION['succ_msg']))
							echo "<h3 style='color:#0C0'>".$_SESSION['succ_msg']."</h3>";
						else
							echo "<h3 style='color:#F00'>".$_SESSION['err_msg']."</h3>";
					
					?>
             	</div>
            </div>
		</div>
        <div class="clear"></div>
	</div>
	<!--container ends-->

</div>

<!--footer starts-->
<div class="footer">
	<?php include ('footer.php'); ?>
</div>
<!--footer ends-->

<style>
	
	#formContainer {padding:20px;}
	#visitor_wrp {display:none;}
	label {margin-bottom:10px; display:block;}
	.col-50 {float:left;}
	.form-group {padding:0;}
	.form-control:focus {
    border: 1px solid #222;
}
	.btn-submit {box-shadow:none; border:0; height:32px; padding:0 15px; cursor:pointer;}
	#otp {display:none;}
	
</style>

</body>
</html>