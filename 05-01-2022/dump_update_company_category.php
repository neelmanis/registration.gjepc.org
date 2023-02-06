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


$checkHistory = "SELECT * FROM elite_visitors where 1 AND category='ELITE'";
$resultQuery = $conn ->query($checkHistory);
$num = $resultQuery->num_rows;
if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
	{ //echo '<pre>'; print_r($resultHistory);
			$company_pan_no = $resultHistory['company_pan'];
			$registration_id = getRegisID($company_pan_no,$conn);
			$category = $resultHistory['category'];
			$visitor_pan = $resultHistory['pan_no'];
			
			
		echo $checks = "select * from registration_master where company_pan_no='$company_pan_no'";
			echo '<br/>';
			$resultData = $conn ->query($checks);
			$countx = $resultData->num_rows;
			if($countx >0){
			
		/*	echo $comp_update = "UPDATE registration_master SET category='$category' WHERE id='$registration_id'";
			$comp_updateQuery = $conn ->query($comp_update);
		*/
		
		echo $del = "UPDATE visitor_directory SET category='$category' WHERE registration_id='$registration_id' AND pan_no='$visitor_pan'";
		//	$delQuery = $conn ->query($del);
			$num = $delQuery->num_rows;
			if($nums>0)
			{
				echo 'Updated';
			} else { 
				echo 'not update';
			}	
			} else {
					echo $company_pan_no.' Company PAN Not MATCH';
			}
	}	
}	
?>