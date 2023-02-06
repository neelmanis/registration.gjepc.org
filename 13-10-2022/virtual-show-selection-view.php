<?php 
include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit; }
$registration_id = filter($_SESSION['USERID']);

$sqlt = "select * from virtual_event_registration where registration_id='$registration_id' and event_version='VIRL2';";
$anst = $conn->query($sqlt);
$result = $anst->fetch_assoc();
$event = $result['event'];
$additional_image = $result['additional_image'];
$meeting_room = $result['meeting_room'];
$show_charge = $result['show_charge'];
$image_charge = $result['image_charge'];
$meeting_charge = $result['meeting_charge'];
$sub_total_cost = $result['sub_total_cost'];
$gst_total_cost = $result['gst_total_cost'];
$grand_total_cost = $result['grand_total_cost'];

function getEventName($event,$conn)
{
	$query_sel = "SELECT section_desc FROM virtual_event_master where event='$event'";
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		 	
	return $row['section_desc'];		
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Virual Show Selection view</title>
		<link rel="icon" href="https://gjepc.org/images/favicon.ico" type="image/x-icon"/>
		<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
		<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />		
		<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
		<script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>
		<!--NAV-->
		<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js?v=<?php echo $version;?>"></script>
		<script src="js/common.js?v=<?php echo $version;?>"></script>
		<!--NAV-->
		<!-- UItoTop plugin -->
		<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css?v=<?php echo $version;?>" />
		<script src="js/easing.js?v=<?php echo $version;?>" type="text/javascript"></script>
		<script src="js/jquery.ui.totop.js?v=<?php echo $version;?>" type="text/javascript"></script>
		<script src="jsvalidation/jquery.validate.js?v=<?php echo $version;?>" type="text/javascript"></script> 
         <link rel="stylesheet" type="text/css" media="screen" href="css/rcmc.validation.css?v=<?php echo $version;?>" />
		<script type="text/javascript">
		$(document).ready(function() {
		$().UItoTop({ easingType: 'easeOutQuart' });
		});
		</script>
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
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '398834417477910');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=398834417477910&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

</head>

<body>

		<div class="wrapper">
			<div class="header"><?php include('header1.php'); ?></div>
<div class="inner_container">
				
	<div class="container_wrap">
		<div class="container">
           <span class="headtxt"></span>	
           <div id="loginForm">		  
           
        <div id="formContainer">
        
        <div class="title"><h4 style="text-align: center; color: #fff; display: table; background: #00000099; margin: 0 auto; border: 1px solid#000;
    -webkit-box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); -moz-box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); border-radius: 6px;">IIJS VIRTUAL 2.0 Details</h4></div>
	<div class="clear"></div>
	
    <div class="borderBottom"></div>
  
        <div class="d-flex flex-column">	
			<div class="field_box">
			<div class="field_box">
			<div class="field_name">Package </div>
			<div class="field_input">
			<?php echo '<b>'.getEventName($event,$conn).'</b>'; ?>
			</div>
			<div class="clear"></div>
			</div>
			
			<div class="field_box">
			<div class="field_name">Additional Images </div>
			<div class="field_input">
			<?php echo $additional_image; ?>
			</div>
			<div class="clear"></div>
			</div>
			
			<div class="field_box">
			<div class="field_name">Additional Meeting Rooms </div>
			<div class="field_input">
			<?php echo $meeting_room; ?>
			</div>
			<div class="clear"></div>
			</div>
			
			<div class="field_box">
			<div class="field_name">Package Charges </div>
			<div class="field_input">
			<?php echo $show_charge; ?>
			</div>
			<div class="clear"></div>
			</div> 
			
			<div class="field_box">
			<div class="field_name">Additional Image Charges </div>
			<div class="field_input">
			<?php echo $image_charge; ?>
			</div>
			<div class="clear"></div>
			</div> 
			
			<div class="field_box">
			<div class="field_name">Additional Meeting Room Charges </div>
			<div class="field_input">
			<?php echo $meeting_charge; ?>
			</div>
			<div class="clear"></div>
			</div> 
			
			<div class="field_box">
			<div class="field_name">Sub Total cost </div>
			<div class="field_input">
			<?php echo $sub_total_cost; ?>
			</div>
			<div class="clear"></div>
			</div>   
			
			<div class="field_box">
			<div class="field_name">GST (18% on SubTotal Cost)</div>
			<div class="field_input">
			<?php echo $gst_total_cost; ?>
			</div>
			<div class="clear"></div>
			</div>
			
			<div class="field_box">
			<div class="field_name">Grand Total </div>
			<div class="field_input">
			<?php echo $grand_total_cost; ?>
			</div>
			<div class="clear"></div>
			</div> 
			</div>
        </div>
        </div>

</div>
</div>

</div>
<div class="clear"></div>
</div>

</div>			
</body>
</html>