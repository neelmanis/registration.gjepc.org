<?php 
include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php"); exit; }
$uid = intval($_SESSION['USERID']);

$year = "2023"; 
$eventInfo = $_SESSION['eventInfo']; /* Get Event Selected */
$event_selected = $eventInfo['event_selected'];
$eventDescription = getExhEventDescriptionEvent($event_selected,$conn);
if(empty($event_selected)){ header("location:my_dashboard.php"); exit; }
if($_SESSION['eventInfo']['event_selected']){
	$event_for = getExhEventDescriptionEvent($_SESSION['eventInfo']['event_selected'],$conn); 
	$eventMail = $event_for; 
}

$getgeneralInfo = $_SESSION['generalInfo']; /* Get 1 step data */
$getcompanyInfo = $_SESSION['companyInfo']; /* Get 2 step data */
$getstallInfo = $_SESSION['stallInfo'];  /* Get 3 step data */
//echo '<pre>'; print_r($getstallInfo); exit;
//$show = "IIJS Signature 2020";

$action = $_REQUEST['action'];
if($action=="save")
{	
	//echo '<pre>'; print_r($getgeneralInfo); 
	//echo '<pre>'; print_r($getcompanyInfo); 
	//echo '<pre>'; print_r($getstallInfo); 
	/* Insert Step 1 Data */
	
	$sqlmx="select contact_person,region from exh_reg_general_info where uid='$uid' and event_selected='$event_selected' order by id desc limit 0,1";
	$querymx=$conn->query($sqlmx);
	$resultmx=$querymx->fetch_assoc();
	$contact_person=$resultmx['contact_person'];
	$region=$resultmx['region'];

	if($region=='HO-MUM (M)'){$to_admin='notification@gjepcindia.com'; }
	if($region=='RO-CHE'){$to_admin='p.anand@gjepcindia.com'; }
	if($region=='RO-DEL'){$to_admin='pranabes@gjepcindia.com'; }
	if($region=='RO-JAI'){$to_admin='ajaypurohit@gjepcindia.com'; }
	if($region=='RO-KOL'){$to_admin='kaushik@gjepcindia.com'; }
	if($region=='RO-SRT'){$to_admin='malcom@gjepcindia.com,utsav.ansurkar@gjepcindia.com'; }

	if(strtoupper($_SESSION['COUNTRY'])=="IN")
	{
	$currency = ""; 
	$int_type = "N"; 
	$payment_mode = "online";
	$bank_acc_no = $conn->real_escape_string($_POST["bank_acc_no"]);
	$name_bank = $conn->real_escape_string($_POST["bank_name"]);
	$name_bank_branch = $conn->real_escape_string($_POST["branch_name"]);
	$ifsc_code = $conn->real_escape_string($_POST["ifsc_code"]);
	$int_acc_type = $conn->real_escape_string($_POST["int_acc_type"]);
		
	$tds_holder = $conn->real_escape_string($_POST["tds_holder"]);
	if($tds_holder == 'Yes') {	
	$cheque_tds_per = $conn->real_escape_string($_POST["cheque_tds_per"]);
	$cheque_tds_amount = $conn->real_escape_string($_POST["cheque_tds_amount"]);
	$cheque_tds_Netamount = $conn->real_escape_string($_POST["cheque_tds_Netamount"]);
	$cheque_tds_deducted = $conn->real_escape_string($_POST["cheque_tds_deducted"]);
	} else {		
	$cheque_tds_per = "";
	$cheque_tds_amount = "";
	$cheque_tds_Netamount = "";
	$cheque_tds_deducted = "";
	}	
	
	$checks = "select uid,gid from exh_reg_payment_details where uid='$uid' AND `show`='$eventDescription' AND event_selected='$event_selected' limit 0,1";
	$querycheck = $conn->query($checks);
	$numCount = $querycheck->num_rows; 
	$resultData = $querycheck->fetch_assoc();
		$gidData = $resultData["gid"];
		$_SESSION['gid'] = $resultData["gid"]; 
	if($numCount >0)
	{
	/* Update Step 1 Data */
	$company_name = strtoupper(str_replace(array('&amp;','&AMP;'), '&', $getgeneralInfo['company_name']));
	
	$generalInfo = "UPDATE exh_reg_general_info set uid='$uid',company_name='".$company_name."',membership_id='".$getgeneralInfo['membership_id']."',membership_date='".$getgeneralInfo['membership_date']."',bp_number='".$getgeneralInfo['bp_number']."',address1='".$getgeneralInfo['address1']."',address2='".$getgeneralInfo['address2']."',address3='".$getgeneralInfo['address3']."',billing_address_id='".$getgeneralInfo['billing_address_id']."',get_billing_bp_number='".$getgeneralInfo['get_billing_bp_number']."',billing_gstin='".$getgeneralInfo['billing_gstin']."',billing_address1='".$getgeneralInfo['billing_address1']."',billing_address2='".$getgeneralInfo['billing_address2']."',billing_address3='".$getgeneralInfo['billing_address3']."',bcity='".$getgeneralInfo['bcity']."',bpincode='".$getgeneralInfo['bpincode']."',bcountry='".$getgeneralInfo['bcountry']."',btelephone_no='".$getgeneralInfo['btelephone_no']."',bfax_no='".$getgeneralInfo['bfax_no']."',billing_address_same='".$getgeneralInfo['billing_address_same']."',pan_no='".$getgeneralInfo['pan_no']."',tan_no='".$getgeneralInfo['tan_no']."',city='".$getgeneralInfo['city']."',pincode='".$getgeneralInfo['pincode']."',country='".$getgeneralInfo['country']."',telephone_no='".$getgeneralInfo['telephone_no']."',mobile='".$getgeneralInfo['mobile']."',fax_no='".$getgeneralInfo['fax_no']."',email='".$getgeneralInfo['email']."',membership_certificate_type='".$getgeneralInfo['membership_certificate_type']."',gst='".$getgeneralInfo['gst']."',kyc='".$getgeneralInfo['kyc']."',website='".$getgeneralInfo['website']."',contact_person='".$getgeneralInfo['contact_person']."',contact_person_desg='".$getgeneralInfo['contact_person_desg']."',contact_person_desg_show='".$getgeneralInfo['contact_person_desg_show']."',contact_person_co='".$getgeneralInfo['contact_person_co']."',contacts='".$getgeneralInfo['contacts']."',event_for='".$getgeneralInfo['event_for']."',event_selected='".$event_selected."',participant_type='".$getgeneralInfo['participant_type']."',region='".$getgeneralInfo['region']."',created_date=NOW(),year='$year',company_type='".$getgeneralInfo['company_type']."',iec_number='".$getgeneralInfo['iec_number']."',dir_name='".$getgeneralInfo['dir_name']."',din_number='".$getgeneralInfo['din_number']."',cin_number='".$getgeneralInfo['cin_number']."',cast='".$getgeneralInfo['cast']."' where uid='$uid' AND id='$gidData'"; 
	$result1 = $conn->query($generalInfo);
	/* Update Step 2 Data */	
	$comp_desc = trim($getcompanyInfo['comp_desc']);
	$comp_desc = str_replace("'","\'", $comp_desc); 
	$companyInfo = "UPDATE exh_reg_company_details set we_are_jewellery='".$getcompanyInfo['we_are_jewellery']."', we_are_loose='".$getcompanyInfo['we_are_loose']."',we_are_machinery='".$getcompanyInfo['we_are_machinery']."', we_are='".$getcompanyInfo['we_are']."', we_are_jewellery_any_other='".$getcompanyInfo['we_are_jewellery_any_other']."',we_are_loose_any_other='".$getcompanyInfo['we_are_loose_any_other']."',we_are_machinery_any_other='".$getcompanyInfo['we_are_machinery_any_other']."', we_are_any_other='".$getcompanyInfo['we_are_any_other']."',comp_desc='".$comp_desc."',last_yr_turn_over='".$getcompanyInfo['last_yr_turn_over']."' where uid='$uid' AND gid='$gidData' AND `show`='".$getcompanyInfo['show']."' AND event_selected='".$event_selected."'";
	$result2 = $conn->query($companyInfo);
	if(!$result2) { die('Error: Company Details Update query failed' . $conn->error); }	
			 // echo $getstallInfo['tot_space_cost_rate'];exit;
	/* Update Step 3 Data */	
	$stallInfos = "UPDATE exh_registration set options='".$getstallInfo['option']."',woman_entrepreneurs='".$getstallInfo['woman_entrepreneurs']."',last_yr_participant='".$getstallInfo['last_yr_participant']."',section='".$getstallInfo['section']."',category='".$getstallInfo['category']."',selected_area='".$getstallInfo['selected_area']."',selected_scheme_type='".$getstallInfo['selected_scheme_type']."',selected_premium_type='".$getstallInfo['selected_premium_type']."',tot_space_cost_rate='".floatval($getstallInfo['tot_space_cost_rate'])."',tot_space_cost_discount='".$getstallInfo['tot_space_cost_discount']."',get_tot_space_cost_rate='".$getstallInfo['get_tot_space_cost_rate']."',get_category_rate='".$getstallInfo['get_category_rate']."',mezzanine_space_charges='".$getstallInfo['mezzanine_space_charges']."',selected_scheme_rate='".$getstallInfo['selected_scheme_rate']."',selected_premium_rate='".$getstallInfo['selected_premium_rate']."',sub_total_cost ='".$getstallInfo['sub_total_cost']."',security_deposit='".$getstallInfo['security_deposit']."',govt_service_tax='".$getstallInfo['govt_service_tax']."',grand_total='".$getstallInfo['grand_total']."',mcb_charges='".$getstallInfo['mcb_charges']."',incentive='".$getstallInfo['incentive']."',discount='".$getstallInfo['discount']."',incentive_value='".$getstallInfo['incentive_value']."',discount_value='".$getstallInfo['discount_value']."' where uid='$uid' AND gid='$gidData' AND `show`='".$eventDescription."' AND event_selected='".$event_selected."'";
	$stallResult = $conn->query($stallInfos);	
	if(!$stallResult) { die('Error: Stall Details Update query failed' . $conn->error); }
	
	/* Update Step 4 Data */
	$sqlm = "SELECT * FROM `exh_registration` WHERE uid='$uid' AND gid='$gidData' AND `show`='$event_for' AND event_selected='$event_selected' order by exh_id desc limit 0,1"; 
	$querym = $conn->query($sqlm);		
	$resultm = $querym->fetch_assoc();
	$grandTotals = $resultm["grand_total"];
	$exh_id = $resultm["exh_id"];
		
		/* 50% or 100% */
	$amount_payable = $conn->real_escape_string($_POST["amount_payable"]);
	$net_payable_amount = $conn->real_escape_string($_POST["net_payable_amount"]);
	if(empty($amount_payable)) {  
			$signup_error = "Please Select Amount Payable"; }
	else if(empty($_POST["net_payable_amount"])) {
			$net_payable_amount_error = "Please Select Net Amount Payable"; }
	else if(empty($_POST["tds_holder"]) && $getstallInfo['last_yr_participant'] == "YES") {
			$tds_deducted_error = "Please Select TDS Option"; }
			
	else if(empty($_POST['cheque_tds_per']) && $_POST["tds_holder"] == 'Yes' && $getstallInfo['last_yr_participant'] == "YES"){
			$cheque_tds_per_error = "Please Select TDS Percentage"; }
			
	else if(empty($_POST['cheque_tds_amount']) && $_POST["tds_holder"] == 'Yes' && $getstallInfo['last_yr_participant'] == "YES"){ $cheque_tds_amount_error = "Please Enter TDS Amount"; }
	
	else if(empty($_POST['cheque_tds_Netamount']) && $_POST["tds_holder"] == 'Yes' && $getstallInfo['last_yr_participant'] == "YES"){ $cheque_tds_amount_error = "Net Amount Missing"; }
	else {
	
	if($_POST["tds_holder"] == 'Yes' && $getstallInfo['last_yr_participant'] == "YES") {
		//echo $_POST['cheque_tds_Netamount'];
		$amountPay = $conn->real_escape_string($_POST["cheque_tds_Netamount"]);
		//echo '<pre>'; print_r($_POST);  exit;
	} else if($_POST["tds_holder"] == 'No' && $getstallInfo['last_yr_participant'] == "YES") {
		//echo $_POST["net_payable_amount"];
		$amountPay = $conn->real_escape_string($_POST["net_payable_amount"]);
		//echo '<pre>'; print_r($_POST);  exit;
	} else if($_POST["tds_holder"] == 'Yes' &&  $event_selected == "iijstritiya23") {
		$amountPay = $conn->real_escape_string($_POST["cheque_tds_Netamount"]);
	} else if($_POST["tds_holder"] == 'Yes' &&  $event_selected == "igjme23") {
		$amountPay = $conn->real_escape_string($_POST["cheque_tds_Netamount"]);
	} else {
		//echo $_POST["net_payable_amount"];
		$amountPay = $conn->real_escape_string($_POST["net_payable_amount"]);
		//echo '<pre>'; print_r($_POST);  exit;
	}
		
	$paymentInfo = "UPDATE exh_reg_payment_details set int_type='$int_type', payment_mode='$payment_mode', bank_acc_no='$bank_acc_no', name_bank='$name_bank', name_bank_branch='$name_bank_branch', ifsc_code='$ifsc_code', int_acc_type='$int_acc_type',`tds_holder`='$tds_holder',`net_payable_amount`='$net_payable_amount',`percentage`='$amount_payable', `cheque_tds_gross_amount`='$cheque_tds_gross_amount',`cheque_tds_per`='$cheque_tds_per',`cheque_tds_amount`='$cheque_tds_amount',`cheque_tds_Netamount`='$amountPay',`cheque_tds_deducted`='$cheque_tds_deducted' WHERE `show`='$eventDescription' AND event_selected='$event_selected' AND uid='$uid' AND gid='$gidData'";
	$result4 = $conn->query($paymentInfo);
	if(!$result4) { die('Error: ' . $conn->error); }
	
	include 'rz_pay.php';
	}


		
	} else {

		//echo gettype(floatval($getstallInfo['tot_space_cost_rate']));exit;

	if(!empty($getgeneralInfo['company_name']) && !empty($event_selected))
	{
	$amount_payable = $conn->real_escape_string($_POST["amount_payable"]);
	$net_payable_amount = $conn->real_escape_string($_POST["net_payable_amount"]);
	if(empty($amount_payable)) { 
			$signup_error = "Please Select Amount Payable"; }
	else if(empty($_POST["net_payable_amount"])) {
			$net_payable_amount_error = "Please Select Net Amount Payable"; }
	else if(empty($_POST["tds_holder"]) && $getstallInfo['last_yr_participant'] == "YES") {
			$tds_deducted_error = "Please Select TDS Option"; }
			
	else if(empty($_POST['cheque_tds_per']) && $_POST["tds_holder"] == 'Yes' && $getstallInfo['last_yr_participant'] == "YES"){
			$cheque_tds_per_error = "Please Select TDS Percentage"; }
			
	else if(empty($_POST['cheque_tds_amount']) && $_POST["tds_holder"] == 'Yes' && $getstallInfo['last_yr_participant'] == "YES"){ $cheque_tds_amount_error = "Please Enter TDS Amount"; }
	
	else if(empty($_POST['cheque_tds_Netamount']) && $_POST["tds_holder"] == 'Yes' && $getstallInfo['last_yr_participant'] == "YES"){ $cheque_tds_amount_error = "Net Amount Missing"; }
	else {
	
	/* Insert Step 1 Data */
	$company_name = strtoupper(str_replace(array('&amp;','&AMP;'), '&', $getgeneralInfo['company_name']));
	
	$generalInfo = "insert into exh_reg_general_info set uid='$uid',company_name='".$company_name."',membership_id='".$getgeneralInfo['membership_id']."',membership_date='".$getgeneralInfo['membership_date']."',bp_number='".$getgeneralInfo['bp_number']."',address1='".$getgeneralInfo['address1']."',address2='".$getgeneralInfo['address2']."',address3='".$getgeneralInfo['address3']."',billing_address_id='".$getgeneralInfo['billing_address_id']."',get_billing_bp_number='".$getgeneralInfo['get_billing_bp_number']."',billing_gstin='".$getgeneralInfo['billing_gstin']."',billing_address1='".$getgeneralInfo['billing_address1']."',billing_address2='".$getgeneralInfo['billing_address2']."',billing_address3='".$getgeneralInfo['billing_address3']."',bcity='".$getgeneralInfo['bcity']."',bpincode='".$getgeneralInfo['bpincode']."',bcountry='".$getgeneralInfo['bcountry']."',btelephone_no='".$getgeneralInfo['btelephone_no']."',bfax_no='".$getgeneralInfo['bfax_no']."',billing_address_same='".$getgeneralInfo['billing_address_same']."',pan_no='".$getgeneralInfo['pan_no']."',tan_no='".$getgeneralInfo['tan_no']."',city='".$getgeneralInfo['city']."',pincode='".$getgeneralInfo['pincode']."',country='".$getgeneralInfo['country']."',telephone_no='".$getgeneralInfo['telephone_no']."',mobile='".$getgeneralInfo['mobile']."',fax_no='".$getgeneralInfo['fax_no']."',email='".$getgeneralInfo['email']."',membership_certificate_type='".$getgeneralInfo['membership_certificate_type']."',gst='".$getgeneralInfo['gst']."',kyc='".$getgeneralInfo['kyc']."',website='".$getgeneralInfo['website']."',contact_person='".$getgeneralInfo['contact_person']."',contact_person_desg='".$getgeneralInfo['contact_person_desg']."',contact_person_desg_show='".$getgeneralInfo['contact_person_desg_show']."',contact_person_co='".$getgeneralInfo['contact_person_co']."',contacts='".$getgeneralInfo['contacts']."',event_for='".$getgeneralInfo['event_for']."',event_selected='".$event_selected."',participant_type='".$getgeneralInfo['participant_type']."',region='".$getgeneralInfo['region']."',created_date=NOW(),year='$year',company_type='".$getgeneralInfo['company_type']."',iec_number='".$getgeneralInfo['iec_number']."',dir_name='".$getgeneralInfo['dir_name']."',din_number='".$getgeneralInfo['din_number']."',cin_number='".$getgeneralInfo['cin_number']."',cast='".$getgeneralInfo['cast']."'";
	$result1 = $conn->query($generalInfo);
	$gid = $conn->insert_id;
	$_SESSION['gid'] = $gid; 
	
		if($gid!='')
		{
		/* Insert Step 2 Data */
		$comp_desc = trim($getcompanyInfo['comp_desc']);
		$comp_desc = str_replace("'","\'", $comp_desc);
		$companyInfo = "INSERT into exh_reg_company_details set gid='".$gid."', uid='$uid', we_are_jewellery='".$getcompanyInfo['we_are_jewellery']."', we_are_loose='".$getcompanyInfo['we_are_loose']."',we_are_machinery='".$getcompanyInfo['we_are_machinery']."', we_are='".$getcompanyInfo['we_are']."', we_are_jewellery_any_other='".$getcompanyInfo['we_are_jewellery_any_other']."',we_are_loose_any_other='".$getcompanyInfo['we_are_loose_any_other']."',we_are_machinery_any_other='".$getcompanyInfo['we_are_machinery_any_other']."', we_are_any_other='".$getcompanyInfo['we_are_any_other']."',comp_desc='".$comp_desc."',last_yr_turn_over='".$getcompanyInfo['last_yr_turn_over']."',created_date=NOW(),`show`='".$getcompanyInfo['show']."',event_selected='".$event_selected."',year='$year'";
		$result1 = $conn->query($companyInfo);
		if(!$result1) { die('Error: Company Details insert query failed' . $conn->error); }	
		
		/* Insert Step 3 Data */
		$stallInfos = "INSERT into exh_registration set options='".$getstallInfo['option']."',uid='$uid',gid='$gid',woman_entrepreneurs='".$getstallInfo['woman_entrepreneurs']."',last_yr_participant='".$getstallInfo['last_yr_participant']."',section='".$getstallInfo['section']."',category='".$getstallInfo['category']."',selected_area='".$getstallInfo['selected_area']."',selected_scheme_type='".$getstallInfo['selected_scheme_type']."',selected_premium_type='".$getstallInfo['selected_premium_type']."',tot_space_cost_rate='".floatval($getstallInfo['tot_space_cost_rate'])."',tot_space_cost_discount='".$getstallInfo['tot_space_cost_discount']."',get_tot_space_cost_rate='".$getstallInfo['get_tot_space_cost_rate']."',get_category_rate='".$getstallInfo['get_category_rate']."',mezzanine_space_charges='".$getstallInfo['mezzanine_space_charges']."',selected_scheme_rate='".$getstallInfo['selected_scheme_rate']."',selected_premium_rate='".$getstallInfo['selected_premium_rate']."',sub_total_cost ='".$getstallInfo['sub_total_cost']."',security_deposit='".$getstallInfo['security_deposit']."',govt_service_tax='".$getstallInfo['govt_service_tax']."',grand_total='".$getstallInfo['grand_total']."',mcb_charges='".$getstallInfo['mcb_charges']."',created_date=NOW(),`show`='$event_for',event_selected='".$event_selected."',year='$year',incentive='".$getstallInfo['incentive']."',discount='".$getstallInfo['discount']."',incentive_value='".$getstallInfo['incentive_value']."',discount_value='".$getstallInfo['discount_value']."'";
		$stallResult = $conn->query($stallInfos);	
		if(!$stallResult) { die('Error: Stall Details insert query failed' . $conn->error); }
		
		/* Insert Step 4 Data */
		$sqlm = "SELECT * FROM `exh_registration` WHERE uid='$uid' AND gid='$gid' AND `show`='$event_for' AND event_selected='$event_selected' order by exh_id desc limit 0,1";
		$querym = $conn->query($sqlm);		
		$resultm = $querym->fetch_assoc();
		$grandTotals = $resultm["grand_total"];
		$exh_id = $resultm["exh_id"];
		
		if($_POST["tds_holder"] == 'Yes' && $getstallInfo['last_yr_participant'] == "YES") {
		//echo $_POST['cheque_tds_Netamount'];
		$amountPay = $conn->real_escape_string($_POST["cheque_tds_Netamount"]);
		//echo '<pre>'; print_r($_POST);  exit;
		} else if($_POST["tds_holder"] == 'No' && $getstallInfo['last_yr_participant'] == "YES") {
			//echo $_POST["net_payable_amount"];
			$amountPay = $conn->real_escape_string($_POST["net_payable_amount"]);
		} else if($_POST["tds_holder"] == 'Yes' &&  $event_selected == "igjme23") {
			$amountPay = $conn->real_escape_string($_POST["cheque_tds_Netamount"]);
		} else {
			//echo $_POST["net_payable_amount"];
			$amountPay = $conn->real_escape_string($_POST["net_payable_amount"]);
			//echo '<pre>'; print_r($_POST);  exit;
		}
			
		$payment_status = "pending";
		$document_status = "pending";
		$application_status = "pending";
		
	$insert_query = "insert into exh_reg_payment_details set gid='$gid', uid='$uid', int_type='$int_type', payment_mode='$payment_mode', bank_acc_no='$bank_acc_no', name_bank='$name_bank', name_bank_branch='$name_bank_branch', ifsc_code='$ifsc_code', int_acc_type='$int_acc_type', created_date=NOW(), payment_status='$payment_status', document_status='$document_status', application_status='$application_status',`tds_holder`='$tds_holder',`net_payable_amount`='$net_payable_amount',`percentage`='$amount_payable', `cheque_tds_gross_amount`='$cheque_tds_gross_amount',`cheque_tds_per`='$cheque_tds_per',`cheque_tds_amount`='$cheque_tds_amount',`cheque_tds_Netamount`='$amountPay',`cheque_tds_deducted`='$cheque_tds_deducted',`show`='$event_for',event_selected='$event_selected',year='$year'";
		$result4 = $conn->query($insert_query);
		if(!$result4) { die('Error: ' . $conn->error); }
		$ok = $conn->query("update exh_registration set curr_last_yr_check='Y' where exh_id='$exh_id'");
		include 'rz_pay.php';

		
		}	
	}
	}
	}

	} else {
	/* International */
	$currency = "USD"; 
	$int_type = "I"; 
	
	if(!empty($getgeneralInfo['company_name']) && !empty($event_selected))
	{			
		$company_name = strtoupper(str_replace(array('&amp;','&AMP;'), '&', $getgeneralInfo['company_name']));
	$generalInfo = "insert into exh_reg_general_info set uid='$uid',company_name='".$company_name."',membership_id='".$getgeneralInfo['membership_id']."',membership_date='".$getgeneralInfo['membership_date']."',bp_number='".$getgeneralInfo['bp_number']."',address1='".$getgeneralInfo['address1']."',address2='".$getgeneralInfo['address2']."',address3='".$getgeneralInfo['address3']."',billing_address_id='".$getgeneralInfo['billing_address_id']."',get_billing_bp_number='".$getgeneralInfo['get_billing_bp_number']."',billing_gstin='".$getgeneralInfo['billing_gstin']."',billing_address1='".$getgeneralInfo['billing_address1']."',billing_address2='".$getgeneralInfo['billing_address2']."',billing_address3='".$getgeneralInfo['billing_address3']."',bcity='".$getgeneralInfo['bcity']."',bpincode='".$getgeneralInfo['bpincode']."',bcountry='".$getgeneralInfo['bcountry']."',btelephone_no='".$getgeneralInfo['btelephone_no']."',bfax_no='".$getgeneralInfo['bfax_no']."',billing_address_same='".$getgeneralInfo['billing_address_same']."',pan_no='".$getgeneralInfo['pan_no']."',tan_no='".$getgeneralInfo['tan_no']."',city='".$getgeneralInfo['city']."',pincode='".$getgeneralInfo['pincode']."',country='".$getgeneralInfo['country']."',telephone_no='".$getgeneralInfo['telephone_no']."',mobile='".$getgeneralInfo['mobile']."',fax_no='".$getgeneralInfo['fax_no']."',email='".$getgeneralInfo['email']."',membership_certificate_type='".$getgeneralInfo['membership_certificate_type']."',gst='".$getgeneralInfo['gst']."',kyc='".$getgeneralInfo['kyc']."',website='".$getgeneralInfo['website']."',contact_person='".$getgeneralInfo['contact_person']."',contact_person_desg='".$getgeneralInfo['contact_person_desg']."',contact_person_desg_show='".$getgeneralInfo['contact_person_desg_show']."',contact_person_co='".$getgeneralInfo['contact_person_co']."',contacts='".$getgeneralInfo['contacts']."',event_for='".$getgeneralInfo['event_for']."',event_selected='".$event_selected."',participant_type='".$getgeneralInfo['participant_type']."',region='".$getgeneralInfo['region']."',created_date=NOW(),year='$year',company_type='".$getgeneralInfo['company_type']."',iec_number='".$getgeneralInfo['iec_number']."',dir_name='".$getgeneralInfo['dir_name']."',din_number='".$getgeneralInfo['din_number']."',cin_number='".$getgeneralInfo['cin_number']."',cast='".$getgeneralInfo['cast']."'";
		$result1 = $conn->query($generalInfo); 

		$gid = $conn->insert_id;		
if($gid!='')
{
	/* Insert Step 2 Data */
	$comp_desc = trim($getcompanyInfo['comp_desc']);
	$comp_desc = str_replace("'","\'", $comp_desc); 
	$companyInfo = "INSERT into exh_reg_company_details set gid='".$gid."', uid='$uid', we_are_jewellery='".$getcompanyInfo['we_are_jewellery']."', we_are_loose='".$getcompanyInfo['we_are_loose']."',we_are_machinery='".$getcompanyInfo['we_are_machinery']."', we_are='".$getcompanyInfo['we_are']."', we_are_jewellery_any_other='".$getcompanyInfo['we_are_jewellery_any_other']."',we_are_loose_any_other='".$getcompanyInfo['we_are_loose_any_other']."',we_are_machinery_any_other='".$getcompanyInfo['we_are_machinery_any_other']."', we_are_any_other='".$getcompanyInfo['we_are_any_other']."',comp_desc='".$comp_desc."',last_yr_turn_over='".$getcompanyInfo['last_yr_turn_over']."',created_date=NOW(),`show`='".$getcompanyInfo['show']."',event_selected='".$event_selected."',year='$year'";
	$result1 = $conn->query($companyInfo);
    if(!$result1) { die('Error: Company Details insert query failed' . $conn->error); }	
	
	/* Insert Step 3 Data */
 
	echo $stallInfos = "INSERT into exh_registration set options='".$getstallInfo['option']."',uid='$uid',gid='$gid',woman_entrepreneurs='".$getstallInfo['woman_entrepreneurs']."',last_yr_participant='".$getstallInfo['last_yr_participant']."',section='".$getstallInfo['section']."',category='".$getstallInfo['category']."',selected_area='".$getstallInfo['selected_area']."',selected_scheme_type='".$getstallInfo['selected_scheme_type']."',selected_premium_type='".$getstallInfo['selected_premium_type']."',tot_space_cost_rate='".floatval($getstallInfo['tot_space_cost_rate'])."',tot_space_cost_discount='".$getstallInfo['tot_space_cost_discount']."',get_tot_space_cost_rate='".$getstallInfo['get_tot_space_cost_rate']."',get_category_rate='".$getstallInfo['get_category_rate']."',mezzanine_space_charges='".$getstallInfo['mezzanine_space_charges']."',selected_scheme_rate='".$getstallInfo['selected_scheme_rate']."',selected_premium_rate='".$getstallInfo['selected_premium_rate']."',sub_total_cost ='".$getstallInfo['sub_total_cost']."',security_deposit='".$getstallInfo['security_deposit']."',govt_service_tax='".$getstallInfo['govt_service_tax']."',grand_total='".$getstallInfo['grand_total']."',mcb_charges='".$getstallInfo['mcb_charges']."',created_date=NOW(),`show`='$event_for',event_selected='".$event_selected."',year='$year',incentive='".$getstallInfo['incentive']."',discount='".$getstallInfo['discount']."',incentive_value='".$getstallInfo['incentive_value']."',discount_value='".$getstallInfo['discount_value']."'"; 
	$stallResult = $conn->query($stallInfos);	
	if(!$stallResult) { die('Error: INTL Stall Details insert query failed' . $conn->error); }
	
	/* Insert Step 4 Data */
	if(isset($_POST["payment_mode"]) && isset($_POST["bank_acc_no"]))
	{
		$int_type = "I";
		$int_acc_type = $conn->real_escape_string($_POST["int_acc_type"]);
		$int_bank_acc_no = $conn->real_escape_string($_POST["bank_acc_no"]);
		$int_name_bank = $conn->real_escape_string($_POST["bank_name"]);
		$int_name_bank_branch = $conn->real_escape_string($_POST["branch_name"]);	
		$int_bank_address = $conn->real_escape_string($_POST["int_bank_address"]);
		$int_beneficiary_name = $conn->real_escape_string($_POST["int_beneficiary_name"]);
		$int_swift_code = $conn->real_escape_string($_POST["int_swift_code"]);
		$int_iban_no = $conn->real_escape_string($_POST["int_iban_no"]);
		
		$sqlm = "SELECT * FROM `exh_registration` WHERE uid='$uid' AND gid='$gid' AND `show`='$event_for' AND event_selected='$event_selected' order by exh_id desc limit 0,1";
		$querym = $conn->query($sqlm);		
		$resultm = $querym->fetch_assoc();
		$exh_id = $resultm["exh_id"];
				
		$payment_status = "pending";
		$document_status = "pending";
		$application_status = "pending";
		
		$insert_query = "insert into exh_reg_payment_details set gid='$gid', uid='$uid', int_type='$int_type', int_acc_type='$int_acc_type', int_bank_acc_no='$int_bank_acc_no', int_name_bank='$int_name_bank', int_name_bank_branch='$int_name_bank_branch', int_bank_address='$int_bank_address', int_beneficiary_name='$int_beneficiary_name', int_swift_code='$int_swift_code', int_iban_no='$int_iban_no', created_date=NOW(), payment_status='$payment_status', document_status='$document_status', application_status='$application_status', `show`='$event_for',event_selected='$event_selected',year='$year'";
		$result4 = $conn->query($insert_query);
		if(!$result4) { die('Error: ' . $conn->error); }
		$conn->query("update exh_registration set curr_last_yr_check='Y' where exh_id='$exh_id'");
		
		$message ='<table width="100%" bgcolor="#fff" style="margin:20px auto; border:2px solid #dddddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
<tr>
<td style="padding:30px;">
<table width="100%" border="0" background="#fff" cellpadding="0" cellspacing="0">
	<tr>
    	<td align="left" valign="top"><a href="https://www.gjepc.org"><img src="https://registration.gjepc.org/images/logo.png"/></a></td>
    </tr> 
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>    
    <tr><td colspan="2" height="1px" bgcolor="#333333"></td></tr>    
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>    
	<tr>
    	<td colspan="2" valign="top" style="font-size:13px;">
		<p><strong>Company Name :</strong> '.$_SESSION['COMPANYNAME'].'</p>
    	<p><strong>Dear '.$getgeneralInfo['contact_person'].',</strong> </p>
		<p><strong>Application No. : EXREG/'.$eventMail.'/2022/'.$resultm['gid'].'</strong></p>
    	<p>Thank you for applying Online for '.$eventMail.' Exhibitor Registration. Please note your application is under approval process.</p>    	
    	</td>
    </tr>
    
    <tr><td colspan="2">&nbsp;</td></tr>    
    <tr>
    <td colspan="2">

<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; float:left;">
    <tr><td colspan="2" style="color:#14b3da;"><strong>Application Summary</strong></td></tr>
    <tr>
        <td width="35%"><strong>Last Year Participant </strong></td>
        <td width="65%">'.$resultm['last_yr_participant'].'</td>
        <!--<td width="65%">IIJS SIGNATURE 2023 ROI Details / IIJS SIGNATURE 2023 Allotment Details (If Not applied for IIJS SIGNATURE 2023 ROI)</td>-->
    </tr>	
	<tr>
        <td><strong>Selected Option</strong></td>
        <td>'.$resultm['options'].' Signature 2020</td>
    </tr>
    <tr>
        <td><strong>Section</strong></td>
        <td>'.getSection_description($resultm['section'],$conn).'</td>
    </tr>
	<tr>
        <td><strong>Category</strong></td>
        <td>'.$resultm['category'].'</td>
    </tr>
    <tr>
        <td><strong>Area</strong></td>
        <td>'.$resultm['selected_area'].'</td>
    </tr>
    <!--<tr>
        <td><strong>Premium</strong></td>
        <td>'.$resultm['selected_premium_type'].'</td>
    </tr>-->
	<tr>
        <td><strong>Scheme</strong></td>
        <!--<td>'.$resultm['selected_scheme_type'].'</td>-->
        <td>Shell Scheme</td>
    </tr>
</table>

<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; float:right;">
  <tr valign="top">
    <td colspan="2"  style="color:#14b3da;"><strong>Application Payment Summary</strong><br /></td>
    </tr>
  <tr valign="top">
    <td width="30%"><strong>Total Space Cost '.$currency.' </strong></td>
    <td width="21%">'.$resultm['tot_space_cost_rate'].'</td>
  </tr>
  <tr valign="top">
    <td width="30%"><strong>Category Cost '.$currency.' </strong></td>
    <td width="21%">'.$resultm['get_category_rate'].'</td>
  </tr>
 <!-- <tr valign="top">
    <td><strong>Space cost after Incentive '.$currency.' </strong></td>
    <td>'.$resultm['incentive_value'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>Discount '.$currency.' </strong></td>
    <td>'.$resultm['discount_value'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>After Discount Space Cost '.$currency.' </strong></td>
    <td>'.$resultm['get_tot_space_cost_rate'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>Selected scheme rate '.$currency.' </strong></td>
    <td>'.$resultm['selected_scheme_rate'].'</td>
  </tr>-->
  <!--<tr valign="top">
    <td><strong>Selected premium rate '.$currency.' </strong></td>
    <td>'.$resultm['selected_premium_rate'].'</td>
  </tr>-->
  <tr valign="top">
    <td><strong>Sub Total '.$currency.' </strong></td>
    <td>'.$resultm['sub_total_cost'].'</td>
  </tr>
  <tr valign="top">
    <td valign="top"><strong>Security Deposit (10% on Sub Total) '.$currency.'</strong></td>
    <td valign="top">'.$resultm['security_deposit'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>GST (18% on Sub Total) '.$currency.' </strong></td>
    <td>'.$resultm['govt_service_tax'].'<br /></td>
  </tr>
  <tr valign="top">
    <td><strong>Grand Total '.$currency.' </strong></td>
    <td>'.$resultm['grand_total'].'</td>
  </tr>
</table>
	</td>
  </tr>  
    <tr>
    	<td colspan="2" height="25px">&nbsp;</td>
    </tr>
    <tr>
    <td colspan="2">
	<table width="100%" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" border="1" bordercolor="#CCCCCC" style="border-collapse:collapse;">
  	<tr valign="top">
   	<td colspan="2" style="color:#14b3da;"><strong>Payment Details</strong></td>
    </tr>
    <tr valign="top">
	<td width="52%"><strong>Mode of Payment </strong></td>
	<td width="48%">'.$payment_mode.'</td>
    </tr>
	</table>
	</td>
	</tr>
    <tr> <td colspan="2">&nbsp;</td> </tr>
	<tr>
    <td colspan="2">
    <table width="100%" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" border="1" bordercolor="#CCCCCC" style="border-collapse:collapse;">
    <tr valign="top">
    <td colspan="2" style="color:#14b3da;"><strong>For Domestic Companies</strong></td>
    </tr>
	<tr valign="top">
	<td width="52%"><strong>Company Name</strong></td>
	<td width="48%">The Gem & Jewellery Export Promotion Council</td>
	</tr>
    <tr valign="top">
	<td width="52%"><strong>Bank</strong></td>
	<td width="48%">ICICI BANK</td>
    </tr>
   <!--<tr valign="top">
    <td width="52%"><strong>Branch</strong></td>
    <td width="48%">Kalanagar, Bandra</td>
    </tr>-->
    <tr valign="top">
    <td width="52%"><strong>A/c No.</strong></td>
    <td width="48%">034801000360</td>
    </tr>
    <tr valign="top">
    <td width="52%"><strong>IFSC Code</strong></td>
    <td width="48%">ICIC0000348</td>
    </tr>
    <tr valign="top">
    <td width="52%"><strong>Type of Account</strong></td>
    <td width="48%">Saving Account</td>
    </tr>
  </table>
    </td>
    </tr>
	<tr><td colspan="2" height="25px">&nbsp;</td></tr>
    <tr>
    <td colspan="2">
    <!-- <table width="100%" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" border="1" bordercolor="#CCCCCC" style="border-collapse:collapse;">
    <tr valign="top">
    <td colspan="2" style="color:#14b3da;"><strong>RTGS Details For International Companies</strong></td>
    </tr>
    <tr valign="top">
    <td width="52%"><strong>Bank Name</strong></td>
    <td width="48%">State Bank of India, (09276)-Diamond Branch Mumbai</td>
    </tr>
    <tr valign="top">
    <td width="52%"><strong>Address</strong></td>
	<td width="48%">D-3, West Core, Bharat Diamond Bourse, Bandra Kurla Complex, Bandra East, Mumbai 400051</td>
    </tr>
    <tr valign="top">
    <td width="52%"><strong>Beneficiary Name</strong></td>
    <td width="48%">The Gem & Jewellery Export Promotion Council</td>
    </tr>
    <tr valign="top">
    <td width="52%"><strong>A/c No.</strong></td>
    <td width="48%">00000031170503463</td>
    </tr>
    <tr valign="top">
    <td width="52%"><strong>SWIFT Code No</strong></td>
    <td width="48%">SBININBB109</td>
    </tr>
    <tr valign="top">
    <td width="52%"><strong>Purpose of remittance</strong></td>
    <td width="48%">Participation charges</td>
    </tr>
    </table> -->
    </td>
    </tr>
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>    
    <tr>
    <td colspan="2" style="line-height:20px;">
	<p align="justify">All the applicant members will have to update the details of advance payment along with UTR number and TDS on the dashboard after successful submission of online space application along with payment details before the deadline.</p>
	<p>A system generated notification will be sent to you on successful approval of your application.</p>
	<p>Kind Regards,</p>   
	<p><strong>'.$eventMail.' Team,</strong></p>

</td>
</tr>
</table>

</td>
</tr>
</table>';

	/*
	$to =$_SESSION['EMAILID'].",".$to_admin.",notification@gjepcindia.com,iijs.gjepc@gmail.com";
	//$to ='neelmani@kwebmaker.com';
	$subject = "Exhibitor Registration for ".$event_for." (EXREG/".$event_for."/2021/".$resultm['exh_id']."/dated".date('Y-m-d').")";
	$headers  = 'MIME-Version: 1.0' . "\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1'."\n";	
	$headers .='From: '.$event_for.' <admin@gjepc.org>';	
	@mail($to, $subject, $message, $headers);
	*/
	
	//$to = $_SESSION['EMAILID'].",".$to_admin.",notification@gjepcindia.com,iijs.gjepc@gmail.com"; 
	$to ='neelmani@kwebmaker.com';
//	$subject = "Exhibitor Registration for ".$eventMail." (EXREG/".$eventMail."/2022/".$resultm['exh_id']."/dated".date('Y-m-d').")";
	$subject = "Exhibitor Registration for ".$eventMail."";
	$cc = "";
    $email_array = explode(",",$to);
    //send_mailArray($email_array,$subject,$message,$cc);
	
	/* Now Unset session */
	unset($_SESSION['eventInfo']);	/* Event Applying */	 
	unset($_SESSION['generalInfo']);  /* Get 1 step data */
	unset($_SESSION['companyInfo']); /* Get 2 step data */
	unset($_SESSION['stallInfo']);    /* Get 3 step data */
	header("location:my_dashboard.php"); exit;
	//header("location:exhibitor_registration_print_application.php?gid=".$gid);	exit;	
}

	
	} else {
		header("location:my_dashboard.php"); exit;
	}
	
	} else {
		header("location:my_dashboard.php"); exit;
	}		
}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Exhibitor Registration - Payment Details</title>
<link rel="icon" href="https://gjepc.org/assets/images/fav_icon.png" type="image/x-icon"/>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>
<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />

<!--NAV-->
<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.flexnav.js?v=<?php echo $version;?>" type="text/javascript"></script>
<script src="js/common.js?v=<?php echo $version;?>"></script> 
<!--NAV-->

<!-- UItoTop plugin -->
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css?v=<?php echo $version;?>" />
<style>.content_form_area{max-width:700px}.right-content li{font-size:12px;line-height:23px;}.right-content{margin:35px 0;
border:1px solid#ccc;padding:7px}</style>
<script src="js/easing.js?v=<?php echo $version;?>" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js?v=<?php echo $version;?>" type="text/javascript"></script>    
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178505237-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-178505237-1');
</script>
<!-- Global site tag (gtag.js) - Google Ads: 679056788 --><!--  <script async src="https://www.googletagmanager.com/gtag/js?id=AW-679056788"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-679056788'); </script>  -->
<!-- Event snippet for GJEPC_Google_PageView conversion page --> <script> gtag('event', 'conversion', {'send_to': 'AW-679056788/N1zUCJPKxLsBEJSr5sMC'}); </script> 
<script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuart' });        
    });
