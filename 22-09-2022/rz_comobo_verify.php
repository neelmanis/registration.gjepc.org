<?php
include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php"); exit; }

//require('rz_config_dev.php');
require('rz_config.php');
//session_start();
require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$success = true;

$error = "Payment Failed";

//echo '<pre>'; print_r($_SESSION); exit;

$registration_id =  $_SESSION['USERID'];
$getgeneralInfo = $_SESSION['generalInfo']; /* Get 1 step data */
$getcompanyInfo = $_SESSION['companyInfo']; /* Get 2 step data */
// $getstallInfo = $_SESSION['stallInfo'];  /* Get 3 step data */

$gid_iijs = $_SESSION['gid_iijs'];  /* Get 3 step data */
$gid_signature = $_SESSION['gid_signature'];  /* Get 3 step data */
$gid_tritiya = $_SESSION['gid_tritiya'];  /* Get 3 step data */

$event = $_SESSION['eventInfo']['event_selected'];
$eventDescription = getExhEventDescriptionEvent($event,$conn);
$event_selected = getEvent_selected($event,$conn);
$year = getExhYearEvent($event,$conn);
	
$sql_iijs = "SELECT * FROM `exh_registration` WHERE uid='$registration_id' AND gid='$gid_iijs' AND `show`='IIJS PREMIERE 2022' AND event_selected='iijs22' order by exh_id desc limit 0,1";
$query_iijs = $conn->query($sql_iijs);		
$result_iijs = $query_iijs->fetch_assoc();

$sql_signature = "SELECT * FROM `exh_registration` WHERE uid='$registration_id' AND gid='$gid_signature' AND `show`='IIJS SIGNATURE 2023' AND event_selected='signature23' order by exh_id desc limit 0,1";
$query_signature = $conn->query($sql_signature);		
$result_signature = $query_signature->fetch_assoc();


$sql_tritiya = "SELECT * FROM `exh_registration` WHERE uid='$registration_id' AND gid='$gid_tritiya' AND `show`='IIJS TRITIYA 2023' AND event_selected='iijstritiya23' order by exh_id desc limit 0,1";
$query_tritiya = $conn->query($sql_tritiya);		
$result_tritiya = $query_tritiya->fetch_assoc();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $event_name; ?> Payment </title>
<link rel="shortcut icon" href="images/fav.png" />
	<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
	<link rel="stylesheet" type="text/css" href="css/general.css" />
	<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />	 
	<link rel="stylesheet" type="text/css" href="css/responsive.css" />
	<link rel="stylesheet" type="text/css" href="css/media_query.css" />
	<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>

	<!--NAV-->
	<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="js/jquery.flexnav.js" type="text/javascript"></script>
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
</head>

<body>
<div class="wrapper">

<div class="header"><?php include('header1.php'); ?></div>
<div class="inner_container">
<div class="container">
<div class="container_leftn">

<?php
$razorpay_payment_id =  $_POST['razorpay_payment_id'];

