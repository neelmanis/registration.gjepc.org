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
	$show = "signature2";
	$year = "2021";
	 
	if(empty($registration_id )){
	    echo json_encode(array("status"=>"error","message"=>"Your session has been expired."));exit;
	}
	$create_directory = 'images/agency_directory/'.$registration_id;
	if(!file_exists($create_directory)) {
		mkdir($create_directory, 0777);
	}
       $checkVisitorDir = $conn->query("SELECT * FROM visitor_directory WHERE `pan_no`= '$pan'");
		$checkVisitorDirCount = $checkVisitorDir->num_rows;
		$checkVisitorDirRow = $checkVisitorDir->fetch_assoc();
		if($checkVisitorDirCount>0){
	        echo json_encode(array("status"=>"error","message"=>"This PAN Number is already registered under visitor registration portal "));exit;
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
	 $companyData = $conn->query("SELECT * FROM visitor_agency_master WHERE `id`='$registration_id'");
     $rowcompanyData = $companyData->fetch_assoc();
     $isDocument = $rowcompanyData['isDocument'];
      
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
        (`agency_id`, `person_name`, `mobile`, `category`,`committee`, `id_proof_name`,`id_proof_file`,`pan_no`,`photo`,`payment_made_for`,`show`,`year`,`person_status`,`createdDate`,`modifiedDate`) VALUES (
        '$registration_id', '$person_name', '$mobile','$category','$committee','$id_proof_doc_name','$id_proof', '$pan','$photo','$payment_made_for','$show','$year','$person_status','$createdDate','$modifiedDate')";
	    $ansData = $conn ->query($sqlx);
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
     $sqlX = "INSERT INTO  visitor_lab_info SET `create_date`='$createdDate',`lab_name`='',`location`='',`registration_id`='$registration_id',`visitor_id`='$visitor_id',`pan_no`='$pan',`mobile_no`='$mobile',`via`='self',`status`='1',`self_declaration`='Negative',`category_for`='$category_for',`self_report`='$self_report',`certificate`='$certificate'";
     $resultx = $conn->query($sqlX);
    }
	
	
       if($resultx){
       	echo json_encode($data = array("status"=>'success',"message"=>"Thank you, your COVID report has been uploaded successfully")); exit;
       }else{
       	echo json_encode($data = array("status"=>'error',"message"=>"Sorry, Something went wrong. Please try again. ")); exit;
       }
	}

?>