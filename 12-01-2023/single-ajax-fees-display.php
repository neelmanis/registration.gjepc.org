<?php
include('header_include.php');
$show = $conn->real_escape_string($_REQUEST["show"]);
$registration_id = $conn->real_escape_string($_REQUEST["registration_id"]);
//$state = getStateForVisitor($_REQUEST["registration_id"],$conn);

$tritiya_discount = "no";
$visitor_id = $_SESSION['visitor_id'];
$visitor_sql  = "SELECT discount FROM `visitor_directory`  WHERE 1 and `registration_id`='".$registration_id."' AND `visitor_id`='$visitor_id'";
$result_visitor=$conn->query($visitor_sql);
$rows_visitor=$result_visitor->fetch_assoc();
$isdiscount = $rows_visitor['discount'];


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
$result_event = $conn->query("SELECT * FROM `visitor_event_master` WHERE `shortcode`='$show' ");
	$count_event = $result_event->num_rows;
	if($count_event > 0){
		$row_event = $result_event->fetch_assoc();
		$isFree = $row_event['isFree'];
}

if($isFree =="yes"){
		$participation_fee = 0;
} else {
     if($show =="iijstritiya23" && $tritiya_discount =="yes" && $isdiscount =="Y" ){
       $sql="SELECT * FROM `visitor_fee_structure` WHERE min_date <=  NOW() AND max_date >=  NOW() AND type='$type' AND `shortcode`='$show'";
			$result=$conn->query($sql);
			$count = $result->num_rows;
			if($count > 0){
				$row = $result->fetch_assoc();
			 	$participation_fee = $row['fees']-1000;
			}else{
			 	$participation_fee = "";
			}
        
     }else{
		//$sql="SELECT * FROM `visitor_fee_structure` WHERE min_date <=  NOW() AND max_date >=  NOW() AND type='$type' AND `shortcode`='$show'";
		$now = date('Y-m-d H:i:s');
		$sql="SELECT * FROM `visitor_fee_structure` WHERE min_date <=  '$now' AND max_date >=  '$now' AND type='$type' AND `shortcode`='$show'";
			$result=$conn->query($sql);
			$count = $result->num_rows;
			if($count > 0){
				$row = $result->fetch_assoc();
			 	$participation_fee = $row['fees'];
			}else{
			 	$participation_fee = "";
			}
     }	
	
}
echo $participation_fee;

// while($rows2=$result->fetch_assoc())
// {
// 	if($show == "signature22")
// 		echo $participation_fee = trim($rows2['signature22']);
// 	elseif($show == "igjme22")
// 		echo $participation_fee = trim($rows2['igjme']);
// 	else
// 		echo "";
// 	/*
// 	if($show == "iijs21")
// 		echo $participation_fee=$rows2['iijs21'];
// 	elseif($show == "igjme21")
// 		echo $participation_fee=$rows2['igjme'];
// 	else
// 		echo "";
// 	*/
	
// 	/*if($show == "vbsm")
// 		echo $participation_fee=$rows2['vbsm'];
// 	else
// 		echo ""; 
// 	if($show == "1show")
// 		echo $participation_fee=$rows2['1show'];
// 	elseif($show == "combo")
// 		echo $participation_fee=$rows2['combo'];
// 	elseif($show == "4show")
// 		echo $participation_fee=$rows2['4show'];
// 	elseif($show == "igjme")
// 		echo $participation_fee=$rows2['igjme'];
// 	else
// 		echo ""; */
// }
}
?>