</script>

<!-- calendar starts-->
<link rel="stylesheet" href="calendar/css/jquery-ui.css" />
  <!--<script src="calendar/js/jquery-1.9.1.js"></script>-->
  <script src="calendar/js/jquery-ui.js"></script>
  <!--<link rel="stylesheet" href="/resources/demos/style.css" />-->
  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
	$( "#cheque_tds_date" ).datepicker();
  });
  </script>
<!-- calendar ends-->
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="css/rcmc.validation.css" />
<script type="text/javascript">
$(document).ready(function(){
	if($("#payment_mode").val()=="RTGS")
	{
		$("#rtgs_desc").css("display","block");
		$("#chequeordd").css("display","none");
	}
	else
	{
		$("#rtgs_desc").css("display","none");
		$("#chequeordd").css("display","block");
	}
	
	$("#payment_mode").change(function(){
		var value = $(this).val();
		//alert(value);
		
		if(value == "RTGS")
		{
			$("#rtgs_desc").css("display","block");
			$("#chequeordd").css("display","none");
		}
		else
		{
			$("#rtgs_desc").css("display","none");
			$("#chequeordd").css("display","block");
		}
	});
});
</script>
<script type="text/javascript">
function validation()
{
var payment_mode=$("#payment_mode").val(); 
var amount_payable=$("#amount_payable").val(); //Amount Payable
var cheque_dd_no=$("#cheque_dd_no").val();
var datepicker=$("#datepicker").val();
var cheque_drawn_bank_name=$("#cheque_drawn_bank_name").val();
var cheque_drawn_branch_name=$("#cheque_drawn_branch_name").val();
var bank_acc_no=$("#bank_acc_no").val(); 
var bank_name=$("#bank_name").val();
var branch_name=$("#branch_name").val();

var ifsc_code=$("#ifsc_code").val();
var int_bank_address=$("#int_bank_address").val();
var int_beneficiary_name=$("#int_beneficiary_name").val();
var int_swift_code=$("#int_swift_code").val();
var int_iban_no=$("#int_iban_no").val();
var int_acc_type=$("#int_acc_type").val();

//var cheque_tds_gross_amount=$("#cheque_tds_gross_amount").val();
var cheque_tds_per=$("#cheque_tds_per").val();
var cheque_tds_amount=$("#cheque_tds_amount").val();
var cheque_tds_Netamount=$("#cheque_tds_Netamount").val();
var cheque_tds_deducted=$("#cheque_tds_deducted").val();

var tds_holder = $('[name="tds_holder"]:checked').val();

var flagpay = flagddno = flagdddate = flagcbankname = flagcbranchname = flagaccno = flagbankname = flagbranchname = flagifsc = flagiadd = flagibeneficiary = flagswift = flagiban = flagacctype = 0;

if(amount_payable=="" || amount_payable=="0")
{
	$("#amount_payable_error").text("Please Select Amount Payable");
	$("#amount_payable").focus();
	var flagpay = 1;
}
else
{
	$("#amount_payable_error").text("");
	var flagpay = 0;
}

if(tds_holder=="Yes"){
		if(cheque_tds_per=="")
		{ 
			$("#cheque_tds_per_error").text("Required");
			$("#cheque_tds_per").focus();
			var flagcheque_tds_per = 1;
		}
		else
		{
			$("#cheque_tds_per_error").text("");
			var flagcheque_tds_per = 0;
		}

		if(cheque_tds_amount=="" || isNaN(cheque_tds_amount))
		{
			$("#cheque_tds_amount_error").text("Please Enter a valid TDS Amount.");
			$("#cheque_tds_amount").focus();
			var flagcheque_tds_amount = 1;
		}
		else
		{
			$("#cheque_tds_amount_error").text("");
			var flagcheque_tds_amount = 0;
		}

		if(cheque_tds_Netamount=="" || isNaN(cheque_tds_Netamount))
		{
			$("#cheque_tds_Netamount_error").text("Please Enter a valid Net Amount");
			$("#cheque_tds_Netamount").focus();
			var flagcheque_tds_Netamount = 1;
		}
		else
		{
			$("#cheque_tds_Netamount_error").text("");
			var flagcheque_tds_Netamount = 0;
		}
		
		if(flagcheque_tds_per==1 || flagcheque_tds_amount==1 || flagcheque_tds_Netamount==1)
		return false;
		else
		return true;
}



if(payment_mode=="")
{
	$("#payment_mode_error").text("Please Select One");
	var flagpay = 1;
}
else
{
	$("#payment_mode_error").text("");
	var flagpay = 0;
}

if($("#payment_mode").val()!="RTGS")
{
		if(cheque_dd_no=="")
		{
			$("#cheque_dd_no_error").text("Required");
			var flagddno = 1;
		}
		else
		{
			$("#cheque_dd_no_error").text("");
			var flagddno = 0;
		}
		
		if(datepicker=="")
		{
			$("#datepicker_error").text("Required");
			var flagdddate = 1;
		}
		else
		{
			$("#datepicker_error").text("");
			var flagdddate = 0;
		}
		
		if(cheque_drawn_bank_name=="")
		{
			$("#cheque_drawn_bank_name_error").text("Please Select One");
			var flagcbankname = 1;
		}
		else
		{
			$("#cheque_drawn_bank_name_error").text("");
			var flagcbankname = 0;
		}
		
		if(cheque_drawn_branch_name=="")
		{
			$("#cheque_drawn_branch_name_error").text("Required");
			var flagcbranchname = 1;
		}
		else
		{
			$("#cheque_drawn_branch_name_error").text("");
			var flagcbranchname = 0;
		}
}

/*
if(cheque_tds_gross_amount=="")
{ 
	$("#cheque_tds_gross_amount_error").text("Required");
	var flagcheque_tds_gross_amount = 1;
}
else
{
	$("#cheque_tds_gross_amount_error").text("");
	var flagcheque_tds_gross_amount = 0;
}
*/
	
if(bank_acc_no=="" || isNaN(bank_acc_no))
{
	$("#bank_acc_no_error").text("Please Enter a valid Bank Account No");
	$("#bank_acc_no").focus();
	var flagaccno = 1;
}
else
{
	$("#bank_acc_no_error").text("");
	var flagaccno = 0;
}

if(bank_name=="")
{ 
	$("#bank_name_error").text("Required");
	var flagbankname = 1;
}
else
{
	$("#bank_name_error").text("");
	var flagbankname = 0;
}

if(branch_name=="")
{
	$("#branch_name_error").text("Required");
	var flagbranchname = 1;
}
else
{
	$("#branch_name_error").text("");
	var flagbranchname = 0;
}

if(ifsc_code=="")
{
	$("#ifsc_code_error").text("Required");
	var flagifsc = 1;
}
else
{
	$("#ifsc_code_error").text("");
	var flagifsc = 0;
}

if(int_bank_address=="")
{
	$("#int_bank_address_error").text("Required");
	var flagiadd = 1;
}
else
{
	$("#int_bank_address_error").text("");
	var flagiadd = 0;
}

if(int_beneficiary_name=="")
{
	$("#int_beneficiary_name_error").text("Required");
	var flagibeneficiary = 1;
}
else
{
	$("#int_beneficiary_name_error").text("");
	var flagibeneficiary = 0;
}

if(int_swift_code=="")
{
	$("#int_swift_code_error").text("Required");
	var flagswift = 1;
}
else
{
	$("#int_swift_code_error").text("");
	var flagswift = 0;
}
if(int_iban_no=="")
{
	$("#int_iban_no_error").text("Required");
	var flagiban = 1;
}
else
{
	$("#int_iban_no_error").text("");
	var flagiban = 0;
}

if(int_acc_type=="")
{
	$("#int_acc_type_error").text("Please Select One");
	var flagacctype = 1;
}
else
{
	$("#int_acc_type_error").text("");
	var flagacctype = 0;
}

if( flagpay==1 || flagddno==1 || flagdddate==1 || flagcbankname==1 || flagcbranchname==1 || flagaccno==1 || flagbankname==1 || flagbranchname==1 || flagifsc==1 || flagiadd==1 || flagibeneficiary==1 || flagswift==1 || flagiban==1 || flagacctype==1)
	return false;
else
	return true;
} 
</script>

