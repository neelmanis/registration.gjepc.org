<?php include('header_include.php');?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to India International Jewellery Show</title>
    <link rel="icon" href="https://gjepc.org/assets/images/fav_icon.png" type="image/x-icon"/>
     <link rel="stylesheet" type="text/css" href=" https://www.gjepc.org/assets-new/css/bootstrap.min.css" /> 
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








<div class="container my-5">

	<div class="bold_font text-center">
		<div class="d-block"><img src="https://www.gjepc.org/assets/images/gold_star.png" class="mb-3"></div>
		New Visitor Registration Process
	</div>


	<ul class="inner_under_listing">
		<li>Enter your pan number or login with your username and password on  <strong><a href="https://registration.gjepc.org/single_visitor.php" target="_blank" class="gold_clr">(https://registration.gjepc.org/single_visitor.php)</a></strong></li>
		<li>Enter your pan number to register yourself</li>
		<li>Enter your Company details</li>
		<li>Upload copy of Person Pan card, Company GST Certificate, passport size photo and recommendation letter on company letterhead for employee’s registration too, if any</li>
		<li>After approval of the above documents proceed to submit payments online</li>
		<li>On completion of payments, upload Final Vaccination Certificate of self and employees as registered above, if any,  to complete your registration process.</li>
		<li>After your VC is verified as per your registration details submitted, you will receive notification via WhatsApp, SMS and email on successful approval of your documents and payments. </li>
	</ul>

	<style>
		p {font-size: 15px; line-height: 26px;}
		.gold_clr {color: #a89c5d;}
		li a:hover {text-decoration: none; color: #000}
		.inner_under_listing li {font-size: 15px;}
	</style>

</div>




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