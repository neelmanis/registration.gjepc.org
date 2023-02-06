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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Payment Success</title>
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
$show = "signature2";
$year = 2021;
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
    if($txn_status=='0300' && $clnt_txn_ref!='')
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
        $company_first_letter = $company_name[0];
        if(!is_numeric($company_first_letter)){
        $alphabet = strtoupper($company_first_letter);
        } else {
        $alphabet = "NA";
        }
        $slot_query = "SELECT * FROM visitor_slot_master  where alphabets like '%$alphabet%' AND status = '1'";
        $result_slot = $conn->query($slot_query);
        $count_slot = $result_slot->num_rows;
        if($count_slot>0){
        $row_slot = $result_slot->fetch_assoc();
        }else{
        $row_slot = array("dates"=>"");
        }
        $slots_array = explode(",",$row_slot['dates']);
        //echo date("d F Y",strtotime(getEventSlotDate($slots_array[0],$conn)))." & ". date("d F Y",strtotime(getEventSlotDate($slots_array[1],$conn)));
		$days_allow = date("d",strtotime(getEventSlotDate($slots_array[0],$conn))).",". date("d",strtotime(getEventSlotDate($slots_array[1],$conn)));
		
		$digits = 9;	
	    $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
	    $checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");
	    $countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
		while($countUniqueIdentifier > 0) {
		$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		} 
						
		$checkGlobalRecord = "SELECT * FROM globalExhibition WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `pan_no`='$visitorPAN' AND participant_Type='VIS'";
		$globalResult = $conn->query($checkGlobalRecord);
        $checkGlobalCount = $globalResult->num_rows;
	    if($checkGlobalCount>0){
			
		} else { 
		$insertGlobal = "INSERT INTO globalExhibition  SET `uniqueIdentifier`='$uniqueIdentifier',`registration_id`='$registration_id',`visitor_id`='$visitor_id',`fname`='$name',`mobile`='$visitorMobile',`pan_no`='$visitorPAN',`designation`='$visitorDesignation',`company`='$company_name',`photo_url`='$photo_url',`participant_type`='VIS',`covid_report_status`='pending',`days_allow`='$days_allow',`status`='P'";
			$insertGlobalResult = $conn->query($insertGlobal);
		}
		/*Global Table End */
		
		if($result){
		$updatx = "DELETE FROM `visitor_order_temp` WHERE `registration_id`='$registration_id' AND `visitor_id` ='$visitor_id' AND `show`='$show' AND `year`='$year' AND paymentThrough='single'";
		$resultx = $conn->query($updatx);
			
		$message = "Thank you for registration at IIJS SIGNATURE 2021. Your ORDER ID for Visitor registration is $clnt_txn_ref. Your badge will be couriered shortly.";
	//	get_data($message,$ownerMobile); 

	//	$messagev = "Thank you for registration at IIJS SIGNATURE 2021. Your Registration Number is $visitor_id for ORDER ID $orderId. Your badge will be dispatched shortly.";
		$messagev = "Thank you for registration at IIJS SIGNATURE 2021. Your Unique ID number is $clnt_txn_ref. Please make sure to do your RT PCR Covid-19 test 72 hours before the show visit. Please download GJEPC App to get the E-Badge of the show. Your E Badge will get activated Only after successful submission of negative report.";
		get_data($messagev,$visitorMobile); 			
		
		/*Send Email Receipt to Company */
	$message ='<table class="table2" width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">	
    <tbody>    
    	<tr>
            <td align="left"><img id="ri" src="https://gjepc.org/iijs-signature/assets/images/gjepc_logo.png">
            <td align="center"> <img id="mi"> </td>
            <td align="right"><img id="ri" src="https://gjepc.org/emailer_gjepc/06.03.2021/iijs.jpg"></td>
            </td>                        
		</tr>
        <tr>
            <td align="center" colspan="3">
                <p style="line-height:25px;">
                    <h3 style="margin: 5px;">THE GEM JEWELLERY EXPORT PROMOTION COUNCIL</h3>
                    <b>GJEPC-H.O.-MUMBAI:1st Flr, Tower A,G Block, BDB, Bandra-Kurla Complex, Bandra(E)-400 051</b><br>
                    <b>GJEPC-E.X.-MUMBAI:G2-A, Trade Center, Bandra-Kurla Complex, Bandra(E)-400 051</b><br>
					<b>Toll Free Number :</b> 1800-103-4353, <b>Missed Call Number :</b> +91-7208048100<br>Website: https://gjepc.org/iijs-signature/ Email: visitors@gjepcindia.com</p>
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
                    <td width="75%">IIJS-SIGNATURE 2021</td>
                </tr>
				<tr>
                    <td width="20%"></td>
                    <td width="75%"><strong>Please Make sure to do your RT PCR Covid-19 test 72 Hours before the show visit</strong></td>
                </tr>
				<tr>
                 <td width="100%" colspan="2">
                    <p style="text-align: left; width: 100%; padding-top: 10px; margin: 0;">
                    We thank you for your visitor registration for IIJS Signature 2021.  
					Please download GJEPC app to get the E-Badge of the show. Your E Badge will get activated Only after successful submission of Negative report of RT-PCR Covid-19 test. 
					For further assistance you may please feel free to contact us on 1800-103-4353 / OR give us missed call on +91-7208048100; or write to us on visitors@gjepcindia.com.</p>
				
                </td>
				</tr>
                <tr>
                <td width="100%" colspan="2">
                    <h4 style="text-align: center; width: 100%; padding-top: 30px; margin: 0;">This is a computer generated receipt requires no signature. Invoice as per GST Format would be dispatched seperately.</h4>
                </td>
				</tr>

				 <tr>
                <td width="100%" colspan="2">
                    <p>
            <strong>Disclaimer:</strong> <span style="font-size: 10px">This information contained in this circular are provided for the purpose of making application for the participation and visiting IIJS Signature 2021 (the show). Please note that the Council reserves all the rights to postpone or cancel the show completely or partially without any prior intimation, subject to the changes in the Govt. rules and regulations and any such changes thereof for organising the show. In case of any delay or failure to organise the show which is caused by matters beyond reasonable control of the Council including, but not limited to the force majeure events, the Council shall not accept any responsibility or indemnity, whatsoever, and under no circumstance shall the Council have any liability to participants and visitors for any loss or damage of any kind incurred as a result of the postponement or cancellation of the show.</span> 
           </p>
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
		$to =$email.',visitors@gjepcindia.com';
		$subject = "Thank you for registering at IIJS SIGNATURE 2021 Show"; 
		$headers  = 'MIME-Version: 1.0' . "\n"; 
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		$headers .= 'From: IIJS SIGNATURE 2021 <admin@gjepc.org>';			
		mail($to, $subject, $message, $headers);
		/*  Email End */		
		}	
		}		
	
	//	header("Refresh: 2; url=https://registration.gjepc.org/visitor_registration.php");
		?>
		<div class="container_wrap">
		<div class="container" id="manualFormContainer">
		<h1 style="color:green;">PAYMENT SUCCESSFUL</h1>
		<div id="formWrapper">
		<p>Your transaction is successfully Completed. Thank you for your Visitor Registration in IIJS SIGNATURE 2021.</p>
		<p>Your Transaction ID : <?php echo $tpsl_txn_id;?></p>
		</div>
		<div class="clear"></div>
		</div>
		</div>
		<?php
	} else if($txn_status=='0392') {
			echo $saveSuccessMsg = "Cancelled_BY_User";
			$orderUpdate ="update visitor_order_detail set txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where clnt_txn_ref='$clnt_txn_ref' AND regId='$registration_id' AND paymentThrough='single'";
			$getResult = $conn->query($orderUpdate);
		} else if($txn_status=='0395') {			
			echo $saveSuccessMsg = "User Aborted";
			$orderUpdate ="update visitor_order_detail set txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where clnt_txn_ref='$clnt_txn_ref' AND regId='$registration_id' AND paymentThrough='single'";
			$getResult = $conn->query($orderUpdate);
		} else if($txn_status=='0396') {			
			echo $saveSuccessMsg = "AWAITED";
			$orderUpdate ="update visitor_order_detail set txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where clnt_txn_ref='$clnt_txn_ref' AND regId='$registration_id' AND paymentThrough='single'";
			$getResult = $conn->query($orderUpdate);
		} else if($txn_status=='0397') {			
			echo $saveSuccessMsg = "ABORTED";
			$orderUpdate ="update visitor_order_detail set txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where clnt_txn_ref='$clnt_txn_ref' AND regId='$registration_id' AND paymentThrough='single'";
			$getResult = $conn->query($orderUpdate);
		} else if($txn_status=='0399') {			
			echo $saveSuccessMsg = "FAILED";
			$orderUpdate ="update visitor_order_detail set txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where clnt_txn_ref='$clnt_txn_ref' AND regId='$registration_id' AND paymentThrough='single'";
			$getResult = $conn->query($orderUpdate);
		} else if($txn_status=='0400') {			
			echo $saveSuccessMsg = "<p class='text-center font-weight-bold text-danger'>Refund Successful in Db </p>";
		} else if($txn_status=='0499') {			
			echo $saveSuccessMsg = "<p class='text-center font-weight-bold text-danger'>Refund Fail In Db</p>";
		} else if($txn_status=='9999') {			
			echo $saveSuccessMsg = "<p class='text-center font-weight-bold text-danger'>Transaction Not Found In Db</p>";
		} else	{
			echo "<p class='text-center text-danger font-weight-bold'>Security Error. Illegal access detected</p>";		
		}
		header("Refresh: 30; url=http://registration.gjepc.org/single_visitor.php");
		unset($_SESSION['clnt_txn_ref']);		
} ?>

			</div>
			<div class="border w-100"></div>
			<div class="col-12 mt-3">
				
				<p class="text-center font-weight-bold">RT-PCR Test report (Covid-19 test)</p>
	            <p class="text-center font-weight-bold">It is mandatory to submit RT-PCR test report 72 hours before visit date</p>
				<div class="container_wrap">
				
		<div class="container" id="manualFormContainer">		
		<div id="formWrapper" class="py-5">
		
		<form method="POST" name="regisForm" id="regisForm">
		<input type="hidden" name="action" value="saveCovidDetails"/>	
		<input type="hidden" name="registration_id" value="<?php echo $registration_id;?>"/>	
		<input type="hidden" name="visitor_id" value="<?php echo $visitor_id;?>"/>	
		<input type="hidden" name="pan_no" value="<?php echo $visitorPAN;?>"/>	
		<input type="hidden" name="mobile_no" value="<?php echo $visitorMobile;?>"/>	
		<div class="row">
			<div class="col-12">
				<label class="d-inline-block mr-5">
					<input type="radio" id="self" name="valueType" value="self"/>&nbsp;&nbsp;Self Upload
				</label>
				<label>
					<input type="radio" id="lab" name="valueType" value="lab"/>&nbsp;&nbsp;Upload Via Lab
				</label>
			</div>
			<div class="col-12">
				<label for="valueType" generated="true" class="error d-none">Select any one of the above</label>
			</div>
		
			<div class="col-12 mb-2" id="specific-company" style="display: none">
				<p class="font-weight-bold">I will upload RT-PCR test report myself</p>
			</div>
			
			<div class="col-12 mb-2" id="company-wise" style="display: none">				  
				<div class="row">
							<div class="col-12">
								<p class="font-weight-bold">I would like to do RT-PCR testing via SRL Labs  <a data-fancybox data-src="#modals" href="javascript:;" id="Offers" class="cta">Click here to View Offers</a></p>
							</div>
							<div class="form-group col-sm-6">
								<label class="form-label" for="location"><p>Lab: </p></label>
								<select name="labs" id="labs" class="form-control" style="width:100%">
									<!--<option value="">--- Please Select One ---</option>-->
									<option value="srl" <?php if($lab=="lab") echo "selected"; ?>>SRL Diagnostics</option>
								</select>
							</div>
							
							<div class="form-group col-sm-6">
									<label class="form-label" for="location"><p>Lab Location </p></label>
									<select name="location" id="location" class="form-control" style="width:100%">
										<option value="">--- Please Select Lab Location ---</option>
										<?php
										$city= "SELECT * FROM `cities` order by city_name asc";
										$cityquery = $conn->query($city);
										while($row1 = $cityquery->fetch_assoc()){?>
										<option value="<?php echo $row1['city_name'];?>"><?php echo strtoupper($row1['city_name']);?></option>
										<?php }	?>
									</select>		
							</div>						
				</div>
			</div>
			<div class="col-12">
            <input type="checkbox" name="agree" value="YES"> I declare that my covid report can be share with GJEPC
            <label for="agree" generated="true" style="display: none;" class="error"></label>
			</div>
			<div class="col-12">
				<input type="submit" name="submit" id="submit" value="Submit" class="cta">
			</div>
		</div>		
		</form>
		 <div id="chkPendingPANStatus" ></div>
		</div>
		
		<div class="clear"></div>
		</div>
	</div>
	</div>
	</div>
	</div>		
	<div class="clear"></div>
	</div>
