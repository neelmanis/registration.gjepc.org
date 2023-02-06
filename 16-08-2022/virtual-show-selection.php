<?php 
include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit; }
$registration_id = filter($_SESSION['USERID']);

function getEventName($event,$conn)
{
	$query_sel = "SELECT section_desc FROM virtual_event_master where event='$event'";
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		 	
	return $row['section_desc'];		
}

$sqlm = "select * from virtual_event_registration where registration_id='$registration_id' event_version='VIRL2'";
$ansm = $conn->query($sqlm);
$countxx = $ansm->num_rows;
if($countxx>0){
	echo "<script>alert('Already Applied'); window.location = 'my_dashboard.php';</script>";
}

$action=@$_REQUEST['action'];
if($action=="save")
{
	//echo '<pre>'; print_r($_POST); exit;
	$event_version='VIRL2';
	$event = trim($_POST['event']);
	$event_for = getEventName($event,$conn);
	$selected_image_type   = trim($_POST['selected_image_type']);
	$selected_meeting_type = trim($_POST['selected_meeting_type']);
	if($event!='' && $selected_image_type!='' && $selected_meeting_type!=''){
		
	$company_name=trim($_POST['company_name']);
	$contact_person_name=trim($_POST['contact_person_name']);
	$contact_person_email=trim($_POST['contact_person_email']);
	$contact_person_mobile_no=trim($_POST['contact_person_mobile_no']);
	$contact_person_designation=trim($_POST['contact_person_designation']);
	
	$contact_person_name_show=trim($_POST['contact_person_name_show']);
	$contact_person_email_show=trim($_POST['contact_person_email_show']);
	$contact_person_mobile_no_show=trim($_POST['contact_person_mobile_no_show']);
	$contact_person_designation_show=trim($_POST['contact_person_designation_show']);
	
	$category=$_POST['category'];
	
	$event_charge = trim($_POST['event_charge']);
	$image_charge = trim($_POST['image_charge']);
	$meeting_charge = trim($_POST['meeting_charge']);
	$sub_total_cost = trim($_POST['sub_total_cost']);
	$gst_total = trim($_POST['gst_total']);
	$grand_total = trim($_POST['grand_total']);
	$agree=$_POST['agree'];

	
	$sqlx = "INSERT into virtual_event_registration SET post_date=NOW(),registration_id='$registration_id',event='$event',company_name='$company_name',contact_person_name='$contact_person_name',contact_person_email='$contact_person_email',contact_person_mobile_no='$contact_person_mobile_no',contact_person_designation='$contact_person_designation',contact_person_name_show='$contact_person_name_show',contact_person_email_show='$contact_person_email_show',contact_person_mobile_no_show='$contact_person_mobile_no_show',contact_person_designation_show='$contact_person_designation_show',category='$category',additional_image='$selected_image_type',meeting_room='$selected_meeting_type',show_charge='$event_charge',image_charge='$image_charge',meeting_charge='$meeting_charge',sub_total_cost='$sub_total_cost',gst_total_cost='$gst_total',grand_total_cost='$grand_total',agree='$agree',event_selected='vbsm2',event_version='$event_version'";
	$resultx = $conn->query($sqlx);
	$last_id = mysqli_insert_id($conn);
	if($resultx)
	{
		
$message ='<table width="100%" bgcolor="#fff" style="margin:20px auto; border:2px solid #dddddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
<tr>
<td style="padding:30px;">
<table width="100%" border="0" background="#fff" cellpadding="0" cellspacing="0">
	<tr>
    	<td align="left" valign="top"><a href="https://www.gjepc.org"><img src="https://gjepc.org/images/gjepc_logon.png"/></a></td>
    	<td align="right"><a href="https://gjepc.org/iijs-virtual/"><img src="https://gjepc.org/emailer_gjepc/24.11.2020/logo2.0.jpg"/></a></td>
    </tr> 
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>    
    <tr><td colspan="2" height="1px" bgcolor="#333333"></td></tr>    
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>    
	<tr>
    	<td colspan="2" valign="top" style="font-size:13px;">
		<p><strong>Company Name : </strong> '.$_SESSION['COMPANYNAME'].'</p>
		<p><strong>Application No. : EXREG/'.$event.'/2021/'.$last_id.'</strong></p>
    	<p>Thank you for applying Online for '.$event_for.' at IIJS VIRTUAL SHOW 2.0 Please note your application is under approval process.</p>    	
    	</td>
    </tr>
    
    <tr><td colspan="2">&nbsp;</td></tr>    
    <tr>
    <td colspan="2">

<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; float:left;">
    <tr><td colspan="2" style="color:#14b3da;"><strong>Application Summary</strong></td></tr>
    <tr>
        <td width="35%"><strong>Package Name </strong></td>
        <td width="65%">'.$event_for.'</td>
    </tr>	
	<tr>
        <td><strong>Additional Images Taken</strong></td>
        <td>'.$selected_image_type.'</td>
    </tr>
    <tr>
        <td><strong>Additional Meeting Room Taken</strong></td>
        <td>'.$selected_meeting_type.'</td>
    </tr>

  <tr valign="top">
    <td colspan="2" style="color:#14b3da;"><strong>Application Payment Summary</strong><br/></td>
    </tr>
  <tr valign="top">
    <td width="30%"><strong>Package Charges </strong></td>
    <td width="21%">'.$event_charge.'</td>
  </tr>
  <tr valign="top">
    <td><strong>Additional Image Charges</strong></td>
    <td>'.$image_charge.'</td>
  </tr>
  <tr valign="top">
    <td><strong>Additional Meeting Room Charges</strong></td>
    <td>'.$meeting_charge.'</td>
  </tr>
  <tr valign="top">
    <td><strong>Sub Total cost</strong></td>
    <td>'.$sub_total_cost.'</td>
  </tr>
  <tr valign="top">
    <td valign="top"><strong>GST (18% on SubTotal Cost) </strong></td>
    <td valign="top">'.$gst_total.'</td>
  </tr>
  <tr valign="top">
    <td><strong>Grand Total </strong></td>
    <td>'.$grand_total.'<br /></td>
  </tr>

	<tr valign="top">
    <td colspan="2" style="color:#14b3da;"><strong>Bank Details</strong></td>
    </tr>
	<tr valign="top">
	<td width="52%"><strong>Company Name</strong></td>
	<td width="48%">The Gem & Jewellery Export Promotion Council</td>
	</tr>
    <tr valign="top">
	<td width="52%"><strong>Bank</strong></td>
	<td width="48%">ICICI BANK</td>
    </tr>
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

    <tr>
    <td colspan="2" style="line-height:20px;">
	<p align="justify">All the applicant members will have to update the details of payment along with UTR number and TDS on the dashboard after successful submission of online space application form in 4 working days from date of online submission.</p>
	<p>A system generated notification will be sent to you on successful approval of your application.</p>
	<p>Kind Regards,</p>   
	<p><strong>IIJS Team Virtual</strong></p>
</td>
</tr>
</table>

</td>
</tr>
</table>';
	
	$to =$_SESSION['EMAILID'].",notification@gjepcindia.com,iijs.gjepc@gmail.com";
	//$to ='neelmani@kwebmaker.com,notification@gjepcindia.com';	
	$subject = "IIJS VIRTUAL SHOW 2.0 for ".$event_for." (EXREG/".$event."/2021/".$last_id."/".date('Y-m-d').")";
	$headers  = 'MIME-Version: 1.0' . "\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1'."\n";	
	$headers .='From: IIJS VIRTUAL SHOW 2.0 <admin@gjepc.org>';	
	@mail($to, $subject, $message, $headers);
	
		$utrNameSuccess = "Saved Successfully"; 
		header("Refresh: 2; url=https://registration.gjepc.org/my_dashboard.php");
	}
	} else {
		echo 'Something Missing';
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Virual Show Selection</title>
		<link rel="icon" href="https://gjepc.org/images/favicon.ico" type="image/x-icon"/>
		<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
		<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />		
		<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
		<script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>
		<!--NAV-->
		<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js?v=<?php echo $version;?>"></script>
		<script src="js/common.js"></script>
		<!--NAV-->
		<!-- UItoTop plugin -->
		<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css?v=<?php echo $version;?>" />
		<script src="js/easing.js?v=<?php echo $version;?>" type="text/javascript"></script>
		<script src="js/jquery.ui.totop.js?v=<?php echo $version;?>" type="text/javascript"></script>
		<script src="jsvalidation/jquery.validate.js?v=<?php echo $version;?>" type="text/javascript"></script> 
         <link rel="stylesheet" type="text/css" media="screen" href="css/rcmc.validation.css?v=<?php echo $version;?>" />
		<script type="text/javascript">
		$(document).ready(function() {
		$().UItoTop({ easingType: 'easeOutQuart' });
		});
		</script>
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
		<script type="text/javascript">
		$(window).load(function() {
			$(".loader").fadeOut("slow");

		var checkEvent = $('input[name="event"]').val();
		if($('input[name="event"]').is(':checked')) {
		 	$('#submit').attr("disabled",true);
		} else {
		 	$('#submit').attr("disabled",true);
		}			
		});
		
		$("#specific-data").hide();
		//$("#submit").attr("disabled");
		$(document).ready(function() {
		$('input[name="event"]').change(function(){
			
			var event =  $(this).val();
			$("#specific-data").show();
			//$("#eventForm")[0].reset() 
			//alert(event);
			if(event=="standard"){
				$(this).closest('form').find("input[type=text], textarea").val(""); 
				$("#std").show(); 
				$("#prm").hide(); 
				$("#sprm").hide();				
				}
			else if(event=="premium"){ 
			$(this).closest('form').find("input[type=text], textarea").val(""); 
				$("#std").hide(); 
				$("#prm").show(); 
				$("#sprm").hide();
			}
			else if(event=="spremium"){ 
			$(this).closest('form').find("input[type=text], textarea").val("");
				$("#sprm").show();
				$("#std").hide(); 
				$("#prm").hide(); 				
			}
			
			$.ajax({ 
				   type: 'POST',
					url: 'ajax.php',
					data: "actiontype=getVirtualPkg&&event="+event,
					dataType:'html',
					beforeSend: function(){
							$('.loader').show();
							},
					success: function(data){
					//alert(data);
					$('#submit').attr('disabled',true);
					$('.loader').hide();
					
					var res = data.split("#");
					if($.trim(res[0])!=""){
							$('#selected_image_type').html(res[0]);
					}
					if($.trim(res[1])!=""){
						$('#selected_meeting_type').html(res[1]);
					}
					}
		});
		
			$('#selectedShow').html('<b>'+event+'</b>');			
			$('#calculate').attr('disabled',false);
		});
		});
		
		$(window).ready(function(e){
			$("#eventForm").validate({
				rules: {
					event: {
						required: true,
					},
					category: {
						required: true,
					},  
					selected_image_type: {
						required: true,
					},
					selected_meeting_type: {
						required: true,
					},		
					contact_person_name: {
						required: true,
					},
					contact_person_email: {
						required: true,
						email:true,
					},
					contact_person_mobile_no: {
						required: true,
						number:true,
						minlength: 10,
						maxlength:10
					},
					contact_person_designation: {
						required: true,
					},
					contact_person_name_show: {
						required: true,
					},
					contact_person_email_show: {
						required: true,
						email:true,
					},
					contact_person_mobile_no_show: {
						required: true,
						number:true,
						minlength: 10,
						maxlength:10
					},
					contact_person_designation_show: {
						required: true,
					},
				},
				messages: {
					event: {
						required: "Please select Show",
					},
					category: {
						required: "Please select category/section",
					},
					selected_image_type: {
						required: "Please select Image",
					},	
					selected_meeting_type: {
						required: "Please select area",
					},
					contact_person_name: {
						required: "Please Enter Contact Person Name",
					},
					contact_person_email: {
						required: "Please Enter a valid Email id",
					},
					contact_person_mobile_no: {
						required: "Required",
						number:"Please Enter Numbers only",
						minlength:"Please enter at least {10} digit.",
						maxlength:"Please enter no more than {0} digit."
					},
					contact_person_designation: {
						required: "Required",
					},
					contact_person_name_show: {
						required: "Please Enter Contact Person Name for Show Co-ordination",
					},
					contact_person_email_show: {
						required: "Please Enter a valid Email id",
					},
					contact_person_mobile_no_show: {
						required: "Required",
						number:"Please Enter Numbers only",
						minlength:"Please enter at least {10} digit.",
						maxlength:"Please enter no more than {0} digit."
					},
					contact_person_designation_show: {
						required: "Required",
					},
			 }
			});
			
	$('.numeric').keypress(function (event) {
	var keycode = event.which;
	if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) 
	{
		event.preventDefault();
	}
	if ($(this).val().length == $(this).attr("maxlength")) {
		return false;
	}
	});
		
	});
		
</script>
<script>
$(document).ready(function(){
  $("#calculate").click(function(e){
	   e.preventDefault();
	category=$("#category").val(); 
	event=$("input[name='event']:checked").val();
	selected_meeting_type=$("#selected_meeting_type").val();
	selected_image_type=$("#selected_image_type").val();
   //$("#submit").attr("disabled");
    if (event == '' || selected_meeting_type == '' || selected_image_type == '') {
	alert("Please Fill Required Fields");
	} else {
			$.ajax({ 		
					type: 'POST',
					url: 'ajax.php',
					data: "actiontype=getcalculation&&event="+event+"&&selected_image_type="+selected_image_type+"&&selected_meeting_type="+selected_meeting_type+"&&category="+category,
					dataType:'html',
					beforeSend: function(){
							$('.loader').show();
							},
					success: function(data){
							    //alert(data);return false;
								if(data!==''){
								$('.loader').hide();
								
								var data=data.split("#");
								if($.trim(data[0])!=""){
								$('#event_charge').val(data[0]);
								}
								if($.trim(data[1])!=""){
								$('#image_charge').val(data[1]);
								}
								if($.trim(data[2])!=""){
								$('#meeting_charge').val(data[2]);
								}
								if($.trim(data[3])!=""){
								$('#sub_total_cost').val(data[3]);
								}
								if($.trim(data[4])!=""){
								$('#gst_total').val(data[4]);
								}
								if($.trim(data[5])!=""){
								$('#grand_total').val(data[5]);
								}
								//$("#submit").removeAttr("disabled");
								if($("#grand_total").val() !=""){
									$("#submit").attr('disabled',false);
								}else{
									$("#submit").attr('disabled',true);
								}
								//$("#submit").show();
								} else {
								$('.loader').show();
								}								
							}
		});
	}
 });
});
</script>
<style>
.form_wrapper {width:50%; float:left;}
@media (max-width:768px)
{
.form_wrapper {width:100%; float:none;}
}
</style>
</head>

<body>

<div class="loader"><p>loading please wait....</p></div>
		<div class="wrapper">
			<div class="header"><?php include('header1.php'); ?></div>
<div class="inner_container">
				
	<div class="container_wrap">
		<div class="container">
           <span class="headtxt"></span>	
           <div id="loginForm">		  
           
        <div id="formContainer">
        
        <div class="title"><h4 style="text-align: center; color: #fff; display: table; background: #00000099; margin: 0 auto; border: 1px solid#000;
    -webkit-box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); -moz-box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); border-radius: 6px;">Choose Your IIJS Virtual Show Package</h4></div>
	<div class="clear"></div>
	
	<div id="std" style="display: none">
