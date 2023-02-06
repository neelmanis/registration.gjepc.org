<?php
include ("db.inc.php");
include ("functions.php");
session_start();

$action = $_REQUEST['action'];
if($action == 'pan_number'){
	$pan_number = trim($_REQUEST['pan_no']);
	$sql =  "SELECT * FROM visitor_directory WHERE pan_no='$pan_number' order by visitor_approval limit 1";
	$result = $conn ->query($sql); 
	$count = $result->num_rows;
  
    $data = array();
	if($count>0) 
	{
		$row = $result->fetch_assoc(); 
		$company = strtoupper(str_replace('&amp;', '&', getCompanyName($row['registration_id'],$conn)));
		$isSecondary  = $row['isSecondary'];
		if($isSecondary  =="Y"){
        	$mobile = $row['secondary_mobile'];
		}else{
	        $mobile = $row['mobile'];
		}
		
		$email = $row['email'];
		$designation = getVisitorDesignationID($row['designation'],$conn);
		$name = $row['name'];
		$lname = $row['lname'];
		$photo = $row['photo'];
		$registration_id = $row['registration_id'];
		$visitor_id = $row['visitor_id'];
		$status = $row['visitor_approval'];
		$combo = $row['combo'];
		$visitorID = $row['visitor_id']; 
  
        $_SESSION['isMobileVerified'] = "NO";
        $_SESSION['requestFor'] = "";

		$sqlData = "select * from registration_master where id='$registration_id' AND approval_status='D'";
        $ansData = $conn ->query($sqlData);
        $rowData=$ansData->num_rows;
        if($rowData>0){
	    echo json_encode($data = array("status"=>'companyData')); exit;
        }
		// $newx = "SELECT * from visitor_directory where pan_no='$pan_number' AND visitor_approval='Y'";
		// $query=$conn ->query($newx);
		// $lettersinDB = array();
		// 	while($rows = $query->fetch_assoc()){
		// 	array_push($lettersinDB,array('visitor_id'=>$rows['visitor_id'],'name'=>$rows['name']));
		// }

		//  $checkHistory = "SELECT * FROM `visitor_order_history` WHERE visitor_id='$visitorID' AND (payment_made_for='signature2') AND `status`='1' AND payment_status='Y'";exit;
		// $getQuery = $conn ->query($checkHistory);
		// $checkResult = $getQuery->num_rows;
		// $gotcommaid = array();
		// while($checkQuery = $getQuery->fetch_assoc()){
		// 	array_push($gotcommaid,explode(",",$checkQuery['visitor_id']));															
		// }
		// $finalvisitoridarray = array();
		// foreach($gotcommaid as $k => $v){
		// 	$finalvisitoridarray = array_merge($finalvisitoridarray,$v);
		// }
        
		if($status =='Y'){
			
			/*======================CHECK VACCINE DOSE APPROVAL START=====================*/

            $sqlVaccine = "SELECT * FROM visitor_lab_info WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'" ;
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

            /*==========================CHECK PAYMENT HISTORY START========================*/

   //          $checkHistory = "SELECT * FROM `visitor_order_history` WHERE visitor_id='$visitorID' AND (payment_made_for='signature22' OR payment_made_for='igjme22' ) AND `status`='1' AND payment_status='Y'";			 
			// $getQuery = $conn ->query($checkHistory);
			// $checkResult = $getQuery->num_rows;

			// if($checkResult > 0){
   //              $_SESSION['registration_id'] = $row['registration_id']; 
			// 	$_SESSION['visitor_id'] = $row['visitor_id'];
	  //      	    $data = array("status"=>'success',"company"=>$company, "mobile"=>$mobile,"email"=>$email,"name"=>$name,"lname"=>$lname,"photo"=>$photo,"reg_id"=>$registration_id,"designation"=>$designation);
	  //      	    echo json_encode($data); exit;
			// }else{
   //              $data = array("status"=>'paymentNotDone');
			// 	echo json_encode($data); exit;
			// }

			$_SESSION['registration_id'] = $row['registration_id']; 
				$_SESSION['visitor_id'] = $row['visitor_id'];
	       	    $data = array("status"=>'success',"company"=>$company, "mobile"=>$mobile,"email"=>$email,"name"=>$name,"lname"=>$lname,"photo"=>$photo,"reg_id"=>$registration_id,"designation"=>$designation);
	       	    echo json_encode($data); exit;

            /*==========================CHECK PAYMENT HISTORY END==========================*/
			
		}else if($status =='D'){
	        $message = "Dear ".$name.", Kindly update your data";		
			//get_data($message,$mobile_no);
			$_SESSION['registration_id'] = $row['registration_id']; 
			$_SESSION['visitor_id'] = $row['visitor_id'];
	        $data = array("status"=>'disapproved');
		}else if($status =='P'){
			$data = array("status"=>'pending');	
		}else if($status =='U'){
			$data = array("status"=>'updated');	
		}
	} else {
		$data = array("status"=>'notExist');
	}	
	echo json_encode($data);
}

