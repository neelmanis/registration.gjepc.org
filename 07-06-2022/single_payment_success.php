<?php 
include('header_include.php');
//if(!isset($_SESSION['registration_id'])){ header("location:login.php");	exit; }

if(!isset($_SESSION['registration_id']) && !isset($_SESSION['visitor_id'])){
$registration_id = $_REQUEST['registration_id'];
$visitor_id = $_REQUEST['visitor_id'];
} else {
$registration_id = $_SESSION['registration_id'];
$visitor_id = $_SESSION['visitor_id'];
}

$email = getVisitorEmail($visitor_id,$conn); 
$CompanyName = getCompanyName($registration_id,$conn); 
$ownerMobile = getVisitorMobile($visitor_id,$conn);
$visitorPAN = getVisitorPAN($visitor_id,$conn);
$visitorMobile = getVisitorMobile($visitor_id,$conn);

require_once 'ebs/TransactionRequestBean.php';
require_once 'ebs/TransactionResponseBean.php';
$transactionRequestBean = new TransactionRequestBean();

$sql_event = "SELECT * FROM `visitor_event_master` WHERE `status` ='1' AND `shortcode` = '".$_SESSION['show']."'";
$result_event = $conn->query($sql_event);
$count_event = $result_event->num_rows;
if($count_event > 0){
   $row_event = $result_event->fetch_assoc();
   $shortcode = $row_event['shortcode'];
   $year = $row_event['year'];
   $event_name = $row_event['event_name'];
   $badge_date = $row_event['badge_date'];
   $logo = $row_event['logo'];
   $website = $row_event['website'];
} else {
	exit;
}
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
	<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
		$(document).ready(function() {        
			$().UItoTop({ easingType: 'easeOutQuart' });        
		});
	</script>
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
    fbq('track', 'Step3');
    
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=398834417477910&ev=PageView&noscript=1"
    /></noscript>