if (empty($_POST['razorpay_payment_id']) === false)
{ 
    $api = new Api($keyId, $keySecret);

    try
    {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}
		$api = new Api($keyId, $keySecret);
		
		$payment = $api->payment->fetch($_POST['razorpay_payment_id']);
		
		//$payment_resp  = $api->payment->fetch($_POST['razorpay_payment_id'])->capture(array('amount'=>$amount,'currency' => 'INR'));
		//echo '<pre>'; print_r($payment_resp); exit;
			 
//echo '<pre>'; print_r($payment); exit;
	
	$razorpay_payment_id =  $_POST['razorpay_payment_id'];
    $razorpay_signature = $_POST['razorpay_signature'];
    $razorpay_order_id = $_SESSION['razorpay_order_id'];
    $email =  $_SESSION['EMAILID'];
	
	$error_description =  $payment->error_description;
	$card_id =  $payment->card_id;
	$bank =  $payment->bank;
	$payment_status =  $payment->status;
	$method =  $payment->method;
	$currency =  $payment->currency;
	$order_id =  $payment->order_id;
//	$amountPaid = $payment->amountPaid;
	$payment_date = date('Y-m-d',$payment->created_at);
	$notes_response = $payment->notes;
	$merchant_order_id = $notes_response->merchant_order_id;
	$amountPaid = $notes_response->amountPaid;
	
	if($registration_id!='' && $razorpay_order_id!=''){
	
	 $checks_iijs = "select tds_holder,cheque_tds_per,cheque_tds_amount from exh_reg_payment_details where uid='$registration_id' AND gid='$gid_iijs'  limit 0,1";
	$querycheck_iijs = $conn->query($checks_iijs);
	$numCount_iijs = $querycheck_iijs->num_rows; 
	$resultData_iijs = $querycheck_iijs->fetch_assoc();
	$tds_holder_iijs = $resultData_iijs["tds_holder"];
	$cheque_tds_per_iijs = $resultData_iijs["cheque_tds_per"];
	$cheque_tds_amount_iijs = $resultData_iijs["cheque_tds_amount"];
	if($numCount_iijs >0)
	{
		$updateUTRtbl_iijs = "UPDATE `utr_history` SET tds_holder='$tds_holder_iijs', `cheque_tds_per`='$cheque_tds_per_iijs',`cheque_tds_amount`='$cheque_tds_amount_iijs'	WHERE utr_number='$merchant_order_id' AND `registration_id`='$registration_id' AND `show`='IIJS PREMIERE 2022' AND `event_selected`='iijs22'"; 
		$resultUTRtbl_iijs = $conn->query($updateUTRtbl_iijs);
		if(!$resultUTRtbl_iijs) { die('Error: Update utr query failed' . $conn->error); }
	}


	$updateUTR_iijs = "UPDATE `utr_history` SET `modified_date`=NOW(),razorpay_signature='$razorpay_signature', `order_id`='$order_id',`razorpay_payment_id`='$razorpay_payment_id',`currency`='$currency',`method`='$method',`payment_status`='$payment_status',`card_id`='$card_id',`bank`='$bank',`email`='$email',`error_description`='$error_description',`payment_date`='$payment_date'
	WHERE utr_number='$merchant_order_id' AND `registration_id`='$registration_id' AND `show`='IIJS PREMIERE 2022' AND `event_selected`='iijs22'"; 
	$resultUTR_iijs = $conn->query($updateUTR_iijs);



	$checks_signature = "select tds_holder,cheque_tds_per,cheque_tds_amount from exh_reg_payment_details where uid='$registration_id' AND gid='$gid_signature'  limit 0,1";
	$querycheck_signature = $conn->query($checks_signature);
	$numCount_signature = $querycheck_signature->num_rows; 
	$resultData_signature = $querycheck_signature->fetch_assoc();
	$tds_holder_signature = $resultData_signature["tds_holder"];
	$cheque_tds_per_signature = $resultData_signature["cheque_tds_per"];
	$cheque_tds_amount_signature = $resultData_signature["cheque_tds_amount"];
	if($numCount_signature >0)
	{
		$updateUTRtbl_signature = "UPDATE `utr_history` SET tds_holder='$tds_holder_signature', `cheque_tds_per`='$cheque_tds_per_signature',`cheque_tds_amount`='$cheque_tds_amount_signature'	WHERE utr_number='$merchant_order_id' AND `registration_id`='$registration_id' AND `show`='IIJS SIGNATURE 2023' AND `event_selected`='signature23'"; 
		$resultUTRtbl_signature = $conn->query($updateUTRtbl_signature);
		if(!$resultUTRtbl_signature) { die('Error: Update utr query failed' . $conn->error); }
	}


	$updateUTR_signature = "UPDATE `utr_history` SET `modified_date`=NOW(),razorpay_signature='$razorpay_signature', `order_id`='$order_id',`razorpay_payment_id`='$razorpay_payment_id',`currency`='$currency',`method`='$method',`payment_status`='$payment_status',`card_id`='$card_id',`bank`='$bank',`email`='$email',`error_description`='$error_description',`payment_date`='$payment_date'
	WHERE utr_number='$merchant_order_id' AND `registration_id`='$registration_id' AND `show`='IIJS SIGNATURE 2023' AND `event_selected`='signature23'"; 
	$resultUTR_signature = $conn->query($updateUTR_signature);


	$checks_tritiya = "select tds_holder,cheque_tds_per,cheque_tds_amount from exh_reg_payment_details where uid='$registration_id' AND gid='$gid_tritiya'  limit 0,1";
	$querycheck_tritiya = $conn->query($checks_tritiya);
	$numCount_tritiya = $querycheck_tritiya->num_rows; 
	$resultData_tritiya = $querycheck_tritiya->fetch_assoc();
	$tds_holder_tritiya = $resultData_tritiya["tds_holder"];
	$cheque_tds_per_tritiya = $resultData_tritiya["cheque_tds_per"];
	$cheque_tds_amount_tritiya = $resultData_tritiya["cheque_tds_amount"];
	if($numCount_tritiya >0)
	{
		$updateUTRtbl_tritiya = "UPDATE `utr_history` SET tds_holder='$tds_holder_tritiya', `cheque_tds_per`='$cheque_tds_per_tritiya',`cheque_tds_amount`='$cheque_tds_amount_tritiya'	WHERE utr_number='$merchant_order_id' AND `registration_id`='$registration_id' AND `show`='IIJS TRITIYA 2023' AND `event_selected`='iijstritiya23'"; 
		$resultUTRtbl_tritiya = $conn->query($updateUTRtbl_tritiya);
		if(!$resultUTRtbl_tritiya) { die('Error: Update utr query failed' . $conn->error); }
	}


	$updateUTR_tritiya = "UPDATE `utr_history` SET `modified_date`=NOW(),razorpay_signature='$razorpay_signature', `order_id`='$order_id',`razorpay_payment_id`='$razorpay_payment_id',`currency`='$currency',`method`='$method',`payment_status`='$payment_status',`card_id`='$card_id',`bank`='$bank',`email`='$email',`error_description`='$error_description',`payment_date`='$payment_date'
	WHERE utr_number='$merchant_order_id' AND `registration_id`='$registration_id' AND `show`='IIJS TRITIYA 2023' AND `event_selected`='iijstritiya23'"; 
	$resultUTR_tritiya = $conn->query($updateUTR_tritiya);




	if(!$resultUTR_iijs) { die('Error: Update query failed' . $conn->error); }
	} else {
		echo "<script type='text/javascript'> alert('something went wrong!! Please try again');
		window.location.href='my_dashboard.php';
		</script>";
		return;	exit;
	}
	
	if($payment['status'] == 'captured'){
		$modified_date = date("Y-m-d");
		if($eventDescription == "IIJS SIGNATURE 2023"){
		$update_query_sig = "update exh_reg_payment_details set modified_date='$modified_date', payment_status='approved', document_status='approved',application_status='approved',application_comment='stepwise' where gid='$gid_signature' and uid='$registration_id' and `show`='IIJS SIGNATURE 2023'";
		$result_update_sig =$conn ->query($update_query_sig);
		}
		if($eventDescription == "IIJS TRITIYA 2023"){
		$update_query_tri = "update exh_reg_payment_details set modified_date='$modified_date', payment_status='approved', document_status='approved',application_status='approved',application_comment='stepwise' where gid='$gid_tritiya' and uid='$registration_id' and `show`='IIJS TRITIYA 2023'";
		$result_update_tri = $conn ->query($update_query_tri);
		}
		
	$message ='<table width="100%" bgcolor="#fff" style="margin:20px auto; border:2px solid #dddddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
<tr>
<td style="padding:30px;">
<table width="100%" border="0" background="#fff" cellpadding="0" cellspacing="0">
	<tr>
    	<td align="left" valign="top"><a href="https://www.gjepc.org"><img src="https://registration.gjepc.org/images/logo.png"/></a></td>
    	<td align="right"><a href="https://gjepc.org/iijs-signature/"><img src="https://registration.gjepc.org/images/signature_logo_new_2023.jpg"/><img src="https://registration.gjepc.org/images/Tritiya_Logo__new_2023.jpg" style="width: 174px;"/></a></td>
    </tr> 
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>    
    <tr><td colspan="2" height="1px" bgcolor="#333333"></td></tr>    
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>    
	<tr>
    	<td colspan="2" valign="top" style="font-size:13px;">
		<p><strong>Company Name :</strong> '.$_SESSION['COMPANYNAME'].'</p>
    	<p><strong>Dear '.$getgeneralInfo['contact_person'].',</strong> </p>
		<p><strong>Order No. : '.$_SESSION['orderId'].'</strong></p>
    	<p>Thank you for applying Online for '.$eventMail.' Exhibitor Registration. Please note your application is under approval process.</p>    	
    	</td>
    </tr>
    
    <tr><td colspan="2">&nbsp;</td></tr>    
    <tr>
    <td colspan="2">

<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; float:left;">
    <tr><td colspan="2" style="color:#14b3da;"><strong>Application Summary</strong></td></tr>
    <tr>
        <td width="35%"><strong>Last Year Participant </strong></td>
        <td width="65%">'.$result_iijs['last_yr_participant'].'</td>
        <!--<td width="65%">IIJS SIGNATURE 2022 ROI Details / IIJS SIGNATURE 2022 Allotment Details (If Not applied for IIJS SIGNATURE 2022 ROI)</td>-->
    </tr>	
	<tr>
        <td><strong>Selected Option</strong></td>
        <td>'.$result_iijs['options'].' Signature 2023</td>
    </tr>
    <tr>
        <td><strong>Section</strong></td>
        <td>'.getSection_desc($result_iijs['section'],$conn).'</td>
    </tr>
	<tr>
        <td><strong>Category</strong></td>
        <td>'.$result_iijs['category'].'</td>
    </tr>
    <tr>
        <td><strong>Area</strong></td>
        <td>'.$result_iijs['selected_area'].'</td>
    </tr>
    <!--<tr>
        <td><strong>Premium</strong></td>
        <td>'.$result_iijs['selected_premium_type'].'</td>
    </tr>-->
	<tr>
        <td><strong>Scheme</strong></td>
        <!--<td>'.$result_iijs['selected_scheme_type'].'</td>-->
        <td>Shell Scheme</td>
    </tr>
</table>

<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; float:right;">
  <tr valign="top">
    <td colspan="2"  style="color:#14b3da;"><strong>Application Payment Summary</strong><br /></td>
    </tr>
  <tr valign="top">
    <td width="30%"><strong>Total Space Cost '.$currency.' </strong></td>
    <td width="21%">'.$result_iijs['tot_space_cost_rate'].'</td>
  </tr>
  <tr valign="top">
    <td width="30%"><strong>Category Cost '.$currency.' </strong></td>
    <td width="21%">'.$result_iijs['get_category_rate'].'</td>
  </tr>
 <!-- <tr valign="top">
    <td><strong>Space cost after Incentive '.$currency.' </strong></td>
    <td>'.$result_iijs['incentive_value'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>Discount '.$currency.' </strong></td>
    <td>'.$result_iijs['discount_value'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>After Discount Space Cost '.$currency.' </strong></td>
    <td>'.$result_iijs['get_tot_space_cost_rate'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>Selected scheme rate '.$currency.' </strong></td>
    <td>'.$result_iijs['selected_scheme_rate'].'</td>
  </tr>-->
  <!--<tr valign="top">
    <td><strong>Selected premium rate '.$currency.' </strong></td>
    <td>'.$result_iijs['selected_premium_rate'].'</td>
  </tr>-->
  <tr valign="top">
    <td><strong>Sub Total '.$currency.' </strong></td>
    <td>'.$result_iijs['sub_total_cost'].'</td>
  </tr>
  <tr valign="top">
    <td valign="top"><strong>Security Deposit (10% on Sub Total) '.$currency.'</strong></td>
    <td valign="top">'.$result_iijs['security_deposit'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>GST (18% on Sub Total) '.$currency.' </strong></td>
    <td>'.$result_iijs['govt_service_tax'].'<br /></td>
  </tr>
  <tr valign="top">
    <td><strong>Grand Total '.$currency.' </strong></td>
    <td>'.$result_iijs['grand_total'].'</td>
  </tr>
</table>
	</td>
  </tr>
  <tr>
    <td colspan="2">

<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; float:left;">
    <tr><td colspan="2" style="color:#14b3da;"><strong>Application Summary</strong></td></tr>
    <tr>
        <td width="35%"><strong>Last Year Participant </strong></td>
        <td width="65%">'.$result_signarture['last_yr_participant'].'</td>
        <!--<td width="65%">IIJS SIGNATURE 2022 ROI Details / IIJS SIGNATURE 2022 Allotment Details (If Not applied for IIJS SIGNATURE 2022 ROI)</td>-->
    </tr>	
	<tr>
        <td><strong>Selected Option</strong></td>
        <td>'.$result_signarture['options'].' Signature 2023</td>
    </tr>
    <tr>
        <td><strong>Section</strong></td>
        <td>'.getSection_desc($result_signarture['section'],$conn).'</td>
    </tr>
	<tr>
        <td><strong>Category</strong></td>
        <td>'.$result_signarture['category'].'</td>
    </tr>
    <tr>
        <td><strong>Area</strong></td>
        <td>'.$result_signarture['selected_area'].'</td>
    </tr>
    <!--<tr>
        <td><strong>Premium</strong></td>
        <td>'.$result_signarture['selected_premium_type'].'</td>
    </tr>-->
	<tr>
        <td><strong>Scheme</strong></td>
        <!--<td>'.$result_signarture['selected_scheme_type'].'</td>-->
        <td>Shell Scheme</td>
    </tr>
</table>

<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; float:right;">
  <tr valign="top">
    <td colspan="2"  style="color:#14b3da;"><strong>Application Payment Summary</strong><br /></td>
    </tr>
  <tr valign="top">
    <td width="30%"><strong>Total Space Cost '.$currency.' </strong></td>
    <td width="21%">'.$result_signarture['tot_space_cost_rate'].'</td>
  </tr>
  <tr valign="top">
    <td width="30%"><strong>Category Cost '.$currency.' </strong></td>
    <td width="21%">'.$result_signarture['get_category_rate'].'</td>
  </tr>
 <!-- <tr valign="top">
    <td><strong>Space cost after Incentive '.$currency.' </strong></td>
    <td>'.$result_signarture['incentive_value'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>Discount '.$currency.' </strong></td>
    <td>'.$result_signarture['discount_value'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>After Discount Space Cost '.$currency.' </strong></td>
    <td>'.$result_signarture['get_tot_space_cost_rate'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>Selected scheme rate '.$currency.' </strong></td>
    <td>'.$result_signarture['selected_scheme_rate'].'</td>
  </tr>-->
  <!--<tr valign="top">
    <td><strong>Selected premium rate '.$currency.' </strong></td>
    <td>'.$result_signarture['selected_premium_rate'].'</td>
  </tr>-->
  <tr valign="top">
    <td><strong>Sub Total '.$currency.' </strong></td>
    <td>'.$result_signarture['sub_total_cost'].'</td>
  </tr>
  <tr valign="top">
    <td valign="top"><strong>Security Deposit (10% on Sub Total) '.$currency.'</strong></td>
    <td valign="top">'.$result_signarture['security_deposit'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>GST (18% on Sub Total) '.$currency.' </strong></td>
    <td>'.$result_signarture['govt_service_tax'].'<br /></td>
  </tr>
  <tr valign="top">
    <td><strong>Grand Total '.$currency.' </strong></td>
    <td>'.$result_signarture['grand_total'].'</td>
  </tr>
</table>
	</td>
  </tr>  
  <tr>
    <td colspan="2">

<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; float:left;">
    <tr><td colspan="2" style="color:#14b3da;"><strong>Application Summary</strong></td></tr>
    <tr>
        <td width="35%"><strong>Last Year Participant </strong></td>
        <td width="65%">'.$result_tritiya['last_yr_participant'].'</td>
        <!--<td width="65%">IIJS SIGNATURE 2023 ROI Details / IIJS SIGNATURE 2023 Allotment Details (If Not applied for IIJS SIGNATURE 2023 ROI)</td>-->
    </tr>	
	<tr>
        <td><strong>Selected Option</strong></td>
        <td>'.$result_tritiya['options'].' Tritiya 2023</td>
    </tr>
    <tr>
        <td><strong>Section</strong></td>
        <td>'.getSection_desc($result_tritiya['section'],$conn).'</td>
    </tr>
	<tr>
        <td><strong>Category</strong></td>
        <td>'.$result_tritiya['category'].'</td>
    </tr>
    <tr>
        <td><strong>Area</strong></td>
        <td>'.$result_tritiya['selected_area'].'</td>
    </tr>
    <!--<tr>
        <td><strong>Premium</strong></td>
        <td>'.$result_tritiya['selected_premium_type'].'</td>
    </tr>-->
	<tr>
        <td><strong>Scheme</strong></td>
        <!--<td>'.$result_tritiya['selected_scheme_type'].'</td>-->
        <td>Shell Scheme</td>
    </tr>
</table>

<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; float:right;">
  <tr valign="top">
    <td colspan="2"  style="color:#14b3da;"><strong>Application Payment Summary</strong><br /></td>
    </tr>
  <tr valign="top">
    <td width="30%"><strong>Total Space Cost '.$currency.' </strong></td>
    <td width="21%">'.$result_tritiya['tot_space_cost_rate'].'</td>
  </tr>
  <tr valign="top">
    <td width="30%"><strong>Category Cost '.$currency.' </strong></td>
    <td width="21%">'.$result_tritiya['get_category_rate'].'</td>
  </tr>
 <!-- <tr valign="top">
    <td><strong>Space cost after Incentive '.$currency.' </strong></td>
    <td>'.$result_tritiya['incentive_value'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>Discount '.$currency.' </strong></td>
    <td>'.$result_tritiya['discount_value'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>After Discount Space Cost '.$currency.' </strong></td>
    <td>'.$result_tritiya['get_tot_space_cost_rate'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>Selected scheme rate '.$currency.' </strong></td>
    <td>'.$result_tritiya['selected_scheme_rate'].'</td>
  </tr>-->
  <!--<tr valign="top">
    <td><strong>Selected premium rate '.$currency.' </strong></td>
    <td>'.$result_tritiya['selected_premium_rate'].'</td>
  </tr>-->
  <tr valign="top">
    <td><strong>Sub Total '.$currency.' </strong></td>
    <td>'.$result_tritiya['sub_total_cost'].'</td>
  </tr>
  <tr valign="top">
    <td valign="top"><strong>Security Deposit (10% on Sub Total) '.$currency.'</strong></td>
    <td valign="top">'.$result_tritiya['security_deposit'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>GST (18% on Sub Total) '.$currency.' </strong></td>
    <td>'.$result_tritiya['govt_service_tax'].'<br /></td>
  </tr>
  <tr valign="top">
    <td><strong>Grand Total '.$currency.' </strong></td>
    <td>'.$result_tritiya['grand_total'].'</td>
  </tr>
</table>
	</td>
  </tr>    
   
	<tr><td colspan="2" height="25px">&nbsp;</td></tr>
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>    
    <tr>
    <td colspan="2" style="line-height:20px;">
	<p align="justify">All the applicant members will have to update the details of advance payment along with UTR number and TDS on the dashboard after successful submission of online space application along with payment details before the deadline.</p>
	<p>A system generated notification will be sent to you on successful approval of your application.</p>
	<p>Kind Regards,</p>   
	<p><strong>IIJS Team,</strong></p>

</td>
</tr>
</table>

</td>
</tr>
</table>';

	
	$to = $_SESSION['EMAILID'].",".$to_admin.",notification@gjepcindia.com,iijs.gjepc@gmail.com"; 
	//$to = 'santosh@kwebmaker.com';
  //$to = 'rohit@kwebmaker.com';
	$subject = "Exhibitor Registration ";
	$cc = "";
  $email_array = explode(",",$to);
  send_mailArray($email_array,$subject,$message,$cc);
	
} else {	
	echo json_encode(array("status"=>"fail","error"=>$payment['error_description']));
}

if ($success === true)
{
    $html = "<p>Your payment was successful</p>
             <p>Payment ID: {$_POST['razorpay_payment_id']}</p>";
}
else
{
    $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
}
?>
<div class="container_wrap">
	<div class="container" id="manualFormContainer">
	<h1 style="color:green;">PAYMENT </h1>
	<div id="formWrapper">
	<p><?php echo $html;?></p>
	</div>
	<div class="clear"></div>
	</div>
</div>
<?php
/* Now Unset session */
	unset($_SESSION['eventInfo']);	   /* Event Applying  */	 
	unset($_SESSION['generalInfo']);  /* Get 1 step data */
	unset($_SESSION['companyInfo']); /* Get 2 step data */
	unset($_SESSION['stallInfo']);    /* Get 3 step data */
	unset($_SESSION['orderId']);
	unset($_SESSION['razorpay_order_id']);
	header("Refresh: 3; url=https://registration.gjepc.org/my_dashboard.php");
?>
</div>
  </div>
  </div>

<div class="clear"></div>
<div class="footer_wrap">
<?php include ('footer.php'); ?>
</div>
</div>
<!--footer ends-->
</body>
</html>