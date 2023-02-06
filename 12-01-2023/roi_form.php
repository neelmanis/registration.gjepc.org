<?php 
include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit;	}
$registration_id=$_SESSION['USERID'];

if($_SESSION['eventInfo']['event_selected']=="signature"){ $event_for="IIJS SIGNATURE 2022"; } 
if($_SESSION['eventInfo']['event_selected']=="iijs") { $event_for="IIJS 2021"; }
?>
<?php
$bp_number = getBPNO($_SESSION['USERID'],$conn);
if($_SESSION['COUNTRY']=="IN")
{
	$country="IN";
} else {
	$country=strtoupper($_SESSION['COUNTRY']);
}
	
$action = $_REQUEST['action'];
if($action=="Save")
{
		$registration_id=$_POST['registration_id'];
		$company_name=getCompanyName($registration_id,$conn);
		$event_name=$_POST['event_name'];
		$eventDescription=getExhRoi_desc($event_name,$conn);
		$member_type=$_POST['member_type'];
		$prefered_city = $conn->real_escape_string(strtoupper($_REQUEST['prefered_city']));
		$contact_person_name = $conn->real_escape_string(strtoupper($_REQUEST['contact_person']));
		$contact_person_designation = $conn->real_escape_string(strtoupper($_REQUEST['contact_person_desg_show']));   
		$contact_person_email = $conn->real_escape_string($_REQUEST['email']);
		$contact_person_mobile_no = $conn->real_escape_string($_REQUEST['mobile_no']);
		$office_address = $conn->real_escape_string($_REQUEST['office_address']);
		
		$billing_address_id = $conn->real_escape_string($_REQUEST['billing_address_id']);
		if($billing_address_id=='')
			$billing_address_id=0;
		
		$billing_gstin = $conn->real_escape_string($_REQUEST['billing_gstin']);	
		$section=$_POST['section'];
		$selected_area=$_POST['selected_area'];
		$tot_space_cost_rate = $_REQUEST['tot_space_cost_rate'];
		$govt_service_tax = $_REQUEST['govt_service_tax'];
		$grand_total = $_REQUEST['grand_total'];
		
		$post_date=date('Y-m-d');
	/*............................................Already applied status.......................................................*/	
	$query=$conn->query("select * from roi_space_registration where registration_id='$registration_id' and event_name='$event_name'");
	$num=$query->num_rows;
	if($num>0){
		$_SESSION['error_msg']="You have already showed your interest for this show.";
		echo '<script type="text/javascript">'; 
		echo 'alert("You have already showed your interest for this show.");'; 
		echo 'window.location.href = "my_dashboard.php";';
		echo '</script>';
		exit;
	}else{
	$sql="insert into roi_space_registration set registration_id='$registration_id',member_type='$member_type',event_name='$event_name',contact_person_name='$contact_person_name',contact_person_designation='$contact_person_designation',contact_person_email='$contact_person_email',contact_person_mobile_no='$contact_person_mobile_no',office_address='$office_address',billing_address_id='$billing_address_id',billing_gstin='$billing_gstin',prefered_city='$prefered_city',section='$section',selected_area='$selected_area',tot_space_cost_rate='$tot_space_cost_rate',govt_service_tax='$govt_service_tax',grand_total='$grand_total',post_date='$post_date'";
		
		if(!$conn->query($sql)){
			$_SESSION['error_msg']="There is something wrong. Please contact with admin";
		}else{
			$_SESSION['succ_msg']="You have successfully submitted! Thank you for showing your interest";
		/*.......................................Send mail to users mail id...............................................*/
			$message ='<table cellpadding="10" width="100%" style="margin:0px auto;font-family: Roboto; background-color:#eeee;padding:30px; border-collapse:collapse;">
			
			<tr>
				<td align="left"><img src="https://gjepc.org/assets/images/logo.png"> </td>
				<td align="right"><img src="https://registration.gjepc.org/images/IIJS_Tritiya_2022_logo.png"> </td>
			</tr>
			
			<tr>
			<td>Dear '.$contact_person_name.' , </td>
			<td>&nbsp;</td>
			</tr>
			<tr style="background-color:#eeee;padding:30px;">
				<td><h4 style="margin:0;">Thank you for Showing your interest in '.$eventDescription.'- ROI application</h4></td>
			</tr>
			
			<tr>
			<td colspan="2">
				<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; float:left;">
					<tr>
						<td colspan="2" style="color:#14b3da;"><strong>Application Summary</strong></td></tr>
						
						
					<tr>
						<td width="35%"><strong>Company Name </strong></td>
						<td width="65%">'.$company_name.'</td>
					</tr>
					<tr>
						<td width="35%"><strong>Section </strong></td>
						<td width="65%">'.$section.'</td>
					</tr>
					<tr>
						<td width="35%"><strong>Selected Area </strong></td>
						<td width="65%">'.$selected_area.'</td>
					</tr>
					<tr bgcolor="red">
						<td width="35%"><strong>Advance Amount @ Rs. 5000 per sqm</strong></td>
						<td width="65%">'.$tot_space_cost_rate.'</td>
					</tr>
					<tr bgcolor="red">
						<td width="35%"><strong>GST @18% </strong></td>
						<td width="65%">'.$govt_service_tax.'</td>
					</tr>
					<tr bgcolor="red">
						<td width="35%"><strong>Amount to be paid</strong></td>
						<td width="65%">'.$grand_total.'</td>
					</tr>
				</table>
			</td>
			</tr>  
			
	<tr>
		<td colspan="2">
			<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; float:left;">
				<tr>
					<td colspan="2" style="color:#14b3da;"><strong>Bank Details for RTGS Payment:</strong></td>
				</tr>
				<tr>
					<td colspan="2" style="color:#14b3da;"><strong>For Domestic Companies:</strong></td>
				</tr>
				<tr>
					<td width="35%"><strong>Company Name </strong></td>
					<td width="65%">The Gem & Jewellery Export Promotion Council</td>
				</tr>
				<tr>
					<td width="35%"><strong>Bank </strong></td>
					<td width="65%">ICICI BANK</td>
				</tr>
				<tr>
					<td width="35%"><strong>A/c No. </strong></td>
					<td width="65%">034801000360</td>
				</tr>
				<tr>
					<td width="35%"><strong>IFSC Code </strong></td>
					<td width="65%">ICIC0000348</td>
				</tr>
				<tr>
					<td width="35%"><strong>Type of Account </strong></td>
					<td width="65%">Saving Account</td>
				</tr>	
			</table>
		</td>
	</tr> 
	<tr> 
		<td><p>All the applicant members will have to update the details of advance payment along with UTR number and TDS on the dashboard after successful submission of online space application along with payment details before the deadline.</p></td>
		
	</tr>
	<tr><td><p>A system generated notification will be sent to you on successful approval of your application.</P></td>
	<tr>
		<td>       
		<p>Kind Regards,<br>
		<b>Team '.$eventDescription.'</b></p>
		<p> For Any Queries : </p>
		</td>
	</tr>
		<tr>
			<td><b>Toll Free Number :</b> 1800-103-4353 <br/>
			<b>Missed Call Number :</b> +91-7208048100
			</td>
		</tr> 
	</table>';
  
		 $to = $contact_person_email.",notification@gjepcindia.com,iijs.gjepc@gmail.com";
		 //$to = $contact_person_email;
		 $subject = "ROI Registration For ".$eventDescription; 
		 $headers  = 'MIME-Version: 1.0' . "\n"; 
		 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		 $headers .= 'From: GJEPC <admin@gjepc.org>';
		 mail($to, $subject, $message, $headers);
		 
		echo '<script type="text/javascript">'; 
		echo 'alert("You have successfully submitted! Thank you for showing your interest.");'; 
		echo 'window.location.href = "my_dashboard.php";';
		echo '</script>';
		exit;
		}
	}
}
?>
<?php 
   /*.......................Membership Information From Approval table ..................................*/
    $sqlApl="select membership_certificate_type from approval_master where registration_id='$registration_id'";
	$queryApl=$conn->query($sqlApl);
	$resultApl=$queryApl->fetch_assoc();
	$membership_certificate_type = $resultApl['membership_certificate_type'];
	$msme_ssi_status = chk_msme($registration_id,$conn);
	if($msme_ssi_status =='Yes'){ $membership_certificate_type = "MSME"; }
	
	/*..........................Get Company from registration...............................*/
	$cquery=$conn->query("select * from registration_master where id='$registration_id'");
	$cresult=$cquery->fetch_assoc();
	$company_name=$cresult['company_name'];		
	
	$company_address1 = htmlentities(strip_tags($cresult['address_line1']));
	$company_address2 = htmlentities(strip_tags($cresult['address_line2']));
	$company_address3 = htmlentities(strip_tags($cresult['address_line3']));
	$company_pincode = str_replace(' ', '', $cresult['pin_code']);
	$company_city = $cresult['city'];
	
	if($_SESSION['member_type']=="NON_MEMBER"){ 
		$company_pan_no = strtoupper($cresult['company_pan_no']);
		$company_gstn = strtoupper($result1['company_gstn']);
	}
	
	$query1=$conn->query("select address1,address2,address3,pincode,city,pan_no,gst_no from communication_address_master where registration_id='$registration_id' and type_of_address='2'");
	$result1=$query1->fetch_assoc();
	$address1 = htmlentities(strip_tags(trim($result1['address1'])));
	$address2 = htmlentities(strip_tags(trim($result1['address2'])));
	$address3 = htmlentities(strip_tags(trim($result1['address3'])));
	
	if($_SESSION['member_type']=="MEMBER"){ 
		$company_pan_no = strtoupper($result1['pan_no']);		
		$company_gstn = strtoupper($result1['gst_no']);
	}
	
	$pincode = str_replace(' ', '', $result1['pincode']);
	$city=$result1['city'];
	
	/* For NonMember If Address No found */
	if(empty($address1)){ $address1 = htmlentities(strip_tags($cresult['address_line1'])); }
	if(empty($address2)){ $address2 = htmlentities(strip_tags($cresult['address_line2'])); }
	if(empty($address2)){ $address2 = htmlentities(strip_tags($cresult['address_line3'])); }
	if(empty($pincode)) { $pincode = str_replace(' ', '', $cresult['pin_code']); }
	if(empty($city))    { $city = $cresult['city']; }
	$region=$result['region_id'];		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ROI Form</title>
