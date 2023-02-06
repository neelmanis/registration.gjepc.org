<?php
include('header_include.php');

/*......................................... Get visitor show which is selected 3 & 6 show ..............................................*/

echo $checkHistory = "SELECT * FROM visitor_lab_info where 1 and category_for='VIS' AND approval_status='Y' limit 4000,1000"; 
$resultQuery = $conn ->query($checkHistory);
$num = $resultQuery->num_rows;

if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
	{
		$approval_status = $resultHistory['approval_status'];
		if($approval_status =="N"){
        $covid_report_status = "positive";
		} else if($approval_status =="Y"){
        $covid_report_status = "negative";
	    } else {
        $covid_report_status = "pending";
		}
		$certificate = $resultHistory['certificate'];
		$dose1_status   = $resultHistory['dose1_status'];
		$dose2_status   = $resultHistory['dose2_status'];
		$isDownload = $resultHistory['isDataPosted'];
		$registration_id = $resultHistory['registration_id'];
		$visitor_id = $resultHistory['visitor_id'];
        if($isDownload =="N"){
            $updateStatus = "I";
        } else {
            $updateStatus = "U";
        }
	
	echo '<br/>';	
		
		echo	$checks = "select * from globalExhibition where visitor_id='$visitor_id' AND registration_id='$registration_id' AND status='P' AND participant_Type='VIS'";
		echo '<br/>';
		$resultData = $conn ->query($checks);
		$countx = $resultData->num_rows;
		if($countx >0){
			
	echo	$updateCovidStatus = "UPDATE globalExhibition SET `covid_report_status`='$covid_report_status',`status`='$approval_status',`certificate`='$certificate',`dose1_status`='$dose1_status',`dose2_status`='$dose2_status',isDataPosted='N',`updateStatus`='$updateStatus',srl_report_url='updateViaDump' WHERE  `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `participant_Type`='VIS' ";
     //   $resultStatusUpdate = $conn->query($updateCovidStatus);
		
		} else {
			echo 'Datanot match';
		}
	
	}
}
?>