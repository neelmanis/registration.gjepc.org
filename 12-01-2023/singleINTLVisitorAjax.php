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
		$checkHistory = "SELECT * FROM `ivr_registration_history` WHERE visitor_id='$eid' AND registration_id='$uid' AND payment_made_for ='signature22'";
		$getQuery = $conn ->query($checkHistory);
		$countVisitor = $getQuery->num_rows;
		$rowx = $getQuery->fetch_assoc();
				
		// if($countVisitor>0){
	    //$data = array("status"=>'paymentAlreadyDone');
	    //$data = array("status"=>'error',"message"=>"You are already registered for this show.Kindly upload your vaccination certificate from below link");
		//	echo json_encode($data); exit;
        //} 
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
	  $message ='<table cellpadding="10" width="100%" style="margin:0px auto;font-family: Roboto; background-color:#fff;padding:30px; border-collapse:collapse;border:1px solid #000"><tr><td colspan="2" style="background-color:#a89c5d;padding:3px;"></td></tr><tr><td align="left" ><img src="https://registration.gjepc.org/images/logo.png"></td><td align="right"></td></tr><tr ><td colspan="2">Dear '.$company_name .',</td></tr><tr ><td colspan="2">One Time Password for International Visitor Verification is <b>'.$otp.'</b></td></tr><tr><td colspan="2"><p> For Any Queries : </p><b>Email us on :</b>  naheed@gjepcindia.com </td></tr><tr><td colspan="2"><p>Kind Regards,<br><b>GJEPC Web Team.</b></p></td></tr></table>';
  
	 $to = $email;
	 $cc = "naheed@gjepcindia.com,daphne.dcosta@gjepcindia.com";
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


