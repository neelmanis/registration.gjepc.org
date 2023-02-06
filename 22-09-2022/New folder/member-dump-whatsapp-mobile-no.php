<?php
include('db.inc.php');

$checkHistory = "SELECT distinct(mobile) FROM gjepclivedatabase.whatsapp_number_directory where `type`='member' and isPush='N' limit 500 ";
$resultQuery = $conn ->query($checkHistory);
$num = $resultQuery->num_rows;
if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
	{ //echo '<pre>'; print_r($resultHistory);
			$mobile_no = $resultHistory['mobile'];

		 $checks = "SELECT mobile FROM gjepclivedatabase.communication_address_master where mobile_no='$mobile_no' AND whatsapp_verified='0' ";
			echo '<br/>';
			$resultData = $conn ->query($checks);
			$countx = $resultData->num_rows;
			if($countx >0){
		   $del = "UPDATE gjepclivedatabase.communication_address_master SET whatsapp_verified='1' WHERE mobile_no='$mobile_no'";
		 
		//echo $del.'<br/>';
			$delQuery = $conn ->query($del);
			
			if($delQuery)
			{
				$conn->query("UPDATE gjepclivedatabase.whatsapp_number_directory SET isPush='Y' WHERE mobile='$mobile_no'");
				echo 'Updated'; echo '<br/>';
			} else { 
				$conn->query("UPDATE gjepclivedatabase.whatsapp_number_directory SET isPush='Y' WHERE mobile='$mobile_no'");
				echo ' not update'; echo '<br/>';
			}	
			} else {
					echo $Mobile. ' Mobile No Not MATCH'; echo '<br/>';
			}
	}	
}
$conn->close();
?>