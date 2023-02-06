<?php 
include('header_include.php');
include('config_constant.php');
require('rz_config.php');
//require('rz_config_dev.php');
require('razorpay-php/Razorpay.php');
ini_set('display_errors', 1);
    ini_set('error_reporting', E_ALL);
use Razorpay\Api\Api;
$api = new Api( $keyId,  $keySecret);

if(isset($_POST['action']))
{	   
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        //filter($_POST);
        //print_r($_POST); exit;
        if(!isset($_POST['gid'])){
            $return['status'] = "fail";
            $return['msg'] = "GID Missing";
            echo json_encode($return); die();
        }
		if(!isset($_POST['show'])){
			$return['status'] = "fail";
            $return['msg'] = "Show Missing";
            echo json_encode($return); die();
		}
		$cheque_tds_Netamount  = trim($_POST['cheque_tds_Netamount']); 
		
		if(!isset($cheque_tds_Netamount)){
            $return['status'] = "fail";
            $return['msg'] = "Balance Amount Missing";
            echo json_encode($return);die();
        }
		
        $gid = trim($_POST['gid']);    
        $payment_status = 'pending';
		$registration_id =  $_SESSION['USERID'];
		
        $strNo = rand(99999,11111);
		$orderId = "ALLOT3".$strNo;
        $_SESSION['order'] = $orderId;
		//$cheque_tds_Netamount = 100;	
        $orderData = [
            'receipt'         => $orderId,
            'amount'          => $cheque_tds_Netamount*100, //  rupees in paise
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ];

		$amount = $orderData['amount'];
		
        $razorpayOrder = $api->order->create($orderData);		
        $razorpayOrderId = $razorpayOrder['id'];
        if($razorpayOrderId){           
            $data = [
					"key" => $keyId,
					"amount" => $amount,
					"name"   => "GJEPC",
			   "description" => "Space Allotment Dashboard",
			    "image"      => "https://gjepc.org/assets/images/logo.png",
				"prefill"    => [
				"name"          => "GJEPC",
				"email"         => trim($_SESSION['EMAILID']),
				"contact"       => "0",
				],
			"notes" 	    => [
		'name'              => strtoupper(str_replace(array('&amp;','&AMP;'), '&', $_SESSION['COMPANYNAME'])),
		'registration_id'	=> trim($_SESSION['USERID']),
		'amountPaid' 		=> $cheque_tds_Netamount,
		'merchant_order_id' => $orderData['receipt'],
					  'gid' => $gid
		],
		"theme"             => [
		"color"             => "#F37254"
		],
		"order_id"          => $razorpayOrderId,
				"success"   => true
				];
				
        $merchant_order_id = $orderData['receipt'];
		$payment_date = date('Y-m-d');
		
		$selected_area = $_POST['selected_area'];
		$tot_space_cost_rate = $_POST['tot_space_cost_rate'];
		$sub_total_cost = $_POST['sub_total_cost'];
		$security_deposit = $_POST['security_deposit'];
		$govt_service_tax = $_POST['govt_service_tax'];
			
		$balancePayment = $_POST['balancePayment'];
		$tds_per = $_POST['cheque_tds_per'];
		$cheque_tds_amount = $_POST['cheque_tds_amount'];
		$cheque_tds_Netamount = $_POST['cheque_tds_Netamount'];
		
		if($_POST['show'] == 'signature'){
			$show = EVENT_SIGNATURE_2023;
			$event_selected = EVENT_SELECTED;
			$logo = LOGO_SIGNATURE;
		} else if($_POST['show'] == 'tritiya'){
			$show = EVENT_TRITIYA_2023;
			$event_selected = EVENT_SELECTED_TRITIYA;
			$logo = LOGO_TRITIYA;
		} else {
			$show = EVENT_IGJME_2023;
			$event_selected = EVENT_SELECTED_IGJME;
			$logo = LOGO_IGJME;
		}
		$_SESSION['selected_show'] = $show;
		$year = YEAR;
	
	if(isset($registration_id) && $registration_id!="")
	{
	$insertUTR = "INSERT INTO `utr_history`(`post_date`, `registration_id`,`gcode`,`utr_number`,`tdsAmount`,`cheque_tds_per`,`amountPaid`, `razorpay_order_id`, `merchant_order_id`,`payment_status`,`payment_date`,`show`,`event_selected`, `year`, `status`,`error_description`,`comment`,`payment_made_for`,source) VALUES (NOW(),'$registration_id','$gid','$merchant_order_id','$cheque_tds_amount','$tds_per','$cheque_tds_Netamount','$razorpayOrderId','$merchant_order_id','pending','$payment_date','$show','$event_selected','$year','1','ALLOTMENT','ALLOTMENT','ALLOTMENT','ALLOTMENT')";
	$insert = $conn->query($insertUTR);
	if(!$insert) { die('Error: Insert query failed' . $conn->error); }
	
	$insertManual = "INSERT INTO `exh_manual_calculation`(`created_date`, `uid`,`gid`,`balancePayment`,`selected_area`,`tot_space_cost_rate`,`sub_total_cost`,`security_deposit`,`govt_service_tax`,`net_payable_amount`, `merchant_order_id`,`razorpay_order_id`,`tds_per`,`tdsAmount`,`show`,`event_selected`, `year`,`payment_status`) VALUES (NOW(),'$registration_id','$gid','$balancePayment','$selected_area','$tot_space_cost_rate','$sub_total_cost','$security_deposit','$govt_service_tax','$cheque_tds_Netamount','$merchant_order_id','$razorpayOrderId','$tds_per','$cheque_tds_amount','$show','$event_selected','$year','pending')";
	$insertM = $conn->query($insertManual);
	if(!$insertM) { die('Error: Insert query failed in Manual' . $conn->error); }
	
	$payLog = "INSERT INTO `space_payment_log`(`registration_id`,`gid`,`merchant_order_id`,`amount`, `razorpay_order_id`,`post_date`,`source`,`payment_status`,`event_selected`) VALUES ('$registration_id','$gid','$merchant_order_id','$cheque_tds_Netamount','$razorpayOrderId','$payment_date','ALLOTMENT','pending','$event_selected')";
	$resultPay = $conn->query($payLog);
    if($insert){
            echo json_encode($data); exit;
    } else {
            echo json_encode(array("status" => "fail", "title" => "Server error", "icon" => "warning", "message" => "Payment initialization has been failed")); exit;
    }
		} else {
            echo json_encode(array("status" => "fail", "title" => "Server error", "icon" => "warning", "message" => "Session ID Expired")); exit;
		}
    } else {
            echo json_encode($razorpayOrder['error']); exit;
    }  
}

