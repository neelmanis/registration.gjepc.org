<?php include('header_include.php');?>
<?php
//echo '<pre>'; print_r($_SESSION);
$action=$_REQUEST['action'];
if($action=="save")
{ 	//echo '<pre>'; print_r($_POST); 
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	
	$email_id 		= filter(strtolower($_REQUEST['email_id']));
	$company_pan_no = strtoupper(filter($_REQUEST['company_pan_no']));
	$company_gstn   = strtoupper(filter($_REQUEST['company_gstn']));
	$company_type   = $_REQUEST['company_type'];
    $pass 		= generatePassword();
	$company_name   = strtoupper(filter($_REQUEST['company_name']));
	$mobile_no = filter($_REQUEST['mobile_no']);
	$land_line_no = filter($_REQUEST['land_line_no']);
    $member_of_any_other_organisation = $_REQUEST['member_of_any_other_organisation'];
	$name_of_organisation = strtoupper($_REQUEST['name_of_organisation']);
	$nature_of_buisness = $_REQUEST['nature_of_buisness'];
		
	foreach($nature_of_buisness as $val)
	{
		if($val=="other")
		{
			$nature_of_buisness_other = $_REQUEST['nature_of_buisness_other'];
			$nature_of_buisness_new.= $nature_of_buisness_other.",";
		} else {
			$nature_of_buisness_new.=$val.",";	
		}
	}
	$dt=date('Y-m-d');
	$ip = $_SERVER['REMOTE_ADDR'];
	$website = "Registration - ".  date("Y");
	$query=$conn->query("select * from registration_master where email_id='$email_id' or company_pan_no='$company_pan_no' or mobile_no='$mobile_no'");
	$num=$query->num_rows;
	if(empty($email_id))
	{
		$_SESSION['err_msg']="Please Enter Email Id";
	}
	else if(!ninjaxMailCheck($email_id))
	{
		$_SESSION['err_msg'] = $email_id. " is Invalid Email Id";
	}
	else if(empty($_FILES['pan_no_copy']['name']))
	{	
		$_SESSION['err_msg']="Please Upload PAN Copy";
	}else if(empty($_FILES['gst_copy']['name']))
	{	
		$_SESSION['err_msg']="Please Upload GST Copy Or Company Document";
	}else if(empty($mobile_no))
	{	
		$_SESSION['err_msg']="Please Enter Mobile Number";
	}else if(empty($company_pan_no))
	{	
		$_SESSION['err_msg']="Please Enter Company PAN Number";
	}
	else if($num>0)
	{	
		$_SESSION['err_msg']="Already registered with this Email id or PAN No or Mobile No";
	}
	else
	{
		if(isset($_FILES['pan_no_copy']) && !empty($_FILES['pan_no_copy']['name']))
		{
			$pan_no_copy_name=$_FILES['pan_no_copy']['name'];
			$pan_no_copy_temp=$_FILES['pan_no_copy']['tmp_name'];
			$pan_no_copy_type=$_FILES['pan_no_copy']['type'];
			$pan_no_copy_size=$_FILES['pan_no_copy']['size'];
			$attach="pan_no_copy";
			if($pan_no_copy_name!="")
			{
				$create_pan_no_copy = 'images/'.$attach;
				if (!file_exists($create_pan_no_copy)) {
				mkdir($create_partner, 0777);
				}
				$pan_no_copy = uploadRegistrationPan($pan_no_copy_name,$pan_no_copy_temp,$pan_no_copy_type,$pan_no_copy_size,$company_pan_no);
			}
		} else {
		$_SESSION['err_msg']="Please Upload PAN Copy";
		}
		
		if(isset($_FILES['gst_copy']) && !empty($_FILES['gst_copy']['name']))
		{
			$gst_copy_name=$_FILES['gst_copy']['name'];
			$gst_no_copy_temp=$_FILES['gst_copy']['tmp_name'];
			$gst_no_copy_type=$_FILES['gst_copy']['type'];
			$gst_no_copy_size=$_FILES['gst_copy']['size'];
			$attach="gst_copy";
			if($pan_no_copy_name!="")
			{
				$create_pan_no_copy = 'images/'.$attach;
				if (!file_exists($create_pan_no_copy)) {
				mkdir($create_partner, 0777);
				}
				$gst_copy = uploadRegistrationGst_copy($gst_copy_name,$gst_no_copy_temp,$gst_no_copy_type,$gst_no_copy_size,$company_pan_no);
			}
		} else {
		$_SESSION['err_msg']="Please Upload GST Copy";
		}
	
    if(!empty($email_id) && !empty($company_pan_no) && !empty($company_name) && !empty($pan_no_copy)) {
	$hash = md5( rand(0,1000) );
	$password = md5($pass);
	$sql="insert into registration_master set email_id='$email_id',old_pass='$pass',company_secret='$password',company_pan_no='$company_pan_no',company_gstn='$company_gstn',company_type='$company_type',company_name='$company_name',country='IN',pan_no_copy='$pan_no_copy',gst_copy='$gst_copy',land_line_no='$land_line_no',mobile_no='$mobile_no',member_of_any_other_organisation='$member_of_any_other_organisation',name_of_organisation='$name_of_organisation',nature_of_buisness='$nature_of_buisness_new',status='0',website='$website',post_date='$dt',ip='$ip',hash='$hash'";
	$result = $conn->query($sql);	
	if($result){
	$uid = $conn->insert_id;
	$_SESSION['regis_id'] = $uid;
	/*.......................................Send mail to users mail id...............................................*/
  $message ='<table cellpadding="10" width="65%" style="margin:0px auto;font-family: Roboto; background-color:#eeee;padding:30px; border-collapse:collapse;">
<tr><td style="background-color:#744F9E;padding:3px;"></td></tr>
  <tr><td align="left"><img src="https://gjepc.org/assets/images/logo.png"> </td></tr>
  <tr style="background-color:#eeee;padding:30px;">
  <td><h4 style="margin:0;">Thank you for registering at Gems and Jewellery Export Promotion Council (GJEPC).</h4></td></tr>
  <tr style="background-color:#eeee;padding:30px;">
  <td>Your account has been created, Please click The following link For verifying and activation of your account</td></tr>
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
	 $headers  = 'MIME-Version: 1.0' . "\r\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
	 $headers .= 'From: GJEPC <admin@gjepc.org>';		
	 mail($to, $subject, $message, $headers);
	 header('location:domestic_user_registration_step2.php');
	 } else {
	 $_SESSION['err_msg']="There is some technical problem";
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
	<title>Domestic User Registration Step - 1</title>
	<link rel="icon" href="https://gjepc.org/images/favicon.ico" type="image/x-icon"/>
	<!--<link rel="stylesheet" type="text/css" href="css/mystyle.css" />-->
    <link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />	 
	<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
	<script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>

	<!--NAV-->
	<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
	<!--<script src="js/jquery.flexnav.js" type="text/javascript"></script>-->
	<script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js?v=<?php echo $version;?>"></script>
	<script src="js/common.js?v=<?php echo $version;?>"></script> 
	<!--NAV-->
	<script src="jsvalidation/jquery.validate.js?v=<?php echo $version;?>" type="text/javascript"></script> 
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178505237-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-178505237-1');
</script>

<!-- Global site tag (gtag.js) - Google Ads: 679097911 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-679097911"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-679097911');
</script>
<!-- Event snippet for Step 1 conversion conversion page
In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
<script>
function gtag_report_conversion(url) {
  var callback = function () {
    if (typeof(url) != 'undefined') {
      window.location = url;
    }
  };
  gtag('event', 'conversion', {
      'send_to': 'AW-679097911/XLmJCLbMuu0CELfs6MMC',
      'event_callback': callback
  });
  return false;
}
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
	
  gtag_report_conversion();
  fbq('track', 'Step1');

</script>
	<script type="text/javascript">
	$().ready(function() {
	jQuery.validator.addMethod("specialChrs", function (value, element) {
	if (/[^a-zA-Z 0-9\-]+$/i.test(value)) {
        return false;
    } else {
        return true;
    };
    },	"Special Characters Not Allowed");
	
	jQuery.validator.addMethod("Chrs", function (value, element) {
	if (/[^a-zA-Z\-]+$/i.test(value)) {
        return false;
    } else {
        return true;
    };
    },	"Only Characters are Allowed");
    
	jQuery.validator.addMethod("mobno", function (value, element) {
	var regExp = /^[6-9]\d{9}$/; 
	if (value.match(regExp) ) {
		return true;
	} else {
		return false;
	};
	},"Please Enter valid Mobile No");
	
	jQuery.validator.addMethod("panno", function (value, element) {
	var regExp = /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/; 
	if (value.match(regExp) ) {
		return true;
	} else {
		return false;
	};
	},"Please Enter valid PAN No");
	
	$("input[name='gstholder_status']").on('change', function () {
         var gst_holder = $("input[name='gstholder_status']:checked").val();
         if(gst_holder=='N')
               $("#company_gstn").val("NA");
		  else
		  	$("#company_gstn").val("");
    });
		
	$.validator.addMethod("company_gstn", function(value, element) {
		var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$');
		if (gstinformat.test(value)) {
			return true;
		} else {
			return false;
		}
	},"Please Enter Valid GSTIN Number");
	

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
			company_pan_no: {
				required: true,
				panno: true,
				minlength: 10,
				maxlength:10
			},
			gstholder_status:{
				required: true, 
			},
			company_gstn: {
                required: true,
                minlength: 15,
                maxlength: 15,
				company_gstn: true
            },	
			pan_no_copy:{
				required: true,
			},
			company_type: {
				required: true,
			},
			company_name: {
				required: true,
				specialChrs: true,
				maxlength:38
			}, 	 
			address_line1: {
				required: true,
				specialChrs: true
				},
			address_line2: {
				required: true,
				specialChrs: true
				},
			city: {
				required: true,
				Chrs: true
				},
			country: {
				required: true,
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
				},
			mobile_no: {
				required: true,
				number:true,
				minlength: 10,
				maxlength:10,
				mobno: true
				},
			member_of_any_other_organisation: {
				required: true,
				},
			nature_of_buisness: {
				required: true,
				},
			terms_and_cond:
			{
				required: true,
			},
			captcha_code:{
				  required: true,
			},
		},
		messages: {
			email_id: {
				required: "Please Enter a valid Email id",
			},
			cemail_id: {
				required: "Please Enter a valid Email id",
				equalTo: "Please Enter the same Email id as above"
			},  
			company_pan_no: {
				required: "Enter Company PAN no",
				minlength:"Please enter at least {10} digit.",
				maxlength:"Please enter no more than {0} digit."
			},
			gstholder_status:{
				required: "Please Select GST Holder", 
			},
			company_gstn: {
				required: "Please Enter GSTIN No.",
				minlength:"Please enter not less than 15 characters",
				maxlength:"Please enter not more than 15 characters"
			},
			pan_no_copy:{
				required: "Upload Company PAN copy",
			},
			company_type: {
				required: "Please Select Company type",
			},   
			company_name: {
				required: "Please Enter Company Name",
				maxlength:"Please enter no more than {38} digit."
			},  
			address_line1: {
				required: "Please Enter Your Address",
			},
			address_line2: {
				required: "Please Enter Your Address",
			},
			city: {
				required: "Please Enter City",
			},
			country: {
				required: "Please Choose Country",
			},
			state: {
				required: "Please Choose state",
			}, 
			pin_code: {
				required: "Please Enter Pin Code",
				number:"Please Enter Numbers only"
			}, 
			land_line_no: {
				required: "Please Enter landline number",
			},
			mobile_no: {
				required:"Please Enter Mobile Number",
				number:"Please Enter Numbers only",
				minlength:"Please enter at least {10} digit.",
				maxlength:"Please enter no more than {10} digit."
			},
			member_of_any_other_organisation: {
				required: "Choose Organization",
			},
			nature_of_buisness: {
				required: "Please select bussiness nature",
			},  
			terms_and_cond: {
			required:"Required.",
			},
			captcha_code:{
					required: "Please Enter Captcha Code",
			}
	 }
	});
});
</script>
<style>
	.loader {
    position: fixed;
	display:none;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('images/progress.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: 80;
	}
	.body_text{height: 95px;margin-top: 20px;}
	ol li{list-style: disc;}
</style>
<script>
$(document).ready(function(){
  $("#email_id").change(function(){
	email_id=$("#email_id").val();
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=chkregisuser&email_id="+email_id,
					dataType:'html',
					beforeSend: function(){
							$('.loader').show();
							},
					success: function(data){
							     //alert(data);
								 if(data==0){
									$('.loader').hide();
								 	$('#register').attr('disabled', true);
									$("#chkregisuser").html("Already registered with this Email Id").css("color", "red"); 
								 }else{
									$('.loader').hide();
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
						$('.loader').show();
							},
					success: function(data){
							     //alert(data);
								 if(data==0){
									$('.loader').hide();
								 	$('#register').attr('disabled' , true);
									$("#chkpanuser").html("Already registered with this PAN No").css("color", "red"); 
								 }else{
									$('.loader').hide();
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
  $("#company_gstn").change(function(){
	company_gstn=$("#company_gstn").val();
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=chkgstin&company_gstn="+company_gstn,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							     //alert(data);
								 if(data==0){
								 	$('#register').attr('disabled' , true);
									$("#chkgstnuser").html("Already registered with this GSTIN No").css("color", "red"); 
								 }else{
								 	$('#register').removeAttr("disabled");
									$("#chkgstnuser").html("")
								 }
							}
		});
 });
});
</script>

<script>
$(document).ready(function(){
  $("#mobile_no").change(function(){
	mobile_no=$("#mobile_no").val();
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=chkRegistrationMobileNO&mobile_no="+mobile_no,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							     //alert(data);
								 if(data==0){
								 	$('#register').attr('disabled' , true);
									$("#chkMobileuser").html("Already registered with this Mobile No").css("color", "red"); 
								 }else{
								 	$('#register').removeAttr("disabled");
									$("#chkMobileuser").html("")
								 }
							}
		});
 });
});
</script>

<script>
$(document).ready(function(){

	$("input[name=member_of_any_other_organisation]").change(function(){
	if($(this).val()=="Y")
		$("#organisation_name").show();
	else
		$("#organisation_name").hide();	
	});
	  
	/*  $('#member_of_any_other_organisation_no').click(function(){
//alert('disapprove');
		$('#organisation_name').hide();
      }); */
	  
      $('.gstholder_status_no').click(function(){
        
		$('#companyDoc').html("<ul class='error'><li>(Kindly upload Max 2MB. jpeg, png,pdf)</li><li>Kindly upload Shop certificate / Gomastha Lisence</li></ul>");
		$("#gst_status").attr('disabled',true);
		$('#company_gstn').attr('placeholder','Not Applicable');
		$('#company_gstn').attr('disabled',true);
      });
	  $('.gstholder_status_yes').click(function(){
        $('#company_gstn').attr('placeholder','GST Number');
		$('#company_gstn').attr('disabled',false);
		$('#companyDoc').html("<ul class='error'><li>(Kindly upload Max 2MB. jpeg, png,pdf)</li><li>Kindly Upload GSTIN</li></ul>");
      });
});
</script>
</head>

<body>
    <div class="wrapper">
	<div class="loader">  <div style="display:table; width:100%; height:100%;"><span style="display:table-cell; vertical-align:middle; text-align:center; padding-top:100px;">Please wait....</span></div></div>
       <div class="header">
          <?php include('header1.php'); ?>
      </div>
     <!--  <div class="new_banner">
        <img src="images/iijs-virtual-1.jpg">
    </div> -->
    <div class="clear"></div>

    <!--container starts-->
    <div class="container_wrap">
		<div class="container">
        
           <span class="headtxt">Create Account : Domestic User Registration Step - 1</span>	
           
           
          
           <div id="loginForm">
		   <?php 
			if($_SESSION['err_msg']!=""){
			echo "<span style='color: red;'>".$_SESSION['err_msg']."</span>";
			$_SESSION['err_msg']="";
			}
			?>
           
        <div class="box-shadow">
        <div class="d-flex flex-row justify-center form-group m-10 form-tab">
			<label class="container_radio"><span class="check_text"></span>
			  <input type="radio" checked="checked" disabled>
			  <span class="checkmark_radio"></span>
			</label>
			<label class="container_radio radio_center"><span class="check_text"></span>
			  <input type="radio" disabled>
			  <span class="checkmark_radio"></span>
			</label>
		  <label class="container_radio"><span class="check_text"></span>
			  <input type="radio"disabled>
			  <span class="checkmark_radio"></span>
		  </label>
		</div>
           <div class="title">
            <h4>Account Information</h4>
            <p id="chkregisuser" style="color:#FF0000; display:block;"></p>
			<p id="chkpanuser"></p>
			<p id="chkgstnuser"></p>
			<p id="chkMobileuser"></p>
			</div>
        <div class="clear"></div>
        <div class="borderBottom"></div>
		
        <form class="" method="POST" name="regisForm" id="regisForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off" enctype="multipart/form-data">
		<input type="hidden" name="action" value="save" />
		<?php token(); ?>
		
           <div class="d-flex flex-column ">
              <div class="d-flex flex-row form-setup">
                <div class="col-50 d-flex justify-around flex-wrap form-group">
                <div class="col-50 d-flex align-baseline">
                    <label><span style="color: red;" />*</span>Email address (Username): </label>
                </div>
                <div class="col-50">
                    <input type="text" class="form-control" id="email_id" name="email_id" value="<?php echo $email_id;?>" autocomplete="off"/>
                </div>
				</div>
				<div class="col-50 d-flex justify-around flex-wrap form-group">
				  <div class="col-50 d-flex align-baseline">
					<label><span style="color: red;" />*</span>Confirm Email address : </label>
				</div>
				<div class="col-50">
					<input type="text" class="form-control" id="cemail_ids" name="cemail_id" autocomplete="off"/>
				</div>
				</div>
			  </div>
			<div class="d-flex flex-row form-setup">
			<div class="col-50 d-flex justify-around flex-wrap form-group">
			  <div class="col-50 d-flex align-baseline">
				<label><span style="color: red;" />*</span>Company Name : </label>
			</div>
			<div class="col-50">
				<input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo $company_name;?>" autocomplete="off"  maxlength='38'/>
			</div>
			</div>
			<div class="col-50 d-flex justify-around flex-wrap form-group">
				<div class="col-50 d-flex align-baseline">
				<label><span style="color: red;" />*</span>Mobile No : </label>
				</div>
				<div class="col-50">
				<input type="text" class="form-control" id="mobile_no" name="mobile_no" value="<?php echo $mobile_no;?>" maxlength="10" autocomplete="off"/>
				</div>
			</div>
			</div>

			<div class="d-flex flex-row form-setup">
				<div class="col-50 d-flex justify-around flex-wrap form-group">
				<div class="col-50 d-flex align-baseline">
					<label><span style="color: red;" />*</span>Company PAN No : </label>
				</div>
				<div class="col-50">
					<input type="text" class="form-control" id="company_pan_no" name="company_pan_no" value="<?php echo $company_pan_no;?>" maxlength="10" autocomplete="off"/> 
				</div>
				</div>
				<div class="col-50 d-flex justify-around flex-wrap form-group">
				<div class="col-50 d-flex align-baseline">
					<label><span style="color: red;" />*</span>Company PAN Upload : </label>
				</div>
				<div class="col-50">
					<input type="file" class="form-control" id="pan_no_copy" name="pan_no_copy" value="" accept=".jpg,.jpeg,.png,.pdf"/>
					(Kindly upload Max 2MB. jpeg, png,pdf)
				</div>
				</div>
			</div>
            <div class="d-flex flex-row form-setup">
				<div class="col-50 d-flex justify-around flex-wrap form-group ">
				<div class="col-50 d-flex align-baseline">
					<label>GST holder status:</label>
				</div>
				<div class="col-50 d-flex justify-around align-center">
					<label class="container_radio"><span class="check_text">Yes</span>
					  <input type="radio" id="gstholder_status" class="gstholder_status_yes" name="gstholder_status" value="Y">
					  <span class="checkmark_radio"></span>
				  </label>
				  <label class="container_radio"><span class="check_text">No</span>
					  <input type="radio" id="gstholder_status" class="gstholder_status_no" name="gstholder_status" value="N">
					  <span class="checkmark_radio"></span>
				  </label>
				</div>
				<label for="gstholder_status" generated="true" style="display: none;" class="error">Please Select GST Holder</label>
				</div>			
			</div>
			<div class="d-flex flex-row form-setup">
			<div class="col-50 d-flex justify-around flex-wrap form-group" id="gst_status">
				<div class="col-50 d-flex align-baseline">
				  <label>Company GSTIN : </label>
				</div>
				<div class="col-50">
				  <input type="text" class="form-control" id="company_gstn" name="company_gstn" value="<?php echo $company_gstn;?>" maxlength="15" autocomplete="off"/>
				</div>
			</div>
			<div class="col-50 d-flex justify-around flex-wrap form-group">
				<div class="col-50 d-flex align-baseline">
					<label><span style="color: red;" />*</span>Company DOC Upload : </label>
				</div>
				<div class="col-50">
					<input type="file" class="form-control" id="gst_copy" name="gst_copy" value="" accept=".jpg,.jpeg,.png,.pdf"/>
					 <div id="companyDoc"></div>
				</div>
			</div>
			</div>
			
			<div class=" d-flex flex-row form-setup">
			<div class="col-50 d-flex justify-around flex-wrap form-group">
				<div class="col-50 d-flex align-baseline">
				<label><span style="color: red;" />*</span>Telephone No : </label>
				</div>
				<div class="col-50">
				<input type="text" class="form-control" id="land_line_no" name="land_line_no" value="<?php echo $land_line_no;?>" maxlength="15" autocomplete="off" placeholder="022-22452158"/>
				</div>
			</div>
			<div class="col-50 d-flex justify-around flex-wrap form-group">
			</div>
			</div>
			
			<div class=" d-flex flex-row form-setup">
				<div class="col-50 d-flex justify-around flex-wrap form-group ">
				<div class="col-50 d-flex align-baseline">
					<label>Member Of Any Other Association :</label>
				</div>
				<div class="col-50 d-flex justify-around align-center">
					<label class="container_radio"><span class="check_text">Yes</span>
					  <input type="radio" id="member_of_any_other_organisation" name="member_of_any_other_organisation" value="Y">
					  <span class="checkmark_radio"></span>
				  </label>
				  <label class="container_radio"><span class="check_text">No</span>
					  <input type="radio" id="member_of_any_other_organisation" name="member_of_any_other_organisation" value="N">
					  <span class="checkmark_radio"></span>
				  </label>
				</div>
				</div>
			<div class="col-50 d-flex justify-around flex-wrap form-group" id="organisation_name">
			<div class="col-50 d-flex align-baseline">
				<label>Name Of Association : </label>
			</div>
			<div class="col-50">
			<input type="text" class="form-control" id="name_of_organisation" name="name_of_organisation" value="<?php echo $name_of_organisation;?>"  autocomplete="off"/>
			</div>
			</div>
			<label for="member_of_any_other_organisation" generated="true" style="display:none;" class="error">Please Choose Organization</label>
			</div>
			
		<div class="d-flex flex-column">   
		<div class="col-50 d-flex align-baseline form-group">
			<label><span style="color: red;" />*</span>Company Type : </label>
			<label for="company_type" generated="true" class="error" style="display:none;"> &nbsp; Please Select Company type</label>
		</div>
		
		<div class="d-flex flex-row justify-space-between form-group form-setup">
			<label class="container_radio"><span class="check_text">Proprietary</span>
			  <input type="radio" id="company_type" name="company_type" value="14">
			  <span class="checkmark_radio"></span>
			</label>
			<label class="container_radio"><span class="check_text">Partnership</span>
			  <input type="radio" id="company_type" name="company_type" value="11">
			  <span class="checkmark_radio"></span>
			</label>
			<label class="container_radio"><span class="check_text">Private</span>
			  <input type="radio" id="company_type" name="company_type" value="13">
			  <span class="checkmark_radio"></span>
			</label>
			<label class="container_radio"><span class="check_text">Public</span>
			  <input type="radio" id="company_type" name="company_type" value="12">
			  <span class="checkmark_radio"></span>
			</label>
			<label class="container_radio"><span class="check_text">LLP</span>
			  <input type="radio" id="company_type" name="company_type" value="19">
			  <span class="checkmark_radio"></span>
			</label>
			<label class="container_radio"><span class="check_text">HUF</span>
			  <input type="radio" id="company_type" name="company_type" value="15">
			  <span class="checkmark_radio"></span>
			</label>
		</div>
		</div>

    <div class="d-flex flex-column">
	<div class="col-50 d-flex align-center form-group">
		<label>Business Nature:</label>
	</div>
	<div class="d-flex flex-row justify-space-between form-group form-setup">
		<label class="container_check">Retailer
		  <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Retailer">
		  <span class="checkmark"></span>
	  </label>
	  <label class="container_check">Wholesaler Agent
		  <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Wholesaler">
		  <span class="checkmark"></span>
	  </label>
	  <label class="container_check">Importers / Exporters
		  <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="IE">
		  <span class="checkmark"></span>
	  </label>
	  <label class="container_check">Manufacturer
		  <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Manufacturer">
		  <span class="checkmark"></span>
	  </label>
	</div>
	</div>

	<div class=" d-flex flex-row form-setup">
	  <div class="col-50 d-flex justify-around flex-wrap form-group">
		<div class="col-50 d-flex align-center">
		  <label>Other : </label>
		</div>
		<div class="col-50">
		  <input type="text" class="form-control" id="other" name="nature_of_buisness[]" autocomplete="off"/>
		</div>
	  </div>
	 <div class="col-50 d-flex justify-around flex-wrap form-group"> </div>
	</div>
</div>

<div class="title">
  <h4>Terms of Agreement</h4>
</div>
<div class="clear"></div>
<div class="borderBottom"></div>
<div class="body_text">These are the general terms and conditions of &nbsp;Gems and Jewellery Export Promotion Council&nbsp;(GJEPC) for use of the GJEPC web site. Please read these terms and conditions carefully as your use of the Site is subject to them. GJEPC reserves the right at its sole discretion to change, modify or add to these terms and conditions without prior notice to you. By continuing to use the Site you agree to be bound by such amended terms.

<div id="open" style="display:none;">
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
    <li>GJEPC does not provide investment advice and that nothing on the Site constitutes investment advice (as defined in the Financial Services Act 1986) and that you will not treat any of the Site's content as such;</li>
    <li>GJEPC does not recommend any financial product;</li>
    <li>GJEPC does not recommend that any financial product should be bought, sold or held by you; and</li>
    <li>nothing on the Site should be construed as an offer, nor the solicitation of an offer, to buy or sell securities by GJEPC</li>
    <li>information which may be referred to on the Site from time to time may not be suitable for you and that you should not make any investment decision without consulting a fully qualified financial adviser.</li>
</ol>
</li>
<li>Access The Site is directed exclusively at users located within the United Kingdom and as such any use of the site by users outside India is at their sole risk. By using the Site you confirm that you are located within India and that you are permitted by law to use the Site.</li>
<li>Your personal information:<br>
GJEPC's use of your personal information is governed by GJEPC's Privacy Policy, which forms part of these terms and conditions.</li>
<li>Copyright and Trade Marks
  <ol>
    <li>All copyright and other intellectual property rights in any material (including text, photographs and other images and sound) contained in the Site is either owned by GJEPC or has been licensed to GJEPC by the rights owner(s) for use by GJEPC on the Sitee Site. You are only allowed to use the Site and the material contained in the Site as set out in these terms and conditions.</li>
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
<li>Enquiries or complaints<br>
If you have any enquiries or complaints about the Site then please address them (within 30 days of such enquiry or complaint first arising) to : email: info@gjepc.org</li>
<li>General and governing law
  <ol>
    <li>These terms and conditions form the entire understanding of the parties and supersede all previous agreements, understandings and representations relating to the subject matter. If any provision of these terms and conditions is found to be unenforceable, this shall not affect the validity of any other provision. GJEPC may delay enforcing its rights under these terms and conditions without losing them. You agree that GJEPC may sub-contract the performance of any of its obligations or may assign these terms and conditions or any of its rights or obligations without giving you notice.</li>
    <li>GJEPC will not be liable to you for any breach of these terms and conditions which arises because of any circumstances which GJEPC cannot reasonably be expected to control.</li>
    <li>These terms and conditions shall be governed and interpreted in accordance with Indian law, and you consent to the non-exclusive jurisdiction of the Indian courts.</li>
</ol>
</li>
</ol></div>

<a class="read_btn" style="color:#f00; font-weight:bold; display:block; cursor:pointer;">More >></a>
</div>


<div class="d-flex flex-column ">
    
<div class="d-flex flex-row form-setup">
    <div class="col-50 d-flex  flex-wrap form-group">
      <input type="submit"  name="submit" id="submit" value="Next" class="btn btn-submit">
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
<!--container ends-->
<!--footer starts-->
<div class="footer">
    <?php include ('footer.php'); ?>
</div>
</div>
<!--footer ends-->

<link rel="stylesheet" type="text/css" href="css/new_style.css" />
<script>
//read less
jQuery(".read_btn").click(function (e) { jQuery("#open").is(":visible") ? ($(this).text("More >>"), jQuery("#open").slideUp()) : ($(this).text("Less >>"), jQuery("#open").slideDown()) });


</script>

</body>
</html>