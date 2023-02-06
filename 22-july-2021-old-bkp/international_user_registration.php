<?php include('header_include.php');?>
<?php

$action=$_REQUEST['action'];

if($action=="save")
{

	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
    

	$email_id = filter($_REQUEST['email_id']);

	if(empty($email_id))
	{   $_SESSION['err_msg']="Please Enter a valid Email id";}
	elseif(!filter_var(trim($email_id), FILTER_VALIDATE_EMAIL))
	{
		$_SESSION['err_msg']="The email you have entered is invalid, please try again."; 
	}elseif(empty($_SESSION['captcha_code'] ) ||  strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0)
	{
		$_SESSION['err_msg']= "The captcha code does not match!";
	}else{


	$company_type = $_REQUEST['company_type'];
	$pass		=	generatePassword();
	$company_name  = filter(strtoupper($_REQUEST['company_name']));
	$address_line1 = strtoupper(filter($_REQUEST['address_line1']));
	$address_line2 = strtoupper(filter($_REQUEST['address_line2']));
	$address_line3 = strtoupper($_REQUEST['address_line3']);
	$city = strtoupper(filter($_REQUEST['city']));
	$country = strtoupper($_REQUEST['country']);
	$state = strtoupper(addslashes($_REQUEST['state']));
	$mobile_no = $_REQUEST['mobile_no'];
	$land_line_no = $_REQUEST['land_line_no'];
	$nature_of_buisness = $_REQUEST['nature_of_buisness'];
	$pin_code = $_REQUEST['pin_code'];
	
	foreach($nature_of_buisness as $val)
	{
		if($val=="other")
		{
			$nature_of_buisness_other=$_REQUEST['nature_of_buisness_other'];
			$nature_of_buisness_new.=$nature_of_buisness_other.",";
		} else {
			$nature_of_buisness_new.=$val.",";	
		}
	}
	$dt=date('Y-m-d');
	$ip = $_SERVER['REMOTE_ADDR'];
	$website = "Registration INTL- ".  date("Y");
	
	$query=$conn->query("select * from registration_master where email_id='$email_id'");
	$num=$query->num_rows;
	if($num>0)
	{	
		$_SESSION['err_msg']="Already registered with this Email Id or Taxation No";
	}
    else
    {
	if(!empty($email_id)) {
	$hash = md5( rand(0,1000) );
	$password = md5($pass);
	$sql="insert into registration_master set email_id='$email_id',old_pass='$pass',company_secret='$password',company_type='$company_type',company_name='$company_name',address_line1='$address_line1',address_line2='$address_line2',address_line3='$address_line3',city='$city',country='$country',state='$state',pin_code='$pin_code',land_line_no='$land_line_no',mobile_no='$mobile_no',nature_of_buisness='$nature_of_buisness_new',status='0',website='$website',post_date='$dt',ip='$ip',hash='$hash'";
	
	if($conn->query($sql)){
	/*.......................................Send mail to users mail id...............................................*/
	$message ='<table cellpadding="10" width="65%" style="margin:0px auto;font-family: Roboto; background-color:#eeee;padding:30px; border-collapse:collapse;">
<tr><td style="background-color:#744F9E;padding:3px;"></td></tr>
  <tr><td align="left"><img src="https://gjepc.org/images/gjepc_logon.png"> </td></tr>
  <tr style="background-color:#eeee;padding:30px;">
  <td><h4 style="margin:0;">Thank you for registering at Gems and Jewellery Export Promotion Council (GJEPC).</h4></td></tr>
  <tr style="background-color:#eeee;padding:30px;">
  <td>Your account has been created, Please click The following link For verifying and activation of your account</td></tr>
  <tr>
    <td align="left" style="text-align:justify;"><strong>Company Name :</strong> '. $company_name .' </td>
    </tr>
	<tr>
    <td align="left" style="text-align:justify;"><strong>Password :</strong> '. $pass .' </td>
    </tr>
  <tr>
    <td align="left"  style="text-align:justify;">Please click this link to activate your account:<br/>
    https://registration.gjepc.org/verify.php?email='.$email_id.'&hash='.$hash.'</td>
  </tr>
   <tr><td>       
      <p>Kind Regards,<br>
      <b>GJEPC Web Team,</b>
      </p>
	  <p> For Any Queries : </p>
    </td>
  </tr>
  <tr><td><b>Toll Free Number :</b> 1800-103-4353 <br/>
<b>Missed Call Number :</b> +91-7208048100
 </td></tr> 
</table>';
  
	 $to = $email_id;
	 $subject = "New User Registration";
	 $headers  = 'MIME-Version: 1.0' . "\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	 $headers .= 'From: GJEPC <admin@gjepc.org>';
	 mail($to, $subject, $message, $headers);
	 $_SESSION['succ_msg']="You have been successfully registered<br/>Please check your email for getting Username and Password.";
	 } else { 
	 $_SESSION['err_msg']="There is some technical problem";
	 }
	}
	}
  }
	} else {
	 $_SESSION['err_msg']="Invalid Token Error";
	}
}
?>

	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Welcome to International Registration</title>
	<link rel="shortcut icon" href="images/fav.png"/>
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
	<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>"/>
	<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>"/>	 
	<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>"/>
	<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>"/>
	<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
	<!--NAV-->