<div class="clear"></div>
   <div style="display: none;" id="modals">
            <h1 align="center" class="mb-2 blue" >Offers</h1>
           <table class="table_responsive"><thead><tr class="tableizer-firstrow"><th>City</th><th>Walk-in ( Yes/No ) if Yes pls give the address</th><th>Home Collection ( Yes/No)</th><th>Offered Price</th></tr></thead><tbody><tr><td>Agra </td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Aligarh</td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Amritsar</td><td>YES</td><td>YES</td><td>700</td></tr><tr><td>BANGALORE</td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Bareilly</td><td>YES</td><td>YES</td><td>800</td></tr><tr><td>Chandigarh</td><td>NO</td><td>YES</td><td>900</td></tr><tr><td>CHENNAI</td><td>YES</td><td>YES</td><td>1200</td></tr><tr><td>Dehradun</td><td>NO</td><td>YES</td><td>500</td></tr><tr><td>Delhi</td><td>YES</td><td>NO</td><td>1000</td></tr><tr><td>Deoghar</td><td>NO</td><td>YES</td><td>600</td></tr><tr><td>Dibrugarh</td><td>YES</td><td>YES</td><td>1000</td></tr><tr><td>Gorakhpur</td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Goa</td><td>YES</td><td>YES</td><td>900</td></tr><tr><td>Gurgaon</td><td>YES</td><td>NO</td><td>699</td></tr><tr><td>Guwahati</td><td>YES</td><td>YES</td><td>1000</td></tr><tr><td>GWALIOR</td><td>NO</td><td>YES</td><td>900</td></tr><tr><td>HALDWANI</td><td>YES</td><td>YES</td><td>500</td></tr><tr><td>Hyderabad</td><td>YES</td><td>YES</td><td>600</td></tr><tr><td>Imphal</td><td>YES</td><td>YES</td><td>1200</td></tr><tr><td>Indore</td><td>YES</td><td>YES</td><td>900</td></tr><tr><td>Jabalpur</td><td>NO</td><td>YES</td><td>900</td></tr><tr><td>Jalandhar</td><td>YES</td><td>YES</td><td>900</td></tr><tr><td>Jammu</td><td>YES</td><td>YES</td><td>1400</td></tr><tr><td>Kolhapur</td><td>YES</td><td>YES</td><td>850</td></tr><tr><td>Kolkata</td><td>YES</td><td>YES</td><td>950</td></tr><tr><td>Lucknow</td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Ludhiana</td><td>YES</td><td>YES</td><td>900</td></tr><tr><td>Meerut</td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Moradabad</td><td>YES</td><td>YES</td><td>800</td></tr><tr><td>Mumbai</td><td>YES</td><td>NO</td><td>800</td></tr><tr><td>Muzzafarnagar</td><td>YES</td><td>YES</td><td>800</td></tr><tr><td>Nagpur</td><td>YES</td><td>YES</td><td>850</td></tr><tr><td>Navi Mumbai</td><td>YES</td><td>NO</td><td>850</td></tr><tr><td>Prayagraj</td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Pune</td><td>YES</td><td>YES</td><td>850</td></tr><tr><td>Raipur</td><td>YES</td><td>YES</td><td>800</td></tr><tr><td>Rishikesh</td><td>NO</td><td>YES</td><td>500</td></tr><tr><td>Silchar</td><td>YES</td><td>YES</td><td>1000</td></tr><tr><td>Ujjain</td><td>NO</td><td>YES</td><td>900</td></tr><tr><td>Varanasi</td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Vizag</td><td>NO</td><td>YES</td><td>499</td></tr></tbody></table>
         
                  
              </div>
