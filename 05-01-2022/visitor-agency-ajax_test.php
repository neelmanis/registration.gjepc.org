<?php
include ("db.inc.php");
include ("functions.php");
session_start();

$action = $_REQUEST['action'];

if(isset($_POST['action']) && $_POST['action']=="agency-visitor-add-action")
{
	//echo '<pre>';  print_r($_POST); exit;	
	$registration_id = filter($_SESSION['AGENCYID']);
	$agency_name = filter($_POST['agency_name']);
	$person_name = filter($_POST['person_name']);
	$mobile = filter($_POST['mobile']);
	$category = filter($_POST['category']);
	$committee = filter($_POST['committee']);
	$id_proof = filter($_POST['id_proof']);
	$id_proof_doc_name = filter($_POST['id_proof_name']);
	$pan = filter($_POST['pan']);
	$payment_made_for = filter($_POST['payment_made_for']);
	$amount = "0";
	// $via = filter($_POST['via']);
	// $lab_name = filter($_POST['labs']);
	// $location = filter($_POST['location']);
    $createdDate = date("Y-m-d H:i:s");
	$modifiedDate = date("Y-m-d H:i:s");
	$person_status = "P";
	$show = "signature22";
	$year = "2022";
	 
	if(empty($registration_id )){
	    echo json_encode(array("status"=>"error","message"=>"Your session has been expired."));exit;
	}
	$companyData = $conn->query("SELECT * FROM visitor_agency_master WHERE `id`='$registration_id'");
     $rowcompanyData = $companyData->fetch_assoc();
     $isDocument = $rowcompanyData['isDocument'];
	$create_directory = 'images/agency_directory/'.$registration_id;
	if(!file_exists($create_directory)) {
		mkdir($create_directory, 0777);
	}
       $checkVisitorDir = $conn->query("SELECT * FROM visitor_directory WHERE `pan_no`= '$pan'");
		$checkVisitorDirCount = $checkVisitorDir->num_rows;
		$checkVisitorDirRow = $checkVisitorDir->fetch_assoc();
		if($checkVisitorDirCount>0){
			if( $isDocument =="Y"){
				 echo json_encode(array("status"=>"error","message"=>"This PAN Number is already registered under visitor registration portal "));exit;
			}
	       
		}else{
			$checkAgencyDir = $conn->query("SELECT * FROM visitor_agency_registration WHERE `pan_no`= '$pan'");
			$checkAgencyDirCount = $checkAgencyDir->num_rows;
		    $checkAgencyDirRow = $checkAgencyDir->fetch_assoc();
		    if($checkAgencyDirCount>0){
	        echo json_encode(array("status"=>"error","message"=>"This id proof Number is already exist "));exit;
			}

		}


		$checkVisitorDirByMobile = $conn->query("SELECT * FROM visitor_directory WHERE `mobile`= '$mobile'");
		$checkVisitorDirCountByMobile = $checkVisitorDirByMobile->num_rows;
		$checkVisitorDirRowByMobile = $checkVisitorDirByMobile->fetch_assoc();
		if($checkVisitorDirCountByMobile>0){
	        echo json_encode(array("status"=>"error","message"=>"This Mobile Number is already registered under visitor registration portal "));exit;
		}else{
			$checkAgencyDirByMobile = $conn->query("SELECT * FROM visitor_agency_registration WHERE `mobile`= '$mobile'");
			$checkAgencyDirCountByMobile = $checkAgencyDirByMobile->num_rows;
		    $checkAgencyDirRowByMobile = $checkAgencyDirByMobile->fetch_assoc();
		    if($checkAgencyDirCountByMobile>0){
	        echo json_encode(array("status"=>"error","message"=>"This Mobile is already exist  "));exit;
			}

		}
	 
      
    if($isDocument =="yes"){
     

		if(isset($_FILES['id_proof']) && $_FILES['id_proof']['name']!=""){		
		$id_proof_name=$_FILES['id_proof']['name'];
		$id_proof_temp=$_FILES['id_proof']['tmp_name'];
		$id_proof_type=$_FILES['id_proof']['type'];
		$id_proof_size=$_FILES['id_proof']['size'];
		/*$id = $_SESSION['visitor_id'];*/
		$attach="id_proof";
		if($id_proof_name!="")
		{
		     $create_id_proof = 'images/agency_directory/'.$registration_id.'/'.$attach;
			if (!file_exists($create_id_proof)) {
			mkdir($create_id_proof, 0777);
			}
			  $id_proof=uploadAgencyVisitor($id_proof_name,$id_proof_temp,$id_proof_type,$id_proof_size,$mobile,$attach);
			 if ($id_proof =="fail") {
			 	echo json_encode(array('status'=>'error',"message"=>"Sorry, Id Proof uploading has been failed on server. Please contact administrator"));exit; 
			 }elseif ($id_proof =="invalid") {
			 	echo json_encode(array('status'=>'error',"message"=>"Please Select valid file type"));exit; 
			 
			 }
		}else{
			echo json_encode(array("status"=>"error","message"=>"Please Select Id Proof"));exit;
		}
	}else{
		echo json_encode(array("status"=>"error","message"=>"Please Select Id Proof"));exit;
    }

    

    }
	

	

    
	
	
	if(isset($_FILES['photo']) && $_FILES['photo']['name']!=""){
		
		$photo_name=$_FILES['photo']['name'];
		$photo_temp=$_FILES['photo']['tmp_name'];
		$photo_type=$_FILES['photo']['type'];
		$photo_size=$_FILES['photo']['size'];
		/*$id = $_SESSION['visitor_id'];*/
		$attach="photo";
		if($photo_name!="")
		{
		     $create_photo = 'images/agency_directory/'.$registration_id.'/'.$attach;
			if (!file_exists($create_photo)) {
			mkdir($create_photo, 0777);
			}
			  $photo=uploadAgencyVisitor($photo_name,$photo_temp,$photo_type,$photo_size,$mobile,$attach);
			 if ($photo =="fail") {
			 	echo json_encode(array('status'=>'error',"message"=>"Sorry, Id Proof uploading has been failed on server. Please contact administrator"));exit; 
			 }elseif ($photo =="invalid") {
			 	echo json_encode(array('status'=>'error',"message"=>"Please Select valid file type"));exit; 
			 
			 }
		}else{
			echo json_encode(array("status"=>"error","message"=>"Please Select Id Proof"));exit;
		}
	}else{
		echo json_encode(array("status"=>"error","message"=>"Please Select Id Proof"));exit;
	}

	    $mobileResult = $conn->query("SELECT * FROM `visitor_agency_registration` WHERE `mobile`='$mobile'");
        $mobileCount =  $mobileResult ->num_rows;
        if($mobileCount > 0){
        	echo json_encode(array('status'=>'error',"message"=>"Mobile is already exist"));exit; 
        }

        $mobileGlobalResult = $conn->query("SELECT * FROM `globalExhibition` WHERE `mobile`='$mobile'");
        $mobileGlobalCount =  $mobileGlobalResult ->num_rows;
        if($mobileGlobalCount > 0){
        	echo json_encode(array('status'=>'error',"message"=>"Mobile is already exist in global"));exit; 
        }


         $sqlx = "INSERT INTO `visitor_agency_registration` 
        (`agency_id`, `person_name`,`company_name`,`mobile`, `category`,`committee`, `id_proof_name`,`id_proof_file`,`pan_no`,`photo`,`payment_made_for`,`show`,`year`,`person_status`,`createdDate`,`modifiedDate`) VALUES (
        '$registration_id', '$person_name', '$agency_name','$mobile','$category','$committee','$id_proof_doc_name','$id_proof', '$pan','$photo','$payment_made_for','$show','$year','$person_status','$createdDate','$modifiedDate')";
	    $ansData = $conn ->query($sqlx);
        $visitor_id = $conn->insert_id;

	 //    if($ansData){
		// /*Global Table Start */
		
		// $visitorPhoto =  getAgencyVisitorPhoto($visitor_id,$conn); 	
		// $photo_url = "https://registration.gjepc.org/images/agency_directory/".$registration_id."/photo/".$visitorPhoto;

		// $digits = 9;	
	 //    $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
	 //    $checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");
	 //    $countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
		// while($countUniqueIdentifier > 0) {
		// $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		// } 
						
		// $checkGlobalRecord = "SELECT * FROM globalExhibition WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id'  AND participant_Type='CONTR'";
		// $globalResult = $conn->query($checkGlobalRecord);
  //       $checkGlobalCount = $globalResult->num_rows;
	 //    if($checkGlobalCount>0){
		//  $updateGlobal = "UPDATE globalExhibition  SET `uniqueIdentifier`='$uniqueIdentifier',`fname`='$person_name',`mobile`='$mobile',`designation`='',`company`='$company_name',`photo_url`='$photo_url',`covid_report_status`='pending',`status`='P',`agency_category`='$category' WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id'  AND participant_Type='CONTR'";
		// $updateGlobalResult = $conn->query($updateGlobal);	
		// } else { 
		//  $insertGlobal = "INSERT INTO globalExhibition  SET `uniqueIdentifier`='$uniqueIdentifier',`registration_id`='$registration_id',`visitor_id`='$visitor_id',`fname`='$person_name',`mobile`='$mobile',`pan_no`='$pan',`designation`='',`company`='$agency_name',`photo_url`='$photo_url',`participant_type`='CONTR',`agency_category`='$category',`covid_report_status`='pending',`status`='P'";
		// 	$insertGlobalResult = $conn->query($insertGlobal);
		// }
		// /*Global Table End */

		// echo json_encode($data = array("status"=>'success',"message"=>"Successfully submitted")); exit;
	 //    }
	    echo json_encode($data = array("status"=>'success',"message"=>"Successfully submitted")); exit;
	    
	    
	
	
	}

