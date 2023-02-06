<?php
include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php"); exit; }

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
$getstallInfo = $_SESSION['stallInfo'];  /* Get 3 step data */
$gid = $_SESSION['gid'];  /* Get 3 step data */

$event = $_SESSION['eventInfo']['event_selected'];
$eventDescription = getExhEventDescriptionEvent($event,$conn);
$event_selected = getEvent_selected($event,$conn);
$year = getExhYearEvent($event,$conn);
	
$sqlm = "SELECT * FROM `exh_registration` WHERE uid='$registration_id' AND gid='$gid' AND `show`='$eventDescription' AND event_selected='$event' order by exh_id desc limit 0,1";
$querym = $conn->query($sqlm);		
$resultm = $querym->fetch_assoc();

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
    $email =  $_SESSION['email'];
	
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
	
	$checks = "select tds_holder,cheque_tds_per,cheque_tds_amount from exh_reg_payment_details where uid='$registration_id' AND gid='$gid' AND `show`='$eventDescription' AND event_selected='$event' limit 0,1";
	$querycheck = $conn->query($checks);
	$numCount = $querycheck->num_rows; 
	$resultData = $querycheck->fetch_assoc();
	$tds_holder = $resultData["tds_holder"];
	$cheque_tds_per = $resultData["cheque_tds_per"];
	$cheque_tds_amount = $resultData["cheque_tds_amount"];
	if($numCount >0)
	{
		$updateUTRtbl = "UPDATE `utr_history` SET tds_holder='$tds_holder', `cheque_tds_per`='$cheque_tds_per',`cheque_tds_amount`='$cheque_tds_amount'	WHERE utr_number='$merchant_order_id' AND `registration_id`='$registration_id' AND `show`='$eventDescription' AND `event_selected`='$event'"; 
		$resultUTRtbl = $conn->query($updateUTRtbl);
		if(!$resultUTRtbl) { die('Error: Update utr query failed' . $conn->error); }
	}


	$updateUTR = "UPDATE `utr_history` SET `modified_date`=NOW(),razorpay_signature='$razorpay_signature', `order_id`='$order_id',`razorpay_payment_id`='$razorpay_payment_id',`currency`='$currency',`method`='$method',`payment_status`='$payment_status',`card_id`='$card_id',`bank`='$bank',`email`='$email',`error_description`='$error_description',`payment_date`='$payment_date'
	WHERE utr_number='$merchant_order_id' AND `registration_id`='$registration_id' AND `show`='$eventDescription' AND `event_selected`='$event'"; 
	$resultUTR = $conn->query($updateUTR);
	if(!$resultUTR) { die('Error: Update query failed' . $conn->error); }
	} else {
		echo "<script type='text/javascript'> alert('something went wrong!! Please try again');
		window.location.href='my_dashboard_uat.php';
		</script>";
		return;	exit;
	}
	
	if($payment['status'] == 'captured'){
		
		$update_query = "update exh_reg_payment_details set modified_date=NOW(), payment_status='approved', document_status='approved',application_status='approved',application_comment='stepwise' where gid='$gid' and uid='$registration_id' and `show`='$eventDescription'";
		$result_update=$conn ->query($update_query);
			
	$message ='<table width="100%" bgcolor="#fff" style="margin:20px auto; border:2px solid #dddddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
<tr>
<td style="padding:30px;">
<table width="100%" border="0" background="#fff" cellpadding="0" cellspacing="0">
	<tr>
    	<td align="left" valign="top"><a href="https://www.gjepc.org"><img src="https://registration.gjepc.org/images/logo.png"/></a></td>
    	<td align="right"><a href="https://gjepc.org/iijs-premiere/"><img src="https://gjepc.org/iijs-premiere/assets/images/iijs_logo.png"/></a></td>
    </tr> 
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>    
    <tr><td colspan="2" height="1px" bgcolor="#333333"></td></tr>    
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>    
	<tr>
    	<td colspan="2" valign="top" style="font-size:13px;">
		<p><strong>Company Name :</strong> '.$_SESSION['COMPANYNAME'].'</p>
    	<p><strong>Dear '.$getgeneralInfo['contact_person'].',</strong> </p>
		<p><strong>Order No. : '.$_SESSION['orderId'].'</strong></p>
    	<p>Thank you for applying Online for IIJS PREMIERE 2022 Exhibitor Registration. Please note your application is under approval process.</p>    	
    	</td>
    </tr>
    
    <tr><td colspan="2">&nbsp;</td></tr>    
    <tr>
    <td colspan="2">

<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; float:left;">
    <tr><td colspan="2" style="color:#14b3da;"><strong>Application Summary</strong></td></tr>
    <tr>
        <td width="35%"><strong>Last Year Participant </strong></td>
        <td width="65%">'.$resultm['last_yr_participant'].'</td>
    </tr>	
	<tr>
        <td><strong>Selected Option</strong></td>
        <td>'.$resultm['options'].'</td>
    </tr>
    <tr>
        <td><strong>Section</strong></td>
        <td>'.getSection_description($resultm['section'],$conn).'</td>
    </tr>
	<tr>
        <td><strong>Category</strong></td>
        <td>'.$resultm['category'].'</td>
    </tr>
    <tr>
        <td><strong>Area</strong></td>
        <td>'.$resultm['selected_area'].'</td>
    </tr>
    <!--<tr>
        <td><strong>Premium</strong></td>
        <td>'.$resultm['selected_premium_type'].'</td>
    </tr>-->
	<tr>
        <td><strong>Scheme</strong></td>
        <!--<td>'.$resultm['selected_scheme_type'].'</td>-->
        <td>Shell Scheme</td>
    </tr>
</table>

<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; float:right;">
  <tr valign="top">
    <td colspan="2"  style="color:#14b3da;"><strong>Application Payment Summary</strong><br /></td>
    </tr>
  <tr valign="top">
    <td width="30%"><strong>Total Space Cost '.$currency.' </strong></td>
    <td width="21%">'.$resultm['tot_space_cost_rate'].'</td>
  </tr>
  <tr valign="top">
    <td width="30%"><strong>Category Cost '.$currency.' </strong></td>
    <td width="21%">'.$resultm['get_category_rate'].'</td>
  </tr>
 <!-- <tr valign="top">
    <td><strong>Space cost after Incentive '.$currency.' </strong></td>
    <td>'.$resultm['incentive_value'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>Discount '.$currency.' </strong></td>
    <td>'.$resultm['discount_value'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>After Discount Space Cost '.$currency.' </strong></td>
    <td>'.$resultm['get_tot_space_cost_rate'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>Selected scheme rate '.$currency.' </strong></td>
    <td>'.$resultm['selected_scheme_rate'].'</td>
  </tr>-->
  <!--<tr valign="top">
    <td><strong>Selected premium rate '.$currency.' </strong></td>
    <td>'.$resultm['selected_premium_rate'].'</td>
  </tr>-->
  <tr valign="top">
    <td><strong>Sub Total '.$currency.' </strong></td>
    <td>'.$resultm['sub_total_cost'].'</td>
  </tr>
  <tr valign="top">
    <td valign="top"><strong>Security Deposit (10% on Sub Total) '.$currency.'</strong></td>
    <td valign="top">'.$resultm['security_deposit'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>GST (18% on Sub Total) '.$currency.' </strong></td>
    <td>'.$resultm['govt_service_tax'].'<br /></td>
  </tr>
  <tr valign="top">
    <td><strong>Grand Total '.$currency.' </strong></td>
    <td>'.$resultm['grand_total'].'</td>
  </tr>
</table>
	</td>
  </tr>  
   
	<tr><td colspan="2" height="25px">&nbsp;</td></tr>
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>    
    <tr>
    <td colspan="2" style="line-height:20px;">
	<p align="justify">All the applicant members will have to submit online space application along with payment before the deadline.</p>
	<p>A system generated notification will be sent to you on successful approval of your application.</p>
	<p>Kind Regards,</p>   
	<p><strong>IIJS Team,</strong></p>

</td>
</tr>
</table>

</td>
</tr>
</table>';
	
	//$to = $_SESSION['EMAILID'].",notification@gjepcindia.com,iijs.gjepc@gmail.com"; 
	$to = "iijs.gjepc@gmail.com,notification@gjepcindia.com";
	$subject = "Exhibitor Registration For IIJS PREMIERE 2022";
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
	header("Refresh: 3; url=https://registration.gjepc.org/my_dashboard_uat.php");
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