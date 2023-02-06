	<?php
include ("db.inc.php");
include ("functions.php");
session_start();


if($_POST['mobile_no']){
	 $mobile_no = trim($_REQUEST['mobile_no']);
	$datetime = date("Y-m-d H:i:s");
	$visitor_id =$_SESSION['visitor_id'];
	$registration_id = $_SESSION['registration_id'];
	$sql =  "SELECT mobile FROM visitor_directory WHERE mobile = '$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id' ";
	$result = mysql_query($sql); 
	$count = mysql_num_rows($result);
    $data = array();
	if($count>0) 
	{
		$otp = rand(1000,9999); // generate OTP	
		$message = "One Time Password for Visitor Verification is.".$otp;
		$otp_sendStatus = get_data($message,$mobile_no); // Send OTP
		if($otp_sendStatus){
      
			$getMobile = "SELECT mobile_no FROM visitor_mobileotpverification WHERE mobile_no='$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id'";
			$getMobileResult = mysql_query($getMobile);
			  $countMobile = mysql_num_rows($getMobileResult);
			 /*echo "INSERT INTO visitor_mobileotpverification SET mobile_no='$mobile_no',otp='$otp',verified ='0',post_date='$datetime'";exit;*/
			 if($countMobile>0){
             $UpdateMobileOtp = mysql_query("UPDATE visitor_mobileotpverification SET otp='$otp',verified ='0',modifiedDate='$datetime' WHERE mobile_no='$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id'");
		    
			 }else{
               $InsertMobileOtp = mysql_query("INSERT INTO visitor_mobileotpverification SET mobile_no='$mobile_no',otp='$otp',verified ='0',post_date='$datetime',registration_id='$registration_id',visitor_id='$visitor_id'");
			 }
			$data = array("status"=>'successOtp',"mobile_no"=>"$mobile_no");
		}
		
	} else {
		$data = array("status"=>'error');
	}	
	echo json_encode($data);
}




?>