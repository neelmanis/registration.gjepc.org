<?php 
include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php");exit;	}
/*
if($_SESSION['redirectLink'] =="Y"){
	 header("Location:https://registration.gjepc.org/visitor_registration.php"); exit;
}
*/
$registration_id = filter($_SESSION['USERID']);
$bp_number = getBPNO($_SESSION['USERID'],$conn);
$quota = getVisitorHotelQuota($registration_id,$conn);
?>
<?php //include('fetch_space_order.php'); /* Space order status API*/?>
<?php
date_default_timezone_set('Asia/Kolkata');
$cr_date=date('d-m-Y H:i:s');
$current_time=strtotime($cr_date);
//echo "Last Time : ".$checking_time=strtotime("11-7-2018 23:59:59");
$checking_time=strtotime("23-07-2019 23:59:00");
//$checking_time=strtotime("23-07-2018 19:10:00");
$closetime = strtotime("15-09-2022 23:55:00");
?>
	<?php
	/* IVR Start */
	/* $fetch_status="select application_status from ivr_registration_details where uid=".$_SESSION['USERID']." and trade_show='IIJS 2018' LIMIT 1";
	$get_status=mysql_query($fetch_status);	
	$show_status = mysql_fetch_array($get_status); */
	/* IVR End */
		
	/* Check Visitor filled obmp profile*/
	$fetch_status_pvr="select obmp_application_status from visitor_obmp_details where uid=".$_SESSION['USERID']." and participate_for_show='iijs22' and year='2022' LIMIT 1";
	$get_status_pvr= $conn->query($fetch_status_pvr);
	/*if(!$get_status_pvr){ echo "error while processing"; exit; } */
	$show_status_pvr = $get_status_pvr->fetch_assoc();	

	?>
	<?php /*
	$uid_exits_ivr="select uid from ivr_registration_details where uid=".$_SESSION['USERID']." and trade_show='IIJS 2019'";
	$count_result_ivr=mysql_query($uid_exits_ivr);
	$count_ivr=mysql_num_rows($count_result_ivr);

	if($count_ivr>=1)
		$_SESSION['UID_EXISTS_IVR']=1;
	else
		$_SESSION['UID_EXISTS_IVR']=0; */
	?>
	