if($action == 'send_otp'){
	$mobile_no = trim($_REQUEST['mobile_no']);
	$secondary_mobile = trim($_REQUEST['secondary_mobile']);

	$datetime = date("Y-m-d H:i:s");
	$visitor_id =$_SESSION['visitor_id'];
	$registration_id = $_SESSION['registration_id'];

	/*=========================CHECK SECONDARY MOBILE FLAG================================*/

	$visData = $conn->query("SELECT * FROM visitor_directory WHERE visitor_id='$visitor_id' AND registration_id='$registration_id'");
	$rowData = $visData->fetch_assoc();
	$isSecondary = $rowData['isSecondary'];

	if($isSecondary  =="Y"){
        $mobile_no = $rowData['secondary_mobile'];
         $sql =  "SELECT mobile FROM visitor_directory WHERE secondary_mobile = '$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id' ";
	}else{
        $mobile_no = $rowData['mobile'];
         $sql =  "SELECT mobile FROM visitor_directory WHERE mobile = '$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id' ";
	}
   
	$result = $conn->query($sql); 
	$count = $result->num_rows;
    $data = array();

	if($count>0) 
	{
		$otp = rand(1000,9999); // generate OTP	
		/* $message = "One Time Password for Visitor Verification is ".$otp.", Regards GJEPC";
		$otp_sendStatus = get_data($message,$mobile_no); // Send OTP */
		$message = "One Time Password for Pan Number Verification is ".$otp." Regards GJEPC";
		$otp_sendStatus = send_sms($message,$mobile_no);
		if($otp_sendStatus){
      
			 $getMobile = "SELECT mobile_no FROM visitor_mobileotpverification WHERE mobile_no='$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id'";
			  $getMobileResult = $conn->query($getMobile);
			  $countMobile = $getMobileResult->num_rows;
			 /*echo "INSERT INTO visitor_mobileotpverification SET mobile_no='$mobile_no',otp='$otp',verified ='0',post_date='$datetime'";exit;*/
			 if($countMobile>0){

             $UpdateMobileOtp = $conn->query("UPDATE visitor_mobileotpverification SET otp='$otp',verified ='0',modifiedDate='$datetime'WHERE mobile_no='$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id'");
		    
			 }else{
               $InsertMobileOtp = $conn->query("INSERT INTO visitor_mobileotpverification SET mobile_no='$mobile_no',otp='$otp',verified ='0',post_date='$datetime',registration_id='$registration_id',visitor_id='$visitor_id'");
			 }
			$data = array("status"=>'successOtp',"mobile_no"=>"$mobile_no");
		}
	} else {
		$data = array("status"=>'error');
	}

echo json_encode($data);
}


