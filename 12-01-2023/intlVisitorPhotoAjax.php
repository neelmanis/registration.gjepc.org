<?php
include ("db.inc.php");
include ("functions.php");
session_start();

$action = $_REQUEST['action'];
if($action == 'email_id'){
	$email_id = trim($_REQUEST['email_id']);
	$sql =  "SELECT * FROM ivr_registration_details WHERE email='$email_id' order by application_approved limit 1"; 
	$result = $conn ->query($sql); 
	$count = $result->num_rows; 
  
    $data = array();
	if($count>0) 
	{
		$row = $result->fetch_assoc(); 
		$company = trim($row['company_name']);
		$email = $row['email'];
		$mob_no = $row['mob_no'];
		$first_name = $row['first_name'];
		$last_name = $row['last_name'];
		$designation = $row['designation'];
		$photo = $row['photograph_fid'];
		$passport_fid = $row['passport_fid'];
		$visit_card_fid = $row['visit_card_fid'];
      $uid = intval(filter($row['uid']));
      $eid = intval(filter($row['eid']));

      $face_isApplied = $row['face_isApplied']; 
		$face_status = $row['face_status']; 
		$status = $row['application_approved'];
		$checkHistory = "SELECT * FROM `ivr_registration_history` WHERE visitor_id='$eid' AND registration_id='$uid' AND payment_made_for ='iijs22'";
		$getQuery = $conn ->query($checkHistory);
		$countVisitor = $getQuery->num_rows;
		$rowx = $getQuery->fetch_assoc();
				
		 if($countVisitor>0){

	    //$data = array("status"=>'error',"message"=>"You are already registered for this show.Kindly upload your vaccination certificate from below link");
			//echo json_encode($data); exit;


        } 

      
  
		if($status =='Y'){
			$_SESSION['uid'] = $row['uid'];
			$_SESSION['eid'] = $row['eid'];
			$_SESSION['email'] = $row['email'];
       	$data = array("status"=>'success',"company"=>$company,"mob_no"=>$mob_no,"email"=>$email,"first_name"=>$first_name,"last_name"=>$last_name,"photo"=>$photo,"passport_fid"=>$passport_fid,"visit_card_fid"=>$visit_card_fid,"uid"=>$uid,"designation"=>$designation);
		} else if($status =='N'){
        $message = "Dear ".$first_name.",your personal details are disapproved. Kindly update your data";
		$_SESSION['uid'] = $row['uid']; 
        $data = array("status"=>'error',"message"=>$message);
		} else if($status =='P'){
		$message = "Dear ".$first_name.", Your personal details approval is pending";
		$data = array("status"=>'error',"message"=>$message);	
		}
	} else {
		$data = array("status"=>'error',"message"=>"Your E-mail ID is not registered");
	}	
	echo json_encode($data);exit;
}

if($action == 'send_otp'){
	
	$email = trim($_REQUEST['emails']);
	$datetime = date("Y-m-d H:i:s");
	$eid = $_SESSION['eid'];
	$uid = $_SESSION['uid'];

	if(isset($email)){
    $sql =  "SELECT email,company_name FROM ivr_registration_details WHERE email = '$email' AND eid='$eid' AND uid = '$uid' ";
	$result = $conn->query($sql); 
	$rows = $result->fetch_assoc();
	$company_name = $rows['company_name'];
	$count = $result->num_rows;
    $data = array();
	if($count>0) 
	{
		$otp = rand(1000,9999); // generate OTP			
		$UpdateEmailOtp = $conn->query("UPDATE ivr_registration_details SET otp='$otp',verified ='0' WHERE email='$email' AND eid='$eid' AND uid = '$uid'");
		if($UpdateEmailOtp){
		/*.......................................Send mail to users mail id...............................................*/
	  $message ='<table cellpadding="10" width="100%" style="margin:0px auto;font-family: Roboto; background-color:#fff;padding:30px; border-collapse:collapse;border:1px solid #000"><tr><td colspan="2" style="background-color:#a89c5d;padding:3px;"></td></tr><tr><td align="left" ><img src="https://registration.gjepc.org/images/logo.png"></td><td align="right"></td></tr><tr ><td colspan="2">Dear '.$company_name .',</td></tr><tr ><td colspan="2">One Time Password for International Visitor Verification is <b>'.$otp.'</b></td></tr><tr><td colspan="2"><p> For Any Queries : </p><b>Email us on : daphne.dcosta@gjepcindia.com, naheed@gjepcindia.com</b> </td></tr><tr><td colspan="2"><p>Kind Regards,<br><b>GJEPC Web Team.</b></p></td></tr></table>';
  
	 $to = $email;
	 $cc = "daphne.dcosta@gjepcindia.com, naheed@gjepcindia.com";
	 $subject = "Email Verification OTP"; 
	
	 send_mail($to,$subject,$message,$cc);
	 $data = array("status"=>'successOtp',"email"=>"$email");
	}
	} else {
		$data = array("status"=>'error');
		}
	}
echo json_encode($data);
}


