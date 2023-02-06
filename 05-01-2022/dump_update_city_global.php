<?php
include('header_include.php');
/*
echo $checkHistory = "SELECT distinct(registration_id) from globalExhibition where participant_Type='VIS' AND country IS NULL"; 
$resultQuery = $conn ->query($checkHistory);
$num = $resultQuery->num_rows;
if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
	{
		$registration_id = $resultHistory['registration_id'];
	$cityName = strtoupper(getCompanyCityName($registration_id,$conn));
	$stateCode = strtoupper(getCompanyStateName($registration_id,$conn));
	$stateName = strtoupper(getStateName($stateCode,$conn));
	echo '<br/>';	

			
	echo	$updateCovidStatus = "UPDATE globalExhibition SET `city`='$cityName',country='IN',state='$stateName',srl_report_url='city' WHERE `registration_id`='$registration_id' AND country IS NULL AND `participant_Type`='VIS'";
    //    $resultStatusUpdate = $conn->query($updateCovidStatus);
	}
} */

function getCountryByRegistrationID($id,$conn)
{
	$query_sel = "SELECT country FROM registration_master where id='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		 	
	 		
		return $row['country'];		
}

echo $checkHistory = "SELECT distinct(registration_id) from globalExhibition where participant_Type='INTL' AND country IS NULL"; 
$resultQuery = $conn ->query($checkHistory);
$num = $resultQuery->num_rows;
if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
	{
		$registration_id = $resultHistory['registration_id'];
		$country_code = getCountryByRegistrationID($registration_id,$conn);
	$getCountryName = strtoupper(getCountryName($country_code,$conn));
	$cityName = strtoupper(getCompanyCityName($registration_id,$conn));
	$stateCode = strtoupper(getCompanyStateName($registration_id,$conn));
	//$stateName = strtoupper(getStateName($stateCode,$conn));
	echo '<br/>';	

			
	echo	$updateCovidStatus = "UPDATE globalExhibition SET `city`='$cityName',country='$getCountryName',state='$stateCode',srl_report_url='state' WHERE `registration_id`='$registration_id' AND country IS NULL AND `participant_Type`='INTL'";
    //   $resultStatusUpdate = $conn->query($updateCovidStatus);
	}
}
?>