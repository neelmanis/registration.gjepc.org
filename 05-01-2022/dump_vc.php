<?php
include('db.inc.php');
/*
$checkHistory = "SELECT * FROM gjepclivedatabase.badge_vc_dump limit 6000,500";
$resultQuery = $conn ->query($checkHistory);
$num = $resultQuery->num_rows;
if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
	{ //echo '<pre>'; print_r($resultHistory);
			$registration_id = $resultHistory['registration_id'];
			$visitor_id = $resultHistory['visitor_id'];
			$mobile_no = $resultHistory['mobile_no'];
			$pan_no = "EXH".$visitor_id;
			
		//echo $checks = "SELECT * FROM gjepclivedatabase.visitor_lab_info where 1 AND registration_id='$registration_id' AND category_for='EXH' AND (lab_name!='c' || lab_name IS NULL)";
		echo $checks = "SELECT * FROM gjepclivedatabase.visitor_lab_info where 1 AND registration_id='$registration_id' AND category_for='EXH' AND (lab_name!='c' || lab_name IS NULL)";
			echo '<br/>';
			$resultData = $conn ->query($checks);
			$countx = $resultData->num_rows;
			if($countx >0){
		 $del = "UPDATE gjepclivedatabase.visitor_lab_info SET visitor_id='$visitor_id',pan_no='$pan_no',lab_name='c' WHERE registration_id='$registration_id' AND mobile_no='$mobile_no' AND category_for='EXH'";
		//echo $del.'<br/>';
			//$delQuery = $conn ->query($del);
			$num = $delQuery->num_rows;
			if($nums>0)
			{
				echo 'Updated';
			} else { 
				echo 'not update';
			}	
			} else {
					echo $registration_id.' Registration ID Not MATCH';
			}
	}	
}
*/


$checkHistory = "SELECT * FROM gjepclivedatabase.dump_exh_vc limit 10000,1000";
$resultQuery = $conn ->query($checkHistory);
$num = $resultQuery->num_rows;
if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
	{ //echo '<pre>'; print_r($resultHistory);
			$mobile_no = $resultHistory['mobile_no'];

		echo $checks = "SELECT * FROM gjepclivedatabase.visitor_lab_info where 1 AND mobile_no='$mobile_no' AND category_for='VIS' AND (lab_name!='exh' || lab_name IS NULL)";
			echo '<br/>';
			$resultData = $conn ->query($checks);
			$countx = $resultData->num_rows;
			if($countx >0){
		echo $del = "UPDATE gjepclivedatabase.visitor_lab_info SET lab_name='exh' WHERE mobile_no='$mobile_no' AND category_for='VIS'";
		//echo $del.'<br/>';
		//	$delQuery = $conn ->query($del);
			$num = $delQuery->num_rows;
			if($nums>0)
			{
				echo 'Updated';
			} else { 
				echo ' not update';
			}	
			} else {
					echo $registration_id. ' Registration ID Not MATCH';
			}
	}	
}
?>