<?php
include ("db.inc.php");
include ("functions.php");
session_start();

$action = $_REQUEST['action'];
if($action == 'plant_registration'){

	$visitor_type = 'exhibitor';
		$tree_name = filter($_POST['tree_name']);
		$tree_qty = filter($_POST['tree_qty']);
		$tree_amount = filter($_POST['tree_amount']);
		$fname = filter($_POST['fname']);
		$lname = filter($_POST['lname']);
		$mobile = filter($_POST['mobile']);
		$email = filter($_POST['email']);
		$billing_first_name = filter($_POST['billing_first_name']);
		$billing_last_name = filter($_POST['billing_last_name']);
		$billing_address_1 = filter($_POST['billing_address_1']);
		$billing_state = filter($_POST['billing_state']);
		$billing_city = filter($_POST['billing_city']);
		$billing_postcode = filter($_POST['billing_postcode']);
		$billing_pan_card_no = filter($_POST['billing_pan_card_no']);
		$billing_aadhar_card_no = filter($_POST['billing_aadhar_card_no']);
		$exhibitor_area = filter($_POST['exhibitor_area']);

		$insert =  "INSERT INTO plant_registration SET create_date=NOW(),registration_id='$registration_id',visitor_type='$visitor_type',tree_name='$tree_name',tree_qty='$tree_qty',tree_amount='$tree_amount',fname='$fname',lname='$lname',mobile='$mobile',email='$email',billing_first_name='$billing_first_name',billing_last_name='$billing_last_name',billing_address_1='$billing_address_1',billing_state='$billing_state',billing_city='$billing_city',billing_postcode='$billing_postcode',billing_pan_card_no='$billing_pan_card_no',billing_aadhar_card_no='$billing_aadhar_card_no',exhibitor_area='$exhibitor_area'";

		$response_url = "https://uat.sankalptaru.org/brand-promotions/gjpec-tree-plantation/?tree_name=".$tree_name."&phone_number=".$mobile."&email_id=".$email."&
billing_first_name="$billing_first_name"&billing_last_name=".$billing_last_name."&billing_address_1=".$billing_address_1."&billing_state=".$billing_state."&billing_city=".$billing_city."&billing_postcode=".$billing_postcode."&billing
_pan_card_number=".$billing_pan_card_no."&billing_aadhar_card_number=".$billing_aadhar_card_no."&tree_c
ount=".$tree_qty;

		$result = $conn->query($insert);

		if($result){
      echo json_encode("status"=>"success","response_url"=$response_url);exit;
		}else{
			 echo json_encode("status"=>"fail");exit;
		}
	
}


?>