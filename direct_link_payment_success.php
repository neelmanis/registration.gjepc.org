<?php include('header_include.php');
 // if(!isset($_SESSION['registration_id'])){ header("location:login.php");	exit; }
if(!isset($_SESSION['registration_id']) && !isset($_SESSION['visitor_id'])){
$registration_id = $_REQUEST['registration_id'];
$visitor_id = $_REQUEST['visitor_id'];
} else {
$registration_id = $_SESSION['registration_id'];
$visitor_id = $_SESSION['visitor_id'];
}

$email = getVisitorEmail($visitor_id,$conn); 
$CompanyName = getCompanyName($registration_id,$conn);
$visitorName = getVisitorName($visitor_id,$conn);  
$ownerMobile = getVisitorMobile($visitor_id,$conn);
$visitorMobile = getVisitorMobile($visitor_id,$conn);
$visitoSecondaryMobile = getVisitorSecondaryMobile($visitor_id,$conn);	
$visitorPAN = getVisitorPAN($visitor_id,$conn);

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
	<link rel="stylesheet" type="text/css" href="css/mystyle.css?v=<?php echo $version;?>" />
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
	<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
	 
	<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>
	<script type="text/javascript" src="js/jquery.fancybox.min.js?v=<?php echo $version;?>"></script>

	<!--NAV-->
	<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="js/jquery.flexnav.js?v=<?php echo $version;?>" type="text/javascript"></script>
	<script src="js/common.js?v=<?php echo $version;?>"></script> 
	<!--NAV-->
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
	<!-- UItoTop plugin -->
	<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css?v=<?php echo $version;?>" />
	<script src="js/easing.js?v=<?php echo $version;?>" type="text/javascript"></script>
	<script src="js/jquery.ui.totop.js?v=<?php echo $version;?>" type="text/javascript"></script>    
	<script type="text/javascript">
		$(document).ready(function() {        
			$().UItoTop({ easingType: 'easeOutQuart' });        
		});
	</script>
	<style type="text/css">
		.container_wrap{  border: 1px solid#aa9e5f;}
		.error{color:red;}
	</style>
</head>

<body>
<div class="wrapper">

<div class="header">
	<?php include('header1.php'); ?>
</div>
<div class="clear"></div>


<?php
$show ="signature2";
$year = 2021;
$orderId=$_SESSION['orderId'];
$post_date=date('Y-m-d');

if(isset($_POST))
{
	// echo '<pre>'; print_r($_POST); exit;
	
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
    }else {
        $str = $response;
    }

    $transactionResponseBean = new TransactionResponseBean();
    $transactionResponseBean->setResponsePayload($str);
    /*$transactionResponseBean->setKey('4681267225TDBCEB');
    $transactionResponseBean->setIv('7944996633RXRYHY'); */
	$transactionResponseBean->key = '4681267225TDBCEB';
	$transactionResponseBean->iv = '7944996633RXRYHY';

    $response = $transactionResponseBean->getResponsePayload();
   /* echo "<pre>";
    print_r($response);
    echo "<br><br><br><br>"; 
	exit; */
	$pipeResponse = explode('|',$response);
	//echo "<pre>"; print_r($pipeResponse); exit;
	
	$txnStatus 	= $pipeResponse[0];
	$txnMsg    	= $pipeResponse[1];
	$txnErrMsg  = $pipeResponse[2];
	$clntTxnRef = $pipeResponse[3];
	$tpslTxnId = $pipeResponse[5];
	$tpsl_TrascTime = $pipeResponse[8];
	
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
            
             <?php 
             	if($txn_status=='0300' && $clnt_txn_ref!=''){
					$orderUpdate ="update visitor_order_detail set payment_status='$msgs',txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id',paymentThrough='link' where orderId='$clnt_txn_ref' AND regId='$registration_id'";
					$getResult = $conn->query($orderUpdate);
					if(!$getResult) { die($conn->error); }
					
					$getapplication ="SELECT total_payable FROM `visitor_order_detail` WHERE `regId` = '$registration_id' AND orderId='$clnt_txn_ref' AND payment_status='Y' AND paymentThrough='link'";
					$getApplicationResult = $conn->query($getapplication);
					$getApplicationRow = $getApplicationResult->fetch_assoc();
					$total_payable = $getApplicationRow['total_payable'];
					$total_payable_word = number_word_v($total_payable);
							
					$ssx = "SELECT * FROM `visitor_order_temp` WHERE `registration_id`='$registration_id' AND `show`='$show' AND `year`='$year' AND paymentThrough='link' AND orderId='$clnt_txn_ref'";
					$query_result=$conn->query($ssx);
					while($result1=$query_result->fetch_assoc())
					{ //echo '<pre>'; print_r($result1);
						$visitor_id = $result1['visitor_id'];
						$payment_made_for = $result1['payment_made_for'];		
						$amount = $result1['amount'];
						$show = $result1['show'];
						$year = $result1['year'];
					
					$sqlx1 = "INSERT INTO `visitor_order_history`(`create_date`, `registration_id`, `orderId`,`visitor_id`, `payment_made_for`, `amount`,`show`, `year`,`payment_status`, `status`,`paymentThrough`) VALUES (NOW(),'$registration_id','$clnt_txn_ref','$visitor_id','$payment_made_for','$amount','$show','$year','Y','1','link')";
					$result = $conn->query($sqlx1);
					if($result){
					$updatx = "DELETE FROM `visitor_order_temp` WHERE `registration_id`='$registration_id' AND `visitor_id` ='$visitor_id' AND `show`='$show' AND `year`='$year' AND paymentThrough='link'";
					$resultx = $conn->query($updatx);
						
					$messagev = "Thank you for registration at IIJS SIGNATURE 2021. Your Unique ID number is $clnt_txn_ref. Please make sure to do your RT PCR Covid-19 test 72 hours before the show visit. Please download GJEPC App to get the E-Badge of the show. Your E Badge will get activated Only after successful submission of negative report.";
		           // get_data($messagev,$visitorMobile);
					
					/*Send Email Receipt to Company */
				$message ='<table class="table2" width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">	
    <tbody>    
    	<tr>
            <td align="left"><img id="ri" src="https://gjepc.org/iijs-signature/assets/images/gjepc_logo.png">
            <td align="center"> <img id="mi"> </td>
            <td align="right"><img id="ri" src="https://gjepc.org/iijs-signature/assets/images/logo.png"></td>
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
                    <p style="text-align: left; width: 100%; padding-top: 10px; margin: 0;">We thank you for your visitor registration to view 800+ plus gems and Jewellery manufacturers and wholesalers of India under one roof.</p>
					<p style="text-align: left; width: 100%; padding-top: 10px; margin: 0;">Your presence is important to us, we would like to inform you that Please make sure to do your RT PCR Covid-19 test 72 hours before the show visit.</p>
					<p style="text-align: left; width: 100%; padding-top: 10px; margin: 0;">Please download GJEPC app to get the E-Badge of the show. Your E Badge will get activated Only after successful submission of negative report. </p>
					<p style="text-align: left; width: 100%; padding-top: 10px; margin: 0;">For further assistance you may please feel free to contact us on 1800-103-4353 / OR give us missed call on +91–7208048100; or write to us on visitors@gjepcindia.com.</p>
                </td>
				</tr>
                <tr>
                <td width="100%" colspan="2">
                    <h4 style="text-align: center; width: 100%; padding-top: 30px; margin: 0;">This is a computer generated receipt requires no signature. Invoice as per GST Format would be dispatched seperately.</h4>
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
					//mail($to, $subject, $message, $headers);
					/*  Email End */		
					}	
					}		
				
					//header("Refresh: 2; url=https://registration.gjepc.org/visitor_registration.php");
					?>
					
					<h3 class="text-center font-weight-bold text-success">Payment Successful </h3>
					<p class="mt-3 text-center">Thank you for registering to visit IIJS SIGNATURE 2021 Show.</p>
					<p class=" text-center">To Confirm  your visit, upload your covid report, 72 hours before event's date of visit.</p>
					<p  class=" text-center">Your Transaction ID : <?php echo $tpsl_txn_id;?></p>
				
					<?php
				} else if($txn_status=='0392') {
						echo $saveSuccessMsg = "Cancelled_BY_User";
						$orderUpdate ="update visitor_order_detail set txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where orderId='$clnt_txn_ref' AND regId='$registration_id' AND paymentThrough='link'";
						$getResult = $conn->query($orderUpdate);
					} else if($txn_status=='0395') {			
						echo $saveSuccessMsg = "<p class='text-danger text-center'>User Aborted</p>";
						$orderUpdate ="update visitor_order_detail set txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where orderId='$clnt_txn_ref' AND regId='$registration_id' AND paymentThrough='link'";
						$getResult = $conn->query($orderUpdate);
					} else if($txn_status=='0396') {			
						echo $saveSuccessMsg = "<p class='text-danger text-center'>AWAITED</p>";
						$orderUpdate ="update visitor_order_detail set txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where orderId='$clnt_txn_ref' AND regId='$registration_id' AND paymentThrough='link'";
						$getResult = $conn->query($orderUpdate);
					} else if($txn_status=='0397') {			
						echo $saveSuccessMsg = "<p class='text-danger text-center'>ABORTED</p>";
						$orderUpdate ="update visitor_order_detail set txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where orderId='$clnt_txn_ref' AND regId='$registration_id' AND paymentThrough='link'";
						$getResult = $conn->query($orderUpdate);
					} else if($txn_status=='0399') {			
						echo $saveSuccessMsg = "<p class='text-danger text-center'>FAILED</p>";
						$orderUpdate ="update visitor_order_detail set txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where orderId='$clnt_txn_ref' AND regId='$registration_id' AND paymentThrough='link'";
						$getResult = $conn->query($orderUpdate);
					} else if($txn_status=='0400') {			
						echo $saveSuccessMsg = "<p class='text-danger text-center'> Refund Successful in Db</p>";
					} else if($txn_status=='0499') {			
						echo $saveSuccessMsg = "<p class='text-danger text-center'>Refund Fail In Db</p>";
					} else if($txn_status=='9999') {			
						echo $saveSuccessMsg = "<p class='text-danger text-center'>Transaction Not Found In Db</p>";
					} else	{
						echo "<p class='text-danger text-center'>Security Error. Illegal access detected</p>";		
					}
					//("Refresh: 2; url=http://registration.gjepc.org/order_history.php");
					unset($_SESSION['clnt_txn_ref']);		
} ?>

			</div>
			<div class="border w-100"></div>
			<div class="col-12 mt-3">
				
				<p class="text-center font-weight-bold">RT-PCR Test report (Covid-19 test)</p>
	            <p class="text-center font-weight-bold">It is mandatory to submit RT-PCR test report 72 hours before visit date</p>
				<div class="container_wrap">
		<div class="container" id="manualFormContainer">
		
		<div id="formWrapper" class="py-5 ">

		
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
									<p class="font-weight-bold">I would like to do RT-PCR testing via SRL Labs  <a data-fancybox data-src="#modals" href="javascript:;" id="Offers" class="cta">Click here to view Offers</a></p>
								</div>
								<div class="form-group col-sm-6">
									<label class="form-label" for="location"><p>Select Lab: </p></label>
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
</div>

