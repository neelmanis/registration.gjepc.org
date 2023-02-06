<?php
$hostname = "localhost";
$uname = "gjepcliveuserdb";
$pwd = "KGj&6(pcvmLk5";
$database = "gjepclivedatabase";

// Create connection
$conn = new mysqli($hostname, $uname, $pwd, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
	
}

function getVisitorPhoto($id,$conn)
{
	$query_sel = "SELECT photo FROM visitor_directory where visitor_id='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	 		
	return $row['photo'];
}

function getRegisID($company_pan_no,$conn)
{
	$query_sel = "SELECT id FROM registration_master where company_pan_no='$company_pan_no'";
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	 			
	return $row['id'];
}

function getVisitorID($pan_no,$conn)
{
	$query_sel = "SELECT visitor_id FROM visitor_directory where pan_no='$pan_no' ";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['visitor_id'];
}

function getVisitorMobile($id,$conn)
{
	$query_sel = "SELECT mobile FROM visitor_directory where visitor_id='$id' ";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['mobile'];
}

echo $checkHistory = "SELECT * FROM free_vip_visitors where 1 ";
$resultQuery = $conn ->query($checkHistory);
$num = $resultQuery->num_rows;
if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
	{ //echo '<pre>'; print_r($resultHistory);
		$company_pan_no = $resultHistory['company_pan'];
		$registration_id = $resultHistory['registration_id'];
		$visitorPAN = $resultHistory['pan_no'];
		$visitor_id = getVisitorID($visitorPAN,$conn);
		
		$name = $resultHistory['fname'].' '.$resultHistory['lname'];
		$company_name = $resultHistory['company'];
	//	$visitorMobile = $resultHistory['mobile'];
		$visitorMobile = getVisitorMobile($visitor_id,$conn);
		$visitorDesignation = $resultHistory['designation'];
		
		$visitorPhoto =  getVisitorPhoto($visitor_id,$conn); 		 
		$photo_url = "https://registration.gjepc.org/images/employee_directory/".$registration_id."/photo/".$visitorPhoto;
	
		$payment_made_for = "iijs21";
		$orderId = "IIJS21".$visitor_id;
		$year = '2021';
		
		$checks = "select * from visitor_directory where visitor_id='$visitor_id' AND registration_id='$registration_id' AND visitor_approval='Y'";
		echo '<br/>';
		$resultData = $conn ->query($checks);
		$countx = $resultData->num_rows;
		if($countx >0){
			
		$checkHistorys = "SELECT * FROM `visitor_order_history` WHERE payment_made_for='iijs21' AND `registration_id`='$registration_id' AND visitor_id='$visitor_id' AND payment_status='Y'";	
		$resultQuerys = $conn ->query($checkHistorys);
		$nums = $resultQuerys->num_rows;
		if($nums>0)
		{
			echo 'Already Registered for Current Show';			
		} else {
		// Insert into Order Details Table

	echo	$sqlx2 = "insert into visitor_order_detail set orderId='$orderId',regId='$registration_id',payment_mode='vip',total_payable='0',payment_status='Y',create_date=NOW(),year='2021',event='iijs21',paymentThrough='vip',agree='Y'";
	//	$result2 = $conn->query($sqlx2);
		if($result2){
		$sqlx1 = "INSERT INTO `visitor_order_history`(`create_date`, `registration_id`, `orderId`,`visitor_id`, `payment_made_for`, `amount`,`show`, `year`,`payment_status`, `paymentThrough`,`status`) VALUES (NOW(),'$registration_id','$orderId','$visitor_id','$payment_made_for','0','$payment_made_for','$year','Y','vip','1')";
	//	$result = $conn->query($sqlx1);
	
		/*Global Table Start */
  	
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
		$insertGlobal = "INSERT INTO globalExhibition  SET `uniqueIdentifier`='$uniqueIdentifier',`registration_id`='$registration_id',`visitor_id`='$visitor_id',`fname`='$name',`mobile`='$visitorMobile',`pan_no`='$visitorPAN',`designation`='$visitorDesignation',`company`='$company_name',`photo_url`='$photo_url', `participant_type`='VIS',`covid_report_status`='pending',`status`='P',srl_report_url='vip'";
	//	$insertGlobalResult = $conn->query($insertGlobal);
		}
		
		/*Global Table End */
		
		}
		}
			
		} else {
			echo '<br/>Data not match';
		}						
	}
}
?>