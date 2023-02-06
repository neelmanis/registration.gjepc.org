<?php
include ("db.inc.php");
include ("functions.php");
session_start();

$actiontype = $_POST['actiontype'];
if($actiontype == 'checkPanNo'){
	$pan_number = trim(strtoupper($_REQUEST['pan_number']));
	
	$sql =  "SELECT * FROM visitor_directory WHERE pan_no='$pan_number' AND visitor_approval='Y' limit 1";
	$result = $conn->query($sql);
	$count = $result->num_rows;
	$data = array();
	if($count>0) 
	{
	$row = $conn->query($result); 
	$company = getCompanyName($row['registration_id'],$conn);	
	$mobile = trim($row['mobile']);
	$email = $row['email'];
	$reg_id = $row['registration_id'];
	$status = $row['visitor_approval'];
	$visitorID = $row['visitor_id']; 
	
	$checkHistory = "SELECT * FROM `visitor_order_history` WHERE visitor_id='$visitorID' AND `status`='1' AND payment_status='Y'";
	$getQuery = $conn->query($checkHistory);
	$checkResultCount = $getQuery->num_rows;
		if($checkResultCount>0) 
		{
			$getrow = $getQuery->fetch_assoc(); 	
			$mobile = trim($row['mobile']);
			$data['status'] = 'success';
			
			echo json_encode($data = array("status"=>'success',"mobile"=>$mobile)); exit;
		} else {
			echo json_encode($data = array("status"=>'notExistHistory')); exit;
		}
	
	} else {
		echo json_encode($data = array("status"=>'notExist')); exit;
	}	
	
}

if($actiontype == 'send_otp'){
	//$mobile_no = trim($_REQUEST['mobile_no']);
	$mobile_no = "9987753842";
	//$mobile_no = "9619662253";
	$datetime = date("Y-m-d H:i:s");
	$otp = rand(1000,9999); // generate OTP	
	$message = "One Time Password for Visitor Verification is.".$otp;
	$otp_sendStatus = get_data($message,$mobile_no); // Send OTP
	if(true){
  
		$getMobile = "SELECT mobile_no FROM airticket_mobile_verfication WHERE mobile_no='$mobile_no'";
		$getMobileResult = $conn->query($getMobile);
		$countMobile = $getMobileResult->num_rows;
		 if($countMobile>0){
		 $UpdateMobileOtp = $conn->query("UPDATE airticket_mobile_verfication SET otp='$otp',verified ='0',modifiedDate='$datetime' WHERE mobile_no='$mobile_no'");
		 }else{
		   $InsertMobileOtp = $conn->query("INSERT INTO airticket_mobile_verfication SET mobile_no='$mobile_no',otp='$otp',verified ='0',post_date='$datetime'");
		 }
		//$data = array("status"=>'success',"mobile_no"=>"$mobile_no");
		echo json_encode($data = array("status"=>'success',"mobile_no"=>$mobile_no)); exit;
	}else{
		//$data = array("status"=>'error');
		echo json_encode($data = array("status"=>'error')); exit;
	}
	//echo json_encode($data); exit;
}

//print_r($_POST); exit;

if($_POST['actiontype'] == 'verify_otp'){
	//$mobile_no = trim($_REQUEST['mobile_no']);
	$mobile_no = "9987753842";
	//$mobile_no = "9619662253";
	$otp_number = trim($_REQUEST['otp_number']);
	$visitor_type=$_REQUEST['visitor_type'];
	$pan_number = trim($_REQUEST['pan_number']);
	$post_date = date("Y-m-d H:i:s");
	
	if(isset($_REQUEST['otp_number']) && $_REQUEST['otp_number']!=''){
		
    $sql  = "SELECT * FROM airticket_mobile_verfication WHERE otp='$otp_number' AND mobile_no='$mobile_no'";
    $result = $conn->query($sql); 
    $count = $result->num_rows;
    if($count>0){
    $otpUpdate = "UPDATE airticket_mobile_verfication SET verified='1', modifiedDate='$post_date' WHERE otp='$otp_number' AND mobile_no='$mobile_no'";
    $otpUpdateResult = $conn->query($otpUpdate);    
	
	$_SESSION['IsOtpVerified']='Yes';
	$_SESSION['visitor_type']=$visitor_type;
	$_SESSION['pan_number']=$pan_number;
	$_SESSION['mobile_no']=$mobile_no;
	echo json_encode($data = array("status"=>'success')); exit;
    } else {
	echo json_encode($data = array("status"=>'fail')); exit;
    }
	}	
	echo json_encode($data = array("status"=>'failure')); exit;
} else { echo json_encode($data = array("status"=>'failurees')); exit; }

if($actiontype == 'resend_otp'){
	//$mobile_no = trim($_REQUEST['mobile_no']);
	$mobile_no = "9987753842";
	//$mobile_no = "9619662253";
	$datetime = date("Y-m-d H:i:s");
	$otp = rand(1000,9999); // generate OTP	
	$message = "One Time Password for Visitor Verification is.".$otp;
	$otp_sendStatus = get_data($message,$mobile_no); // Send OTP
	if(true){
  
		$getMobile = "SELECT mobile_no FROM airticket_mobile_verfication WHERE mobile_no='$mobile_no'";
		$getMobileResult = $conn->query($getMobile);
		$countMobile = $getMobileResult->num_rows;
		 if($countMobile>0){
		 $UpdateMobileOtp = $conn->query("UPDATE airticket_mobile_verfication SET otp='$otp',verified ='0',modifiedDate='$datetime' WHERE mobile_no='$mobile_no'");
		 }else{
		   $InsertMobileOtp = $conn->query("INSERT INTO airticket_mobile_verfication SET mobile_no='$mobile_no',otp='$otp',verified ='0',post_date='$datetime'");
		 }
		$data = array("status"=>'success',"mobile_no"=>"$mobile_no");
	}else{
		$data['status'] = 'error';
	}
	echo json_encode($data);
}

?>