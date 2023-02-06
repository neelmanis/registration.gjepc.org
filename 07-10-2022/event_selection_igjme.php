<?php 
include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit; }
$registration_id = filter($_SESSION['USERID']);

$getEvent = "SELECT event FROM exh_event_selected WHERE registration_id='$registration_id'";
$result = $conn->query($getEvent);
$count = $result->num_rows;
$rowx = $result->fetch_assoc();
$gotEventName = $rowx['event'];

$action = $_POST['action'];
if($action == "save")
{
	$event = $_POST['event'];		
	if($count > 0){
	 	$sql = "UPDATE exh_event_selected SET event = '$event' WHERE registration_id ='$registration_id' ";	
	} else {
	    $sql = "INSERT INTO `exh_event_selected`(`event`, `year`, `registration_id`) VALUES ('$event','2023','$registration_id')";
	}
	$resultx = $conn->query($sql);
	if($resultx)
		$eventInfo = array('event_selected' => $event);
		$_SESSION['eventInfo']  = $eventInfo;
	header('Location: exhibitor_registration_step_1.php'); exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Select Event</title>
		<link rel="icon" href="https://gjepc.org/assets/images/fav_icon.png" type="image/x-icon"/>
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
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178505237-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-178505237-1');
</script>

<!-- Global site tag (gtag.js) - Google Ads: 679056788 --><!--  <script async src="https://www.googletagmanager.com/gtag/js?id=AW-679056788"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-679056788'); </script> --> 
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
		<script type="text/javascript">
		$(document).ready(function() {
		$().UItoTop({ easingType: 'easeOutQuart' });
		});
		</script>
		<script type="text/javascript">
		$(window).load(function() {
			$(".loader").fadeOut("slow");

			var checkEvent = $('input[name="event"]').val();
		 if($('input[name="event"]').is(':checked')) {
		 	$('#submit').attr('disabled',false); 

		 }else{
		 	$('#submit').attr('disabled',true);
		 }			
		});

		$(document).ready(function() {

		$('input[name="event"]').change(function(){
			var event = $(this).data('name');
			$('#selectedShow').html('You Selected <b>" '+event+' "</b> Click Next To Continue');
			$('#submit').attr('disabled',false);
		});
		});
		$(window).ready(function(){

	$("#eventForm").validate({
		rules: {
			agree: {
			required: true		
			}
		},
		messages: {
			agree: {
				required: "Please accept Terms & Conditions",				
			}			
	 }
	});
});
</script>

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
<div class="loader"><p>loading please wait....</p></div>
		<div class="wrapper">
			<div class="header"><?php include('header1.php'); ?></div>
<div class="inner_container">
				
	<div class="container_wrap">
		<div class="container">
           <span class="headtxt"></span>	
           <div id="loginForm">		  
           
        <div id="formContainer">
        <div class="d-flex flex-row justify-center form-group m-10 form-tab">
			<label class="container_radio"><span class="check_text"></span>
			  <input type="radio" checked="checked" disabled="disabled" >
			  <span class="checkmark_radio"></span>
			</label>
			<label class="container_radio"><span class="check_text"></span>
			  <input type="radio" disabled="disabled" >
			  <span class="checkmark_radio"></span>
			</label>
			<label class="container_radio"><span class="check_text"></span>
			  <input type="radio" disabled="disabled">
			  <span class="checkmark_radio"></span>
			</label>
			<label class="container_radio"><span class="check_text"></span>
			  <input type="radio" disabled="disabled">
			  <span class="checkmark_radio"></span>
			</label>
			<label class="container_radio"><span class="check_text"></span>
			  <input type="radio" disabled="disabled">
			  <span class="checkmark_radio"></span>
			</label>
		</div>
        <div class="title"><h4 style="text-align: center; color: #fff; display: table; background: #00000099; margin: 0 auto; border: 1px solid#000;
    -webkit-box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); -moz-box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); border-radius: 6px;">Choose Your Event</h4></div>
		   
        <div class="clear"></div>
        <div class="borderBottom"></div>
	<?php
	$sql = "select * from exh_reg_payment_details where uid='$registration_id' AND `year`='2022' order by payment_id desc limit 0,1";
	$ans = $conn->query($sql);
	$result = $ans->fetch_assoc();
	$nans=$ans->num_rows;
	//if($nans==0){
	?>	
    <form method="POST" name="eventForm" id="eventForm" autocomplete="off">
		<input type="hidden" name="action" value="save"/>   
        <div class="d-flex flex-column ">
              <div class="d-flex flex-row form-setup">
                <div class="col-100 d-flex justify-around flex-wrap form-group">
                <div class="hungry">
				<?php 
				if($_SESSION['COUNTRY']=="IN")
				$getEvent = "SELECT * FROM `exh_event_master` WHERE id=5";
				else 
				 $getEvent = "SELECT * FROM `exh_event_master` WHERE status='1' AND country='IN'";				
				$eventResult = $conn->query($getEvent);
				while($eventRow = $eventResult->fetch_assoc()){ ?>
				  <div class="selection">
					<input id="<?php echo $eventRow['id'];?>" name="event" type="radio" value="<?php echo $eventRow['event'];?>" data-name="<?php echo $eventRow['eventDescription'];?>" <?php if($gotEventName==$eventRow['event']){ echo "checked"; } ?>/>
					<label for="<?php echo $eventRow['id'];?>"><?php echo $eventRow['eventDescription'];?></label>
				  </div>
				<?php } ?>
				</div>
				</div>				
			  </div>			  
		<p id="selectedShow"> Please Choose  Event To Continue </p>	
		<input type="checkbox" name="agree" id="agree"style="display: inline-block;" ><strong> I have read and hereby accept and agree <a href="#" target="_blank" style="color: red"> Stall booking circular </a>,<a href="#" target="_blank" style="color: red"> Guidelines Rules Regulations for Allotment of Booths</a> , <a href="#" target="_blank" style="color: red"> Terms & Conditions </a></strong> 
		<label for="agree" generated="true" class="error"></label>
		<div class="form-group btn_right">
		  <input type="submit" name="submit" disabled="disabled" id="submit" value="Next" class="btn btn-submit" disabled="disabled">
		</div>
        </div>
        </div>
    </form>  
	<?php /*} else { echo "<script type='text/javascript'> alert('Already Show Selected');
		window.location.href='my_dashboard.php';
		</script>";
		return;	exit; } */?>
</div>
</div>

</div>
<div class="clear"></div>
</div>

</div>			
</body>
</html>