if(isset($_POST['action']) && $_POST['action']=="covid-report-upload-action")
{
	
	//echo '<pre>';  print_r($_POST); exit;	
	$registration_id = filter($_SESSION['AGENCYID']);
	$visitor_id =  filter(base64_decode($_POST['visitor']));
	$modifiedDate = date("Y-m-d H:i:s");
	$createdDate = date("Y-m-d H:i:s");
	$self_declaration = "Negative";
	$certificate = $_POST['certificate'];
	
	if(empty($registration_id )){
	 echo json_encode(array("status"=>"error","message"=>"Your session has been expired."));exit;
	}

	$checkAgencyDir = $conn->query("SELECT * FROM visitor_agency_registration WHERE `id`= '$visitor_id'");
	$checkAgencyDirCount = $checkAgencyDir->num_rows;
    $checkAgencyDirRow = $checkAgencyDir->fetch_assoc();

    if($checkAgencyDirCount==0){
        echo json_encode(array("status"=>"error","message"=>"Please check employee not found"));exit;
	}

	$mobile = $checkAgencyDirRow['mobile'];
	$pan = $checkAgencyDirRow['pan_no'];

	$create_directory = 'images/covid/contr/'.$registration_id;
		if(!file_exists($create_directory)) {
		mkdir($create_directory, 0777);
	}
    
	
	if(isset($_FILES['self_report']) && $_FILES['self_report']['name']!=""){
				
		$self_report_name=$_FILES['self_report']['name'];
		$self_report_temp=$_FILES['self_report']['tmp_name'];
		$self_report_type=$_FILES['self_report']['type'];
		$self_report_size=$_FILES['self_report']['size'];
		/*$id = $_SESSION['visitor_id'];*/
		$attach="self_report";
		if($self_report_name!="")
		{
		     $create_self_report = 'images/covid/contr/'.$registration_id.'/'.$attach;
			if (!file_exists($create_self_report)) {
			mkdir($create_self_report, 0777);
			}
			  $self_report=uploadCovidAgencyVisitor($self_report_name,$self_report_temp,$self_report_type,$self_report_size,$mobile,$attach);
			 if ($self_report =="fail") {
			 	echo json_encode(array('status'=>'error',"message"=>"Sorry, COVID report uploading has been failed on server. Please contact administrator"));exit; 
			 }elseif ($self_report =="invalid") {
			 	echo json_encode(array('status'=>'error',"message"=>"Please Select valid file type"));exit; 
			 
			 }
		}else{
			echo json_encode(array("status"=>"error","message"=>"Please Select COVID Report"));exit;
		}
	}else{
		echo json_encode(array("status"=>"error","message"=>"Please Select COVID Report"));exit;
	}
	
	$category_for = "CONTR";

	$getx = $conn->query("SELECT * FROM visitor_lab_info WHERE registration_id='$registration_id' AND `visitor_id`='$visitor_id'  AND `category_for`='$category_for'");
	$countx = $getx->num_rows;

    if($countx > 0){
     $sqlX = "UPDATE visitor_lab_info SET  `via`='self',`status`='1',`self_declaration`='Negative',`self_report`='$self_report',`certificate`='$certificate' WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id'  AND `category_for`='$category_for'";
     $resultx = $conn->query($sqlX);
    }else{
     $sqlX = "INSERT INTO  visitor_lab_info SET `create_date`='$createdDate',`lab_name`='',`location`='',`registration_id`='$registration_id',`visitor_id`='$visitor_id',`pan_no`='$pan',`mobile_no`='$mobile',`via`='self',`status`='1',`self_declaration`='Negative',`category_for`='$category_for',`self_report`='$self_report',`certificate`='$certificate',event='signature22'";
     $resultx = $conn->query($sqlX);
    }
	
	
       if($resultx){
       	echo json_encode($data = array("status"=>'success',"message"=>"Thank you, your COVID report has been uploaded successfully")); exit;
       }else{
       	echo json_encode($data = array("status"=>'error',"message"=>"Sorry, Something went wrong. Please try again. ")); exit;
       }
	}
	
