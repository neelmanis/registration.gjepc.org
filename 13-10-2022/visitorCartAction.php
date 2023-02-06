<?php 
include ("db.inc.php");
include ("functions.php");
session_start();
$registration_id = intval(filter($_SESSION['USERID']));

if(!isset($registration_id)){ header("location:login.php");	exit; }
?>
<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="saveVisitorDetails")
{
	if(isset($_POST['visitor_id'])){
    $visitor_id = $_POST['visitor_id'];
    }else{
    $visitor_id = "";
    }

	$payment_made_for = filter($_POST['payment_made_for']);
	$amount	=	filter($_POST['participation_fee']);
	$show	=	filter($_POST['show']);
	$year	=	filter($_POST['year']);

	if(empty($visitor_id)  && empty($payment_made_for) && empty($amount) ){
		echo json_encode(array('status' =>"allEmpty"));exit;
	}elseif(empty($visitor_id)){
        echo json_encode(array('status' => "visEmpty"));exit;
	}elseif(empty($payment_made_for) ){
        echo json_encode(array('status' =>"showEmpty"));exit;
	}
    
    $visCount = count($visitor_id);
    $amountPerVis = $amount	/ $visCount;

	if(isset($registration_id) && $registration_id!=""){
	if($visCount>0 && is_array($visitor_id)){

		foreach ($visitor_id as $visitor) {
			$checkVisitor = "SELECT * FROM `visitor_order_temp` WHERE visitor_id='$visitor' AND registration_id='$registration_id' AND `show`='$show' AND `year`='$year' AND `status`='1' AND paymentThrough='online'";
	        $checkVisitorResult = $conn->query($checkVisitor);
	        $getCountx = $checkVisitorResult->num_rows;

	        if($getCountx ==0){
	        	$ins = "INSERT INTO `visitor_order_temp`(`registration_id`, `visitor_id`, `payment_made_for`, `amount`,`show`, `year`, `status`,`paymentThrough`) VALUES ('$registration_id','$visitor','$payment_made_for','$amountPerVis','$show','$year','1','online')"; 
	            $getResult = $conn->query($ins);
	        }
		}
		echo json_encode(array('status' => "success"));exit;
	}else
	{
	    echo json_encode(array('status' => "visEmpty"));exit;
	}
	}
}
?>