<table class="table" style="border: 1px solid black; font-family:Roboto Condensed,sans-serif; color:#333333; font-size:13px; border-radius:2px;padding:20px; border-collapse: collapse;">
  <thead>
    <tr>
      <th style="border:1px solid black; padding: 8px;">Exhibitor Category</th>
      <th style="border:1px solid black; padding: 8px;">Standard Package</th>
      <th style="border:1px solid black; padding: 8px;">Optional add-on </th>
      <th style="border:1px solid black; padding: 8px;">Total</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="border:1px solid black; padding: 8px;"><strong>Placement</strong></td>
      <td style="border:1px solid black; padding: 8px;">2D Exhibition interface</td>
      <td style="border:1px solid black; padding: 8px;"></td>
      <td style="border:1px solid black; padding: 8px;"></td>
    </tr>
    <tr>
      <td style="border:1px solid black; padding: 8px;"><strong>Design</strong></td>
      <td style="border:1px solid black; padding: 8px;">Standard 2D Template Design</td>
      <td style="border:1px solid black; padding: 8px;"></td>
      <td style="border:1px solid black; padding: 8px;"></td>
    </tr>
    <tr>
      <td style="border:1px solid black; padding: 8px;"><strong>Catalogue Size</strong></td>
      <td style="border:1px solid black; padding: 8px;">100 Images upload* </td>
      <td style="border:1px solid black; padding: 8px;">Up to 100 additional Images upload*</td>
      <td style="border:1px solid black; padding: 8px;">Max. 200 images upload*</td>
    </tr>
    <tr>
      <td style="border:1px solid black; padding: 8px;"><strong>Video Calling</strong></td>
      <td style="border:1px solid black; padding: 8px;">1 Meeting room </td>
      <td style="border:1px solid black; padding: 8px;">Up to 1 Meeting room</td>
      <td style="border:1px solid black; padding: 8px;">Max. 2 Meeting room</td>
    </tr>
    <tr>
      <td style="border:1px solid black; padding: 8px;"><strong>Price</strong></td>
      <td style="border:1px solid black; padding: 8px;"> ₨ 45,000* <br/> ₨ 40,000* for MSME</td>
      <td style="border:1px solid black; padding: 8px;">Per Meeting Room: ₨ 10,000*</td>
      <td style="border:1px solid black; padding: 8px;"></td>
    </tr>
    <tr>
      <td style="border:1px solid black; padding: 8px;"><strong>Price</strong></td>
      <td style="border:1px solid black; padding: 8px;">₨ 40,000* (Machinery & Allied - Member) <br/>₨ 45,000* (Machinery & Allied - NonMember)</td>
      <td style="border:1px solid black; padding: 8px;">Per 100 Images: ₨ 5,000*</td>
      <td style="border:1px solid black; padding: 8px;"></td>
    </tr>
  </tbody>