<script type="text/javascript">
    $(function () {
		$("#pay").attr("disabled",true);
		$("#amount_payable").on('change',function(){
			var amount_payable = $('#amount_payable').val();
			if(amount_payable != '' || amount_payable != 0)
			{			
			   var gross_total = $('#grand_total').val() * amount_payable/100;
			$("#net_payable_amount").val(gross_total);
			$("#pay").attr("disabled",false);
			} else {
				alert("Please Select Amount Payable");
				return false;
			}
		});
		
        $("input[name='tds_holder']").click(function ()
		{
            if ($("#chkYes").is(":checked")) {
                $("#holder_star").show();
            } else {
                $("#holder_star").hide();
            }
        });
    });
	
	
	$(function () {
	$("#cheque_tds_per").on('change',function(){
		var net_payable_amount = $("#net_payable_amount").val(); //alert(net_payable_amount);
		if(net_payable_amount == '' || net_payable_amount == 0)
		{
			alert("Please Select Amount Payable");
			return false;
		}
		
	});
	});
	
	
	function change_amount() {
        var net_payable_amount = $("#net_payable_amount").val();
        var cheque_tds_amount = $("#cheque_tds_amount").val();
		var cheque_tds_per = $("#cheque_tds_per").val();
		
		if(net_payable_amount != '' || net_payable_amount != 0)
		{
			var get_tds_amount = net_payable_amount * cheque_tds_per/100;
			var amount = net_payable_amount - cheque_tds_amount;
			if(amount>0 && get_tds_amount >= cheque_tds_amount && cheque_tds_amount>0){
			$("#cheque_tds_Netamount").val(amount); 
			$("#pay").attr("disabled",false);
			} else { 
			alert('TDS Amount should be less than selected TDS percentage of Gross Amount'); 
			$("#pay").attr("disabled",true);
			$("#cheque_tds_amount").val('');
			}
		} else {
			alert("Please Select Amount Payable");
			return false;
		}
    }
