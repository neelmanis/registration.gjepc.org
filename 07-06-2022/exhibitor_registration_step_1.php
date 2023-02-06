<?php 
include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit;	}
$registration_id=$_SESSION['USERID'];
if(($_SESSION['eventInfo']['event_selected'] =="")){ header("location:event_selection.php"); exit; }

/*if($_SESSION['eventInfo']['event_selected']=="signature"){ $event_for="IIJS SIGNATURE 2022"; } 
if($_SESSION['eventInfo']['event_selected']=="iijs") { $event_for="IIJS 2022"; } */
$event_selected = $_SESSION['eventInfo']['event_selected'];
$event_for = getExhEventDescriptionEvent($event_selected,$conn);
?>
<?php /*
		$checkiijs = "select temp_roi_check_iijs from registration_master where id='$registration_id'";
		$qchk = mysql_query($checkiijs);
		$rchk = mysql_fetch_array($qchk);
		$rchk['temp_roi_check_iijs'];
		if($rchk['temp_roi_check_iijs']=="N"){
			echo "<script>alert('Not Allow'); window.location = 'my_dashboard.php';</script>";
		} */	
?>

<?php
$bp_number = getBPNO($_SESSION['USERID'],$conn);
if($_SESSION['COUNTRY']=="IN")
{
	$country="IN";
} else {
	$country=strtoupper($_SESSION['COUNTRY']);
}
	
$Action = $_REQUEST['Action'];
$action = @$_REQUEST['action'];
if($action=="Save")
{
	$Action=@$_REQUEST['Action'];
		$address1=$conn->real_escape_string($_REQUEST['address1']);
		$address2=$conn->real_escape_string($_REQUEST['address2']);
		$address3=$conn->real_escape_string($_REQUEST['address3']);
		$city=$conn->real_escape_string($_REQUEST['city']);
		$pincode=$conn->real_escape_string($_REQUEST['pincode']);
		$country=$conn->real_escape_string($_REQUEST['country']);
		$telephone_no= $conn->real_escape_string($_REQUEST['telephone_no']);
		$fax_no = $conn->real_escape_string($_REQUEST['fax_no']);
		$billing_address_id = $conn->real_escape_string($_REQUEST['billing_address_id']);
		if($billing_address_id=='')
			$billing_address_id=0;
		
		$get_billing_bp_number = getBPNObyID($conn->real_escape_string($_REQUEST['billing_address_id']),$conn);
		$billing_gstin = $conn->real_escape_string($_REQUEST['billing_gstin']);
		$billing_address1=$conn->real_escape_string($_REQUEST['baddress1']);
		$billing_address2=$conn->real_escape_string($_REQUEST['baddress2']);
		$billing_address3=$conn->real_escape_string($_REQUEST['baddress3']);		
		$bcity=$conn->real_escape_string($_REQUEST['bcity']);
		if($bpincode!='')
			$bpincode=$conn->real_escape_string($_REQUEST['bpincode']);
		else
			$bpincode=0;
		$btelephone_no=$conn->real_escape_string($_REQUEST['btelephone_no']);
	
	$company_name = $conn->real_escape_string(strtoupper($_REQUEST['company_name']));
	
	$membership_id = $conn->real_escape_string($_REQUEST['membership_id']);
	$membership_certificate_type = $conn->real_escape_string($_REQUEST['membership_certificate_type']);
	//$bp_number = filter($_REQUEST['bp_number']);
	$membership_date = $conn->real_escape_string($_REQUEST['membership_date']);
	$gst = strtoupper($_REQUEST['gst']);
	$kyc = $_REQUEST['kyc'];
	$pan_no = $conn->real_escape_string(strtoupper($_REQUEST['pan_no']));
	$tan_no = $conn->real_escape_string(strtoupper($_REQUEST['tan_no']));	
	$mobile = trim($_REQUEST['mobile']);	
	$email = $_REQUEST['email'];	
	$website = $conn->real_escape_string($_REQUEST['website']);
	$contact_person = $conn->real_escape_string(strtoupper($_REQUEST['contact_person']));
	$contact_person_desg = $conn->real_escape_string(strtoupper($_REQUEST['contact_person_desg']));   
	$contact_person_desg_show = strtoupper($_REQUEST['contact_person_desg_show']);
	$contact_person_co = strtoupper($_REQUEST['contact_person_co']);
	$contacts = $_REQUEST['contacts'];
	$participant_type = $_REQUEST['participant_type'];
	$region = $_REQUEST['region'];
	$created_date = date('Y-m-d');
	$company_type = $conn->real_escape_string($_REQUEST['company_type']);   
	$iec_number = $conn->real_escape_string($_REQUEST['iec_number']);   
	$dir_name = $conn->real_escape_string($_REQUEST['dir_name']);   
	$din_number = $conn->real_escape_string($_REQUEST['din_number']);   
	$is_cin = $conn->real_escape_string($_REQUEST['is_cin']);   
	$cin_number = $conn->real_escape_string($_REQUEST['cin_number']);   
	$cast = $conn->real_escape_string($_REQUEST['cast']);   
	
	/* Validation Start */
	$flag=1;
	if(empty($company_name)){
	$companyNameError = "Company Name should not be blank"; $flag=0;
	} else {
	$company_name = filter($company_name); // check name only contains letters and whitespace
	}
	
	if($_SESSION['COUNTRY']=="IN")
	{
		if($_SESSION['member_type']=="MEMBER")
		{
			if(empty($membership_id)){	$membershipIDError = "Membership ID should not be blank"; $flag=0;}
			
			if(empty($gst)){
			$gstNameError = "Please Enter GST No"; $flag=0;
			} else {
			$gst = filter($gst); // check name only contains letters and whitespace
			/*if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-5])([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}([a-zA-Z0-9]){1}([a-zA-Z]){1}([0-9]){1}?$/", $gst)) {
			$gstNameError = "Please Enter Valid GSTIN No."; $flag=0;
			} */	}
			
			if(empty($tan_no)){
			$tanNameError = "Please Enter TAN No"; $flag=0;
			} else {
			$tan_no = filter($tan_no); // check name only contains letters and whitespace
			/*if(!preg_match("/^[0-9]{10}$/",$tan_no)) {
			$tanNameError = "TAN No. must be exactly 10 digit"; $flag=0;
			}*/ }
			
			if(empty($region)){	$regionError = "Choose Region"; $flag=0;}
			if(empty($billing_address_id)){	$billing_addressError = "Choose Billing Address"; $flag=0;}
			if(empty($billing_gstin)){	$billing_gstinError = "Enter GSTIN"; $flag=0;}
		} else {
			if(empty($gst)){
			$gstNameError = "Please Enter GST No"; $flag=0;
			} else {
			$gst = filter($gst); // check name only contains letters and whitespace
			/*if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-5])([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}([a-zA-Z0-9]){1}([a-zA-Z]){1}([0-9]){1}?$/", $gst)) {
			$gstNameError = "Please Enter Valid GSTIN No."; $flag=0;
			} */	}
			
			if(empty($tan_no)){
			$tanNameError = "Please Enter TAN No"; $flag=0;
			} else {
			$tan_no = filter($tan_no); // check name only contains letters and whitespace
			/*if(!preg_match("/^[0-9]{10}$/",$tan_no)) {
			$tanNameError = "TAN No. must be exactly 10 digit"; $flag=0;
			}*/ }
			
			if(empty($region)){	$regionError = "Choose Region"; $flag=0;}
		}
	}
	
	
	if(empty($email)){
	$emailError ="Please Enter Email"; $flag=0;
	}else {
	$email = filter($email);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	$emailError = "Please Enter Valid Email"; $flag=0;
	} }	
	
	if(empty($contact_person_co)){
	$contactPersonError = "Contact Person should not be blank"; $flag=0;
	} else {
	$contact_person_co = filter($contact_person_co); // check name only contains letters and whitespace
	if(!preg_match("/^[a-zA-Z. ]*$/",$contact_person_co)) {
	$contactPersonError = "Please Enter Contact Person Name"; $flag=0;
	} }
	
	if(empty($contact_person_desg_show)){
	$contactDesignationError = "Designation should not be blank"; $flag=0;
	} else {
	$contact_person_desg_show = filter($contact_person_desg_show); // check name only contains letters and whitespace
	if(!preg_match("/^[a-zA-Z ]*$/",$contact_person_desg_show)) {
	$contactDesignationError = "Please Enter Designation"; $flag=0;
	} }
	
	if(empty($mobile)){
	$mobileError = "Mobile No should not be blank"; $flag=0;
	} else {
	$mobile = filter($mobile); // check name only contains letters and whitespace
	if(!preg_match("/^[0-9]{10}$/",$mobile)) {
	$mobileError = "Mobile No must be exactly 10 digit"; $flag=0;
	} }
	
	if(empty($contacts)){
	$contactsError = "Mobile No should not be blank";  $flag=0;
	} else {
	$contacts = filter($contacts); // check name only contains letters and whitespace
	if(!preg_match("/^[0-9]{10}$/",$contacts)) {
	$contactsError = "Mobile No must be exactly 10 digit"; $flag=0;
	} }

	if($_SESSION['COUNTRY']=="IN")
	{
	if(empty($company_type)){
		$company_typeError = "Select Company Type";  $flag=0;
	}else{
		// if($company_type =="Pvt Ltd"){
		// 	if(empty($din_number)){
		// 		$din_numberError = "Enter DIN No of Director";  $flag=0;
		// 	}

		// }else if($company_type !="Proprietor"){
		// 	if(empty($cin_number)){
  //               $cin_numberError = "CIN Number is required";  $flag=0;
  //           }
		// }
	}
	if(empty($dir_name)){
		$dir_nameError = "Director /Proprietor /Partner Name is required";  $flag=0;
	}
	if(empty($iec_number)){
		$iec_numberError = "IEC Number is required";  $flag=0;
	}



	if(empty($cast)){
		$castError = "Select Whether belongs to";  $flag=0;
	}

	}