if(isset($_POST['razorpay_payment_id']) && isset($_POST['razorpay_order_id']) ) 
{
	$payment = $api->payment->fetch($_POST['razorpay_payment_id']);
	//echo '<pre>'; print_r($_POST); exit;
	$razorpay_payment_id =  $_POST['razorpay_payment_id'];
    $razorpay_signature = $_POST['razorpay_signature'];
	$registration_id = $_SESSION['USERID'];
    $email =  $_SESSION['EMAILID'];
	$selected_show = $_SESSION['selected_show'];
	
	if($selected_show == 'IIJS SIGNATURE 2023'){
		$show = EVENT_SIGNATURE_2023;
		$event_selected = EVENT_SELECTED;
		$logo = LOGO_SIGNATURE;
	} else if($selected_show == 'IIJS TRITIYA 2023'){
		$show = EVENT_TRITIYA_2023;
		$event_selected = EVENT_SELECTED_TRITIYA;
		$logo = LOGO_TRITIYA;
	} else {
		$show = EVENT_IGJME_2023;
		$event_selected = EVENT_SELECTED_IGJME;
		$logo = LOGO_IGJME;
	}
	$year = YEAR;
	
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
	$gid = $notes_response->gid;
    $razorpay_order_id = $payment->order_id;

	if($registration_id!='' && $razorpay_order_id!=''){
	$updateUTR = "UPDATE `utr_history` SET `modified_date`=NOW(),razorpay_signature='$razorpay_signature',`order_id`='$order_id',`razorpay_payment_id`='$razorpay_payment_id',`currency`='$currency',`method`='$method',`payment_status`='$payment_status',`card_id`='$card_id',`bank`='$bank',`email`='$email',`error_description`='$error_description',`comment`='ALLOTMENT',`payment_date`='$payment_date',source='ALLOTMENT' WHERE razorpay_order_id='$razorpay_order_id' AND `registration_id`='$registration_id' AND `show`='$show' AND `event_selected`='$event_selected'";
	$resultUTR = $conn->query($updateUTR);
	if(!$resultUTR) { die('Error: Update query failed' . $conn->error); }
	} else {
		echo "<script type='text/javascript'> alert('something went wrong!! Please try again');
		window.location.href='my_dashboard.php';
		</script>";
		return;	exit;
	}
	
    if($payment['status'] == 'captured'){
	
	$update_query = "UPDATE exh_manual_calculation set `modified_date`=NOW(),payment_status='".$payment['status']."' where gid='$gid' and uid='$registration_id' and `show`='$show' AND merchant_order_id='$merchant_order_id' AND razorpay_order_id='$razorpay_order_id'";
	$result_update=$conn ->query($update_query);
		
	$sqlmx="select contact_person,region from exh_reg_general_info where uid='$registration_id' and event_selected='$event_selected' AND event_for='$show' order by id desc limit 0,1";
	$querymx=$conn->query($sqlmx);
	$resultmx=$querymx->fetch_assoc();
	$contact_person =$resultmx['contact_person'];
	$region=$resultmx['region'];

	if($region=='HO-MUM (M)'){$to_admin='notification@gjepcindia.com'; }
	if($region=='RO-CHE'){$to_admin='p.anand@gjepcindia.com'; }
	if($region=='RO-DEL'){$to_admin='pranabes@gjepcindia.com'; }
	if($region=='RO-JAI'){$to_admin='ajaypurohit@gjepcindia.com'; }
	if($region=='RO-KOL'){$to_admin='kaushik@gjepcindia.com'; }
	if($region=='RO-SRT'){$to_admin='malcom@gjepcindia.com,utsav.ansurkar@gjepcindia.com'; }
	
	$sqlm = "SELECT * FROM `exh_registration` WHERE uid='$registration_id' AND gid='$gid' AND `show`='$show' AND event_selected='$event_selected' order by exh_id desc limit 0,1";
	$querym = $conn->query($sqlm);		
	$resultm = $querym->fetch_assoc();
		
	$message ='<table width="100%" bgcolor="#fff" style="margin:20px auto; border:2px solid #dddddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
<tr>
<td style="padding:30px;">
<table width="100%" border="0" background="#fff" cellpadding="0" cellspacing="0">
	<tr>
    	<td align="left" valign="top"><a href="https://www.gjepc.org"><img src="https://registration.gjepc.org/images/logo.png"/></a></td>
    	<td align="right"><a href="https://gjepc.org/iijs-signature/"><img src="https://registration.gjepc.org/manual_signature/images/SIGNATURE-LOGO-4.jpg"/></a></td>
    </tr>  
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>    
    <tr><td colspan="2" height="1px" bgcolor="#333333"></td></tr>    
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>    
	<tr>
    	<td colspan="2" valign="top" style="font-size:13px;">
		<p><strong>Company Name :</strong> '.$_SESSION['COMPANYNAME'].'</p>
    	<p><strong>Dear '.$contact_person.',</strong> </p>
		<p><strong>Order No. : '.$merchant_order_id.'</strong></p>
    	<p>We have received your Payment for Stall Booking at '.$show.'</p>  	
    	</td>
    </tr>
   
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>  
    <tr>
    <td colspan="2" style="line-height:20px;">
	<p>Kind Regards,</p>    
	<p><strong>IIJS Team,</strong></p>
	</td>
	</tr>
</table>

</td>
</tr>
</table>';
	
	$to = $_SESSION['EMAILID'].",notification@gjepcindia.com,iijs.gjepc@gmail.com"; 
	//$to = 'rohit@kwebmaker.com';
	$subject = "Exhibitor Registration For $show";
	$cc = "";
    $email_array = explode(",",$to);
    send_mailArray($email_array,$subject,$message,$cc);
	
	$return['status'] = "success";
    $return['redirect'] = "my_dashboard.php";
    $return['msg'] = "Payment Successfully Done";
    echo json_encode($return); exit;
} else {
        $return['status'] = "fail";
        echo json_encode($return); exit;
}	
   
}			
?>