if($action == 'singleVisitorRegistration'){
$uid = $_SESSION['uid'];
$eid = $_SESSION['eid'];

if(empty($uid)){  header("location:single_intl_registration.php"); }

$trade_shows = $_REQUEST['trade_show']; 


//CHECK FOR ALREADY REGISTERED VISITOR
$sql_history = "SELECT * FROM ivr_registration_history WHERE visitor_id='$eid' AND registration_id='$uid' AND payment_made_for='$trade_shows' AND payment_status='Y'";
$result_history = $conn->query($sql_history);
$count_history = $result_history->num_rows;

if($count_history >0){
	echo json_encode(array("status"=>"error","message"=>"You are already registered for this show"));exit;
} 

$sql_check_event = "SELECT * FROM visitor_event_master WHERE `shortcode` = '$trade_shows' AND `status`='1' ";
$result_check_event= $conn->query($sql_check_event);
$count_check_event = $result_check_event->num_rows;
if($count_check_event > 0){
	$row_check_event = $result_check_event->fetch_assoc();
    $show = $_SESSION['show'] =  $row_check_event['shortcode'];
	$year = $_SESSION['year'] =  $row_check_event['year'];
	
}else{
	echo json_encode(array("status"=>"error","message"=>"Sorry show registration is closed"));exit;
}

if(isset($_POST['agree']) && $_POST['agree'] == 'YES'){   $agree = "YES"; } else {  $agree = "NO"; }

if(isset($uid) && $uid!=""){
	 $insert_query = "INSERT INTO `ivr_registration_history` set `registration_id`='$uid',`visitor_id`='$eid',`payment_made_for`= '$trade_shows', `amount`='0',`show`='$trade_shows',`year`='$year', `payment_status`='Y', `paymentThrough`='single',`badge_status`='P', `status`='1'";
	$update_result = $conn->query($insert_query);
	if($update_result){
	echo json_encode(array('status'=>'success')); exit; 
	}	
} else {
		echo json_encode(array("status"=>"error","message"=>"Session is expired"));exit; 
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
		// GET CURRENT SHOW INFO
	$sql_check_event = "SELECT * FROM visitor_event_master WHERE `status` = '1' AND `isParentShow`='1' ";
	$result_check_event= $conn->query($sql_check_event);
    $count_check_event = $result_check_event->num_rows;
	if($count_check_event > 0){
	$row_check_event = $result_check_event->fetch_assoc();
    $show =  $row_check_event['shortcode'];
	$year =  $row_check_event['year'];
		
	}else{
		echo json_encode($data = array("status"=>'error',"message"=>"EVENT IS NOT ACTIVE")); exit;
	} 
	
	/*======================= SEND SMS AFTER UPLOAD CERTIFICATE  ===================*/
	/*.......................................Send mail to users mail id...............................................*/
	  $message ='<table cellpadding="10" width="65%" style="margin:0px auto;font-family: Roboto; background-color:#eeee;padding:30px; border-collapse:collapse;">
	<tr><td style="background-color:#744F9E;padding:3px;"></td></tr>
	  <tr>
            <td align="left">
            	<div style="float: left;">
            	<img id="ri" src="https://registration.gjepc.org/images/logo.png">            		
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
	 //$to = 'santosh@kwebmaker.com';
	 $subject = "International Vaccination Certificate Upload"; 
	 $headers  = 'MIME-Version: 1.0' . "\r\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
	 $headers .= 'From: IIJS SHOW<admin@gjepc.org>';				
	
	 
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

		if($certificate =='booster_dose'){
			$sqlx = "UPDATE visitor_lab_info SET `booster_dose`='$vaccine_certificate',`certificate`='$certificate',`approval_status`='U',`booster_dose_status`='U',`modified_at`='$datetime' WHERE registration_id='$uid' AND visitor_id='$eid' AND category_for='INTL'";
            
		} else {
			$sqlx = "UPDATE visitor_lab_info SET `dose2`='$vaccine_certificate',`certificate`='$certificate',`approval_status`='U',`dose2_status`='U',`modified_at`='$datetime' WHERE registration_id='$uid' AND visitor_id='$eid' AND category_for='INTL'";
           
		} 
		$ansData = $conn ->query($sqlx);
		if($ansData){
		mail($to, $subject, $message, $headers);	
        unset($_SESSION['uid']);
        unset($_SESSION['eid']);
        unset($_SESSION['email']);

        	echo json_encode($data = array("status"=>'success',"device"=>$device,"message"=>$messagev,)); exit;
        }else{
        	echo json_encode($data = array("status"=>'error',"message"=>$conn->error)); exit;
        }
        
	} else {
		
		if($certificate =='booster_dose'){
        $sqlx = "INSERT INTO `visitor_lab_info` (`registration_id`, `visitor_id`, `pan_no`, `mobile_no`,`email`, `via`,`certificate`,`booster_dose`, `status`,`approval_status`,`booster_dose_status`,`category_for`,`event`) VALUES ('$uid', '$eid', '$eid', '$eid','$email', '$via','$certificate','$vaccine_certificate','1','P','P','INTL','signature22')";
		} else {
        $sqlx = "INSERT INTO `visitor_lab_info` (`registration_id`, `visitor_id`, `pan_no`, `mobile_no`,`email`, `via`,`certificate`,`dose2`, `status`,`approval_status`,`dose2_status`,`category_for`,`event`) VALUES ('$uid', '$eid', '$eid', '$eid', '$email','$via','$certificate','$vaccine_certificate','1','P','P','INTL','signature22')";
		}
		
	    $ansData = $conn ->query($sqlx);
	    if($ansData){
	    mail($to, $subject, $message, $headers);
	        unset($_SESSION['uid']);
	        unset($_SESSION['eid']);
			unset($_SESSION['email']);
		    echo json_encode($data = array("status"=>'success',"device"=>$device,"message"=>$messagev)); exit;	
	    }else{
	    	echo json_encode($data = array("status"=>'error',"message"=>$conn->error)); exit;
	    }
		
	}
	
}
?>