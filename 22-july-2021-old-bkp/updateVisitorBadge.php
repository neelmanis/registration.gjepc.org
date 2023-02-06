<?php
include('db.inc.php');
include('functions.php');
if($_SERVER['REQUEST_METHOD'] == "POST"){
	
$json = file_get_contents('php://input');
$obj = json_decode($json,True);

$uniqueId= $obj["uniqueId"];
$badge_status= $obj["badge_status"];
$tracking_no= $obj["tracking_no"];
$remarks= $obj["remarks"];

$q=mysql_query("select * from visitor_order_history where visitor_id='$uniqueId'");
$n=mysql_num_rows($q);

	if($n > 0) {
	$sqlx = "update  visitor_order_history set badge_status='$badge_status',tracking_no='$tracking_no',remarks='$remarks' where visitor_id='$uniqueId'";
	$sqlDatas = mysql_query($sqlx) or die(mysql_error());
	
	//$sendMobile="9987753842,9619662253";
	$sendMobile=getVisitorMobile($uniqueId);
	
	if($badge_status=="C"){
	$message = "Badge for Registration Number :".$uniqueId.", has been couriered. Kindly track your badge at www.indiapost.gov.in, with Tracking:  ".$tracking_no;
	get_data($message,$sendMobile);
	}elseif($badge_status=="CR"){
	$message = "Delivery failed for couriered Badge with Registration Number :".$uniqueId.". Kindly show this SMS at the Badge Pickup Counter , Registration Hall and collect your badge";
	
	get_data($message,$sendMobile);	
	}
	
	$strResponse=array(
					"Result"=>"Record Updated Successfully",
					"Message"=>'Success',
					"status"=>"true"
				  );
	} else {
		$strResponse=array(
						"Result"=>'',
						"Message"=>'No Record Found.',
						"status"=>"false"
				      );
		}
	} else {
		$strResponse=array(
						"Result"=>'',
						"Message"=>'No Response Found.',
						"status"=>"false"
					  );
	}
	header('Content-type: application/json');
     echo json_encode(array("Response"=>$strResponse));
?>