<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
<!--<script src="js/jquery.flexnav.js" type="text/javascript"></script>-->
<script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js"></script>
<script src="js/common.js?v=<?php echo $version;?>"></script> 
<!--NAV-->

	<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
	<link rel="stylesheet" type="text/css" media="screen" href="css/rcmc.validation.css?v=<?php echo $version;?>"/> 
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178505237-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-178505237-1');
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
	<script type="text/javascript">
	$().ready(function() {
	jQuery.validator.addMethod("specialChrs", function (value, element) {
	if (/[^a-zA-Z 0-9\-]+$/i.test(value)) {
        return false;
    } else {
        return true;
	};
	},	"Special Characters Not Allowed");
   
	$("#regisForm").validate({
		rules: {  
			email_id: {
				required: true,
				email:true
			},  
			cemail_id:{
				required: true,
				email:true,
				equalTo: "#email_id"
			},
			company_type: {
				required: true,
			},
			company_name: {
				required: true,
				specialChrs: true
			}, 	 
			address_line1: {
				required: true,
				specialChrs: true
			},
			country: {
				required: true,
			},
			city: {
				required: true,
				specialChrs: true
			},
			state: {
				required: true,
			},
			pin_code: {
				required: true,
				number:true
			},
			land_line_no: {
				required: true,
				number:true
			},
			mobile_no: {
				required: true,
				number:true
			},
			nature_of_buisness:{
				required:true
			},
			terms_and_cond:{
				required: true,
			},
			captcha_code:{
				required: true,
				remote: "check-captcha.php",
				type:"post"
			},
		},
		messages: {
			email_id: {
				required: "Please Enter Email id",
			},
			cemail_id: {
				required: "Please Enter Email id",
				equalTo: "Please Enter the same Email id as above"
			},
			company_type: {
				required: "Please Select Company type",
			},   
			company_name: {
				required: "Please Enter Company Name",
			},
			address_line1: {
				required: "Please Enter Your Address",
			},
			city: {
				required: "Please Enter City",
			},
			country: {
				required: "Please Choose Country",
			},
			state: {
				required: "Please Enter state",
			},
			pin_code: {
				required: "Please Enter Pin Code",
				number:"Please Enter Numbers only"
			},  
			land_line_no: {
				required: "Please Enter landline number",
				number:"Please Enter Numbers only"
			},
			mobile_no: {
				required:"Please Enter Mobile Number",
				number:"Please Enter Numbers only"
			},
			nature_of_buisness: {
				required: "Please selct bussiness nature",
			},  
			terms_and_cond: {
				required:"Required.",
			},
			captcha_code:{
					required: "Please Enter Captcha Code",
					remote: "Captcha Entered Incorrectly"
			}
	 }
	});
});
</script>
<script language='JavaScript' type='text/javascript'>
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
<script>
$(document).ready(function(){
$("#country").change(function(){
	country=$("#country").val();
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=getTaxation&country="+country,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							     //alert(data);
							     $("#taxationDiv").html(data);  
							}
		});
});
/*$("#otherField").click(function(){

	alert("0sssss");
	$("otherDiv").show();
});*/
});

</script>
<script type="text/javascript">
function valueChanged()
{
    if($('.otherField').is(":checked"))   
        $("#otherDiv").slideDown();
    else
        $("#otherDiv").slideUp();
}
</script>
 
<script>
$(document).ready(function(){
  $("#email_id").change(function(){
	email_id=$("#email_id").val();
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=chkregisuser&email_id="+email_id,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							     //alert(data);
								 if(data==0){
								 	$('#register').attr('disabled' , true);
									$("#chkregisuser").html("Already registered with this email id").css("color", "red"); 
								 }else{
								 	$("#chkregisuser").html("");
								 	$('#register').removeAttr("disabled");
								 }
							}
		});
 });
});
</script>