//	echo '----'.$flag;
	//if($flag==1) { echo 'ok'; exit; } else { echo 'not ok'; exit; }
	
	/* Validation End */
	if($flag==1) {
	if(empty($companyNameError) && empty($emailError) && empty($contactPersonError) && empty($contactDesignationError) && empty($mobileError) && empty($contactsError) && empty($company_typeError) && empty($din_numberError) && empty($dir_nameError) && empty($iec_numberError)  && empty($cin_numberError) && empty($castError))
	{

	 $generalInfo = array('address1'=>$address1,'address2'=>$address2,'address3'=>$address3,'city'=>$city,'pincode'=>$pincode,'country'=>$country,'telephone_no'=>$telephone_no,'fax_no'=>$fax_no,'bp_number'=>$bp_number,'billing_address_id'=>$billing_address_id,'get_billing_bp_number'=>$get_billing_bp_number,'billing_gstin'=>$billing_gstin,'billing_address1'=>$billing_address1,'billing_address2'=>$billing_address2,'billing_address3'=>$billing_address3,'bcity'=>$bcity,'bpincode'=>$bpincode,'btelephone_no'=>$btelephone_no,'membership_id'=>$membership_id,'company_name'=>$company_name,'membership_date'=>$membership_date,'gst'=>$gst,'kyc'=>$kyc,'pan_no'=>$pan_no,'tan_no'=>$tan_no,'mobile'=>$mobile,'email'=>$email,'membership_certificate_type'=>$membership_certificate_type,'website'=>$website,'contact_person'=>$contact_person,'contact_person_desg'=>$contact_person_desg,'contact_person_desg_show'=>$contact_person_desg_show,'contact_person_co'=>$contact_person_co,'contacts'=>$contacts,'participant_type'=>$participant_type,'region'=>$region,'event_for'=>$event_for,"company_type"=>$company_type,"iec_number"=>$iec_number,"dir_name"=>$dir_name,"din_number"=>$din_number,"cin_number"=>$cin_number,"cast"=>$cast);
	 $_SESSION['generalInfo'] =$generalInfo; 	
	 // $gid=$conn->insert_id;
     header('location:exhibitor_registration_step_2.php');
	
	// print_r($generalInfo);exit;
	
	} else { 

		$signup_error = "Something wrong in Form Registration. Please register with correct values."; 
	}
	} else { 
		$signup_error = "Something wrong in Form Registration. Please register with correct values.."; 
	}

}
?>
<?php 
   /*.......................Basic Information From Registration ..................................*/
    $sqlApl="select membership_certificate_type from approval_master where registration_id='$registration_id'";
	$queryApl=$conn->query($sqlApl);
	$resultApl=$queryApl->fetch_assoc();
	$membership_certificate_type = $resultApl['membership_certificate_type'];
	$msme_ssi_status = chk_msme($registration_id,$conn);
	if($msme_ssi_status =='Yes'){ $membership_certificate_type = "MSME"; }
	
	//echo $msme_ssi_status = $resultApl['msme_ssi_status'];
	//if($membership_certificate_type ==''){ }
		
	$registration_id=intval($_SESSION['USERID']);
	$sql="select * from exh_reg_general_info where uid='$registration_id' and event_for='$event_for' order by id desc limit 0,1";
	$query=$conn->query($sql);
	$num=$query->num_rows;
	$result=$query->fetch_assoc();
	$id=$result['id'];
	if($num>0)
	{
		$email=$result['email'];
		$company_name=$result['company_name'];
		$address1=htmlentities(strip_tags($result['address1']));
		$address2=htmlentities(strip_tags($result['address2']));
		$address3=htmlentities(strip_tags($result['address3']));
		$billing_address_id=htmlentities(strip_tags($result['billing_address_id']));
		if($billing_address_id=="")
			$billing_address_id=0;
		$billing_bp_number=htmlentities(strip_tags($result['get_billing_bp_number']));
		$billing_gstin=htmlentities(strip_tags($result['billing_gstin']));
		$billing_address1=htmlentities(strip_tags($result['billing_address1']));
		$billing_address2=htmlentities(strip_tags($result['billing_address2']));
		$billing_address3=htmlentities(strip_tags($result['billing_address3']));		
		$bcity=htmlentities(strip_tags($result['bcity']));
		$bpincode=htmlentities(strip_tags($result['bpincode']));
		$bcountry=htmlentities(strip_tags($result['bcountry']));
		$btelephone_no=htmlentities(strip_tags($result['btelephone_no']));
		$bfax_no=htmlentities(strip_tags($result['bfax_no']));
		$billing_address_same=htmlentities(strip_tags($result['billing_address_same']));
		$pan_no=htmlentities(strip_tags($result['pan_no']));
		$tan_no=strtoupper($result['tan_no']);
		$city=$result['city'];
		$telephone_no=$result['telephone_no'];
		$mobile=$result['mobile'];
		$website=$result['website'];
		$fax_no=$result['fax_no'];
		$pincode=$result['pincode'];
		$gst=htmlentities(strip_tags($result['gst']));
		$tin=htmlentities(strip_tags($result['tin']));
		$kyc=htmlentities(strip_tags($result['kyc']));
		$website=$result['website'];
		$contact_person=$result['contact_person'];
		$contact_person_desg=$result['contact_person_desg'];
		$contact_person_desg_show=$result['contact_person_desg_show'];
		$contact_person_co=$result['contact_person_co'];
		$contacts=$result['contacts'];
		$region=$result['region'];
		$company_type=$result['company_type'];
		$dir_name=$result['dir_name'];
		$iec_number=$result['iec_number'];
		$din_number=$result['din_number'];
		$is_cin=$result['is_cin'];
		$cin_number=$result['cin_number'];
		$cast=$result['cast'];

	}	
	else
	{	
		/*..........................Get Company from registration...............................*/
		$cquery=$conn->query("select * from registration_master where id='$registration_id'");
		$cresult=$cquery->fetch_assoc();
		$company_name=$cresult['company_name'];		
		
		$company_address2 = htmlentities(strip_tags($cresult['address_line2']));
		$company_address3 = htmlentities(strip_tags($cresult['address_line3']));
		$company_pincode = str_replace(' ', '', $cresult['pin_code']);
		$company_city = $cresult['city'];
		$query1=$conn->query("select address1,address2,address3,pincode,city,pan_no,gst_no from communication_address_master where registration_id='$registration_id' and type_of_address='2'");
		$result1=$query1->fetch_assoc();
		$address1 = htmlentities(strip_tags(trim($result1['address1'])));
		$address2 = htmlentities(strip_tags(trim($result1['address2'])));
		$address3 = htmlentities(strip_tags(trim($result1['address3'])));
		$company_pan_no = strtoupper($result1['pan_no']);		
		$company_gstn = strtoupper($result1['gst_no']);
		$pincode = str_replace(' ', '', $result1['pincode']);
		$city=$result1['city'];
		
		/* For NonMember If Address No found */
		if(empty($address1)){ $address1 = htmlentities(strip_tags($cresult['address_line1'])); }
		if(empty($address2)){ $address2 = htmlentities(strip_tags($cresult['address_line2'])); }
		if(empty($address2)){ $address2 = htmlentities(strip_tags($cresult['address_line3'])); }
		if(empty($pincode)) { $pincode = str_replace(' ', '', $cresult['pin_code']); }
		if(empty($city))    { $city = $cresult['city']; }
				
		$sql="select * from information_master where registration_id='$registration_id'";
		$query=$conn->query($sql);
		$result=$query->fetch_assoc();
		$email=$result['email_id'];		
		$telephone_no=$result['land_line_no'];
		$mobile=$result['mobile_no'];
		$website=$result['website'];
		$fax_no=$result['fax_no'];		
		$tan_no=strtoupper($result['tan_no']);
		$website=$result['website'];
		$pan_no=$result['pan_no'];
		
		$contact_person = strtoupper($result['name']);
		$contact_person_desg=trim($result['designation']);	
		
		if($pan_no=="")
			$pan_no = $company_pan_no; 
		if($company_gstn=="" || $gst=="NA"){
			$gst=$result['gst_no'];
		}else{
			$gst=$company_gstn;
		}

		if($result['land_line_no']=='' || $result['land_line_no']=='0'){ $telephone_no = $cresult['land_line_no']; }  else { $telephone_no=$result['land_line_no']; }		
		
		if($contact_person_desg == "ZDIRCT"){ $contact_person_desg ="Director"; }
		if($contact_person_desg == "ZPARTN"){ $contact_person_desg ="Partner"; }
		if($contact_person_desg == "ZPROPT"){ $contact_person_desg ="Proprietor"; }
		if($contact_person_desg == "ZKARTA"){ $contact_person_desg ="Karta of HUF"; } 
		
		$region=$result['region_id'];		
	};
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Exhibitor Registration - General Information</title>
<link rel="icon" href="https://gjepc.org/assets/images/fav_icon.png" type="image/x-icon"/>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" /> 
<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>
<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />

