<?php include('header_include.php');
 if(!isset($_SESSION['registration_id']) && !isset($_SESSION['visitor_id']) ){ header("location:visitor-covid-report-upload.php");	exit; }
 if($_SESSION['isMobileVerified']!="YES" && $_SESSION['requestFor']!="covid-report"  ){ header("location:visitor-covid-report-upload.php");	exit; }
  
$registration_id = $_SESSION['registration_id'];
$visitor_id = $_SESSION['visitor_id'];
$email = getVisitorEmail($visitor_id,$conn); 
$CompanyName = getCompanyName($registration_id,$conn); 
$visitorName = getVisitorName($visitor_id,$conn); 
$visitorMobile = getVisitorMobile($visitor_id,$conn);
$visitorPAN = getVisitorPAN($visitor_id,$conn);
$ownerMobile = getOwnerVisitorMobile($registration_id,$conn);
$visitoSecondaryMobile = getVisitorSecondaryMobile($visitor_id,$conn);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<title>Welcome to IIJS</title>
<link rel="shortcut icon" href="images/fav.png" />
	<!-- <link rel="stylesheet" type="text/css" href="css/mystyle.css" /> -->
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
	<link rel="stylesheet" type="text/css" href="css/general.css" />
	<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />
	 
	<link rel="stylesheet" type="text/css" href="css/responsive.css" />
	<link rel="stylesheet" type="text/css" href="css/media_query.css" />
	<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css?v=<?php echo $version;?>" />
	
	<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox.min.js?v=<?php echo $version;?>"></script>
	<!--NAV-->
	<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="js/jquery.flexnav.js" type="text/javascript"></script>
	<script src="js/common.js"></script> 
	<!--NAV-->
	 <script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>

	<!-- UItoTop plugin -->
	<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css" />
	<script src="js/easing.js" type="text/javascript"></script>
	<script src="js/jquery.ui.totop.js" type="text/javascript"></script>    
	
	<script type="text/javascript">
		// $(document).ready(function() {        
		// 	$().UItoTop({ easingType: 'easeOutQuart' });        
		// });
	</script>
	<style type="text/css">
		.container_wrap{  border: 1px solid#aa9e5f;}
		.error{color:red;}
	</style>

</head>

<body>
<div class="wrapper">

<div class="header">
	<?php include('header1.php'); ?>
</div>
<!--container starts-->

<?php
$show ="iijs22";
$year = 2022;
?>
		<div class="container my-5">
			<!-- <div class="border w-100"></div> -->
			<div class="bold_font text-center">
              <div class="d-block">
                  <img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
              </div>
            Vaccination Certificate Upload
          </div>
			<?php include("include_vaccine_upload.php");?>
		
</div>

<div class="footer">
        <?php include ('footer.php'); ?>
      </div>

<!--footer ends-->
</body>
</html>