/* OTP Verification */
if($action == 'verifyOTP'){
	$eid = $_SESSION['eid'];
	$uid = $_SESSION['uid'];
	$otpNumber = trim($_REQUEST['otp_number']);
	$email = trim($_REQUEST['email_otp']);
	
	if(isset($otpNumber)){
    $sql  = "SELECT * FROM ivr_registration_details WHERE otp='$otpNumber' AND email='$email' AND eid='$eid' AND uid = '$uid'";
    $result = $conn->query($sql); 
    $count = $result->num_rows;
    if($count==1){
    $otpUpdate = "UPDATE ivr_registration_details SET verified='1' WHERE otp='$otpNumber' AND email='$email' AND eid='$eid' AND uid= '$uid' ";
    $otpUpdateResult = $conn->query($otpUpdate);
    $data = array("status"=>'success');
    } else {
    $data = array("status"=>'fail');
    }
	}
    echo json_encode($data); 
}





 if($action == 'UpdateVisitorLink'){
 	//print_r($_POST);exit;
	$registration_id = $_SESSION['uid'];
	$visitor_id = $_SESSION['eid'];
	$email = filter($_POST['email']);
	
	$checkForOtp = filter($_POST['checkForOtp']);
	 if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	  echo json_encode(array('status'=>'error',"message"=>"Enter valid E-mail id "));exit; 
	}
	$sqlEmail  = "SELECT email FROM ivr_registration_details WHERE email='$email' and eid !='$visitor_id'";
	$resultEmail= $conn->query($sqlEmail);
	$countEmail = $resultEmail->num_rows;
	if($countEmail > 0 ){
		echo json_encode(array('status'=>'error',"message"=>"Email id is already exist. "));exit; 
	}

	/*OTP CHECK*/
	$sql_otp = $conn->query("SELECT * FROM ivr_registration_details where eid='$visitor_id' and uid='$registration_id'");
  $result_otp = $sql_otp->fetch_assoc();
  $face_checkOtp =  $result_otp['face_checkOtp'];
  $face_emailOtp =  $result_otp['face_emailOtp'];
  $name = filter($result_otp['first_name'])." ".filter($result_otp['last_name']);
  if(	$checkForOtp  =="yes"){
  	if($_POST['email_otp'] ==""){
  		echo json_encode(array('status'=>'error',"message"=>"Enter OTP "));exit; 
  	}
  	$email = filter($_POST['email']);
  	$email_otp = $_POST['email_otp'];
  	if($face_emailOtp  != $email_otp ){
			echo json_encode(array('status'=>'error',"message"=>"OTP not matched "));exit; 
  	}
  	// else{
  	// 	$update_otp = $conn->query("UPDATE visitor_directory SET face_checkOtp ='0',face_emailVerified='1' ,email='$email' where visitor_id='$visitor_id' and registration_id='$registration_id'");
  	// 		echo json_encode(array('status'=>'success',"message"=>"E-mail has been updated successfully "));exit; 
		
  	// }


  }else{
  	$email =  $result_otp['email'];
  }
  
   
	
  
 	$sql_event = "SELECT * FROM `visitor_event_master` WHERE `status` ='1' AND `isParentShow`='1' ";
 	$result_event = $conn->query($sql_event);
 	$count_event = $result_event->num_rows;
 	if($count_event > 0){
   	$row_event = $result_event->fetch_assoc();
   	$show = $row_event['shortcode'];
   	$year = $row_event['year'];
   	$event_name = $row_event['event_name'];
  }else{
	 	$show = "iijs22";
	 	$year = date("Y");
	  $event_name = "IIJS22";

 	}
 