</script>
</head>

<body>

<div class="wrapper">
<div class="header">
	<?php include('header1.php'); ?>
</div>

<div class="inner_container">

	<div class="breadcrum"><a href="index.php"> Home</a> > Exhibitor Registration - Payment Details </div>    
    <div class="clear"></div>
    
    <div class="content_form_area">
      <div class="pg_title">
        <div class="title_cont"> <span class="top">Exhibitor <img src="images/titles/joint.png" style="position:absolute; top:31px; right:0px;" /></span> <span class="below">Registration</span>
          <div class="clear"></div>
        </div>
      </div>
      <div class="clear"></div>
		<div class="d-flex flex-row justify-center form-group m-10 form-tab">
			<label class="container_radio"><span class="check_text"></span>
			  <input type="radio" disabled="disabled" >
			  <span class="checkmark_radio"></span>
			</label>
			<label class="container_radio"><span class="check_text"></span>
			  <input type="radio" disabled="disabled" >
			  <span class="checkmark_radio"></span>
			</label>
			<label class="container_radio"><span class="check_text"></span>
			  <input type="radio" disabled="disabled">
			  <span class="checkmark_radio"></span>
			</label>
			<label class="container_radio"><span class="check_text"></span>
			  <input type="radio" disabled="disabled">
			  <span class="checkmark_radio"></span>
			</label>
			<label class="container_radio"><span class="check_text"></span>
			  <input type="radio" checked="checked" disabled="disabled">
			  <span class="checkmark_radio"></span>
			</label>		
		</div>
        <div class="title"><h4 style="padding:10px 15px;text-align: center; color: #fff; display: table; background: #00000099; margin: 20px auto; border: 1px solid#000; -webkit-box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); -moz-box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); border-radius: 6px;">PAYMENT DETAILS</h4></div>
    <div class="form_main">        
        
      	<div class="clear"></div>
		<?php
		if(strtoupper($_SESSION['COUNTRY'])=="IN"){  $currency = ""; $int_type = "N"; } else { $currency = "USD"; $int_type = "I";}
		
		//echo '<pre>'; print_r($getstallInfo); exit;
		$last_yr_participant	= strtoupper($getstallInfo['last_yr_participant']);
		$option		=	$getstallInfo['option'];
		$section	=	$getstallInfo['section'];
		$selected_area	=	$getstallInfo['selected_area'];
		$category	=	$getstallInfo['category'];
		$selected_scheme_type	=	$getstallInfo['selected_scheme_type'];
		$selected_premium_type	=	$getstallInfo['selected_premium_type'];
		$woman_entrepreneurs	=	$getstallInfo['woman_entrepreneurs'];		
		$tot_space_cost_rate	=	$getstallInfo['tot_space_cost_rate'];
		$tot_space_cost_discount =   $getstallInfo['tot_space_cost_discount'];
		$get_tot_space_cost_rate = $getstallInfo['get_tot_space_cost_rate'];
		$get_category_rate = $getstallInfo['get_category_rate'];
		$mezzanine_space_charges	=	$getstallInfo['mezzanine_space_charges'];
		$selected_scheme_rate	=	$getstallInfo['selected_scheme_rate'];
		$selected_premium_rate	=	$getstallInfo['selected_premium_rate'];
		$sub_total_cost	=	$getstallInfo['sub_total_cost'];
		$security_deposit	=	$getstallInfo['security_deposit'];
		$govt_service_tax	=	$getstallInfo['govt_service_tax'];
		$grand_total	=	$getstallInfo['grand_total'];
		$mcb_charges	=	$getstallInfo['mcb_charges'];
		$show = $getstallInfo['show'];		
		$incentive_value = $getstallInfo['incentive_value'];		
		$discount_value = $getstallInfo['discount_value'];		
		?>        
        <div class="summary_box">
        <p><strong style="text-transform:uppercase; font-size:14px;">Application Summary</strong><br />
        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        <strong>Last Year Participant :</strong> <?php echo $last_yr_participant;?><br />
        <strong>Option :</strong>&nbsp; <?php echo $option;?> <br />
        <strong>Section :</strong>&nbsp; <?php echo getSection_description($section,$conn);?> <br />
      <!--   <strong>Category :</strong>&nbsp; <?php echo $category;?> <br /> -->
        <strong>Area :</strong>&nbsp; <?php echo $selected_area;?> &nbsp;sqrt<br />
        <strong>Scheme :</strong>&nbsp; 
		<?php 
		if($_SESSION['eventInfo']['event_selected']=="signature")
			echo getSchemeDescription_signature($selected_scheme_type,$conn);
		if($_SESSION['eventInfo']['event_selected']=="iijs")
			echo getSchemeDescription($selected_scheme_type,$conn);
		?> <br />
        <!--<strong>Premium :</strong>&nbsp; <?php echo $selected_premium_type;?>--></p>
        </div>
        <div class="summary_box">
        <p><strong style="text-transform:uppercase; font-size:14px;">Application Payment Summary</strong> <br />
        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        <strong>Space Cost <?php echo $currency;?> :</strong>&nbsp; <?php echo $tot_space_cost_rate;?> <br />
		<!-- <strong>Category Cost<?php echo $currency;?> :</strong>&nbsp; <?php echo $get_category_rate;?> <br /> -->
        <!--<strong>Space Cost Discount<?php echo $currency;?> :</strong>&nbsp; <?php echo $tot_space_cost_discount;?> <br />
        <strong>Space cost after Incentive<?php echo $currency;?> :</strong>&nbsp; <?php echo $incentive_value;?> <br />
        <strong>Discount<?php echo $currency;?> :</strong>&nbsp; <?php echo $discount_value;?> <br />
        <strong>After Discount Space Cost<?php echo $currency;?> :</strong>&nbsp; <?php echo $get_tot_space_cost_rate;?> <br />
        <strong>Selected scheme rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $selected_scheme_rate;?> <br />
        <strong>Selected premium rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $selected_premium_rate;?> <br />-->
        <strong>Sub Total <?php echo $currency;?> :</strong>&nbsp; <?php echo $sub_total_cost;?> <br />
        <strong>Security Deposit (10% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo $security_deposit;?> <br />
        <strong>GST (18% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo $govt_service_tax;?><br />
        <strong>Grand Total <?php echo $currency;?> :</strong>&nbsp; <?php echo $grand_total;?></p>
        </div>

    	<div class="clear"></div>		
		
		<form name="paymentForm" id="paymentForm" method="post" action="" onsubmit="return validation()">        
        <input type="hidden" name="action" id="action" value="save"/>
        <div style="margin-bottom:10px; font-size:14px;"><strong>Payment Details</strong><span class="clear" style="height:1px; background:#ccc; display:block; margin-top:8px;"></span></div> 
		<input type="hidden" name="grand_total" id="grand_total" value="<?php echo round($grand_total);?>"/>
        <span id="wa_machinery_error" class="error_mg"></span>
		
		<?php /*if($event_selected=='iijs'){ ?><p><span style="color: red;">Applicants are requested to make 100% Advance payment for IIJS Premiere 2021 after adjusting the advance payment done earlier.</span></p><?php } */?>
		
		<div class="field_box">
        <div class="field_name">Amount Payable <span>*</span>:</div>
        <div class="field_input">
			<select class="textField" name="amount_payable" id="amount_payable">
				 <option value=""> Select Payable Amount </option>
				 <?php /*if($event_selected=='iijs'){ ?>
				  <option value="100">100%</option>			 
				 <?php } else { */ ?>
				 <?php if($last_yr_participant=="NO"){ ?>
				 <option value="25">25%</option>
				 <?php } else { ?>
				 <option value="25">25%</option>
				 <!--<option value="100">100%</option>-->
				 <?php } /*}*/?>
			</select>
        <br><label class="error" id="amount_payable_error"></label>
		<?php if(isset($signup_error)){ echo "<span style='color: red;'>".$signup_error.'</span>';} ?>
		</div>
        <div class="clear"></div>
        </div>		
		
		<div class="field_box">
        <div class="field_name">Gross Amount <span>*</span>:</div>
        <div class="field_input">
			<input name="net_payable_amount" id="net_payable_amount" type="text" class="textField" 
			<?php if(!empty($net_payable_amount)){ ?> value="<?php echo $net_payable_amount;?>" <?php } ?> readonly/>
            <br><label class="error" id="cheque_tds_gross_amount_error"></label> 
			 <?php if(isset($net_payable_amount_error)){ echo "<span style='color: red;'>".$net_payable_amount_error.'</span>';} ?>
		</div>
        <div class="clear"></div>
        </div>
				
		<?php // if($getstallInfo['last_yr_participant']=="YES" || $event_selected == "iijstritiya23"){ ?>
		<div class="field_box">
        <div class="field_name"><strong>TDS Deducted</strong></div>
        <div class="field_input">
		Yes <input type="radio" id="chkYes" value="Yes" name="tds_holder" <?php if($_POST['tds_holder']=='Yes'){ echo "checked";}?>/>
		No <input type="radio" id="chkNo" value="No" name="tds_holder" <?php if($_POST['tds_holder']=='No'){ echo "checked";}?>/>
		</div>
		<?php if(isset($tds_deducted_error)){ echo "<span style='color: red;'>".$tds_deducted_error.'</span>';} ?>
        <div class="clear"></div>
        </div>
		<?php //} ?>
		
		<div class="field_box" id="holder_star" <?php if($tds_holder!='Yes'){ ?> style="display: none"<?php } ?>>	
            
			<div class="field_box">
				<div class="field_name">TDS Percentage 2%,10%<span>*</span> </div>
				<div class="field_input">
				<select class="textField" name="cheque_tds_per" id="cheque_tds_per">
				<option value="">--Select TDS percentage--</option>
			     <option value="2">2 %</option>
				 <option value="10">10 %</option>
				</select>				
                <br><label class="error" id="cheque_tds_per_error"></label>
				</div>	
				<?php if(isset($cheque_tds_per_error)){ echo "<span style='color: red;'>".$cheque_tds_per_error.'</span>';} ?>
                <div class="clear"></div>
            </div>
            <div class="field_box">
                <div class="field_name">TDS Amount <span>*</span> :</div> 
				<div class="field_input"> 
				<input name="cheque_tds_amount" type="text" id="cheque_tds_amount" class="textField" value="<?php echo $cheque_tds_amount;?>" autocomplete="off" onkeyup="return change_amount()"/>
                <br><label class="error" id="cheque_tds_amount_error"></label>
				</div>
				<?php if(isset($cheque_tds_amount_error)){ echo "<span style='color: red;'>".$cheque_tds_amount_error.'</span>';} ?>
                <div class="clear"></div>
            </div>
			<div class="field_box">
                <div class="field_name">Net Amount<span>*</span> :</div>
                <div class="field_input">
				<input name="cheque_tds_Netamount" type="text" id="cheque_tds_Netamount" class="textField" readonly	/>
                <br><label class="error" id="cheque_tds_Netamount_error"></label>
				</div>
				<?php if(isset($cheque_tds_Netamount_error)){ echo "<span style='color: red;'>".$cheque_tds_Netamount_error.'</span>';} ?>
                <div class="clear"></div>
            </div>	
		<!--<span id="amount"></span>-->			
		</div>
		
        <div class="field_box">
        <div class="field_name">Mode of Payment <span>*</span>:</div>
        <div class="field_input">
        <select class="textField" name="payment_mode" id="payment_mode">
		<?php
		if($int_type=="N")
		{	
			$option.='<option value="RTGS"'; if($payment_mode=="RTGS")$option.= 'selected'; $option.='>ONLINE</option>'; echo $option;
		} else {
			$option='';	$option.='<option value="Wire Transfer"'; if($payment_mode=="Wire Transfer") $option.= 'selected'; $option.='>Wire Transfer</option>';
				echo $option;
		}
		?>            
        </select>
		<br><label class="error" id="payment_mode_error"></label>
		</div>
        <div class="clear"></div>
        </div>  

        <!-- RTGS description end -->
        <div class="clear" style="height:10px;"></div>
        
   		<?php 
		if($int_type=="I")
		{		/* for International Login Remittance */
		?>
            <div style="margin-bottom:10px; font-size:14px;"><strong>USD REMITTANCES</strong><span class="clear" style="height:1px; background:#ccc; display:block; margin-top:8px;"></span></div>
            
            <div class="summary_box">
            <p><strong>Remit to :</strong> <br/>
            SWIFT Code No. SBININBB109 <br/>
            State Bank of India, <br/>
            (09276)-Diamond Branch Mumbai  <br/>
            D-3, West Core, Bharat Diamond Bourse,</br>
			Mumbai 400051</p>
            </div>
            <div class="clear"></div>
                    
            <p>Beneficiary Name : <strong>The Gem & Jewellery Export Promotion Council</strong></p>        
            <p>A/c Number : <strong>00000031170503463</strong></p>            
            <div class="clear" style="height:20px;"></div>            
            <div style="margin-bottom:10px; font-size:14px;"><strong>Remittance details for refund of security deposit for International applicant</strong></div>
        <?php } ?>
        
        <?php
		if($int_type == "N" )
		{					/* For National Login Remittance */
        ?>
        <div style="margin-bottom:10px; font-size:14px;"><strong>RTGS / Bank details for Refund of security deposit</strong><span class="clear" style="height:1px; background:#ccc;margin-top:8px;"></span></div>            
        <?php 
		}
		?>
        
        <div class="field_box">
        <div class="field_name">Bank A/c No. <span>*</span> :</div>
        <div class="field_input">
		<input type="text" name="bank_acc_no" id="bank_acc_no" class="textField" value="<?php if($int_type == "N") echo $bank_acc_no; else echo $int_bank_acc_no; ?>"/>
		<br><label class="error" id="bank_acc_no_error"></label>
		</div> <div class="clear"></div>
        </div>
        
        <div class="field_box">
        <div class="field_name">Name of Bank <span>*</span> :</div>
        <div class="field_input">
		<input type="text" name="bank_name" id="bank_name" class="textField" value="<?php if($int_type == "N") echo $name_bank; else echo $int_name_bank; ?>" />
		<br><label class="error" id="bank_name_error"></label>
		</div> <div class="clear"></div>
        </div>
        
        <div class="field_box">
        <div class="field_name">Name of Branch <span>*</span> :</div>
        <div class="field_input">
		<input type="text" name="branch_name" id="branch_name" class="textField" value="<?php if($int_type == "N") echo $name_bank_branch; else echo $int_name_bank_branch; ?>" />
		<br><label class="error" id="branch_name_error"></label>
		</div> <div class="clear"></div>
        </div>
        
		<?php 
		if($int_type == "N" )
		{	/* For National Login Remittance */
        ?>
        <div class="field_box">
        <div class="field_name">IFSC Code <span>*</span> :</div>
        <div class="field_input"><input type="text" name="ifsc_code" id="ifsc_code" class="textField" value="<?php echo $ifsc_code; ?>" /><br><label class="error" id="ifsc_code_error"></label></div>
        <div class="clear"></div>
        </div>
        <?php 
		}
		?>
        
        <?php 
		if($int_type=="I")
		{
		?>
            <div class="field_box">
            <div class="field_name">Address of Bank <span>*</span> :</div>
            <div class="field_input">
			<input type="text" id="int_bank_address" name="int_bank_address" class="bgcolor" value="<?php echo $int_bank_address; ?>"/>
			<br><label class="error" id="int_bank_address_error"></label>
			</div> <div class="clear"></div>
            </div>
            
            <div class="field_box">
            <div class="field_name">Beneficiary Name <span>*</span> :</div>
            <div class="field_input">
			<input type="text" id="int_beneficiary_name" name="int_beneficiary_name" class="bgcolor" value="<?php echo $int_beneficiary_name; ?>"/>
			<br><label class="error" id="int_beneficiary_name_error"></label>
			</div> <div class="clear"></div>
            </div>
            
            <div class="field_box">
            <div class="field_name">Swift Code <span>*</span> :</div>
            <div class="field_input">
			<input type="text" id="int_swift_code" name="int_swift_code" class="bgcolor" value="<?php echo $int_swift_code; ?>" />
			<br><label class="error" id="int_swift_code_error"></label>
			</div> <div class="clear"></div>
            </div>
            
            <div class="field_box">
            <div class="field_name">IBAN Number <span>*</span> :</div>
            <div class="field_input">
			<input type="text" id="int_iban_no" name="int_iban_no" class="bgcolor" value="<?php echo $int_iban_no; ?>" />
            <br><label class="error" id="int_iban_no_error"></label>
            </div> <div class="clear"></div>
            </div>
        <?php
		}
		?>
        
        <div class="field_box">
        <div class="field_name">Type of Account <span>*</span> :</div>
        <div class="field_input">
            <select class="textField" name="int_acc_type" id="int_acc_type" >
            <option value="">--- Please Select Account Type ---</option>
            <option value="Saving" <?php if($int_acc_type=="Saving") echo "selected";?> >Saving</option>
            <option value="Current" <?php if($int_acc_type=="Current") echo "selected";?> >Current</option>
            </select>
            <br><label class="error" id="int_acc_type_error"></label>
        </div>  <div class="clear"></div>
        </div>     
    	<div class="clear" style="height:20px;"></div>
		
		<input type="checkbox" name="agree" id="agree" style="display: inline-block;" checked><strong> I have read and hereby accept and agree <a href="https://gjepc.org/emailer_gjepc/01.05.2022/index.html" target="_blank" style="color: red"> Stall booking circular </a>,<a href="https://gjepc.org/emailer_gjepc/01.05.2022/Guidelines-Rules-Regulations-for-Allotment-of-Booths.pdf" target="_blank" style="color: red"> Guidelines Rules Regulations for Allotment of Booths</a> , <a href="https://registration.gjepc.org/pdf/TERMS-RULES-REGULATIONS-4th-May-2022.pdf" target="_blank" style="color: red"> Terms & Conditions </a></strong> 
		
        <div class="field_box">
        <div class="field_name"></div>
        <a href="exhibitor_registration_step_3.php" class="button">Prev</a>
        <div class="field_input"><input type="submit" class="button" value="Submit" id="pay" disabled/> </div>
        <div class="clear"></div>
        </div>
        <input type="hidden" name="exh_id" id="exh_id" value="<?php echo $exh_id;?>"/>
	</form>
	  
    <div class="clear"></div>
	</div>	   
    <div class="clear"></div>
	</div>

<div class="clear" style="height:10px;"></div>
</div>

<div class="footer"><?php include('footer.php'); ?><div class="clear"></div>
</div>

<div class="clear"></div>
</div>
</body>
</html>