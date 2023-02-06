<?php
include ("db.inc.php");
include ("functions.php");
session_start();

$action = trim($_REQUEST['action']);

if(isset($_POST['action']) && $_POST['action']=="UpdateCovidReport")
{
	//echo '<pre>';  print_r($_SESSION); exit;	
	$registration_id = trim($_SESSION['USERID']); 
	$visitor_id = trim($_POST['visitor_id']);
	$pan_no = getVisitorPAN($visitor_id,$conn);
	$mobile_no = getVisitorMobile($visitor_id,$conn);
	$certificate = $_POST['valueType'];
	
	$via="self";
	$visitor_email = getVisitorEmail($visitor_id,$conn); 
	$CompanyName = getCompanyName($registration_id,$conn); 
	$visitorName = getVisitorName($visitor_id,$conn);
	if(empty($registration_id) && empty($visitor_id)){
	 echo json_encode(array("status"=>"error","message"=>"Your session has been expired.")); exit;
	}
    
	//$category_for = getVisitorSelectedShow($visitor_id,$conn);
	
    $category_for = "INTL";

	$create_directory = 'images/covid/vis/'.$_SESSION['USERID'];
		if(!file_exists($create_directory)) {
		mkdir($create_directory, 0777);
	}
 
 	if(isset($_FILES['vaccine_certificate']) && $_FILES['vaccine_certificate']['name']!="")
	{
		$vaccine_certificate_name=$_FILES['vaccine_certificate']['name'];
		$vaccine_certificate_temp=$_FILES['vaccine_certificate']['tmp_name'];
		$vaccine_certificate_type=$_FILES['vaccine_certificate']['type'];
		$vaccine_certificate_size=$_FILES['vaccine_certificate']['size'];

		$attach="vaccine_certificate";
		if($vaccine_certificate_name!="")
		{
		    $create_vaccine_certificate = 'images/covid/intl/'.$_SESSION['USERID'].'/'.$attach;
			if(!file_exists($create_vaccine_certificate)) {
			mkdir($create_vaccine_certificate, 0777);
			}
			  $vaccine_certificate = uploadBulk_INTLVIsitorCovid($vaccine_certificate_name,$vaccine_certificate_temp,$vaccine_certificate_type,$vaccine_certificate_size,$eid,$attach);
			if ($vaccine_certificate =="fail") {
			 	echo json_encode(array('status'=>'error',"message"=>"Sorry, report uploading has been failed on server. Please contact administrator"));exit; 
			} elseif ($vaccine_certificate =="invalid") {
			 	echo json_encode(array('status'=>'error',"message"=>"Please Select valid file type")); exit; 
			}
		} else {
			echo json_encode(array("status"=>"error","message"=>"Please Select covid vaccination certificate")); exit;
		}
	} else {
		echo json_encode(array("status"=>"error","message"=>"Please Select covid vaccination certificate"));exit;
	}
	
    $checkData = "SELECT * FROM visitor_lab_info WHERE registration_id='$registration_id' AND visitor_id='$visitor_id' AND category_for='INTL'"; 
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
		} else{
		    $device = "android";
		}
	} else{
	    $device = "desktop";
	}
 
	$datetime = date("Y-m-d H:i:s");
	
	$sql_check_event = "SELECT * FROM visitor_event_master WHERE `status` = '1' AND `isParentShow`='1'";
	$result_check_event= $conn->query($sql_check_event);
    $count_check_event = $result_check_event->num_rows;
	if($count_check_event > 0){
	$row_check_event = $result_check_event->fetch_assoc();
    $show =  $row_check_event['shortcode'];
	$year =  $row_check_event['year'];
	} else {
		echo json_encode($data = array("status"=>'error',"message"=>"EVENT IS NOT ACTIVE")); exit;
	} 
	
	/*======================= SEND SMS AFTER UPLOAD CERTIFICATE  ===================*/
	$cert = "Vaccination Certificate";
	$website = "IIJS SIGNATURE 2022";
    $smsContent ="Your ".$cert." has been uploaded successfully for ".$website." .We will notify you on approval/disapproval. Regards, GJEPC";
    //get_data($smsContent,$mobile_no);
 //   send_sms($smsContent,$mobile_no);
	
    /*==============================SHOW MESSAGE AFTER UPLOAD CERTIFICATE=============================*/

    if($certificate =='dose1'){
    //	$messagev = "It is compulsory to carry Covid-19 Negative Report (RT PCR Test) done before 72 hrs before your first visit at IIJS SIGNATURE 2022.";
		$messagev = "All the visitors visiting the exhibition should be fully vaccinated.";
    } else {
    	$messagev = "We will update you on vaccination certificate approval soon.";
    }
    
	if($countData > 0){
		if($certificate =='dose1'){
            $updateData =  $conn->query("UPDATE visitor_lab_info SET `dose1`='$vaccine_certificate',`certificate`='$certificate',`approval_status`='U',`dose1_status`='U',`modified_at`='$datetime',location='bulk' WHERE registration_id='$registration_id' AND visitor_id='$visitor_id' AND `category_for`='$category_for'");
		} else {

            $updateData =  $conn->query("UPDATE visitor_lab_info SET `dose2`='$vaccine_certificate',`certificate`='$certificate',`approval_status`='U',`dose2_status`='U',`modified_at`='$datetime',location='bulk' WHERE registration_id='$registration_id' AND visitor_id='$visitor_id' AND `category_for`='$category_for'");
		} 
		$ansData = $conn ->query($updateData);
    //    unset($_SESSION['USERID']);
    //    unset($_SESSION['visitor_id']);
       
        echo json_encode($data = array("status"=>'success',"device"=>$device,"message"=>$messagev,)); exit;
	} else {

		if($certificate =='dose1'){
        $sqlx = "INSERT INTO `visitor_lab_info` (`registration_id`, `visitor_id`, `pan_no`, `mobile_no`, `via`,`certificate`,`dose1`, `status`,`approval_status`,`dose1_status`,`category_for`,`event`,`location`) VALUES ('$registration_id', '$visitor_id', '$pan_no', '$mobile_no', '$via','$certificate','$vaccine_certificate','1','P','P','$category_for','signature22','bulk')";
		} else {
        $sqlx = "INSERT INTO `visitor_lab_info` (`registration_id`, `visitor_id`, `pan_no`, `mobile_no`, `via`,`certificate`,`dose2`, `status`,`approval_status`,`dose1_status`,`category_for`,`event`,`location`) VALUES ('$registration_id', '$visitor_id', '$pan_no', '$mobile_no', '$via','$certificate','$vaccine_certificate','1','P','P','$category_for','signature22','bulk')";
		}
	    $ansData = $conn ->query($sqlx);
	//    unset($_SESSION['USERID']);
    //    unset($_SESSION['visitor_id']);
	    echo json_encode($data = array("status"=>'success',"device"=>$device,"message"=>$messagev)); exit;
	    
	}
}
?>