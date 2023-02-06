<?php 
include('header_include.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IIJS INTERNATIONAL VISITOR REGISTRATION</title>
    <link rel="icon" href="https://gjepc.org/assets/images/fav_icon.png" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
    <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
   <!--NAV-->
	<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js"></script>
	<script src="js/common.js?v=<?php echo $version;?>"></script> 
	<!--NAV-->
    <script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
   <!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178505237-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-178505237-1');
</script>
<script> gtag('event', 'conversion', {'send_to': 'AW-679056788/N1zUCJPKxLsBEJSr5sMC'}); </script> 

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
	
<!-- End Facebook Pixel Code -->
    <script type="text/javascript">
    $(document).ready(function() {
    $("#passportForm").validate({
      rules: {
        email_id: {
				required: true,
				email:true
		},
      },
      messages: {
        email_id: {
				required: "Please Enter a valid Email id",
		},
      },
      submitHandler: panAction
    });
    });
    
	$(document).ready(function() {
    $("#verifyOTP").validate({
    rules: {
    otp_number:{
    required:true
    }
    },
    messages: {
    otp_number:{
    required: "OTP number is required"
    }
    },
    submitHandler: verifyOTPAction
    });    
    });
	
	$(document).ready(function() {
    $("#sendOTP").validate({
    rules: {
    email:
    {
    required:true,
    },
    company:
    {
    required:true,
    }
    },
    messages: {
    email:{
    required: "Email is required",
    },
    company:{
    required: "Company Name is required",
    }
    },
    submitHandler: sendotpAction
    });
    
    });
	
	function panAction(){
    var formdata = $('#passportForm').serialize();
	$("#send_otp").attr("disabled");
    $.ajax({
    type:'POST',
    data:formdata,
    url:"singleINTLVisitorAjax_test.php",
    dataType: "json",
    beforeSend: function(){
    $('.loaderWrapper').show();
    },
    success:function(data){
        //alert(data);
    if(data.status == 'success'){
    $('#passportForm').hide();
    $('.form-notes').hide();
    $('#sendOTP').show();
    $('.loaderWrapper').delay(3000).fadeOut();
    $("#company").text(data.company);
    $("#email").text(data.email);
    $("#emails").val(data.email);
    $("#name").text(data.first_name);
    $("#lname").text(data.last_name);
    $("#designation").text(data.designation);

        /*  $("#photo").text(data.photo);*/ 
    $('#photo #images').attr('src','images/ivr_image/photograph/'+data.photo);
    $('#visiting_card_photo #visiting_card').attr('src','images/ivr_image/visiting_card/'+data.visit_card_fid);
    $('#passport_photo #passport').attr('src','images/ivr_image/passport/'+data.passport_fid);
    $("#send_otp").removeAttr("disabled");
    }else if(data.status =='error') {
    $('.loaderWrapper').delay(1000).fadeOut();
    $("#chkEmailStatus").html(data.message);
    
    }
    }
    });
    }
	
	/* Send OTP Email */
	function sendotpAction(){
    var formdata = $('#sendOTP').serialize();
    $.ajax({
    type:'POST',
    data:formdata,
    url:"singleINTLVisitorAjax_test.php",
    dataType: "json",
    beforeSend: function(){
    $('.loaderWrapper').show();
    },
    success:function(data){
    if(data.status == "successOtp"){
    
    $('#sendOTP').hide();
    $('#panForm').hide();
    $('#verifyOTP').show();
    $('.loaderWrapper').delay(2000).fadeOut();
    $("#email_otp").val(data.email);
    $("#otpSuccess").text("OTP Sent Successfully");
    $("#otpError").text("");
    } else if(data.status == "errorAlready"){    
    $('.loaderWrapper').delay(3000).fadeOut();
    $('#panForm').hide();
    $('#verifyOTP').hide();
    $('#sendOTP').show(); 
    }else if(data.status == "error"){    
    $('.loaderWrapper').delay(3000).fadeOut();
    $('#panForm').hide();
    $('#verifyOTP').hide();
    $('#sendOTP').show();
    $("#otpError").text("OTP not sent please try again");
    $("#otpSuccess").text("");
    }
    }
    });
    }
	
	
    function verifyOTPAction(){
    var formdata = $('#verifyOTP').serialize();    
    $.ajax({
    type:'POST',
    data:formdata,
    url:"singleINTLVisitorAjax_test.php",
    dataType: "json",
    beforeSend: function(){
    $('.loaderWrapper').show();
    },
    success:function(data){    
    if(data['status'] == "success"){    
        setTimeout(function(){
		window.location = "intl-visitor-covid-report-upload-step-2.php";
		}, 3000);
	
    } else if(data['status'] == "fail"){
      $('.loaderWrapper').delay(1000).fadeOut();
    $("#notMatch").text("OTP not matched");
    $("#otpSuccess").text("");
    }
    }
    });
    }
    </script>
<style type="text/css">
.form-notes{
  border: 1px solid#000;
  padding: 10px;
}
</style>

<link rel="stylesheet" type="text/css" href="css/new_style.css" /> 
</head>

<body>

<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=398834417477910&ev=PageView&noscript=1"/></noscript>

  <div class="wrapper">

    <div class="header"> <?php include('header1.php'); ?></div>

    <div class="container my-5">

      <div class="bold_font text-center">
        <div class="d-block">
          <img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
        </div>
        INTERNATIONAL VISITOR VACCINATION CERTIFICATE UPLOAD
      </div>
  <!--   <p><span class='blink d-block'>2 Vaccine Doses Mandatory For Entry</span> </p> -->
      <div id="loginForm">
        
        <div class="box-shadow">
          
          <div class="loaderWrapper">
            <div class="formLoader">
              <img src="images/formloader.gif" alt="">
              <p> Please Wait....</p>
            </div>
          </div>

        <form method="POST" id="passportForm" autocomplete="off">            
            <div class="row justify-content-between">
              <div class="col-md-6 mb-4 mb-md-0">                
                <div class="row">
                  <div class="col-12 form-group">
                    <label><strong>Registered Visitors Login here with Personal Email-Id</strong></label>
                    <input type="email" class="form-control" id="email_id" name="email_id" autocomplete="off"/ >
                    <p id="chkEmailStatus" class="fail"></p>
                  </div>

                  <div class="col-12">
                    <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-submit">
                    <input type="hidden" name="action" value="email_id">  
                  </div>
                </div>              
              </div>

              

            </div>

		</form>
        <form method="POST" id="sendOTP" autocomplete="off">
            <div class="row">
              <div class="col-sm-6 col-md-4 col-lg-3 form-group">
                <label><strong>Company Name</strong></label>
                <p id="company"></p>
              </div>

              <div class="col-sm-6 col-md-4 col-lg-3 form-group">
                <label><strong>Name</strong></label>
                <p><span id="name"></span> &nbsp;&nbsp;<span id="lname"></span></p>
              </div>

              <div class="col-sm-6 col-md-4 col-lg-3 form-group">
                <label><strong>Designation</strong></label>
                <p><span id="designation"></span></p>
              </div>

              <div class="col-sm-6 col-md-4 col-lg-3 form-group">
                <label><strong>Email-Id</strong></label>
                <p id="email"></p>
                <input type="hidden" name="emails" id="emails" value="">
              </div>

              <div class="col-sm-6 col-md-4 form-group">
                <label><strong>Photo</strong></label>
                <div id="photo">
                  <img id="images" src="" style="max-width:150px; width:100%">
                </div>
              </div>

              <div class="col-sm-6 col-md-4 form-group">
                <label><strong>Passport</strong></label>
                <div id="passport_photo">
                  <img id="passport" src="" style="max-width:150px; width:100%">
                </div>
              </div>

              <div class="col-sm-6 col-md-4 form-group">
                <label><strong>Visiting Card</strong></label>
                <div id="visiting_card_photo">
                  <img id="visiting_card" src="" style="max-width:150px; width:100%">
                </div>
              </div>

              <div class="col-12">
                <input type="submit" name="send_otp" id="send_otp" value="Get OTP on Email" class="btn btn-submit" disabled>
                <input type="hidden" name="action" value="send_otp">
              </div>            
            </div>          
        </form>
				
			<form method="POST" class="w-100" id="verifyOTP" autocomplete="off">            
            <div class="row">
                <div class="col-12 form-gorup">
				<h3 class="success">Please Check your registered Email-Id for OTP Number</h3>  
                </div>
              
              <div class="col-md-5 form-gorup">                          
                <label>OTP Number</label>
                <input type="text" class="form-control" id="otp_number" name="otp_number" maxlength="4" autocomplete="off"/>
                <p id="otpSuccess" class="success"></p>                          
                <p id="notMatch" class="fail"></p>
              </div>

              <div class="col-12">                          
                <input type="submit" name="submit" id="submit" value="Verify OTP" class="btn btn-submit" >
                <!--  <a href="#" id="resendOtp" class="btn btn-submit">Resend OTP</a>  -->
                <input type="hidden" name="email_otp" id="email_otp" value="">
                <input type="hidden" name="action" value="verifyOTP">
              </div>
            </form>
				
               
              </div>
               
              </div>
            </div>

          </div>
          <div class="clear"></div>
        </div>
      </div>
      <div class="footer">
        <?php include ('footer.php'); ?>
      </div>
    </div>
  </body>
</html>