<link rel="icon" href="https://gjepc.org/assets/images/fav_icon.png" type="image/x-icon"/>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel='stylesheet' type='text/css' href='https://www.gjepc.org/assets-new/css/bootstrap.min.css'>
<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" /> 
<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!--<script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>-->
<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />

<!--NAV-->
<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
<script src="flexnav-master/js/jquery.flexnav.min.js?v=<?php echo $version;?>" type="text/javascript"></script>
<script src="js/common.js?v=<?php echo $version;?>"></script> 
<!--NAV-->


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
	$.validator.addMethod("gstno", function(value, element) {
	if(value=='NA')
		return true;
	else {
	return this.optional(element) || /^([0][1-9]|[1-2][0-9]|[3][0-7])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/.test(value);
	} }, "Please Enter Valid GSTIN No.");
	
	$("#regisForm").validate({
		rules: { 
			contact_person: {
				required: true,
			},
			contact_person_desg_show: {
				required: true,
			},
			email: {
				required: true,
				email:true
			},
			mobile_no: {
				required: true,
				number:true,
				minlength: 10,
				maxlength:10
			},
			billing_address_id: {
				required: true,
			},
			billing_gstin: {
				required: true,
				gstno:true
			},
			prefered_city: {
				required: true,
			},
			section: {
				required: true,
			},
			selected_area: {
				required: true,
			},
			
		},
		messages: {
			contact_person: {
				required: "Please enter contact person name",
			},
			contact_person_desg_show: {
				required: "Please enter designation",
			},
			email: {
				required: "Please Enter a valid Email id",
			},
			mobile_no: {
				required:"Please Enter Mobile Number",
				number:"Please Enter Numbers only",
				minlength:"Please enter at least {10} digit.",
				maxlength:"Please enter no more than {0} digit."
			},
			billing_address_id: {
				required: "Select your billing address",
			},
			billing_gstin: {
				required: "Please Enter Company GSTIN",
			},
			prefered_city: {
				required: "Required",
			},
			section: {
				required: "Select your section",
			},
			selected_area: {
				required: "Select your area",
			}
	 }
	});
});
</script>

