<?php 
include('header_include.php');

if($_POST['action'] == "iijsAction")
{
//echo '<pre>';print_r($_POST);

$last_yr_participant = $_POST['last_yr_participant'];
$exh_id = $_POST['exh_id'];
$option = $_POST['option'];
$section = $_POST['section'];
$selected_area = $_POST['selected_area'];
$lastYearArea = $_POST['lastYearArea'];
$selected_scheme_type = $_POST['selected_scheme_type'];
$selected_premium_type = $_POST['selected_premium_type'];
$woman_entrepreneurs = $_POST['woman_entrepreneurs'];
$tot_space_cost_rate = $_POST['tot_space_cost_rate'];
$tot_space_cost_discount = $_POST['tot_space_cost_discount'];
$get_tot_space_cost_rate = $_POST['get_tot_space_cost_rate'];
$selected_scheme_rate = $_POST['selected_scheme_rate'];
$selected_premium_rate = $_POST['selected_premium_rate'];
$sub_total_cost = $_POST['sub_total_cost'];
$security_deposit = $_POST['security_deposit'];
$govt_service_tax = $_POST['govt_service_tax'];
$grand_total = $_POST['grand_total'];
$mcb_charges = $_POST['mcb_charges'];
$country = $_POST['country'];

	if($tot_space_cost_rate=='') $tot_space_cost_rate=0;			
	if($tot_space_cost_discount=='') $tot_space_cost_discount=0;	
	if($get_tot_space_cost_rate=='') $get_tot_space_cost_rate=0;	
	if($selected_scheme_rate=='') $selected_scheme_rate=0;	
	if($selected_premium_rate=='') $selected_premium_rate=0;		
	if($sub_total_cost=='')	$sub_total_cost=0;	
	if($mezzanine_space_charges=='') $mezzanine_space_charges=0;	
	if($security_deposit=='') $security_deposit=0;		
	if($grand_total=='') $grand_total=0;		
	if($mcb_charges=='') $mcb_charges=0;
	$created_date=date('Y-m-d');
	
	if(strtoupper($_SESSION['COUNTRY'])=="IN") $currency = "";	else $currency = "USD";

if(empty($last_yr_participant)){
echo json_encode(array('name'=>'last_yr_participant','status'=>'last_yr_participant_empty','msg'=>'last_yr_participant is required'));exit;
}elseif(empty($option)){
	echo json_encode(array('name'=>'option','status'=>'option_empty','msg'=>'Please select any option'));exit;
}elseif(empty($section)){
	echo json_encode(array('name'=>'section','status'=>'section_empty','msg'=>'Please select section '));exit;	
}elseif(empty($selected_area)){
	echo json_encode(array('name'=>'selected_area','status'=>'selected_area_empty','msg'=>'Please select your area'));exit;	
}elseif(empty($selected_scheme_type)){
	echo json_encode(array('name'=>'selected_scheme_type','status'=>'selected_scheme_type_empty','msg'=>'Please Select your scheme type'));exit;	
}elseif(empty($selected_premium_type)){
	echo json_encode(array('name'=>'selected_premium_type','status'=>'selected_premium_type_empty','msg'=>'Please Select your premium type'));exit;
}

$iijsInfo = array('last_yr_participant'=>$last_yr_participant,'exh_id'=>$exh_id,'option'=>$option,'section'=>$section,'selected_area'=>$selected_area,'lastYearArea'=>$lastYearArea,'selected_scheme_type'=>$selected_scheme_type,'selected_premium_type'=>$selected_premium_type,'woman_entrepreneurs'=>$woman_entrepreneurs,'tot_space_cost_rate'=>$tot_space_cost_rate,'tot_space_cost_discount'=>$tot_space_cost_discount,'get_tot_space_cost_rate'=>$get_tot_space_cost_rate,'selected_scheme_rate'=>$selected_scheme_rate,'selected_premium_rate'=>$selected_premium_rate,'sub_total_cost'=>$sub_total_cost,'security_deposit'=>$security_deposit,'govt_service_tax'=>$govt_service_tax,'grand_total'=>$grand_total);

$_SESSION['iijsInfo'] =$iijsInfo; 

//echo '<pre>'; print_r($_SESSION['iijsInfo']); exit;
echo json_encode(array('name'=>'submitIijs','status'=>'success','msg'=>'Your Data for IIJS Premiere 2020 is Stored Sucessfully Complete your data for IIJS Signature 2020 form'));exit;
}

