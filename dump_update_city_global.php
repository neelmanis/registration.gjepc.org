<?php
include('header_include.php');

echo $checkHistory = "SELECT distinct(registration_id) from globalExhibition where participant_Type='VIS' AND city IS NULL"; 
$resultQuery = $conn ->query($checkHistory);
$num = $resultQuery->num_rows;
if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
	{
		$registration_id = $resultHistory['registration_id'];
	$cityName = strtoupper(getCompanyCityName($registration_id,$conn));
	echo '<br/>';	

			
	echo	$updateCovidStatus = "UPDATE globalExhibition SET `city`='$cityName',srl_report_url='city' WHERE `registration_id`='$registration_id' AND city IS NULL AND `participant_Type`='VIS'";
     //   $resultStatusUpdate = $conn->query($updateCovidStatus);
	}
}
?>