<div class="clear"></div>
<div style="display: none;" id="modals">
            <h1 align="center" class="mb-2 blue" >Offers</h1>
           <table class="table_responsive">
<thead><tr class="tableizer-firstrow"><th>City</th><th>Walk-in ( Yes/No ) if Yes pls give the address</th><th>Home Collection ( Yes/No)</th><th>Cap Price</th><th>Offered Price</th></tr></thead><tbody>
 <tr><td>Agra  </td><td>NO</td><td>YES</td><td>900</td><td>800</td></tr>
 <tr><td>Aligarh</td><td>NO</td><td>YES</td><td>900</td><td>800</td></tr>
 <tr><td>Amritsar</td><td>YES</td><td>YES</td><td>700</td><td>700</td></tr>
 <tr><td>BANGALORE</td><td>NO</td><td>YES</td><td>1200</td><td>800</td></tr>
 <tr><td>Bareilly</td><td>YES</td><td>YES</td><td>900</td><td>800</td></tr>
 <tr><td>Chandigarh</td><td>NO</td><td>YES</td><td>900</td><td>900</td></tr>
 <tr><td>CHENNAI</td><td>YES</td><td>YES</td><td>1500</td><td>1200</td></tr>
 <tr><td>Dehradun </td><td>NO</td><td>YES</td><td>500</td><td>500</td></tr>
 <tr><td>Delhi</td><td>YES</td><td>NO</td><td>1200</td><td>1000</td></tr>
 <tr><td>Deoghar</td><td>NO</td><td>YES</td><td>600</td><td>600</td></tr>
 <tr><td>Dibrugarh</td><td>YES</td><td>YES</td><td>1000</td><td>1000</td></tr>
 <tr><td>Gorakhpur</td><td>NO</td><td>YES</td><td>900</td><td>800</td></tr>
 <tr><td>Goa</td><td>YES</td><td>YES</td><td>1188</td><td>900</td></tr>
 <tr><td>Gurgaon</td><td>YES</td><td>NO</td><td>699</td><td>699</td></tr>
 <tr><td>Guwahati</td><td>YES</td><td>YES</td><td>1000</td><td>1000</td></tr>
 <tr><td>GWALIOR</td><td>NO</td><td>YES</td><td>1100</td><td>900</td></tr>
 <tr><td>HALDWANI</td><td>YES</td><td>YES</td><td>500</td><td>500</td></tr>
 <tr><td>Hyderabad</td><td>YES</td><td>YES</td><td>750</td><td>600</td></tr>
 <tr><td>Imphal</td><td>YES</td><td>YES</td><td>1400</td><td>1200</td></tr>
 <tr><td>Indore</td><td>YES</td><td>YES</td><td>1100</td><td>900</td></tr>
 <tr><td>Jabalpur</td><td>NO</td><td>YES</td><td>1100</td><td>900</td></tr>
 <tr><td>Jalandhar</td><td>YES</td><td>YES</td><td>900</td><td>900</td></tr>
 <tr><td>Jammu</td><td>YES</td><td>YES</td><td>1600</td><td>1400</td></tr>
 <tr><td>Kolhapur</td><td>YES</td><td>YES</td><td>980</td><td>850</td></tr>
 <tr><td>Kolkata</td><td>YES</td><td>YES</td><td>950</td><td>950</td></tr>
 <tr><td>Lucknow</td><td>NO</td><td>YES</td><td>900</td><td>800</td></tr>
 <tr><td>Ludhiana</td><td>YES</td><td>YES</td><td>900</td><td>900</td></tr>
 <tr><td>Meerut</td><td>NO</td><td>YES</td><td>900</td><td>800</td></tr>
 <tr><td>Moradabad</td><td>YES</td><td>YES</td><td>900</td><td>800</td></tr>
 <tr><td>Mumbai</td><td>YES</td><td>NO</td><td>980</td><td>850</td></tr>
 <tr><td>Muzzafarnagar </td><td>YES</td><td>YES</td><td>900</td><td>800</td></tr>
 <tr><td>Nagpur</td><td>YES</td><td>YES</td><td>980</td><td>850</td></tr>
 <tr><td>Navi Mumbai</td><td>YES</td><td>NO</td><td>980</td><td>850</td></tr>
 <tr><td>Prayagraj</td><td>NO</td><td>YES</td><td>900</td><td>800</td></tr>
 <tr><td>Pune</td><td>YES</td><td>YES</td><td>980</td><td>850</td></tr>
 <tr><td>Raipur</td><td>YES</td><td>YES</td><td>950</td><td>800</td></tr>
 <tr><td>Rishikesh</td><td>NO</td><td>YES</td><td>500</td><td>500</td></tr>
 <tr><td>Silchar</td><td>YES</td><td>YES</td><td>1000</td><td>1000</td></tr>
 <tr><td>Ujjain</td><td>NO</td><td>YES</td><td>1100</td><td>900</td></tr>
 <tr><td>Varanasi</td><td>NO</td><td>YES</td><td>900</td><td>800</td></tr>
 <tr><td>Vizag</td><td>NO</td><td>YES</td><td>499</td><td>499</td></tr>
</tbody></table>
         
                  
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
	jQuery("#chkPendingPANStatus").html("Your Application is Submitted successfully");	
	jQuery('#submit').val('Submit');		
	jQuery('#submit').attr('disabled',false);		
    $('#regisForm').hide();
    
    } else if(data.status =='error'){
    alert("Contact Admin"); 
	jQuery('#submit').val('Submit');		
	jQuery('#submit').attr('disabled',false);		
    $('#regisForm').hide();	
    }
    }
    });
    }
</script>
</body>
</html>