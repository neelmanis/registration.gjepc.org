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

$show = "IIJS Signature 2020";
$action = $_POST['action'];
if($action =="Save")
{	
	//echo '<pre>'; print_r($getgeneralInfo); 
	//echo '<pre>'; print_r($getcompanyInfo); 
	//echo '<pre>'; print_r($getstallInfo); exit;
	//echo '<pre>'; print_r($getiijsInfo); exit;
	/* Insert Step 1 Data */
	
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
		$net_payable_amount = mysql_real_escape_string($_POST["net_payable_amount"]);
		$bank_acc_no = mysql_real_escape_string($_POST["bank_acc_no"]);
		$name_bank = mysql_real_escape_string($_POST["bank_name"]);
		$name_bank_branch = mysql_real_escape_string($_POST["branch_name"]);
		$ifsc_code = mysql_real_escape_string($_POST["ifsc_code"]);
		$int_acc_type = mysql_real_escape_string($_POST["int_acc_type"]);

/*echo '<pre>'; print_r($_POST); exit;*/
		if(strtoupper($_SESSION['COUNTRY'])=="IN"){  $currency = "";}else{ $currency = "USD";}
	      /*Common Data for both iijs & Signature end*/
		 $generalInfo_iijs = "insert into exh_reg_general_info set uid='$uid',company_name='".$getgeneralInfo['company_name']."',membership_id='".$getgeneralInfo['membership_id']."',membership_date='".$getgeneralInfo['membership_date']."',bp_number='".$getgeneralInfo['bp_number']."',address1='".$getgeneralInfo['address1']."',address2='".$getgeneralInfo['address2']."',address3='".$getgeneralInfo['address3']."',billing_address_id='".$getgeneralInfo['billing_address_id']."',get_billing_bp_number='".$getgeneralInfo['get_billing_bp_number']."',billing_gstin='".$getgeneralInfo['billing_gstin']."',billing_address1='".$getgeneralInfo['billing_address1']."',billing_address2='".$getgeneralInfo['billing_address2']."',billing_address3='".$getgeneralInfo['billing_address3']."',bcity='".$getgeneralInfo['bcity']."',bpincode='".$getgeneralInfo['bpincode']."',bcountry='".$getgeneralInfo['bcountry']."',btelephone_no='".$getgeneralInfo['btelephone_no']."',bfax_no='".$getgeneralInfo['bfax_no']."',billing_address_same='".$getgeneralInfo['billing_address_same']."',pan_no='".$getgeneralInfo['pan_no']."',tan_no='".$getgeneralInfo['tan_no']."',city='".$getgeneralInfo['city']."',pincode='".$getgeneralInfo['pincode']."',country='".$getgeneralInfo['country']."',telephone_no='".$getgeneralInfo['telephone_no']."',mobile='".$getgeneralInfo['mobile']."',fax_no='".$getgeneralInfo['fax_no']."',email='".$getgeneralInfo['email']."',gst='".$getgeneralInfo['gst']."',kyc='".$getgeneralInfo['kyc']."',website='".$getgeneralInfo['website']."',contact_person='".$getgeneralInfo['contact_person']."',contact_person_desg='".$getgeneralInfo['contact_person_desg']."',contact_person_desg_show='".$getgeneralInfo['contact_person_desg_show']."',contact_person_co='".$getgeneralInfo['contact_person_co']."',contacts='".$getgeneralInfo['contacts']."',event_for='".$getgeneralInfo['event_for']."',event_selected='iijs',participant_type='".$getgeneralInfo['participant_type']."',region='".$getgeneralInfo['region']."',created_date=NOW(),isCombo='Y'";
		$generalInfoResult = mysql_query($generalInfo_iijs);
		$gid_iijs = mysql_insert_id();
		
if($gid_iijs!='')
{
	/* Insert Step 2 Data */
	$companyInfo_iijs = "INSERT into exh_reg_company_details set gid='".$gid_iijs."', uid='$uid', we_are_jewellery='".$getcompanyInfo['we_are_jewellery']."', we_are_loose='".$getcompanyInfo['we_are_loose']."',we_are_machinery='".$getcompanyInfo['we_are_machinery']."', we_are='".$getcompanyInfo['we_are']."', we_are_jewellery_any_other='".$getcompanyInfo['we_are_jewellery_any_other']."',we_are_loose_any_other='".$getcompanyInfo['we_are_loose_any_other']."',we_are_machinery_any_other='".$getcompanyInfo['we_are_machinery_any_other']."', we_are_any_other='".$getcompanyInfo['we_are_any_other']."',comp_desc='".$getcompanyInfo['comp_desc']."',last_yr_turn_over='".$getcompanyInfo['last_yr_turn_over']."',created_date=NOW(),`show`='".$getcompanyInfo['show']."',event_selected='iijs',isCombo='Y'";
	$companyInfoResult = mysql_query($companyInfo_iijs);
    if(!$companyInfoResult) { die('Error: Company Details insert query failed' . mysql_error()); }	
	
	/* Insert Step 3 Data */
 
	 $iijsInfo = "INSERT into exh_registration set options='".$getiijsInfo['option']."',uid='$uid',gid='$gid_iijs',woman_entrepreneurs='".$getiijsInfo['woman_entrepreneurs']."',last_yr_participant='".$getiijsInfo['last_yr_participant']."',section='".$getiijsInfo['section']."',category='".$getiijsInfo['category']."',selected_area='".$getiijsInfo['selected_area']."',selected_scheme_type='".$getiijsInfo['selected_scheme_type']."',selected_premium_type='".$getiijsInfo['selected_premium_type']."',tot_space_cost_rate='".$getiijsInfo['tot_space_cost_rate']."',selected_scheme_rate='".$getiijsInfo['selected_scheme_rate']."',selected_premium_rate='".$getiijsInfo['selected_premium_rate']."',sub_total_cost ='".$getiijsInfo['sub_total_cost']."',security_deposit='".$getiijsInfo['security_deposit']."',govt_service_tax='".$getiijsInfo['govt_service_tax']."',grand_total='".$getiijsInfo['grand_total']."',created_date=NOW(),`show`='$show',event_selected='iijs',isCombo='Y'";
	$iijsInfoResult = mysql_query($iijsInfo);	
	if(!$iijsInfoResult) { die('Error: Stall Details insert query failed' . mysql_error()); }
	
	/* Insert Step 4 Data */
	if(isset($_POST["payment_mode"]) && isset($_POST["bank_acc_no"]))
	{

	$payment_mode = trim($_POST["payment_mode"]);
	
		
	$tds_holder = mysql_real_escape_string($_POST["tds_holder"]);
	if($tds_holder == 'Yes') {	
	$cheque_tds_per = mysql_real_escape_string($_POST["cheque_tds_per"]);
	$cheque_tds_amount = mysql_real_escape_string($_POST["cheque_tds_amount"]);
	$cheque_tds_Netamount = mysql_real_escape_string($_POST["cheque_tds_Netamount"]);
	$cheque_tds_deducted = mysql_real_escape_string($_POST["cheque_tds_deducted"]);		
	} else {		
	$cheque_tds_per = "";
	$cheque_tds_amount = "";
	$cheque_tds_Netamount = "";
	$cheque_tds_deducted = "";
	}
		$sqlm = "select * from  exh_registration where uid='$uid' AND gid='$gid_iijs'";
		$querym = mysql_query($sqlm);		
		$resultm = mysql_fetch_array($querym);
		$grandTotals = $resultm["grand_total"];
		$exh_id = $resultm["exh_id"];
	
		/* 50% or 100% */
		echo '----'.$amount_payable = mysql_real_escape_string($_POST["amount_payable"]);
		if(empty($amount_payable)) {  $signup_error1 = "Please Select Amount Payable"; exit; } else {
		
		$net_payable_amount = mysql_real_escape_string($_POST["net_payable_amount"]);
		
		//$grandTotals;
		$netTotal = $grandTotals * $amount_payable/100;
		//echo '--->'.$net_payable_amount .'=='. $netTotal;
		if($net_payable_amount == $netTotal)
		{

		 $paymenyInfo_iijs = "insert into exh_reg_payment_details set gid='$gid_iijs', uid='$uid', int_type='$int_type', payment_mode='$payment_mode', cheque_dd_no='$cheque_dd_no', cheque_dd_date='$cheque_dd_date', cheque_drawn_bank_name='$cheque_drawn_bank_name', cheque_drawn_branch_name='$cheque_drawn_branch_name', bank_acc_no='$bank_acc_no', name_bank='$name_bank', name_bank_branch='$name_bank_branch', ifsc_code='$ifsc_code', int_acc_type='$int_acc_type', created_date=NOW(), payment_status='$payment_status', document_status='$document_status', application_status='$application_status', erp_push='$erp_push', `tds_holder`='$tds_holder',`net_payable_amount`='$net_payable_amount',`percentage`='$amount_payable',`cheque_tds_per`='$cheque_tds_per',`cheque_tds_amount`='$cheque_tds_amount',`cheque_tds_Netamount`='$cheque_tds_Netamount',`cheque_tds_deducted`='$cheque_tds_deducted',`show`='$show',event_selected='iijs',isCombo='Y'";
		$paymenyInfoResult = mysql_query($paymenyInfo_iijs);
		if(!$paymenyInfoResult) { die('Error: payment Details insert query failed' . mysql_error()); }
		mysql_query("update exh_registration set curr_last_yr_check='Y' where exh_id='$exh_id'");	
		} else { echo 'something wrong'; }
		}

	}


/*-------------------------------------------IIJS Data Insert Process end--------------------------------------------------------*/
/*======================================================================================================================================*/
/*-------------------------------------------Signature Data Insert Process Start--------------------------------------------------------*/
$generalInfo_signature = "insert into exh_reg_general_info set uid='$uid',company_name='".$getgeneralInfo['company_name']."',membership_id='".$getgeneralInfo['membership_id']."',membership_date='".$getgeneralInfo['membership_date']."',bp_number='".$getgeneralInfo['bp_number']."',address1='".$getgeneralInfo['address1']."',address2='".$getgeneralInfo['address2']."',address3='".$getgeneralInfo['address3']."',billing_address_id='".$getgeneralInfo['billing_address_id']."',get_billing_bp_number='".$getgeneralInfo['get_billing_bp_number']."',billing_gstin='".$getgeneralInfo['billing_gstin']."',billing_address1='".$getgeneralInfo['billing_address1']."',billing_address2='".$getgeneralInfo['billing_address2']."',billing_address3='".$getgeneralInfo['billing_address3']."',bcity='".$getgeneralInfo['bcity']."',bpincode='".$getgeneralInfo['bpincode']."',bcountry='".$getgeneralInfo['bcountry']."',btelephone_no='".$getgeneralInfo['btelephone_no']."',bfax_no='".$getgeneralInfo['bfax_no']."',billing_address_same='".$getgeneralInfo['billing_address_same']."',pan_no='".$getgeneralInfo['pan_no']."',tan_no='".$getgeneralInfo['tan_no']."',city='".$getgeneralInfo['city']."',pincode='".$getgeneralInfo['pincode']."',country='".$getgeneralInfo['country']."',telephone_no='".$getgeneralInfo['telephone_no']."',mobile='".$getgeneralInfo['mobile']."',fax_no='".$getgeneralInfo['fax_no']."',email='".$getgeneralInfo['email']."',gst='".$getgeneralInfo['gst']."',kyc='".$getgeneralInfo['kyc']."',website='".$getgeneralInfo['website']."',contact_person='".$getgeneralInfo['contact_person']."',contact_person_desg='".$getgeneralInfo['contact_person_desg']."',contact_person_desg_show='".$getgeneralInfo['contact_person_desg_show']."',contact_person_co='".$getgeneralInfo['contact_person_co']."',contacts='".$getgeneralInfo['contacts']."',event_for='".$getgeneralInfo['event_for']."',event_selected='signature',participant_type='".$getgeneralInfo['participant_type']."',region='".$getgeneralInfo['region']."',created_date=NOW(),isCombo='Y'";
		$generalInfoResult = mysql_query($generalInfo_signature);
		$gid_signature = mysql_insert_id(); // last insert id for signature data
		
if($gid_signature!='') //check gid is not blank
{
	/*========================================================================================================================*/
	/* Insert company information into exh_reg_company_details for signature */
	/*========================================================================================================================*/
	$companyInfo_signature = "INSERT into exh_reg_company_details set gid='".$gid_signature."', uid='$uid', we_are_jewellery='".$getcompanyInfo['we_are_jewellery']."', we_are_loose='".$getcompanyInfo['we_are_loose']."',we_are_machinery='".$getcompanyInfo['we_are_machinery']."', we_are='".$getcompanyInfo['we_are']."', we_are_jewellery_any_other='".$getcompanyInfo['we_are_jewellery_any_other']."',we_are_loose_any_other='".$getcompanyInfo['we_are_loose_any_other']."',we_are_machinery_any_other='".$getcompanyInfo['we_are_machinery_any_other']."', we_are_any_other='".$getcompanyInfo['we_are_any_other']."',comp_desc='".$getcompanyInfo['comp_desc']."',last_yr_turn_over='".$getcompanyInfo['last_yr_turn_over']."',created_date=NOW(),`show`='".$getcompanyInfo['show']."',event_selected='signature',isCombo='Y'";
	$companyInfoResult = mysql_query($companyInfo_signature);
    if(!$companyInfoResult) { die('Error: Company Details for signature insert query failed' . mysql_error()); }	
	/*===========================================================================================================================*/
	/* Insert stall information into exh_registration for signature */
	/*============================================================================================================================*/
	 $signatureInfo = "INSERT into exh_registration set options='".$getsignatureInfo['option']."',uid='$uid',gid='$gid_signature',woman_entrepreneurs='".$getsignatureInfo['woman_entrepreneurs']."',last_yr_participant='".$getsignatureInfo['last_yr_participant']."',section='".$getsignatureInfo['section']."',category='".$getsignatureInfo['category']."',selected_area='".$getsignatureInfo['selected_area']."',selected_scheme_type='".$getsignatureInfo['selected_scheme_type']."',selected_premium_type='".$getsignatureInfo['selected_premium_type']."',tot_space_cost_rate='".$getsignatureInfo['tot_space_cost_rate']."',selected_scheme_rate='".$getsignatureInfo['selected_scheme_rate']."',selected_premium_rate='".$getsignatureInfo['selected_premium_rate']."',sub_total_cost ='".$getsignatureInfo['sub_total_cost']."',security_deposit='".$getsignatureInfo['security_deposit']."',govt_service_tax='".$getsignatureInfo['govt_service_tax']."',grand_total='".$getsignatureInfo['grand_total']."',created_date=NOW(),`show`='$show',event_selected='signature',isCombo='Y'";
	$signatureInfoResult = mysql_query($signatureInfo);	
	if(!$signatureInfoResult) { die('Error: Stall Details insert query failed' . mysql_error()); }
	/*==============================================================================================================================*/
	/*Insert payment information into exh_reg_company_details table for signature  */
	/*==============================================================================================================================*/
	if(isset($_POST["signature_payment_mode"]) && isset($_POST["bank_acc_no"]))
	{
		
	$signature_payment_mode = trim($_POST["signature_payment_mode"]);  //signature payment mode
	$signature_tds_holder = mysql_real_escape_string($_POST["signature_tds_holder"]);
	if($signature_tds_holder == 'Yes') {	
	$signature_cheque_tds_per = mysql_real_escape_string($_POST["signature_cheque_tds_per"]);
	$signature_cheque_tds_amount = mysql_real_escape_string($_POST["signature_cheque_tds_amount"]);
	$signature_cheque_tds_Netamount = mysql_real_escape_string($_POST["signature_cheque_tds_Netamount"]);
	$signature_cheque_tds_deducted = mysql_real_escape_string($_POST["signature_cheque_tds_deducted"]);		
	} else {		
	$signature_cheque_tds_per = "";
	$signature_cheque_tds_amount = "";
	$signature_cheque_tds_Netamount = "";
	$signature_cheque_tds_deducted = "";
	}
		$sql_signature = "select * from  exh_registration where uid='$uid' AND gid='$gid_signature'";
		$query_signture = mysql_query($sql_signature);		
		$result_signature = mysql_fetch_array($query_signture);
		$signature_grandTotals = $result_signature["grand_total"];
		$exh_id_signature = $result_signature["exh_id"];
	
		/* 50% or 100% */
		 $signature_amount_payable = mysql_real_escape_string($_POST["signature_amount_payable"]);
		if(empty($signature_amount_payable)) {   $signup_error = "Please Select Amount Payable"; } else {
		
		$signature_net_payable_amount = mysql_real_escape_string($_POST["signature_net_payable_amount"]);
		//$grandTotals;
		$signature_netTotal = $signature_grandTotals * $signature_amount_payable/100;
		//echo '--->'.$net_payable_amount .'=='. $netTotal;
		if($signature_net_payable_amount == $signature_netTotal)
		{
		
		 $paymentInfo_signature = "insert into exh_reg_payment_details set gid='$gid_signature', uid='$uid', int_type='$int_type', payment_mode='$signature_payment_mode', cheque_dd_no='$cheque_dd_no', cheque_dd_date='$cheque_dd_date', cheque_drawn_bank_name='$cheque_drawn_bank_name', cheque_drawn_branch_name='$cheque_drawn_branch_name', bank_acc_no='$bank_acc_no', name_bank='$name_bank', name_bank_branch='$name_bank_branch', ifsc_code='$ifsc_code', int_acc_type='$int_acc_type', created_date=NOW(), payment_status='$payment_status', document_status='$document_status', application_status='$application_status', erp_push='$erp_push', `tds_holder`='$signature_tds_holder',`net_payable_amount`='$signature_net_payable_amount',`percentage`='$signature_amount_payable',`cheque_tds_per`='$signature_cheque_tds_per',`cheque_tds_amount`='$signature_cheque_tds_amount',`cheque_tds_Netamount`='$signature_cheque_tds_Netamount',`cheque_tds_deducted`='$signature_cheque_tds_deducted',`show`='$show',event_selected='signature',isCombo='Y'";

		$paymentInfoResult = mysql_query($paymentInfo_signature);
		if(!$paymentInfoResult) { die('Error: payment Details insert query failed' . mysql_error()); }
		mysql_query("update exh_registration set curr_last_yr_check='Y' where exh_id='$exh_id_signature'");	
/*-------------------------------------------Signature Data Insert Process end--------------------------------------------------------*/
		
		} else { echo 'something wrong'; }
		}
	
	}
	
$message ='<table width="100%" bgcolor="#fbfbfb" style="margin:20px auto; border:2px solid #dddddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
<tr>
<td style="padding:30px;">
<table width="100%" border="0" background="#fbfbfb" cellpadding="0" cellspacing="0">
    <tr>
    	<td align="left" valign="top"><a href="https://www.iijs-signature.org"><img src="http://registration.gjepc.org/images/mailer/logo.png"/></a></td>
    	<td align="right"><a href="https://www.gjepc.org"><img src="http://registration.gjepc.org/images/mailer/gjepc_logo.png"  /></a></td>
    </tr>    
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>
    
    <tr><td colspan="2" height="1px" bgcolor="#333333"></td></tr>
    
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>
    
	<tr>
    	<td colspan="2" valign="top" style="font-size:13px;">
    	<p><strong>Dear '.$getgeneralInfo['contact_person'].',</strong> </p>
    	<p>Thank you for applying Online for IIJS Signature Exhibitor Registration. Please note your application is under approval process.</p>    
    	
    	<p><strong>Company Name :</strong> '.$_SESSION['COMPANYNAME'].'</p>
    	</td>
    </tr>
    
    <tr><td colspan="2">&nbsp;</td></tr>
    
    <tr>
    
    	<td style="padding-right:10px;">
			
            <table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; margin-bottom:15px;">
    			<tr>
    				<td colspan="2" style="color:#14b3da;"><strong>Application Summary IIJS-Primiere</strong></td>
    			</tr>
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
        <td>'.$getiijsInfo['options'].'</td>
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
        <td valign="top">'.$getiijsInfo['selected_scheme_type'].'</td>
    </tr>
</table>


<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; margin-bottom:20px;">
  <tr valign="top">
    <td colspan="2"  style="color:#14b3da;"><strong>Application Payment Summary IIJS-Primiere</strong><br /></td>
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
    <tr>
    	<td colspan="2" style="color:#14b3da;"><strong>Application Summary IIJS-Signature</strong></td>
    </tr>
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
        <td>'.$getsignatureInfo['options'].'</td>
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
        <td valign="top">'.$getsignatureInfo['selected_scheme_type'].'</td>
    </tr>
</table>


<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; margin-bottom:20px;">
  <tr valign="top">
    <td colspan="2"  style="color:#14b3da;"><strong>Application Payment Summary IIJS-Signature</strong><br /></td>
    </tr>
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
  <td width="48%">Saving Account – Trust</td>
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
	
	//$to =$_SESSION['EMAILID'].",".$to_admin.",notification@gjepcindia.com";
	$to ='neelmani@kwebmaker.com';	
	$subject = "Exhibitor Registration for IIJS Signature 2020 (EXREG/IIJS Signature/2020/".$resultm['exh_id']."/dated".date('Y-m-d').")";
	$headers  = 'MIME-Version: 1.0' . "\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1'."\n";	
	$headers .='From: IIJS Signature 2020 <admin@gjepc.org>';	
	@mail($to, $subject, $message, $headers);
	
	/* Now Unset session */
	unset($_SESSION['eventInfo']);	/* Event Applying */	 
	unset($_SESSION['generalInfo']);  /* Get 1 step data */
	unset($_SESSION['companyInfo']); /* Get 2 step data */
	unset($_SESSION['stallInfo']);    /* Get 3 step data */
	unset($_SESSION['iijsInfo']);    /* Get 3 step data */
	unset($_SESSION['signatureInfo']);    /* Get 3 step data */

	header("location:exhibitor_registration_print_application.php?gid=".$gid);	exit;	
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
<!--<script type="text/javascript">
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
</script>-->
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

    });
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
		?>          
    	<div class="clear"></div>
		<?php if(isset($signup_error1)){ echo "<span style='color: red;'>".$signup_error1.'</span>';} ?>	  
    <div class="clear"></div>
	</div>	      
    <div class="clear"></div>    
    
    <div class="wrap">
		
		<section class="float-l border-r">
		<h1 class="form-title">IIJS PREMIERE</h1>
		<div class="summary_box">
        <p><strong style="text-transform:uppercase; font-size:14px;">Application Summary(Exh<?php //echo $result['gid'];?>)</strong></p>
        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        <p><strong>Last Year Participant :</strong>&nbsp;<?php echo $getiijsInfo['last_yr_participant'];?></p>
        <p><strong>Option :</strong>&nbsp; <?php echo $getiijsInfo['option'];?> </p>
        <p><strong>Section :</strong>&nbsp; <?php echo $getiijsInfo['section'];?> </p>
        <p><strong>Area :</strong>&nbsp; <?php echo $getiijsInfo['selected_area'];?> &nbsp;sqrt</p>
        <p><strong>Scheme :</strong>&nbsp; <?php echo getSchemeDescription($getiijsInfo['selected_scheme_type']);?> </p>
        <p><strong>Premium :</strong>&nbsp; <?php echo $getiijsInfo['selected_premium_type'];?></p>
        </div>
        
        <div class="summary_box">
        <p><strong style="text-transform:uppercase; font-size:14px;"> Payment Summary</strong> </p>
       <p> <span class="clear" style="height:1px; background:#ccc; display:block;"></span></p>
       <p> <strong>Total Space Cost <?php echo $currency;?> :</strong>&nbsp;<?php echo $getiijsInfo['tot_space_cost_rate'];?> </p>
       <p> <strong>Selected scheme rate <?php echo $currency;?> :</strong>&nbsp;<?php echo $getiijsInfo['selected_scheme_rate'];?> </p>
       <p> <strong>Selected premium rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $getiijsInfo['selected_premium_rate'];?></p>
       <p> <strong>Sub Total <?php echo $currency;?> :</strong>&nbsp;<?php echo $getiijsInfo['sub_total_cost'];?> </p>
       <p> <strong>Security Deposit (10% on Sub Total) <?php echo $currency;?> :</strong>&nbsp;<?php echo $getiijsInfo['security_deposit'];?> </p>
       <p> <strong>GST (18% on Sub Total) <?php echo $currency;?> :</strong>&nbsp;<?php echo $getiijsInfo['govt_service_tax'];?></p>
       <p> <strong>Grand Total <?php echo $currency;?> :</strong>&nbsp; <?php echo $getiijsInfo['grand_total'];?></p>
		</div>  
		</section>
		<section class="float-r">
		<h1 class="form-title">IIJS SIGNATURE</h1>
		<div class="summary_box">
        <p><strong style="text-transform:uppercase; font-size:14px;">Application Summary(Exh<?php //echo $result['gid'];?>)</strong><br />
        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        <strong>Last Year Participant :</strong>&nbsp;<?php echo $getsignatureInfo['last_yr_participant'];?><br />
        <strong>Option :</strong>&nbsp; <?php echo $getsignatureInfo['option'];?> <br />
        <strong>Section :</strong>&nbsp; <?php echo $getsignatureInfo['section'];?> <br />
        <strong>Category :</strong>&nbsp; <?php echo $getsignatureInfo['category'];?> <br />
        <strong>Area :</strong>&nbsp; <?php echo $getsignatureInfo['selected_area'];?> &nbsp;sqrt<br />
        <strong>Scheme :</strong>&nbsp; <?php echo getSchemeDescription($getsignatureInfo['selected_scheme_type']);?> <br />
        <strong>Premium :</strong>&nbsp; <?php echo $getsignatureInfo['selected_premium_type'];?></p>
        </div>
        
        <div class="summary_box">
        <p><strong style="text-transform:uppercase; font-size:14px;"> Payment Summary</strong> <br />
        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        <strong>Total Space Cost <?php echo $currency;?> :</strong>&nbsp;  <?php echo $getsignatureInfo['tot_space_cost_rate'];?> <br />
        <strong>Selected scheme rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $getsignatureInfo['selected_scheme_rate'];?><br />
        <strong>Selected premium rate <?php echo $currency;?> :</strong>&nbsp;  <?php echo $getsignatureInfo['selected_premium_rate'];?> <br />
        <strong>Sub Total <?php echo $currency;?> :</strong>&nbsp;  <?php echo $getsignatureInfo['sub_total_cost'];?> <br />
        <strong>Security Deposit (10% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo $getsignatureInfo['security_deposit'];?> <br />
        <strong>GST (18% on Sub Total) <?php echo $currency;?> :</strong>&nbsp;  <?php echo $getsignatureInfo['govt_service_tax'];?><br />
        <strong>Grand Total <?php echo $currency;?> :</strong>&nbsp;  <?php echo $getsignatureInfo['grand_total'];?></p>
        </div>
		</section>

		<div class="clear"></div>
		<p style="text-align: center;"><strong><span style="color: red; text-align: center;">All the applicants will have to update UTR No. and TDS Details on Dashboard after submitting space application form.</span></strong></p>
 <div class="clear" style="height:10px;"></div>
 
<form action="" method="post" id="step_4_combo">

		<section class="float-l border-r">
		<div style="margin-bottom:10px; font-size:14px;"><strong>Payment Details</strong><span class="clear" style="height:1px; background:#ccc; display:block; margin-top:8px;"></span></div> 
		<input type="hidden" name="grand_total" id="grand_total" value="<?php echo round($getiijsInfo['grand_total']);?>"/>
		<input type="hidden" name="exh_id" id="exh_id" value="<?php echo $getiijsInfo['exh_id'];?>"/>
        <span id="wa_machinery_error" class="error_mg"></span>
		
		<div class="field_box">
        <div class="field_name">Amount Payable <span>*</span>:</div>
        <div class="field_input">
			<select class="textField" name="amount_payable" id="amount_payable"/>
				 <option value=""> Select Payable Amount  </option>
				 <?php if(strtoupper($getiijsInfo['last_yr_participant'])=="NO"){ ?>
				 <option value="50">50%</option>
				 <?php } else { ?>
				 <option value="50">50%</option>
				 <option value="100">100%</option>
				 <?php } ?>
			</select>
        <br><label class="error" id="amount_payable_error"></label>
		</div>
        <div class="clear"></div>
        </div>
		
		<div class="field_box">
        <div class="field_name">Gross Amount <span>*</span>:</div>
        <div class="field_input">
			<input name="net_payable_amount" id="net_payable_amount" type="text" class="bgcolor" 
			 readonly/>
            <br><label class="error" id="cheque_tds_gross_amount_error"></label> 
		</div>
        <div class="clear"></div>
        </div>
				
		<?php if(strtoupper($getiijsInfo['last_yr_participant'])=="YES"){ ?>
		<div class="field_box">
        <div class="field_name"><strong>TDS Deducted</strong></div>
        <div class="field_input">
		<label>Yes</label> <input type="radio" id="chkYes" value="Yes" name="tds_holder"/>
		<label>No</label> <input type="radio" id="chkNo" value="No" name="tds_holder"  /></label>
		</div>
        <label for="tds_holder" generated="true" class="error" style="display: inline-block;"></label>
        <div class="clear"></div>
        </div>
		
		<div class="field_box" id="holder_star">
			<div class="field_box">
				<div class="field_name">TDS Percentage @2 % or 10%<span>*</span> : </div>
				<div class="field_input">
				<select class="textField" name="cheque_tds_per" id="cheque_tds_per">
				<option value="">--Select TDS percentage--</option>
			     <option value="2" >2 %</option>
				 <option value="10" >10 %</option>
				</select>				
                <br><label class="error" id="cheque_tds_per_error"></label>
				</div>			
                <div class="clear"></div>
            </div>
            <div class="field_box">
                <div class="field_name">TDS Amount <span>*</span> :</div> 
				<div class="field_input"> 
				<input name="cheque_tds_amount" type="text" id="cheque_tds_amount" class="textField"  autocomplete="off"/>
                <br><label class="error" id="cheque_tds_amount_error"></label>
				</div>
                <div class="clear"></div>
            </div>
			<div class="field_box">
                <div class="field_name">Net Amount<span>*</span> :</div>
                <div class="field_input">
				<input name="cheque_tds_Netamount" type="text" id="cheque_tds_Netamount" class="textField" autocomplete="off"/>
                <br><label class="error" id="cheque_tds_Netamount_error"></label>
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
		</div>
        <div class="clear"></div>
        </div>
		</section>
		<section class="float-r">
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
				 <option value="50">50%</option>
				 <?php } else { ?>
				 <option value="50">50%</option>
				 <option value="100">100%</option>
				 <?php } ?>
			</select>
        <br><label class="error" id="signature_amount_payable_error"></label>
		</div>
        <div class="clear"></div>
        </div>
		
		<div class="field_box">
        <div class="field_name">Gross Amount <span>*</span>:</div>
        <div class="field_input">
		<input name="signature_net_payable_amount" id="signature_net_payable_amount" type="text" class="bgcolor" readonly/>
        <br><label class="error" id="signature_cheque_tds_gross_amount_error"></label> 
		</div>
        <div class="clear"></div>
        </div>
				
		<?php if(strtoupper($getsignatureInfo['last_yr_participant']) =="YES"){ ?>
		<div class="field_box">
        <div class="field_name"><strong>TDS Deducted</strong></div>
        <div class="field_input">
		Yes <input type="radio" id="signature_chkYes" value="Yes" name="signature_tds_holder"/>
		No <input type="radio" id="signature_chkNo" value="No" name="signature_tds_holder"/></label>
		</div>
		<label for="signature_tds_holder" generated="true" class="error" style="display: inline-block;"></label>
        <div class="clear"></div>
        </div>		
		
		<div class="field_box" id="signature_holder_star" >	
            
			<div class="field_box">
				<div class="field_name">TDS Percentage @2 % or 10%<span>*</span> : </div>
				<div class="field_input">
				<select class="textField" name="signature_cheque_tds_per" id="signature_cheque_tds_per">
				<option value="">--Select TDS percentage--</option>
			     <option value="2">2 %</option>
				 <option value="10">10 %</option>
				</select>				
                <br><label class="error" id="signature_cheque_tds_per_error"></label>
				</div>			
                <div class="clear"></div>
            </div>
            <div class="field_box">
                <div class="field_name">TDS Amount <span>*</span> :</div> 
				<div class="field_input"> 
				<input name="signature_cheque_tds_amount" type="text" id="signature_cheque_tds_amount" class="textField" autocomplete="off"/>
                <br><label class="error" id="signature_cheque_tds_amount_error"></label>
				</div>
                <div class="clear"></div>
            </div>
			<div class="field_box">
                <div class="field_name">Net Amount<span>*</span> :</div>
                <div class="field_input">
				<input name="signature_cheque_tds_Netamount" type="text" id="signature_cheque_tds_Netamount" class="textField" />
                <br><label class="error" id="signature_cheque_tds_Netamount_error"></label>
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
		</div>
        <div class="clear"></div>
        </div>
		</section>
		<div class="clear"></div>
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
		<input type="text" name="bank_acc_no" id="bank_acc_no" class="bgcolor" />
		<br><label class="error" id="bank_acc_no_error"><?php if(isset($bank_acc_no_error)){ echo $bank_acc_no_error;}?></label>
		</div> <div class="clear"></div>
        </div>
        
        <div class="field_box">
        <div class="field_name">Name of Bank <span>*</span> :</div>
        <div class="field_input">
		<input type="text" name="bank_name" id="bank_name" class="bgcolor"  />
		<br><label class="error" id="bank_name_error"><?php if(isset($bank_name_error)){ echo $bank_name_error;}?></label>
		</div> <div class="clear"></div>
        </div>
                
        <div class="field_box">
        <div class="field_name">Type of Account <span>*</span> :</div>
        <div class="field_input">
            <select class="bgcolor" name="int_acc_type" id="int_acc_type" >
            <option value="">--- Please Select Account Type ---</option>
            <option value="Saving">Saving</option>
            <option value="Current">Current</option>
            </select>
            <br><label class="error" id="int_acc_type_error"><?php if(isset($int_acc_type_error)){ echo $int_acc_type_error;}?></label>
        </div>  <div class="clear"></div>
        </div>     
		</section>

		<section class="float-r">		
        <div class="field_box">
        <div class="field_name">IFSC Code <span>*</span> :</div>
        <div class="field_input"><input type="text" name="ifsc_code" id="ifsc_code" class="bgcolor"  /><br>
        <label class="error" id="ifsc_code_error"><?php if(isset($ifsc_code_error)){ echo $ifsc_code_error;}?></label></div>
        <div class="clear"></div>
        </div>
      
		<div class="field_box">
        <div class="field_name">Name of Branch <span>*</span> :</div>
        <div class="field_input">
		<input type="text" name="branch_name" id="branch_name" class="bgcolor"/>
		<br><label class="error" id="branch_name_error"><?php if(isset($branch_name_error)){ echo $branch_name_error;}?></label>
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