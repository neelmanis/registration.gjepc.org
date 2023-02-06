<?php
ob_start();
session_start();
include('../../db.inc.php');
include('../../functions.php');
if($_SERVER['REQUEST_METHOD'] == "POST"){

$json = file_get_contents('php://input');
$obj = json_decode($json,True);
$orderId = $obj["orderId"];

$q=$conn->query("select * from visitor_order_detail where orderId='$orderId'");
$r=$q->fetch_assoc();
	
	$registration_id=$r['regId'];
	$tpsl_txn_time=date('d-m-Y',strtotime($r['create_date']));	
	$orderId= $r['orderId'];	
	$email=getUserEmail($registration_id,$conn);
	$company_name=getCompanyName($registration_id,$conn);
	$saveSuccessMsg = "Failed Transaction Success In Db";
	/*$show ="iijs22";
	$year = 2022; */
    
	$orderUpdate ="update visitor_order_detail set payment_status='Y',txn_status='0300',txn_msg='success',payment_reason='$saveSuccessMsg',txn_err_msg='0',clnt_txn_ref='0',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='0',paymentThrough='NEFT' where orderId='$orderId' AND regId='$registration_id'";
	echo "<br/>";
	$getResult = $conn->query($orderUpdate);
	if(!$getResult) { die('Error: ' . $conn->error); }
		
	$getapplication ="SELECT total_payable FROM `visitor_order_detail` WHERE `regId` = '$registration_id' AND orderId='$orderId' AND payment_status='Y'";
	$getApplicationResult = $conn->query($getapplication);
	$getApplicationRow = $getApplicationResult->fetch_assoc();
	$total_payable = $getApplicationRow['total_payable'];
	$total_payable_word = number_word_v($total_payable);
				
	$ssx = "SELECT * FROM `visitor_order_temp` WHERE `registration_id`='$registration_id' AND orderId='$orderId'";
	$query_result=$conn->query($ssx);
	while($result1=$query_result->fetch_assoc())
	{ //echo '<pre>'; print_r($result1);
		$visitor_id = $result1['visitor_id'];
		$payment_made_for = $result1['payment_made_for'];		
		$amount = $result1['amount'];
		$show = $result1['show'];
		$year = $result1['year'];
	
		$name = getVisitorName($visitor_id,$conn);
		$visitorPAN = getVisitorPAN($visitor_id,$conn);
		$visitorMobile = getVisitorMobile($visitor_id,$conn);
		$designation = getVisitorDesignation($visitor_id,$conn);
		$visitorDesignation =  getVisitorDesignationID($designation,$conn); 
		$visitorPhoto =  getVisitorPhoto($visitor_id,$conn); 		 
		$photo_url = "https://registration.gjepc.org/images/employee_directory/".$registration_id."/photo/".$visitorPhoto;
		
		$company_name = trim(getCompanyName($registration_id,$conn));
     		
		$digits = 9;	
	    $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
	    $checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");
	    $countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
		while($countUniqueIdentifier > 0) {
		$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		}
		
		$checkGlobalRecord = "SELECT * FROM globalExhibition WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `pan_no`='$visitorPAN' AND participant_Type='VIS'";
		$globalResult = $conn->query($checkGlobalRecord);
        $checkGlobalCount = $globalResult->num_rows;
	    if($checkGlobalCount>0){
			
		} else { 
		$insertGlobal = "INSERT INTO globalExhibition  SET `uniqueIdentifier`='$uniqueIdentifier',`registration_id`='$registration_id',`visitor_id`='$visitor_id',`fname`='$name',`mobile`='$visitorMobile',`pan_no`='$visitorPAN',`designation`='$visitorDesignation',`company`='$company_name',`photo_url`='$photo_url',`participant_type`='VIS',`covid_report_status`='pending',`days_allow`='$days_allow',`event`='$payment_made_for',`status`='P'";
			$insertGlobalResult = $conn->query($insertGlobal);
		}
		
	$sqlx1 = "INSERT INTO `visitor_order_history`(`create_date`, `registration_id`, `orderId`,`visitor_id`, `payment_made_for`, `amount`,`show`, `year`,`payment_status`, `status`) VALUES (NOW(),'$registration_id','$orderId','$visitor_id','$payment_made_for','$amount','$show','$year','Y','1')";
	$result = $conn->query($sqlx1);
	if($result){
	$updatx = "DELETE FROM `visitor_order_temp` WHERE `registration_id`='$registration_id' AND `visitor_id` ='$visitor_id' AND `show`='$show' AND `year`='$year' ";
	$resultx = $conn->query($updatx);
	} else { echo "something error"; }
	}
	
	header('Content-type: application/json');
	echo json_encode(array("Response"=>$response));
	//print_r($response);
    ob_flush();
}
?>