if($_POST['action'] == "signatureAction")
{
//echo '<pre>';print_r($_POST);
$last_yr_signature_participant = $_POST['last_yr_signature_participant'];
$signature_exh_id = $_POST['signature_exh_id'];
$signature_option = $_POST['signature_option'];
$signature_section = $_POST['signature_section'];
$signature_category = $_POST['signature_category'];
$signature_area = $_POST['signature_area'];
$lastYearSignatureArea = $_POST['lastYearSignatureArea'];
$signature_selected_scheme_type = $_POST['signature_selected_scheme_type'];
$signature_selected_premium_type = $_POST['signature_selected_premium_type'];
$signature_woman_entrepreneurs = $_POST['signature_woman_entrepreneurs'];
$signature_tot_space_cost_rate = $_POST['signature_tot_space_cost_rate'];
$signature_tot_space_cost_discount = $_POST['signature_tot_space_cost_discount'];
$signature_get_tot_space_cost_rate = $_POST['signature_get_tot_space_cost_rate'];							
$signature_get_category_rate = $_POST['signature_get_category_rate'];							
$signature_selected_scheme_rate = $_POST['signature_selected_scheme_rate'];
$signature_selected_premium_rate = $_POST['signature_selected_premium_rate'];
$signature_sub_total_cost = $_POST['signature_sub_total_cost'];
$signature_security_deposit = $_POST['signature_security_deposit'];
$signature_govt_service_tax = $_POST['signature_govt_service_tax'];
$signature_grand_total = $_POST['signature_grand_total'];

	if($signature_tot_space_cost_rate=='') $signature_tot_space_cost_rate=0;			
	if($signature_tot_space_cost_discount=='') $signature_tot_space_cost_discount=0;	
	if($signature_get_tot_space_cost_rate=='') $signature_get_tot_space_cost_rate=0;	
	if($signature_get_category_rate=='') $signature_get_category_rate=0;	
	if($signature_selected_scheme_rate=='') $signature_selected_scheme_rate=0;	
	if($signature_selected_premium_rate=='') $signature_selected_premium_rate=0;		
	if($signature_sub_total_cost=='')	$signature_sub_total_cost=0;	
	if($signature_security_deposit=='') $signature_security_deposit=0;		
	if($signature_grand_total=='') $signature_grand_total=0;		

if(empty($last_yr_signature_participant)){
echo json_encode(array('name'=>'last_yr_signature_participant','status'=>'last_yr_signature_participant_empty','msg'=>'last_yr_signature_participant is required'));exit;
}elseif(empty($signature_option)){
	echo json_encode(array('name'=>'signature_option','status'=>'signature_option_empty','msg'=>'Please select above any option'));exit;
}elseif(empty($signature_section)){
	echo json_encode(array('name'=>'signature_section','status'=>'signature_section_empty','msg'=>'Please your section'));exit;
}elseif(empty($signature_category)){
	echo json_encode(array('name'=>'signature_category','status'=>'signature_category_empty','msg'=>'Please your category'));exit;
}elseif(empty($signature_area)){
	echo json_encode(array('name'=>'signature_area','status'=>'signature_area_empty','msg'=>'Please Select your Area '));exit;
}elseif(empty($signature_selected_scheme_type)){
	echo json_encode(array('name'=>'signature_selected_scheme_type','status'=>'signature_selected_scheme_type_empty','msg'=>'Please select your scheme type'));exit;
}elseif(empty($signature_selected_premium_type)){
	echo json_encode(array('name'=>'signature_selected_premium_type','status'=>'signature_selected_premium_type_empty','msg'=>'Please Select your premium type')); exit;	
}
$signatureInfo = array('last_yr_participant'=>$last_yr_signature_participant,'exh_id'=>$signature_exh_id,'option'=>$signature_option,'section'=>$signature_section,'category'=>$signature_category,'selected_area'=>$signature_area,'lastYearArea'=>$lastYearSignatureArea,'selected_scheme_type'=>$signature_selected_scheme_type,'selected_premium_type'=>$signature_selected_premium_type,'woman_entrepreneurs'=>$signature_woman_entrepreneurs,'tot_space_cost_rate'=>$signature_tot_space_cost_rate,'tot_space_cost_discount'=>$signature_tot_space_cost_discount,'get_tot_space_cost_rate'=>$signature_get_tot_space_cost_rate,'get_category_rate'=>$signature_get_category_rate,'selected_scheme_rate'=>$signature_selected_scheme_rate,'selected_premium_rate'=>$signature_selected_premium_rate,'sub_total_cost'=>$signature_sub_total_cost,'security_deposit'=>$signature_security_deposit,'govt_service_tax'=>$signature_govt_service_tax,'grand_total'=>$signature_grand_total);
   $_SESSION['signatureInfo'] =$signatureInfo; 
	/*echo '<pre>'; print_r($signatureData);exit;*/
echo json_encode(array('name'=>'submitSignature','status'=>'success','msg'=>'Your Data for both is Stored Sucessfully proceed for next Step'));exit;

}
if($_POST['action'] == "tritiyaAction")
{

$last_yr_tritiya_participant = $_POST['last_yr_tritiya_participant'];
$tritiya_exh_id = $_POST['tritiya_exh_id'];
$tritiya_option = "";
$tritiya_section = $_POST['tritiya_section'];
$tritiya_category = "";
$tritiya_area = $_POST['tritiya_area'];
$lastYearTritiyaArea = $_POST['lastYearTritiyaArea'];
$tritiya_selected_scheme_type = "";
$tritiya_selected_premium_type = "";
$tritiya_woman_entrepreneurs = "";
$tritiya_tot_space_cost_rate = $_POST['tritiya_tot_space_cost_rate'];
$tritiya_tot_space_cost_discount = $_POST['tritiya_tot_space_cost_discount'];
$tritiya_get_tot_space_cost_rate = $_POST['tritiya_get_tot_space_cost_rate'];							
$tritiya_get_category_rate = $_POST['tritiya_get_category_rate'];							
$tritiya_selected_scheme_rate = $_POST['tritiya_selected_scheme_rate'];
$tritiya_selected_premium_rate = $_POST['tritiya_selected_premium_rate'];
$tritiya_sub_total_cost = $_POST['tritiya_sub_total_cost'];
$tritiya_security_deposit = $_POST['tritiya_security_deposit'];
$tritiya_govt_service_tax = $_POST['tritiya_govt_service_tax'];
$tritiya_grand_total = $_POST['tritiya_grand_total'];

	if($tritiya_tot_space_cost_rate=='') $tritiya_tot_space_cost_rate=0;			
	if($tritiya_tot_space_cost_discount=='') $tritiya_tot_space_cost_discount=0;	
	if($tritiya_get_tot_space_cost_rate=='') $tritiya_get_tot_space_cost_rate=0;	
	if($tritiya_get_category_rate=='') $tritiya_get_category_rate=0;	
	if($tritiya_selected_scheme_rate=='') $tritiya_selected_scheme_rate=0;	
	if($tritiya_selected_premium_rate=='') $tritiya_selected_premium_rate=0;		
	if($tritiya_sub_total_cost=='')	$tritiya_sub_total_cost=0;	
	if($tritiya_security_deposit=='') $tritiya_security_deposit=0;		
	if($tritiya_govt_service_tax=='') $tritiya_govt_service_tax=0;		
	if($tritiya_grand_total=='') $tritiya_grand_total=0;		

if(empty($last_yr_tritiya_participant)){
echo json_encode(array('name'=>'last_yr_tritiya_participant','status'=>'last_yr_tritiya_participant_empty','msg'=>'last_yr_tritiya_participant is required'));exit;
}elseif(empty($tritiya_section)){
	echo json_encode(array('name'=>'tritiya_section','status'=>'tritiya_section_empty','msg'=>'Please your section'));exit;
}elseif(empty($tritiya_area)){
	echo json_encode(array('name'=>'tritiya_area','status'=>'tritiya_area_empty','msg'=>'Please Select your Area '));exit;
}
$tritiyaInfo = array('last_yr_participant'=>$last_yr_tritiya_participant,'exh_id'=>$tritiya_exh_id,'option'=>$tritiya_option,'section'=>$tritiya_section,'category'=>$tritiya_category,'selected_area'=>$tritiya_area,'lastYearArea'=>$lastYearSignatureArea,'selected_scheme_type'=>$tritiya_selected_scheme_type,'selected_premium_type'=>$tritiya_selected_premium_type,'woman_entrepreneurs'=>$tritiya_woman_entrepreneurs,'tot_space_cost_rate'=>$tritiya_tot_space_cost_rate,'tot_space_cost_discount'=>$tritiya_tot_space_cost_discount,'get_tot_space_cost_rate'=>$tritiya_get_tot_space_cost_rate,'get_category_rate'=>$tritiya_get_category_rate,'selected_scheme_rate'=>$tritiya_selected_scheme_rate,'selected_premium_rate'=>$tritiya_selected_premium_rate,'sub_total_cost'=>$tritiya_sub_total_cost,'security_deposit'=>$tritiya_security_deposit,'govt_service_tax'=>$tritiya_govt_service_tax,'grand_total'=>$tritiya_grand_total);
   $_SESSION['tritiyaInfo'] =$tritiyaInfo; 
	/*echo '<pre>'; print_r($signatureData);exit;*/
echo json_encode(array('name'=>'submitTritiya','status'=>'success','msg'=>'Your Data for combo is Stored Sucessfully proceed for next Step'));exit;

}

?>