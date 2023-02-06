<?php
include('header_include.php');
if(!isset($_SESSION['USERID'])){	header("location:login.php");	exit;	}
$visitorsCount = filter($_POST["totalVisitors"]);
$show = filter($_POST["show"]);
$action =filter($_POST["action"]); 

$sql="SELECT * FROM `approval_master`  WHERE 1 and `registration_id`='".$_SESSION['USERID']."' AND issue_membership_certificate_expire_status='Y'";
$result=$conn->query($sql);
$rows1=$result->fetch_assoc();
$num_rows=$result->num_rows;
if($num_rows>0)
{
	$type='M';
} else {
	$type='NM';
}

if($visitorsCount >0 && $action =="visitorsFeesCalculation" && $show  !=""){
$sql="SELECT * FROM `visitor_fee_structure` WHERE min_date <=  NOW() AND max_date >=  NOW() AND type='$type'";
$result=$conn->query($sql);
while($rows2=$result->fetch_assoc())
{
	if($show == "1show"){

		echo $participation_fee=$rows2['1show']*$visitorsCount;
		
	}
	elseif($show == "4show"){
		echo $participation_fee=$rows2['4show']*$visitorsCount;
	}
	elseif($show == "combo"){
		echo $participation_fee=$rows2['combo']*$visitorsCount;
	}
	elseif($show == "igjme"){
		echo $participation_fee=$rows2['igjme']*$visitorsCount;
	}
	else{
		echo "";
	}
}
}

?>