</table>
</div>   

<div id="prm" style="display: none">
<table class="table" style="border: 1px solid black;  font-family:Roboto Condensed,sans-serif; color:#333333; font-size:13px; border-radius:2px; padding:20px; border-collapse: collapse;">
  <thead>
    <tr>
      <th style="border:1px solid black; padding: 5px;">Exhibitor Category</th>
      <th style="border:1px solid black; padding: 5px;">Premium Package</th>
      <th style="border:1px solid black; padding: 5px;">Optional add-on </th>
      <th style="border:1px solid black; padding: 5px;">Total</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="border:1px solid black; padding: 8px;"><strong>Placement</strong></td>
      <td style="border:1px solid black; padding: 8px;">Dedicated rendered stalls at designated Hall as per product category </td>
      <td style="border:1px solid black; padding: 8px;"></td>
      <td style="border:1px solid black; padding: 8px;"></td>
    </tr>
    <tr>
      <td style="border:1px solid black; padding: 8px;"><strong>Design</strong></td>
      <td style="border:1px solid black; padding: 8px;">Customised 3D Template Design from available options</td>
      <td style="border:1px solid black; padding: 8px;"></td>
      <td style="border:1px solid black; padding: 8px;"></td>
    </tr>
    <tr>
      <td style="border:1px solid black; padding: 8px;"><strong>Catalogue Size</strong></td>
      <td style="border:1px solid black; padding: 8px;">250 Images upload* </td>
      <td style="border:1px solid black; padding: 8px;">Maximum 200 Images Upload at blocks of 100 each</td>
      <td style="border:1px solid black; padding: 8px;">Max 450 images upload*</td>
    </tr>
    <tr>
      <td style="border:1px solid black; padding: 8px;"><strong>Video Calling</strong></td>
      <td style="border:1px solid black; padding: 8px;">2 Meeting room </td>
      <td style="border:1px solid black; padding: 8px;">Maximum of 2 meeting rooms</td>
      <td style="border:1px solid black; padding: 8px;">Max. 4 Meeting room</td>
    </tr>
	 <tr>
      <td style="border:1px solid black; padding: 8px;"><strong>Listing</strong></td>
      <td style="border:1px solid black; padding: 8px;">Premium listing at Standard booth directory </td>
      <td style="border:1px solid black; padding: 8px;"></td>
      <td style="border:1px solid black; padding: 8px;"></td>
    </tr>
    <tr>
      <td style="border:1px solid black; padding: 8px;"><strong>Price</strong></td>
      <td style="border:1px solid black; padding: 8px;"> ₨ 85,000* (Jewellery Section)</td>
      <td style="border:1px solid black; padding: 8px;">Per Meeting Room: ₨ 10,000*</td>
      <td style="border:1px solid black; padding: 8px;"></td>
    </tr>
    <tr>
      <td style="border:1px solid black; padding: 8px;"><strong>Price</strong></td>
      <td style="border:1px solid black; padding: 8px;">₨ 85,000* (Machinery & Allied - Member) <br/>₨ 90,000* (Machinery & Allied - NonMember)</td>
      <td style="border:1px solid black; padding: 8px;">Per 100 Images: ₨ 5,000*</td>
      <td style="border:1px solid black; padding: 8px;"></td>
    </tr>
  </tbody>
