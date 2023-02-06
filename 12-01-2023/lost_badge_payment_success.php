<?php 
include('header_include.php');

if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit; }
$registration_id = $_SESSION['USERID'];
$visitor_id = $_SESSION['visitor_id'];
$email = $_SESSION['EMAILID'];

$ownerMobile = getOwnerVisitorMobile($_SESSION['USERID'],$conn);
$visitorMobile = getVisitorMobile($visitor_id,$conn);
date_default_timezone_set('Asia/Kolkata');
$cr_date = date('d-m-Y H:i:s');
$current_time = strtotime($cr_date);
$closetime = strtotime("02-08-2019 23:55:00");

require_once 'ebs/TransactionRequestBean.php';
require_once 'ebs/TransactionResponseBean.php';
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

<div class="header">
	<?php include('header1.php'); ?>
</div>
<div class="inner_container">
  <div class="container">
    <div class="container_leftn">

<?php
$orderId = $_SESSION['orderId'];
$post_date=date('Y-m-d');

$transactionRequestBean = new TransactionRequestBean();
if(isset($_POST))
{
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
    $transactionResponseBean->setKey($_SESSION['key']);
    $transactionResponseBean->setIv($_SESSION['iv']);

    $response = $transactionResponseBean->getResponsePayload();
 /*   echo "<pre>";
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

	if($txn_status=='0300' && $orderId==$clnt_txn_ref)
	{		
		$orderUpdate ="update visitor_lost_badges set payment_status='$msgs',txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id',paymentThrough='online' where orderId='$clnt_txn_ref' AND regId='$registration_id' AND visitor_id='$visitor_id'";
		$getResult = $conn->query($orderUpdate);
		if(!$getResult) { die('Error: ' . $conn->error); }
		
		$getapplication ="SELECT total_payable FROM `visitor_lost_badges` WHERE `regId` = '$registration_id' AND orderId='$orderId' AND payment_status='Y' AND visitor_id='$visitor_id'";
		$getApplicationResult = $conn->query($getapplication);
		$getApplicationRow = $getApplicationResult->fetch_assoc();
		$total_payable = $getApplicationRow['total_payable'];
		$total_payable_word = number_word_v($total_payable);	
		
		/* Send SMS to Visitors Start */
		$messagev = "Thank you for registration. Your Lost Badge Registration Number is $visitor_id for ORDER ID $orderId.Your badge will be dispatched shortly";
		get_data($messagev,$visitorMobile); 	
		
		$messageo = "Thank you for registration. Your ORDER ID for Lost Badge Visitor registration is $orderId.Your badge will be dispatched shortly";
		get_data($messageo,$ownerMobile); 		
		/* Send SMS to Visitors Stop */					
		
	/*Send Email Receipt to Company */
	$message ='<table class="table2" width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">	
    <tbody>    
    	<tr>
            <td align="left"><img id="ri" src="https://registration.gjepc.org/images/mailer/gjepc_logo.png">
            <td align="center"> <img id="mi"> </td>
            <td align="right"><img id="ri" src="https://registration.gjepc.org/images/mailer/logo.png"></td>
            </td>                        
		</tr>
        <tr>
            <td align="center" colspan="3">
                <p style="line-height:25px;">
                    <h3 style="margin: 5px;">THE GEM JEWELLERY EXPORT PROMOTION COUNCIL</h3>
                    <b>GJEPC-H.O.-MUMBAI:1st Flr, Tower A,G Block, BDB, Bandra-Kurla Complex, Bandra(E)-400 051</b><br>
                    <b>GJEPC-E.X.-MUMBAI:G2-A, Trade Center, Bandra-Kurla Complex, Bandra(E)-400 051</b><br>
					<b>Toll Free Number :</b> 1800-103-4353, <b>Missed Call Number :</b> +91-7208048100<br>Website: https://iijs-signature.org Email: visitors@gjepcindia.com</p>
            </td>
        </tr>            
        <tr><td colspan="3" height="30"><hr></td></tr>        
        <tr>           
        	<td colspan="3" id="content">
            	<table class="table1"width="100%" style="font-family:Arial, sans-serif; color:#333333; font-size:13px;">
                <tr>
                <td style="padding:0 10px;" align="left">Order ID: '.$orderId.' </td>
                <td style="padding:0 60px;" align="right">Date: '.date("d-m-y").'</td>
                </tr>                    
                </table>

                <table class="table2"width="100%" style="font-family:Arial, sans-serif; color:#333333; font-size:13px;" cellpadding="10">
                <tr>
                    <td width="20%">Received with Thanks From M/s: </td>
                    <td width="75%">'.$_SESSION['COMPANYNAME'].'</td>
                </tr>
                <tr>
                    <td width="20%">Rupees: </td>
                    <td width="75%">'.$total_payable.' ('.$total_payable_word.')</td>
                </tr>
				<tr>
                    <td width="20%">Events: </td>
                    <td width="75%">IIJS-SIGNATURE</td>
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
           } .table2 h4{text-align: center; }
           </style>
	</tbody>
	</table>';	
		
		//$to ='santosh@kwebmaker.com,neelmani@kwebmaker.com,akash@gjepcindia.com';
		$to =$email.',pvr@gjepcindia.com';
		$subject  = "Thank you for registering at IIJS SIGNATURE 2020 Show"; 
		$headers  = 'MIME-Version: 1.0' . "\n"; 
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		$headers .= 'From: IIJS SIGNATURE 2020 <admin@gjepc.org>';			
		mail($to, $subject, $message, $headers);
		/*  Email End */		
				
		//header('Location: https://iijs.org/visitor_registration.php');
		header("Refresh: 2; url=https://registration.gjepc.org/employee_directory.php");
		?>
		<div class="container_wrap">
		<div class="container" id="manualFormContainer">
		<h1 style="color:green;">PAYMENT SUCCESSFUL</h1>
		<div id="formWrapper">
		<p>Your transaction is successfully Completed. Thank you for your participation in IIJS SIGNATURE 2020.</p>
		<p>Your Transaction ID : <?php echo $tpsl_txn_id;?></p>
		</div>
		<div class="clear"></div>
		</div>
		</div>
		<?php
	} else if($txn_status=='0392') {
			echo $saveSuccessMsg = "Cancelled_BY_User";
			$orderUpdate ="update visitor_lost_badges set txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where orderId='$clnt_txn_ref' AND regId='$registration_id' AND paymentThrough='online' AND visitor_id='$visitor_id'";
			$getResult = $conn->query($orderUpdate);
		} else if($txn_status=='0395') {			
			echo $saveSuccessMsg = "User Aborted";
			$orderUpdate ="update visitor_lost_badges set txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where orderId='$clnt_txn_ref' AND regId='$registration_id' AND paymentThrough='online' AND visitor_id='$visitor_id'";
			$getResult = $conn->query($orderUpdate);
		} else if($txn_status=='0396') {			
			echo $saveSuccessMsg = "AWAITED";
			$orderUpdate ="update visitor_lost_badges set txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where orderId='$clnt_txn_ref' AND regId='$registration_id' AND paymentThrough='online' AND visitor_id='$visitor_id'";
			$getResult = $conn->query($orderUpdate);
		} else if($txn_status=='0397') {			
			echo $saveSuccessMsg = "ABORTED";
			$orderUpdate ="update visitor_lost_badges set txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where orderId='$clnt_txn_ref' AND regId='$registration_id' AND paymentThrough='online' AND visitor_id='$visitor_id'";
			$getResult = $conn->query($orderUpdate);
		} else if($txn_status=='0399') {			
			echo $saveSuccessMsg = "FAILED";
			$orderUpdate ="update visitor_lost_badges set txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where orderId='$clnt_txn_ref' AND regId='$registration_id' AND paymentThrough='online' AND visitor_id='$visitor_id'";
			$getResult = $conn->query($orderUpdate);
		} else if($txn_status=='0400') {			
			echo $saveSuccessMsg = "Refund Successful in Db";
		} else if($txn_status=='0499') {			
			echo $saveSuccessMsg = "Refund Fail In Db";
		} else if($txn_status=='9999') {			
			echo $saveSuccessMsg = "Transaction Not Found In Db";
		} else	{
			echo "<br>Security Error. Illegal access detected";		
		}
		header("Refresh: 2; url=http://registration.gjepc.org/employee_directory.php");
		unset($_SESSION['orderId']);		
		unset($_SESSION['visitor_id']);		
}
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