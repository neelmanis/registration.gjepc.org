<?php
include ("db.inc.php");
include ("functions.php");
session_start();

$action = $_REQUEST['action'];
if($action == 'check_mobile_number'){
	$mobile_no = trim($_REQUEST['mobile_no']);
	 $sql =  "SELECT * FROM globalExhibition WHERE participant_Type='CONTR' AND mobile='$mobile_no' order by post_date desc limit 1";
	$result = $conn ->query($sql); 
	$count = $result->num_rows;
  
    $data = array();
	if($count>0) 
	{
		$row = $result->fetch_assoc(); 
		$company = strtoupper(str_replace('&amp;', '&', $row['company']));
		$mobile = trim($row['mobile']);
		$email = $row['email'];
		$designation = $row['designation'];
		$name = $row['fname'];
		$lname = "";
		$photo = $row['photo_url'];
		$reg_id = $row['registration_id'];
		$status = $row['status'];
		$visitorID = $row['visitor_id']; 
		if($status =='Y'){
		     $_SESSION['registration_id'] = $row['registration_id']; 
			    $_SESSION['visitor_id'] = $row['visitor_id'];
			    $_SESSION['participant_Type'] = "CONTR" ;
       	  $data = array("status"=>'success',"company"=>$company, "mobile"=>$mobile,"email"=>$email,"name"=>$name,"lname"=>$lname,"photo"=>$photo,"reg_id"=>$reg_id,"visitor_id"=>$visitorID,"designation"=>$designation,"showHistory"=>"");
    
		}else if($status =='D'){
   		$data = array("status"=>'warning', "message"=>"Your badge is disapproved for the show.");
				echo json_encode($data); exit;
		}else if($status =='P'){
		$data = array("status"=>'warning', "message"=>"Your badge approval for the show is pending.");
			echo json_encode($data); exit;
		}
	} else {
		$data = array("status"=>'warning', "message"=>"Record not found for the badge.");
			echo json_encode($data); exit;
	}	
	echo json_encode($data);
}

if($action == 'send_otp'){
	$mobile_no = trim($_REQUEST['mobile_no_x']);
	
	$datetime = date("Y-m-d H:i:s");
	$visitor_id =$_SESSION['visitor_id'];
	$registration_id = $_SESSION['registration_id'];
    $otp = rand(1000,9999); // generate OTP	

    $sql =  "SELECT mobile FROM globalExhibition WHERE mobile = '$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id' AND participant_Type='CONTR'";
	$result = $conn->query($sql); 
	$count = $result->num_rows;
    $data = array();
		if($count>0) 
		{
			
			$message = "One Time Password for Visitor Verification is ".$otp." , Regards GJEPC";
			$otp_sendStatus = send_sms($message,$mobile_no);
		//echo "UPDATE globalExhibition SET otp='$otp',isVerified ='0',modifiedDate='$datetime' WHERE mobile='$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id'  AND participant_Type='CONTR' ";exit;
				
	          $UpdateMobileOtp = $conn->query("UPDATE globalExhibition SET otp='$otp',isVerified ='0',modified_date='$datetime' WHERE mobile='$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id'  AND participant_Type='CONTR' ");
				
				$data = array("status"=>'successOtp',"mobile_no"=>"$mobile_no");
			
			
		} else {
			$data = array("status"=>'error');
		}

	echo json_encode($data);
}

if($action == 'verifyOTP'){
	$visitor_id =$_SESSION['visitor_id'];
	$registration_id = $_SESSION['registration_id'];
	$otpNumber = trim($_REQUEST['otp_number']);

	$mobile_no_otp = trim($_REQUEST['mobile_no_otp']);

	$post_date = date("Y-m-d H:i:s");
    // $sql  = "SELECT * FROM visitor_mobileotpverification WHERE otp='$otpNumber' AND mobile_no='$mobile_no_otp' AND visitor_id='$visitor_id' AND registration_id = '$registration_id'";
    $sql  = "SELECT mobile FROM globalExhibition WHERE otp='$otpNumber' AND mobile = '$mobile_no_otp' AND visitor_id='$visitor_id' AND registration_id = '$registration_id' AND participant_Type='CONTR'";

    $result = $conn->query($sql); 
    $count = $result->num_rows;
    if($count > 0){
   
   $updateGlobal = "UPDATE gjepclivedatabase.globalExhibition SET isVerified='1' WHERE visitor_id='$visitorID' AND  registration_id='$registration_id' AND participant_Type ='CONTR' ";
   	$resultUpdateGlobal = $conn->query($updateGlobal);
    $_SESSION['isBadgeMobileVerified'] = "YES";
    $data = array("status"=>'success',"redirect"=>"vis_registration");

    }else{
    $data = array("status"=>'fail');
    }
    echo json_encode($data); 
}




?>