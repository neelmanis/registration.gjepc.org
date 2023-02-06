<?php
include('db.inc.php');
/*
$checkHistory = "SELECT * FROM `visitor_order_history` WHERE (payment_made_for='6show' OR payment_made_for='5show' OR payment_made_for='4show' OR payment_made_for='3show' OR payment_made_for='2show' OR payment_made_for='1show' OR payment_made_for='combo') AND `status`='1' AND payment_status='Y'";  
$resultQuery = $conn->query($checkHistory);
$num = $resultQuery->num_rows;
if($num>0)
{
 	while($resultHistory = $resultQuery->fetch_assoc())
 	{
		//echo '<pre>'; print_r($resultHistory);
 		$visitor_id =  $resultHistory['visitor_id'];
 		$registration_id = $resultHistory['registration_id'];
 		$photo = $resultHistory['photo'];
		
 		$src = './images/employee_directory/'.$registration_id.'/photo/'.$photo;
 		// echo '<br/>';
	     
	//	$checks = "select * from visitor_directory where 1 AND visitor_approval='D' AND disapprove_reason='Kindly update your data.' AND visitor_id='$visitor_id' AND registration_id='$registration_id' AND paymentThrough='onSpot' AND combo!=''";
		$checks = "select * from visitor_directory where 1 AND visitor_approval='D' AND disapprove_reason='Kindly update your data.' AND visitor_id='$visitor_id' AND registration_id='$registration_id' AND paymentThrough='onSpot' AND combo!=''";
		$resultData = $conn ->query($checks);
		echo '<br/>';
		$countx = $resultData->num_rows;
		if($countx >0){
			$imagesize = filesize($src);
			if($imagesize < 1024){ 
				echo 'corrupt image';
			} else {
			//	echo  '---'.$photo; echo '<br/>';
			echo $checkUpdate = "UPDATE `visitor_directory` SET `visitor_approval`='Y' WHERE registration_id='$registration_id' AND visitor_id='$visitor_id' AND disapprove_reason='Kindly update your data.'";
			$resultQuerys = $conn->query($checkUpdate);
			echo '<br/>';	
			}
			
		} else {
			echo 'No Data Found <br/>';
		}
	}
}
*/

//echo $checkHistory = "select * from visitor_directory where 1 AND visitor_approval='D' AND disapprove_reason='Kindly update your data.' AND paymentThrough='onSpot' AND combo!=''";  
echo $checkHistory = "select * from visitor_directory where 1 AND visitor_approval='D' AND disapprove_reason='Kindly update your data.' AND paymentThrough='onSpot'";  
$resultQuery = $conn->query($checkHistory);
$num = $resultQuery->num_rows;
if($num>0)
{
 	while($resultHistory = $resultQuery->fetch_assoc())
 	{
		//echo '<pre>'; print_r($resultHistory);
 		$visitor_id =  $resultHistory['visitor_id'];
 		$registration_id = $resultHistory['registration_id'];
 		$photo = $resultHistory['photo'];
		
 		$src = './images/employee_directory/'.$registration_id.'/photo/'.$photo;
 		// echo '<br/>';
	     
	/*	$checks = "SELECT * FROM `visitor_order_history` WHERE (payment_made_for='6show' OR payment_made_for='5show' OR payment_made_for='4show' OR payment_made_for='3show' OR payment_made_for='2show' OR payment_made_for='1show' OR payment_made_for='combo') AND `status`='1' AND payment_status='Y' AND visitor_id='$visitor_id' AND registration_id='$registration_id' ";
		$resultData = $conn ->query($checks);
		echo '<br/>';
		$countx = $resultData->num_rows;
		if($countx >0){ */
			$imagesize = filesize($src);
			if($imagesize < 1024){ 
				echo 'corrupt image';
			} else {
			//	echo  '---'.$photo; echo '<br/>';
			echo $checkUpdate = "UPDATE `visitor_directory` SET `visitor_approval`='Y' WHERE registration_id='$registration_id' AND visitor_id='$visitor_id' AND disapprove_reason='Kindly update your data.'";
	//		$resultQuerys = $conn->query($checkUpdate);
			echo '<br/>';	
			}
			
		/*} else {
			echo 'No Data Found <br/>';
		} */
	}
}

?>