<script>
$(document).ready(function(){
  $("#company_pan_no").change(function(){
	company_pan_no=$("#company_pan_no").val();
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=chkpan&company_pan_no="+company_pan_no,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							     //alert(data);
								 if(data==0){
								 	$('#register').attr('disabled' , true);
									$("#chkpanuser").html("Already registered with this pan no").css("color", "red"); 
								 }else{
								 	$('#register').removeAttr("disabled");
									$("#chkpanuser").html("")
								 }
							}
		});
 });
});
</script>
<script>
$(document).ready(function(){
$('#member_of_any_other_organisation').click(function(){
//alert('disapprove');
		$('#organisation_name').show();
      });
	  $('#member_of_any_other_organisation_no').click(function(){
//alert('disapprove');
		$('#organisation_name').hide();
      });
});
</script>
<style>
	#regisForm .textField, #form .textField{    width: 45%;float: right;
    border: 1px solid #ddd;
    height: 25px; padding:0 1%;}
    select.textField{    width: 47%!important}
	#regisForm .field, #form .field{width:100%; margin-bottom: 15px; }
	#regisForm label, #form label{min-width: 45%!important}
	#form .field{width:100%!important}
</style>
</head>

<body>
<div class="wrapper">
	<div class="header">
		<?php include('header1.php'); ?>
	</div>

<div class="clear"></div>