$sql  = "SELECT photograph_fid,passport_fid,visit_card_fid FROM ivr_registration_details WHERE uid='$registration_id' AND eid='$visitor_id'";
$result= $conn->query($sql);
$row = $result->fetch_assoc();
$get_photo = $row['photograph_fid'];

 if($checkForOtp  =="yes"){
			if (empty($_POST['photo'])) {
		 		$photo =  $get_photo;
		 	}
    }else{
    	if (empty($_POST['photo'])) {
		 		echo json_encode(array('status'=>'error',"message"=>"Please first capture photo and submit form. "));exit; 
		 	}
    }


	if (!empty($_POST['photo'])) {

	  $img = $_POST['photo']; 
	  $img = str_replace('data:image/jpeg;base64,', '', $img);
	  $img = str_replace(' ', '+', $img);
	  $file_data = base64_decode($img);
	  $photo = $eid."_".$uid."_".time().'-photo-'.mt_rand(100000,999999).'.jpg';
	  $file_name = 'images/ivr_image/photograph/'.$photo;
	  $save_file = file_put_contents($file_name, $file_data);
	}
  $current_date =date("Y-m-d");
  $face_isApplied = "Y";
  $face_status = "U";
  $face_photo = $photo;
  $face_ip = $_SERVER['REMOTE_ADDR'];
  
    $updateSql ="UPDATE ivr_registration_details SET email='$email', face_date='$current_date', face_modify='$current_date', face_isApplied='$face_isApplied', face_status='$face_status', face_ip='$face_ip',face_photo='$face_photo' where eid='$visitor_id' AND uid='$registration_id'";
   $updateResult = $conn->query($updateSql);

   if($updateResult ==TRUE){
   
   	$message = "Dear ".$name.", Thank you for uploading latest photo. You will be notified shortly on approval/disapproval . For any further query please contact $tollNumber GJEPC";

   	$_SESSION['successMessage']= $message; 
   	$messageEmail ='<table cellpadding="10" width="100%" style="margin: 0px auto; font-family: Roboto; background-color: #fff; padding: 30px; border-collapse: collapse; border: 1px solid #000;">
		<tr>
		        <td colspan="3" style="background-color: #a89c5d; padding: 3px;"></td>
		    </tr>
			<tr>
            <td align="left"><img id="ri" src="https://registration.gjepc.org/images/logo.png">
            <td align="center"> <img id="mi"> </td>
            <td align="right"></td>
                                  
		</tr>
		  <tr style="background-color:#eeee;padding:30px;">
		   <td colspan="3">'.$message.' </td>
		</tr> 
		   <tr><td colspan="3">       
			  <p>Kind Regards,<br>
			  <b>GJEPC Web Team,</b>
			  </p>
			 
			</td>
		  </tr>
		  
		</table>';
	  
		 $to = $email;
		 $subject = "FR. photo update notification"; 
		 
		 $cc ="";
		 	send_mail($to,$subject,$messageEmail,$cc);

    echo json_encode(array('status'=>'updateSuccess'));exit; 
   }
 
}

if($action =="visitorEmailOtpAction"){
	$datetime = date("Y-m-d H:i:s");
	$visitor_id =$_SESSION['eid'];
	$email =$_POST['email'];
	$registration_id = $_SESSION['uid'];
	$otp = rand(1000,9999); // generate OTP	
	// $email = getVisitorEmail($visitor_id,$conn);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	  echo json_encode(array('status'=>'error',"message"=>"Enter valid E-mail id "));exit; 
	}
	$sqlEmail  = "SELECT email FROM ivr_registration_details WHERE email='$email' and eid !='$visitor_id'";
	$resultEmail= $conn->query($sqlEmail);
	$countEmail = $resultEmail->num_rows;
	if($countEmail > 0 ){
		echo json_encode(array('status'=>'error',"message"=>"Email id is already exist. "));exit; 
	}




    $messageEmail ='<table cellpadding="10" width="100%" style="margin: 0px auto; font-family: Roboto; background-color: #fff; padding: 30px; border-collapse: collapse; border: 1px solid #000;">
		<tr>
		        <td colspan="3" style="background-color: #a89c5d; padding: 3px;"></td>
		    </tr>
			<tr>
            <td align="left"><img id="ri" src="https://registration.gjepc.org/images/logo.png">
            <td align="center"> <img id="mi"> </td>
            <td align="right"></td>
            </td>                        
		</tr>
		  <tr style="background-color:#eeee;padding:30px;">
		  <td colspan="3">One Time Password for Visitor E-mail Verification is <b>'.$otp.'</b> </td></tr>
		  <tr><td colspan="3"> <p> For Any Queries : </p><b>Email us on :</b> visitors@gjepcindia.com
		 </td></tr> 
		   <tr><td colspan="3">       
			  <p>Kind Regards,<br>
			  <b>GJEPC Web Team,</b>
			  </p>
			 
			</td>
		  </tr>
		  
		</table>';
	  
		 $to = $email;
		 $subject = "Verification code to verify your account"; 
		 // $headers  = 'MIME-Version: 1.0' . "\r\n"; 
		 // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
		 // $headers .= 'From: IIJS SHOW REGISTRATION <admin@gjepc.org>';		
		 // mail($to, $subject, $messageEmail, $headers); //Send OTP ON E-Mail
    // Make verified status zero and update otp
		 $cc ="";
		 	send_mail($to,$subject,$messageEmail,$cc);

		 $update_otp = $conn->query("UPDATE ivr_registration_details SET face_emailOtp ='$otp', face_emailVerified='0', face_checkOtp='1' WHERE uid='$registration_id' AND eid='$visitor_id'");
     
		echo json_encode(array('status'=>'success',"message"=>"OTP ahs been sent successfully "));exit; 
		



}
?>