</table>
</div> 

<div id="sprm" style="display: none">
<table class="table" style="border: 1px solid black;  font-family:Roboto Condensed,sans-serif; color:#333333; font-size:13px; border-radius:2px; padding:20px; border-collapse: collapse;">
  <thead>
    <tr>
      <th style="border:1px solid black; padding: 8px;">Exhibitor Category</th>
      <th style="border:1px solid black; padding: 8px;">Super Premium Package</th>
      <th style="border:1px solid black; padding: 8px;">Optional add-on </th>
      <th style="border:1px solid black; padding: 8px;">Total</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="border:1px solid black; padding: 8px;"><strong>Placement</strong></td>
      <td style="border:1px solid black; padding: 8px;">Specially dedicated rendered stalls at the centre of the designated Hall as per product category </td>
      <td style="border:1px solid black; padding: 8px;"></td>
      <td style="border:1px solid black; padding: 8px;"></td>
    </tr>
    <tr>
      <td style="border:1px solid black; padding: 8px;"><strong>Design</strong></td>
      <td style="border:1px solid black; padding: 8px;">Customised 3D Premium Template Design from available options</td>
      <td style="border:1px solid black; padding: 8px;"></td>
      <td style="border:1px solid black; padding: 8px;"></td>
    </tr>
    <tr>
      <td style="border:1px solid black; padding: 8px;"><strong>Catalogue Size</strong></td>
      <td style="border:1px solid black; padding: 8px;">500 Images upload* </td>
      <td style="border:1px solid black; padding: 8px;">Maximum 300 Images Upload* at blocks of 100 each</td>
      <td style="border:1px solid black; padding: 8px;">Max. 800 images upload*</td>
    </tr>
    <tr>
      <td style="border:1px solid black; padding: 8px;"><strong>Video Calling</strong></td>
      <td style="border:1px solid black; padding: 8px;">4 Parallel meeting rooms</td>
      <td style="border:1px solid black; padding: 8px;">Maximum of 4 meeting rooms</td>
      <td style="border:1px solid black; padding: 8px;">Max. 8 Meeting room</td>
    </tr>
	<tr>
      <td style="border:1px solid black; padding: 8px;"><strong>Listing</strong></td>
      <td style="border:1px solid black; padding: 8px;">Super premium listing at Standard booth directory</td>
      <td style="border:1px solid black; padding: 8px;"></td>
      <td style="border:1px solid black; padding: 8px;"></td>
    </tr>
    <tr>
      <td style="border:1px solid black; padding: 8px;"><strong>Price</strong></td>
      <td style="border:1px solid black; padding: 8px;"> ₨ 1,25,000* </td>
      <td style="border:1px solid black; padding: 8px;">Per Meeting Room: ₨ 10,000*</td>
      <td style="border:1px solid black; padding: 8px;"></td>
    </tr>
    <tr>
      <td style="border:1px solid black; padding: 8px;"><strong>Price</strong></td>
      <td style="border:1px solid black; padding: 8px;">₨ 1,25,000* (Machinery & Allied - Member) <br/>₨ 130,000* (Machinery & Allied - NonMember) </td>
      <td style="border:1px solid black; padding: 8px;">Per 100 Images: ₨ 5,000*</td>
      <td style="border:1px solid black; padding: 8px;"></td>
    </tr>
  </tbody>
