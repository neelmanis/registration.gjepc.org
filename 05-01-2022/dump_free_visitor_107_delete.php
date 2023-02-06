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

/*echo $checkHistory = "SELECT * FROM globalExhibition where 1 AND participant_Type='VIS'";
$resultQuery = $conn ->query($checkHistory);
$num = $resultQuery->num_rows;
if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
	{ //echo '<pre>'; print_r($resultHistory);
		$visitorPAN = $resultHistory['pan_no'];
		$id = $resultHistory['id'];
	
	echo	$checks = "SELECT * FROM gjepclivedatabase.free_vip_visitors where 1 AND pan_no='$visitorPAN'";
		echo '<br/>';
		$resultData = $conn ->query($checks);
	echo	$countx = $resultData->num_rows;
		if($countx >0){
			echo '<br/> Mila';
		//	echo $update = "UPDATE `globalExhibition` SET `status` = 'D' WHERE pan_no='$visitorPAN'  AND participant_Type='VIS'";
		//	$updateQuery = $conn ->query($update);
			
			echo $del = "DELETE FROM globalExhibition WHERE pan_no='$visitorPAN' AND participant_Type='VIS'";
		//	$updateQuery = $conn ->query($del);
		}	else {
		echo '<br/> Not Found';
		}			
	}
} */


/*
$checkHistory = "SELECT * FROM free_vip_visitors where 1 ";
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
			
			$checks = "select * from visitor_directory where visitor_id='$visitor_id' AND registration_id='$registration_id' AND visitor_approval='Y'";
			echo '<br/>';
			$resultData = $conn ->query($checks);
			$countx = $resultData->num_rows;
			if($countx >0){
			
			echo $del = "select * FROM visitor_order_history WHERE 1 visitor_id='$visitor_id' AND registration_id='$registration_id' AND payment_made_for='iijs21'";
			$delQuery = $conn ->query($del);
			$num = $delQuery->num_rows;
			if($nums>0)
			{
				echo 'delete';
			} else { 
				echo 'not found';
			}
			
			}
	}	
}	else {
		echo '<br/> Not Found';
}	*/	

$checkHistory = "SELECT * FROM vvip_visitors where 1 ";
$resultQuery = $conn ->query($checkHistory);
$num = $resultQuery->num_rows;
if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
	{ //echo '<pre>'; print_r($resultHistory);
			$company_pan_no = $resultHistory['pan_no'];
			$category = $resultHistory['category'];
			$registration_id = getRegisID($company_pan_no,$conn);
			
		echo $checks = "select * from registration_master where company_pan_no='$company_pan_no'";
			echo '<br/>';
			$resultData = $conn ->query($checks);
			$countx = $resultData->num_rows;
			if($countx >0){
			
			echo $del = "UPDATE visitor_directory SET category='$category' WHERE registration_id='$registration_id'";
		//	$delQuery = $conn ->query($del);
			$num = $delQuery->num_rows;
			if($nums>0)
			{
				echo 'Updated';
			} else { 
				echo 'not found';
			}			
			}
	}	
}	else {
		echo '<br/> Not Found';
}	
?>