</head>
	<style type="text/css">
		.container_wrap{  border: 1px solid#aa9e5f;}
		.error{color:red;}
	</style>

<body>
<div class="wrapper">

<div class="header">
	<?php include('header1.php'); ?>
</div>
<div class="clear"></div>

<?php

$show = $shortcode;
$year = $year;

$orderId=$_SESSION['orderId'];
$post_date=date('Y-m-d');

if(isset($_POST))
{	/* echo "<pre>";    print_r($_POST); exit; */
	
	if(!isset($_SESSION['registration_id']) && !isset($_SESSION['visitor_id'])){
	$registration_id = $_REQUEST['registration_id'];
	$visitor_id = $_REQUEST['visitor_id'];
	} else {
	$registration_id = $_SESSION['registration_id'];
	$visitor_id = $_SESSION['visitor_id'];
	}
	
	$response = $_POST;
    if(is_array($response)){
        $str = $response['msg'];
    }else if(is_string($response) && strstr($response, 'msg=')){
        $outputStr = str_replace('msg=', '', $response);
        $outputArr = explode('&', $outputStr);
        $str = $outputArr[0];
    } else {
        $str = $response;
    }

    $transactionResponseBean = new TransactionResponseBean();
    $transactionResponseBean->setResponsePayload($str);
    /*$transactionResponseBean->setKey('4681267225TDBCEB');
    $transactionResponseBean->setIv('7944996633RXRYHY'); */
	$transactionResponseBean->key = '4681267225TDBCEB';
	$transactionResponseBean->iv = '7944996633RXRYHY';

    $response = $transactionResponseBean->getResponsePayload();
	//echo "<pre>"; print_r($response); exit;
	$pipeResponse = explode('|',$response);
	//echo "<pre>"; print_r($pipeResponse); exit;
	
	$txnStatus 	= $pipeResponse[0];
	$txnMsg    	= $pipeResponse[1];
	$txnErrMsg  = $pipeResponse[2];
	$clntTxnRef = $pipeResponse[3];
	$tpslTxnId = $pipeResponse[5];
	$tpsl_TrascTime = $pipeResponse[8];
	
	/*$clnt_rqst_meta = $pipeResponse[7];	
	$clnt_data = explode('=',$clnt_rqst_meta); 
	print_r($clnt_data);
	echo '---'.$clnt_getdata   = $clnt_data[1]; 
	exit; */
	
	$txnStatusMsg = explode('=',$txnStatus);
	$txnMsgs 	  = explode('=',$txnMsg);
	$txnErr_Msg   = explode('=',$txnErrMsg);
	$clntTxnRef_Msg   = explode('=',$clntTxnRef);
	$tpslTxnId_Msg   = explode('=',$tpslTxnId);
	$tpsl_TrascTime_Msg   = explode('=',$tpsl_TrascTime);
	
	$txn_status   = $txnStatusMsg[1]; 
	$txn_msg 	  = $txnMsgs[1]; 
	$txn_err_msg  = $txnErr_Msg[1]; //if(failure) txn_err_msg=Cancelled_BY_User 	if(success)txn_err_msg=NA
	$clnt_txn_ref = $clntTxnRef_Msg[1]; //Merchant Reference Number i.e. orderID
	$tpsl_txn_id = $tpslTxnId_Msg[1]; 
	$tpsl_txn_time = $tpsl_TrascTime_Msg[1]; //Merchant Reference Number i.e. orderID
	
	if(isset($txn_status)) 
	{ 
		if($txn_status=='0300'){
			$msgs = 'Y';
			$saveSuccessMsg = "Transactions Success In DB";
		} else if($txn_status=='0392') {	
			$msgs = 'C';
			$saveSuccessMsg = "Cancelled_BY_User";
		} else if($txn_status=='0395') {	
			$msgs = 'C';
			$saveSuccessMsg = "User Aborted";
		} else if($txn_status=='0396') {	
			$msgs = 'P';
			$saveSuccessMsg = "AWAITED";
		} else if($txn_status=='0397') {	
			$msgs = 'C';
			$saveSuccessMsg = "ABORTED";
		} else if($txn_status=='0399') {	
			$msgs = 'C';
			$saveSuccessMsg = "FAILED";
		} else if($txn_status=='0400') {	
			$msgs = 'C';
			$saveSuccessMsg = "Refund Successful in Db";
		} else if($txn_status=='0499') {	
			$msgs = 'C';
			$saveSuccessMsg = "Refund Fail In Db";
		}else if($txn_status=='9999')	{	
			$msgs = 'C';
			$saveSuccessMsg = "Transaction Not Found In Db";
		}
	}
?>
	<div class="container">
		<div class="border w-100"></div>
		<div class="row mt-5">
			<div class="col-12">
             <!-- Add Gateeway Resposnse -->
    <?php 
    if($txn_status=='0300' && $clnt_txn_ref!='' && $orderId !="")
	{ 
		$orderUpdate ="update visitor_order_detail set payment_status='$msgs',txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id',paymentThrough='single' where orderId='$clnt_txn_ref' AND regId='$registration_id'";
		$getResult = $conn->query($orderUpdate);
		if(!$getResult) { die($conn->error); }
		
		$getapplication ="SELECT total_payable FROM `visitor_order_detail` WHERE `regId` = '$registration_id' AND orderId='$clnt_txn_ref' AND payment_status='Y' AND paymentThrough='single'";
		$getApplicationResult = $conn->query($getapplication);
		$getApplicationRow = $getApplicationResult->fetch_assoc();
		$total_payable = $getApplicationRow['total_payable'];
		$total_payable_word = number_word_v($total_payable);
				
		$ssx = "SELECT * FROM `visitor_order_temp` WHERE `registration_id`='$registration_id' AND `show`='$show' AND `year`='$year' AND paymentThrough='single' AND orderId='$clnt_txn_ref'";
		$query_result=$conn->query($ssx);
		while($result1=$query_result->fetch_assoc())
		{ //echo '<pre>'; print_r($result1);
			$visitor_id = $result1['visitor_id'];
			$payment_made_for = $result1['payment_made_for'];		
			$amount = $result1['amount'];
			$show = $result1['show'];
			$year = $result1['year'];
		
		$sqlx1 = "INSERT INTO `visitor_order_history`(`create_date`, `registration_id`, `orderId`,`visitor_id`, `payment_made_for`, `amount`,`show`, `year`,`payment_status`, `status`,`paymentThrough`) VALUES (NOW(),'$registration_id','$clnt_txn_ref','$visitor_id','$payment_made_for','$amount','$show','$year','Y','1','single')";
		$result = $conn->query($sqlx1);
		
		/*Global Table Start */
		
		$name = getVisitorName($visitor_id,$conn);
		$visitorPAN = getVisitorPAN($visitor_id,$conn);
		$visitorMobile = getVisitorMobile($visitor_id,$conn);
		$designation = getVisitorDesignation($visitor_id,$conn);
		$visitorDesignation =  getVisitorDesignationID($designation,$conn); 
		$visitorPhoto =  getVisitorPhoto($visitor_id,$conn); 		 
		$photo_url = "https://registration.gjepc.org/images/employee_directory/".$registration_id."/photo/".$visitorPhoto;
		
		$getCompany_name = trim(getCompanyName($registration_id,$conn));
		$company_name = str_replace('&amp;', '&', $getCompany_name);
        $visitoSecondaryMobile = getVisitorSecondaryMobile($visitor_id,$conn);
		$isSecondary = getVisitorSecondaryMobileStatus($visitor_id,$conn);
		$digits = 9;	
	    $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
	    $checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");
	    $countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
		while($countUniqueIdentifier > 0) {
		$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		} 
						
		$checkGlobalRecord = "SELECT * FROM globalExhibition WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `pan_no`='$visitorPAN' AND participant_Type='VIS' AND `event`='$shortcode' ";
		$globalResult = $conn->query($checkGlobalRecord);
        $checkGlobalCount = $globalResult->num_rows;
	    if($checkGlobalCount>0){
		$updateGlobal = "UPDATE globalExhibition  SET `uniqueIdentifier`='$uniqueIdentifier',`fname`='$name',`mobile`='$visitorMobile',`secondary_mobile`='$visitoSecondaryMobile',`isSecondary`='$isSecondary',`designation`='$visitorDesignation',`company`='$company_name',`photo_url`='$photo_url',`covid_report_status`='pending',`status`='P' WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `pan_no`='$visitorPAN' AND participant_Type='VIS' AND `event`='$shortcode'";
			$updateGlobalResult = $conn->query($updateGlobal);
		} else { 
		$insertGlobal = "INSERT INTO globalExhibition  SET `uniqueIdentifier`='$uniqueIdentifier',`registration_id`='$registration_id',`visitor_id`='$visitor_id',`fname`='$name',`mobile`='$visitorMobile',`secondary_mobile`='$visitoSecondaryMobile',`isSecondary`='$isSecondary',`pan_no`='$visitorPAN',`designation`='$visitorDesignation',`company`='$company_name',`photo_url`='$photo_url',`participant_type`='VIS',`covid_report_status`='pending',`status`='P',`event`='$shortcode'";
			$insertGlobalResult = $conn->query($insertGlobal);
			
			/*Start to check last year vaccination status */		
		$modified_at = date("Y-m-d H:i:s");
		$checkData = "SELECT * FROM visitor_lab_info WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'" ;
		$resultData =$conn->query($checkData);
		$countData =  $resultData->num_rows;
		$rowx = $resultData->fetch_assoc();
		$certificate = $rowx['certificate'];
		
		$dose2_status = $rowx['dose2_status'];
		$booster_dose_status = $rowx['booster_dose_status'];
		if($dose2_status =="Y" ||  $booster_dose_status =="Y"){
		  $approval_status = "Y";
		}else{
		  $approval_status = "N";
		}
		
		$dose2_status = $rowx['dose2_status'];
		$booster_dose_status = $rowx['booster_dose_status'];
		
			if($countData > 0){
			if($certificate =='dose2'){
				$updateCovidStatus = "UPDATE globalExhibition SET `status`='$approval_status',`certificate`='$certificate',`dose2_status`='$dose2_status',`modified_date`='$modified_at' WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `participant_Type`='VIS' AND `event`='$shortcode' ";
				$resultStatusUpdate = $conn->query($updateCovidStatus);
			
			}else if($certificate =='booster_dose'){
				$updateCovidStatus = "UPDATE globalExhibition SET `status`='$approval_status',`certificate`='$certificate',`booster_dose_status`='$booster_dose_status',`modified_date`='$modified_at' WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `participant_Type`='VIS' AND `event`='$shortcode' ";
			}
			
		} else {
			$updateCovidStatus = "UPDATE globalExhibition SET `status`='P',`certificate`='',`dose2_status`='P',`modified_date`='$modified_at' WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `participant_Type`='VIS' AND `event`='$shortcode' ";
		}
		
		}
		/*Global Table End */
		
		if($result){
		$updatx = "DELETE FROM `visitor_order_temp` WHERE `registration_id`='$registration_id' AND `visitor_id` ='$visitor_id' AND `show`='$show' AND `year`='$year' AND paymentThrough='single'";
		$resultx = $conn->query($updatx);
		
		
		$badgeDate = date("d-m-Y",strtotime($badge_date));
	//	$messagev = "Thank you for registration at $event_name. Your Unique ID number is $clnt_txn_ref. Please download GJEPC App to get the E-Badge of the show. Your E Badge will be available Only after approval of vaccination certificate.";
	//	$messagev = "Thank you for registration at $event_name. Your Unique ID number is $clnt_txn_ref. Please download GJEPC App to get the E-Badge of the show. Your E Badge will available Only after approval of vaccination certificate.";
		$messagev = "Thank you for registering for $event_name.Your Unique ID number is $clnt_txn_ref. Generate your E-Badge from GJEPC App from $badgeDate onwards. Please note your E Badge will be only generated after approval of vaccination certificate. 2 dose of vaccines is compulsory to visit the show. Team GJEPC";
		
		if($isSecondary=='Y'){
		//	send_sms($messagev,$visitoSecondaryMobile);
		}else{
		//	send_sms($messagev,$visitorMobile);			
		}		
		
		/*Send Email Receipt to Company */
	$message ='<table class="table2" width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">	
    <tbody>    
    	<tr>
            <td align="left"><img id="ri" src="https://registration.gjepc.org/images/logo.png"></td>
           <!-- <td align="center"> <img id="mi"> </td>
            <td align="right"><img id="ri" src="https://registration.gjepc.org/images/logo/'.$logo.'"></td>-->                       
		</tr>
        <tr>
            <td align="center" colspan="3">
                <p style="line-height:25px;">
                    <h3 style="margin: 5px;">THE GEM JEWELLERY EXPORT PROMOTION COUNCIL</h3>
                    <b>D2B, D-Tower, West Core Wing, Bharat Dimaond Bourse, Bandra Kurla Complex, Bandra (E) - 400 051</b><br>
					<b>Toll Free Number :</b> 1800-103-4353, <b>Missed Call Number :</b> +91-7208048100<br>Website: https://gjepc.org Email: visitors@gjepcindia.com</p>
            </td>
        </tr>              
        <tr><td colspan="3" height="30"><hr></td></tr>        
        <tr>           
        	<td colspan="3" id="content">
            	<table class="table1"width="100%" style="font-family:Arial, sans-serif; color:#333333; font-size:13px;">
                <tr>
                <td style="padding:0 10px;" align="left">Order ID: '.$clnt_txn_ref.' </td>
                <td style="padding:0 60px;" align="right">Date: '.date("d-m-y").'</td>
                </tr>                    
                </table>

                <table class="table2"width="100%" style="font-family:Arial, sans-serif; color:#333333; font-size:13px;" cellpadding="10">
                <tr>
                    <td width="20%">Received with Thanks From M/s: </td>
                    <td width="75%">'.$CompanyName.'</td>
                </tr>
                <tr>
                    <td width="20%">Rupees: </td>
                    <td width="75%">'.$total_payable.' ('.$total_payable_word.')</td>
                </tr>
				<tr>
                    <td width="20%">Events: </td>
                    <td width="75%">'.$event_name.'</td>
                </tr>
				<tr>
                 <td width="100%" colspan="2">
                    <p style="text-align: left; width: 100%; padding-top: 10px; margin: 0;">
                 <strong>We thank you for your visitor registration for '.$event_name.'. All the visitors visiting the exhibition should be fully vaccinated. 
					<br/>For further assistance you may please feel free to contact us on 1800-103-4353 / OR give us missed call on +91-7208048100; or write to us on visitors@gjepcindia.com.</strong></p>				
                </td>
				</tr>
                <tr>
                <td width="100%" colspan="2">
                    <h4 style="text-align: center; width: 100%; padding-top: 30px; margin: 0;">This is a computer generated receipt requires no signature. Invoice as per GST Format would be dispatched separately.</h4>
                </td>
			</tr>
            </table>
		</td>            
        </tr>   
           <style type="text/css">
           .table2 input{width: 80%;border-left: none; border-right: none; border-top: none; border-bottom: 1px solid #000;}
               .table1 input{border-left: none; border-right: none; border-top: none; border-bottom: 1px solid #000; width: 150px;}
           }          
            .table2 h4{text-align: center;}
           </style>
	</tbody>
	</table>';	
		
		//$to =$data['email']; 
		//$to = 'neelmani@kwebmaker.com';
		$to = $email;
		$subject = "Thank you for registering at ".$event_name.""; 
		$cc = "";
		$email_array = explode(",",$to);
		send_mailArray($email_array,$subject,$message,$cc);
		/*
		$headers  = 'MIME-Version: 1.0' . "\n"; 
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		$headers .= 'From: '.$event_name.' SHOW <admin@gjepc.org>';			
		mail($to, $subject, $message, $headers);
		*/
		
		/*  Email End */		
		}	
		}		
	
	//	header("Refresh: 2; url=https://registration.gjepc.org/visitor_registration.php");
		?>
		<div class="container_wrap">
		<div class="container" id="manualFormContainer">
		<h1 style="color:green;">PAYMENT SUCCESSFUL</h1>
		<div id="">
		<p>Your transaction is successfully Completed. Thank you for your Visitor Registration in <?php echo $event_name;?></p>
		<p>Your Transaction ID : <?php echo $tpsl_txn_id;?></p>
		</div>
		<div class="clear"></div>
		</div>
		</div>
		<?php
	} else if($txn_status=='0392') {
			echo $saveSuccessMsg = "Cancelled_BY_User";
			 $orderUpdate ="update visitor_order_detail set txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where orderId='$clnt_txn_ref' AND regId='$registration_id' AND paymentThrough='single'";
			$getResult = $conn->query($orderUpdate);
			header("Refresh: 10; url=https://registration.gjepc.org/single_visitor.php");
		} else if($txn_status=='0395') {			
			echo $saveSuccessMsg = "User Aborted";
			$orderUpdate ="update visitor_order_detail set txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where orderId='$clnt_txn_ref' AND regId='$registration_id' AND paymentThrough='single'";
			$getResult = $conn->query($orderUpdate);
			header("Refresh: 10; url=https://registration.gjepc.org/single_visitor.php");
		} else if($txn_status=='0396') {			
			echo $saveSuccessMsg = "AWAITED";
			$orderUpdate ="update visitor_order_detail set txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where orderId='$clnt_txn_ref' AND regId='$registration_id' AND paymentThrough='single'";
			$getResult = $conn->query($orderUpdate);
		} else if($txn_status=='0397') {			
			echo $saveSuccessMsg = "ABORTED";
			$orderUpdate ="update visitor_order_detail set txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where orderId='$clnt_txn_ref' AND regId='$registration_id' AND paymentThrough='single'";
			$getResult = $conn->query($orderUpdate);
			header("Refresh: 10; url=https://registration.gjepc.org/single_visitor.php");
		} else if($txn_status=='0399') {			
			echo $saveSuccessMsg = "FAILED";
			$orderUpdate ="update visitor_order_detail set txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where orderId='$clnt_txn_ref' AND regId='$registration_id' AND paymentThrough='single'";
			$getResult = $conn->query($orderUpdate);
			header("Refresh: 10; url=https://registration.gjepc.org/single_visitor.php");
		} else if($txn_status=='0400') {			
			echo $saveSuccessMsg = "<p class='text-center font-weight-bold text-danger'>Refund Successful in Db </p>";
		} else if($txn_status=='0499') {			
			echo $saveSuccessMsg = "<p class='text-center font-weight-bold text-danger'>Refund Fail In Db</p>";
		} else if($txn_status=='9999') {			
			echo $saveSuccessMsg = "<p class='text-center font-weight-bold text-danger'>Transaction Not Found In Db</p>";
		} else	{
			echo "<p class='text-center text-danger font-weight-bold'>Security Error. Illegal access detected</p>";		
		}
		//header("Refresh: 30; url=http://registration.gjepc.org/single_visitor.php");
		unset($_SESSION['clnt_txn_ref']);		
		unset($_SESSION['orderId']);		
} ?>

			</div>
	        <?php
			if($txn_status=='0300' && $clnt_txn_ref!='' && $orderId !="")
			{
			include("include_vaccine_upload.php"); 
			}
			?>

	</div>
	</div>
	</div>		
	<div class="clear"></div>
	</div>
<div class="clear"></div>
<?php include ('footer.php'); ?>
</div>
<!--footer ends-->
</body>
</html>