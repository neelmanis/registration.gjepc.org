<?php
include('header_include.php');

/*......................................... Get visitor show which is selected 3 & 6 show ..............................................*/

// $checkHistory = "SELECT * FROM globalExhibition_migration where  isMigrated='N' and  dose2_status='Y' limit 1"; 
// $resultQuery = $conn ->query($checkHistory);
// $num = $resultQuery->num_rows;

// if($num>0)
// {
// 	while($resultHistory = $resultQuery->fetch_assoc())
// 	{
// 		  $id = $resultHistory['id'];
// 	       $query  =    "UPDATE globalExhibition SET `status` = 'Y'  WHERE id='".$resultHistory['id']."' AND `status` = 'P'";
// 	      $result = $conn ->query($query);
// 	      if ($result) {
// 	      	$conn ->query("UPDATE globalExhibition_migration SET isMigrated='Y' WHERE id='".$resultHistory['id']."' ");
// 	      	echo $id." -  Succeess";echo "<br>";
// 	      }else {
// 	      	echo $id.' - Entry not found';echo "<br>";
// 	      }
// 	} 
			
// }

// $checkHistory = "SELECT * FROM globalExhibition where  participant_type='INTL'  AND `event` ='signature22' limit 1 "; 
// $resultQuery = $conn ->query($checkHistory);
// $num = $resultQuery->num_rows;

// if($num>0)
// {
// 	while($resultHistory = $resultQuery->fetch_assoc())
// 	{
// 		  $visitor_id = $resultHistory['visitor_id'];
// 		  $registration_id = $resultHistory['registration_id'];
// 		  $payment_made_for = $resultHistory['event'];
		

// 	      $query  =    "SELECT ivr_registration_history WHERE `visitor_id` = '$visitor_id' ";
// 	      $result = $conn ->query($query);
// 	      if ($result->num_rows > 0) {
	      
// 	      	echo $visitor_id." -  already";echo "<br>";
// 	      }else {
// 	      	 $sql_insert = "INSERT INTO ivr_registration_history SET registration_id='$registration_id' , visitor_id='$visitor_id',payment_made_for='$payment_made_for',`amount`='0',`show`='$payment_made_for',`year`='2022',`payment_status`='Y',`downlaod_status`='N',`paymentThrough`='single',`badge_status`='P',`status`='1'";
// 	      	$conn ->query($sql_insert);
// 	      		echo $visitor_id." -  inserted";echo "<br>";
// 	      }
// 	} 
			
// }

?>