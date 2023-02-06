<?php 
include('header_include.php');
require('rz_config.php');
require('razorpay-php/Razorpay.php');

use Razorpay\Api\Api;
$api = new Api( $keyId,  $keySecret);
if(isset($_POST['action']))
{	   
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        //filter($_POST);
        
        if(!isset($_POST['gidData'])){
            $return['status'] = "fail";
            $return['msg'] = "Please Enter EXHID";
            echo json_encode($return);die();
        }
		
		$net_payable_amount  = base64_decode($_POST['net_payable_amount']); 
		
		if(!isset($net_payable_amount)){
            $return['status'] = "fail";
            $return['msg'] = "Please Enter Amount";
            echo json_encode($return);die();
        }
		
        $gidData = trim($_POST['gidData']);    
        $payment_status = 'pending';
		$registration_id =  $_SESSION['USERID'];
		
        $strNo = rand(1,1000000);
		$orderId = "SPACE220".$strNo;
        $_SESSION['order'] = $orderId;
	//	$net_payable_amount = 1;	
        $orderData = [
            'receipt'         => $orderId,
            'amount'          => $net_payable_amount*100, //  rupees in paise
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
			   "description" => "Space Application Dashboard",
			    "image"      => "https://gjepc.org/assets/images/logo.png",
				"prefill"    => [
				"name"          => "GJEPC",
				"email"         => trim($_SESSION['EMAILID']),
				"contact"       => "0",
				],
			"notes" 	    => [
		'name'              => strtoupper(str_replace(array('&amp;','&AMP;'), '&', $_SESSION['COMPANYNAME'])),
		'registration_id'	=> trim($_SESSION['USERID']),
		'amountPaid' 		=> $net_payable_amount,
		'merchant_order_id' => $orderData['receipt'],
					  'gid' => $gidData
		],
		"theme"             => [
		"color"             => "#F37254"
		],
		"order_id"          => $razorpayOrderId,
				"success"   => true
				];
				
        $merchant_order_id = $orderData['receipt'];
		$payment_date = date('Y-m-d');

	$insertUTR = "INSERT INTO `utr_history`(`post_date`, `registration_id`,`gcode`,`utr_number`,`tdsAmount`,`amountPaid`, `razorpay_order_id`, `merchant_order_id`,`payment_status`,`payment_date`,`show`,`event_selected`, `year`, `status`,`error_description`,`comment`,`payment_made_for`) VALUES (NOW(),'$registration_id','$gidData','$merchant_order_id','0','$net_payable_amount','$razorpayOrderId','$merchant_order_id','pending','$payment_date','IIJS PREMIERE 2022','iijs','2022','1','dashboard','dashboard','SPACE')";
	$insert = $conn->query($insertUTR);
	if(!$insert) { die('Error: Insert query failed' . $conn->error); }
	$payLog = "INSERT INTO `space_payment_log`(`registration_id`,`gid`,`merchant_order_id`,`amount`, `razorpay_order_id`,`post_date`,`source`,`payment_status`,`event_selected`) VALUES ('$registration_id','$gidData','$merchant_order_id','$net_payable_amount','$razorpayOrderId','$payment_date','dashboard','pending','iijs')";
	$resultPay = $conn->query($payLog);
    if($insert){
            echo json_encode($data); exit;
    } else {
            echo json_encode(array("status" => "fail", "title" => "Server error", "icon" => "warning", "message" => "Payment initialization has been failed")); exit;
    }
    } else {
            echo json_encode($razorpayOrder['error']); exit;
    }
    
}

if(isset($_POST['razorpay_payment_id']) && isset($_POST['razorpay_order_id']) ) 
{
	$payment = $api->payment->fetch($_POST['razorpay_payment_id']);
//	echo '<pre>'; print_r($_POST); exit;
	$razorpay_payment_id =  $_POST['razorpay_payment_id'];
    $razorpay_signature = $_POST['razorpay_signature'];
	$registration_id = $_SESSION['USERID'];
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
	$gid = $notes_response->gid;
    $razorpay_order_id = $payment->order_id;

	if($registration_id!='' && $razorpay_order_id!=''){
	$updateUTR = "UPDATE `utr_history` SET `modified_date`=NOW(),razorpay_signature='$razorpay_signature',`order_id`='$order_id',`razorpay_payment_id`='$razorpay_payment_id',`currency`='$currency',`method`='$method',`payment_status`='$payment_status',`card_id`='$card_id',`bank`='$bank',`email`='$email',`error_description`='$error_description',`comment`='dashboard',`payment_date`='$payment_date',source='dashboard' WHERE razorpay_order_id='$razorpay_order_id' AND `registration_id`='$registration_id' AND `show`='IIJS PREMIERE 2022' AND `event_selected`='iijs'"; 
	$resultUTR = $conn->query($updateUTR);
	if(!$resultUTR) { die('Error: Update query failed' . $conn->error); }
	} else {
		echo "<script type='text/javascript'> alert('something went wrong!! Please try again');
		window.location.href='my_dashboard.php';
		</script>";
		return;	exit;
	}
	
    if($payment['status'] == 'captured'){
	
	$update_query = "update exh_reg_payment_details set payment_status='approved', document_status='approved',application_status='approved',application_comment='dashboard' where gid='$gid' and uid='$registration_id' and `show`='IIJS PREMIERE 2022'";
	$result_update=$conn ->query($update_query);
		
	$sqlmx="select contact_person,region from exh_reg_general_info where uid='$registration_id' and event_selected='iijs' AND event_for='IIJS PREMIERE 2022' order by id desc limit 0,1";
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
	
	$sqlm = "SELECT * FROM `exh_registration` WHERE uid='$registration_id' AND gid='$gid' AND `show`='IIJS PREMIERE 2022' AND event_selected='iijs' order by exh_id desc limit 0,1";
	$querym = $conn->query($sqlm);		
	$resultm = $querym->fetch_assoc();
		
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
    	<p><strong>Dear '.$contact_person.',</strong> </p>
		<p><strong>Order No. : '.$merchant_order_id.'</strong></p>
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
        <!--<td width="65%">IIJS SIGNATURE 2022 ROI Details / IIJS SIGNATURE 2022 Allotment Details (If Not applied for IIJS SIGNATURE 2022 ROI)</td>-->
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
	
	$to = $_SESSION['EMAILID'].",notification@gjepcindia.com,iijs.gjepc@gmail.com"; 
	//$to = 'neelmani@kwebmaker.com';
	$subject = "Exhibitor Registration For IIJS PREMIERE 2022";
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