if($action == 'verifyOTP'){

	$_SESSION['isMobileVerified'] = "NO";
    $_SESSION['requestFor'] = "";
	$visitor_id =$_SESSION['visitor_id'];
	$registration_id = $_SESSION['registration_id'];
	$otpNumber = trim($_REQUEST['otp_number']);
    $mobile_no_otp = trim($_REQUEST['mobile_no_otp']);
	$post_date = date("Y-m-d H:i:s");
    $sql  = "SELECT * FROM visitor_mobileotpverification WHERE otp='$otpNumber' AND mobile_no='$mobile_no_otp' AND visitor_id='$visitor_id' AND registration_id = '$registration_id'";
    $result = $conn->query($sql); 
    $count = $result->num_rows;
    if($count==1){
		$otpUpdate = "UPDATE visitor_mobileotpverification SET verified='1', modifiedDate='$post_date' WHERE otp='$otpNumber' AND mobile_no='$mobile_no_otp' AND visitor_id='$visitor_id' AND registration_id = '$registration_id' ";
	    $otpUpdateResult = $conn->query($otpUpdate);
 
    $_SESSION['isMobileVerified'] = "YES";
    $_SESSION['requestFor'] = "covid-report";
    $data = array("status"=>'success');
   
    }else{
    	$data = array("status"=>'fail');
    }
    
    echo json_encode($data); 
}

