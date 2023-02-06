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
		$status = $row['application_approved'];
		
		//$checkHistory = "SELECT * FROM `ivr_registration_details` WHERE email='$email_id' AND `application_approved`='Y'";
		/*$checkHistory = "SELECT * FROM `ivr_registration_details` WHERE email='$email_id' AND trade_show ='IIJS 2021'";
		$getQuery = $conn ->query($checkHistory);
		$countVisitor = $getQuery->num_rows;
		$rowx = $getQuery->fetch_assoc();
				
		 if($countVisitor>0){
	    $data = array("status"=>'paymentAlreadyDone');
		echo json_encode($data); exit;
        } */
			
		//if($status =='Y'){
               /*======================CHECK FOR CURRENT EVENT APPLIED START=====================*/
            
            $checkEvent = $conn->query("SELECT * FROM ivr_registration_details WHERE eid='$eid' AND uid='$uid' AND `trade_show`='IIJS SIGNATURE 2022'");
            $countCheckEvent = $checkEvent->num_rows;
            if($countCheckEvent>0){
               /*======================CHECK VACCINE DOSE APPROVAL START=====================*/
          
	            $sqlVaccine = "SELECT * FROM visitor_lab_info WHERE registration_id='$uid' AND visitor_id='$eid' AND category_for='INTL'" ;
				$resultVaccine = $conn->query($sqlVaccine);
				$countVaccine = $resultVaccine->num_rows;
	            if($countVaccine>0){

	            	$rowVaccine = $resultVaccine->fetch_assoc();
				    $vaccine_approval = $rowVaccine['approval_status'];
				    if($vaccine_approval =="P"){
				    	echo  json_encode(array("status"=>'error',"message"=>"Your vaccine certificate approval is pending"));exit;
				    }else if($vaccine_approval =="U"){
				    	echo  json_encode(array("status"=>'error',"message"=>"Your vaccine certificate approval is pending"));exit;
				    }

	            }
				/*=======================CHECK VACCINE DOSE APPROVAL END======================*/
            }
              	/*======================CHECK FOR CURRENT EVENT APPLIED END=====================*/

            
            
			$_SESSION['uid'] = $row['uid'];
			$_SESSION['eid'] = $row['eid'];
			$_SESSION['email'] = $row['email'];
       	$data = array("status"=>'success',"company"=>$company,"mob_no"=>$mob_no,"email"=>$email,"first_name"=>$first_name,"last_name"=>$last_name,"photo"=>$photo,"passport_fid"=>$passport_fid,"visit_card_fid"=>$visit_card_fid,"uid"=>$uid,"designation"=>$designation);
		
		/*
		} else if($status =='N'){
        $message = "Dear ".$first_name.", Kindly update your data";
		$_SESSION['uid'] = $row['uid']; 
        $data = array("status"=>'disapproved');
		} else if($status =='P'){
		$data = array("status"=>'pending');	
		} */	
	} else {
		$data = array("status"=>'notExist');
	}	
	echo json_encode($data);
}