if(isset($_POST['action']) && $_POST['action']=="UpdateCovidReport")
{

	function uploadIntlVIsitor($file_name,$file_temp,$file_type,$file_size,$id,$name)
	{
		$upload_image = '';
		$target_folder = 'images/covid/contr/'.$_SESSION['AGENCYID'].'/'.$name.'/';
		
		$target_path = "";
		$user_id = $_SESSION['AGENCYID'];
		$file_name = str_replace(" ","_",$file_name);
		
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

	$registration_id = $_POST['registration_id'];
	$vis_id = $_POST['vis_id'];
	$via = 'self'; 
	$category_for = 'CONTR'; 
	$self_declaration ="Negative";
	$certificate = $_POST['valueType'];

	$getVendorData = $conn->query("SELECT * FROM visitor_agency_registration WHERE agency_id='$registration_id' AND id='$vis_id'");
	$rowVendor = $getVendorData->fetch_assoc();

    $mobile_no = $rowVendor['mobile'];
	$pan_no = $rowVendor['pan_no'];
	if($pan_no ==""){
		$pan_no ="CONTR".$vis_id;
	}
	if(empty($registration_id && $vis_id)){
	 echo json_encode(array("status"=>"error","message"=>"Your session has been expired.")); exit;
	}

	$create_directory = 'images/covid/contr/'.$registration_id ;
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
		     $create_self_report = 'images/covid/contr/'.$registration_id .'/'.$attach;
			if(!file_exists($create_self_report)) {
			mkdir($create_self_report, 0777);
			}
			 
			$vaccine_certificate=uploadIntlVIsitor($self_report_name,$self_report_temp,$self_report_type,$self_report_size,$vis_id,$attach);
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
	
	/*======================= SEND EMAIL NOTIFICATION AFTER UPLOAD CERTIFICATE  ===================*/
	/*.......................................Send mail to users mail id...............................................*/
	//   $message ='<table cellpadding="10" width="65%" style="margin:0px auto;font-family: Roboto; background-color:#eeee;padding:30px; border-collapse:collapse;">
	// <tr><td style="background-color:#744F9E;padding:3px;"></td></tr>
	//   <tr><td align="left"><img src="https://registration.gjepc.org/images/logo.png"> </td></tr>
	//   <tr style="background-color:#eeee;padding:30px;">
	//   <td>Your Vaccination Certificate has been uploaded successfully. We will notify you on approval/disapproval of the document. Regards, GJEPC</td></tr>
	//    <tr><td>       
	// 	  <p>Kind Regards,<br>
	// 	  <b>GJEPC Web Team,</b>
	// 	  </p>
	// 	  <p> For Any Queries : </p>
	// 	</td>
	//   </tr>
	//   <tr><td><b>Toll Free Number :</b> 1800-103-4353 <br/>
	// <b>Missed Call Number :</b> +91-7208048100
	//  </td></tr> 
	// </table>';
  
	//  $to = $email;
	//  $subject = "Your Vaccination Certificate has been uploaded successfully"; 
	//  $headers  = 'MIME-Version: 1.0' . "\r\n"; 
	//  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
	//  $headers .= 'From: IIJS Premiere 2021 <admin@gjepc.org>';				
	//  mail($to, $subject, $message, $headers);
	 
    /*==============================SHOW MESSAGE AFTER UPLOAD CERTIFICATE=============================*/
	
	/*==============================SHOW MESSAGE AFTER UPLOAD CERTIFICATE=============================*/

    if($certificate =='dose1'){
    	$messagev = "It is compulsory to carry Covid-19 Negative Report(RT PCR Test) done before 48 hrs of your first scheduled entry at IIJS SIGNATURE 2022.";
    } else {
    	$messagev = "Please download your E-badge from GJEPC app post approval of your final vaccination certificate.";
    }
	
	$checkData = "SELECT * FROM visitor_lab_info WHERE registration_id='$registration_id' AND visitor_id='$vis_id' AND category_for='$category_for'";
	$resultData = $conn->query($checkData);
	$countData =  $resultData->num_rows;
	if($countData > 0){
		if($certificate =='dose1'){
         $updateData =  "UPDATE visitor_lab_info SET `dose1`='$vaccine_certificate',`certificate`='$certificate',`approval_status`='U',`dose1_status`='U',`modified_at`='$datetime' WHERE registration_id='$registration_id' AND visitor_id='$vis_id' AND category_for='$category_for'";
		} else {
             $updateData = "UPDATE visitor_lab_info SET `dose2`='$vaccine_certificate',`certificate`='$certificate',`approval_status`='U',`dose2_status`='U',`modified_at`='$datetime' WHERE registration_id='$registration_id' AND visitor_id='$vis_id' AND category_for='$category_for'";
		} 
		$ansData = $conn ->query($updateData);
 
        if(!$ansData){
        	echo json_encode(array("status"=>"error","message"=>$conn->error)); exit;
        }
        echo json_encode($data = array("status"=>'success',"device"=>$device,"message"=>$messagev,)); exit;
	} else {
		
		if($certificate =='dose1'){
        $sqlx = "INSERT INTO `visitor_lab_info` (`registration_id`, `visitor_id`, `pan_no`, `mobile_no`, `via`,`certificate`,`dose1`, `status`,`approval_status`,`dose1_status`,`category_for`,`event`) VALUES ('$registration_id', '$vis_id', '$pan_no', '$mobile_no', '$via','$certificate','$vaccine_certificate','1','P','P','$category_for','signature22')";
		} else {
         $sqlx = "INSERT INTO `visitor_lab_info` (`registration_id`, `visitor_id`, `pan_no`, `mobile_no`, `via`,`certificate`,`dose2`, `status`,`approval_status`,`dose1_status`,`category_for`,`event`) VALUES ('$registration_id', '$vis_id','$pan_no', '$mobile_no', '$via','$certificate','$vaccine_certificate','1','P','P','$category_for','signature22')";
		}
		
	    $ansData = $conn ->query($sqlx);
	
        if(!$ansData){
        	echo json_encode(array("status"=>"error","message"=>$conn->error)); exit;
        }
	    echo json_encode($data = array("status"=>'success',"device"=>$device,"message"=>$messagev)); exit;
	}
	
}

if(isset($_POST['action']) && $_POST['action']=="confirm_show")
{
	
	
	$registration_id = filter($_SESSION['AGENCYID']);
	$visitor_id =  filter($_POST['visitor_id']);
	$event =  filter($_POST['event']);
	$category =  filter($_POST['category']);
	$participant_Type = "CONTR";
	$event = "signature23";
	$modified_at = date("Y-m-d H:i:s");
    $created_at = date("Y-m-d H:i:s");

	$getVisitor = $conn->query("SELECT id,agency_id,person_name,company_name,mobile,category,photo,badge_status,`show`,`year`,person_status FROM visitor_agency_registration WHERE `id`='$visitor_id' AND `agency_id`='$registration_id'");
	$row = $getVisitor->fetch_assoc();

    $fname =  str_replace(array('&amp;','&AMP;'), '&', $row['person_name']);
    $lname = '';
    $mobile = $row['mobile'];
    $pan_no = $row['pan_no'];
    $designation = "";
    $categoryId=getAgencyCat($registration_id,$conn);
	if($categoryId=="5")

	$company = strtoupper(str_replace(array('&amp;','&AMP;'), '&', $row['company_name']));
	else	
	$company = getAgencyName($registration_id,$conn);
   $company = strtoupper(str_replace(array('&amp;','&AMP;'), '&', $company));
	
    $photo_url = "https://registration.gjepc.org/images/agency_directory/".$registration_id."/photo/".$row['photo'];
    $participant_type = "CONTR";
    $covid_report_status = "pending";
    $days_allow = 'all';
    //$category = $row['category'];
    $committee = $row['committee'];


	if(!empty($registration_id )){
		if($visitor_id !==""){


            /* GLOBAL EXHIBITION INSERT START*/
            $digits = 9;	
            $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
            $checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");
            $countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
			while($countUniqueIdentifier > 0) {
			  $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
			} 
					
			 $checkRecord = $conn->query("SELECT * FROM globalExhibition WHERE  `registration_id`='$registration_id' AND `visitor_id`='$visitor_id'  AND `mobile`='$mobile' AND event='$event' ");
                  $checkRecordNum = $checkRecord->num_rows;
	                        if($checkRecordNum>0){
	                        	$checkRecordRow = $checkRecord->fetch_assoc();
	                        	$global_booster_dose_status = $checkRecordRow['booster_dose_status'] ; 
	                        	$global_dose2_status = $checkRecordRow['dose2_status'] ;
	                        	
	                        	$global_status = "Y";

                                $updateGlobal = "UPDATE  globalExhibition  SET `modified_date`='$modified_at',`status`='$global_status' WHERE  `registration_id`='$registration_id' AND `visitor_id`='$visitor_id'   AND `participant_type`= '$participant_type' AND event='$event' ";
						        $globalResult = $conn->query($updateGlobal);
								
	                        }else{
             $insertGlobal = "INSERT INTO globalExhibition  SET `post_date`='$created_at',`uniqueIdentifier`='$uniqueIdentifier',`registration_id`='$registration_id',`visitor_id`='$visitor_id',`fname`='$fname',`lname`='$lname',`mobile`='$mobile',`pan_no`='$pan_no',`designation`='$designation',`company`='$company',`photo_url`='$photo_url',`participant_type`='$participant_type',`covid_report_status`='$covid_report_status',`days_allow`='$days_allow',`agency_category`='$category',`committee`='$committee',`status`='Y',`event`='$event'";
	        $globalResult = $conn->query($insertGlobal);
			}
	                        



	 		if($globalResult){
	       	echo json_encode($data = array("status"=>'success',"message"=>"Thank you, you have registered for IIJS Signature 2023 successfully")); exit;
	       }else{
	       	echo json_encode($data = array("status"=>'error',"message"=>"Sorry, Something went wrong. Please try again. ")); exit;
	       }


	    }else{
	    	echo json_encode(array("status"=>"error","message"=>"Please check employee not found"));exit;
	    }
	}else{
		 echo json_encode(array("status"=>"error","message"=>"Your session has been expired."));exit;
	}
    
      
}
    if(isset($_POST['action']) && $_POST['action']=="getPersonInfo")
	{
	
	
	$registration_id = filter($_SESSION['AGENCYID']);
	$visitor_id =  filter($_POST['person_id']);


	$getVisitor = $conn->query("SELECT * FROM visitor_agency_registration WHERE `id`='$visitor_id' AND `agency_id`='$registration_id'");
	$row = $getVisitor->fetch_assoc();
	$count = $getVisitor->num_rows;
	if($count > 0){
		$fname =  str_replace(array('&amp;','&AMP;'), '&', $row['person_name']);
	    $lname = '';
	    $company_name = $row['company_name'];
	    $photo = "images/agency_directory/".$registration_id."/photo/".$row['photo'];
	    echo json_encode(array("status"=>"success","company_name"=>$company_name,"photo"=>$photo));
	}else{
		echo json_encode(array("status"=>"error","message"=>"Data not found"));
	}

   
      
	}

	if(isset($_POST['action']) && $_POST['action']=="update_person_info")
	{
	
	
	$registration_id = filter($_SESSION['AGENCYID']);
	$visitor_id =  filter($_POST['x_person_id']);
	$photo =  filter($_POST['x_photo']);
	$company_name =  filter($_POST['x_company_name']);
	$designation =  filter($_POST['x_designation']);


	$getVisitor = $conn->query("SELECT * FROM visitor_agency_registration WHERE `id`='$visitor_id' AND `agency_id`='$registration_id'");
	$row = $getVisitor->fetch_assoc();
	$count = $getVisitor->num_rows;
	if($count > 0){



	    $prev_company_name = $row['company_name'];
	    $prev_photo = $row['photo'];

	    	if(isset($_FILES['x_photo']) && $_FILES['x_photo']['name']!=""){
		
		$photo_name=$_FILES['x_photo']['name'];
		$photo_temp=$_FILES['x_photo']['tmp_name'];
		$photo_type=$_FILES['x_photo']['type'];
		$photo_size=$_FILES['x_photo']['size'];
		/*$id = $_SESSION['visitor_id'];*/
		$attach="photo";
		if($photo_name!="")
		{
		     $create_photo = 'images/agency_directory/'.$registration_id.'/'.$attach;
			if (!file_exists($create_photo)) {
			mkdir($create_photo, 0777);
			}
			  $photo_file = uploadAgencyVisitor($photo_name,$photo_temp,$photo_type,$photo_size,$mobile,$attach);
			 if ($photo =="fail") {
			 	echo json_encode(array('status'=>'error',"message"=>"Sorry, Id Proof uploading has been failed on server. Please contact administrator"));exit; 
			 }elseif ($photo =="invalid") {
			 	echo json_encode(array('status'=>'error',"message"=>"Please Select valid file type"));exit; 
			 
			 }
		}else{
			echo json_encode(array("status"=>"error","message"=>"Please Select Id Proof"));exit;
		}
	}else{
		$photo_file =  $prev_photo ;
	}

	    $update_directory = "UPDATE visitor_agency_registration SET  company_name='$company_name',photo='$photo_file' WHERE `id`='$visitor_id' AND `agency_id`='$registration_id'";
	    $update_directory_result = $conn->query($update_directory);
	    if($update_directory_result){

	    	// /*Global Table Start */
		
		
		 $photo_url = "https://registration.gjepc.org/images/agency_directory/".$registration_id."/photo/".$photo_file;

		
						
		$checkGlobalRecord = "SELECT * FROM globalExhibition WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id'  AND participant_Type='CONTR'";
		$globalResult = $conn->query($checkGlobalRecord);
        $checkGlobalCount = $globalResult->num_rows;
	    if($checkGlobalCount>0){
         $globalRow = $globalResult->fetch_assoc();
         if($designation =="" || empty($designation)){
			$designation = trim($globalRow['designation']);
         }else{
			$designation = $designation;
         }
        
	    	
		 $updateGlobal = "UPDATE globalExhibition  SET `company`='$company_name',`designation`='$designation',`photo_url`='$photo_url', `isDataPosted`='N' WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id'  AND participant_Type='CONTR'";
		$updateGlobalResult = $conn->query($updateGlobal);	
		} 

		// /*Global Table End */
		echo json_encode(array("status"=>"success","message"=>"Data has been successfully updated"));exit;

	    }


	   
	}else{
		echo json_encode(array("status"=>"error","message"=>"Data not found something went wrong"));exit;
	}

   
      
	}

	
?>