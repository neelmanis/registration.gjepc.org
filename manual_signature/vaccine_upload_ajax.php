<?php
include('header_include.php');
$hostname_main = "localhost";
$uname_main = "gjepcliveuserdb";
$pwd_main = "KGj&6(pcvmLk5";
$database_main = "gjepclivedatabase";

// Create connection
$conn_main = new mysqli($hostname_main, $uname_main, $pwd_main, $database_main);
// Check connection
if ($conn_main->connect_error) {
    die("Connection failed: " . $conn_main->connect_error);
} else {
}



if(isset($_POST['action']) && $_POST['action']=="UpdateCovidReport")
{
	function uploadVaccineCertificate($file_name,$file_temp,$file_type,$file_size,$id,$name,$registration_id)
	{
		$upload_image = '';
		$target_folder = '/var/www/html/registration.gjepc.org/images/covid/exh/'.$registration_id.'/'.$name.'/';
		
		$target_path = "";
		$user_id = $registration_id;
		$file_name = str_replace(" ","_",$file_name);
		$file_name = str_replace(".php","",$file_name);
		$file_name = str_replace("'","",$file_name);
		
		if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
	    echo "Sorry something error while uploading..."; exit;
		}
		else if($file_name != '')
		{
			if((($file_type == "application/pdf" || $file_type == "application/PDF" || $file_type == "image/jpg" || $file_type == "image/png" || $file_type == "image/JPG" || $file_type == "image/PNG" || $file_type == "image/jpeg" || $file_type == "image/JPEG")) && $file_size < 2097152)
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

	$exhibitor_code = $_SESSION['EXHIBITOR_CODE'];
	$registration_id = $_POST['registration_id'];
	$visitor_id = $_POST['exhibitor_id'];
	$certificate = $_POST['valueType'];
	$pan_no = "EXH".$visitor_id;
	$category_for = "EXH";
	$via="self";
	$CompanyName = getExhibitorName($exhibitor_code,$conn); 
	if(empty($registration_id) && empty($visitor_id)){
	 echo json_encode(array("status"=>"error","message"=>"Your session has been expired."));exit;
	}
	$exh_list_sql =  "SELECT * FROM `iijs_badge_items` WHERE Exhibitor_Code='$exhibitor_code' AND `Badge_Item_ID`='$visitor_id' AND `badge_approved`='Y'"; 
	$exh_list_result = $conn->query($exh_list_sql);
    $exh_list_count = $exh_list_result->num_rows;
    if($exh_list_count>0){
    	$exh_list_row = $exh_list_result->fetch_assoc();
       	$mobile_no = $exh_list_row['Badge_Mobile'];
    } else {
	 echo json_encode(array("status"=>"error","message"=>"Your session has been expired."));exit;
    }
	$create_directory = '/var/www/html/registration.gjepc.org/images/covid/exh/'.$registration_id;
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
		     $create_vaccine_certificate = '/var/www/html/registration.gjepc.org/images/covid/exh/'.$registration_id.'/'.$attach;
			if (!file_exists($create_vaccine_certificate)) {
			mkdir($create_vaccine_certificate, 0777);
			}
			  $vaccine_certificate=uploadVaccineCertificate($vaccine_certificate_name,$vaccine_certificate_temp,$vaccine_certificate_type,$vaccine_certificate_size,$mobile_no,$attach,$registration_id);
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
	$resultData =$conn_main->query($checkData);
	$countData =  $resultData->num_rows;
	$datetime = date("Y-m-d H:i:s");
	
	/*======================= SEND SMS AFTER UPLOAD CERTIFICATE  ===================*/
	$cert = "Vaccination Certificate";
    $smsContent ="Your ".$cert." has been uploaded successfully. We will notify you on approval/disapproval of the document. Regards, GJEPC";
    get_data($smsContent,$mobile_no);
    /*==============================SHOW MESSAGE AFTER UPLOAD CERTIFICATE=============================*/

    if($certificate =='dose1'){
    //	$messagev = "It is compulsory to carry Covid-19 Negative Report(RT PCR Test) done before 48 hrs of your first scheduled entry at IIJS Premiere 2021.";
    }else{
    	$messagev = "We will update you After approval of your vaccination certificate, Your Digital badge will be available soon on GJEPC APP.";
    }
    
	if($countData > 0){
		if($certificate =='dose1'){
            $updateData =  "UPDATE visitor_lab_info SET `dose1`='$vaccine_certificate',`certificate`='$certificate',`approval_status`='U',`dose1_status`='U',`modified_at`='$datetime' WHERE registration_id='$registration_id' AND visitor_id='$visitor_id' AND `category_for`='$category_for'";
		} else {
             $updateData =  "UPDATE visitor_lab_info SET `dose2`='$vaccine_certificate',`certificate`='$certificate',`approval_status`='U',`dose2_status`='U',`modified_at`='$datetime' WHERE registration_id='$registration_id' AND visitor_id='$visitor_id' AND `category_for`='$category_for'";
		} 
		$ansData = $conn_main ->query($updateData);
        if(!$ansData){
	     	echo json_encode(array('status'=>'error',"message"=>$conn_main->error));exit; 
	    }
       
        echo json_encode($data = array("status"=>'success',"device"=>$device,"message"=>$messagev,)); exit;
	} else {

		if($certificate =='dose1'){
         $sqlx = "INSERT INTO `visitor_lab_info` (`registration_id`, `visitor_id`, `pan_no`, `mobile_no`, `via`,`certificate`,`dose1`, `status`,`approval_status`,`dose1_status`,`category_for`) VALUES ('$registration_id', '$visitor_id', '$pan_no', '$mobile_no', '$via','$certificate','$vaccine_certificate','1','P','P','$category_for')";
		} else{
         $sqlx = "INSERT INTO `visitor_lab_info` (`registration_id`, `visitor_id`, `pan_no`, `mobile_no`, `via`,`certificate`,`dose2`, `status`,`approval_status`,`dose1_status`,`category_for`) VALUES ('$registration_id', '$visitor_id', '$pan_no', '$mobile_no', '$via','$certificate','$vaccine_certificate','1','P','P','$category_for')";
		}
    
	    $ansData = $conn_main ->query($sqlx);
	    if(!$ansData){
	     	echo json_encode(array('status'=>'error',"message"=>$conn_main->error));exit; 
	    }
	    echo json_encode($data = array("status"=>'success',"device"=>$device,"message"=>$messagev)); exit;
	}
}
?>