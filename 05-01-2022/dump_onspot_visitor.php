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

function getVisitorID($pan_no,$conn)
{
	$query_sel = "SELECT visitor_id FROM visitor_directory where pan_no='$pan_no' ";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['visitor_id'];
}

function getRegisID($pan_no,$conn)
{
	$query_sel = "SELECT registration_id FROM visitor_directory where pan_no='$pan_no' ";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['registration_id'];
}

echo $checkHistory = "SELECT * FROM dump_visitor_refund";
$resultQuery = $conn ->query($checkHistory);
$num = $resultQuery->num_rows;
if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
	{ //echo '<pre>'; print_r($resultHistory);
		$name = $resultHistory['person'];
		$visitorPAN = $resultHistory['visitor_pan_no'];
		$mobile = $resultHistory['mobile'];
		$photo_name = $resultHistory['photo_name'];
		$registration_id = getRegisID($visitorPAN,$conn);
		$visitor_id = getVisitorID($visitorPAN,$conn);
		
	echo	$checks = "select * from visitor_directory where visitor_id='$visitor_id' AND registration_id='$registration_id'";
		echo '<br/>';
		$resultData = $conn ->query($checks);
		$countx = $resultData->num_rows;
		if($countx >0){
			
		echo $update = "update visitor_directory set paymentThrough='machinery' where visitor_id='$visitor_id' AND registration_id='$registration_id'";
	//	$resultQuerys = $conn ->query($update);
		} else {
			echo '<br/>Data not match';
		echo '<br/>'.	$insert = "insert into visitor_directory set name='$name',pan_no='$visitorPAN',mobile='$mobile',photo='$photo_name',status='1',visitor_approval='D',isApplied='Y',paymentThrough='machinery'";
	//	$resultQueryt = $conn ->query($insert);
		echo '<br/>';
		}						
	}
}
?>