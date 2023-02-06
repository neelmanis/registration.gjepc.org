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
		$mobile = trim($row['mobile']);
		$email = $row['email'];
		$designation = getVisitorDesignationID($row['designation'],$conn);
		$name = $row['name'];
		$lname = $row['lname'];
		$photo = $row['photo'];
		$reg_id = $row['registration_id'];
		$status = $row['visitor_approval'];
		$combo = $row['combo'];
		$visitorID = $row['visitor_id']; 
        $registration_id = intval(filter($row['registration_id']));
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

              $checkHistory = "SELECT * FROM `visitor_order_history` WHERE visitor_id='$visitorID' AND (payment_made_for='signature2') AND `status`='1' AND payment_status='Y'";
			$getQuery = $conn ->query($checkHistory);
			$checkResult = $getQuery->num_rows;

			if($checkResult > 0){
                $_SESSION['registration_id'] = $row['registration_id']; 
				$_SESSION['visitor_id'] = $row['visitor_id'];
	       	    $data = array("status"=>'success',"company"=>$company, "mobile"=>$mobile,"email"=>$email,"name"=>$name,"lname"=>$lname,"photo"=>$photo,"reg_id"=>$reg_id,"designation"=>$designation);
	       	    echo json_encode($data); exit;
			}else{
                $data = array("status"=>'paymentNotDone');
				echo json_encode($data); exit;
			}
			
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
	$is_secondary = trim($_REQUEST['is_secondary']);
    $_SESSION['is_secondary'] = $is_secondary;
	$datetime = date("Y-m-d H:i:s");
	$visitor_id =$_SESSION['visitor_id'];
	$registration_id = $_SESSION['registration_id'];

	if(isset($is_secondary) && $is_secondary == 'Y'){   
		$mobile_no = trim($_REQUEST['secondary_mobile']);
	} else {  
		$mobile_no = trim($_REQUEST['mobile_no']);
	}

	if(isset($is_secondary) && $is_secondary == 'Y'){
		
		if(filter($_REQUEST['secondary_mobile']) =="" && empty(filter($_REQUEST['secondary_mobile'])) ){

         $data = array("status"=>'secondaryEmpty');
         echo json_encode($data);exit;
		}
		$sqlb =  "SELECT secondary_mobile FROM visitor_directory WHERE (secondary_mobile = '".$_REQUEST['secondary_mobile']."' OR mobile = '".$_REQUEST['secondary_mobile']."')";
		$resultb = $conn->query($sqlb); 
		$countb = $resultb->num_rows;
		if($countb>0) 
		{
		 $data = array("status"=>'errorAlready');
		  
		} else {
        $otp = rand(1000,9999); // generate OTP	
	    $message = "One Time Password for Visitor Verification is ".$otp.", Regards GJEPC";
		$otp_sendStatus = get_data($message,$mobile_no); // Send OTP
		if($otp_sendStatus){
      
			$getMobile = "SELECT mobile_no FROM visitor_mobileotpverification WHERE mobile_no='$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id'";
			  $getMobileResult = $conn->query($getMobile);
			  $countMobile = $getMobileResult->num_rows;
			 /*echo "INSERT INTO visitor_mobileotpverification SET mobile_no='$mobile_no',otp='$otp',verified ='0',post_date='$datetime'";exit;*/
			 if($countMobile>0){

             $UpdateMobileOtp = $conn->query("UPDATE visitor_mobileotpverification SET otp='$otp',verified ='0',modifiedDate='$datetime',isSecondary='$is_secondary' WHERE mobile_no='$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id'");
		    
			 }else{
			 	// echo "INSERT INTO visitor_mobileotpverification SET mobile_no='$mobile_no',otp='$otp',verified ='0',post_date='$datetime',registration_id='$registration_id',visitor_id='$visitor_id',isSecondary='$is_secondary'";exit;
               $InsertMobileOtp = $conn->query("INSERT INTO visitor_mobileotpverification SET mobile_no='$mobile_no',otp='$otp',verified ='0',post_date='$datetime',registration_id='$registration_id',visitor_id='$visitor_id',isSecondary='$is_secondary'");
			 }
			$data = array("status"=>'successOtp',"mobile_no"=>"$mobile_no");
		}
		}
	} else {
   $sql =  "SELECT mobile FROM visitor_directory WHERE mobile = '$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id' ";
	$result = $conn->query($sql); 
	$count = $result->num_rows;
    $data = array();
	if($count>0) 
	{

		$otp = rand(1000,9999); // generate OTP	
		$message = "One Time Password for Visitor Verification is ".$otp.", Regards GJEPC";
		$otp_sendStatus = get_data($message,$mobile_no); // Send OTP
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
   if($_SESSION['is_secondary'] =="Y"){
    $updateSecondary =  $conn->query("UPDATE visitor_directory SET secondary_mobile='$mobile_no_otp' WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'");
   }
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
	$via = 'self';
	// $lab_name = $_POST['labs'];
	// $location = $_POST['location'];
	$self_declaration ="Negative";
	$certificate = $_POST['certificate'];
	
	if(empty($registration_id && $visitor_id)){
	 echo json_encode(array("status"=>"error","message"=>"Your session has been expired."));exit;
	}

	$create_directory = 'images/covid/vis/'.$_SESSION['registration_id'];
		if(!file_exists($create_directory)) {
		mkdir($create_directory, 0777);
	}
    // $self_report="";
	// if($via =="self"){
		 	if(isset($_FILES['self_report']) && $_FILES['self_report']['name']!=""){
				
				$self_report_name=$_FILES['self_report']['name'];
				$self_report_temp=$_FILES['self_report']['tmp_name'];
				$self_report_type=$_FILES['self_report']['type'];
				$self_report_size=$_FILES['self_report']['size'];
				/*$id = $_SESSION['visitor_id'];*/
				$attach="self_report";
				if($self_report_name!="")
				{
				     $create_self_report = 'images/covid/vis/'.$_SESSION['registration_id'].'/'.$attach;
					if (!file_exists($create_self_report)) {
					mkdir($create_self_report, 0777);
					}
					  $self_report=uploadSingleVIsitorCovid($self_report_name,$self_report_temp,$self_report_type,$self_report_size,$mobile_no,$attach);
					 if ($self_report =="fail") {
					 	echo json_encode(array('status'=>'error',"message"=>"Sorry, report uploading has been failed on server. Please contact administrator"));exit; 
					 }elseif ($self_report =="invalid") {
					 	echo json_encode(array('status'=>'error',"message"=>"Please Select valid file type"));exit; 
					 
					 }
				}else{
					echo json_encode(array("status"=>"error","message"=>"Please Select covid report"));exit;
				}
			}else{
				echo json_encode(array("status"=>"error","message"=>"Please Select covid report"));exit;
			}

	// }
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
	if($countData > 0){
		 
        $updateData =  $conn->query("UPDATE visitor_lab_info SET via='$via',self_report='$self_report',`self_declaration`='$self_declaration',`certificate`='$certificate',`approval_status`='U',`modified_at`='$datetime' WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'");
        unset($_SESSION['registration_id']);
        unset($_SESSION['visitor_id']);
        echo json_encode($data = array("status"=>'success',"device"=>$device,"message"=>"Your COVID details have been updated successfully")); exit;
	}else{
        $sqlx = "INSERT INTO `visitor_lab_info` (`registration_id`, `visitor_id`, `pan_no`, `mobile_no`, `via`,`lab_name`,`location`,`self_report`,`self_declaration`,`certificate`, `status`,`approval_status`) VALUES ('$registration_id', '$visitor_id', '$pan_no', '$mobile_no', '$via','','','$self_report','$self_declaration','$certificate','1','U')";
	    $ansData = $conn ->query($sqlx);
	    unset($_SESSION['registration_id']);
        unset($_SESSION['visitor_id']);
	    echo json_encode($data = array("status"=>'success',"device"=>$device,"message"=>"Your COVID details have been submitted successfully")); exit;
	    
	}
		
	
	
	}
	

function valid_email($str) {
return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}


?>