if(isset($_POST['action']) && $_POST['action']=="UpdateCovidReport")
{
	//echo '<pre>';  print_r($_POST); exit;	
	$registration_id = $_POST['registration_id'];
	$visitor_id = $_POST['visitor_id'];
	$pan_no = $_POST['pan_no'];
	$mobile_no = $_POST['mobile_no'];
	$certificate = $_POST['valueType'];
	$via="self";
	$visitor_email = getVisitorEmail($visitor_id,$conn); 
	$CompanyName = getCompanyName($registration_id,$conn); 
	$visitorName = getVisitorName($visitor_id,$conn);
	$category_for = "VIS";
	if(empty($registration_id) && empty($visitor_id)){
	 echo json_encode(array("status"=>"error","message"=>"Your session has been expired."));exit;
	}
    
	//$category_for = getVisitorSelectedShow($visitor_id,$conn);
	
	// if($category_for =="igjme22"){
 //    $category_for = "IGJME";
	// }else{
 //    $category_for ="VIS";
	// }
	

	$create_directory = 'images/covid/vis/'.$_SESSION['registration_id'];
		if(!file_exists($create_directory)) {
		mkdir($create_directory, 0777);
	}
 
 	if(isset($_FILES['vaccine_certificate']) && $_FILES['vaccine_certificate']['name']!=""){
		
		$vaccine_certificate_name=$_FILES['vaccine_certificate']['name'];
		$vaccine_certificate_temp=$_FILES['vaccine_certificate']['tmp_name'];
		$vaccine_certificate_type=$_FILES['vaccine_certificate']['type'];
		$vaccine_certificate_size=$_FILES['vaccine_certificate']['size'];

		$attach="vaccine_certificate";
		if($vaccine_certificate_name!="")
		{
		     $create_vaccine_certificate = 'images/covid/vis/'.$_SESSION['registration_id'].'/'.$attach;
			if (!file_exists($create_vaccine_certificate)) {
			mkdir($create_vaccine_certificate, 0777);
			}
			  $vaccine_certificate=uploadSingleVIsitorCovid($vaccine_certificate_name,$vaccine_certificate_temp,$vaccine_certificate_type,$vaccine_certificate_size,$mobile_no,$attach,$certificate);
			 if ($vaccine_certificate =="fail") {
			 	echo json_encode(array('status'=>'error',"message"=>"Sorry, report uploading has been failed on server. Please contact administrator"));exit; 
			 }elseif ($vaccine_certificate =="invalid") {
			 	echo json_encode(array('status'=>'error',"message"=>"Please Select valid file type"));exit; 
			 
			 }
		}else{
			echo json_encode(array("status"=>"error","message"=>"Please Select covid vaccination certificate"));exit;
		}
	}else{
		echo json_encode(array("status"=>"error","message"=>"Please Select covid vaccination certificate"));exit;
	}

	
    $checkData = "SELECT * FROM visitor_lab_info WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'" ;
	$resultData =$conn->query($checkData);
	$countData =  $resultData->num_rows;
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

	}else{
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
	$cert = "Vaccination Certificate";
	$website = "visitor badge";
    $smsContent ="Your ".$cert." has been uploaded successfully for ".$website." .We will notify you on approval/disapproval. Regards, GJEPC";
    //get_data($smsContent,$mobile_no);
   
	
    /*==============================SHOW MESSAGE AFTER UPLOAD CERTIFICATE=============================*/

    if($certificate =='dose1'){
    	//$messagev = "It is compulsory to carry Covid-19 Negative Report (RT PCR Test) done before 72 hrs before your first visit at IIJS SIGNATURE 2022.";
    	$messagev = "All the visitors visiting the exhibition should be fully vaccinated.";
    }else{
    	$messagev = "We will update you on vaccination certificate approval soon.";
    }
    
	if($countData > 0){
		if($certificate =='booster_dose'){
			 $sqlx = "UPDATE visitor_lab_info SET `booster_dose`='$vaccine_certificate',`certificate`='$certificate',`approval_status`='U',
			 `booster_dose_status`='U',`modified_at`='$datetime' WHERE registration_id='$registration_id' AND visitor_id='$visitor_id' AND `category_for`='$category_for'";
            

		} else {
			 $sqlx = "UPDATE visitor_lab_info SET `dose2`='$vaccine_certificate',`certificate`='$certificate',`approval_status`='U',`dose2_status`='U',`modified_at`='$datetime' WHERE registration_id='$registration_id' AND visitor_id='$visitor_id' AND `category_for`='$category_for'";;
            
		} 
		$ansData = $conn ->query($sqlx);
		if($ansData){
			send_sms($smsContent,$mobile_no);
	 		unset($_SESSION['registration_id']);
	        unset($_SESSION['visitor_id']);
        	echo json_encode($data = array("status"=>'success',"device"=>$device,"message"=>$messagev,)); exit;
		}else{
			echo json_encode($data = array("status"=>'error',"message"=>$conn->error)); exit;
		}
       
	}else{

		if($certificate =='booster_dose'){

         $sqlx = "INSERT INTO `visitor_lab_info` (`registration_id`, `visitor_id`, `pan_no`, `mobile_no`, `via`,`certificate`,`booster_dose`, `status`,`approval_status`,`booster_dose_status`,`category_for`,`event`) VALUES ('$registration_id', '$visitor_id', '$pan_no', '$mobile_no', '$via','$certificate','$vaccine_certificate','1','P','P','$category_for','$show')";

		} else {

         $sqlx = "INSERT INTO `visitor_lab_info` (`registration_id`, `visitor_id`, `pan_no`, `mobile_no`, `via`,`certificate`,`dose2`, `status`,`approval_status`,`dose1_status`,`category_for`,`event`) VALUES ('$registration_id', '$visitor_id', '$pan_no', '$mobile_no', '$via','$certificate','$vaccine_certificate','1','P','P','$category_for','$show')";

		}

	    $ansData = $conn ->query($sqlx);
	     
	    
	    if($ansData){
			send_sms($smsContent,$mobile_no);
	 		unset($_SESSION['registration_id']);
	        unset($_SESSION['visitor_id']);
	    	echo json_encode($data = array("status"=>'success',"device"=>$device,"message"=>$messagev)); exit;
		}else{
			echo json_encode($data = array("status"=>'error',"message"=>$conn->error)); exit;
		}
	    
	}
}

function valid_email($str) {
return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}
?>