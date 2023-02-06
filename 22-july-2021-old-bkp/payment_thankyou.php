<?php include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit; }
$registration_id = $_SESSION['USERID'];
?>
<script>
	$(document).ready(function(){
		$(document).load(function(){
			localStorage.clear();
		});
	});
</script>
<?php
$show = "signature2";
$year = 2021;
$payment_type = "online";
$post_date = date('Y-m-d');

$delivery_id	= 	filter($_POST['delivery_id']);
$billing_delivery_id	= 	filter($_POST['billing_delivery_id']);
$type_of_member	=	filter($_POST['type_of_member']);
if(isset($_POST['agree']) && $_POST['agree'] == 'YES'){   $agree = "YES"; } else {  $agree = "NO"; }
//print_r($_POST);exit;
	if(isset($registration_id) && $registration_id!=""){
	$ssx = "SELECT * FROM `visitor_order_temp` WHERE `registration_id`='$registration_id' AND `show`='$show' AND `year`='$year' AND visitor_id!='0' AND paymentThrough='online'";
	$query_result=$conn->query($ssx);
	$count_v=$query_result->num_rows;
	if($count_v==0)
	{
		echo "<script type='text/javascript'> alert('Please Add Visitors');
		window.location.href='visitor_registration.php';
		</script>";
		return;	exit;
	}
	}
	/*
	$amount = convert_uudecode($_POST['amount']);
	$gst_amount   = convert_uudecode($_POST['gst_amount']);
	$total_payable  = convert_uudecode($_POST['total_payable']); */
	
	$amount = base64_decode($_POST['amount']);
	$gst_amount   = base64_decode($_POST['gst_amount']);
	$total_payable  = base64_decode($_POST['total_payable']); 
	
	if(!is_numeric($total_payable) || !is_numeric($registration_id)){
	echo '<script type="text/javascript">'; 
	echo 'alert("There is something went wrong..!! Kindly check with Admin");'; 
	echo 'window.location.href = "visitor_registration.php";';
	echo '</script>';	
	exit;
	}

	/* Check session_id and Amount start*/
	if(isset($registration_id) && $registration_id!="")
	{
	$sqlP = "select sum(amount) as amount,payment_made_for from visitor_order_temp where registration_id='$registration_id' AND `show`='$show' AND `year`='$year' AND paymentThrough='online'";
	$queryP = $conn->query($sqlP);
	$resultP = $queryP->fetch_assoc();
	$temp_total_amount = trim($resultP['amount']);
	$payment_made_for = trim($resultP['payment_made_for']);
	//echo $temp_total_amount."---".$total_payable;exit;
		
		if($temp_total_amount==$total_payable)
		{
			$chks = "select * from visitor_order_detail order by id desc limit 1";
			$chkResult = $conn->query($chks);
			$row = $chkResult->fetch_assoc();
			$num=$chkResult->num_rows;
			$strNo = rand(1,10000000);
			if($num<=0)
			{ $orderId = 'vis1'; }
			else
			{
			 $orderId='SIGN21'.$strNo;
			}
			$_SESSION['orderId']=$orderId;
		
		/* For Machinery Start*/		
		if($payment_made_for=="igjme" && $temp_total_amount==0)
		{
			if(isset($delivery_id) && !empty($delivery_id) && !empty($billing_delivery_id) && $delivery_id!='N') {
		$sqlx2 = "insert into visitor_order_detail set orderId='$orderId',regId='$registration_id',payment_type='free',total_payable='$total_payable',create_date='$post_date',year='$year',event='$show',agree='$agree'";
		$result2 = $conn->query($sqlx2);
				
		$sqlx3 = "UPDATE `visitor_order_detail` SET `type_of_member`='$type_of_member',`delivery_id`='$delivery_id',`billing_delivery_id`='$billing_delivery_id', paymentThrough='online' WHERE `regId`='$registration_id' AND orderId='$orderId' AND year='$year' AND event='$show'";
		$result3 = $conn->query($sqlx3);
		} else {
			echo "<script type='text/javascript'> alert('Choose Delivery & Shipping Address');
			window.location.href='visitor_registration.php';
			</script>";	return;	exit;
		}
		
		$ssx1 = "UPDATE `visitor_order_temp` SET `orderId`='$orderId' WHERE `registration_id`='$registration_id' AND `show`='$show' AND `year`='$year' AND `paymentThrough`='online'";
		$query_result1=$conn->query($ssx1);
		if($result2){ header('Location: payment_igjme_success.php'); }		
		// For Machinery End 
		}	else {
		/* For IIJS Start*/	
		if(isset($delivery_id) && !empty($delivery_id) && !empty($billing_delivery_id) && $delivery_id!='N') {
		$sqlx2 = "insert into visitor_order_detail set orderId='$orderId',regId='$registration_id',payment_type='$payment_type',total_payable='$total_payable',create_date='$post_date',year='$year',event='$show',agree='$agree'";
		$result2 = $conn->query($sqlx2);		
		
		$sqlx3 = "UPDATE `visitor_order_detail` SET `type_of_member`='$type_of_member',`delivery_id`='$delivery_id',`billing_delivery_id`='$billing_delivery_id',`paymentThrough`='online' WHERE `regId`='$registration_id' AND orderId='$orderId' AND year='$year' AND event='$show'";
		$result3 = $conn->query($sqlx3);
		} else {
			echo "<script type='text/javascript'> alert('Choose Delivery & Shipping Address');
			window.location.href='visitor_registration.php';
			</script>";	return;	exit;
		}
		$ssx1 = "UPDATE `visitor_order_temp` SET `orderId`='$orderId' WHERE `registration_id`='$registration_id' AND `show`='$show' AND `year`='$year' AND `paymentThrough`='online'";
		$query_result1=$conn->query($ssx1);
		if($result2){
		header('Location: ebs/techprocess.php');
		}
		}
		/* For IIJS End */	
		
		/* if($payment_made_for=="vbsm2" && $temp_total_amount==0)
		{
		if(isset($delivery_id) && !empty($delivery_id)) {
		$sqlx2 = "insert into visitor_order_detail set orderId='$orderId',regId='$registration_id',payment_type='free',total_payable='$total_payable',create_date='$post_date',year='$year',event='$show',agree='$agree'";
		$result2 = $conn->query($sqlx2);
				
		$sqlx3 = "UPDATE `visitor_order_detail` SET `type_of_member`='$type_of_member',`delivery_id`='$delivery_id',`billing_delivery_id`='$billing_delivery_id', paymentThrough='online' WHERE `regId`='$registration_id' AND orderId='$orderId' AND year='$year' AND event='$show'";
		$result3 = $conn->query($sqlx3);
		} else {
			echo "<script type='text/javascript'> alert('Choose Delivery & Shipping Address');
			window.location.href='visitor_registration.php';
			</script>";	return;	exit;
		}
		
		$ssx1 = "UPDATE `visitor_order_temp` SET `orderId`='$orderId', paymentThrough='online' WHERE `registration_id`='$registration_id' AND `show`='$show' AND `year`='$year' AND `paymentThrough`='online'";
		$query_result1=$conn->query($ssx1);
		if($result2){ header('Location: payment_vbsm_success.php'); }		
		 
		} Virtual End */
		
		}  else {
		echo "<script type='text/javascript'> alert('Error...');
		window.location.href='visitor_registration.php';
		</script>";	return;	exit;
		}		
	} else {
		echo "<script type='text/javascript'> alert('Your session has been expired');
		window.location.href='visitor_registration.php';
		</script>";
		return;	exit;
	}
?>