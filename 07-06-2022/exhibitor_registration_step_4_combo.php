<?php 
include('header_include.php');
/*echo '<pre>';print_r($_SESSION);exit;*/
if(!isset($_SESSION['USERID'])){ header("location:login.php"); exit; }
$uid = intval($_SESSION['USERID']);

$eventInfo = $_SESSION['eventInfo']; /* Get Event Selected */
$event_selected = $eventInfo['event_selected'];
if(empty($event_selected)){ header("location:my_dashboard.php"); exit; }
		 
$getgeneralInfo = $_SESSION['generalInfo']; /* Get 1 step data */
$getcompanyInfo = $_SESSION['companyInfo']; /* Get 2 step data */
$getstallInfo = $_SESSION['stallInfo'];  /* Get 3 step data */
$getiijsInfo = $_SESSION['iijsInfo'];  /* Get 3 step data */
$getsignatureInfo = $_SESSION['signatureInfo'];  /* Get 3 step data */
$getTritiyaInfo = $_SESSION['tritiyaInfo'];  /* Get 3 step data */
//echo '<pre>'; print_r($getsignatureInfo); exit;
//echo '<pre>'; print_r($getiijsInfo); exit;

//$show = "IIJS Signature 2020";
$action = $_POST['action'];
if($action =="Save")
{	
	//echo '<pre>'; print_r($getgeneralInfo); 
	//echo '<pre>'; print_r($getcompanyInfo); 
	//echo '<pre>'; print_r($getstallInfo); exit;
	//echo '<pre>'; print_r($getiijsInfo); exit;
	/* Insert Step 1 Data */
	
	$sqlmx="select contact_person,region from exh_reg_general_info where uid='$uid' and event_selected='$event_selected' order by id desc limit 0,1";
	$querymx=$conn->query($sqlmx);
	$resultmx=$querymx->fetch_assoc();
	$contact_person=$resultmx['contact_person'];
	$region=$resultmx['region'];

	if($region=='HO-MUM (M)'){$to_admin=''; }
	if($region=='RO-CHE'){$to_admin='p.anand@gjepcindia.com'; }
	if($region=='RO-DEL'){$to_admin='pranabes@gjepcindia.com'; }
	if($region=='RO-JAI'){$to_admin='ajaypurohit@gjepcindia.com,shyambilochi@gjepcindia.com,pawan.motwani@gjepcindia.com'; }
	if($region=='RO-KOL'){$to_admin='kaushik@gjepcindia.com'; }
	if($region=='RO-SRT'){$to_admin='malcom@gjepcindia.com,utsav.ansurkar@gjepcindia.com'; }
	
	if(!empty($getgeneralInfo['company_name']) && !empty($event_selected))
/*-------------------------------------------IIJS Data Insert Process Start--------------------------------------------------------*/
	{			
	/*Common Data for both iijs & Signature start*/	
		$int_type = "N";
        $payment_status = "pending";
		$document_status = "pending";
		$application_status = "pending";
		$cheque_dd_no = "";
		$cheque_dd_date = "";
		$cheque_drawn_bank_name = "";
		$cheque_drawn_branch_name = "";
	
		$bank_acc_no = $conn->real_escape_string($_POST["bank_acc_no"]);
		$name_bank = $conn->real_escape_string($_POST["bank_name"]);
		$name_bank_branch = $conn->real_escape_string($_POST["branch_name"]);
		$ifsc_code = $conn->real_escape_string($_POST["ifsc_code"]);
		$int_acc_type = $conn->real_escape_string($_POST["int_acc_type"]);
		/*-------------------iijs  start-----------*/
		$payment_mode = trim($_POST["payment_mode"]);//iijs payment mode
		$amount_payable = $conn->real_escape_string($_POST["amount_payable"]);
		$net_payable_amount = $conn->real_escape_string($_POST["net_payable_amount"]);
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
		/*-------------------iijs end-----------*/

		/*-------------------signature start-----------*/
		$signature_payment_mode = trim($_POST["signature_payment_mode"]);  //signature payment mode
		$signature_amount_payable = $conn->real_escape_string($_POST["signature_amount_payable"]);
		$signature_net_payable_amount = $conn->real_escape_string($_POST["signature_net_payable_amount"]);
		$signature_tds_holder = $conn->real_escape_string($_POST["signature_tds_holder"]);
		if($signature_tds_holder == 'Yes') {	
		$signature_cheque_tds_per = $conn->real_escape_string($_POST["signature_cheque_tds_per"]);
		$signature_cheque_tds_amount = $conn->real_escape_string($_POST["signature_cheque_tds_amount"]);
		$signature_cheque_tds_Netamount = $conn->real_escape_string($_POST["signature_cheque_tds_Netamount"]);
		$signature_cheque_tds_deducted = $conn->real_escape_string($_POST["signature_cheque_tds_deducted"]);		
		} else {		
		$signature_cheque_tds_per = "";
		$signature_cheque_tds_amount = "";
		$signature_cheque_tds_Netamount = "";
		$signature_cheque_tds_deducted = "";
		}
		/*-------------------signature end -----------*/

		/*-------------------tritiya start-----------*/
		$tritiya_payment_mode = trim($_POST["tritiya_payment_mode"]);  //signature payment mode
		$tritiya_amount_payable = $conn->real_escape_string($_POST["tritiya_amount_payable"]);
		$tritiya_net_payable_amount = $conn->real_escape_string($_POST["tritiya_net_payable_amount"]);
		$tritiya_tds_holder = $conn->real_escape_string($_POST["tritiya_tds_holder"]);
		if($tritiya_tds_holder == 'Yes') {	
		$tritiya_cheque_tds_per = $conn->real_escape_string($_POST["tritiya_cheque_tds_per"]);
		$tritiya_cheque_tds_amount = $conn->real_escape_string($_POST["tritiya_cheque_tds_amount"]);
		$tritiya_cheque_tds_Netamount = $conn->real_escape_string($_POST["tritiya_cheque_tds_Netamount"]);
		$tritiya_cheque_tds_deducted = $conn->real_escape_string($_POST["tritiya_cheque_tds_deducted"]);		
		} else {		
		$tritiya_cheque_tds_per = "";
		$tritiya_cheque_tds_amount = "";
		$tritiya_cheque_tds_Netamount = "";
		$tritiya_cheque_tds_deducted = "";
		}
		/*-------------------tritiya end -----------*/
				
		if(empty($amount_payable)) {  $amount_payable_error = "Please Select Amount Payable"; }
		else if(empty($net_payable_amount)) { $net_payable_amount_error = "Please Select Net Amount Payable"; }
		/*else if($getiijsInfo['last_yr_participant'] == "YES") {
		 if(empty($tds_holder)) {$tds_holder_error = "Please Select any option"; }
	
		}*/	
		else if(empty($tds_holder) && $getiijsInfo['last_yr_participant'] == "YES") { $tds_holder_error = "Please Select Net Amount Payable"; }

		else if(empty($cheque_tds_per) && $tds_holder=="Yes" && $getiijsInfo['last_yr_participant'] == "YES") { $cheque_tds_per_error = "Please Select Net Amount Payable"; }

		else if(empty($cheque_tds_amount) && $tds_holder=="Yes" && $getiijsInfo['last_yr_participant'] == "YES") { $cheque_tds_amount_error = "Please Select Net Amount Payable"; }

		else if(empty($cheque_tds_Netamount) && $tds_holder=="Yes" && $getiijsInfo['last_yr_participant'] == "YES") { $cheque_tds_Netamount_error = "Please Select Net Amount Payable"; }


		else if(empty($signature_tds_holder) && $getsignatureInfo['last_yr_participant'] == "YES") { 
			$signature_tds_holder_error = "Please Select Net Amount Payable"; }

		else if(empty($signature_cheque_tds_per) && $signature_tds_holder=="Yes" && $getsignatureInfo['last_yr_participant'] == "YES") {
		 $signature_cheque_tds_per_error = "Please Select Net Amount Payable"; }

		else if(empty($signature_cheque_tds_amount) && $signature_tds_holder=="Yes" && $getsignatureInfo['last_yr_participant'] == "YES") { $signature_cheque_tds_amount_error = "Please Select Net Amount Payable"; }

		else if(empty($signature_cheque_tds_Netamount) && $signature_tds_holder=="Yes" && $getsignatureInfo['last_yr_participant'] == "YES") { $signature_cheque_tds_Netamount_error = "Please Select Net Amount Payable"; }


		else if(empty($tritiya_tds_holder) && $getTritiyaInfo['last_yr_participant'] == "YES") { 
			$tritiya_tds_holder_error = "Please Select Net Amount Payable"; }

		else if(empty($tritiya_cheque_tds_per) && $tritiya_tds_holder=="Yes" && $getTritiyaInfo['last_yr_participant'] == "YES") {
		 $tritiya_cheque_tds_per_error = "Please Select Net Amount Payable"; }

		else if(empty($tritiya_cheque_tds_amount) && $tritiya_tds_holder=="Yes" && $getTritiyaInfo['last_yr_participant'] == "YES") { $tritiya_cheque_tds_amount_error = "Please Select Net Amount Payable"; }

		else if(empty($tritiya_cheque_tds_Netamount) && $tritiya_tds_holder=="Yes" && $getTritiyaInfo['last_yr_participant'] == "YES") { $tritiya_cheque_tds_Netamount_error = "Please Select Net Amount Payable"; }



		else if(empty($payment_mode)) { $payment_mode_error = "Please Select Payment Mode"; }
		else if(empty($signature_payment_mode)) { $signature_payment_mode_error = "Please Select Net Amount Payable"; }
		else if(empty($tritiya_payment_mode)) { $tritiya_payment_mode_error = "Please Select Net Amount Payable"; }

		else if(empty($signature_amount_payable)) { $signature_amount_payable_error = "Please Select Net Amount Payable"; }
		else if(empty($tritiya_amount_payable)) { $tritiya_amount_payable_error = "Please Select Net Amount Payable"; }
		else if(empty($signature_net_payable_amount)) { $signature_net_payable_amount_error = "Please Select Net Amount Payable"; }
		else if(empty($tritiya_net_payable_amount)) { $tritiya_net_payable_amount_error = "Please Select Net Amount Payable"; }
		
		else if(empty($bank_acc_no)) { $bank_acc_no_error = "Please Select Net Amount Payable"; }
		else if(empty($ifsc_code)) { $ifsc_code_error = "Please Select Net Amount Payable"; }
		else if(empty($name_bank)) { $name_bank_error = "Please Select Net Amount Payable"; }
		else if(empty($name_bank_branch)) { $name_bank_branch_error = "Please Select Net Amount Payable"; }
		else if(empty($int_acc_type)) { $int_acc_type_error = "Please Select Net Amount Payable"; }

		else {

        /*echo '<pre>'; print_r($_POST); exit;*/

		if(strtoupper($_SESSION['COUNTRY'])=="IN"){  $currency = "";}else{ $currency = "USD";}
	      /*Common Data for both iijs & Signature end*/
		 $generalInfo_iijs = "insert into exh_reg_general_info set uid='$uid',company_name='".$getgeneralInfo['company_name']."',membership_id='".$getgeneralInfo['membership_id']."',membership_date='".$getgeneralInfo['membership_date']."',bp_number='".$getgeneralInfo['bp_number']."',address1='".$getgeneralInfo['address1']."',address2='".$getgeneralInfo['address2']."',address3='".$getgeneralInfo['address3']."',billing_address_id='".$getgeneralInfo['billing_address_id']."',get_billing_bp_number='".$getgeneralInfo['get_billing_bp_number']."',billing_gstin='".$getgeneralInfo['billing_gstin']."',billing_address1='".$getgeneralInfo['billing_address1']."',billing_address2='".$getgeneralInfo['billing_address2']."',billing_address3='".$getgeneralInfo['billing_address3']."',bcity='".$getgeneralInfo['bcity']."',bpincode='".$getgeneralInfo['bpincode']."',bcountry='".$getgeneralInfo['bcountry']."',btelephone_no='".$getgeneralInfo['btelephone_no']."',bfax_no='".$getgeneralInfo['bfax_no']."',billing_address_same='".$getgeneralInfo['billing_address_same']."',pan_no='".$getgeneralInfo['pan_no']."',tan_no='".$getgeneralInfo['tan_no']."',city='".$getgeneralInfo['city']."',pincode='".$getgeneralInfo['pincode']."',country='".$getgeneralInfo['country']."',telephone_no='".$getgeneralInfo['telephone_no']."',mobile='".$getgeneralInfo['mobile']."',fax_no='".$getgeneralInfo['fax_no']."',email='".$getgeneralInfo['email']."',gst='".$getgeneralInfo['gst']."',kyc='".$getgeneralInfo['kyc']."',website='".$getgeneralInfo['website']."',contact_person='".$getgeneralInfo['contact_person']."',contact_person_desg='".$getgeneralInfo['contact_person_desg']."',contact_person_desg_show='".$getgeneralInfo['contact_person_desg_show']."',contact_person_co='".$getgeneralInfo['contact_person_co']."',contacts='".$getgeneralInfo['contacts']."',event_for='IIJS PREMIERE 2022',event_selected='iijs22',participant_type='".$getgeneralInfo['participant_type']."',region='".$getgeneralInfo['region']."',created_date=NOW(),isCombo='Y',year='2022'";
		$generalInfoResult = $conn->query($generalInfo_iijs);
		$gid_iijs = $conn->insert_id;
		
if($gid_iijs!='')
{
	/* Insert Step 2 Data */
	$companyInfo_iijs = "INSERT into exh_reg_company_details set gid='".$gid_iijs."', uid='$uid', we_are_jewellery='".$getcompanyInfo['we_are_jewellery']."', we_are_loose='".$getcompanyInfo['we_are_loose']."',we_are_machinery='".$getcompanyInfo['we_are_machinery']."', we_are='".$getcompanyInfo['we_are']."', we_are_jewellery_any_other='".$getcompanyInfo['we_are_jewellery_any_other']."',we_are_loose_any_other='".$getcompanyInfo['we_are_loose_any_other']."',we_are_machinery_any_other='".$getcompanyInfo['we_are_machinery_any_other']."', we_are_any_other='".$getcompanyInfo['we_are_any_other']."',comp_desc='".$getcompanyInfo['comp_desc']."',last_yr_turn_over='".$getcompanyInfo['last_yr_turn_over']."',created_date=NOW(),`show`='IIJS PREMIERE 2022',event_selected='iijs22',isCombo='Y',year='2022'";
	$companyInfoResult = $conn->query($companyInfo_iijs);
    if(!$companyInfoResult) { die('Error: Company Details insert query failed' . $conn->error); }	
	
	/* Insert Step 3 Data */
 
	 $iijsInfo = "INSERT into exh_registration set options='".$getiijsInfo['option']."',uid='$uid',gid='$gid_iijs',woman_entrepreneurs='".$getiijsInfo['woman_entrepreneurs']."',last_yr_participant='".$getiijsInfo['last_yr_participant']."',section='".$getiijsInfo['section']."',category='".$getiijsInfo['category']."',selected_area='".$getiijsInfo['selected_area']."',selected_scheme_type='".$getiijsInfo['selected_scheme_type']."',selected_premium_type='".$getiijsInfo['selected_premium_type']."',tot_space_cost_rate='".$getiijsInfo['tot_space_cost_rate']."',tot_space_cost_discount='".$getiijsInfo['tot_space_cost_discount']."',get_tot_space_cost_rate='".$getiijsInfo['get_tot_space_cost_rate']."',selected_scheme_rate='".$getiijsInfo['selected_scheme_rate']."',selected_premium_rate='".$getiijsInfo['selected_premium_rate']."',sub_total_cost ='".$getiijsInfo['sub_total_cost']."',security_deposit='".$getiijsInfo['security_deposit']."',govt_service_tax='".$getiijsInfo['govt_service_tax']."',grand_total='".$getiijsInfo['grand_total']."',created_date=NOW(),`show`='IIJS PREMIERE 2022',event_selected='iijs22',isCombo='Y',year='2022'";
	$iijsInfoResult = $conn->query($iijsInfo);	
	if(!$iijsInfoResult) { die('Error: IIJS Stall Details insert query failed' . $conn->error); }
	
	/* Insert Step 4 Data */
	if(isset($_POST["payment_mode"]) && isset($_POST["bank_acc_no"]))
	{	
		$sqlm = "select * from  exh_registration where uid='$uid' AND gid='$gid_iijs'";
		$querym = $conn->query($sqlm);		
		$resultm = $querym->fetch_assoc();
		$grandTotals = $resultm["grand_total"];
		$exh_id = $resultm["exh_id"];
	
		/* 50% or 100% */				
		
		//$grandTotals;
		$netTotal = $grandTotals * $amount_payable/100;
		//echo '--->'.$net_payable_amount .'=='. $netTotal;
		// if($net_payable_amount == $netTotal)
		// {

		 $paymenyInfo_iijs = "insert into exh_reg_payment_details set gid='$gid_iijs', uid='$uid', int_type='$int_type', payment_mode='$payment_mode', cheque_dd_no='$cheque_dd_no', cheque_dd_date='$cheque_dd_date', cheque_drawn_bank_name='$cheque_drawn_bank_name', cheque_drawn_branch_name='$cheque_drawn_branch_name', bank_acc_no='$bank_acc_no', name_bank='$name_bank', name_bank_branch='$name_bank_branch', ifsc_code='$ifsc_code', int_acc_type='$int_acc_type', created_date=NOW(), payment_status='$payment_status', document_status='$document_status', application_status='$application_status', erp_push='$erp_push', `tds_holder`='$tds_holder',`net_payable_amount`='$net_payable_amount',`percentage`='$amount_payable',`cheque_tds_per`='$cheque_tds_per',`cheque_tds_amount`='$cheque_tds_amount',`cheque_tds_Netamount`='$cheque_tds_Netamount',`cheque_tds_deducted`='$cheque_tds_deducted',`show`='IIJS PREMIERE 2022',event_selected='iijs22',isCombo='Y',year='2022'";
		$paymenyInfoResult = $conn->query($paymenyInfo_iijs);
		if(!$paymenyInfoResult) { die('Error: payment Details insert query failed' .$conn->error); }
		$conn->query("update exh_registration set curr_last_yr_check='Y' where exh_id='$exh_id'");	
		// } else { echo 'something wrong'; }
		//}

	}


/*-------------------------------------------IIJS Data Insert Process end--------------------------------------------------------*/
/*======================================================================================================================================*/
/*-------------------------------------------Signature Data Insert Process Start--------------------------------------------------------*/
$generalInfo_signature = "insert into exh_reg_general_info set uid='$uid',company_name='".$getgeneralInfo['company_name']."',membership_id='".$getgeneralInfo['membership_id']."',membership_date='".$getgeneralInfo['membership_date']."',bp_number='".$getgeneralInfo['bp_number']."',address1='".$getgeneralInfo['address1']."',address2='".$getgeneralInfo['address2']."',address3='".$getgeneralInfo['address3']."',billing_address_id='".$getgeneralInfo['billing_address_id']."',get_billing_bp_number='".$getgeneralInfo['get_billing_bp_number']."',billing_gstin='".$getgeneralInfo['billing_gstin']."',billing_address1='".$getgeneralInfo['billing_address1']."',billing_address2='".$getgeneralInfo['billing_address2']."',billing_address3='".$getgeneralInfo['billing_address3']."',bcity='".$getgeneralInfo['bcity']."',bpincode='".$getgeneralInfo['bpincode']."',bcountry='".$getgeneralInfo['bcountry']."',btelephone_no='".$getgeneralInfo['btelephone_no']."',bfax_no='".$getgeneralInfo['bfax_no']."',billing_address_same='".$getgeneralInfo['billing_address_same']."',pan_no='".$getgeneralInfo['pan_no']."',tan_no='".$getgeneralInfo['tan_no']."',city='".$getgeneralInfo['city']."',pincode='".$getgeneralInfo['pincode']."',country='".$getgeneralInfo['country']."',telephone_no='".$getgeneralInfo['telephone_no']."',mobile='".$getgeneralInfo['mobile']."',fax_no='".$getgeneralInfo['fax_no']."',email='".$getgeneralInfo['email']."',gst='".$getgeneralInfo['gst']."',kyc='".$getgeneralInfo['kyc']."',website='".$getgeneralInfo['website']."',contact_person='".$getgeneralInfo['contact_person']."',contact_person_desg='".$getgeneralInfo['contact_person_desg']."',contact_person_desg_show='".$getgeneralInfo['contact_person_desg_show']."',contact_person_co='".$getgeneralInfo['contact_person_co']."',contacts='".$getgeneralInfo['contacts']."',event_for='IIJS SIGNATURE 2023',event_selected='signature23',participant_type='".$getgeneralInfo['participant_type']."',region='".$getgeneralInfo['region']."',created_date=NOW(),isCombo='Y',year='2023'";
		$generalInfoResult = $conn->query($generalInfo_signature);
		$gid_signature = $conn->insert_id; // last insert id for signature data
		
if($gid_signature!='') //check gid is not blank
{
	/*========================================================================================================================*/
	/* Insert company information into exh_reg_company_details for signature */
	/*========================================================================================================================*/
	$companyInfo_signature = "INSERT into exh_reg_company_details set gid='".$gid_signature."', uid='$uid', we_are_jewellery='".$getcompanyInfo['we_are_jewellery']."', we_are_loose='".$getcompanyInfo['we_are_loose']."',we_are_machinery='".$getcompanyInfo['we_are_machinery']."', we_are='".$getcompanyInfo['we_are']."', we_are_jewellery_any_other='".$getcompanyInfo['we_are_jewellery_any_other']."',we_are_loose_any_other='".$getcompanyInfo['we_are_loose_any_other']."',we_are_machinery_any_other='".$getcompanyInfo['we_are_machinery_any_other']."', we_are_any_other='".$getcompanyInfo['we_are_any_other']."',comp_desc='".$getcompanyInfo['comp_desc']."',last_yr_turn_over='".$getcompanyInfo['last_yr_turn_over']."',created_date=NOW(),`show`='IIJS SIGNATURE 2023',event_selected='signature',isCombo='Y',year='2023'";
	$companyInfoResult = $conn->query($companyInfo_signature);
    if(!$companyInfoResult) { die('Error: Company Details for signature insert query failed' .$conn->error); }	
	/*===========================================================================================================================*/
	/* Insert stall information into exh_registration for signature */
	/*============================================================================================================================*/
	$signatureInfo = "INSERT into exh_registration set options='".$getsignatureInfo['option']."',uid='$uid',gid='$gid_signature',woman_entrepreneurs='".$getsignatureInfo['woman_entrepreneurs']."',last_yr_participant='".$getsignatureInfo['last_yr_participant']."',section='".$getsignatureInfo['section']."',category='".$getsignatureInfo['category']."',selected_area='".$getsignatureInfo['selected_area']."',selected_scheme_type='".$getsignatureInfo['selected_scheme_type']."',selected_premium_type='".$getsignatureInfo['selected_premium_type']."',tot_space_cost_rate='".$getsignatureInfo['tot_space_cost_rate']."',tot_space_cost_discount='".$getsignatureInfo['tot_space_cost_discount']."',get_tot_space_cost_rate='".$getsignatureInfo['get_tot_space_cost_rate']."',get_category_rate='".$getsignatureInfo['get_category_rate']."',selected_scheme_rate='".$getsignatureInfo['selected_scheme_rate']."',selected_premium_rate='".$getsignatureInfo['selected_premium_rate']."',sub_total_cost ='".$getsignatureInfo['sub_total_cost']."',security_deposit='".$getsignatureInfo['security_deposit']."',govt_service_tax='".$getsignatureInfo['govt_service_tax']."',grand_total='".$getsignatureInfo['grand_total']."',created_date=NOW(),`show`='IIJS SIGNATURE 2023',event_selected='signature23',isCombo='Y',year='2023'";
	$signatureInfoResult = $conn->query($signatureInfo);	
	if(!$signatureInfoResult) { die('Error: Signature Stall Details insert query failed' . $conn->error); }
	/*==============================================================================================================================*/
	/*Insert payment information into exh_reg_company_details table for signature  */
	/*==============================================================================================================================*/
	if(isset($_POST["signature_payment_mode"]) && isset($_POST["bank_acc_no"]))
	{
		$sql_signature = "select * from  exh_registration where uid='$uid' AND gid='$gid_signature'";
		$query_signture = $conn->query($sql_signature);		
		$result_signature = $query_signture->fetch_assoc();
		$signature_grandTotals = $result_signature["grand_total"];
		$exh_id_signature = $result_signature["exh_id"];	
		/* 50% or 100% */
		
		//$grandTotals;
		$signature_netTotal = $signature_grandTotals * $signature_amount_payable/100;
		//echo '--->'.$net_payable_amount .'=='. $netTotal;
		// if($signature_net_payable_amount == $signature_netTotal)
		// {		
		 $paymentInfo_signature = "insert into exh_reg_payment_details set gid='$gid_signature', uid='$uid', int_type='$int_type', payment_mode='$signature_payment_mode', cheque_dd_no='$cheque_dd_no', cheque_dd_date='$cheque_dd_date', cheque_drawn_bank_name='$cheque_drawn_bank_name', cheque_drawn_branch_name='$cheque_drawn_branch_name', bank_acc_no='$bank_acc_no', name_bank='$name_bank', name_bank_branch='$name_bank_branch', ifsc_code='$ifsc_code', int_acc_type='$int_acc_type', created_date=NOW(), payment_status='$payment_status', document_status='$document_status', application_status='$application_status', erp_push='$erp_push', `tds_holder`='$signature_tds_holder',`net_payable_amount`='$signature_net_payable_amount',`percentage`='$signature_amount_payable',`cheque_tds_per`='$signature_cheque_tds_per',`cheque_tds_amount`='$signature_cheque_tds_amount',`cheque_tds_Netamount`='$signature_cheque_tds_Netamount',`cheque_tds_deducted`='$signature_cheque_tds_deducted',`show`='IIJS SIGNATURE 2023',event_selected='signature23',isCombo='Y',year='2023'";

		$paymentInfoResult = $conn->query($paymentInfo_signature);
		if(!$paymentInfoResult) { die('Error: payment Details insert query failed' . $conn->error); }
		$conn->query("update exh_registration set curr_last_yr_check='Y' where exh_id='$exh_id_signature'");	
/*-------------------------------------------Signature Data Insert Process end--------------------------------------------------------*/


		// } else { echo 'something wrong'; }
	}
	
	/*-------------------------------------------Tritiya Data Insert Process Start--------------------------------------------------------*/
$generalInfo_tritiya = "insert into exh_reg_general_info set uid='$uid',company_name='".$getgeneralInfo['company_name']."',membership_id='".$getgeneralInfo['membership_id']."',membership_date='".$getgeneralInfo['membership_date']."',bp_number='".$getgeneralInfo['bp_number']."',address1='".$getgeneralInfo['address1']."',address2='".$getgeneralInfo['address2']."',address3='".$getgeneralInfo['address3']."',billing_address_id='".$getgeneralInfo['billing_address_id']."',get_billing_bp_number='".$getgeneralInfo['get_billing_bp_number']."',billing_gstin='".$getgeneralInfo['billing_gstin']."',billing_address1='".$getgeneralInfo['billing_address1']."',billing_address2='".$getgeneralInfo['billing_address2']."',billing_address3='".$getgeneralInfo['billing_address3']."',bcity='".$getgeneralInfo['bcity']."',bpincode='".$getgeneralInfo['bpincode']."',bcountry='".$getgeneralInfo['bcountry']."',btelephone_no='".$getgeneralInfo['btelephone_no']."',bfax_no='".$getgeneralInfo['bfax_no']."',billing_address_same='".$getgeneralInfo['billing_address_same']."',pan_no='".$getgeneralInfo['pan_no']."',tan_no='".$getgeneralInfo['tan_no']."',city='".$getgeneralInfo['city']."',pincode='".$getgeneralInfo['pincode']."',country='".$getgeneralInfo['country']."',telephone_no='".$getgeneralInfo['telephone_no']."',mobile='".$getgeneralInfo['mobile']."',fax_no='".$getgeneralInfo['fax_no']."',email='".$getgeneralInfo['email']."',gst='".$getgeneralInfo['gst']."',kyc='".$getgeneralInfo['kyc']."',website='".$getgeneralInfo['website']."',contact_person='".$getgeneralInfo['contact_person']."',contact_person_desg='".$getgeneralInfo['contact_person_desg']."',contact_person_desg_show='".$getgeneralInfo['contact_person_desg_show']."',contact_person_co='".$getgeneralInfo['contact_person_co']."',contacts='".$getgeneralInfo['contacts']."',event_for='IIJS TRITIYA 2023',event_selected='iijstritiya23',participant_type='".$getgeneralInfo['participant_type']."',region='".$getgeneralInfo['region']."',created_date=NOW(),isCombo='Y',year='2023'";
		$generalInfoResultTritiya = $conn->query($generalInfo_tritiya);
		$gid_tritiya = $conn->insert_id; // last insert id for Tritiya data
		
if($gid_tritiya!='') //check gid is not blank
{
	/*========================================================================================================================*/
	/* Insert company information into exh_reg_company_details for Tritiya */
	/*========================================================================================================================*/
	$companyInfo_tritiya = "INSERT into exh_reg_company_details set gid='".$gid_tritiya."', uid='$uid', we_are_jewellery='".$getcompanyInfo['we_are_jewellery']."', we_are_loose='".$getcompanyInfo['we_are_loose']."',we_are_machinery='".$getcompanyInfo['we_are_machinery']."', we_are='".$getcompanyInfo['we_are']."', we_are_jewellery_any_other='".$getcompanyInfo['we_are_jewellery_any_other']."',we_are_loose_any_other='".$getcompanyInfo['we_are_loose_any_other']."',we_are_machinery_any_other='".$getcompanyInfo['we_are_machinery_any_other']."', we_are_any_other='".$getcompanyInfo['we_are_any_other']."',comp_desc='".$getcompanyInfo['comp_desc']."',last_yr_turn_over='".$getcompanyInfo['last_yr_turn_over']."',created_date=NOW(),`show`='IIJS TRITIYA 2023',event_selected='iijstritiya23',isCombo='Y',year='2023'";
	$companyInfoResult = $conn->query($companyInfo_tritiya);
    if(!$companyInfoResult) { die('Error: Company Details for Tritiya insert query failed' .$conn->error); }	
	/*===========================================================================================================================*/
	/* Insert stall information into exh_registration for Tritiya */
	/*============================================================================================================================*/
	$TritiyaInfo = "INSERT into exh_registration set options='".$getTritiyaInfo['option']."',uid='$uid',gid='$gid_signature',woman_entrepreneurs='".$getTritiyaInfo['woman_entrepreneurs']."',last_yr_participant='".$getTritiyaInfo['last_yr_participant']."',section='".$getTritiyaInfo['section']."',category='".$getTritiyaInfo['category']."',selected_area='".$getTritiyaInfo['selected_area']."',selected_scheme_type='".$getTritiyaInfo['selected_scheme_type']."',selected_premium_type='".$getTritiyaInfo['selected_premium_type']."',tot_space_cost_rate='".$getTritiyaInfo['tot_space_cost_rate']."',tot_space_cost_discount='".$getTritiyaInfo['tot_space_cost_discount']."',get_tot_space_cost_rate='".$getTritiyaInfo['get_tot_space_cost_rate']."',get_category_rate='".$getTritiyaInfo['get_category_rate']."',selected_scheme_rate='".$getTritiyaInfo['selected_scheme_rate']."',selected_premium_rate='".$getTritiyaInfo['selected_premium_rate']."',sub_total_cost ='".$getTritiyaInfo['sub_total_cost']."',security_deposit='".$getTritiyaInfo['security_deposit']."',govt_service_tax='".$getTritiyaInfo['govt_service_tax']."',grand_total='".$getTritiyaInfo['grand_total']."',created_date=NOW(),`show`='IIJS TRITIYA 2023',event_selected='iijstritiya23',isCombo='Y',year='2023'";
	$TritiyaInfoResult = $conn->query($TritiyaInfo);	
	if(!$TritiyaInfoResult) { die('Error: Tritiya Stall Details insert query failed' . $conn->error); }

     $sql_iijs = "SELECT * FROM `exh_registration` WHERE uid='$uid' AND gid='$gid_iijs' AND `show`='IIJS PREMIERE 2022' AND event_selected='iijs22' order by exh_id desc limit 0,1";
		$queryiijs= $conn->query($sql_iijs);		
		$resultm = $queryiijs->fetch_assoc();
		$grandTotal_iijs = $result_iijs["grand_total"];
		$exh_id_iijs = $result_iijs["exh_id"];
		
		if($_POST["tds_holder"] == 'Yes' && $getstallInfo['last_yr_participant'] == "YES") {
		//echo $_POST['cheque_tds_Netamount'];
		$amountPay_iijs = $conn->real_escape_string($_POST["cheque_tds_Netamount"]);
		//echo '<pre>'; print_r($_POST);  exit;
		} else if($_POST["tds_holder"] == 'No' && $getstallInfo['last_yr_participant'] == "YES") {
			//echo $_POST["net_payable_amount"];
			$amountPay_iijs = $conn->real_escape_string($_POST["net_payable_amount"]);
			//echo '<pre>'; print_r($_POST);  exit;
		} else {
			//echo $_POST["net_payable_amount"];
			$amountPay_iijs = $conn->real_escape_string($_POST["net_payable_amount"]);
			//echo '<pre>'; print_r($_POST);  exit;
		}

	$sql_signature = "SELECT * FROM `exh_registration` WHERE uid='$uid' AND gid='$gid_signature' AND `show`='IIJS SIGNATURE 2023' AND event_selected='signature23' order by exh_id desc limit 0,1";
	$querysignature= $conn->query($sql_signature);		
	$resultm = $querysignature->fetch_assoc();
	$grandTotal_signature = $result_signature["grand_total"];
	$exh_id_signature = $result_signature["exh_id"];
	
	if($_POST["tds_holder"] == 'Yes' && $getstallInfo['signature_last_yr_participant'] == "YES") {
	//echo $_POST['cheque_tds_Netamount'];
	$amountPay_signature = $conn->real_escape_string($_POST["signature_cheque_tds_Netamount"]);
	//echo '<pre>'; print_r($_POST);  exit;
	} else if($_POST["tds_holder"] == 'No' && $getstallInfo['signature_last_yr_participant'] == "YES") {
		//echo $_POST["net_payable_amount"];
		$amountPay_signature = $conn->real_escape_string($_POST["signature_net_payable_amount"]);
		//echo '<pre>'; print_r($_POST);  exit;
	} else {
		//echo $_POST["net_payable_amount"];
		$amountPay_signature = $conn->real_escape_string($_POST["signature_net_payable_amount"]);
		//echo '<pre>'; print_r($_POST);  exit;
	}

	$sql_tritiya = "SELECT * FROM `exh_registration` WHERE uid='$uid' AND gid='$gid_tritiya' AND `show`='IIJS TRITIYA 2023' AND event_selected='iijstritiya23' order by exh_id desc limit 0,1";
	$querytritiya= $conn->query($sql_tritiya);		
	$resultm = $querytritiya->fetch_assoc();
	$grandTotal_tritiya = $result_tritiya["grand_total"];
	$exh_id_tritiya = $result_tritiya["exh_id"];
	
	if($_POST["tds_holder"] == 'Yes' && $getstallInfo['tritiya_last_yr_participant'] == "YES") {
	//echo $_POST['cheque_tds_Netamount'];
	$amountPay_tritiya = $conn->real_escape_string($_POST["tritiya_cheque_tds_Netamount"]);
	//echo '<pre>'; print_r($_POST);  exit;
	} else if($_POST["tds_holder"] == 'No' && $getstallInfo['tritiya_last_yr_participant'] == "YES") {
		//echo $_POST["net_payable_amount"];
		$amountPay_tritiya = $conn->real_escape_string($_POST["tritiya_net_payable_amount"]);
		//echo '<pre>'; print_r($_POST);  exit;
	} else {
		//echo $_POST["net_payable_amount"];
		$amountPay_tritiya = $conn->real_escape_string($_POST["tritiya_net_payable_amount"]);
		//echo '<pre>'; print_r($_POST);  exit;
	}


	/*==============================================================================================================================*/
	/*Insert payment information into exh_reg_company_details table for Tritiya  */
	/*==============================================================================================================================*/
	if(isset($_POST["tritiya_payment_mode"]) && isset($_POST["bank_acc_no"]))
	{
		$sql_tritiya = "select * from  exh_registration where uid='$uid' AND gid='$gid_tritiya'";
		$query_signture = $conn->query($sql_tritiya);		
		$result_tritiya = $query_signture->fetch_assoc();
		$tritiya_grandTotals = $result_tritiya["grand_total"];
		$exh_id_tritiya = $result_tritiya["exh_id"];	
		/* 50% or 100% */
		
		//$grandTotals;
		$tritiya_netTotal = $tritiya_grandTotals * $tritiya_amount_payable/100;
		//echo '--->'.$net_payable_amount .'=='. $netTotal;
		// if($tritiya_net_payable_amount == $tritiya_netTotal)
		// {		
		  $paymentInfo_tritiya = "insert into exh_reg_payment_details set gid='$gid_tritiya', uid='$uid', int_type='$int_type', payment_mode='$tritiya_payment_mode', cheque_dd_no='$cheque_dd_no', cheque_dd_date='$cheque_dd_date', cheque_drawn_bank_name='$cheque_drawn_bank_name', cheque_drawn_branch_name='$cheque_drawn_branch_name', bank_acc_no='$bank_acc_no', name_bank='$name_bank', name_bank_branch='$name_bank_branch', ifsc_code='$ifsc_code', int_acc_type='$int_acc_type', created_date=NOW(), payment_status='$payment_status', document_status='$document_status', application_status='$application_status', erp_push='$erp_push', `tds_holder`='$tritiya_tds_holder',`net_payable_amount`='$tritiya_net_payable_amount',`percentage`='$tritiya_amount_payable',`cheque_tds_per`='$tritiya_cheque_tds_per',`cheque_tds_amount`='$tritiya_cheque_tds_amount',`cheque_tds_Netamount`='$tritiya_cheque_tds_Netamount',`cheque_tds_deducted`='$tritiya_cheque_tds_deducted',`show`='IIJS TRITIYA 2023',event_selected='iijstritiya23',isCombo='Y',year='2023'";

		$paymentInfoResult = $conn->query($paymentInfo_tritiya);
		if(!$paymentInfoResult) { die('Error: payment Details insert query failed' . $conn->error); }
		$conn->query("update exh_registration set curr_last_yr_check='Y' where exh_id='$exh_id_tritiya'");	

		// Manage session for multiple shows payment
         $amountPay = $amountPay_iijs+$amountPay_signature+$amountPay_tritiya;

        $_SESSION['amountPay'] = $amountPay; 
        $_SESSION['amountPay_iijs'] = $amountPay_iijs; 
        $_SESSION['amountPay_signature'] = $amountPay_signature; 
        $_SESSION['amountPay_tritiya'] = $amountPay_tritiya; 
        $_SESSION['gid_iijs'] = $gid_iijs; 
        $_SESSION['gid_signature'] = $gid_signature; 
        $_SESSION['gid_tritiya'] = $gid_tritiya; 
		include 'rz_combo_pay.php';


/*-------------------------------------------Tritiya Data Insert Process end--------------------------------------------------------*/
		// } else { echo 'something wrong'; }
	}
}
$message ='<table width="100%" bgcolor="#fff" style="margin:20px auto; border:2px solid #dddddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
<tr>
<td style="padding:30px;">
<table width="100%" border="0" background="#fff" cellpadding="0" cellspacing="0">
    <tr>
    	<td align="left" valign="top"><a href="https://www.gjepc.org"><img src="https://gjepc.org/images/gjepc_logon.png"/></a></td>
		<td align="right" valign="top"><a href="https://www.iijs.org"><img src="https://iijs.org/images/IIJS2018Logo.png" width="23%"/></a></td>
    	<td align="right"><a href="https://www.iijs-signature.org"><img src="https://iijs-signature.org/images/logo.png"  /></a></td>
    </tr>    
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>    
    <tr><td colspan="2" height="1px" bgcolor="#333333"></td></tr>    
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>    
	<tr>
    	<td colspan="2" valign="top" style="font-size:13px;">
		<p><strong>Company Name :</strong> '.$_SESSION['COMPANYNAME'].'</p>
    	<p><strong>Dear '.$getgeneralInfo['contact_person'].',</strong> </p>
    	<p>Thank you for applying Online for IIJS Signature & IIJS Premiere Exhibitor Registration. Please note your application is under approval process.</p>        	
    	</td>
    </tr>    
    <tr><td colspan="2">&nbsp;</td></tr>    
    <tr>    
    	<td style="padding-right:10px;">			
            <table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; margin-bottom:15px;">
    			<tr><td colspan="2" style="color:#14b3da;"><strong>Application Summary IIJS Premiere</strong></td></tr>
                <tr>
                    <td width="35%"><strong>Application No </strong></td>
                    <td width="65%">'.$gid_iijs.'</td>
                </tr>                
                <tr>
                    <td width="35%"><strong>Last Year Participant </strong></td>
                    <td width="65%">'.$getiijsInfo['last_yr_participant'].'</td>
                </tr>	
				<tr>
					<td><strong>Selected Option</strong></td>
					<td>'.$getiijsInfo['option'].'</td>
				</tr>
				<tr>
					<td><strong>Section</strong></td>
					<td>'.$getiijsInfo['section'].'</td>
				</tr>
				<tr>
					<td><strong>Area</strong></td>
					<td>'.$getiijsInfo['selected_area'].'</td>
				</tr>
				<tr>
					<td valign="top" height="83px"><strong>Premium</strong></td>
					<td valign="top">'.$getiijsInfo['selected_premium_type'].'</td>
				</tr>
				<tr>
					<td valign="top" height="83px"><strong>Scheme</strong></td>
					<td valign="top">'.getSchemeDescription($getiijsInfo['selected_scheme_type'],$conn).'</td>
				</tr>
			</table>

<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; margin-bottom:20px;">
  <tr valign="top">
    <td colspan="2"  style="color:#14b3da;"><strong>Application Payment Summary IIJS Premiere</strong><br /></td>
    </tr>
  <tr valign="top">
    <td width="30%"><strong>Total Space Cost '.$currency.' </strong></td>
    <td width="21%">'.$getiijsInfo['tot_space_cost_rate'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>Selected scheme rate '.$currency.' </strong></td>
    <td>'.$getiijsInfo['selected_scheme_rate'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>Selected premium rate '.$currency.' </strong></td>
    <td>'.$getiijsInfo['selected_premium_rate'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>Sub Total '.$currency.' </strong></td>
    <td>'.$getiijsInfo['sub_total_cost'].'</td>
  </tr>
  <tr valign="top">
    <td valign="top"><strong>Security Deposit (10% on Sub Total) '.$currency.'</strong></td>
    <td valign="top">'.$getiijsInfo['security_deposit'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>GST (18% on Sub Total) '.$currency.' </strong></td>
    <td>'.$getiijsInfo['govt_service_tax'].'<br /></td>
  </tr>
  <tr valign="top">
    <td><strong>Grand Total '.$currency.' </strong></td>
    <td>'.$getiijsInfo['grand_total'].'</td>
  </tr>
</table>
</td>
	<td style="padding-left:10px;">
    <table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; margin-bottom:20px;">
    <tr><td colspan="2" style="color:#14b3da;"><strong>Application Summary IIJS Signature</strong></td> </tr>
    <tr>
        <td width="35%"><strong>Application No </strong></td>
        <td width="65%">'.$gid_signature.'</td>
    </tr>
    <tr>
        <td width="35%"><strong>Last Year Participant </strong></td>
        <td width="65%">'.$getsignatureInfo['last_yr_participant'].'</td>
    </tr>	
	<tr>
        <td><strong>Selected Option</strong></td>
        <td>'.$getsignatureInfo['option'].'</td>
    </tr>
    <tr>
        <td><strong>Section</strong></td>
        <td>'.$getsignatureInfo['section'].'</td>
    </tr>
    <tr>
        <td><strong>Area</strong></td>
        <td>'.$getsignatureInfo['selected_area'].'</td>
    </tr>
    <tr>
        <td valign="top" height="83px"><strong>Premium</strong></td>
        <td valign="top">'.$getsignatureInfo['selected_premium_type'].'</td>
    </tr>
	<tr>
        <td valign="top" height="83px"><strong>Scheme</strong></td>
        <td valign="top">'.getSchemeDescription_signature($getsignatureInfo['selected_scheme_type'],$conn).'</td>
    </tr>
</table>


<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; margin-bottom:20px;">
  <tr valign="top"><td colspan="2"  style="color:#14b3da;"><strong>Application Payment Summary IIJS Signature</strong><br /></td></tr>
  <tr valign="top">
    <td width="30%"><strong>Total Space Cost '.$currency.' </strong></td>
    <td width="21%">'.$getsignatureInfo['tot_space_cost_rate'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>Selected scheme rate '.$currency.' </strong></td>
    <td>'.$getsignatureInfo['selected_scheme_rate'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>Selected premium rate '.$currency.' </strong></td>
    <td>'.$getsignatureInfo['selected_premium_rate'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>Sub Total '.$currency.' </strong></td>
    <td>'.$getsignatureInfo['sub_total_cost'].'</td>
  </tr>
  <tr valign="top">
    <td valign="top"><strong>Security Deposit (10% on Sub Total) '.$currency.'</strong></td>
    <td valign="top">'.$getsignatureInfo['security_deposit'].'</td>
  </tr>
  <tr valign="top">
    <td><strong>GST (18% on Sub Total) '.$currency.' </strong></td>
    <td>'.$getsignatureInfo['govt_service_tax'].'<br /></td>
  </tr>
  <tr valign="top">
    <td><strong>Grand Total '.$currency.' </strong></td>
    <td>'.$getsignatureInfo['grand_total'].'</td>
  </tr>
</table>
</td>	
    </tr>

    <tr>
    <table width="100%" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" border="1" bordercolor="#CCCCCC" style="border-collapse:collapse; margin-bottom:20px;">   
	<tr valign="top">
	<td width="52%"><strong>Mode of Payment</strong></td>
	<td width="48%">RTGS</td>
	</tr>
      
  </table>
  <table width="100%" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" border="1" bordercolor="#CCCCCC" style="border-collapse:collapse; margin-bottom:20px;">
    <tr valign="top">
      <td colspan="2" style="color:#14b3da;"><strong>For Domestic Companies</strong></td>
    </tr>
   <tr valign="top">
  <td width="52%"><strong>Company Name</strong></td>
  <td width="48%">The Gem & Jewellery Export Promotion Council</td>
   </tr>
      <tr valign="top">
  <td width="52%"><strong>Bank</strong></td>
  <td width="48%">Yes Bank Ltd</td>
   </tr>
        <tr valign="top">
  <td width="52%"><strong>Branch</strong></td>
  <td width="48%">Kalanagar, Bandra</td>
   </tr>
        <tr valign="top">
  <td width="52%"><strong>A/c No.</strong></td>
  <td width="48%">026894600001826</td>
   </tr>
        <tr valign="top">
  <td width="52%"><strong>IFSC Code</strong></td>
  <td width="48%">YESB0000268</td>
   </tr>
   <tr valign="top">
  <td width="52%"><strong>Type of Account</strong></td>
  <td width="48%">Saving Account</td>
   </tr>
  </table>
  
</tr>
 <tr>
    <td colspan="2" style="line-height:20px;">

<p align="justify">All the applicant members will have to update the details of advance payment along with UTR number and TDS on the dashboard after successful submission of online space application form in 4 working days from date of online submission. </p>

<p>A system generated notification will be sent to you on successful approval of your application.</p>

<p>Kind Regards,</p>
   
<p><strong>IIJS Signature Web Team,</strong></p>

<p>Important Links : <br />
<a href="#" style="text-decoration:none; color:#14b3da;">Registration Status</a> | <a href="#" style="text-decoration:none; color:#14b3da;">Travel & Hotel</a> | <a href="#" style="text-decoration:none; color:#14b3da;">Show Updates</a> | <a href="#" style="text-decoration:none; color:#14b3da;">Helpdesk</a> | <a href="#" style="text-decoration:none; color:#14b3da;">FAQs</a> | <a href="#" style="text-decoration:none; color:#14b3da;">OBMP</a>
</p>
</td>
</tr>
</table>

</td>
</tr>

</table>';
	

}
}
	
} 

} else {
	header("location:my_dashboard.php"); exit;
	}	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Exhibitor Registration - Payment Details</title>
<link rel="shortcut icon" href="images/fav.png" />
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="css/general.css" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/visitor_reg.css" />
<link rel="stylesheet" type="text/css" href="css/responsive.css" />
<link rel="stylesheet" type="text/css" href="css/media_query.css" />
<link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
<!-- UItoTop plugin -->
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css" />
<style>.content_form_area{max-width:700px}.right-content li{font-size:12px;line-height:23px;}.right-content{margin:35px 0;
border:1px solid#ccc;padding:7px}</style>
<script src="js/easing.js" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js" type="text/javascript"></script>    

<!--NAV-->
<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.flexnav.js" type="text/javascript"></script>
<script src="js/common.js"></script> 
<!--NAV-->

<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="css/rcmc.validation.css" />
<script type="text/javascript">
$(window).ready(function(){

	jQuery.validator.addMethod("lettersonly", function(value, element) 
	{
	return this.optional(element) || /^[a-z ]+$/i.test(value);
	}, "Letters and spaces only please");

	$("#step_4_combo").validate({
		rules: {
			amount_payable: {
			required: true		
			},
			signature_amount_payable: {
			required: true		
			},
			net_payable_amount: {
			required: true			
			},
			signature_net_payable_amount: {
			required: true			
			},
			tds_holder: {
			required: true			
			},
			signature_tds_holder: {
			required: true			
			},
			bank_acc_no:{
            required: true
			},
			bank_name:{
		    required: true
			},
			ifsc_code:{
            required: true
			},
			branch_name:{
            required: true
			},
			int_acc_type:{
			required: true	
			},
		},
		messages: {
			amount_payable: {
				required: "Please Select amount payable",				
			},
			signature_amount_payable: {
				required: "Please Select amount payable",				
			},
			net_payable_amount: {
				required: "Gross amount is required",
			},
			signature_net_payable_amount: {
				required: "Gross amount is required",
			},
			tds_holder: {
				required: "Please select tds deducted`",
			},
			signature_tds_holder: {
				required: "Please select tds deducted`",
			},
			bank_acc_no:{
				required: "Bank A/c no is required",
			},
			bank_name:{
		    required: "Bank name no is required",
			},
			ifsc_code:{
            required: "Bank IFSC code is required",
			},
			branch_name:{
            required: "Bank branch name is required",
			},
			int_acc_type:{
			required: "Please select account type",
			}			
	 }
	});
});
</script>
<script type="text/javascript">
    $(function () {
    	/*------------------------------------------IIJS Code start-----------------------------------*/

		$("#amount_payable").on('change',function(){
			var amount_payable=$('#amount_payable').val();
			var gross_total=$('#grand_total').val()*amount_payable/100;
			$("#net_payable_amount").val(gross_total);
		});
		
        $("input[name='tds_holder']").click(function () {
            if ($("#chkYes").is(":checked")) {
                $("#holder_star").show();
            } else {
                $("#holder_star").hide();
            }
        });
    	/*---------------------------------------------IIJS Code end--------------------------------------*/
    	/*================================================================================================*/
    	/*-------------------------------------------SIGNATURE Code Start---------------------------------*/

        $("#signature_amount_payable").on('change',function(){
			var signature_amount_payable=$('#signature_amount_payable').val();
			var signature_gross_total=$('#signature_grand_total').val()*signature_amount_payable/100;
			$("#signature_net_payable_amount").val(signature_gross_total);
		});

         $("input[name='signature_tds_holder']").click(function () {
            if ($("#signature_chkYes").is(":checked")) {
                $("#signature_holder_star").show();
            } else {
                $("#signature_holder_star").hide();
            }
        });
    	/*----------------------------------------------SIGNATURE Code end--------------------------------*/

    	/*-------------------------------------------TRITIYA Code Start---------------------------------*/

        $("#tritiya_amount_payable").on('change',function(){
			var tritiya_amount_payable=$('#tritiya_amount_payable').val();
		
			var tritiya_gross_total=$('#tritiya_grand_total').val()*tritiya_amount_payable/100;
			$("#tritiya_net_payable_amount").val(tritiya_gross_total);
		});

         $("input[name='tritiya_tds_holder']").click(function () {
            if ($("#tritiya_chkYes").is(":checked")) {
                $("#tritiya_holder_star").show();
            } else {
                $("#tritiya_holder_star").hide();
            }
        });
    	/*----------------------------------------------TRITIYA Code end--------------------------------*/

    });
</script>

<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '398834417477910');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=398834417477910&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

</head>

<body>

<div class="wrapper">
<div class="header">
	<?php include('header1.php'); ?>
</div>

<div class="inner_container">

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
		?>          
    	<div class="clear"></div>
  
    <div class="clear"></div>
	</div>	      
    <div class="clear"></div>    
    
    <div class="wrap">
		<div class="row mb-4">
			<div class="col-12 col-md-4 border pt-3">
				<h1 class="form-title ">IIJS Premiere 2022</h1>
				<div class="summary_box">
		        <p><strong style="text-transform:uppercase; font-size:14px;">Application Summary(Exh<?php //echo $result['gid'];?>)</strong></p>
		        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
		        <p><strong>Last Year Participant :</strong>&nbsp;<?php echo $getiijsInfo['last_yr_participant'];?></p>
		        <p><strong>Option :</strong>&nbsp; <?php echo $getiijsInfo['option'];?> </p>
		        <p><strong>Section :</strong>&nbsp; <?php echo $getiijsInfo['section'];?> </p>
		        <p><strong>Area :</strong>&nbsp; <?php echo $getiijsInfo['selected_area'];?> &nbsp;sqrt</p>
		        <p><strong>Scheme :</strong>&nbsp; <?php echo getSchemeDescription($getiijsInfo['selected_scheme_type'],$conn);?> </p>
		        <p><strong>Premium :</strong>&nbsp; <?php echo $getiijsInfo['selected_premium_type'];?></p>
		        </div>
			    <div class="summary_box">
		        <p><strong style="text-transform:uppercase; font-size:14px;"> Payment Summary</strong> </p>
		       	<p> <span class="clear" style="height:1px; background:#ccc; display:block;"></span></p>
		       	<p> <strong>Space Cost <?php echo $currency;?> :</strong>&nbsp;<?php echo $getiijsInfo['tot_space_cost_rate'];?> </p>
		       	<p> <strong>Space Cost Discount<?php echo $currency;?> :</strong>&nbsp;<?php echo $getiijsInfo['tot_space_cost_discount'];?> </p>
		       	<p> <strong>After Discount Space Cost<?php echo $currency;?> :</strong>&nbsp;<?php echo $getiijsInfo['get_tot_space_cost_rate'];?> </p>
		       	<p> <strong>Selected scheme rate <?php echo $currency;?> :</strong>&nbsp;<?php echo $getiijsInfo['selected_scheme_rate'];?> </p>
		       	<p> <strong>Selected premium rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $getiijsInfo['selected_premium_rate'];?></p>
		       	<p> <strong>Sub Total <?php echo $currency;?> :</strong>&nbsp;<?php echo $getiijsInfo['sub_total_cost'];?> </p>
		       	<p> <strong>Security Deposit (10% on Sub Total) <?php echo $currency;?> :</strong>&nbsp;<?php echo $getiijsInfo['security_deposit'];?> </p>
		       	<p> <strong>GST (18% on Sub Total) <?php echo $currency;?> :</strong>&nbsp;<?php echo $getiijsInfo['govt_service_tax'];?></p>
		       	<p> <strong>Grand Total <?php echo $currency;?> :</strong>&nbsp; <?php echo $getiijsInfo['grand_total'];?></p>
		        </div>
		        
		        <div class="summary_box">

				</div>  
			</div>
			<div class="col-12 col-md-4 border pt-3">
				<h1 class="form-title">IIJS Signature 2023</h1>
				<div class="summary_box">
		        <p><strong style="text-transform:uppercase; font-size:14px;">Application Summary(Exh<?php //echo $result['gid'];?>)</strong><br />
		        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
		        <strong>Last Year Participant :</strong>&nbsp;<?php echo $getsignatureInfo['last_yr_participant'];?><br />
		        <strong>Option :</strong>&nbsp; <?php echo $getsignatureInfo['option'];?> <br />
		        <strong>Section :</strong>&nbsp; <?php echo $getsignatureInfo['section'];?> <br />
		        <strong>Category :</strong>&nbsp; <?php echo $getsignatureInfo['category'];?> <br />
		        <strong>Area :</strong>&nbsp; <?php echo $getsignatureInfo['selected_area'];?> &nbsp;sqrt<br />
		        <strong>Scheme :</strong>&nbsp; <?php echo getSchemeDescription_signature($getsignatureInfo['selected_scheme_type'],$conn);?> <br />
		        <strong>Premium :</strong>&nbsp; <?php echo $getsignatureInfo['selected_premium_type'];?></p>
		        
		        </p>
		        </div>
			    <div class="summary_box">
			    	<p><strong style="text-transform:uppercase; font-size:14px;"> Payment Summary</strong> <br />
		        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
		        <strong>Space Cost <?php echo $currency;?> :</strong>&nbsp;  <?php echo $getsignatureInfo['tot_space_cost_rate'];?> <br />
		        <strong>Space Cost Discount<?php echo $currency;?> :</strong>&nbsp;  <?php echo $getsignatureInfo['tot_space_cost_discount'];?> <br />
		        <strong>After Discount Space Cost<?php echo $currency;?> :</strong>&nbsp;  <?php echo $getsignatureInfo['get_tot_space_cost_rate'];?> <br />
		        <strong>Category Cost <?php echo $currency;?> :</strong>&nbsp;  <?php echo $getsignatureInfo['get_category_rate'];?> <br />
		        <strong>Selected scheme rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $getsignatureInfo['selected_scheme_rate'];?><br />
		        <strong>Selected premium rate <?php echo $currency;?> :</strong>&nbsp;  <?php echo $getsignatureInfo['selected_premium_rate'];?> <br />
		        <strong>Sub Total <?php echo $currency;?> :</strong>&nbsp;  <?php echo $getsignatureInfo['sub_total_cost'];?> <br />
		        <strong>Security Deposit (10% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo $getsignatureInfo['security_deposit'];?> <br />
		        <strong>GST (18% on Sub Total) <?php echo $currency;?> :</strong>&nbsp;  <?php echo $getsignatureInfo['govt_service_tax'];?><br />
		        <strong>Grand Total <?php echo $currency;?> :</strong>&nbsp;  <?php echo $getsignatureInfo['grand_total'];?>
		        </div>
			</div>
			<div class="col-12 col-md-4 border pt-3">
				<h1 class="form-title">IIJS Tritiya 2023</h1>
				<div class="summary_box">
			        <p><strong style="text-transform:uppercase; font-size:14px;">Application Summary(Exh<?php //echo $result['gid'];?>)</strong><br />
			        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
			        <strong>Last Year Participant :</strong>&nbsp;<?php echo $getTritiyaInfo['last_yr_participant'];?><br />
			  <!--       <strong>Option :</strong>&nbsp; <?php //echo $getTritiyaInfo['option'];?> <br /> -->
			        <strong>Section :</strong>&nbsp; <?php echo $getTritiyaInfo['section'];?> <br />
			       <!--  <strong>Category :</strong>&nbsp; <?php //echo $getTritiyaInfo['category'];?> <br /> -->
			        <strong>Area :</strong>&nbsp; <?php echo $getTritiyaInfo['selected_area'];?> &nbsp;sqrt<br />
	<!-- 		        <strong>Scheme :</strong>&nbsp; <?php // echo getSchemeDescription_signature($getTritiyaInfo['selected_scheme_type'],$conn);?> <br /> -->
			       <!--  <strong>Premium :</strong>&nbsp; <?php // echo $getTritiyaInfo['selected_premium_type'];?></p> -->
			       
		    	</div>
			    <div class="summary_box">
			    	<p><strong style="text-transform:uppercase; font-size:14px;"> Payment Summary</strong> <br /></p>
			        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
			        <!-- <strong>Space Cost <?php echo $currency;?> :</strong>&nbsp;  <?php echo $getTritiyaInfo['tot_space_cost_rate'];?> <br /> -->
			     <!--    <strong>Space Cost Discount<?php echo $currency;?> :</strong>&nbsp;  <?php echo $getTritiyaInfo['tot_space_cost_discount'];?> <br /> -->
			       <!--  <strong>After Discount Space Cost<?php echo $currency;?> :</strong>&nbsp;  <?php echo $getTritiyaInfo['get_tot_space_cost_rate'];?> <br /> -->
			    <!--     <strong>Category Cost <?php echo $currency;?> :</strong>&nbsp;  <?php echo $getTritiyaInfo['get_category_rate'];?> <br /> -->
			      <!--   <strong>Selected scheme rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $getTritiyaInfo['selected_scheme_rate'];?><br />
			        <strong>Selected premium rate <?php echo $currency;?> :</strong>&nbsp;  <?php echo $getTritiyaInfo['selected_premium_rate'];?> <br /> -->
			        <strong>Sub Total <?php echo $currency;?> :</strong>&nbsp;  <?php echo $getTritiyaInfo['sub_total_cost'];?> <br />
			        <strong>Security Deposit (10% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo $getTritiyaInfo['security_deposit'];?> <br />
			        <strong>GST (18% on Sub Total) <?php echo $currency;?> :</strong>&nbsp;  <?php echo $getTritiyaInfo['govt_service_tax'];?><br />
			        <strong>Grand Total <?php echo $currency;?> :</strong>&nbsp;  <?php echo $getTritiyaInfo['grand_total']; ?>
			    </div>
				</div>
		</div>
		


		<div class="clear"></div>
		<p style="text-align: center;"><strong><span style="color: red; text-align: center;">All the applicants will have to update UTR No. and TDS Details on Dashboard after submitting space application form.</span></strong></p>
 <div class="clear" style="height:10px;"></div>
 
<form action="" method="post" id="step_4_combo">
          <div class="row">
          	<div class="col-12 col-md-4">
          		<div style="margin-bottom:10px; font-size:14px;"><strong>Payment Details</strong><span class="clear" style="height:1px; background:#ccc; display:block; margin-top:8px;"></span></div> 
		<input type="hidden" name="grand_total" id="grand_total" value="<?php echo round($getiijsInfo['grand_total']);?>"/>
		<input type="hidden" name="exh_id" id="exh_id" value="<?php echo $getiijsInfo['exh_id'];?>"/>
        <span id="wa_machinery_error" class="error_mg"></span>
		
		<div class="field_box">
        <div class="field_name">Amount Payable <span>*</span>:</div>
        <div class="field_input">
			<select class="textField" name="amount_payable" id="amount_payable"/>
				 <option value=""> Select Payable Amount  </option>
				 <option <?php if($amount_payable =="10"){echo "selected";}?> value="10">10%</option>				 
			</select>
        <br><label class="error" id="amount_payable_error"></label>
        <?php if(isset($amount_payable_error)){ echo "<span style='color: red;'>".$amount_payable_error.'</span>';} ?>
		</div>
        <div class="clear"></div>
        </div>
        <!-- <p style="text-align: center; line-height:10px; margin-bottom:10px;">* Advance provided for IIJS Premiere 2020 is not refundable</p> -->
		
		<div class="field_box">
        <div class="field_name">Gross Amount <span>*</span>:</div>
        <div class="field_input">
			<input name="net_payable_amount" id="net_payable_amount" type="text" class="bgcolor" 
			 readonly value="<?php echo $net_payable_amount;?>" />
            <br><label class="error" id="cheque_tds_gross_amount_error"></label> 
            <?php if(isset($net_payable_amount_error)){ echo "<span style='color: red;'>".$net_payable_amount_error.'</span>';} ?>
		</div>
        <div class="clear"></div>
        </div>
				
		<?php if(strtoupper($getiijsInfo['last_yr_participant'])=="YES"){ ?>
		<div class="field_box">
        <div class="field_name"><strong>TDS Deducted</strong></div>
        <div class="field_input">
		<label>Yes</label> <input type="radio" id="chkYes" value="Yes" name="tds_holder" <?php if($tds_holder == "Yes"){echo "checked";}?> />
		<label>No</label> <input type="radio" id="chkNo" value="No" name="tds_holder" <?php if($tds_holder == "No"){echo "checked";}?>  /></label>
		</div>
        <label for="tds_holder" generated="true" class="error" style="display: inline-block;"></label>
        <?php if(isset($tds_holder_error)){ echo "<span style='color: red;display: inline-block;'>".$tds_holder_error.'</span>';} ?>
        <div class="clear"></div>
        </div>
		
		<div class="field_box" id="holder_star">
			<div class="field_box">
				<div class="field_name">TDS Percentage @2 % or 10%<span>*</span> : </div>
				<div class="field_input">
				<select class="textField" name="cheque_tds_per" id="cheque_tds_per">
				<option value="">--Select TDS percentage--</option>
			     <option <?php if($cheque_tds_per =="2"){echo "selected";}?> value="2" >2 %</option>
				 <option <?php if($cheque_tds_per =="10"){echo "selected";}?> value="10" >10 %</option>
				</select>				
                <br><label class="error" id="cheque_tds_per_error"></label>
                 <?php if(isset($cheque_tds_per_error)){ echo "<span style='color: red;'>".$cheque_tds_per_error.'</span>';} ?>
				</div>			
                <div class="clear"></div>
            </div>
            <div class="field_box">
                <div class="field_name">TDS Amount <span>*</span> :</div> 
				<div class="field_input"> 
				<input name="cheque_tds_amount" type="text" id="cheque_tds_amount" class="textField"  autocomplete="off" value="<?php echo 
				$cheque_tds_amount;?>" />
                <br><label class="error" id="cheque_tds_amount_error"></label>
                 <?php if(isset($cheque_tds_amount_error)){ echo "<span style='color: red;'>".$cheque_tds_amount_error.'</span>';} ?>

				</div>
                <div class="clear"></div>
            </div>
			<div class="field_box">
                <div class="field_name">Net Amount<span>*</span> :</div>
                <div class="field_input">
				<input name="cheque_tds_Netamount" type="text" id="cheque_tds_Netamount" class="textField" autocomplete="off"  value="<?php echo 
				$cheque_tds_Netamount;?>"/>
                <br><label class="error" id="cheque_tds_Netamount_error"></label>
                 <?php if(isset($cheque_tds_Netamount_error)){ echo "<span style='color: red;'>".$cheque_tds_Netamount_error.'</span>';} ?>

				</div>
                <div class="clear"></div>
            </div>			
		</div>
		<?php } ?>
        <div class="field_box">
        <div class="field_name">Mode of Payment <span>*</span>:</div>
        <div class="field_input">
        <select class="textField" name="payment_mode" id="payment_mode">
		<?php
		if($int_type=="N")
		{	
			$option.='<option value="RTGS"'; if($payment_mode=="RTGS")$option.= 'selected'; $option.='>RTGS</option>'; echo $option;
		} else {
			$option='';	$option.='<option value="Wire Transfer"'; if($payment_mode=="Wire Transfer") $option.= 'selected'; $option.='>Wire Transfer</option>';
				echo $option;
		}
		?>            
        </select>
		<br><label class="error" id="payment_mode_error"></label>
        <?php if(isset($payment_mode_error)){ echo "<span style='color: red;'>".$payment_mode_error.'</span>';} ?>

		</div>
        <div class="clear"></div>
        </div>
          	</div>
          	<div class="col-12 col-md-4">
          		<div style="margin-bottom:10px; font-size:14px;"><strong>Payment Details</strong><span class="clear" style="height:1px; background:#ccc; display:block; margin-top:8px;"></span></div> 
		<input type="hidden" name="signature_grand_total" id="signature_grand_total" value="<?php echo round($getsignatureInfo['grand_total']);?>"/>
		<input type="hidden" name="signature_exh_id" id="signature_exh_id" value="<?php echo $getsignatureInfo['exh_id'];?>"/>
        <span id="wa_machinery_error" class="error_mg"></span>
		
		<div class="field_box">
        <div class="field_name">Amount Payable <span>*</span>:</div>
        <div class="field_input">
			<select class="textField" name="signature_amount_payable" id="signature_amount_payable"/>
				 <option value=""> Select Payable Amount  </option>
				 <?php if(strtoupper($getsignatureInfo['last_yr_participant'])=="NO"){ ?>
				 <option <?php if($signature_amount_payable =="50"){echo "selected";}?> value="50">50%</option>
				 <?php } else { ?>
				 <option <?php if($signature_amount_payable =="50"){echo "selected";}?> value="50">50%</option>
				 <option <?php if($signature_amount_payable =="100"){echo "selected";}?> value="100">100%</option>
				 <?php } ?>
			</select>
        <br><label class="error" id="signature_amount_payable_error"></label>
                 <?php if(isset($signature_amount_payable_error)){ echo "<span style='color: red;'>".$signature_amount_payable_error.'</span>';} ?>

		</div>
        <div class="clear"></div>
        </div>
		
		<div class="field_box">
        <div class="field_name">Gross Amount <span>*</span>:</div>
        <div class="field_input">
		<input name="signature_net_payable_amount" id="signature_net_payable_amount" type="text" value="<?php echo $signature_net_payable_amount;?>" class="bgcolor" readonly/>
        <br><label class="error" id="signature_cheque_tds_gross_amount_error"></label> 
                 <?php if(isset($signature_cheque_tds_gross_amount_error)){ echo "<span style='color: red;'>".$signature_cheque_tds_gross_amount_error.'</span>';} ?>

		</div>
        <div class="clear"></div>
        </div>
				
		<?php if(strtoupper($getsignatureInfo['last_yr_participant']) =="YES"){ ?>
		<div class="field_box">
        <div class="field_name"><strong>TDS Deducted</strong></div>
        <div class="field_input">
		Yes <input type="radio" id="tritiya_chkYes" value="Yes" name="tritiya_tds_holder" <?php if($tritiya_tds_holder="Yes"){echo "checked";}?> />
		No <input type="radio" id="tritiya_chkNo" value="No" name="tritiya_tds_holder"  <?php if($tritiya_tds_holder="No"){echo "checked";}?>/></label>
		</div>
		<label for="tritiya_tds_holder" generated="true" class="error" style="display: inline-block;"></label>
         <?php if(isset($tritiya_tds_holder_error)){ echo "<span style='color: red;display: inline-block;'>".$tritiya_tds_holder_error.'</span>';} ?>
        <div class="clear"></div>
        </div>		
		
		<div class="field_box" id="tritiya_holder_star" >	
            
			<div class="field_box">
				<div class="field_name">TDS Percentage @2 % or 10%<span>*</span> : </div>
				<div class="field_input">
				<select class="textField" name="tritiya_cheque_tds_per" id="tritiya_cheque_tds_per">
				<option  value="">--Select TDS percentage--</option>
			     <option <?php if($tritiya_cheque_tds_per =="2"){echo "selected";}?> value="2">2 %</option>
				 <option <?php if($tritiya_cheque_tds_per =="10"){echo "selected";}?> value="10">10 %</option>
				</select>				
                <br><label class="error" id="tritiya_cheque_tds_per_error"></label>
                 <?php if(isset($tritiya_cheque_tds_per_error)){ echo "<span style='color: red;'>".$tritiya_cheque_tds_per_error.'</span>';} ?>

				</div>			
                <div class="clear"></div>
            </div>
            <div class="field_box">
                <div class="field_name">TDS Amount <span>*</span> :</div> 
				<div class="field_input"> 
				<input name="tritiya_cheque_tds_amount" type="text" id="tritiya_cheque_tds_amount" class="textField" value="<?php echo $tritiya_cheque_tds_amount;?>" autocomplete="off"/>
                <br><label class="error" id="tritiya_cheque_tds_amount_error"></label>
                 <?php if(isset($tritiya_cheque_tds_amount_error)){ echo "<span style='color: red;'>".$tritiya_cheque_tds_amount_error.'</span>';} ?>

				</div>
                <div class="clear"></div>
            </div>
			<div class="field_box">
                <div class="field_name">Net Amount<span>*</span> :</div>
                <div class="field_input">
				<input name="tritiya_cheque_tds_Netamount" value="<?php echo $tritiya_cheque_tds_Netamount;?>" type="text" id="tritiya_cheque_tds_Netamount" class="textField" />
                <br><label class="error" id="tritiya_cheque_tds_Netamount_error"></label>
                 <?php if(isset($tritiya_cheque_tds_Netamount_error)){ echo "<span style='color: red;'>".$tritiya_cheque_tds_Netamount_error.'</span>';} ?>

				</div>
                <div class="clear"></div>
            </div>			
		</div>
		<?php } ?>
		
        <div class="field_box">
        <div class="field_name">Mode of Payment <span>*</span>:</div>
        <div class="field_input">
        <select class="textField" name="signature_payment_mode" id="signature_payment_mode">
		<?php
		if($int_type=="N")
		{	
			$option.='<option value="RTGS"'; if($payment_mode=="RTGS")$option.= 'selected'; $option.='>RTGS</option>'; echo $option;
		} else {
			$option='';	$option.='<option value="Wire Transfer"'; if($payment_mode=="Wire Transfer") $option.= 'selected'; $option.='>Wire Transfer</option>';
				echo $option;
		}
		?>            
        </select>
		<br><label class="error" id="signature_payment_mode_error"></label>
                 <?php if(isset($signature_payment_mode_error)){ echo "<span style='color: red;'>".$signature_payment_mode_error.'</span>';} ?>

		</div>
        <div class="clear"></div>
        </div>
          	</div>
          	<div class="col-12 col-md-4">
          		<div style="margin-bottom:10px; font-size:14px;"><strong>Payment Details</strong><span class="clear" style="height:1px; background:#ccc; display:block; margin-top:8px;"></span></div> 
		<input type="hidden" name="tritiya_grand_total" id="tritiya_grand_total" value="<?php echo round($getTritiyaInfo['grand_total']);?>"/>
		<input type="hidden" name="tritiya_exh_id" id="tritiya_exh_id" value="<?php echo $getsignatureInfo['exh_id'];?>"/>
        <span id="wa_machinery_error" class="error_mg"></span>
		
		<div class="field_box">
        <div class="field_name">Amount Payable <span>*</span>:</div>
        <div class="field_input">
			<select class="textField" name="tritiya_amount_payable" id="tritiya_amount_payable"/>
				 <option value=""> Select Payable Amount  </option>
				 <?php if(strtoupper($getsignatureInfo['last_yr_participant'])=="NO"){ ?>
				 <option <?php if($tritiya_amount_payable =="50"){echo "selected";}?> value="50">50%</option>
				 <?php } else { ?>
				 <option <?php if($tritiya_amount_payable =="50"){echo "selected";}?> value="50">50%</option>
				 <option <?php if($tritiya_amount_payable =="100"){echo "selected";}?> value="100">100%</option>
				 <?php } ?>
			</select>
        <br><label class="error" id="tritiya_amount_payable_error"></label>
                 <?php if(isset($tritiya_amount_payable_error)){ echo "<span style='color: red;'>".$tritiya_amount_payable_error.'</span>';} ?>

		</div>
        <div class="clear"></div>
        </div>
		
		<div class="field_box">
        <div class="field_name">Gross Amount <span>*</span>:</div>
        <div class="field_input">
		<input name="tritiya_net_payable_amount" id="tritiya_net_payable_amount" type="text" value="<?php echo $tritiya_net_payable_amount;?>" class="bgcolor" readonly/>
        <br><label class="error" id="tritiya_cheque_tds_gross_amount_error"></label> 
                 <?php if(isset($tritiya_cheque_tds_gross_amount_error)){ echo "<span style='color: red;'>".$tritiya_cheque_tds_gross_amount_error.'</span>';} ?>

		</div>
        <div class="clear"></div>
        </div>
				
		<?php if(strtoupper($getTritiyaInfo['last_yr_participant']) =="YES"){ ?>
		<div class="field_box">
        <div class="field_name"><strong>TDS Deducted</strong></div>
        <div class="field_input">
		Yes <input type="radio" id="tritiya_chkYes" value="Yes" name="tritiya_tds_holder" <?php if($tritiya_tds_holder="Yes"){echo "checked";}?> />
		No <input type="radio" id="tritiya_chkNo" value="No" name="tritiya_tds_holder"  <?php if($tritiya_tds_holder="No"){echo "checked";}?>/></label>
		</div>
		<label for="tritiya_tds_holder" generated="true" class="error" style="display: inline-block;"></label>
         <?php if(isset($tritiya_tds_holder_error)){ echo "<span style='color: red;display: inline-block;'>".$tritiya_tds_holder_error.'</span>';} ?>
        <div class="clear"></div>
        </div>		
		
		<div class="field_box" id="tritiya_holder_star" >	
            
			<div class="field_box">
				<div class="field_name">TDS Percentage @2 % or 10%<span>*</span> : </div>
				<div class="field_input">
				<select class="textField" name="tritiya_cheque_tds_per" id="tritiya_cheque_tds_per">
				<option  value="">--Select TDS percentage--</option>
			     <option <?php if($tritiya_cheque_tds_per =="2"){echo "selected";}?> value="2">2 %</option>
				 <option <?php if($tritiya_cheque_tds_per =="10"){echo "selected";}?> value="10">10 %</option>
				</select>				
                <br><label class="error" id="tritiya_cheque_tds_per_error"></label>
                 <?php if(isset($tritiya_cheque_tds_per_error)){ echo "<span style='color: red;'>".$tritiya_cheque_tds_per_error.'</span>';} ?>

				</div>			
                <div class="clear"></div>
            </div>
            <div class="field_box">
                <div class="field_name">TDS Amount <span>*</span> :</div> 
				<div class="field_input"> 
				<input name="tritiya_cheque_tds_amount" type="text" id="tritiya_cheque_tds_amount" class="textField" value="<?php echo $tritiya_cheque_tds_amount;?>" autocomplete="off"/>
                <br><label class="error" id="tritiya_cheque_tds_amount_error"></label>
                 <?php if(isset($tritiya_cheque_tds_amount_error)){ echo "<span style='color: red;'>".$tritiya_cheque_tds_amount_error.'</span>';} ?>

				</div>
                <div class="clear"></div>
            </div>
			<div class="field_box">
                <div class="field_name">Net Amount<span>*</span> :</div>
                <div class="field_input">
				<input name="tritiya_cheque_tds_Netamount" value="<?php echo $tritiya_cheque_tds_Netamount;?>" type="text" id="tritiya_cheque_tds_Netamount" class="textField" />
                <br><label class="error" id="tritiya_cheque_tds_Netamount_error"></label>
                 <?php if(isset($tritiya_cheque_tds_Netamount_error)){ echo "<span style='color: red;'>".$tritiya_cheque_tds_Netamount_error.'</span>';} ?>

				</div>
                <div class="clear"></div>
            </div>			
		</div>
		<?php } ?>
		
        <div class="field_box">
        <div class="field_name">Mode of Payment <span>*</span>:</div>
        <div class="field_input">
        <select class="textField" name="tritiya_payment_mode" id="tritiya_payment_mode">
		<?php
		if($int_type=="N")
		{	
			$option.='<option value="RTGS"'; if($payment_mode=="RTGS")$option.= 'selected'; $option.='>RTGS</option>'; echo $option;
		} else {
			$option='';	$option.='<option value="Wire Transfer"'; if($payment_mode=="Wire Transfer") $option.= 'selected'; $option.='>Wire Transfer</option>';
				echo $option;
		}
		?>            
        </select>
		<br><label class="error" id="tritiya_payment_mode_error"></label>
                 <?php if(isset($tritiya_payment_mode_error)){ echo "<span style='color: red;'>".$tritiya_payment_mode_error.'</span>';} ?>

		</div>
        <div class="clear"></div>
        </div>
          	</div>
          </div>
		

		<div class="clear"></div>
			
    	<!-- RTGS description -->
        <div id="rtgs_desc" style="margin-bottom:10px;font-size:12px;">
        <p><strong>Please note the RTGS instructions for participation cost payment.</strong> </p>
        <section class="float-l">
        <strong>BENIFICIARY NAME : </strong> THE GEM & JEWELLERY EXPORT PROMOTION COUNCIL.<br/>
		<strong>ACCOUNT NO. : </strong>	026894600001826<br/>
		<strong>BANK NAME : </strong>	Yes Bank Ltd<br/>
        </section>
        <section class="float-r">
        <strong>BRANCH CODE : </strong>	Kalanagar, Bandra<br/>
		<strong>RTGS/NEFT IFS Code : </strong> YESB0000268<br/>
		<strong>Type of Account:</strong> Saving Account – Trust<br/>
        </section>
        <div class="clear"></div>
		
		
<p>All the applicant members will have to update the details of advance payment along with UTR number and TDS on the dashboard after successful submission of online space application form in 4 working days from date of online submission.
A system generated notification will be sent to you on successful approval of your application</p>
        <span class="clear" style="height:1px; background:#ccc; display:block; margin-top:8px;"></span>
    </div>
        <!-- RTGS description end -->
        <div class="clear" style="height:10px;"></div>
    
        <div style="margin-bottom:10px; font-size:14px;"><strong>RTGS / Bank details for Refund</strong><span class="clear" style="height:1px; background:#ccc;margin-top:8px;"></span></div>            
        
		<section class="float-l border-r">
		<div class="field_box">
        <div class="field_name">Bank A/c No. <span>*</span> :</div>
        <div class="field_input">
		<input type="text" name="bank_acc_no" id="bank_acc_no" class="bgcolor" value="<?php echo $bank_acc_no;?>" />
          <br>
          <?php if(isset($bank_acc_no_error)){ echo "<span style='color: red;'>".$bank_acc_no_error.'</span>';} ?>
		
		</div> <div class="clear"></div>
        </div>
        
        <div class="field_box">
        <div class="field_name">Name of Bank <span>*</span> :</div>
        <div class="field_input">
		<input type="text" name="bank_name" id="bank_name" class="bgcolor" value="<?php echo $name_bank;?>"   />
		<br>
          <?php if(isset($name_bank_error)){ echo "<span style='color: red;'>".$name_bank_error.'</span>';} ?>

		</div> <div class="clear"></div>
        </div>
                
        <div class="field_box">
        <div class="field_name">Type of Account <span>*</span> :</div>
        <div class="field_input">
            <select class="bgcolor" name="int_acc_type" id="int_acc_type" value="<?php echo $int_acc_type;?>" >
            <option  value="">--- Please Select Account Type ---</option>
            <option <?php if($int_acc_type == "Saving"){echo "selected";}?> value="Saving">Saving</option>
            <option <?php if($int_acc_type == "Current"){echo "selected";}?> value="Current">Current</option>
            </select>
            <br>
          <?php if(isset($int_acc_type_error)){ echo "<span style='color: red;'>".$int_acc_type_error.'</span>';} ?>

        </div>  <div class="clear"></div>
        </div>     
		</section>

		<section class="float-r">		
        <div class="field_box">
        <div class="field_name">IFSC Code <span>*</span> :</div>
        <div class="field_input"><input type="text" name="ifsc_code" id="ifsc_code" class="bgcolor" value="<?php echo $ifsc_code;?>"   /><br>
          <?php if(isset($ifsc_code_error)){ echo "<span style='color: red;'>".$ifsc_code_error.'</span>';} ?>
        </div>
        <div class="clear"></div>
        </div>
      
		<div class="field_box">
        <div class="field_name">Name of Branch <span>*</span> :</div>
        <div class="field_input">
		<input type="text" name="branch_name" id="branch_name" class="bgcolor" value="<?php echo $name_bank_branch;?>"/>
		<br>
          <?php if(isset($name_bank_branch)){ echo "<span style='color: red;'>".$name_bank_branch_error.'</span>';} ?>

		</div> <div class="clear"></div>
        </div>        
    	<div class="clear" style="height:20px;"></div>
		</section>
		<div class="clear"></div>
    	<!-- RTGS description -->
       
        <!-- RTGS description end -->
        <div class="clear" style="height:10px;"></div>
        <div class="field_box">
        <div class="field_name"></div>
        <input type="hidden" name="action" value="Save">
        <div class="field_input"><input type="submit" class="button" value="submit" name="submit" /> </div>
        <div class="clear"></div>
        </div>

    </div>
	</div>
</form>
	
<div class="clear" style="height:10px;"></div>
</div>

<div class="footer"><?php include('footer.php'); ?><div class="clear"></div>
</div>

<div class="clear"></div>
</div>

<style>
.inner_container {width:80%;}
.content_form_area {width:100%; max-width:inherit;}
.right_area {width:28%; float:right;}
.form-title {padding-left:3%; border-left:3px solid #ef4e22; font-size:16px; color:#ef4e22;}
.form_main {width:70%; margin:0; float:left;}
.right-content {margin-top:0;}

.wrap section {width:48%; }
.float-r{float: right;}
.float-l{float: left; }
.border-r{position: relative;}
.border-r:after{content: "";position: absolute;height: 100%;width: 1px; border-right: 1px dotted#ccc; right: -20px;top: 0}

input[type=radio]{ display: inline-block!Important; }

#rtgs_desc  {line-height:22px;}

</style>
</body>
</html>