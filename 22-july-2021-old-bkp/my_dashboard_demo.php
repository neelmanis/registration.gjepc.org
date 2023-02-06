<?php include('header_include.php');
	if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit;	}
	$registration_id = filter($_SESSION['USERID']);
?>
<?php
date_default_timezone_set('Asia/Kolkata');
$cr_date=date('d-m-Y H:i:s');
$current_time=strtotime($cr_date);
//echo "Last Time : ".$checking_time=strtotime("11-7-2018 23:59:59");
$checking_time=strtotime("23-07-2019 23:59:00");
//$checking_time=strtotime("23-07-2018 19:10:00");

$closetime = strtotime("13-11-2019 23:55:00");
?>
	<?php
	/* IVR Start */
	/* $fetch_status="select application_status from ivr_registration_details where uid=".$_SESSION['USERID']." and trade_show='IIJS 2018' LIMIT 1";
	$get_status=mysql_query($fetch_status);	
	$show_status = mysql_fetch_array($get_status); */
	/* IVR End */
		
	/* Check Visitor filled obmp profile*/
	$fetch_status_pvr="select obmp_application_status from visitor_obmp_details where uid=".$_SESSION['USERID']." and participate_for_show='signature' and year='2020' LIMIT 1";
	$get_status_pvr=mysql_query($fetch_status_pvr);
	/*if(!$get_status_pvr){ echo "error while processing"; exit; } */
	$show_status_pvr = mysql_fetch_array($get_status_pvr);	
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
	$sql="delete from utr_history where id='$_REQUEST[id]'";
	$result = mysql_query($sql);
	if(!$result) { die('Error: ' . mysql_error());}
	echo"<meta http-equiv=refresh content=\"0;url=my_dashboard.php\">";
}
?>
<?php
$saveUTR = $_POST['saveUTR'];
if($saveUTR=="saveinfo")
{
	$gcodes=getGcode($registration_id);
	$utr_number = filter($_POST['utr_number']);
	$event = filter($_POST['event']);
	$amountPaid = filter($_POST['amountPaid']);
	$tdsAmount = filter($_POST['tdsAmount']);
	if(empty($event)) { $eventError = "Plz Select Event Participated"; }
	elseif(empty($utr_number)) { $utrNameError = "Plz Enter UTR Number"; }
	elseif(empty($amountPaid)) { $amountPaidError = "Plz Enter Amount Paid"; }
	else {
		$mmx = "SELECT * FROM `utr_history` WHERE registration_id='$registration_id' AND utr_number='$utr_number' AND `show`='IIJS Signature 2020' AND `event_selected`='$event'";
		$mmxResult = mysql_query($mmx);
		$countUTR = mysql_num_rows($mmxResult);
		if($countUTR > 0)
			{
			$mmRowx = mysql_fetch_array($mmxResult);
			$id = $mmRowx['id'];
			
			$updateUTR = "UPDATE `utr_history` SET `modified_date`=NOW(),`utr_number`='$utr_number',`amountPaid`='$amountPaid', `tdsAmount`='$tdsAmount' WHERE `registration_id`='$registration_id' AND id='$id' AND `show`='IIJS Signature 2020' AND `event_selected`='$event'";
			$resultUTR = mysql_query($updateUTR);
			if($resultUTR) { $utrNameSuccess = "Saved Successfully"; }
					} else {
			$insertUTR = "INSERT INTO `utr_history`(`post_date`, `registration_id`,`gcode`, `utr_number`,`amountPaid`, `tdsAmount`, `show`,`event_selected`, `status`) VALUES (NOW(),'$registration_id','$gcodes','$utr_number','$amountPaid','$tdsAmount','IIJS Signature 2020','$event','1')";
			$resultUTR = mysql_query($insertUTR);
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
		<link rel="stylesheet" type="text/css" href="css/general.css" />
		<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />
		
		<link rel="stylesheet" type="text/css" href="css/responsive.css" />
		<link rel="stylesheet" type="text/css" href="css/media_query.css" />
		<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
		<!--NAV-->
		<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js"></script>
		<script src="js/common.js"></script>
		<!--NAV-->
		<!-- UItoTop plugin -->
		<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css" />
		<script src="js/easing.js" type="text/javascript"></script>
		<script src="js/jquery.ui.totop.js" type="text/javascript"></script>
		<script type="text/javascript">
		$(document).ready(function() {
		$().UItoTop({ easingType: 'easeOutQuart' });
		});
		</script>
		<style>
		.member_type{float: right;
		margin-top: -48px;
		width: auto;
		}
		.member_type img{    display: inline-block;
		/* width: 45px; */
		background: #8873bd;
		height: 35px;
		margin-top: -1px;
			margin-right: -4px;}
		.member_type span{padding: 11px 15px;background: #8873bd}
		.box_dash{width: 90%;min-height:100px;margin-left: 50%;transform: translate(-50%);background: #fff;border: 1px solid #f5876b;border-radius: 7px;
			text-align:center;-webkit-box-shadow: 6px 6px 9px -4px rgba(0,0,0,0.75);display: flex;justify-content: space-around;align-items: center;
		-moz-box-shadow: 6px 6px 9px -4px rgba(0,0,0,0.75);
		box-shadow: 6px 6px 9px -4px rgba(0,0,0,0.75);flex-wrap: wrap;padding: 30px 0;}
		.btn{padding:10px 15px; text-align: center;/*margin-right: 8px;*/ border-radius: 5px;background: #000;color: #fff;	transition: all 0.4s }
		.btn:hover{background: #f04f23;color:#000;}
		.box_dash_container{position: relative; margin-bottom:30px;}
		.box_dash_container .box_title {position: absolute;
		text-align: center;
		left: 50%;
		transform: translate(-50%);
		z-index: 1;
		background: #fff;
		top: -22px;
		padding: 0 8px;}
		.box_dash_container .box_title h3{display: inline-block;}
	/*	.orange{background: #f14e23}
		.yellow{background: #fdcd0a}
		.green{background: #99c31c}*/
		.box_exhibitor{flex-flow: column;padding-top: 30px;padding-bottom: 30px}
		#form-horizontal{margin: 20px 0; }

		.form-control{
  width: 100%;
  padding: 5px 5px;
  margin: 8px 0;
  box-sizing: border-box;
  text-align: left;
  border:1px solid#ccc;
  transition: all 0.6s;
}
.form-group{display: flex;
    flex-flow: row;justify-content: space-between;margin-bottom: 15px}
.form-control:focus{border:1px solid#000;}
.form-group-inner{margin:0px 5px 0px 5px}
.submit_button{background: #f04f23;padding:5px 10px;color:#000; border:0px solid #000;border-radius: 5px;}
#table_data {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 96%;
}

#table_data td, #table_data th {
  border: 1px solid #ddd;
  padding: 8px;
}

#table_data tr:nth-child(even){background-color: #f2f2f2;}

#table_data tr:hover {background-color: #ddd;}

#table_data th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #776e6e;
  color: white;
}


.box_dash a {position:relative;padding: 15px 20px 25px 20px; font-size:13px;}
.box_dash a span {position:absolute;bottom: -10px;max-width: 50px;margin: 0 auto;font-size: 12px;background: #fff;border: 2px solid #ddd;/* padding:0 10px; */line-height: 20px;color: #444;border-radius: 100px;font-weight:bold;left: 0;right: 0;}



</style>

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
			<div class="header">
				<?php include('header1.php'); ?>
			</div>
			<!--<div class="new_banner">
				<img src="images/banners/banner.jpg"/>
			</div>-->
			<div class="inner_container">
				<div class="breadcrum"><a href="index.php">Home</a> > My Dashboard</div>
				<div class="clear"></div>
				
				<div class="content_area">
					
					<div class="pg_title">						
						<div class="title_cont">
							<span class="top">My <img src="images/titles/joint.png" style="position:absolute; top:31px; right:0px;" /></span>
							<span class="below">Dashboard</span>
							<div class="clear"></div>							
						</div>						
					</div>
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
								$qchk_membership=mysql_query($schk_membership);
								$get_membership=mysql_fetch_array($qchk_membership);								
								$nchk_membership=mysql_num_rows($qchk_membership);
								
								$_SESSION['combo']=getUserCombo($registration_id);
								
								if($nchk_membership>0){
									$_SESSION['member_type']= 'MEMBER'; 
									$_SESSION['membership_certificate_type']= $get_membership['membership_certificate_type'];
									$_SESSION['msme_ssi_status']= chk_msme($registration_id);
									}
									else { $_SESSION['member_type']= 'NON_MEMBER'; }
								}
								else{ $_SESSION['member_type']= 'INTERNATIONAL';}
									echo $_SESSION['member_type'];
								?>
							</span>						
					</div>	
					
					<?php
					/* Member Visitor Registration Start  */
					if($_SESSION['COUNTRY']=="IN")
					{	
						//$sql = "select * from exh_reg_payment_details where uid='$registration_id' and `show`='IIJS 2019' AND document_status!='rejected' AND payment_status!='rejected' order by payment_id desc limit 0,1";
						$sql = "select * from exh_reg_payment_details where uid='$registration_id' and `show`='IIJS 2019' AND allow_visitor='N' order by payment_id desc limit 0,1";
						$ans = mysql_query($sql);
						$result = mysql_fetch_array($ans);
						$nans=mysql_num_rows($ans);
						if($nans==0){
						
						//echo "<p><a href='#' id='trigger'> *** Domestic Visitor Note</a></p><h2>Domestic Visitor Registration</h2><br><br>";
						echo "<div class='box_dash_container'>
						<div class='box_title'><h3>Domestic Visitor Registration</h3></div>
						<div class='box_dash'>";						
						echo '<a href="employee_directory.php" class="btn orange" title="Add / Edit Application"><span>Step 1</span>Manage Directory</a>';
						
						if($show_status_pvr['obmp_application_status']==1) {
						echo '<a href="visitor_registration.php" class="btn orange" title="Select Show And Make Payment"><span>Step 2</span>Registration Application</a>';
						} else {
						echo '<a href="member_obmp_profile.php" class="btn orange" title="Select Show And Make Payment">Registration Application</a>';
						}
						
						echo '<a href="manage_address.php" class="btn orange"  title="Add /Edit Address"><span>Step 3</span>Manage Address</a>';
						echo '<a href="order_history.php" class="btn orange" title="Registration Summary"><span>Step 4</span>Orders</a>';	
						echo '</div></div>';
						}
					}
					/* Member Visitor Registration End  */
					
					/* INTERNATIONAL Visitor Registration Start */					
					if($_SESSION['COUNTRY']!="IN"){	?>
					<div class="box_dash_container">
						<div class="box_title"><h3>International Visitor Registration</h3></div>
						<div class='box_dash'>
						<?php
						$check = "select * from ivr_registration_details where uid=".$_SESSION['USERID']." ";
						$checkq = mysql_query($check);
						$totalnum = mysql_num_rows($checkq);
						while($rows = mysql_fetch_array($checkq )){
						$total_status = $rows['application_status'];
						}

						if(!empty($totalnum)){
							if($total_status == "1"){							
								echo '<a href="i_v_r.php?action=addnew" class="btn orange">Add New</a>'; 
							}
										
						$sqlivr = "select * from ivr_registration_details where uid=".$_SESSION['USERID']." ";
						$queryivr = mysql_query($sqlivr);						  
						while($rowivr = mysql_fetch_assoc($queryivr))
						{
							$ivrid = $rowivr['eid'];
							$first_name = $rowivr['first_name'];
							if($rowivr['application_status'] == 1){
							echo '<a href="international_visitor_registration.php?eid='.$ivrid.'" class="btn orange">'.$first_name.'</a>';
							} else {
							echo '<a href="i_v_r.php?id='.$ivrid.'" class="btn orange">View Application Summary</a>';	
							} 
						}					 
						}  else {									
							echo '<a href="i_v_r.php?action=addnew" class="btn orange">Apply</a>';							
							//echo '<a href="#" class="btn orange">Closed</a>';							
						} ?>
						</div>
						</div>
						<?php }	?>					
											
					<div class="clear"></div>
					
					<!-- Start Space Registration Start Mukesh Panwar -->
					<div class="box_dash_container">						
						<?php
						$checkiijs = "select temp_roi_check_iijs from registration_master where id='$registration_id'";
						$qchk = mysql_query($checkiijs);
						$rchk = mysql_fetch_array($qchk);
						//echo '---'.$rchk['temp_roi_check_iijs'];
						//if($rchk['temp_roi_check_iijs']=="Y"){ /* Only For Some members allow to space registration*/ ?>
						<?php
						$sql = "select * from exh_reg_payment_details where uid='$registration_id' and `show`='IIJS Signature 2020' order by payment_id desc limit 0,1";
						$ans = mysql_query($sql);
						$result = mysql_fetch_array($ans);
						$gid = $result['gid'];
						$nans=mysql_num_rows($ans);
						if($nans>0){
						?>
						<div class="box_title"><h3>Exhibitor Registration</h3></div>
						<div class="box_dash box_exhibitor">
							<a href="exhibitor_registration_print_application.php?gid=<?php echo $gid;?>" class="btn orange">View Application Summary / Exhibitor Manual</a>	
						
						<!-------------- UTR START ----------------------------->
						
						<div class="form_payment">
						<h3><b>Update Payment Details </b></h3>
						
						<form name="utr" method="POST" action="" id="form-horizontal">
						<input type="hidden" name="saveUTR" value="saveinfo">
						<?php 
					//	$sqlShow = "select * from exh_reg_payment_details where uid='$registration_id' AND `show`='IIJS Signature 2020' order by payment_id desc limit 0,2";
						$sqlShow = "select * from exh_reg_payment_details where uid='$registration_id' AND `isCombo`='Y' order by payment_id desc limit 0,2";
						$resultShow = mysql_query($sqlShow);
						$countShow=mysql_num_rows($resultShow);
						if($countShow==0){
						$sqlShow = "select * from exh_reg_payment_details where uid='$registration_id' AND `isCombo`='N' order by payment_id desc limit 0,1";
						$resultShow = mysql_query($sqlShow);
						}
						?>
							<div class="form-group">
							<div class="form-group-inner">
							<label>Event Participated: </label>
							
							<select  name="event" id="event" class="form-control">
							<option value="">--Select Event--</option>
							<?php while($shows = mysql_fetch_assoc($resultShow) ){ ?>
							<option value="<?php echo $shows['event_selected']?>" <?php if($event == $shows['event_selected']){echo "selected";}?>><?php if( $shows['event_selected'] == "signature"){ echo "IIJS Signature 2020";}else{ echo "IIJS Premiere 2020";}?></option>
							<?php } ?>
							</select>
							
							<?php if(isset($eventError)) { echo  '<span style="color: red;"/>'.$eventError.'</span>';} ?>
							</div>
							<div class="form-group-inner">
							<label>UTR Number : </label>
							
							<input type="text" class="form-control" id="utr_number" name="utr_number" value="<?php echo $utr_number;?>"/>
							<?php if(isset($utrNameError)) { echo  '<span style="color: red;"/>'.$utrNameError.'</span>';} ?>
							</div>
							<div class="form-group-inner">
							<label>Amount Paid : </label>
							<input type="number" class="form-control" id="amountPaid" name="amountPaid" value="<?php echo $amountPaid;?>" onkeypress="return isNumberKey(event)"/>
							<?php if(isset($amountPaidError)) { echo  '<span style="color: red;"/>'.$amountPaidError.'</span>';} ?>
							</div>
							<div class="form-group-inner">
							<label>TDS Amount(If Any) : </label>
							<input type="number" class="form-control" id="tdsAmount" name="tdsAmount" value="<?php echo $tdsAmount;?>"/>				
								<?php if(isset($utrNameSuccess)){ echo '<span style="color: green;"/>'.$utrNameSuccess.'</span>';} ?>
							</div>
							</div>
							<input type="submit" class="submit_button" id="submit" value="SAVE"/>
						</form>
						
						<div class="clear"></div>
						<?php 
						$utrExist = "SELECT * FROM `utr_history` WHERE registration_id='$registration_id' AND `show`='IIJS Signature 2020'";
						$existResult = mysql_query($utrExist);
						$countPayment = mysql_num_rows($existResult);
						if($countPayment > 0){
						?>
						<table>
						<tr> <td> Payment Details </td></tr>
						</table>
						<table id="table_data">
							<tr>
								<th align="center">UTR No</th>
								<th align="center">Amount Paid</th>
								<th align="center">TDS Amount</th>
								<th align="center">Delete</th>
								<th align="center">Comment</th>
							</tr>
								<?php				
								$totalPrice = 0;
								while($printutr = mysql_fetch_array($existResult))
								{
								$id = $printutr['id']; 
								$getUTR_no = $printutr['utr_number']; 
								$amountPaid = $printutr['amountPaid']; 
								$tdsAmount = $printutr['tdsAmount']; 
								$utr_approved = $printutr['utr_approved'];
								$comment = $printutr['comment'];
								?>
								<tr>
								<td align="center"><?php echo $getUTR_no;?></td>
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
						$utrExistTotal = "SELECT sum(amountPaid),sum(tdsAmount) FROM `utr_history` WHERE registration_id='$registration_id' AND `show`='IIJS Signature 2020'";
						$existResultTotal = mysql_query($utrExistTotal);
						$countTotal  = mysql_num_rows($existResultTotal);
						if($countTotal > 0) {
						?>
						<table id="table_data">
							<tr>
							<th align="center">Total Amount Paid</th>
							<th align="center">Total TDS Amount</th>
							</tr>
							<tbody>
							<?php	
							while($printutr = mysql_fetch_array($existResultTotal))
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
						
						</div>
						</div>
						<!-------------- UTR END ----------------------------->
						
						<?php } else { ?>
						<?php
						if($_SESSION['member_type']=="NON_MEMBER"){ ?> 
						<div class="box_dash_container">
						<div class="box_title"><h3>Exhibitor Registration</h3></div>
						<div class="box_dash">
							<?php
							$q_last_yr=mysql_query("select * from exh_registration where uid='$registration_id' and `show`='IIJS 2019' and section='machinery' order by exh_id desc limit 0,1");
							$r_last_yr=mysql_fetch_array($q_last_yr);
							$n_last_yr=mysql_num_rows($q_last_yr);
							if($n_last_yr>0){
							?>
                            <?php
                            if($current_time<=$closetime)
							echo '<a href="event_selection.php" class="btn orange">Apply</a>';
							else
							echo '<a href="#" class="select_dash_btn btn">Coming Soons</a>'; ?>
						
							<?php } else { 
							$q_last_yr_New = mysql_query("select * from exh_registration where uid='$registration_id'");
							$n_last_yr_New = mysql_num_rows($q_last_yr_New);
							if($n_last_yr_New==0){ ?>
                            <?php
                            if($current_time<=$closetime)
							echo '<a href="event_selection.php" class="btn orange">Apply</a>';
							else
							echo '<a href="#" class="select_dash_btn btn">Coming Soonss</a>';
                            ?>						
							<?php } else { ?>
							<a href="#" class="select_dash_btn btn">Coming Soon</a>
                            <!--<a href="exhibitor_registration_step_1.php" class="btn orange">Apply</a>-->
							<!--<a href="#" class="btn orange">Kindly Renew GJEPC membership to apply for stall</a>-->
							<?php } } ?>							
						</div>
						</div>
						
						<?php }
						elseif($_SESSION['member_type']=="INTERNATIONAL"){ ?>
						<div class="box_dash_container">
						<div class="box_title"><h3>Exhibitor Registration</h3></div>
						<div class="box_dash">
							<!--<a href="#" class="btn orange">Coming Soon</a>-->
                        <?php
                        if($current_time<=$closetime)
							echo '<a href="exhibitor_registration_step_1.php" class="btn orange">Apply</a>';
						else
							echo '<a href="#" class="select_dash_btn btn">Coming Soon</a>';
                        ?>														
						</div>
						</div>
						<?php } else if($_SESSION['member_type']=="MEMBER"){
						/*.................................Checking KYC...................................*/
							$gcode=getGcode($registration_id);
							$apiurl="http://api.mykycbank.com/Service.svc/44402aeb2e5c4eef8a7100f048b97d84/".$gcode;
							
							$getResponse = file_get_contents($apiurl);
							$getResult = json_decode($getResponse,true);
							$apiResponse = json_decode($getResult,true);
								
						$schk_defaulter="select * from registration_master where id='$registration_id'";
						$qchk_defaulter=mysql_query($schk_defaulter);
						$rchk_defaulter=mysql_fetch_array($qchk_defaulter);
						if($rchk_defaulter['payment_defaulter']=="N"){
						?>
						<?php
						$query1=mysql_query("select * from exh_registration where uid='$registration_id' and `show`='IIJS 2018' and last_yr_section_flag='1' and  curr_last_yr_check='N' order by exh_id desc limit 0,1");
						$num1=mysql_num_rows($query1);
						if($num1>0){
						?>
						<div class="box_dash_container">
						<div class="box_title"><h3>Exhibitor Registration</h3></div>
						<div class="box_dash">
							<!--<a href="#" class="btn orange">Coming Soon</a>-->
							 <?php
                                                         if($current_time<=$closetime)
		echo '<a href="event_selection.php" class="btn orange">Apply</a>';
else
	echo '<a href="#" class="select_dash_btn">Coming Soon</a>';
                                                     ?>			
						</div>
						</div>
						<?php } else { ?>
						<div class="box_dash_container">
						<div class="box_title"><h3>Exhibitor Registration</h3></div>
						<div class="box_dash">
							<!--<a href="#" class="btn orange">Coming Soon</a>-->
							 <?php
                                                         if($current_time<=$closetime)
		echo '<a href="event_selection.php" class="btn orange">Apply</a>';
else
	echo '<a href="#" class="select_dash_btn">Coming Soon</a>';
                                                     ?>							
						</div>
						</div>
						<?php } }  else { ?>
                        <div class="box_dash_container">
						<div class="box_title"><h3>Exhibitor Registration</h3></div>
						<div class="box_dash">
							<!--<a href="#" class="btn orange">Coming Soon</a>-->
							<a href="javascript:alert('<?php echo $rchk_defaulter['payment_defaulter_reason'];?>')" class="select_dash_btn" onclick="">Apply</a>							
						</div>
						</div>
						<?php }
						} else { ?>
                        <div class="box_dash_container">
						<div class="box_title"><h3>Exhibitor Registration</h3></div>
						<div class="box_dash">
							You are not a member..!!					
						</div>
						</div>
						<?php } } ?>
						<?php //} ?>
						<!-- Stop Space Registration Start Mukesh Panwar -->						
					</div>
					
					<div class="clear"></div>
				</div>
				
				<div class="right_area">
					<?php include('include_account_links.php'); ?>
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