<script>
$().ready(function() {
	
  $("#selected_area").on('change',function(){
	selected_area=$('#selected_area').val();
	event_name=$('#event_name').val();
    $.ajax({ type: 'POST',
					url: 'iijs_combo_ajax.php',
					data: "actiontype=ROICAL&&selected_area="+selected_area+"&&event_name="+event_name,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
					var res = data.split("#");		
					$('#tot_space_cost_rate').val(res[0]);$('#tot_space_cost_rate1').val(res[0]);
					$('#govt_service_tax').val(res[1]);$('#govt_service_tax1').val(res[1]);
					$('#grand_total').val(res[2]);$('#grand_total1').val(res[2]);
					}
		});
 }); 
 
  $("#section").on('change',function(){
	section=$('#section').val();
    $.ajax({ type: 'POST',
					url: 'iijs_combo_ajax.php',
					data: "actiontype=ROIALLOEDAREA&&section="+section,
					dataType:'html',
					beforeSend: function(){
					},
					success: function(data){//alert(data);	
					console.log(data);
					$('#selected_area').html(data);
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


<style>
	.form-group .form_head {font-style:normal;font-weight: bold;padding: 7px 7px 7px 0;font-size:14px;/* background:#000; */border-bottom: 1px dashed #a89c5d; color: #a89c5d;}

</style>
</head>

<body>

<div class="wrapper">

<div class="header">
	<?php include('tritiya_header.php'); ?>
</div>

<div id="preloader">
    <div id="status"> <img src="https://www.gjepc.org/assets/images/logo.png"></div>
</div>

<div class="container py-5" style="font-size: 14px;">
	
	<div class="bold_font text-center">
		<div class="d-block"><img src="https://www.gjepc.org/assets/images/gold_star.png" class=""></div>
		“Registration of Interest (ROI) for IIJS Tritiya 2022, 24th – 27th March 2022, at Bangalore International Exhibition Centre - Bengaluru”
	</div>
	
	<!--<div class="d-table mx-auto p-2 px-4 mb-4" style="background: #1ac145; border-bottom: 3px solid #14762d; color: #fff; font-size: 16px;">
		<i class="fa fa-thumbs-up" aria-hidden="true"></i>
	</div>-->

	<?php if(isset($_SESSION['error_msg']) && $_SESSION['error_msg']!=""){?>
	<div class="d-table mx-auto p-2 px-4 mb-4" style="background: #f00; border-bottom: 3px solid #8d0a0a; color: #fff; font-size: 16px;">
		<i class="fa fa-exclamation-circle" aria-hidden="true"></i>
		<?php echo $_SESSION['error_msg'];$_SESSION['error_msg']="";?>
	</div>
	<?php }?>
	
	<div class="box-shadow">
		<form class="cmxform row" method="post" name="regisForm" id="regisForm" autocomplete="off">

			<div class="col-12 form-group">
				<div class="form_head">Company Details</div>	
			</div>

			<div class="col-sm-6 col-md-3 form-group">
				<label class="d-block"><strong>Company Name</strong></label>
				<?php echo stripcslashes(strtoupper($company_name));?>
			</div>

			<div class="col-sm-6 col-md-3 form-group">
				<label class="d-block"><strong>Membership ID</strong></label>
				<?php $membership_id=getMembershipId($_SESSION['USERID'],$conn);echo ($membership_id=="") ? 'NA' : $membership_id;?>
			</div>

			<div class="col-sm-6 col-md-3 form-group">
				<label class="d-block"><strong>Company PAN No.</strong></label>
				<?php echo $company_pan_no;?>
			</div>

			<div class="col-sm-6 col-md-3 form-group">
				<label class="d-block"><strong>Membership Type</strong></label>
				<?php echo $_SESSION['member_type'];?>
			</div>
			
			<div class="col-sm-12 col-md-9 form-group">
				<label class="d-block"><strong>Office Address</strong></label>
				<textarea name="office_address" id="office_address" width='35px' height="200px"><?php echo $address1." ".$address2." ".$address3." ".$pincode." ".$city;?></textarea>
			</div>
			
			<div class="col-12 form-group">
				<div class="form_head">Contact Details</div>	
			</div>

			<div class="col-sm-6 col-md-3 form-group">
				<label class="d-block">Contact Person *</label>
				<input type="text" class="form-control" id="contact_person" name="contact_person" value="">
			</div>
			<div class="col-sm-6 col-md-3 form-group">
				<label class="d-block">Designation *</label>
				<input type="text" class="form-control" id="contact_person_desg_show" name="contact_person_desg_show" value="" maxlength="25">
			</div>

			<div class="col-sm-6 col-md-3 form-group">
				<label class="d-block">Email ID *</label>
				<input type="text" class="form-control" id="email" name="email" value="">
			</div>

			<div class="col-sm-6 col-md-3 form-group">
				<label class="d-block">Mobile No. *</label>
				<input type="text" class="form-control" id="mobile_no" name="mobile_no" value="" onkeypress="if(this.value.length==10) return false;">
			</div>
			
			<?php if($_SESSION['member_type']=="MEMBER"){ ?>
			<div class="col-12 form-group">
				<div class="form_head">Billing Address </div>	
			</div>
			
			<div class="col-12  col-md-6 form-group">
			<label class="d-block">Select your billing address *</label>
			<select name="billing_address_id" id="billing_address_id" class="bgcolor form-control">
			<option value="">--- Choose Billing Address ---</option>
			<?php
			$commAddress2 = "SELECT * FROM `communication_address_master` WHERE `registration_id` = '$registration_id' AND address_identity='CTC' AND c_bp_number!='' AND pan_no!=''";
			$result2 = $conn->query($commAddress2);
			while($addChild = $result2->fetch_assoc()){ ?>
			<option value="<?php echo $addChild['id'];?>">
				<?php echo $addChild['address1'].'-'.$addChild['address2'].'-'.$addChild['address3'].'-'.$addChild['city'];?>
			</option>			
			<?php } ?>
			</select>
			</div>
			<div class="col-sm-6 col-md-3 form-group">
				<label class="d-block">Billing GSTIN *</label>
				<input type="text" class="form-control" id="billing_gstin" name="billing_gstin" value ="">
			</div>
			<?php }?>
			
			<input type='hidden' name="prefered_city" id="prefered_city" value="Bengaluru" />
			<!--
			<div class="col-6  col-md-6 form-group">
			<label class="d-block">Which city would you prefer for IIJS Tritiya 2022*</label>
				<select name="prefered_city" id="prefered_city" class="bgcolor form-control">
					<option value="">--- Select City ---</option>
					<option value="Mumbai">Mumbai</option>
					<option value="Bengaluru">Bengaluru</option>
				</select>
			</div>
			-->

			<div class="col-12 form-group">
				<div class="form_head">Participation Stall Details</div>
				<span style="color:red"><strong>"Jewellery Start-up Zone Applicants can apply for only 6 sqm"</strong></span> 				
			</div>
			
			<div class="col-sm-6 col-md-3 form-group">
				<label class="d-block">Select Event</label>
				<select name="event_name" id="event_name" class="form-control">
					<option value="">-----Select Event----</option>
					<option value="iijstritiya22" selected>IIJS Tritiya 2022</option>
                </select>
			</div>

			<div class="col-sm-6 col-md-3 form-group">
				<label class="d-block">Select your section<br/> </label>
				<select name="section" id="section" class="form-control">
					<option  value="">-----Select Section----</option>
					<?php
						$sql="SELECT * FROM signature_section_master where member_type='".$_SESSION['member_type']."' and roi_status='Y' ORDER BY section_desc";
						$query=$conn->query($sql);
						while($result=$query->fetch_assoc()){
					?>
					 <option value="<?php echo $result['section'];?>"><?php echo $result['section_desc'];?></option>
					<?php }?>
                </select>
			</div>

			<div class="col-sm-6 col-md-3 form-group">
				<label class="d-block">Select your area (sqm)</label>
				<select name="selected_area" id="selected_area" class="form-control">
					<option  value="">-----Select Area----</option>
				</select>
			</div>
			
			<div class="col-sm-6 col-md-3 form-group">
				<label class="d-block">Total Cost</label>
				<input type="text" class="form-control" name="tot_space_cost_rate1" id="tot_space_cost_rate1" value="" readonly="readonly">
				<input type="hidden" class="form-control" name="tot_space_cost_rate" id="tot_space_cost_rate" value="" readonly="readonly">
			</div>

			<div class="col-sm-6 col-md-3 form-group">
				<label class="d-block">Total GST</label>
				<input type="text" class="form-control" id="govt_service_tax1" name="govt_service_tax1" readonly="readonly" value="">
				<input type="hidden" class="form-control" id="govt_service_tax" name="govt_service_tax" readonly="readonly" value="">
			</div>

			<div class="col-sm-6 col-md-3 form-group">
				<label class="d-block">Grand total</label>
				<input type="text" class="form-control" id="grand_total1" name="grand_total1" readonly="readonly" value="">
				<input type="hidden" class="form-control" id="grand_total" name="grand_total" readonly="readonly" value="">
			</div>

			
			<span style="color:red"><strong>“Please note that the above mentioned amount is calculated @ ₹ 5000 per sqm + GST” is an advance amount as mentioned in ROI Circular</strong></span> 
			<div class="col-12">
				<input type="hidden" name="action" value='Save'/>
				<input type="hidden" name="registration_id" id="registration_id" value="<?php echo $_SESSION['USERID'];?>"/>
				<input type="hidden" name="member_type" id="member_type" value="<?php echo $_SESSION['member_type'];?>"/>
				<button class="cta fade_anim">Submit</button>
			</div>
		</form>
	</div>
</div>
<div class="footer">
	<?php include('footer.php'); ?>
</div>

</div>

</body>
</html>