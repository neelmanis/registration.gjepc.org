<?php 
include('header_include.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IIJS INTERNATIONAL VISITOR REGISTRATION</title>
    <link rel="icon" href="https://gjepc.org/images/favicon.ico" type="image/x-icon"/>
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
    url:"singleINTLVisitorAjax.php",
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
    } else if(data.status =='disapproved'){
    alert("Application Disapproved Kindly Update Your Data");
    //window.location = "single_visitor_update.php";
  
    }else if(data.status =='notExist') {        
     $('.loaderWrapper').delay(1000).fadeOut();
    $("#chkEmailStatus").text("Your Email-id Not found"); 
	} /*else if(data.status =='pending') {
    $('.loaderWrapper').delay(1000).fadeOut();
    $("#chkEmailStatus").text("Your Last Year Application is Pending. Kindly Apply for IIJS PREMIERE in Dashboard");    
    }*/ else if(data.status =='paymentAlreadyDone') {
    $('.loaderWrapper').delay(1000).fadeOut();
    $("#chkEmailStatus").html("Application Already Done...");
    
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
    url:"singleINTLVisitorAjax.php",
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
    url:"singleINTLVisitorAjax.php",
    dataType: "json",
    beforeSend: function(){
    $('.loaderWrapper').show();
    },
    success:function(data){    
    if(data['status'] == "success"){    
        setTimeout(function(){
		window.location = "single_intl_show_registration.php";
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
  </head>
  <body>
  	<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=398834417477910&ev=PageView&noscript=1"
	/></noscript>
    <div class="wrapper">
    <div class="header">
	<?php include('header1.php'); ?>
	<div class="clear"> </div>
	</div>
    <div class="clear"> </div>
	<div class="clear"> </div>

      <!--container starts-->
      <div class="container_wrap" style="padding:50px 0 0 0;">
        <div class="container">
     
        <div class="bold_font text-center">
              <div class="d-block">
                  <img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
              </div>
        INTERNATIONAL VISITOR REGISTRATION
        </div>
          <div id="loginForm" >
            <div class="box-shadow">
              <div class="loaderWrapper">
                <div class="formLoader">
                  <img src="images/formloader.gif" alt="">
                  <p> Please Wait....</p>
                </div>
              </div>
              <div class="formwrapper2">
			  
                <form method="POST" id="passportForm" autocomplete="off">
                <div class="d-flex flex-column">
                <div class="d-flex flex-row  form-setup">
                    <div class="col-100 d-flex justify-around flex-wrap form-group">
                      <div class="col-100 d-flex align-center">
                        <label>Registered Visitors Login here with Personal Email-Id</label>
                      </div>
                      <div class="col-100" style="margin-top: 10px;">
                        <input type="email" class="form-control"   id="email_id" name="email_id" autocomplete="off"/ >
                        <p id="chkEmailStatus" class="fail"></p>
                      </div>
                    </div>
                </div>
                </div>
				
                <div class="d-flex flex-column ">
                  <div class="d-flex flex-row">
                    <div class="col-50 col-m-100 d-flex  flex-wrap form-group">
                      <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-submit">
                      <input type="hidden" name="action" value="email_id">
                    </div>
                  </div>
                </div>
				
                <div class="d-flex flex-row">
                    <div class="col-100 d-flex  flex-wrap form-group">
                    <p style="font-size: 15px"><strong>New International Company Visitor Registration</strong> 
					<a href="https://registration.gjepc.org/international_user_registration.php" class="gold_text">Click Here</a></p>
                    </div>                    
                </div>
              </form> 
              
			   <!--<div><span>GJEPC announces postponement of IIJS Signature 2021, scheduled from 7th-12th April 2021. Visitor registration is now on hold till the announcement of new dates.</span></div>-->
                            
               <form method="POST" id="sendOTP" autocomplete="off">
                <div class="d-flex flex-column ">
                  <div class="d-flex flex-row">
                    <div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group">
                      <div class="col-50 col-m-100 d-flex align-center">
                        <label><strong>Company Name</strong></label>
                      </div>
                      <div class="col-50 col-m-100">
                        <p id="company"></p>
                      </div>
                    </div>
                    <div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group">
                      <div class="col-50 col-m-100 d-flex align-center">
                        <label><strong>Name</strong></label>
                      </div>
                      <div class="col-50 col-m-100">
                        <p><span id="name"></span> &nbsp;&nbsp;<span id="lname"></span></p>
                      </div>
                    </div>
                  </div>
                  <div class="d-flex flex-row">
                    
                    <div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group">
                      <div class="col-50 col-m-100 d-flex align-center">
                        <label><strong>Designation</strong></label>
                      </div>
                      <div class="col-50 col-m-100">
                        <p><span id="designation"></span></p>
                      </div>
                    </div>
                    
                    <div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group">
                      <div class="col-50 col-m-100 d-flex align-center">
                        <label><strong>Email-Id</strong></label>
                      </div>
                      <div class="col-50 col-m-100">
                        <p id="email" style="margin-top: 10px;"></p>
						<input type="hidden" name="emails" id="emails" value="">
                      </div>
                    </div>
                  </div>
				  
                <div class="d-flex flex-row">                    				
                    <div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group">
                      <div class="col-50 col-m-100 d-flex align-top">
                        <label>Photo:</label>
                      </div>
                      <div class="col-50 col-m-100">
                        <div id="photo">
                          <img id="images" src="" width="100%">
                        </div>
                      </div>
                    </div>   
					<div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group">
                      <div class="col-50 col-m-100 d-flex align-top">
                        <label>Passport:</label>
                      </div>
                      <div class="col-50 col-m-100">
                        <div id="passport_photo">
                          <img id="passport" src="" width="100%">
                        </div>
                      </div>
                    </div>
					<div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group">
                      <div class="col-50 col-m-100 d-flex align-top">
                        <label>Visiting Card:</label>
                      </div>
                      <div class="col-50 col-m-100">
                        <div id="visiting_card_photo">
                          <img id="visiting_card" src="" width="100%">
                        </div>
                      </div>
                    </div>					
                </div>
				
									
                  <div class="d-flex flex-column">
                    <div class="d-flex flex-row">
                      <div class="col-50 col-m-100 d-flex  flex-wrap form-group">
                        <input type="submit" name="send_otp" id="send_otp" value="Get OTP on Email" class="btn btn-submit" disabled>
                        <input type="hidden" name="action" value="send_otp">
                      </div>
                    </div>
                  </div>
                </div>
                </form>
				
				<form method="POST" class="w-100" id="verifyOTP" autocomplete="off">
                <div class="d-flex flex-column">
                <div class="d-flex flex-row form-setup">
                <div class="col-100 d-flex justify-around flex-wrap form-group">
				<h3 class="success">Please Check your registered Email-Id for OTP Number</h3>  
                </div>
				</div>
                    <div class="d-flex flex-row form-setup">                      
                      <div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group">
                        <div class="col-50 col-m-100 d-flex align-center">                          
                          <label>OTP Number:</label>
                        </div>
                        <div class="col-50 col-m-100">
                          <input type="text" class="form-control" id="otp_number" name="otp_number" maxlength="4" autocomplete="off"/>
                          <p id="otpSuccess" class="success"></p>                          
                          <p id="notMatch" class="fail"></p>
                        </div>
                      </div>
                      <div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group"></div>
                    </div>
                  </div>
                  <div class="d-flex flex-column ">
                    <div class="d-flex flex-row form-setup">
                      <div class="col-50 col-m-100 d-flex  flex-wrap form-group">
                        <input type="submit" name="submit" id="submit" value="Verify OTP" class="btn btn-submit" >
                    <!--  <a href="#" id="resendOtp" class="btn btn-submit">Resend OTP</a> -->
                        <input type="hidden" name="email_otp" id="email_otp" value="">
                        <input type="hidden" name="action" value="verifyOTP">
                      </div>
                    </div>
                  </div>
                </form>
				
                <!--<div class="form-notes black_bg">
				<h3 class="gold_text"> Registration Process</h3>
				<ul class="inner_under_listing">
				<li> <strong class="gold_text">For Approved/Registered Visitors</strong> </li>
				<li>Enter your Personal Pan card number in the box and submit</li>
				<li>Confirm your data by OTP verification</li>
				<li>Select the show and submit your application</li>
				</ul>
				
				<ul class="inner_under_listing">
				<li><strong class="gold_text">For New Registration</strong>		</li>
				<li>Click on New Visitor Registration <a href="https://registration.gjepc.org/domestic_user_registration_step1.php"  class="gold_text"><b>Click Here</b></a></li>
				<li>Update the data, upload necessary documents and submit</li>
				<li>After approval of your profile you can select show and register for IIJS SIGNATURE 2021</li>
				</ul>				
				</div>-->
              </div>
               
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
  </body>
<link rel="stylesheet" type="text/css" href="css/new_style.css" /> 
</html>