<!--container starts-->
<div class="container_wrap">
	<div class="container">
    	<div class="container_left">    	
        	<span class="headtxt">International Registration </span>	
			<div id="loginForm"><span id="chkregisuser" style="color:#FF0000;"></span>	
	<?php 
	if($_SESSION['err_msg']!=""){
	echo "<span style='color: red;'>".$_SESSION['err_msg']."</span>";
	$_SESSION['err_msg']="";
	}
	if($_SESSION['succ_msg']!=""){
	echo "<span style='color: green;'>".$_SESSION['succ_msg']."</span>";
	$_SESSION['succ_msg']="";
	}
	else{
	?>
  <form class="cmxform" method="post" name="regisForm" id="regisForm" autocomplete="off">    
  <div id="formContainer">
<div class="title">
    <h4>Fill In the Details</h4>
    </div>
    <div class="clear"></div>
    <div class="borderBottom"></div>
         <input type="hidden" name="action" value="save" />
		<?php token(); ?>		 
    <div id="form">
        <div class="field">
            <label>Email address (Username):</label>
            <input type="text" class="textField" id="email_id" name="email_id" value="<?php echo $email;?>" autocomplete="off"/>    
            <div class="clear"></div>
        </div>
        <div class="field">
            <label>Confirm Email address : <sup>*</sup></label>
            <input type="text" class="textField" id="cemail_ids" name="cemail_id" value="<?php echo $cemail_ids;?>" autocomplete="off"/>        
            <div class="clear"></div>
        </div>
        <div class="field">
            <label>Country : <sup>*</sup></label>
            <select name="country" id="country" class="textField"> 
				<option value="">---------- Select Country ----------</option>
				   <?php 
					$query=$conn->query("SELECT * FROM country_master where country_code!='IN' order by country_name ASC");
					while($result=$query->fetch_assoc()){ ?>
					<option value="<?php echo $result['country_code'];?>"><?php echo strtoupper($result['country_name']);?></option>
					<?php }?>
			</select>        
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="bottomSpace"></div>       
    <div class="title">
    <h4>Company Information</h4>
    </div>
    <div class="clear"></div>
    <div class="borderBottom"></div>  
             
    <div id="form">
        <div class="field"> 
        	<label>Company Type : <sup>*</sup></label>
        	<select class="textField" name="company_type" id="company_type">
        		<option value="">---Select Company Type---</option>
        		<option value="14">Proprietary</option>
        		<option value="11">Partnership</option>
        		<option value="13">Private Ltd.</option>
        		<option value="12">Public Ltd.</option>
        		<option value="19">LLP</option>
        	</select>

            <!-- <div class="clear"></div>
            <label for="Propritory">
			<input type="radio" id="company_type" name="company_type" value="propritory" style="display:inline-block; margin:0 5px;">Propritory </label>
            <label for="Partnership">
            <input type="radio" id="company_type" name="company_type" value="partnership" style="display:inline-block;">Partnership </label>
            <label for="Private">
            <input type="radio" id="company_type" name="company_type" value="pvt" style="display:inline-block;">Private Ltd.</label>
            <label for="Public">
            <input type="radio" id="company_type" name="company_type" value="public" style="display:inline-block;">Public Ltd.</label>
            
			<label for="company_type" generated="true" style="display: none;" class="error">Please Select Company type</label>
			<div class="clear"></div> -->
        </div>
        <div class="field">
            <label>Company Name : <sup>*</sup></label>
            <input type="text" class="textField" id="company_name" name="company_name" value="<?php echo $company_name;?>" autocomplete="off"/>        
            <div class="clear"></div>
        </div>
        <div class="field">
            <label>Address Line 1 : <sup>*</sup></label>
            <input type="text" class="textField" id="address_line1" name="address_line1" value="<?php echo $address_line1;?>" autocomplete="off"/>        
            <div class="clear"></div>
        </div>
        <div class="field">
            <label>Address Line 2: </label>
            <input type="text" class="textField" id="address_line2" name="address_line2" value="<?php echo $address_line2;?>" autocomplete="off"/>        
            <div class="clear"></div>
        </div>
        <div class="field">
        <label>Address Line 3: </label>
        <input type="text" class="textField" id="address_line3" name="address_line3" value="<?php echo $address_line3;?>" autocomplete="off"/>        
        <div class="clear"></div>
        </div>
        <div class="field">
        <label>State/Province : <sup>*</sup></label>
        <input type="text" class="textField" id="state" name="state" value="<?php echo $state;?>" autocomplete="off"/>        
        <div class="clear"></div>
        </div>  
        <div class="field">
        <label>City: <sup>*</sup></label>
        <input type="text" class="textField" id="city" name="city" value="<?php echo $city;?>" autocomplete="off"/>        
        <div class="clear"></div>
        </div>
        <div class="field">
        <label>Zip Code / Pin Code: <sup>*</sup></label>
        <input type="text" class="textField" id="pin_code" name="pin_code" value="<?php echo $pin_code;?>" maxlength="8" autocomplete="off"/>        
        <div class="clear"></div>
        </div>
        <div class="field">
        <label>Office No: <sup>*</sup></label>
        <input type="text" class="textField" id="land_line_no" name="land_line_no" value="<?php echo $land_line_no;?>" autocomplete="off"/>        
        <div class="clear"></div>
        </div>
        <div class="field">
        <label>Mobile no: <sup>*</sup></label>
        <input type="text" class="textField" id="mobile_no" name="mobile_no" value="<?php echo $mobile_no;?>" maxlength="12" autocomplete="off"/>        
        <div class="clear"></div>
        </div>
        <div class="field">
        	<label>Business Nature : <sup>*</sup></label>
            <div class="clear"></div>
            <label for="Retailer">
			<input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Retailer"> Retailer</label>
           <!--  <label for="Wholesaler">
			<input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Wholesaler"> Wholesaler Agent</label> -->
            <label for="Importers">
			<input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="IE"> Importers / Exporters</label>
            <label for="Manufacturer">
			<input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Manufacturer"> Manufacturer</label>
			<label for="Manufacturer">
			<input type="checkbox" class="otherField" onchange="valueChanged()" name="nature_of_buisness[]" id="nature_of_buisness"  value="other"> Other</label>
            <div class="clear"></div>
        </div>
        <div class="field " id="otherDiv" style="display: none;">
            <label> If Other Specify: <sup>*</sup></label>
            <input type="text" class="textField" id="other" name="nature_of_buisness[]" placeholder="Other" autocomplete="off"/>        
            <div class="clear"></div>
        </div>
    
    <div class="bottomSpace"></div>
    <div class="title">
    <h4>Terms of Agreement</h4>
    </div>
    <div class="clear"></div>
    <div class="borderBottom"></div>
    <div class="body_text">These are the general terms and conditions of&nbsp;Gems and Jewellery Export Promotion Council&nbsp;(GJEPC) for use of the GJEPC web site. Please read these terms and conditions carefully as your use of the Site is subject to them. GJEPC reserves the right at its sole discretion to change, modify or add to these terms and conditions without prior notice to you. By continuing to use the Site you agree to be bound by such amended terms.
    <ol>
				<li>What you are allowed to do You may:
				<ol>
					<li>browse the Site and view the information on it for personal, professional or other commercial purposes;</li>
					<li>print off pages from the Site to the extent reasonably necessary for your use of the Site in accordance with the above. Provided that at all times you do not do any of the things set out in clause 2.</li>
				</ol>
				</li>
				<li>What you are not allowed to do Subject to these terms and conditions, you may not:
				<ol>
					<li>systematically copy (whether by printing off onto paper, storing on disk or in any other way) substantial parts of the Site;</li>
					<li>remove, change or obscure in any way anything on the Site or otherwise use any material contained on the Site except as set out in these terms and conditions;</li>
					<li>include or create hyperlinks to the Site or any materials contained on the Site; or</li>
					<li>use the Site and anything available from the Site in order to produce any publication or otherwise provide any service that competes with the Site (whether on-line or by other media); or</li>
					<li>for unlawful purposes and you shall comply with all applicable laws, statutes and regulations at all times.</li>
				</ol>
				</li>
				<li>No Investment Advice You acknowledge that:
				<ol>
					<li>GJEPC does not provide investment advice and that nothing on the Site constitutes investment advice (as defined in the Financial Services Act 1986) and that you will not treat any of the Site&#39;s content as such;</li>
					<li>GJEPC does not recommend any financial product;</li>
					<li>GJEPC does not recommend that any financial product should be bought, sold or held by you; and</li>
					<li>nothing on the Site should be construed as an offer, nor the solicitation of an offer, to buy or sell securities by GJEPC</li>
					<li>information which may be referred to on the Site from time to time may not be suitable for you and that you should not make any investment decision without consulting a fully qualified financial adviser.</li>
				</ol>
				</li>
				<li>Access The Site is directed exclusively at users located within the United Kingdom and as such any use of the site by users outside India is at their sole risk. By using the Site you confirm that you are located within India and that you are permitted by law to use the Site.</li>
				<li>Your personal information:<br />
				GJEPC&#39;s use of your personal information is governed by GJEPC&#39;s Privacy Policy, which forms part of these terms and conditions.</li>
				<li>Copyright and Trade Marks
				<ol>
					<li>All copyright and other intellectual property rights in any material (including text, photographs and other images and sound) contained in the Site is either owned by GJEPC or has been licensed to GJEPC by the rights owner(s) for use by GJEPC on the Site. You are only allowed to use the Site and the material contained in the Site as set out in these terms and conditions.</li>
					<li>The Site contains trade marks, including the GJEPC name and logo. All trade marks included on the Site belong to GJEPC or have been licensed to GJEPC by the trade mark owner(s) for use on the Site. You are not allowed to copy or otherwise use any of these trade marks in any way except as set out in these terms and conditions.</li>
				</ol>
				</li>
				<li>Exclusions and limitations of liability
				<ol>
					<li>GJEPC does not exclude or limit its liability for death or personal injury resulting from its negligence, fraud or any other liability which may not by applicable law be excluded or limited.</li>
					<li>Subject to clause 7.1, in no event shall GJEPC be liable (whether for breach of contract, negligence or for any other reason) for (i) any loss of profits, (ii) exemplary or special damages, (iii) loss of sales, (iv) loss of revenue, (v) loss of goodwill, (vi) loss of any software or data, (vii) loss of bargain, (viii) loss of opportunity, (ix) loss of use of computer equipment, software or data, (x) loss of or waste of management or other staff time, or (xi) for any indirect, consequential or special loss, however arising.</li>
				</ol>
				</li>
				<li>Disclaimer
				<ol>
					<li>ALL INFORMATION CONTAINED ON THE SITE IS FOR GENERAL INFORMATIONAL USE ONLY AND SHOULD NOT BE RELIED UPON BY YOU IN MAKING ANY INVESTMENT DECISION. THE SITE DOES NOT PROVIDE INVESTMENT ADVICE AND NOTHING ON THE SITE SHOULD BE CONSTRUED AS BEING INVESTMENT ADVICE. BEFORE MAKING ANY INVESTMENT CHOICE YOU SHOULD ALWAYS CONSULT A FULLY QUALIFIED FINANCIAL ADVISER.</li>
					<li>ALTHOUGH GJEPC USES ITS REASONABLE EFFORTS TO ENSURE THAT INFORMATION ON THE SITE IS ACCURATE AND COMPLETE, WE CANNOT GUARANTEE THIS TO BE THE CASE. AS A RESULT, USE OF THE SITE IS AT YOUR SOLE RISK AND GJEPC CANNOT ACCEPT ANY LIABILITY FOR LOSS OR DAMAGE SUFFERED BY YOU ARISING FROM YOUR USE OF INFORMATION CONTAINED ON THE SITE. YOU SHOULD TAKE ADEQUATE STEPS TO VERIFY THE ACCURACY AND COMPLETENESS OF ANY INFORMATION CONTAINED ON THE SITE.</li>
					<li>Information contained on the site is not tailored for individual use and as a result such information may be unsuitable for you and your investment decisions. You should consult a financial adviser before making any investment decision.</li>
					<li>The Site includes advertisements and links to external sites and co-branded pages in order to provide you with access to information and services which you may find useful or interesting. GJEPC does not endorse such sites nor approve any content, information, goods or services provided by them and cannot accept any responsibility or liability for any loss or damage suffered by you as a result of your use of such sites.</li>
					<li>GJEPC is unable to exercise control over the security or content of information passing over the network or via the Service, and GJEPC hereby excludes all liability of any kind for the transmission or reception of infringing or unlawful information of whatever nature.</li>
					<li>GJEPC accepts no liability for loss or damage suffered by you as a result of accessing Site content which contains any virus or which has been maliciously corrupted.</li>
				</ol>
				</li>
				<li>Availability and updating of the Site
				<ol>
					<li>GJEPC may suspend the operation of the Site for repair or maintenance work or in order to update or upgrade its content or functionality from time to time. GJEPC does not warrant that access to or use of the Site or of any sites or pages linked to it will be uninterrupted or error free.</li>
					<li>GJEPC may change the format and content of the Site at its sole discretion from time to time. You should refresh your browser each time you visit the Site to ensure that you access the most up to date version of the Site.</li>
				</ol>
				</li>
				<li>Enquiries or complaints<br />
				If you have any enquiries or complaints about the Site then please address them (within 30 days of such enquiry or complaint first arising) to : email: info@gjepc.org</li>
				<li>General and governing law
				<ol>
					<li>These terms and conditions form the entire understanding of the parties and supersede all previous agreements, understandings and representations relating to the subject matter. If any provision of these terms and conditions is found to be unenforceable, this shall not affect the validity of any other provision. GJEPC may delay enforcing its rights under these terms and conditions without losing them. You agree that GJEPC may sub-contract the performance of any of its obligations or may assign these terms and conditions or any of its rights or obligations without giving you notice.</li>
					<li>GJEPC will not be liable to you for any breach of these terms and conditions which arises because of any circumstances which GJEPC cannot reasonably be expected to control.</li>
					<li>These terms and conditions shall be governed and interpreted in accordance with Indian law, and you consent to the non-exclusive jurisdiction of the Indian courts.</li>
				</ol>
				</li>
			</ol></div>
    
	<div class="field">
    <label style="padding-top:0px;">&nbsp;</label>
    <img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg'/>	
    <div class="clear"></div>
    </div>
	
	<div class="field">
    <label style="padding-top:0px;">Captcha : <sup>*</sup></label>
    <input type="text" class="textField" id="captcha_code" name="captcha_code" autocomplete="off" />	
    <div class="clear"></div>
    </div>
	
    <div class="form-item" id="edit-terms-checkbox-wrapper">
    <label class="option" for="edit-terms-checkbox"><input type="checkbox" name="terms_and_cond" id="terms_and_cond" value="1" class="form-checkbox"> I have read and agreed to the 'Terms of Agreement' above. </label><label for="terms_and_cond" generated="true" class="error" style="display:none"></label>
    
    <div class="form-item" id="edit-terms-checkbox-wrapper">
    <label class="option" for="edit-terms-checkbox">This question is for testing whether you are a human visitor and to prevent automated spam submissions.</label>
    
    <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <div><button type="submit" id="register" class="btn btn-default">Submit</button>
		<button type="reset" class="btn btn-default">Reset</button></div>
    <div class="clear"></div>
    </div>      
   </div>
   </div>
</form>   
<?php } ?>            
</div>
          
</div>
<?php //include ('rightContent.php'); ?>
<div class="clear"></div>
</div>
<div class="container_2">
<?php include ('container2.php'); ?>
</div>    
</div>
<!--container ends-->
<!--footer starts-->
<div class="footer">
<?php include ('footer.php'); ?>
</div>
</div>
<!--footer ends-->

<link rel="stylesheet" type="text/css" href="css/new_style.css" />

</body>
</html>