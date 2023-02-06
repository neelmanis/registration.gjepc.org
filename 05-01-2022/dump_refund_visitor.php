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

echo $checkHistory = "SELECT * FROM dump_visitor_refund";
$resultQuery = $conn ->query($checkHistory);
$num = $resultQuery->num_rows;
if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
	{ //echo '<pre>'; print_r($resultHistory);
		$company_pan_no = $resultHistory['company_pan'];
		$visitorPAN = $resultHistory['visitor_pan_no'];
		$registration_id = getRegisID($company_pan_no,$conn);
		$visitor_id = getVisitorID($visitorPAN,$conn);
	
		$payment_made_for = "signature22";
		
	echo	$checks = "select * from visitor_directory where visitor_id='$visitor_id' AND registration_id='$registration_id' AND visitor_approval='Y'";
		echo '<br/>';
		$resultData = $conn ->query($checks);
		$countx = $resultData->num_rows;
		if($countx >0){
			
	echo	$checkHistorys = "SELECT * FROM `visitor_order_history` WHERE payment_made_for='$payment_made_for' AND `registration_id`='$registration_id' AND visitor_id='$visitor_id' AND payment_status='Y'";	
		$resultQuerys = $conn ->query($checkHistorys);
		$nums = $resultQuerys->num_rows;
		if($nums>0)
		{
			echo 'Already Registered for Signature Show will update refund status';
	echo '<br/>';
	echo	$sqlx1 = "UPDATE visitor_order_history set payment_status='F',remarks='refund' where registration_id='$registration_id' AND visitor_id='$visitor_id' AND payment_made_for='$payment_made_for'";
	//	$result = $conn->query($sqlx1);
	
		/*Global Table Start */
						
		$checkGlobalRecord = "SELECT * FROM globalExhibition WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `pan_no`='$visitorPAN' AND participant_Type='VIS'";
		$globalResult = $conn->query($checkGlobalRecord);
        $checkGlobalCount = $globalResult->num_rows;
	    if($checkGlobalCount>0){
			echo 'Already Registered for Current Show';	
	echo		$insertGlobal = "UPDATE globalExhibition  SET srl_report_url='refund',status='P',disapprove_reason='refund' WHERE`registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `pan_no`='$visitorPAN' AND `participant_type`='VIS'";
	//	$insertGlobalResult = $conn->query($insertGlobal);
		} else { 
			echo '-------------';	
		}
		
		/*Global Table End */
		
		} else {
			echo '<------------->';

		}
			
		} else {
			echo '<br/>Data not match';
		}						
	}
}
?>