</table>
</div>

	<?php if(isset($utrNameSuccess)){ echo '<span style="color: green;"/>'.$utrNameSuccess.'</span>';} ?>
    <div class="borderBottom"></div>
										
    <form method="POST" name="eventForm" id="eventForm" autocomplete="off">
	
		<input type="hidden" name="action" value="save"/>   
        <div class="d-flex flex-column ">
              <div class="d-flex flex-row form-setup">
                <div class="col-100 d-flex justify-around flex-wrap form-group">
                <div class="hungry">
				<?php 
				if($_SESSION['COUNTRY']=="IN")
				{ 
				$getEvent = "SELECT * FROM `virtual_event_master` WHERE status='Y'";				
				$eventResult = $conn->query($getEvent);
				while($eventRow = $eventResult->fetch_assoc()){ ?>
				  <div class="selection">
					<input id="<?php echo $eventRow['id'];?>" name="event" type="radio" value="<?php echo $eventRow['event'];?>" data-name="<?php echo $eventRow['section_desc'];?>" <?php if($gotEventName==$eventRow['event']){ echo "checked"; } ?>/>
					<label for="<?php echo $eventRow['id'];?>"><?php echo $eventRow['section_desc'];?></label>
				  </div>
				<?php } ?>				
				<?php } ?>
				</div>
				</div>				
			  </div>			  
		<!--<p id="selectedShow"></p>-->
			
			
			<div id="specific-data" style="display: none">
            
            <div class="form_wrapper">
            
			<div class="field_box">
			<div class="field_name">Company Name <span>*</span>:</div>
				<div class="field_input">
					<input type="hidden" name="company_name" id="company_name"  value="<?php echo $_SESSION['COMPANYNAME'];?>"/>
					<?php echo $_SESSION['COMPANYNAME'];?>
				</div>
			<div class="clear"></div>
			</div>
			<div class="field_box">
			<div class="field_name">Contact Person Name <span>*</span>:</div>
				<div class="field_input">
					<input type="text" name="contact_person_name" id="contact_person_name" autocomplete="off"/>
				</div>
			<div class="clear"></div>
			</div>
			<div class="field_box">
			<div class="field_name">Contact Person Email <span>*</span>:</div>
				<div class="field_input">
					<input type="text" name="contact_person_email" id="contact_person_email" autocomplete="off"/>
				</div>
			<div class="clear"></div>
			</div>
			<div class="field_box">
			<div class="field_name">Contact Person Mobile No.<span>*</span>:</div>
				<div class="field_input">
				<input type="text" name="contact_person_mobile_no" id="contact_person_mobile_no" class="numeric" maxlength="10" autocomplete="off"/>
				</div>
			<div class="clear"></div>
			</div>
			<div class="field_box">
			<div class="field_name">Contact Person Designation<span>*</span>:</div>
				<div class="field_input">
				<input type="text" name="contact_person_designation" id="contact_person_designation" autocomplete="off"/>
				</div>
			<div class="clear"></div>
			</div>
            
            </div>
            
            <div class="form_wrapper">
            
			<div class="field_box">
			<div class="field_name">&nbsp;</div>
				<div class="field_input">&nbsp;
				</div>
			<div class="clear"></div>
			</div>
			<div class="field_box">
			<div class="field_name">Contact Person Name for Show Co-ordination<span>*</span>:</div>
				<div class="field_input">
					<input type="text" name="contact_person_name_show" id="contact_person_name_show" autocomplete="off"/>
				</div>
			<div class="clear"></div>
			</div>
			<div class="field_box">
			<div class="field_name">Contact Person Email for Show Co-ordination<span>*</span>:</div>
				<div class="field_input">
					<input type="text" name="contact_person_email_show" id="contact_person_email_show" autocomplete="off"/>
				</div>
			<div class="clear"></div>
			</div>
			<div class="field_box">
			<div class="field_name">Contact Person Mobile No. for Show Co-ordination<span>*</span>:</div>
				<div class="field_input">
				<input type="text" name="contact_person_mobile_no_show" id="contact_person_mobile_no_show" class="numeric" maxlength="10" autocomplete="off"/>
				</div>
			<div class="clear"></div>
			</div>
			<div class="field_box">
			<div class="field_name">Contact Person Designation for Show Co-ordination<span>*</span>:</div>
				<div class="field_input">
				<input type="text" name="contact_person_designation_show" id="contact_person_designation_show" autocomplete="off"/>
				</div>
			<div class="clear"></div>
			</div>
            
            </div>
            
            <div class="clear"></div>

			<div class="field_box">
			<div class="field_name">Category / Section<span>*</span>:</div>
			<div class="field_input">
			<select name="category" id="category" class="bgcolor">
				<option value="">Please select your category / section</option>
				<?php if($_SESSION['member_type']=="MEMBER"){ ?>
				<option value="Hall 1. Traditional Gold Jewellery">Hall 1. Traditional Gold Jewellery</option>
				<option value="Hall 2. Diamond / Colour Gemstone Jewellery">Hall 2. Diamond / Colour Gemstone Jewellery</option>
				<option value="Hall 3. Couture / Bridal Jewellery">Hall 3. Couture / Bridal Jewellery</option>
				<option value="Hall 4. Loose / Diamonds / Colour Stone / Pearls / Silver Jewellery">Hall 4. Loose / Diamonds / Colour Stone / Pearls / Silver Jewellery</option>
				<option value="Hall 5. Gold Jewellery (Mass)">Hall 5. Gold Jewellery (Mass)</option>				
				<option value="Machinery_Allied_Section">Machinery & Allied Section</option>
				<?php } else { ?>
				<option value="Machinery_Allied_Section">Machinery & Allied Section</option>
				<?php } ?>
			</select>
			</div>
			<div class="clear"></div>
			</div>
			
			<div class="field_box">
			<div class="field_name">Additional Images Required <span>*</span></div>
			<div class="field_input">
			<select name="selected_image_type" id="selected_image_type" class="bgcolor"></select>
			</div>
			<div class="clear"></div>
			</div>
			
			<div class="field_box">
			<div class="field_name">Additional Meeting Room Required <span>*</span></div>
			<div class="field_input">
			<select name="selected_meeting_type" id="selected_meeting_type" class="bgcolor"></select>
			</div>
			<div class="clear"></div>
			</div>
			
			<div class="field_box">
			<span style="display:inline-block; float:left; margin-right:10px; margin-top:10px;">Click on calculate button to calculate the figures</span>
			  <input type="submit" name="calculate" disabled="disabled" id="calculate" value="Calculate" class="btn btn-submit"/>
			<div class="clear"></div>
			</div>                
			<div class="clear"></div>
			
			<div class="field_box">
			<div class="field_name">Package Charges </div>
			<div class="field_input"><input type="text" class="bgcolor" name="event_charge" id="event_charge" readonly="readonly" value="<?php echo $event_charge;?>" /></div>
			<div class="clear"></div>
			</div> 
			
			<div class="field_box">
			<div class="field_name">Additional Image Charges </div>
			<div class="field_input"><input type="text" class="bgcolor" name="image_charge" id="image_charge" readonly="readonly" value="<?php echo $image_charge;?>" /></div>
			<div class="clear"></div>
			</div> 
			
			<div class="field_box">
			<div class="field_name">Additional Meeting Room Charges </div>
			<div class="field_input"><input type="text" class="bgcolor" name="meeting_charge" id="meeting_charge" readonly="readonly" value="<?php echo $event_charge;?>" /></div>
			<div class="clear"></div>
			</div> 
			
			<div class="field_box">
			<div class="field_name">Sub Total cost </div>
			<div class="field_input"><input type="text" class="bgcolor" name="sub_total_cost" id="sub_total_cost" readonly="readonly" value="<?php echo $sub_total_cost;?>" /></div>
			<div class="clear"></div>
			</div>   
			
			<div class="field_box">
			<div class="field_name">GST (18% on SubTotal Cost) <span>*</span>:</div>
			<div class="field_input"><input type="text" class="bgcolor" id="gst_total" name="gst_total" readonly="readonly" value=""/>
			</div>
			<div class="clear"></div>
			</div>
			
			<div class="field_box">
			<div class="field_name">Grand Total <span>*</span>:</div>
			<div class="field_input">
			<input type="text" class="bgcolor" id="grand_total" name="grand_total" readonly="readonly" value="<?php echo $grand_total;?>"/>
			</div>
			<div class="clear"></div>
			</div>
			
			<div class="field_box">
			<div class=""><input type="checkbox" name="agree" id="agree" value="Y" checked="checked"/>I also agree to receive information from GJEPC via Whatsapp & Media</div>
			<div class="field_input">
				
			</div>
			<div class="clear"></div>
			</div> 
			
			<div class="field_box">
			<span style="display:inline-block; float:left; margin-right:205px; margin-top:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
			<input type="submit" name="submit" id="submit" value="SUBMIT" class="btn btn-submit">	
			<div class="clear"></div>
			</div>       			
			</div>
        </div>
        </div>
    </form>
</div>
</div>

</div>
<div class="clear"></div>
</div>

</div>			
</body>
</html>