<?php include ('footer.php'); ?>

<script type="text/javascript">
			$('input[name="valueType"]').click(function(){
		    var valueType = $('[name="valueType"]:checked').val();
			//alert(valueType);
		    if(valueType =="self"){
		    	$("#specific-company").slideDown();
				$("#company-wise").slideUp();
				$("#labs").attr("disabled", "disabled"); 
				$("#location").attr("disabled", "disabled"); 
				} else { 
				$("#company-wise").slideDown();
		    	$("#specific-company").slideUp();	
				$("#labs").removeAttr("disabled");  
				$("#location").removeAttr("disabled"); 
				}
 });     
</script>

<script type="text/javascript">
$(document).ready(function()
{   
	$("#regisForm").validate({
    rules: {
		valueType:{
		required:true,
		},
		labs:{
		required:true,
		},
		location:{
		required:true,
		},
		agree:{
		required:true,
		}
    },
    messages: {
		valueType:{
		required: "Select any one of the above",
		},
		labs:{
		required: "Lab Name required",
		},
		location:{
		required: "Location required",
		},
		agree:{
		required: "Required",
		}
	},
	submitHandler: covidAction	
    });     
    });	

			
	function covidAction(){
		jQuery('#submit').val('please wait...');
		jQuery('#submit').attr('disabled',true);
    var formdata = $('#regisForm').serialize();
	// alert(formdata);return false;
   
    $.ajax({
    type:'POST',
    data:formdata,
    url:"actionAjax.php",
    dataType: "json",
    
    beforeSend: function(){
    $('.loaderWrapper').show();
    },
    success:function(data){
    //    alert(data);
    if(data.status == 'success'){
	//jQuery("#chkPendingPANStatus").html("Your Application is Submitted successfully");	
	alert("Your Application is Submitted successfully");   
    window.location = "single_visitor.php";
	jQuery('#submit').val('Submit');		
	jQuery('#submit').attr('disabled',false);		
    $('#regisForm').hide();
    
    } else if(data.status =='error'){
    alert("Your Application is Submitted successfully");   
    window.location = "single_visitor.php";
	jQuery('#submit').val('Submit');		
	jQuery('#submit').attr('disabled',false);		
    $('#regisForm').hide();	
    }
    }
    });
    }
</script>
</div>
<!--footer ends-->
</body>
</html>