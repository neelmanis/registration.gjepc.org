<?php
include('header_include.php');

/*......................................... Get visitor show which is selected 3 & 6 show ..............................................*/
/*
echo $checkHistory = "SELECT * FROM `visitor_order_history` WHERE (payment_made_for='6show' OR payment_made_for='5show' OR payment_made_for='4show' OR payment_made_for='3show' OR payment_made_for='2show' OR payment_made_for='1show' OR payment_made_for='combo') AND `status`='1' AND payment_status='Y'"; 
$resultQuery = $conn ->query($checkHistory);
$num = $resultQuery->num_rows;

if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
	{ 	
		//echo '<pre>'; print_r($resultHistory);
		$visitor_id =  $resultHistory['visitor_id'];
		$registration_id = $resultHistory['registration_id'];
		$payment_made_for = "iijs21";
		$orderId = "IIJS21".$visitor_id;
	echo '<br/>';	
	
		echo	$checks = "select * from visitor_directory where visitor_id='$visitor_id' AND registration_id='$registration_id' AND visitor_approval='Y'";
		echo '<br/>';
		$resultData = $conn ->query($checks);
		$countx = $resultData->num_rows;
		if($countx >0){
			
		echo $checkHist = "SELECT * FROM `visitor_order_history` WHERE payment_made_for='iijs21' AND `registration_id`='$registration_id' AND visitor_id='$visitor_id' AND payment_status='Y'";
	//	$resultQuerys = $conn ->query($checkHist);
		$nums = $resultQuerys->num_rows;
		if($nums>0)
		{
			echo '<br/> Already Registered for Current Show';			
		} else {
		// Insert into Order Details Table

		$sqlx2 = "insert into visitor_order_detail set orderId='$orderId',regId='$registration_id',payment_mode='dump',total_payable='0',payment_status='Y',create_date=NOW(),year='2021',event='iijs21',paymentThrough='dump',agree='Y'";
	//	$result2 = $conn->query($sqlx2);
		if($result2){
		$sqlx1 = "INSERT INTO `visitor_order_history`(`create_date`, `registration_id`, `orderId`,`visitor_id`, `payment_made_for`, `amount`,`show`, `year`,`payment_status`, `paymentThrough`,`status`) VALUES (NOW(),'$registration_id','$orderId','$visitor_id','$payment_made_for','0','$payment_made_for','2021','Y','dump','1')";
	//	$result = $conn->query($sqlx1);
	
		
		$name = getVisitorName($visitor_id,$conn);
		$visitorPAN = getVisitorPAN($visitor_id,$conn);
		$visitorMobile = getVisitorMobile($visitor_id,$conn);
		$designation = getVisitorDesignation($visitor_id,$conn);
		$visitorDesignation =  getVisitorDesignationID($designation,$conn); 
		$visitorPhoto =  getVisitorPhoto($visitor_id,$conn); 		 
		$photo_url = "https://registration.gjepc.org/images/employee_directory/".$registration_id."/photo/".$visitorPhoto;
		
		$getCompany_name = trim(getCompanyName($registration_id,$conn));
		$company_name = str_replace('&amp;', '&', $getCompany_name);
  	
		// Global Table Start 
		$digits = 9;	
	    $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
	    $checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");
	    $countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
		while($countUniqueIdentifier > 0) {
		$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		} 
						
		$checkGlobalRecord = "SELECT * FROM globalExhibition WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `pan_no`='$visitorPAN' AND participant_Type='VIS'";
		$globalResult = $conn->query($checkGlobalRecord);
        $checkGlobalCount = $globalResult->num_rows;
	    if($checkGlobalCount>0){
		echo 'Already Registered for Current Show';	
		} else { 
		$insertGlobal = "INSERT INTO globalExhibition  SET `uniqueIdentifier`='$uniqueIdentifier',`registration_id`='$registration_id',`visitor_id`='$visitor_id',`fname`='$name',`mobile`='$visitorMobile',`pan_no`='$visitorPAN',`designation`='$visitorDesignation',`company`='$company_name',`photo_url`='$photo_url', `participant_type`='VIS',`covid_report_status`='pending',`status`='P',srl_report_url='dump' ";
	//	$insertGlobalResult = $conn->query($insertGlobal);
		}
		
		//Global Table End 
		
		
		}
		}
		
		} else {
			echo 'Data not match';
		}
		
	}
} */


//$checkHistory = "SELECT * FROM `visitor_order_history` WHERE payment_made_for='6show' AND payment_status='Y'"; 
//$checkHistory = "SELECT * FROM `visitor_order_history` WHERE payment_made_for='5show' AND payment_status='Y' AND registration_id='3875' AND visitor_id='17090' "; 
$resultQuery = $conn ->query($checkHistory);
$num = $resultQuery->num_rows;

