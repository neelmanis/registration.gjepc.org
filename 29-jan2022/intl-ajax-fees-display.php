<?php
include('header_include.php');
if(!isset($_SESSION['USERID'])){	header("location:login.php");	exit;	}
//$state = getStateForVisitor($_SESSION['USERID'],$conn);
$registration_id = $_SESSION['USERID'];
//$sql="select * from approval_master where registration_id='".$_SESSION['USERID']."' AND (`membership_issued_certificate_dt` between '2019-03-31' and '2020-03-31' || invoice_date between '2019-03-31' and '2020-03-31')";
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

$action = filter($_REQUEST['action']);

// FETCH ALL EMPLOYEES ON SHOW SELECTION
if($action == "get_employees"){

	$show = filter($_REQUEST["show"]);
	$sql_vis = "SELECT CONCAT(first_name, ' ', last_name) AS visitor_name, eid,application_approved FROM ivr_registration_details 
			WHERE NOT EXISTS 
			(SELECT * FROM ivr_registration_history 
			WHERE ivr_registration_details.eid = ivr_registration_history.visitor_id and ivr_registration_history.payment_status='Y' and (ivr_registration_history.payment_made_for='$show' || ivr_registration_history.payment_made_for='6show') ) AND `application_approved`='Y' AND `uid`='".$_SESSION['USERID']."'";

	$query_vis=$conn->query($sql_vis);
	$count_vis = $query_vis->num_rows;
	$html .='<option value="">Select Employee</option>';
	if($count_vis > 0) {
		while($row_vis = $query_vis->fetch_assoc()){
			$html .='<option value="'.$row_vis['eid'].'">'.$row_vis['visitor_name'].'</option>';
		}
	} else {
		$html .='<option value="0">Not found</option>';
	}
	echo json_encode(array("output"=>$html));exit;
}


// FETCH PARTICIPATION FEES ON EMPLOYEE SELECTION
if($action == "get_fees"){
	$show = filter($_REQUEST["show"]);
	$result_event = $conn->query("SELECT * FROM `visitor_event_master` WHERE `shortcode`='$show' ");
	$count_event = $result_event->num_rows;
	if($count_event > 0){
		$row_event = $result_event->fetch_assoc();
		$isFree = $row_event['isFree'];
	}
	if($isFree =="yes"){
		$participation_fee = 0;
	}else{
		$sql="SELECT * FROM `visitor_fee_structure` WHERE min_date <=  NOW() AND max_date >=  NOW() AND type='$type' AND `shortcode`='$show'";
		$result=$conn->query($sql);
		$count = $result->num_rows;
		if($count > 0){
			$row = $result->fetch_assoc();
		 	$participation_fee = 0;
		}else{
		 	$participation_fee = "";

		}
	}
	echo json_encode(array("output"=>$participation_fee));exit;
}

if(isset($_POST['actiontype']) && $_POST['actiontype']=="saveVisitorDetails")
{  
	// echo "<pre>"; print_r($_POST);exit;
	$visitor_id = filter($_POST['visitor_id']);
	$payment_made_for = filter($_POST['payment_made_for']);
	$amount	=	filter($_POST['participation_fee']);
	
	// GET SHOW YEAR FROM MASTER
	$year	=	getVisEventYear($_POST['payment_made_for'],$conn);
	
	if(isset($registration_id) && $registration_id!=""){
		if($visitor_id!='0' && !empty($visitor_id) && !empty($payment_made_for) ){

			// CHECK CURRENTLY SELECTED SHOW IS DIFFERENT THAN TEMP SHOW
			$checkTemp = "SELECT * FROM `ivr_registration_order_temp` WHERE  registration_id='$registration_id' AND `show` !='$payment_made_for' AND `status`='1' AND paymentThrough='online'";
			$checkTempResult = $conn->query($checkTemp);
			$getTempCount = $checkTempResult->num_rows;
			if($getTempCount>0)
			{
				echo json_encode(array("status"=>"error","message"=>"Please complete your registration for previous selected show and continue"));exit;
			} else {
				$checkVisitor = "SELECT * FROM `ivr_registration_order_temp` WHERE visitor_id='$visitor_id' AND registration_id='$registration_id' AND `show`='$payment_made_for' AND `year`='$year' AND `status`='1' AND paymentThrough='online'";
				$checkVisitorResult = $conn->query($checkVisitor);
				$getCountx = $checkVisitorResult->num_rows;
				if($getCountx==0)
				{
					  $ins = "INSERT INTO `ivr_registration_order_temp`(`registration_id`, `visitor_id`, `payment_made_for`, `amount`,`show`, `year`, `status`,`paymentThrough`) VALUES ('$registration_id','$visitor_id','$payment_made_for','$amount','$payment_made_for','$year','1','online')"; 
					$getResult = $conn->query($ins);
					if($getResult)
						{
							echo json_encode(array("status"=>"success","message"=>"Visitor has been added successfully"));exit;

						}
				} else {
					echo json_encode(array("status"=>"error","message"=>"Visitor is already added"));exit;
				}
			}

		} else {
			echo json_encode(array("status"=>"error","message"=>"Something went wrong"));exit;

		}
	}
}

if(isset($_POST['actiontype']) && $_POST['actiontype']=="deleteItemDetails"){
	$id = trim($_POST['v_id']);
	$sqlx = "delete from ivr_registration_order_temp where id='$id' AND registration_id='$registration_id'";
	$deleteResult = $conn->query($sqlx);
}

?>