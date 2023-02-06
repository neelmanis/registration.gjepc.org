<?php 
include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php");exit;	}

$registration_id = filter($_SESSION['USERID']);
$bp_number = getBPNO($_SESSION['USERID'],$conn);
?>
<?php
date_default_timezone_set('Asia/Kolkata');
$cr_date=date('d-m-Y H:i:s');
$current_time=strtotime($cr_date);
//echo "Last Time : ".$checking_time=strtotime("11-7-2018 23:59:59");
$checking_time=strtotime("23-07-2019 23:59:00");
//$checking_time=strtotime("23-07-2018 19:10:00");
$closetime = strtotime("20-04-2021 23:55:00");
?>
	<?php
	/* IVR Start */
	/* $fetch_status="select application_status from ivr_registration_details where uid=".$_SESSION['USERID']." and trade_show='IIJS 2018' LIMIT 1";
	$get_status=mysql_query($fetch_status);	
	$show_status = mysql_fetch_array($get_status); */
	/* IVR End */
		
	/* Check Visitor filled obmp profile*/
	$fetch_status_pvr="select obmp_application_status from visitor_obmp_details where uid=".$_SESSION['USERID']." and participate_for_show='signature' and year='2020' LIMIT 1";
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
$saveUTR = $_POST['saveUTR'];
if($saveUTR=="saveinfo")
{
	$gcodes = getGcode($registration_id,$conn);
	$utr_number = filter(filter_replace($_POST['utr_number']));
	$event = filter($_POST['event']);
	$year = 2021;
	$amountPaid = filter($_POST['amountPaid']);
	$tdsAmount = filter($_POST['tdsAmount']);
	if(empty($event)) { $eventError = "Plz Select Event Participated"; }
	elseif(empty($utr_number)) { $utrNameError = "Plz Enter UTR Number"; }
	elseif(empty($amountPaid)) { $amountPaidError = "Plz Enter Amount Paid"; }
	else {
		if($event=="signature"){ $event_for="IIJS Signature 2021"; } 
		if($event=="iijs") { $event_for="IIJS 2021"; }
		if($event=="vbsm2") { $event_for="IIJS VIRTUAL SHOW 2021"; }
		$mmx = "SELECT * FROM `utr_history` WHERE registration_id='$registration_id' AND utr_number='$utr_number' AND `show`='$event_for' AND `event_selected`='$event'";
		$mmxResult = $conn->query($mmx);
		$countUTR = $mmxResult->num_rows;
		if($countUTR > 0)
			{
			$mmRowx = $mmxResult->fetch_assoc();
			$id = $mmRowx['id'];
			
			$updateUTR = "UPDATE `utr_history` SET `modified_date`=NOW(),`utr_number`='$utr_number',`amountPaid`='$amountPaid', `tdsAmount`='$tdsAmount' WHERE `registration_id`='$registration_id' AND id='$id' AND `show`='$event_for' AND `event_selected`='$event'";
			$resultUTR = $conn->query($updateUTR);
			if($resultUTR) { $utrNameSuccess = "Saved Successfully"; }
			} else {
			$insertUTR = "INSERT INTO `utr_history`(`post_date`, `registration_id`,`gcode`, `utr_number`,`amountPaid`, `tdsAmount`, `show`,`event_selected`, `year`, `status`) VALUES (NOW(),'$registration_id','$gcodes','$utr_number','$amountPaid','$tdsAmount','$event_for','$event','$year','1')";
			$resultUTR = $conn->query($insertUTR);
			if($resultUTR) { $utrNameSuccess = "Saved Successfully"; }
		}
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>My Dashboard</title>
		<link rel="shortcut icon" href="images/fav.png" />
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
					/*	$sql = "select * from exh_reg_payment_details where uid='$registration_id' and `show`='IIJS 2019' AND document_status!='rejected' AND payment_status!='rejected' order by payment_id desc limit 0,1";
						$sql = "select * from exh_reg_payment_details where uid='$registration_id' AND `year`='2019' AND allow_visitor='N' order by payment_id desc limit 0,1";
						$ans = $conn->query($sql);
						$result = $ans->fetch_assoc();
						$nans=$ans->num_rows;
						if($nans==0){ */
						
						echo "<h2>Domestic Visitor Registration</h2><br><br>";
						echo "<div class='box_dash_container box-shadow '>
						<div class='box_title'><h3>Domestic Visitor Registration</h3></div>
						<div class='d-flex justify-content-center col-100'>";						
						echo '<a href="employee_directory.php" class="btn col-100" title="Add / Edit Application"><span></span>Manage Directory</a>';
						
					/*	if($show_status_pvr['obmp_application_status']==1) {
						 echo '<a href="visitor_registration.php" class="btn col-100" title="Select Show And Make Payment"><span>Step 2 - </span>Registration Application</a>';
						// echo '<a href="#" class="btn col-100" title="Select Show And Make Payment"><span>Step 2 - </span>Registration Application</a>';
						} else {
						echo '<a href="member_obmp_profile.php" class="btn col-100 " title="Select Show And Make Payment"><span>Step 2 - </span>Registration Application</a>';
						//echo '<a href="#" class="btn col-100 " title="Select Show And Make Payment"><span>Step 2 - </span>Registration Application</a>';
						} */
						//	echo '<a href="" class="btn col-100 ">Registration Closed</a>';	
						
						echo '<a href="manage_address.php" class="btn col-100 "  title="Add /Edit Address">Manage Address</a>';
					//	echo '<a href="order_history.php" class="btn " title="Registration Summary"><span>Step 4</span>Orders</a>';	
					//	echo '<a href="" class="btn ">Registration under maintenance</a>';	
						echo '</div>
						</div>';
						/* } Exhibitor Check End */
					}
					/* Member Visitor Registration End  */
					
					/* INTERNATIONAL Visitor Registration Start */					
				/*	if($_SESSION['COUNTRY']!="IN"){ ?>
					<div class="box_dash_container box-shadow">
						<div class="box_title"><h3>International Visitor Registration</h3></div>
						<div class='d-flex justify-content-center col-100'>
						<?php
						$check = "select * from ivr_registration_details where uid=".$_SESSION['USERID']." ";
						$checkq = $conn->query($check);
						$totalnum = $checkq->num_rows;
						while($rows = $checkq->fetch_assoc()){
						$total_status = $rows['application_status'];
						}

						if(!empty($totalnum)){
							if($total_status == "1"){							
								echo '<a href="i_v_r.php?action=addnew" class="btn col-100">Add Applicant</a>'; 
								//echo '<a href="#" class="btn col-100 ">Closed</a>'; 
							}
										
						$sqlivr = "select * from ivr_registration_details where uid=".$_SESSION['USERID']." ";
						$queryivr = $conn->query($sqlivr);						  
						while($rowivr = $queryivr->fetch_assoc())
						{
							 $ivrid = $rowivr['eid'];
							 $first_name = $rowivr['first_name'];
							 if($rowivr['application_status'] == 1){
							 echo '<a href="international_visitor_registration.php?eid='.$ivrid.'" class="btn col-100 ">'.strtoupper ($first_name).'</a>';
							 } else {
							 echo '<a href="i_v_r.php?id='.$ivrid.'" class="btn col-100">View Application Summary</a>';	
							 } 
						}					 
						}  else {									
							 echo '<a href="i_v_r.php?action=addnew" class="btn col-100 ">Apply</a>';							
							//echo '<a href="#" class="btn ">Closed</a>';							
						} ?>
						</div>
						</div>
						<?php } */	?>					
											
					<div class="clear"></div>
					
					<!-- Start Space Registration Start Mukesh Panwar -->
					<?php
					//if($_SESSION['COUNTRY']=="IN" && $_SESSION['member_type']=="MEMBER")
					if($_SESSION['COUNTRY']=="IN")
					{						
						echo "<div class='box_dash_container box-shadow'>
						<div class='box_title'><h3>IIJS Premiere 2021 Show</h3></div>
						<div class='d-flex justify-content-center col-100'>";						
						$sqlt = "select * from exh_registration where uid='$registration_id' and `show`='IIJS 2021' ";
						$anst = $conn->query($sqlt);
						$countxx = $anst->num_rows;
						if($countxx==0){
						//echo '<a href="event_selection.php" class="btn col-100" title="Select Show">Apply</a>';
						echo '<a href="#" class="btn " title="Select Show">Application Closed</a>';
						} else {
						echo '<a href="exhibitor_registration_print_application.php" target="_blank" class="btn col-100" title="View Summary">View Summary</a>';
						}	
						echo '</div></div>';
					} ?>
					
				
						<?php
						if($_SESSION['COUNTRY']=="IN")
						{ ?>
						<div class="box_dash_container box-shadow">	
						<div class="box_title"><h3>IIJS Premiere Show UTR</h3></div>
						<div class="d-flex justify-content-center col-100 box_exhibitor">
						<?php /*if($getCount==0){ ?>
						<!--<a href="event_selection.php" class="btn ">Apply For IIJS Premiere</a> <br/>-->
                        <a href="#" class="btn ">Application Closed</a> <br/>
						<?php } */ ?>
						
						<!--<a href="exhibitor_registration_print_application.php?gid=<?php echo $gid;?>" class="btn ">View Application Summary / Exhibitor Manual</a>	-->
						
						<!-------------- UTR START ----------------------------->
						<div class="form_payment ">
						<h3><b>Update Payment Details </b></h3>
						<p><b>Company Name :</b> The Gem & Jewellery Export Promotion Council 
						<br/><b>Bank :</b> ICICI Bank Ltd
						<br/><b>Branch :</b> Lamington Road
						<br/><b>A/c No. :</b> 034801000360
						<br/><b>IFSC Code :</b> ICIC0000348
						<br/><b>Type of Account :</b> Saving Account</p>
						<form name="utr" method="POST" action="" id="form-horizontal">
						<input type="hidden" name="saveUTR" value="saveinfo">
						<?php 
					
						$sqlShow = "select * from exh_reg_payment_details where uid='$registration_id' AND `isCombo`='Y' order by payment_id desc limit 0,2";
						$resultShow = $conn->query($sqlShow);
						$countShow=$resultShow->num_rows;
						if($countShow==0){
						$sqlShow = "select * from exh_reg_payment_details where uid='$registration_id' AND `isCombo`='N' order by payment_id desc limit 0,1";
						$resultShow = $conn->query($sqlShow);
						}
						?>
							<div class="d-flex col-100">
							<div class="form-group-inner col-100">
							<label>Event Participated: </label>
							<select name="event" id="event" class="select-control">
							<option value="">--Select Event--</option>
							<!--<option value="iijs">IIJS Premiere 2020</option>
							<option value="signature">IIJS Signature 2020</option>-->
							<!--<option value="vbsm2">IIJS VIRTUAL SHOW</option>-->
							<option value="iijs">IIJS Premiere 2021</option>
							</select>
							
							<?php if(isset($eventError)) { echo  '<span style="color: red;"/>'.$eventError.'</span>';} ?>
							</div>
							<div class="form-group-inner col-100">
							<label>UTR Number : </label>
							
							<input type="text" class="form-control" id="utr_number" name="utr_number" value="<?php echo $utr_number;?>"/>
							<?php if(isset($utrNameError)) { echo  '<span style="color: red;"/>'.$utrNameError.'</span>';} ?>
							</div>
							<div class="form-group-inner col-100">
							<label>Amount Paid : </label>
							<input type="number" class="form-control" id="amountPaid" name="amountPaid" value="<?php echo $amountPaid;?>" onkeypress="return isNumberKey(event)"/>
							<?php if(isset($amountPaidError)) { echo  '<span style="color: red;"/>'.$amountPaidError.'</span>';} ?>
							</div>
							<div class="form-group-inner col-100">
							<label>TDS Amount(If Any) : </label>
							<input type="number" class="form-control" id="tdsAmount" name="tdsAmount" value="<?php echo $tdsAmount;?>"/><?php if(isset($utrNameSuccess)){ echo '<span style="color: green;"/>'.$utrNameSuccess.'</span>';} ?>
							</div>
							</div>
							<div class="form-group " style="padding: 0;">
								<input type="submit" class="cta" id="submit" value="SAVE"/>
							</div>
							
						</form>
						
						<div class="clear"></div>
						<?php 
						//$utrExist = "SELECT * FROM `utr_history` WHERE registration_id='$registration_id' AND `year`='2019'";
						$utrExist = "SELECT * FROM `utr_history` WHERE registration_id='$registration_id' AND `show`='IIJS 2021'";
						$existResult = $conn->query($utrExist);
						$countPayment = $existResult->num_rows;
						if($countPayment > 0){
						?>
						<table class="table_responsive">
						<tr> <td><strong class="title">Payment Details</strong>  </td></tr>
						</table>
						<table class="table_responsive">
							<tr>
								<th align="center">UTR No</th>
								<th align="center">Show</th>
								<th align="center">Amount Paid</th>
								<th align="center">TDS Amount</th>
								<th align="center">Delete</th>
								<th align="center">Comment</th>
							</tr>
								<?php				
								$totalPrice = 0;
								while($printutr = $existResult->fetch_assoc())
								{
								$id = $printutr['id']; 
								$getUTR_no = $printutr['utr_number']; 
								$event_selected = $printutr['event_selected']; 
								$amountPaid = $printutr['amountPaid']; 
								$tdsAmount = $printutr['tdsAmount']; 
								$utr_approved = $printutr['utr_approved'];
								$comment = $printutr['comment'];
								if($event_selected=="signature"){ $event_for="IIJS Signature 2021"; } 
								if($event_selected=="iijs") { $event_for="IIJS 2021"; }
								if($event_selected=="vbsm2") { $event_for="IIJS VIRTUAL SHOW 2.0"; }
								?>
								<tr>
								<td align="center"><?php echo $getUTR_no;?></td>
								<td align="center"><?php echo $event_for;?></td>
								<td align="center"><?php echo $amountPaid;?></td>
								<td align="center"><?php echo $tdsAmount;?></td>
								<td align="center">
								<?php if($utr_approved=="P" || $utr_approved=="D"){?>
								<a style="color:black;" href="my_dashboard.php?action=del&id=<?php echo $id?>" onClick="return(window.confirm('Are you sure you want to delete?'));">Delete</a>
								<?php }?>
								</td>
								<td align="center"><?php echo $comment;?></td>
								</tr>
								<?php }	?>
						 </table>
						<?php } ?>
						
						<?php
						$utrExistTotal = "SELECT sum(amountPaid),sum(tdsAmount) FROM `utr_history` WHERE registration_id='$registration_id' AND `event_selected`='iijs' AND `show`='IIJS 2021'";
						$existResultTotal = $conn->query($utrExistTotal);
						$countTotal  = $existResultTotal->num_rows;
						if($countTotal > 0) {
						?>
						<table class="table_responsive">
							<tr>
							<th align="center">Total Amount Paid </th>
							<th align="center">Total TDS Amount</th>
							</tr>
							<tbody>
							<?php	
							while($printutr = $existResultTotal->fetch_assoc())
							{				
							?>
							<tr>
							<td align="center"><?php echo $printutr['sum(amountPaid)']; ?></td>
							<td align="center"><?php echo $printutr['sum(tdsAmount)']; ?></td>				
							</tr>
							<?php }	?>
							</tbody>
						</table>
						<?php } ?>
						
						<?php /*
						$utrIIJSExistTotal = "SELECT sum(amountPaid),sum(tdsAmount) FROM `utr_history` WHERE registration_id='$registration_id' AND `event_selected`='iijs'";
						$existIIJSResultTotal = $conn->query($utrIIJSExistTotal);
						$countTotals  = $existIIJSResultTotal->num_rows;
						if($countTotals > 0) {
						?>
						<table id="table_data">
							<tr>
							<th align="center">Total Amount Paid (IIJS 2020)</th>
							<th align="center">Total TDS Amount</th>
							</tr>
							<tbody>
							<?php	
							while($print_iijsutr = $existIIJSResultTotal->fetch_assoc())
							{		
							?>
							<tr>
							<td align="center"><?php echo $print_iijsutr['sum(amountPaid)']; ?></td>
							<td align="center"><?php echo $print_iijsutr['sum(tdsAmount)']; ?></td>				
							</tr>
							<?php }	?>
							</tbody>
						</table>
						<?php } */?>
						
						</div>
						</div>
						<?php } ?>
						<!-------------- UTR END ----------------------------->
						
						<?php
						$checkiijs = "select temp_roi_check_iijs from registration_master where id='$registration_id'";
						$qchk = $conn->query($checkiijs);
						$rchk = $qchk->num_rows;
						//echo '---'.$rchk['temp_roi_check_iijs'];
						//if($rchk['temp_roi_check_iijs']=="Y"){ /* Only For Some members allow to space registration*/ ?>
						<?php
						$checkEvent = "select isCombo from exh_reg_payment_details where uid='$registration_id' AND `year`='2019' AND event_selected='iijs'";
						$checkEventResult = $conn->query($checkEvent);
						$getCount = $checkEventResult->num_rows;
						
						$sql = "select * from exh_reg_payment_details where uid='$registration_id' and `year`='2019' AND (event_selected='signature' || event_selected='iijs') order by event_selected desc limit 0,1";
						$ans = $conn->query($sql);
						$result = $ans->fetch_assoc();
						$gid = $result['gid'];
						$getEvent_selected = $result['event_selected'];
						$nans=$ans->num_rows;
						if($nans>0){ ?>
						<!--<div class="box_title"><h3>Exhibitor Registration</h3></div>-->
						
						
						<?php } else { ?>
						<?php
						if($_SESSION['member_type']=="NON_MEMBER"){ ?> 
						<div class="box_dash_container box-shadow">
						<div class="box_title"><h3>Exhibitor Registration</h3></div>
						<div class="d-flex justify-content-center col-100 ">
							<?php
						/*	$q_last_yr=mysql_query("select * from exh_registration where uid='$registration_id' and `show`='IIJS 2019' and section='machinery' order by exh_id desc limit 0,1");
							$r_last_yr=mysql_fetch_array($q_last_yr);
							$n_last_yr=mysql_num_rows($q_last_yr);
							if($n_last_yr>0){ */
							?>
                            <?php
                            if($current_time<=$closetime)
							echo '<a href="event_selection.php" class="btn col-100">Apply</a>';
							else
							echo '<a href="#" class="select_dash_btn btn col-100">Application Closed</a>'; ?>
						
							<?php /* }  else { 
							$q_last_yr_New = mysql_query("select * from exh_registration where uid='$registration_id'");
							$n_last_yr_New = mysql_num_rows($q_last_yr_New);
							if($n_last_yr_New==0){ ?>
                            <?php
                            if($current_time<=$closetime)
							echo '<a href="event_selection.php" class="btn ">Apply</a>';
							else
							echo '<a href="#" class="select_dash_btn btn">Coming Soon</a>';
                            ?>						
							<?php } else { ?>
							<a href="#" class="select_dash_btn btn">Coming Soon</a>
							<?php } 
								  } */?>							
						</div>
						</div>
						
						<?php }
						elseif($_SESSION['member_type']=="INTERNATIONAL"){ ?>
						<div class="box_dash_container box-shadow">
						<div class="box_title"><h3>Exhibitor Registration</h3></div>
						<div class="d-flex justify-content-center col-100">
							<!--<a href="#" class="btn ">Coming Soon</a>-->
                        <?php
                        if($current_time<=$closetime)
							echo '<a href="event_selection.php" class="btn col-100 ">Apply</a>';
						else
							echo '<a href="#" class="select_dash_btn btn col-100">Application Closed</a>';
                        ?>														
						</div>
						</div>
						<?php } else if($_SESSION['member_type']=="MEMBER"){
						/*.................................Checking KYC...................................*/
							$gcode=getGcode($registration_id,$conn);
							//$apiurl="http://api.mykycbank.com/Service.svc/44402aeb2e5c4eef8a7100f048b97d84/".$gcode;
							$apiurl="http://api.mykycbank.com/service.svc/44402aeb2e5c4eef8a7100f048b97d84/BPID/".$bp_number;
							
							$getResponse = file_get_contents($apiurl);
							$getResult = json_decode($getResponse,true);
							$apiResponse = json_decode($getResult,true);
							$KycProfileId = $apiResponse['KycProfileId'];
							//echo '<pre>'; print_r($apiResponse);
							if($apiResponse['status']==1){
								
						$schk_defaulter="select * from registration_master where id='$registration_id'";
						$qchk_defaulter=$conn->query($schk_defaulter);
						$rchk_defaulter=$qchk_defaulter->fetch_assoc();
						if($rchk_defaulter['payment_defaulter']=="N"){
						?>
						<?php
						$query1= $conn->query("select * from exh_registration where uid='$registration_id' and `show`='IIJS 2019' and last_yr_section_flag='1' and  curr_last_yr_check='N' order by exh_id desc limit 0,1");
						$num1=$query1->num_rows;
						if($num1>0){
						?>
						<div class="box_dash_container box-shadow">
						<div class="box_title"><h3>Exhibitor Registration</h3></div>
						<div class="d-flex justify-content-center col-100">
							<!--<a href="#" class="btn ">Coming Soon</a>-->
							 <?php
                             if($current_time<=$closetime)
									echo '<a href="event_selection.php" class="btn col-100">Apply</a>';
							else
								echo '<a href="#" class="select_dash_btn">Application Closed</a>';
                            ?>			
						</div>
						</div>
						<?php } else { ?>
						<div class="box_dash_container box-shadow">
						<div class="box_title"><h3>Exhibitor Registration</h3></div>
						<div class="d-flex justify-content-center col-100">
							<!--<a href="#" class="btn ">Coming Soon</a>-->
							 <?php
                            if($current_time<=$closetime)
									echo '<a href="event_selection.php" class="btn col-100">Apply</a>';
							else
								echo '<a href="#" class="select_dash_btn">Application Closed</a>';
                            ?>							
						</div>
						</div>
						<?php } }  else { ?>
                        <div class="box_dash_container box-shadow">
						<div class="box_title"><h3>Exhibitor Registration</h3></div>
						<div class="d-flex justify-content-center col-100">
							<!--<a href="#" class="btn ">Coming Soon</a>-->
							<a href="javascript:alert('<?php echo $rchk_defaulter['payment_defaulter_reason'];?>')" class="select_dash_btn" onclick="">Apply</a>							
						</div>
						</div>
						<?php } } else {  ?>
						<!--<div class="grayBlock">
						<h2>Exhibitor Registration / Exhibitor Manual</h2>  <br/><br/>
						<?php //echo "Your KYC is Not updated. Kindly Contact KYC Department on 022 61156800 or Email : support@mykycbank.com, info@mykycbank.com to update KYC No"; 
						echo $apiResponse['Message'];?>
						</div>-->
						<?php }
						} else { ?>
                        <div class="box_dash_container box-shadow">
						<div class="box_title"><h3>Exhibitor Registration</h3></div>
						<div class="d-flex justify-content-center col-100">
							You are not a member..!!					
						</div>
						</div>
						<?php } } ?>
						<?php //} ?>
						<!-- Stop Space Registration Start Mukesh Panwar -->						
					</div>
					
					<div class="clear"></div>
				</div>
				
			<!-- 	<div class="right_area">
					<?php include('include_account_links.php'); ?>
					<div class="clear"></div>
				</div> -->
				
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