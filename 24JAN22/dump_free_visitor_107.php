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
		
		$category = $resultHistory['category'];
		
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
			
		$checkHistorys = "SELECT * FROM `visitor_agency_registration` WHERE mobile='$visitorMobile' ";	
		$resultQuerys = $conn ->query($checkHistorys);
		$nums = $resultQuerys->num_rows;
		if($nums>0)
		{
			echo 'Already Registered';			
		} else {
		if($category == "VVIP"){
			$agency_id = '7';
			$cat = 'VV';
		} else if($category == "VIP"){
			$agency_id = '8';
			$cat = 'VIP';
		}
		
	echo	$sqlx = "INSERT INTO `visitor_agency_registration` 
        (`agency_id`, `person_name`, `mobile`, `category`,`committee`, `id_proof_name`,`id_proof_file`,`pan_no`,`photo`,`payment_made_for`,`show`,`year`,`person_status`,`createdDate`,`self_declaration`) VALUES (
        '$agency_id', '$name', '$visitorMobile','$cat','','','', '$visitorPAN','$visitorPhoto','iijs21','iijs21','2021','P',NOW(),'vip')";
	//    $result2 = $conn ->query($sqlx);
	/*
		$source = "images/employee_directory/".$registration_id."/photo/".$visitorPhoto;
			$destination  = 'images/covid/image/'.$visitorPhoto;
			copy($source ,$destination);
			echo "Copied $source INTO $destination <br/>";
			 
			if (!copy($source, $destination)) {
				echo "failed to copy $source...\n";
			} else {
				echo "copied $source into $destination\n";
			}
			*/
		}
			
		} else {
			echo '<br/>Data not match';
		}						
	}
}
?>