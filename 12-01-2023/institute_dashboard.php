<?php 
include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php");exit;	}

$registration_id = filter($_SESSION['USERID']);
$bp_number = getBPNO($_SESSION['USERID'],$conn);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Institute Dashboard</title>
		<link rel="icon" href="https://gjepc.org/assets/images/fav_icon.png" type="image/x-icon"/>
		<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
		<link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
		
		<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
		<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
		<!--NAV-->
		<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js"></script>
		<script src="js/common.js"></script>
		<!--NAV-->
		<!-- UItoTop plugin -->
		<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css" />
		<script src="js/easing.js" type="text/javascript"></script>
		<script src="js/jquery.ui.totop.js" type="text/javascript"></script>
		<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
		
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178505237-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-178505237-1');
</script>
<!-- Global site tag (gtag.js) - Google Ads: 679056788 --> <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=AW-679056788"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-679056788'); </script>  -->
<!-- Event snippet for GJEPC_Google_PageView conversion page --> <script> gtag('event', 'conversion', {'send_to': 'AW-679056788/N1zUCJPKxLsBEJSr5sMC'}); </script> 
		<script type="text/javascript">
		$(document).ready(function() {
		$().UItoTop({ easingType: 'easeOutQuart' });
		});
		</script>
		<style>
		.member_type {
		float: right;
		margin-top: -70px;
		width: auto;
		height: auto;
		background: #a59c5b;
		}
		.member_type img{    display: inline-block;
		 width: 35px; 
		background: #a59c5b;
		
		margin-top: -1px;
			margin-right: -4px;}
		.member_type span{padding: 10px 15px;background: #a59459; font-weight:bold; color:#fff;}
		/*.box_dash{width: 90%;min-height:100px;margin-left: 50%;transform: translate(-50%);background: #fff;border: 1px solid #a59c5b;border-radius: 7px;
			text-align:center;-webkit-box-shadow: 6px 6px 9px -4px rgba(0,0,0,0.75);display: flex;justify-content: space-around;align-items: center;
		-moz-box-shadow: 6px 6px 9px -4px rgba(0,0,0,0.75);
		box-shadow: 6px 6px 9px -4px rgba(0,0,0,0.75);padding: 30px 0;}*/
		.btn{padding:10px 15px; text-align: center;/*margin-right: 8px;*/ border-radius: 5px;background: #000;color: #fff;	transition: all 0.4s ;margin: 10px 10px	}
		.btn:hover{background: #a59c5b;color:#000;}
		.box_dash_container{position: relative; margin-bottom:30px;}
		.box_dash_container .box_title {position: absolute;
		text-align: center;
		left: 0;
		right:0;
		z-index: 1;
		top: -22px;
		}
		.box_dash_container .box_title h3{display: inline-block; background:#fff; padding:0 10px;}
	/*	.{background: #f14e23}
		.yellow{background: #fdcd0a}
		.green{background: #99c31c}*/
		.box_exhibitor{flex-flow: column;padding-top: 30px;padding-bottom: 30px}
		#form-horizontal{margin: 20px 0; }

/*		.form-control{
  width: 100%;
  padding: 5px 5px;
  margin: 8px 0;
  box-sizing: border-box;
  text-align: left;
  border:1px solid#ccc;
  transition: all 0.6s;
}*/
.form-group{display: flex;
    flex-flow: row;justify-content: space-between;margin-bottom: 15px}

.box_dash a {position:relative;padding: 15px 20px 25px 20px; font-size:13px;}
.box_dash a span {position:absolute;bottom: -10px;max-width: 50px;margin: 0 auto;font-size: 12px;background: #fff;border: 2px solid #ddd;/* padding:0 10px; */line-height: 20px;color: #444;border-radius: 100px;font-weight:bold;left: 0;right: 0;}
@media screen and (max-width: 768px) {
	.box_dash{flex-wrap: wrap;}
	 .member_type {float:none; display:table; margin:0 auto 30px auto;}
}
</style>
</head>

<body>
		<div class="wrapper">
			<div class="header">
				<?php include('header1.php'); ?>
			</div>
			
			<div class="inner_container">
			<div class="bold_font text-center">
				<div class="d-block">
					<img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
				</div>
				My Dashboard
			</div>
				<div class="clear"></div>				
				<div class="content_area">					
				
					<div class="clear"></div>
					
					<div class="member_type">
						<img src="images/User-member.png" alt="Member, non-member">
							<span>	</span>						
					</div>	
					
					<?php
					/* Institute Registration Start  */
					if($_SESSION['COUNTRY']=="IN")
					{						
						echo "<div class='box_dash_container box-shadow '>
						<p><span class='blink d-block'></span> </p>
						<div class='box_title'><h3>Student Registration</h3></div>
						<div class='d-flex justify-content-center col-100'>";						
						echo '<a href="student_directory.php" class="btn col-100" title="Add / View Application">Add/View Student</a>';
						
						//echo '<a href="" class="btn col-100 ">Registration Closed</a>';	
						
						echo '<a href="student_registration.php" class="btn col-100" title="Select Show And Make Payment">Payment for Student</a>'; 
						
						//echo '<a href="#" class="btn col-100" title="Select Show And Make Payment">Registration Closed</a>';
						
						echo '</div>
						</div>';						 
					}
					?>			
					<div class="clear"></div>
					</div>
					
					<div class="clear"></div>
				</div>
				<div class="clear" style="height:10px;"></div>
			</div>
			<div class="footer">
				<?php include('footer.php'); ?>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
	</body>
</html>