<?php
include('header_include.php');
$show = $conn->real_escape_string($_REQUEST["show"]);
$registration_id = $conn->real_escape_string($_REQUEST["registration_id"]);
$state = getStateForVisitor($_REQUEST["registration_id"],$conn);

$sql="SELECT * FROM `approval_master`  WHERE 1 and `registration_id`='".$registration_id."' AND issue_membership_certificate_expire_status='Y'";
$result=$conn->query($sql);
$rows1=$result->fetch_assoc();
$num_rows=$result->num_rows;
if($num_rows>0)
{
	$type='M';
} else {
	$type='NM';
}

if(isset($type) && !empty($type))
{
$sql="SELECT * FROM `visitor_fee_structure` WHERE min_date <=  NOW() AND max_date >=  NOW() AND type='$type'";
$result=$conn->query($sql);
while($rows2=$result->fetch_assoc())
{
	if($show == "iijs21" && $state!=10)
		echo $participation_fee=$rows2['iijs21'];
	elseif($show == "iijs21" && $state==10)
		echo $participation_fee = $rows2['iijs21']-250;
	elseif($show == "igjme21")
		echo $participation_fee=$rows2['igjme'];
	else
		echo "";
	/*
	if($show == "iijs21")
		echo $participation_fee=$rows2['iijs21'];
	elseif($show == "igjme21")
		echo $participation_fee=$rows2['igjme'];
	else
		echo "";
	*/
	
	/*if($show == "vbsm")
		echo $participation_fee=$rows2['vbsm'];
	else
		echo ""; 
	if($show == "1show")
		echo $participation_fee=$rows2['1show'];
	elseif($show == "combo")
		echo $participation_fee=$rows2['combo'];
	elseif($show == "4show")
		echo $participation_fee=$rows2['4show'];
	elseif($show == "igjme")
		echo $participation_fee=$rows2['igjme'];
	else
		echo ""; */
}
}
?>