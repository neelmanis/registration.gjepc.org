<?php
require('rz_config.php');
require('razorpay-php/Razorpay.php');

use Razorpay\Api\Api;
$api = new Api( $keyId,  $keySecret);


$sqlAPI = "SELECT * FROM `utr_history` WHERE 1 AND registration_id='".$_SESSION['USERID']."' AND `show` = 'IIJS 2022' AND event_selected='iijs' AND payment_status='pending'";
$querys =  $conn ->query($sqlAPI);
while($result = $querys->fetch_assoc())
{
	$post_date = date('Y-m-d');
	$razorpay_order_id = $result['razorpay_order_id'];
	$utr_number = $result['utr_number'];
	
	$api  = new Api($keyId, $keySecret);
$payment = $api->order->fetch($razorpay_order_id)->payments();
//echo '<pre>'; print_r($payment); 
//	print_r($payment['items']);
	$payment_items = $payment['items'];
	//echo '<pre>'; print_r($payment_items);
	$payment_status =  $payment_items[0]['status'];
	$order_id =  $payment_items[0]['order_id'];
	$razorpay_payment_id =  $payment_items[0]['id'];
	$method =  $payment_items[0]['method'];
	$currency =  $payment_items[0]['currency'];
	$card_id =  $payment_items[0]['card_id']; 
	$bank =  $payment_items[0]['bank']; 
	$error_description =   $payment_items[0]['error_description'];
	$payment_date = date('Y-m-d',$payment_items[0]['captured_at']);
	
	
	if($payment_status == 'captured'){
	if($_SESSION['USERID']!='' && $razorpay_order_id!=''){
	$updateUTR = "UPDATE `utr_history` SET `modified_date`=NOW(),`order_id`='$order_id',`razorpay_payment_id`='$razorpay_payment_id',`currency`='$currency',`method`='$method',`payment_status`='$payment_status',`card_id`='$card_id',`bank`='$bank',`error_description`='$error_description',`comment`='dashboard status api',`payment_date`='$payment_date' WHERE razorpay_order_id='$razorpay_order_id' AND `registration_id`='$registration_id' AND `show`='IIJS 2022' AND `event_selected`='iijs'"; 
	$resultUTR = $conn->query($updateUTR);
	if(!$resultUTR) { die('Error: Update query failed' . $conn->error); }
	} else { echo 'Not set '; }
	}
		
/*
	if(sizeof($payment['items']) > 1 ){
		$updtx = "";
	$resultUpdate = $conn ->query();
	} else {

	} */
}
?>