<?php
include ("db.inc.php");
include ("functions.php");
session_start();

$action = $_REQUEST['action'];

if($action == 'submitAddressAction')
{ 
	$registration_id = $_SESSION['registration_id'];
	if(empty($registration_id)){
	  header("location:single_visitor.php");
	}

	$address1 = filter($_POST['address1']);
	$address2 = filter($_POST['address2']);
	$state = filter($_POST['state']);
	$city = filter($_POST['city']);
	$pin_code = filter($_POST['pin_code']);

	if(isset($registration_id) && $registration_id!="")
	{
		$sqlx = "INSERT INTO `n_m_billing_address`(`registration_id`, `post_date`,`type_of_address`, `address1`, `address2`, `state`, `city`, `pin_code`) VALUES ('$registration_id',NOW(),'2', '$address1','$address2','$state','$city','$pin_code')";
		$resultx = $conn->query($sqlx);
		if($resultx){
			echo json_encode(array('status'=>'success')); exit;				
		}
	} else {
		echo json_encode(array('status'=>'sessionExpired'));exit; 
	}
}
?>