<?php
if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql = "delete from utr_history where id='$_REQUEST[id]'";
	$result = $conn->query($sql);
	if(!$result){die($conn->error);}
	echo"<meta http-equiv=refresh content=\"0;url=my_dashboard.php\">";
}
?>
<?php
/*
$saveUTR = $_POST['saveUTR'];
if($saveUTR=="saveinfo")
{
	$gcodes = getGcode($registration_id,$conn);
	$utr_number = filter(filter_replace($_POST['utr_number']));
	$event = filter($_POST['event']);
//	$year = 2022;
	$amountPaid = filter($_POST['amountPaid']);
	$tdsAmount = filter($_POST['tdsAmount']);
	
	$eventDescription = getExhEventDescription($event,$conn);
	$year = getExhYear($event,$conn);
	
	$eventSpaceStatus = getExhStatus($event,$conn);
	$roi_status = getExhRoi_status($event,$conn);
	if($roi_status==0 && $eventSpaceStatus==0){
		$payment_made_for = ""; 
	}else if($roi_status==0 && $eventSpaceStatus==1){
		$payment_made_for = "SPACE"; 
	}else if($roi_status==1 && $eventSpaceStatus==0){
		$payment_made_for = "ROI";
	}
	
//	print_r($eventDescription); exit;
	if(empty($event)) { $eventError = "Plz Select Event Participated"; }
	elseif(empty($utr_number)) { $utrNameError = "Plz Enter UTR Number"; }
	elseif(empty($amountPaid)) { $amountPaidError = "Plz Enter Amount Paid"; }
	else {
		/*if($event=="signature22"){ $event_for="IIJS SIGNATURE 2022"; } 
		if($event=="signature"){ $event_for="IIJS Signature 2021"; } 
		if($event=="iijs") { $event_for="IIJS 2021"; }
		if($event=="vbsm2") { $event_for="IIJS VIRTUAL SHOW 2021"; }
		
		
		$mmx = "SELECT * FROM `utr_history` WHERE registration_id='$registration_id' AND utr_number='$utr_number' AND `show`='$eventDescription' AND `event_selected`='$event'";
		$mmxResult = $conn->query($mmx);
		$countUTR = $mmxResult->num_rows;
		if($countUTR > 0)
			{
			$mmRowx = $mmxResult->fetch_assoc();
			$id = $mmRowx['id'];
			
			$updateUTR = "UPDATE `utr_history` SET `modified_date`=NOW(),`utr_number`='$utr_number',`amountPaid`='$amountPaid', `tdsAmount`='$tdsAmount',payment_made_for='$payment_made_for' WHERE `registration_id`='$registration_id' AND id='$id' AND `show`='$eventDescription' AND `event_selected`='$event'";
			$resultUTR = $conn->query($updateUTR);
			if($resultUTR) { $utrNameSuccess = "Saved Successfully"; }
			} else {
			$insertUTR = "INSERT INTO `utr_history`(`post_date`, `registration_id`,`gcode`, `utr_number`,`amountPaid`, `tdsAmount`, `show`,`event_selected`, `year`, `status`,`payment_made_for`) VALUES (NOW(),'$registration_id','$gcodes','$utr_number','$amountPaid','$tdsAmount','$eventDescription','$event','$year','1','$payment_made_for')";
			$resultUTR = $conn->query($insertUTR);
			if($resultUTR) { $utrNameSuccess = "Saved Successfully"; }
		}
	}
} */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>My Dashboard</title>
		<link rel="icon" href="https://gjepc.org/assets/images/fav_icon.png" type="image/x-icon"/>
		<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
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
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="js/save_payment.js" type="text/javascript"></script>
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
							<span>
								<?php
								if($_SESSION['COUNTRY']=="IN")
								{                                
								// current challan yr calculation
								$cur_year = (int)date('Y');
								$cur_month = (int)date('m');
								if ($cur_month < 4) {$cur_fin_yr = $cur_year-1;}
								else {$cur_fin_yr = $cur_year;}
								$next_yr=$cur_fin_yr+1;
								
								//$schk_membership="SELECT * FROM `approval_master`  WHERE 1 and `registration_id`='$registration_id' and ( `membership_issued_dt` between '2019-03-31' and '2020-04-1' || membership_renewal_dt between '2019-03-31' and '2020-04-1' || invoice_date between '2019-03-31' and '2020-04-1')";
								
								$schk_membership="SELECT * FROM `approval_master` WHERE 1 and `registration_id`='$registration_id' and issue_membership_certificate_expire_status='Y'";								
								$qchk_membership=$conn->query($schk_membership);
								$get_membership=$qchk_membership->fetch_assoc();								
								$nchk_membership=$qchk_membership->num_rows;
								
								//$_SESSION['combo']=getUserCombo($registration_id,$conn);
								
								if($nchk_membership>0){
									$_SESSION['member_type']= 'MEMBER'; 
									$_SESSION['membership_certificate_type']= $get_membership['membership_certificate_type'];
									$_SESSION['msme_ssi_status']= chk_msme($registration_id,$conn);
								   } else { $_SESSION['member_type']= 'NON_MEMBER'; }
								} else { $_SESSION['member_type']= 'INTERNATIONAL'; }
									echo $_SESSION['member_type'];
								?>
							</span>						
					</div>	
					
					<?php
					/* Member Visitor Registration Start  */
					if($_SESSION['COUNTRY']=="IN")
					{
						//$sql = "select * from exh_reg_payment_details where uid='$registration_id' and `show`='IIJS 2021' AND document_status!='rejected' AND payment_status!='rejected' order by payment_id desc limit 0,1";
						$sql = "select * from exh_reg_payment_details where uid='$registration_id' AND `show`='IIJS PREMIERE 2022' AND`year`='2022' AND allow_visitor='N' order by payment_id desc limit 0,1";
						$ans = $conn->query($sql);
						$result = $ans->fetch_assoc();
						$nans=$ans->num_rows;
						if($nans==0){
						
						echo "<div class='box_dash_container box-shadow '>
						<!--<p><span class='blink d-block'>2 Vaccine Doses Mandatory For Entry</span> </p>-->
						<div class='box_title'><h3>Domestic Visitor Registration</h3></div>
						<div class='d-flex justify-content-center col-100'>";						
						echo '<a href="employee_directory.php" class="btn col-100" title="Add / View Application">Add/View Employee</a>';
						
						//echo '<a href="" class="btn col-100 ">Registration Closed</a>';	
						echo '<a href="manage_address.php" class="btn col-100" title="Add / View Address">Add/View Address</a>';
						//echo '<a href="order_history.php" class="btn " title="Registration Summary"><span>Step 4</span>Orders</a>';	
											   
					   if($show_status_pvr['obmp_application_status']==1) {
						echo '<a href="visitor_registration.php" class="btn col-100" title="Select Show And Make Payment">Payment for Employees</a>'; 
						
						//echo '<a href="#" class="btn col-100" title="Select Show And Make Payment">Registration Closed</a>';
						
						} else {
						echo '<a href="member_obmp_profile.php" class="btn col-100" title="Select Show And Make Payment">Payment for Employees	</a>';
						  //echo '<a href="#" class="btn col-100 " title="Select Show And Make Payment"><span>Step 2 - </span>Registration Application</a>';
						} 
						
					//	echo '<a href="upload_bulk_employee_vaccination.php" class="btn col-100" title="">Vaccination Certificate Upload</a>';
						/*
						if($quota!=="" &&  !empty($quota) && $quota > 0 && $registration_id =="600865078") {
							echo '<a href="visitor_hotel_booking_interest.php" class="btn col-100" title="">Hotel booking</a>';
						} */
						
	
						echo '</div>
						</div>';
						 } /* Exhibitor Check End */
					}
					/* Member Visitor Registration End  */
					
					/* INTERNATIONAL Visitor Registration Start */					
					if($_SESSION['COUNTRY']!="IN"){ ?>
					<div class="box_dash_container box-shadow">
						<div class="box_title"><h3>International Visitor Registration</h3></div>
						<div class='d-flex justify-content-center col-100'>
						<a href="intl_employee_directory.php" class="btn col-100"title="Add / View Application">Add/View Employee</a>
						<!--<a href="intl_visitor_registration.php" class="btn col-100"title="Application for Employees">Application for Employees</a>-->
					<!--	<a href="upload_intl_bulk_employee_vaccination.php" class="btn col-100" title="">Vaccination Certificate Upload</a>-->
						</div>
					</div>
					<?php }	?>					
					<div class="clear"></div>
					
					<!--........................ROI FORM Registration...................................... -->
					<!--<div class="box_dash_container box-shadow">
						<div class="box_title"><h3>Registration of Interest (ROI) for IIJS Tritiya 2022</h3></div>
						<div class="d-flex justify-content-center col-100">
						<?php 
							$rsql = "select * from roi_space_registration where registration_id='$registration_id' and event_name='iijstritiya22'";
							$rquery = $conn->query($rsql);
							$rnum = $rquery->num_rows;
							if($rnum>0){
						?>
							<a href="#" class="btn col-100" onclick="">You have already showed your interest.!! Please update the UTR details. </a>	
						<?php }else {?>
							<!--<a href="#" class="btn col-100" onclick="alert('Coming soon!');">Apply</a>
							<a href="roi_form.php" class="btn col-100" onclick="">Apply</a>
						<?php }?>
						</div>
					</div>-->
					
					<!-- Start Space Registration Start Mukesh Panwar -->
					<!--------------------------------- IIJS SIGNATURE 2022 ------------------------------------------------->
					<?php
					/*
					if($_SESSION['COUNTRY']=="IN" && $_SESSION['member_type']=="MEMBER")
					{			
						echo "<div class='box_dash_container box-shadow'>
						<div class='box_title'><h3>IIJS SIGNATURE 2022 Show</h3></div>
						<div class='d-flex justify-content-center col-100'>";						
						$sqlt = "select * from exh_registration where uid='$registration_id' and `show`='IIJS SIGNATURE 2022'";
						$anst = $conn->query($sqlt);
						$countxx = $anst->num_rows;
						if($countxx==0){
							$schk_defaulter="select * from registration_master where id='$registration_id'";
							$qchk_defaulter=$conn->query($schk_defaulter);
							$rchk_defaulter=$qchk_defaulter->fetch_assoc();
							$rchk_defaulter['payment_defaulter'];
							if($rchk_defaulter['payment_defaulter']=="N"){ ?>
								<div class="box_dash_container box-shadow">
								<div class="box_title"><h3>Exhibitor Registration</h3></div>
								<div class="d-flex justify-content-center col-100">
									<!--<a href="#" class="btn ">Coming Soon</a>-->
									 <?php
									 if($current_time<=$closetime)
											echo '<a href="event_selection_uat.php" class="btn col-100" title="Select Show">Apply</a>';
									else
										echo '<a href="#" class="btn">Application Closed</a>';
									?>			
								</div>
								</div>
							<?php } else { ?>
                        <div class="box_dash_container box-shadow">
						<div class="box_title"><h3>Exhibitor Registration</h3></div>
						<div class="d-flex justify-content-center col-100">
							<!--<a href="#" class="btn ">Coming Soon</a>-->
							<a href="javascript:alert('<?php echo $rchk_defaulter['payment_defaulter_reason'];?>')" class="btn col-100" onclick="">Apply</a>							
						</div>
						</div>
						<?php }						
						//echo '<a href="#" class="btn col-100" title="Select Show">Coming Soon</a>';
						} else {
						echo '<a href="exhibitor_registration_print_application.php?show=signature&year=2022" target="_blank" class="btn col-100" title="View Summary">Click here to access Exhibitor Manual/Stall Payment Details </a>';
						}	
						echo '</div></div>';
					} 
					
					if($_SESSION['COUNTRY']=="IN" && $_SESSION['member_type']=="NON_MEMBER")
					{
						echo "<div class='box_dash_container box-shadow'>
						<div class='box_title'><h3>IIJS SIGNATURE 2022 Show</h3></div>
						<div class='d-flex justify-content-center col-100'>";						
						$sqlt = "select * from exh_registration where uid='$registration_id' and `show`='IIJS SIGNATURE 2022'";
						$anst = $conn->query($sqlt);
						$countxx = $anst->num_rows;
						if($countxx==0){
							$schk_defaulter="select * from registration_master where id='$registration_id'";
							$qchk_defaulter=$conn->query($schk_defaulter);
							$rchk_defaulter=$qchk_defaulter->fetch_assoc();
							$rchk_defaulter['payment_defaulter'];
							if($rchk_defaulter['payment_defaulter']=="N"){ ?>
								<div class="box_dash_container box-shadow">
								<div class="box_title"><h3>Exhibitor Registration</h3></div>
								<div class="d-flex justify-content-center col-100">
									<!--<a href="#" class="btn ">Coming Soon</a>-->
									 <?php
									 if($current_time<=$closetime)
											echo '<a href="event_selection_uat.php" class="btn col-100" title="Select Show">Apply</a>';
									else
										echo '<a href="#" class="btn">Application Closed</a>';
									?>			
								</div>
								</div>
							<?php } else { ?>
                        <div class="box_dash_container box-shadow">
						<div class="box_title"><h3>Exhibitor Registration</h3></div>
						<div class="d-flex justify-content-center col-100">
							<!--<a href="#" class="btn ">Coming Soon</a>-->
							<a href="javascript:alert('<?php echo $rchk_defaulter['payment_defaulter_reason'];?>')" class="btn col-100" onclick="">Apply</a>							
						</div>
						</div>
						<?php }						
						//echo '<a href="#" class="btn col-100" title="Select Show">Coming Soon</a>';
						} else {
						echo '<a href="exhibitor_registration_print_application.php?show=signature&year=2022" target="_blank" class="btn col-100" title="View Summary">Click here to access Exhibitor Manual/Stall Payment Details</a>';
						}	
						echo '</div></div>';
					}
					
					elseif($_SESSION['member_type']=="INTERNATIONAL")
					{
						echo "<div class='box_dash_container box-shadow'>
						<div class='box_title'><h3>IIJS SIGNATURE 2022 Show</h3></div>
						<div class='d-flex justify-content-center col-100'>";						
						$sqlt = "select * from exh_registration where uid='$registration_id' and `show`='IIJS SIGNATURE 2022'";
						$anst = $conn->query($sqlt);
						$countxx = $anst->num_rows;
						if($countxx==0){
							$schk_defaulter="select * from registration_master where id='$registration_id'";
							$qchk_defaulter=$conn->query($schk_defaulter);
							$rchk_defaulter=$qchk_defaulter->fetch_assoc();
							$rchk_defaulter['payment_defaulter'];
							if($rchk_defaulter['payment_defaulter']=="N"){ ?>
								<div class="box_dash_container box-shadow">
								<div class="box_title"><h3>Exhibitor Registration</h3></div>
								<div class="d-flex justify-content-center col-100">
									<!--<a href="#" class="btn ">Coming Soon</a>-->
									 <?php
									 if($current_time<=$closetime)
											echo '<a href="event_selection_uat.php" class="btn col-100" title="Select Show">Apply</a>';
									else
										echo '<a href="#" class="btn">Application Closed</a>';
									?>			
								</div>
								</div>
							<?php } else { ?>
                        <div class="box_dash_container box-shadow">
						<div class="box_title"><h3>Exhibitor Registration</h3></div>
						<div class="d-flex justify-content-center col-100">
							<!--<a href="#" class="btn ">Coming Soon</a>-->
							<a href="javascript:alert('<?php echo $rchk_defaulter['payment_defaulter_reason'];?>')" class="btn col-100" onclick="">Apply</a>							
						</div>
						</div>
						<?php }
						
						//echo '<a href="#" class="btn col-100" title="Select Show">Coming Soon</a>';
						} else {
						echo '<a href="exhibitor_registration_print_application.php?show=signature&year=2022" target="_blank" class="btn col-100" title="View Summary">Click here to access Exhibitor Manual/Stall Payment Details</a>';
						}	
						echo '</div></div>';
					} 
					*/	?>
					
					<!---------------------------------- IIJS Premiere 2022 Show ------------------------------------------->
					<?php
					if($_SESSION['COUNTRY']=="IN" && $_SESSION['member_type']=="MEMBER")
					{			
						echo "<div class='box_dash_container box-shadow'>
						<div class='box_title'><h3>IIJS SHOWS</h3></div>
						<div class='d-flex justify-content-center col-100'>";						
						$sqlt = "select * from exh_registration where uid='$registration_id' and `show`='IIJS SIGNATURE 2023' OR `show`='IIJS TRITIYA 2023' ";
						$anst = $conn->query($sqlt);
						$countxx = $anst->num_rows;
						if($countxx==0){
							$schk_defaulter="select * from registration_master where id='$registration_id'";
							$qchk_defaulter=$conn->query($schk_defaulter);
							$rchk_defaulter=$qchk_defaulter->fetch_assoc();
							$rchk_defaulter['payment_defaulter'];
							if($rchk_defaulter['payment_defaulter']=="N"){ ?>
								<div class="box_dash_container box-shadow">
								<div class="box_title"><h3>Exhibitor Registration / Stall Booking</h3></div>
								<div class="d-flex justify-content-center col-100">
									<!--<a href="#" class="btn ">Coming Soon</a>-->
									 <?php
									 if($current_time<=$closetime)
										echo '<a href="event_selection_uat.php" class="btn col-100" title="Select Show">Apply</a>';
									else
										echo '<a href="#" class="btn col-100">Application Closed</a>';
									?>			
								</div>
								</div>
							<?php } else { ?>
                        <div class="box_dash_container box-shadow">
						<div class="box_title"><h3>Exhibitor Registration</h3></div>
						<div class="d-flex justify-content-center col-100">
							<!--<a href="#" class="btn ">Coming Soon</a>-->
							<a href="javascript:alert('<?php echo $rchk_defaulter['payment_defaulter_reason'];?>')" class="btn col-100" onclick="">Apply</a>
						</div>
						</div>
						<?php }
						
						} else {
						echo '<a href="exhibitor_registration_print_application.php?show=iijs&year=2022" target="_blank" class="btn col-100" title="View Summary">Click here to access Exhibitor Manual </a>';
						}	
						echo '</div></div>';
					} 
					
					if($_SESSION['COUNTRY']=="IN" && $_SESSION['member_type']=="NON_MEMBER")
					{
						echo "<div class='box_dash_container box-shadow'>
						<div class='box_title'><h3>IIJS SHOWS</h3></div>
						<div class='d-flex justify-content-center col-100'>";						
						$sqlt = "select * from exh_registration where uid='$registration_id' and `show`='IIJS PREMIERE 2022' ";
						$anst = $conn->query($sqlt);
						$countxx = $anst->num_rows;
						if($countxx==0){
							$schk_defaulter="select * from registration_master where id='$registration_id'";
							$qchk_defaulter=$conn->query($schk_defaulter);
							$rchk_defaulter=$qchk_defaulter->fetch_assoc();
							$rchk_defaulter['payment_defaulter'];
							if($rchk_defaulter['payment_defaulter']=="N"){ ?>
								<div class="box_dash_container box-shadow">
								<div class="box_title"><h3>Exhibitor Registration</h3></div>
								<div class="d-flex justify-content-center col-100">
									<?php
									if($current_time<=$closetime)
										echo '<a href="event_selection_uat.php" class="btn col-100" title="Select Show">Apply</a>';
									else
										echo '<a href="#" class="btn col-100">Non Member</a>';
									?>			
								</div>
								</div>
							<?php } else { ?>
                        <div class="box_dash_container box-shadow">
						<div class="box_title"><h3>Exhibitor Registration</h3></div>
						<div class="d-flex justify-content-center col-100">
							<!--<a href="#" class="btn ">Coming Soon</a>-->
							<a href="javascript:alert('<?php echo $rchk_defaulter['payment_defaulter_reason'];?>')" class="btn col-100" onclick="">Apply</a>							
						</div>
						</div>
						<?php }						
						//echo '<a href="#" class="btn col-100" title="Select Show">Coming Soon</a>';
						} else {
						echo '<a href="exhibitor_registration_print_application.php?show=iijs&year=2022" target="_blank" class="btn col-100" title="View Summary">Click here to access Exhibitor Manual </a>';
						}	
						echo '</div></div>';
					}
					
					elseif($_SESSION['member_type']=="INTERNATIONAL")
					{
						echo "<div class='box_dash_container box-shadow'>
						<div class='box_title'><h3>IIJS  Show</h3></div>
						<div class='d-flex justify-content-center col-100'>";						
						$sqlt = "select * from exh_registration where uid='$registration_id' and `show`='IIJS PREMIERE 2022' ";
						$anst = $conn->query($sqlt);
						$countxx = $anst->num_rows;
						if($countxx==0){
							$schk_defaulter="select * from registration_master where id='$registration_id'";
							$qchk_defaulter=$conn->query($schk_defaulter);
							$rchk_defaulter=$qchk_defaulter->fetch_assoc();
							$rchk_defaulter['payment_defaulter'];
							if($rchk_defaulter['payment_defaulter']=="N"){ ?>
								<div class="box_dash_container box-shadow">
								<div class="box_title"><h3>Exhibitor Registration</h3></div>
								<div class="d-flex justify-content-center col-100">
									 <?php
									if($current_time<=$closetime)
										echo '<a href="event_selection_uat.php" class="btn col-100" title="Select Show">Apply</a>';
									else
										echo '<a href="#" class="btn col-100">Application Closed</a>';
									?>			
								</div>
								</div>
							<?php } else { ?>
                        <div class="box_dash_container box-shadow">
						<div class="box_title"><h3>Exhibitor Registration</h3></div>
						<div class="d-flex justify-content-center col-100">
							<!--<a href="#" class="btn ">Coming Soon</a>-->
							<a href="javascript:alert('<?php echo $rchk_defaulter['payment_defaulter_reason'];?>')" class="btn col-100" onclick="">Apply</a>							
						</div>
						</div>
						<?php }
						
						//echo '<a href="#" class="btn col-100" title="Select Show">Coming Soon</a>';
						} else {
						echo '<a href="exhibitor_registration_print_application.php?show=iijs&year=2022" target="_blank" class="btn col-100" title="View Summary">Click here to view the application summary</a>';
						}	
						echo '</div></div>';
					}

					if($_SESSION['COUNTRY']=="IN" && $_SESSION['member_type']=="MEMBER")
					{			
						echo "<div class='box_dash_container box-shadow'>
						<div class='box_title'><h3>IIJS PREMIERE 2022</h3></div>
						<div class='d-flex justify-content-center col-100'>";						
						$sqlt = "select * from exh_registration where uid='$registration_id' and `show`='IIJS PREMIERE 2022'  ";
						$anst = $conn->query($sqlt);
						$countxx = $anst->num_rows;
						if($countxx==0){
							$schk_defaulter="select * from registration_master where id='$registration_id'";
							$qchk_defaulter=$conn->query($schk_defaulter);
							$rchk_defaulter=$qchk_defaulter->fetch_assoc();
							$rchk_defaulter['payment_defaulter'];
							if($rchk_defaulter['payment_defaulter']=="N"){ ?>
								<div class="box_dash_container box-shadow">
								<div class="box_title"><h3>Exhibitor Registration</h3></div>
								<div class="d-flex justify-content-center col-100">
									<!--<a href="#" class="btn ">Coming Soon</a>-->
									 <?php
									 if($current_time<=$closetime)
										echo '<a href="event_selection_uat.php" class="btn col-100" title="Select Show">Apply</a>';
									else
										echo '<a href="#" class="btn col-100">Application Closed</a>';
									?>			
								</div>
								</div>
							<?php } else { ?>
                        <div class="box_dash_container box-shadow">
						<div class="box_title"><h3>Exhibitor Registration</h3></div>
						<div class="d-flex justify-content-center col-100">
							<!--<a href="#" class="btn ">Coming Soon</a>-->
							<a href="javascript:alert('<?php echo $rchk_defaulter['payment_defaulter_reason'];?>')" class="btn col-100" onclick="">Apply</a>
						</div>
						</div>
						<?php }
						
						} else {
						echo '<a href="exhibitor_registration_print_application.php?show=iijs&year=2022" target="_blank" class="btn col-100" title="View Summary">Click here to access Exhibitor Manual </a>';
						}	
						echo '</div></div>';
					} 
					
					if($_SESSION['COUNTRY']=="IN" && $_SESSION['member_type']=="NON_MEMBER")
					{
						echo "<div class='box_dash_container box-shadow'>
						<div class='box_title'><h3>IIJS SHOWS</h3></div>
						<div class='d-flex justify-content-center col-100'>";						
						$sqlt = "select * from exh_registration where uid='$registration_id' and `show`='IIJS PREMIERE 2022' ";
						$anst = $conn->query($sqlt);
						$countxx = $anst->num_rows;
						if($countxx==0){
							$schk_defaulter="select * from registration_master where id='$registration_id'";
							$qchk_defaulter=$conn->query($schk_defaulter);
							$rchk_defaulter=$qchk_defaulter->fetch_assoc();
							$rchk_defaulter['payment_defaulter'];
							if($rchk_defaulter['payment_defaulter']=="N"){ ?>
								<div class="box_dash_container box-shadow">
								<div class="box_title"><h3>Exhibitor Registration</h3></div>
								<div class="d-flex justify-content-center col-100">
									<?php
									if($current_time<=$closetime)
										echo '<a href="event_selection_uat.php" class="btn col-100" title="Select Show">Apply</a>';
									else
										echo '<a href="#" class="btn col-100">Non Member</a>';
									?>			
								</div>
								</div>
							<?php } else { ?>
                        <div class="box_dash_container box-shadow">
						<div class="box_title"><h3>Exhibitor Registration</h3></div>
						<div class="d-flex justify-content-center col-100">
							<!--<a href="#" class="btn ">Coming Soon</a>-->
							<a href="javascript:alert('<?php echo $rchk_defaulter['payment_defaulter_reason'];?>')" class="btn col-100" onclick="">Apply</a>							
						</div>
						</div>
						<?php }						
						//echo '<a href="#" class="btn col-100" title="Select Show">Coming Soon</a>';
						} else {
						echo '<a href="exhibitor_registration_print_application.php?show=iijs&year=2022" target="_blank" class="btn col-100" title="View Summary">Click here to access Exhibitor Manual </a>';
						}	
						echo '</div></div>';
					}
					
					elseif($_SESSION['member_type']=="INTERNATIONAL")
					{
						echo "<div class='box_dash_container box-shadow'>
						<div class='box_title'><h3>IIJS  Show</h3></div>
						<div class='d-flex justify-content-center col-100'>";						
						$sqlt = "select * from exh_registration where uid='$registration_id' and `show`='IIJS PREMIERE 2022' ";
						$anst = $conn->query($sqlt);
						$countxx = $anst->num_rows;
						if($countxx==0){
							$schk_defaulter="select * from registration_master where id='$registration_id'";
							$qchk_defaulter=$conn->query($schk_defaulter);
							$rchk_defaulter=$qchk_defaulter->fetch_assoc();
							$rchk_defaulter['payment_defaulter'];
							if($rchk_defaulter['payment_defaulter']=="N"){ ?>
								<div class="box_dash_container box-shadow">
								<div class="box_title"><h3>Exhibitor Registration</h3></div>
								<div class="d-flex justify-content-center col-100">
									 <?php
									if($current_time<=$closetime)
										echo '<a href="event_selection_uat.php" class="btn col-100" title="Select Show">Apply</a>';
									else
										echo '<a href="#" class="btn col-100">Application Closed</a>';
									?>			
								</div>
								</div>
							<?php } else { ?>
                        <div class="box_dash_container box-shadow">
						<div class="box_title"><h3>Exhibitor Registration</h3></div>
						<div class="d-flex justify-content-center col-100">
							<!--<a href="#" class="btn ">Coming Soon</a>-->
							<a href="javascript:alert('<?php echo $rchk_defaulter['payment_defaulter_reason'];?>')" class="btn col-100" onclick="">Apply</a>							
						</div>
						</div>
						<?php }
						
						//echo '<a href="#" class="btn col-100" title="Select Show">Coming Soon</a>';
						} else {
						echo '<a href="exhibitor_registration_print_application.php?show=iijs&year=2022" target="_blank" class="btn col-100" title="View Summary">Click here to view the application summary</a>';
						}	
						echo '</div></div>';
					} ?>
				
					<!------------------------------------------------>
					<!-- Stop Space Registration Start Mukesh Panwar -->

						<!-------------- UTR END ----------------------------->	
						<div class="clear"></div>
						<?php
						function getTDSAmount($registration_id,$conn)
						{
							$query_sel = "select cheque_tds_amount from exh_reg_payment_details where uid='$registration_id' AND `show`='IIJS PREMIERE 2022' AND event_selected='iijs' limit 0,1";
							$result_sel = $conn->query($query_sel);								
							$row = $result_sel->fetch_assoc();								
								return $row['cheque_tds_amount'];							
						}
						
						$utrExistSuccess = "SELECT * FROM `utr_history` WHERE registration_id='$registration_id' AND `show`='IIJS PREMIERE 2022' AND payment_status='captured' AND payment_made_for='SPACE'";
						$successResult = $conn->query($utrExistSuccess);
						$countSuccessPayment = $successResult->num_rows;
						if($countSuccessPayment > 0){
							$utrExistQuery = "SELECT * FROM `utr_history` WHERE registration_id='$registration_id' AND `show`='IIJS PREMIERE 2022' AND payment_status='captured' AND payment_made_for='SPACE'";
						} else {
							$utrExistQuery = "SELECT * FROM `utr_history` WHERE registration_id='$registration_id' AND `show`='IIJS PREMIERE 2022' AND payment_made_for='SPACE'";							
						}
						
						
						/*$utrExist = "SELECT * FROM `utr_history` WHERE registration_id='$registration_id' AND `show`='IIJS PREMIERE 2022'";
						$existResult = $conn->query($utrExist); */
						$successResultQuery = $conn->query($utrExistQuery);
						$countPayment = $successResultQuery->num_rows;
						if($countPayment > 0){	?>
						
						<table class="table_responsive">
						<tr> <td><strong class="title">Online Stall Payment Details IIJS PREMIERE 2022</strong>  </td></tr>
						</table>
						
						<div class="alert alert-danger error-div" role="alert"></div>
						<div class="alert alert-info success-div" role="alert"></div>
						
						<form>
						
						<table class="table_responsive">
							<tr>
								<th align="center">Date</th>
								<th align="center">Order No</th>
								<th align="center">Show</th>
								<th align="center">Amount Paid</th>
								<th align="center">TDS Amount</th>
								<th align="center">Pay now</th>
								<th align="center">Status</th>
							</tr>
								<?php				
								$totalPrice = 0;
								while($printutr = $successResultQuery->fetch_assoc())
								{
								$payment_date = $printutr['payment_date']; 
								$id = $printutr['id']; 
								$getUTR_no = $printutr['utr_number']; 
								$event_for=$printutr['show']; 
								$event_selected = $printutr['event_selected']; 
								$amountPaid = $printutr['amountPaid'];
								$utr_approved = $printutr['utr_approved'];
								$payment_status = $printutr['payment_status'];
								$tds_holder = $printutr["tds_holder"];
								$cheque_tds_amount = $printutr["cheque_tds_amount"];
								$tdsAmount = $printutr["tdsAmount"];
								$gidData = $printutr["gcode"];
								?>
								<tr>
								<td align="center"><?php echo $payment_date;?></td>
								<td align="center"><?php echo $getUTR_no;?></td>
								<td align="center"><?php echo $event_for;?></td>
								<td align="center"><?php echo $amountPaid;?></td>
								<td align="center"><?php echo getTDSAmount($registration_id,$conn);?></td>
								<td align="center">
								<?php  if($payment_status=="pending" || $payment_status==""){ ?>
								<button class="cta fade_anim d-table mx-auto" id="save" onclick="return savePayment.save()">Click here for Payment</button>   
								<?php }  ?>
								</td>
								<td align="center"><?php echo $payment_status;?></td>
								</tr>
								<?php }	?>
						 </table>
						<input type="hidden" id="gidData" value="<?php echo $gidData;?>">
						<input type="hidden" id="net_payable_amount" value="<?php echo base64_encode($amountPaid);?>">
						<input type="hidden" name="action" value="submit">
						 </form>
						<?php } ?>
						
						
						<div class="clear"></div>
						<?php
						$utrExistSuccess1 = "SELECT * FROM `utr_history` WHERE registration_id='$registration_id' AND `show`='IIJS PREMIERE 2022' AND payment_status='captured' AND payment_made_for='ALLOTMENT'";
						$successResult1 = $conn->query($utrExistSuccess1);
						$countSuccessPayment1 = $successResult1->num_rows;
						if($countSuccessPayment1 > 0){
							$utrExistQuery1 = "SELECT * FROM `utr_history` WHERE registration_id='$registration_id' AND `show`='IIJS PREMIERE 2022' AND payment_status='captured' AND payment_made_for='ALLOTMENT'";
						} else {
							$utrExistQuery1 = "SELECT * FROM `utr_history` WHERE registration_id='$registration_id' AND `show`='IIJS PREMIERE 2022' AND payment_made_for='ALLOTMENT'";							
						}
						$successResultQuery1 = $conn->query($utrExistQuery1);
						$countPayment1 = $successResultQuery1->num_rows;
						if($countPayment1 > 0){	?>
						
						<table class="table_responsive">
						<tr> <td><strong class="title">Online Stall Payment Details IIJS PREMIERE 2022</strong>  </td></tr>
						</table>
												
						<table class="table_responsive">
							<tr>
								<th align="center">Date</th>
								<th align="center">Order No</th>
								<th align="center">Show</th>
								<th align="center">Amount Paid</th>
								<th align="center">TDS Amount</th>
								<th align="center">Status</th>
							</tr>
								<?php				
								$totalPrice = 0;
								while($printutr = $successResultQuery1->fetch_assoc())
								{
								$payment_date = $printutr['payment_date']; 
								$id = $printutr['id']; 
								$getUTR_no = $printutr['utr_number']; 
								$event_for=$printutr['show']; 
								$event_selected = $printutr['event_selected']; 
								$amountPaid = $printutr['amountPaid'];
								$utr_approved = $printutr['utr_approved'];
								$payment_status = $printutr['payment_status'];
								$tds_holder = $printutr["tds_holder"];
								$cheque_tds_amount = $printutr["cheque_tds_amount"];
								$tdsAmount = $printutr["tdsAmount"];
								$gidData = $printutr["gcode"];
								?>
								<tr>
								<td align="center"><?php echo $payment_date;?></td>
								<td align="center"><?php echo $getUTR_no;?></td>
								<td align="center"><?php echo $event_for;?></td>
								<td align="center"><?php echo $amountPaid;?></td>
								<td align="center"><?php echo $tdsAmount;?></td>
								<td align="center"><?php echo $payment_status;?></td>
								</tr>
								<?php }	?>
						 </table>
						<?php } ?>
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