if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
	{ 	
		//echo '<pre>'; print_r($resultHistory);
		$visitor_id =  $resultHistory['visitor_id'];
		$registration_id = $resultHistory['registration_id'];
		$payment_made_for = "signature23";
		$orderId = "SIGN23".$visitor_id;
	
		$checks = "select * from visitor_directory where visitor_id='$visitor_id' AND registration_id='$registration_id' AND visitor_approval='Y'";
		$resultData = $conn ->query($checks);
		$countx = $resultData->num_rows;
		if($countx >0){
			
		$checkHist = "SELECT * FROM `visitor_order_history` WHERE payment_made_for='$payment_made_for' AND `registration_id`='$registration_id' AND visitor_id='$visitor_id' AND payment_status='Y'";
	//	echo '<br/>';
		$resultQuerys = $conn ->query($checkHist);
		$nums = $resultQuerys->num_rows;
		if($nums>0)
		{
			echo '<br/> Already Registered for Current Show';			
		} else {
		// Insert into Order Details Table

	echo	$sqlx2 = "insert into visitor_order_detail set orderId='$orderId',regId='$registration_id',payment_mode='dumped',total_payable='0',payment_status='Y',create_date=NOW(),year='2023',event='$payment_made_for',paymentThrough='dumped',agree='Y'";
	//	$result2 = $conn->query($sqlx2);
		if($result2){
		$sqlx1 = "INSERT INTO `visitor_order_history`(`create_date`, `registration_id`, `orderId`,`visitor_id`, `payment_made_for`, `amount`,`show`, `year`,`payment_status`, `paymentThrough`,`status`) VALUES (NOW(),'$registration_id','$orderId','$visitor_id','$payment_made_for','0','$payment_made_for','2023','Y','dumped','1')";
	//	$result = $conn->query($sqlx1);
		
		$name = getVisitorName($visitor_id,$conn);
		$visitorPAN = getVisitorPAN($visitor_id,$conn);
		$visitorMobile = getVisitorMobile($visitor_id,$conn);
		$designation = getVisitorDesignation($visitor_id,$conn);
		$visitorDesignation =  getVisitorDesignationID($designation,$conn); 
		$visitorPhoto =  getVisitorPhoto($visitor_id,$conn); 		 
		$photo_url = "https://registration.gjepc.org/images/employee_directory/".$registration_id."/photo/".$visitorPhoto;
		
		$getCompany_name = trim(getCompanyName($registration_id,$conn));
		$company_name = str_replace('&amp;', '&', $getCompany_name);
  	
		//Global Table Start 
		$digits = 9;	
	    $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
	    $checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");
	    $countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
		while($countUniqueIdentifier > 0) {
		$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		} 
						
		$checkGlobalRecord = "SELECT * FROM globalExhibition WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `pan_no`='$visitorPAN' AND participant_Type='VIS' AND `event`='$payment_made_for'";
		$globalResult = $conn->query($checkGlobalRecord);
        $checkGlobalCount = $globalResult->num_rows;
	    if($checkGlobalCount>0){
		echo 'Already Registered for Current Show';	
		} else { 
		$insertGlobal = "INSERT INTO globalExhibition  SET `uniqueIdentifier`='$uniqueIdentifier',`registration_id`='$registration_id',`visitor_id`='$visitor_id',`fname`='$name',`mobile`='$visitorMobile',`pan_no`='$visitorPAN',`designation`='$visitorDesignation',`company`='$company_name',`photo_url`='$photo_url', `participant_type`='VIS',`covid_report_status`='pending',`status`='P',srl_report_url='dumped',`event`='$payment_made_for' ";
	//	$insertGlobalResult = $conn->query($insertGlobal);
		}
		//Global Table End 
		
		}
		}
		
		} else {
			echo 'Data not match';
		}
	}
}

/*
$checkHistory = "SELECT * FROM `visitor_order_history` WHERE (payment_made_for='6show' OR payment_made_for='5show' OR payment_made_for='4show' OR payment_made_for='3show' OR payment_made_for='2show' OR payment_made_for='1show' OR payment_made_for='combo') AND `status`='1' AND payment_status='Y' limit 10000,1000"; 
$resultQuery = $conn ->query($checkHistory);
echo '++++'.$num = $resultQuery->num_rows;

if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
	{ 	
		//echo '<pre>'; print_r($resultHistory);
		$visitor_id =  $resultHistory['visitor_id'];
		$registration_id = $resultHistory['registration_id'];
		$payment_made_for = "iijs21";
	
		$checks = "select * from visitor_directory where visitor_id='$visitor_id' AND registration_id='$registration_id' AND visitor_approval='Y'";
		$resultData = $conn ->query($checks);
		$countx = $resultData->num_rows;
		if($countx >0){
			
		$checkHist = "SELECT * FROM `visitor_order_history` WHERE payment_made_for='iijs21' AND `registration_id`='$registration_id' AND visitor_id='$visitor_id' AND payment_status='Y'";
	//	echo '<br/>';
		$resultQuerys = $conn ->query($checkHist);
		$nums = $resultQuerys->num_rows;
		if($nums>0)
		{
			echo '<br/> Already Registered for Current Show';			
		} else {
			echo '<br/> Pending for Current Show';
		}
		
		} else {
			echo '<br/> Data not match';
		}
	}
} */
?>