if($action == 'send_otp'){
	
	$email = trim($_REQUEST['emails']);
	$datetime = date("Y-m-d H:i:s");
	$eid = $_SESSION['eid'];
	$uid = $_SESSION['uid'];

	if(isset($email)){
    $sql =  "SELECT email FROM ivr_registration_details WHERE email = '$email' AND eid='$eid' AND uid = '$uid' ";
	$result = $conn->query($sql); 
	$count = $result->num_rows;
    $data = array();
	if($count>0) 
	{
		$otp = rand(1000,9999); // generate OTP			
		$UpdateEmailOtp = $conn->query("UPDATE ivr_registration_details SET otp='$otp',verified ='0' WHERE email='$email' AND eid='$eid' AND uid = '$uid'");
		if($UpdateEmailOtp){
		/*.......................................Send mail to users mail id...............................................*/
	  $message ='<table cellpadding="10" width="100%" style="margin:0px auto;font-family: Roboto; background-color:#fff;padding:30px; border-collapse:collapse;border:1px solid #000">
	<tr><td colspan="2" style="background-color:#a89c5d;padding:3px;"></td></tr>
	<tr>
		<td align="left" >
			
				<img  src="https://registration.gjepc.org/images/logo.png">
			
			
		</td>
		<td align="right">
			
		
				<img  src="https://registration.gjepc.org/images/signature-logo.png">
			
			
		</td>
	</tr>
	<tr >
		<td colspan="2">One Time Password for International Visitor Verification is <b>'.$otp.'</b></td>
	</tr>
	
	<tr>
		<td colspan="2">
			<p> For Any Queries : </p>
			<b>Email us on :</b> snehal.rane@gjepcindia.com, naheed@gjepcindia.com
	    </td>
   </tr>
	<tr><td colspan="2">
			<p>Kind Regards,<br>
				<b>GJEPC Web Team.</b>
			</p>
			
		</td>
	</tr>
</table>';
  
	 $to = $email;
	 $subject = "Verification code to verify your email address"; 
	 $headers  = 'MIME-Version: 1.0' . "\r\n"; 
	 $headers .= 'CC: snehal.rane@gjepcindia.com,naheed@gjepcindia.com' . "\r\n";
	 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
	 $headers .= 'From: IIJS SIGNATURE 2022 SHOW <admin@gjepc.org>';				
	 mail($to, $subject, $message, $headers);
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


if($action == 'singleVisitorRegistration'){
$uid = $_SESSION['uid'];
$eid = $_SESSION['eid'];

if(empty($uid)){  header("location:single_intl_registration.php"); }

$trade_shows = $_REQUEST['trade_show']; 
if(isset($_POST['agree']) && $_POST['agree'] == 'YES'){   $agree = "YES"; } else {  $agree = "NO"; }

if(isset($uid) && $uid!=""){
	$update_query = "update ivr_registration_details set erp_code='single',agree='$agree', trade_show='$trade_shows',photo_approval='P',valid_passport_copy_approval='P',visiting_card_approval='P', modified_date=NOW() where eid='$eid' AND uid='$uid'";	
	$update_result = $conn->query($update_query);
	if($update_result){
	echo json_encode(array('status'=>'virtualSuccess')); exit; 
	}	
} else {
		echo json_encode(array('status'=>'sessionExpired'));exit; 
	}
}

/* Covid */
if($action == 'verify_email_id')
{
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
		$status = $row['application_approved'];
		
		$checkHistory = "SELECT * FROM `ivr_registration_details` WHERE email='$email_id' AND trade_show ='IIJS SIGNATURE 2022' AND `application_approved`='Y'";
		$getQuery = $conn ->query($checkHistory);
		$countVisitor = $getQuery->num_rows;
		$rowx = $getQuery->fetch_assoc();
				
		if($countVisitor>0){
			
		if($status =='Y'){
			$_SESSION['uid'] = $row['uid'];
			$_SESSION['eid'] = $row['eid'];
       	$data = array("status"=>'success',"company"=>$company,"mob_no"=>$mob_no,"email"=>$email,"first_name"=>$first_name,"last_name"=>$last_name,"photo"=>$photo,"passport_fid"=>$passport_fid,"visit_card_fid"=>$visit_card_fid,"uid"=>$uid,"designation"=>$designation);
		
       	/* print_r($data);exit;*/
		} else if($status =='N'){
        $message = "Dear ".$first_name.", Kindly update your data";
		$_SESSION['uid'] = $row['uid']; 
        $data = array("status"=>'disapproved');
		} else if($status =='P'){
		$data = array("status"=>'pending');	
		}
		} else { 
			$data = array("status"=>'notApplied');
			echo json_encode($data); exit;
		}
	} else {
		$data = array("status"=>'notExist');
	}	
	echo json_encode($data);
}

if(isset($_POST['action']) && $_POST['action']=="UpdateCovidReport")
{
	//echo '<pre>';  print_r($_POST); exit;	
function uploadIntlVIsitor($file_name,$file_temp,$file_type,$file_size,$id,$name)
{
	$upload_image = '';
	$target_folder = 'images/covid/intl/'.$_SESSION['uid'].'/'.$name.'/';
	//$filename="images/employee_directory/".$_SESSION['USERID'];
	$target_path = "";
	$user_id = $_SESSION['uid'];
	$file_name = str_replace(" ","_",$file_name);
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
    echo "Sorry something error while uploading..."; exit;
	}
	else if($file_name != '')
	{
		if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "application/pdf")) && $file_size < 2097152)
		{
			$random_name = rand();
			 $target_path = $target_folder.$user_id.'_'.$id.'_'.$name.'_'.$random_name.$file_name;
			if(@move_uploaded_file($file_temp, $target_path))
			{
				  $upload_image = $user_id.'_'.$id.'_'.$name.'_'.$random_name.$file_name;
			}
			else
			{
				 $upload_image = "fail";
			}
		}
		else
		{
			 $upload_image = "invalid";
		}	
	}
	return $upload_image;
}

	$uid = $_POST['uid'];
	$eid = $_POST['eid'];
	$via = 'self'; 
	$email = $_SESSION['email'];
	
	$self_declaration ="Negative";
	$certificate = $_POST['valueType'];
	
	if(empty($uid && $eid)){
	 echo json_encode(array("status"=>"error","message"=>"Your session has been expired.")); exit;
	}

	$create_directory = 'images/covid/intl/'.$_SESSION['uid'];
		if(!file_exists($create_directory)) {
		mkdir($create_directory, 0777);
	}

		 	if(isset($_FILES['vaccine_certificate']) && $_FILES['vaccine_certificate']['name']!="")
			{				
				$self_report_name=$_FILES['vaccine_certificate']['name'];
				$self_report_temp=$_FILES['vaccine_certificate']['tmp_name'];
				$self_report_type=$_FILES['vaccine_certificate']['type'];
				$self_report_size=$_FILES['vaccine_certificate']['size'];
				
				$attach="vaccine_certificate";
				if($self_report_name!="")
				{
				    $create_self_report = 'images/covid/intl/'.$_SESSION['uid'].'/'.$attach;
					if(!file_exists($create_self_report)) {
					mkdir($create_self_report, 0777);
					}
					 
					$vaccine_certificate=uploadIntlVIsitor($self_report_name,$self_report_temp,$self_report_type,$self_report_size,$eid,$attach);
					if($vaccine_certificate =="fail") {
					 	echo json_encode(array('status'=>'error',"message"=>"Sorry, report uploading has been failed on server. Please contact administrator"));exit; 
					} elseif ($vaccine_certificate =="invalid") {
					 	echo json_encode(array('status'=>'error',"message"=>"Please Select valid file type"));exit; 					 
					 }
				} else {
					echo json_encode(array("status"=>"error","message"=>"Please Select covid report"));exit;
				}
			} else {
				echo json_encode(array("status"=>"error","message"=>"Please Select covid report"));exit;
			}
	
	/*DETECT DEVICE to redirect*/

	$isMobile= preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);

	if($isMobile){
		$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
		$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
		$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
		$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");

		if( $iPod || $iPhone || $iPad ){
		    $device = "ios";
		}else{
		    $device = "android";
		}
	} else {
	    $device = "desktop";
	}
 
	$datetime = date("Y-m-d H:i:s");
	
	/*======================= SEND SMS AFTER UPLOAD CERTIFICATE  ===================*/
	/*.......................................Send mail to users mail id...............................................*/
	  $message ='<table cellpadding="10" width="65%" style="margin:0px auto;font-family: Roboto; background-color:#eeee;padding:30px; border-collapse:collapse;">
	<tr><td style="background-color:#744F9E;padding:3px;"></td></tr>
	  <tr>
            <td align="left">
            	<div style="float: left;">
            	<img id="ri" src="https://registration.gjepc.org/images/logo.png">            		
            	</div>
                <div style="float: right;">
               	<img id="ri" src="https://registration.gjepc.org/images/signature-logo.png">
               </div>
               <div style="clear:both;"></div>        
            </td>                        
		</tr>
	  <tr style="background-color:#eeee;padding:30px;">
	  <td>Your Vaccination Certificate has been uploaded successfully. We will notify you on approval/disapproval of the document.</td></tr>
	   <tr><td>       
		  <p>Kind Regards,<br>
		  <b>GJEPC Web Team,</b>
		  </p>
		  <p> For Any Queries : </p>
		</td>
	  </tr>
	   <tr><td><b>Email us on :</b> snehal.rane@gjepcindia.com; naheed@gjepcindia.com
	 </td></tr> 
	</table>';
  
	 $to = $email.',naheed@gjepcindia.com';
	 $subject = "Your Vaccination Certificate has been uploaded successfully"; 
	 $headers  = 'MIME-Version: 1.0' . "\r\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
	 $headers .= 'From: IIJS SIGNATURE 2022 SHOW<admin@gjepc.org>';				
	 mail($to, $subject, $message, $headers);
	 
    /*==============================SHOW MESSAGE AFTER UPLOAD CERTIFICATE=============================*/
	
	/*==============================SHOW MESSAGE AFTER UPLOAD CERTIFICATE=============================*/
    if($certificate =='dose1'){
    	$messagev = "It is compulsory to carry Covid-19 Negative Report (RT PCR Test) done before 72 hrs before your first visit at IIJS SIGNATURE 2022.";
    } else {
    	$messagev = "Please download your E-badge from GJEPC app post approval of your final vaccination certificate.";
    }
	
	$checkData = "SELECT * FROM visitor_lab_info WHERE registration_id='$uid' AND visitor_id='$eid' AND category_for='INTL'";
	$resultData = $conn->query($checkData);
	$countData =  $resultData->num_rows;
	if($countData > 0){
		if($certificate =='dose1'){
            $updateData =  $conn->query("UPDATE visitor_lab_info SET `dose1`='$vaccine_certificate',`certificate`='$certificate',`approval_status`='U',`dose1_status`='U',`modified_at`='$datetime' WHERE registration_id='$uid' AND visitor_id='$eid' AND category_for='INTL'");
		} else {
            $updateData =  $conn->query("UPDATE visitor_lab_info SET `dose2`='$vaccine_certificate',`certificate`='$certificate',`approval_status`='U',`dose2_status`='U',`modified_at`='$datetime' WHERE registration_id='$uid' AND visitor_id='$eid' AND category_for='INTL'");
		} 
		$ansData = $conn ->query($updateData);
        unset($_SESSION['uid']);
        unset($_SESSION['eid']);
        unset($_SESSION['email']);
        echo json_encode($data = array("status"=>'success',"device"=>$device,"message"=>$messagev,)); exit;
	} else {
		
		if($certificate =='dose1'){
        $sqlx = "INSERT INTO `visitor_lab_info` (`registration_id`, `visitor_id`, `pan_no`, `mobile_no`,`email`, `via`,`certificate`,`dose1`, `status`,`approval_status`,`dose1_status`,`category_for`,`event`) VALUES ('$uid', '$eid', '$eid', '$eid','$email', '$via','$certificate','$vaccine_certificate','1','P','P','INTL','signature22')";
		} else {
        $sqlx = "INSERT INTO `visitor_lab_info` (`registration_id`, `visitor_id`, `pan_no`, `mobile_no`,`email`, `via`,`certificate`,`dose2`, `status`,`approval_status`,`dose1_status`,`category_for`,`event`) VALUES ('$uid', '$eid', '$eid', '$eid', '$email','$via','$certificate','$vaccine_certificate','1','P','P','INTL','signature22')";
		}
		
	    $ansData = $conn ->query($sqlx);
		unset($_SESSION['uid']);
        unset($_SESSION['eid']);
		unset($_SESSION['email']);
	    echo json_encode($data = array("status"=>'success',"device"=>$device,"message"=>$messagev)); exit;
	}
	
}
?>