<!--NAV-->
<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.flexnav.js?v=<?php echo $version;?>" type="text/javascript"></script>
<script src="js/common.js?v=<?php echo $version;?>"></script> 
<!--NAV-->

<!-- UItoTop plugin -->
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css?v=<?php echo $version;?>" />
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
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="css/rcmc.validation.css" /> 

<script type="text/javascript">
$().ready(function() {
	$("#commentForm").validate()
	
	jQuery.validator.addMethod("lettersonly", function(value, element) 
	{
	return this.optional(element) || /^[a-z. ]+$/i.test(value);
	}, "Letters and spaces only please");

	$("#form1").validate({
		rules: {
			gst: {
			required: true,
			minlength: 15,
			maxlength:15
			},
			tan_no: {
			required: true,
			minlength: 10,
			maxlength:10
			},
			pan_no: {
			required: true,
			minlength: 10,
			maxlength:10
			},
			address1: {
			required: true,
			},  
			city: {
				required: true,
			},  
			pincode: {
				required: true,
				number:true,
			}, 	 
			country: {
				required: true,
				},
			telephone_no:{
				required: true,
			},
			mobile: {
				required: true,
				number:true,
				minlength: 10,
				maxlength:10
			},
			email: {
				required: true,
				email:true
			},
			billing_address_id:{
				required:true,
			},
			billing_gstin:{
				required:true,
			},
			contact_person:{
				required:true,
				lettersonly: true,
			},
			contact_person_co:{
				required:true,
				lettersonly: true,
			},
			contact_person_desg:{
				required:true,
			},
			contact_person_desg_show:{
				required:true,
			},			
			contacts: {
				required: true,
				number:true,
				minlength: 10,
				maxlength:10
			},
			company_type:{
				required:true,
			},
			iec_number:{
				required:true,
			},
			din_number:{
				required:true,
			},
			cin_number:{
				required:true,
			},
			cast:{
				required:true,
			}
		},
		messages: {
			gst: {
				required: "Please Update GST No in Membership Portal",
				minlength:"Please Enter 15 digit.",
				maxlength:"Please Enter No more than 15 digit."
			},
			tan_no: {
				required: "Please Enter TAN No",
				minlength:"Please Enter 10 digit.",
				maxlength:"Please Enter No more than 10 digit."
			},
			pan_no: {
				required: "Please Enter PAN No",
				minlength:"Please Enter 10 digit.",
				maxlength:"Please Enter No more than 10 digit."
			},
			address1: {
				required: "Required",
			},  
			city: {
				required: "Required",
			},
			pincode:{
				required: "Required",
			} ,
			country: {
				required: "Required",
			},
		    telephone_no:{
		   		required: "Required",
			},
			mobile: {
				required:"Please Enter Mobile Number",
				number:"Please Enter Numbers only",
				minlength:"Please enter at least 10 digit.",
				maxlength:"Please enter no more than 0 digit."
			},   
		    email: {
				required: "Please Enter Email id",
				email:"Please enter valid email id"
			},
			billing_address_id: {
				required: "Please Choose Billing Address",
			},
			billing_gstin: {
				required: "Please Enter Billing GSTIN",
			},
			contact_person:{
				required: "Please Enter Contact Person",
				lettersonly:jQuery.format("Alphabets and spaces allow only"),
			},
			contact_person_co:{
				required: "Please Enter Contact Person Name",
				lettersonly:jQuery.format("Alphabets and spaces allow only"),
			},
			contact_person_desg:{
				required: "Please Enter Designation",
			},
			contact_person_desg_show:{
				required: "Please Enter Designation",
			},			
			contacts: {
				required:"Please Enter Mobile Number",
				number:"Please Enter Numbers only",
				minlength:"Please enter at least 10 digit.",
				maxlength:"Please enter no more than 0 digit."
			},
			company_type:{
				required:"Select company type",
			},
			iec_number:{
				required:"Enter IEC number",
			},
			dir_name:{
				required:"Enter Director/Proprietor/Partner Name",
			},
			din_number:{
				required:"Enter DIN Number",
			},
			cin_number:{
				required:"Enter CIN Number",
			},
			cast:{
				required:"Whether belongs to",
			}
	 }
	});
});
</script>
<!--
<script type="text/javascript">
function data_copy()
{
if(document.getElementById("form1").address[0].checked){
document.getElementById("baddress1").value=document.getElementById("address1").value;
document.getElementById("baddress2").value=document.getElementById("address2").value;
document.getElementById("baddress3").value=document.getElementById("address3").value;

document.getElementById("bcity").value=document.getElementById("city").value;
document.getElementById("bpincode").value=document.getElementById("pincode").value;
document.getElementById("bcountry").value=document.getElementById("country").value;
document.getElementById("btelephone_no").value=document.getElementById("telephone_no").value;
document.getElementById("bfax_no").value=document.getElementById("fax_no").value;
}else{
document.getElementById("baddress1").value="";
document.getElementById("baddress2").value="";
document.getElementById("baddress3").value="";
document.getElementById("bcity").value="";
document.getElementById("bpincode").value="";
document.getElementById("bcountry").value="";
document.getElementById("btelephone_no").value="";
document.getElementById("bfax_no").value="";
}
}
</script>
-->
<style type="text/css">
	.floatleft {
		width: 50%;
		float: left;
	}
	.floatright {
		width: 50%;
		float: left;
	}
	.field_box .field_name {
    width: 100% !important;
	} 
	.field_box .field_input input[type="number"] {
    width: 260px;
    height: auto;
    padding: 5px 4px;
	}
	input[type="radio" i] {
     margin: 0 5px 7px 0; 
    
}
</style>
<style>
.container_left1 {
    width: 900px;
    height: auto;
    float: left;
    text-align: justify;
}
#form1 label {
    min-width: 150px;
    display: block;
    float: left;
    /* font-weight: bold; */
    font-size: 12px;
    vertical-align: middle;
    padding-top: 5px;
    color: #ea0101;
}
#form1 .field_box {
    background: #ffffff;
    padding: 3px 20px 3px 20px;
    margin-bottom: 1px;
    float: left;
}
.form_title {
    margin-top: 15px;
    margin-left: 20px;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	// $("#din_number_div").slideUp();
	// $("#cin_number_div").slideUp();
	$("#company_type").change(function(){
		var company_type = $(this).val();
		if(company_type =="Pvt Ltd" || company_type =="Public Limited" ){
			$("#din_number_div").slideDown();
		    $("#din_number").removeAttr("disabled");
		    $("#cin_label").html("CIN Number <span>*</span>:");
		}else if(company_type =="Partnership" || company_type =="LLP" ){
			$("#din_number_div").slideUp();

			$("#din_number").attr("disabled", "disabled"); 
			$("#cin_label").html("Registration Number <span>*</span>:");
		}else if(company_type =="Proprietor" ){
			$("#din_number_div").slideUp();
            $("#din_number").attr("disabled", "disabled"); 
            $("#cin_label").html("Registration Number <span>*</span>:");
		}



	});

		$('#billing_address_id').change(function(){
				//alert($( this ).val());
				var option = $(this).val();
			
			  $.ajax({ type: 'POST',
					url: 'ajax_get_child_address.php',
					data: "actiontype=optionValue&&option="+option,
					dataType:'html',
					beforeSend: function(){
						$('#preloader').show();
						$('#status').show();
							},
					success: function(data){
						//alert(data);
						 if($.trim(data)!=""){
							  $('#preloader').hide();
							  $('#status').hide();
							 //$('#selected_area').html(data);
							 data=data.split("#");
							   $("#baddress1").val(data[0]);
							   $("#baddress2").val(data[1]);
							   $("#baddress3").val(data[2]);
							   $("#bcity").val(data[3]);
							   $("#bpincode").val(data[4]);
							   $("#btelephone_no").val(data[5]);							 
							   $("#billing_bp_number").val(data[6]);
							   $("#billing_gstin").val(data[7]);
						 }
					}
		});
	});
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
<div id="preloader">
    <div id="status"> <img src="https://www.gjepc.org/assets/images/logo.png"></div>
</div>

<div class="clear"></div>   
<div class="inner_container">
    <div class="clear"></div>    
    
    <div class="pg_title">    
    <div class="title_cont">
        <span class="top">Exhibitor <img src="images/titles/joint.png" style="position:absolute; top:31px; right:0px;" /></span>   
        <span class="below">Registration</span>
        <div class="clear"></div>
    </div>
    </div> 
    <div class="clear"></div>    
	
    <div class="form_main">
		<div class="d-flex flex-row justify-center form-group m-10 form-tab">
			<label class="container_radio"><span class="check_text"></span>
			  <input type="radio" disabled="disabled" >
			  <span class="checkmark_radio"></span>
			</label>
			<label class="container_radio"><span class="check_text"></span>
			  <input type="radio" checked="checked" disabled="disabled" >
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
			  <input type="radio" disabled="disabled">
			  <span class="checkmark_radio"></span>
			</label>
		</div>
        <div class="title"><h4 style="padding:10px 15px;text-align: center; color: #fff; display: table; background: #00000099; margin: 20px auto; border: 1px solid#000; -webkit-box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); -moz-box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); border-radius: 6px;">GENERAL INFORMATION</h4></div>
   	
    <div class="form_title"><?php if(isset($signup_error) ){ echo '<span style="color: red;" />'.$signup_error.'</span>';} ?></div>

    <form class="cmxform" method="post" name="from1" id="form1"/>
    	<div class="container_left1">

    	<div class="floatleft">	
        <div class="field_box">
            <div class="field_name">Company Name :</div>
            <div class="field_input">
              <input type="text" class="uneditable" id="company_name" name="company_name" value="<?php echo stripcslashes(strtoupper($company_name));?>" readonly="readonly"/>
            </div>
			<?php if(isset($companyNameError)){ echo '<span style="color: red;" />'.$companyNameError.'</span>';} ?>
            <div class="clear"></div>
        </div>        
        </div>        
		<?php if($_SESSION['COUNTRY']=="IN"){ ?>
		<?php if($_SESSION['member_type']=="MEMBER"){?>
		<div class="floatright">			
		<div class="field_box">
        <div class="field_name">Membership ID :</div>
            <div class="field_input"><input type="text" class="uneditable" id="membership_id" name="membership_id" value="<?php echo getMembershipId($_SESSION['USERID'],$conn);?>" readonly="readonly"/></div>
			<?php if(isset($membershipIDError) ){ echo '<span style="color: red;" />'.$membershipIDError.'</span>';} ?>
            <div class="clear"></div>
        </div>    
        </div> 
		<?php } ?>
        <div class="floatleft">	   
        <div class="field_box">
            <div class="field_name">Membership Status:</div>
            <div class="field_input"><input type="text" class="uneditable" id="membership_date" name="membership_date" value="<?php echo $_SESSION['member_type'];?>" readonly="readonly"/></div>
            <div class="clear"></div>
        </div>
        </div>
		<div class="floatright">
		<div class="field_box">
            <div class="field_name">GSTIN No. :</div>
			<div class="field_input">
            <input name="gst" id="gst" type="text" <?php if($_SESSION['member_type']=="MEMBER"){?>class="uneditable" readonly <?php } ?> value="<?php echo $gst;?>" maxlength="15" />
            </div><?php if(isset($gstNameError) ){ echo '<span style="color: red;" />'.$gstNameError.'</span>';} ?>
			<div class="clear"></div>
		</div>
		</div>
		<div class="floatleft">	
		<div class="field_box">
            <div class="field_name">COMPANY PAN No:</div>
			<div class="field_input">
            <input name="pan_no" id="pan_no" type="text" <?php if($_SESSION['member_type']=="MEMBER"){?>class="uneditable" readonly <?php } ?> value="<?php echo $pan_no;?>" maxlength="10" />
			</div>
            <div class="clear"></div>
		</div>	  
		</div>
		<?php if($_SESSION['member_type']=="MEMBER" && $_SESSION['COUNTRY']=="IN"){ ?>
		<div class="floatright">	
		<div class="field_box">
            <div class="field_name">H.O. BP NO :</div>
            <div class="field_input">
              <input name="bp_number" id="bp_number" type="text" class="uneditable" value="<?php echo getBPNO($_SESSION['USERID'],$conn);?>" readonly="readonly"/>
            </div>
            <div class="clear"></div>
        </div>    
        </div> 
		<div class="floatleft">	
		<div class="field_box">
            <div class="field_name">Membership Type :</div>
			<div class="field_input">
            <input name="membership_certificate_type" id="membership_certificate_type" type="text" <?php if($_SESSION['member_type']=="MEMBER"){?>class="uneditable" readonly <?php } ?> value="<?php echo $membership_certificate_type;?>"/>
			</div>
            <div class="clear"></div>
		</div>	  
		</div>
		<?php } ?>
		<div class="floatleft">	
		<div class="field_box">
            <div class="field_name">TAN No. <span>*</span> :</div>
			<div class="field_input">
            <input name="tan_no" id="tan_no" type="text" class="textField" value="<?php echo $tan_no;?>" maxlength="10" autocomplete="off"/>
			</div>
			<?php if(isset($tanNameError) ){ echo '<span style="color: red;" />'.$tanNameError.'</span>';} ?>
            <div class="clear"></div>
		</div>	  
		</div>
		 		 
	<?php } else { ?>
	<div class="floatleft">	   
        <div class="field_box">
            <div class="field_name">Membership Type :</div>
            <div class="field_input"><input type="text" class="uneditable" id="membership_date" name="membership_date" value="<?php echo $_SESSION['member_type'];?>" readonly="readonly"/></div>
            <div class="clear"></div>
        </div>
        </div>
	<?php } ?>
	<div class="clear"></div>
	<div class="clearfix"></div>
<?php if($_SESSION['COUNTRY']=="IN"){ ?>
	<div class="floatleft">	
	<div class="field_box">
			<div class="field_name">Company Type <span>*</span> :</div>
			<div class="field_input">
				<select name="company_type" id="company_type" class="textField valid">
				<option value=""  selected="selected">-- Select Company Type</option>
				<option value="Pvt Ltd" <?php if( $company_type =="Pvt Ltd"){echo "selected";}?> >Pvt Ltd </option>
				<option value="Proprietor" <?php if( $company_type =="Proprietor"){echo "selected";}?>>Proprietor</option>
				<option value="Partnership" <?php if( $company_type =="Partnership"){echo "selected";}?>>Partnership </option>
				<option value="LLP" <?php if( $company_type =="LLP"){echo "selected";}?>>LLP </option>
				<option value="Public Limited" <?php if( $company_type =="Public Limited"){echo "selected";}?>>Public Limited </option>
			   </select>
			</div>
		</div>
	</div>
	
	<div class="floatright">	
	<div class="field_box">
			<div class="field_name">IEC Number <span>*</span> :</div>
			<div class="field_input">
				<input type="text" class="" id="iec_number" name="iec_number" value="<?php echo $iec_number;?>" maxlength="10"/>
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<div class="clearfix"></div>
	<div class="floatleft">	
	<div class="field_box">
			<div class="field_name">Director /Proprietor /Partner Name(Any One)<span>*</span> :</div>
			<div class="field_input">
				<input type="text" class="" id="dir_name" name="dir_name" value="<?php echo $dir_name;?>" />
			</div>
		</div>
	</div>
	<div class="floatright" id="din_number_div">	
	<div class="field_box">
			<div class="field_name">DIN No of Director <span>*</span> :</div>
			<div class="field_input">
				<input type="text" class="" id="din_number" name="din_number" value="<?php echo $din_number;?>" />
			</div>
		</div>
	</div>

	<div class="clear"></div>
	<div class="clearfix"></div>
	
	<div class="floatright" id="cin_number_div">	
	<div class="field_box">
			<div class="field_name" id="cin_label"> CIN Number/Registration Number) <span>*</span> :</div>
			<div class="field_input">
				<input type="text" class="" id="cin_number" name="cin_number" value="<?php echo $cin_number;?>" />
			</div>
		</div>
	</div>

	<div class="floatright">	
	<div class="field_box">
			<div class="field_name">Whether belongs to*<span>*</span> :</div>
			<div class="field_input">
				<span style="color: #000;display: inline-block; margin-right: 10px"><input type="radio" class="uneditable" id="cast" name="cast" <?php if($cast=="SC"){echo "checked";};?>  value="SC " /> <span style="padding-top: 5px">SC</span> </span>
				<span style="color: #000;display: inline-block; margin-right: 10px"><input type="radio" class="uneditable" id="cast" name="cast" <?php if($cast=="NT"){echo "checked";};?>  value="NT" /><span style="padding-top: 5px">NT</span></span>
				<span style="color: #000;display: inline-block; margin-right: 10px"><input type="radio" class="uneditable" id="cast" name="cast" <?php if($cast=="General"){echo "checked";};?>  value="General" /><span style="padding-top: 5px">General</span></span>
				<label for="cast" style="display: none;" generated="true" class="error"></label>
			</div>
		</div>
	</div>
	<?php } ?>

	<div class="clear"></div>
	<div class="clearfix"></div>


    <div class="form_title">OFFICE ADDRESS</div>
		<div class="floatleft">
        <div class="field_box">
            <div class="field_name">Address 1 <span>*</span> :</div>
            <div class="field_input"><input type="text" id="address1" name="address1" <?php if($_SESSION['member_type']=="MEMBER"){?> class="uneditable" readonly <?php } else { ?> class="textField" <?php } ?> value="<?php echo $address1;?>" autocomplete="off"/></div>
            <div class="clear"></div>
        </div>  
		<div class="field_box">
            <div class="field_name">Address 3 :</div>
            <div class="field_input"><input type="text" id="address3" name="address3" <?php if($_SESSION['member_type']=="MEMBER"){?> class="uneditable" readonly <?php } else { ?> class="textField" <?php } ?> value="<?php echo $address3;?>"  autocomplete="off"/></div>
            <div class="clear"></div>
        </div> 
        <div class="field_box">
            <div class="field_name">Pincode <span>*</span> :</div>
            <div class="field_input"><input type="number" id="pincode" name="pincode" <?php if($_SESSION['member_type']=="MEMBER"){?> class="uneditable" readonly <?php } else { ?> class="textField" <?php } ?> value="<?php echo $pincode;?>" onKeyPress="if(this.value.length==10) return false;" autocomplete="off"/></div>
            <div class="clear"></div>
        </div> 
        <div class="field_box">
            <div class="field_name">Telephone No. <span>*</span> :</div>
            <div class="field_input"><input type="text" class="textField" id="telephone_no" name="telephone_no" value="<?php echo $telephone_no;?>" autocomplete="off"/></div>
            <div class="clear"></div>
        </div>
        </div>   

        <div class="floatright">	 
        <div class="field_box">
            <div class="field_name">Address 2 :</div>
            <div class="field_input"><input type="text" id="address2" name="address2" <?php if($_SESSION['member_type']=="MEMBER"){?> class="uneditable" readonly <?php } else { ?> class="textField" <?php } ?> value="<?php echo $address2;?>" autocomplete="off"/></div>
            <div class="clear"></div>
        </div>	
		<div class="field_box">
	        <div class="field_name">City <span>*</span> :</div>
	        <div class="field_input"><input type="text" id="city" name="city" <?php if($_SESSION['member_type']=="MEMBER"){?> class="uneditable" readonly <?php } else { ?> class="textField" <?php } ?> value="<?php echo $city;?>" autocomplete="off"/></div>
	        <div class="clear"></div>
	    </div>    	
		<div class="field_box">
			<div class="field_name">Country <span>*</span> :</div>
			<div class="field_input">
				<select name="country" id="country" class="textField">
				<?php
				if($country=="IN")
				$sql="SELECT * FROM country_master where country_code='IN'";
				else
				$sql="SELECT * FROM country_master where country_code!='IN'";
				$query=$conn->query($sql);
				while($result=$query->fetch_assoc()){
				?>				
				<option value="<?php echo $result['country_code'];?>" <?php if($result['country_code']==$country){?> selected="selected" <?php } else if($result['country_code']=="IN"){?> selected="selected"<?php }?>><?php echo strtoupper($result['country_name']);?></option>
				<?php }?>
				</select>
			</div>
		</div>	
		<div class="field_box">
		    <div class="field_name">Fax No. :</div>
		    <div class="field_input"><input type="text" class="textField" id="fax_no" name="fax_no" value="<?php echo $fax_no;?>" autocomplete="off"/></div>
		    <div class="clear"></div>
	    </div>
	    </div>
		<div class="floatleft">	
			<div class="field_box">
				<div class="field_name">Email <span>*</span> :</div>
				<div class="field_input"><input type="text" class="textField" id="email" name="email" value="<?php echo $email;?>" /></div>
				<div class="clear"></div>
			</div>   
	        <div class="field_box">
		        <div class="field_name">Contact Person <span>*</span> :</div>
		        <div class="field_input"><input type="text" class="textField" id="contact_person" name="contact_person" value="<?php echo $contact_person;?>" /></div>
		        <div class="clear"></div>
	        </div>				
			<div class="field_box">
		        <div class="field_name">Designation:</div>
		        <div class="field_input"><input type="text" class="textField" id="contact_person_desg_show" name="contact_person_desg_show" value="<?php echo $contact_person_desg_show;?>" maxlength="25"/></div>
		        <div class="clear"></div>
	        </div>	
			<div class="field_box">
		        <div class="field_name">Mobile No <span>*</span> :</div>
		        <div class="field_input"><input type="text" class="textField" id="mobile" name="mobile" value="<?php echo $mobile;?>" onKeyPress="if(this.value.length==10) return false;"/></div>
		        <div class="clear"></div>
	        </div>
			<div class="field_box">
			<div class="field_name">Select Region :</div>
			<div class="field_input">
			<select class="bgcolor" disabled="disabled">
			<option value="">--- Select ---</option>
			<?php if($_SESSION['COUNTRY']=="IN" && $_SESSION['member_type']=="MEMBER"){
			$sql3="SELECT * FROM `region_master` WHERE 1 and `status`='1'";  
			$result3=$conn->query($sql3);
			while($rows3=$result3->fetch_assoc())
			{ ?>
			<option value="<?php echo $rows3['region_name'];?>" <?php if($rows3['region_name']==$region){?> selected="selected" <?php }?> ><?php echo $rows3['region_full_name'];?></option>
			<?php } } else if($_SESSION['COUNTRY']=="IN" && $_SESSION['member_type']=="NON_MEMBER"){
				 echo $region ='HO-MUM (M)';?>            
			<option value="<?php echo $region; ?>" selected="selected">HEAD OFFICE - MUMBAI</option>        
			<?php } else { echo $region ='HO-MUM (M)';?>            
			<option value="<?php echo $region; ?>" selected="selected">HEAD OFFICE - MUMBAI</option>        
			<?php } ?>
			</select>
			<input type="hidden" name="region" id="region" value="<?php echo $region; ?>"/>
			</div>
			<div class="clear"></div><?php if(isset($regionError) ){ echo '<span style="color: red;" />'.$regionError.'</span>';} ?>
			</div>						
		</div>	

		<div class="floatright">
	        <div class="field_box">
		        <div class="field_name">Website :</div>
		        <div class="field_input"><input type="text" class="textField" id="website" name="website" value="<?php echo $website;?>" /></div>
		        <div class="clear"></div>
	        </div>	
			<div class="field_box">
		        <div class="field_name">Contact Person For Show Co Ordination:</div>
		        <div class="field_input"><input type="text" class="textField" id="contact_person_co" name="contact_person_co" value="<?php echo $contact_person_co;?>" maxlength="25"/></div>
		        <div class="clear"></div>
	        </div>
			<div class="field_box">
		        <div class="field_name">Designation:</div>
		        <div class="field_input"><input type="text" class="textField" id="contact_person_desg" name="contact_person_desg" value="<?php echo $contact_person_desg;?>" maxlength="25"/></div>
		        <div class="clear"></div>
	        </div>		
			<div class="field_box">
		        <div class="field_name">Mobile No <span>*</span> :</div>
		        <div class="field_input"><input type="text" class="textField" id="contacts" name="contacts" value="<?php echo $contacts;?>" onKeyPress="if(this.value.length==10) return false;"/></div>
		        <div class="clear"></div>
	        </div>			
		</div>
		<!------------------------------------ Start Billing Address ------------------------------------------->
		<?php if($_SESSION['COUNTRY']=="IN" && $_SESSION['member_type']=="MEMBER"){ ?>
			
		<div class="clear"></div>	
		<div class="field fullclass"><b>Choose Your Billing Address</b> 
			<select name="billing_address_id" id="billing_address_id" class="bgcolor">
			<option value="">--- Choose Billing Address ---</option>
            <?php
			$commAddress2 = "SELECT * FROM `communication_address_master` WHERE `registration_id` = '$registration_id' AND address_identity='CTC' AND c_bp_number!='' AND pan_no!=''";
			$result2 = $conn->query($commAddress2);
			while($addChild = $result2->fetch_assoc()){ ?>
			<option value="<?php echo $addChild['id'];?>" <?php if($billing_address_id == $addChild['id']) echo 'selected="selected"';?>>
			<?php echo $addChild['address1'].'-'.$addChild['city'];?></option>			
            <?php } ?>
			</select>
			<?php if(isset($billing_addressError)){ echo '<span style="color: red;" />'.$billing_addressError.'</span>';} ?>
		<div class="clear"></div>
		</div>
		<div class="clear"></div>
		
		<div class="floatleft">
		<div class="field_box">
            <div class="field_name">Billing GSTIN : <span>*</span> :</div>
            <div class="field_input"><input type="text" class="textField" id="billing_gstin" name="billing_gstin" value="<?php echo $billing_gstin;?>" maxlength="15" minlength="15" autocomplete="off"/></div>
            <div class="clear"></div><?php if(isset($billing_gstinError) ){ echo '<span style="color: red;" />'.$billing_gstinError.'</span>';} ?>
        </div>
		
		<div class="field_box">
            <div class="field_name">Address 2 :</div>
            <div class="field_input"><input type="text" class="textField" id="baddress2" name="baddress2" value="<?php echo $billing_address2;?>" readonly/></div>
            <div class="clear"></div>
        </div>			
		<div class="field_box">
            <div class="field_name">Pincode <span>*</span> :</div>
            <div class="field_input"><input type="number" class="textField" id="bpincode" name="bpincode" value="<?php echo $bpincode;?>" autocomplete="off" onKeyPress="if(this.value.length==9) return false;" readonly/></div>
            <div class="clear"></div>
        </div>	
		<div class="field_box">
            <div class="field_name">Telephone No. <span>*</span> :</div>
            <div class="field_input"><input type="text" class="textField" id="btelephone_no" name="btelephone_no" value="<?php echo $btelephone_no;?>" readonly/></div>
            <div class="clear"></div>
        </div>		
        </div> 		
		<div class="floatright">
		<div class="field_box">
            <div class="field_name">Billing BP :</div>
            <div class="field_input"><input type="text" class="textField" id="billing_bp_number" id="billing_bp_number" value="<?php echo $billing_bp_number;?>" readonly/></div>
            <div class="clear"></div>
        </div>
        <div class="field_box">
            <div class="field_name">Address 1 <span>*</span> :</div>
            <div class="field_input"><input type="text" class="textField" id="baddress1" name="baddress1" value="<?php echo $billing_address1;?>" readonly/></div>
            <div class="clear"></div>
        </div>
		<div class="field_box">
            <div class="field_name">Address 3 :</div>
            <div class="field_input"><input type="text" class="textField" id="baddress3" name="baddress3" value="<?php echo $billing_address3;?>" readonly/></div>
            <div class="clear"></div>
        </div>
		<div class="field_box">
            <div class="field_name">City :</div>
            <div class="field_input"><input type="text" class="textField" id="bcity" name="bcity" value="<?php echo $bcity;?>" autocomplete="off" readonly/></div>
            <div class="clear"></div>
        </div>		
        </div>
		<div class="clear"></div>
		<?php } ?>
		<!------------------------------------ End Billing Address ------------------------------------------> 		
		
        <div class="clear"></div>
			<div class="field_box">
	        <div class="field_name"></div>
	        <div class="field_input">
	        <a href="event_selection.php" class="button">Prev</a>
	        <input type="submit" class="button" value="Proceed to Next Step" />
	        <input type="hidden" name="action" id="action" value="Save"/>
	        <input type="hidden" name="Action" id="Action" value="<?php echo $Action?>"/>
	        </div>
	        <div class="clear"></div>
	        </div>
        </div>		
        <div class="clear" style="height:10px;"></div>       
		  
    <div class="clear"></div>
	<!-------------- FORM ENDS ------------>
	</div>
	</form>	 
	</div>
	</div>
     
    <div class="clear"></div>
	</div>

<div class="clear" style="height:10px;"></div>
</div>

<div class="footer">
	<?php include('footer.php'); ?>
<div class="clear"></div>
</div>

<div class="clear"></div>
</div>

</body>
</html>