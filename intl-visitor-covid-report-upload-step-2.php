<?php include('header_include.php');
if(!isset($_SESSION['uid'])){ header("location:single_intl_registration.php");	exit; }

$uid = $_SESSION['uid'];
$eid = $_SESSION['eid']; 
$email = $_SESSION['email']; 






?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WELCOME TO INTERNATIONAL VISITOR VACCINATION CERTIFICATE UPLOAD</title>
<link rel="shortcut icon" href="images/fav.png" />
 <link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/mystyle.css?v=<?php echo $version;?>" />
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
	<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
	 
	<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
	 <link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
	<script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>

	<!--NAV-->
	<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="js/jquery.flexnav.js?v=<?php echo $version;?>" type="text/javascript"></script>
	<script src="js/common.js?v=<?php echo $version;?>"></script> 
	<!--NAV-->
	<script src="jsvalidation/jquery.validate.js?v=<?php echo $version;?>" type="text/javascript"></script>

	<!-- UItoTop plugin -->
	<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css?v=<?php echo $version;?>" />
	<script src="js/easing.js?v=<?php echo $version;?>" type="text/javascript"></script>
	<script src="js/jquery.ui.totop.js?v=<?php echo $version;?>" type="text/javascript"></script>    
	<script type="text/javascript">
		$(document).ready(function() {        
			$().UItoTop({ easingType: 'easeOutQuart' });        
		});
	</script>
</head>

<body>
<div class="header"><?php include('header1.php'); ?></div>
<div class="wrapper my-5">
  
<!--container starts-->
	
<!-- <div class="container my-5">
	
	<div class="bold_font text-center">
        <div class="d-block">
          <img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
        </div>
        INTERNATIONAL VISITOR VACCINATION CERTIFICATE UPLOAD
      </div>

</div> -->

<div class="container">
	<?php include("include_intl_vaccine_upload.php");?>
</div>
</div>

<div class="footer">
	<?php include ('footer.php'); ?>
</div>

<!--footer ends-->
</body>
</html>