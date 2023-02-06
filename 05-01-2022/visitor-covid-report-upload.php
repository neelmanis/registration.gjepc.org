<?php include('header_include.php');
// if(isset($version)){
//  $version = $version;
// }else{
//   $version = "1.1";
// }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IIJS VISITOR VC UPLOAD</title>
    <link rel="icon" href="https://gjepc.org/assets/images/fav_icon.png" type="image/x-icon"/>
    <!--<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>-->
    <link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
   <link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css?v=<?php echo $version;?>" />

    <link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
    <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="js/jquery.fancybox.min.js"></script>
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
<!-- Global site tag (gtag.js) - Google Ads: 679056788 --> <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=AW-679056788"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-679056788'); </script>  -->
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
	
<!-- End Facebook Pixel Code -->
    <script type="text/javascript">
    $(document).ready(function() {
        jQuery.validator.addMethod("specialChrs", function (value, element) {
  if (/[^a-zA-Z 0-9\-]+$/i.test(value)) {
        return false;
    } else {
        return true;
    };
    },  "Special Characters Not Allowed");
  
  jQuery.validator.addMethod("Chrs", function (value, element) {
  if (/[^a-zA-Z\-]+$/i.test(value)) {
        return false;
    } else {
        return true;
    };
    },  "Only Characters are Allowed");
   
  jQuery.validator.addMethod("panno", function (value, element) {
  var regExp = /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/; 
    if (value.match(regExp) ) {
      return true;
    } else {
      return false;
    };
    },"Not valid PAN no");
    
    $("#panForm").validate({
      rules: {
        pan_no:{
          required:true,
          minlength: 10,
          panno: true,
          maxlength:10
        }
      },
      messages: {
        pan_no:{
          required: "Pan No is required",
          minlength:"Please Enter Correct PAN NO",
          maxlength:"Please Enter no more than {0} digit."
        }
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
    },
    mobile_no:
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
    },
    mobile_no:{
    required: "Mobile No. is required",
    }
    },
    submitHandler: sendotpAction
    });
    
    });
    function redirecSecondStep() {
    setTimeout(function(){
    window.location = "visitor-covid-report-upload-step-2.php";
    }, 3000);
    }
      function panAction(){
    var formdata = $('#panForm').serialize();
    $("#send_otp").attr("disabled");
    $.ajax({
    type:'POST',
    data:formdata,
    url:"visitor-covid-report-upload-ajax.php",
    dataType: "json",
    
    beforeSend: function(){
    $('.loaderWrapper').show();
    },
    success:function(data){
        //alert(data);
        if(data.status == 'success'){
    $('#panForm').hide();
    $('.form-notes').hide();
    $('#sendOTP').show();
    $('.loaderWrapper').delay(3000).fadeOut();
    
    $("#mobile_no").val(data.mobile);
        $("#company").text(data.company);
    $("#email").text(data.email);
    $("#name").text(data.name);
    $("#lname").text(data.lname);
    $("#designation").text(data.designation);

        /*  $("#photo").text(data.photo);*/
    $('#photo #images').attr('src','images/employee_directory/'+data.reg_id+'/photo/'+data.photo);
        $("#send_otp").removeAttr("disabled");
        
        }else if(data.status =='disapproved'){
    alert("Application Disapproved Kindly Update Your Data");
   
    window.location = "single_visitor_update.php";
  
    }else if(data.status =='notExist') {        
    document.location.href = "single_visitor_add.php";
	}else if(data.status =='pending') {
    $('.loaderWrapper').delay(1000).fadeOut();
    $("#chkPendingPANStatus").text("Your Application is Pending");
    
    }else if(data.status =='paymentNotDone') {
    $('.loaderWrapper').delay(1000).fadeOut();
    $("#chkPendingPANStatus").html("Please Register for IIJS SIGNATURE 2022.");
    
    }else if(data.status =='exhibitor'){
      $('.loaderWrapper').delay(300).fadeOut();
     $("#chkPendingPANStatus").html("You are Exhibitor");
    }else if(data.status =='quotafull'){
      $('.loaderWrapper').delay(300).fadeOut();
     $("#chkPendingPANStatus").html("Sorry Your company have already registered for 2 visitors.");
    }else if(data.status =='companyData'){
      $('.loaderWrapper').delay(300).fadeOut();
     $("#chkPendingPANStatus").html("Company Details Disapproved");
    }else if(data.status =='updated'){
   $("#chkPendingPANStatus").text("Your Application is Updated ");
         $('.loaderWrapper').delay(300).fadeOut();
    /* window.location.href="single_visitor_update.php";*/
    }else if(data.status =='combo'){
   $("#chkPendingPANStatus").text("You are already registered for this show ");
         $('.loaderWrapper').delay(300).fadeOut();
    /* window.location.href="single_visitor_update.php";*/
    }else if(data.status =="error"){
      $("#chkPendingPANStatus").text(data.message);
      $('.loaderWrapper').delay(300).fadeOut();
    }
    }
    });
    }
      
    function sendotpAction(){
    var formdata = $('#sendOTP').serialize();
       $("#secondary_mobile_error").text("");
    $.ajax({
    type:'POST',
    data:formdata,
    url:"visitor-covid-report-upload-ajax.php",
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
    $("#mobile_no_otp").val(data.mobile_no);
    $("#otpSuccess").text("OTP Sent Successfully");
    $("#otpError").text("");
    }else if(data.status == "errorAlready"){
    
    $('.loaderWrapper').delay(3000).fadeOut();
    $('#panForm').hide();
    $('#verifyOTP').hide();
    $('#sendOTP').show();
    $("#secondary_mobile_error").text("Secondary Mobile No is Already Exist. Please try another No.");
 
    }else if(data.status == "error"){
    
    $('.loaderWrapper').delay(3000).fadeOut();
    $('#panForm').hide();
    $('#verifyOTP').hide();
    $('#sendOTP').show();
    $("#otpError").text("OTP not sent please try again");
    $("#otpSuccess").text("");
    }else if(data.status =='secondaryEmpty'){
      $('.loaderWrapper').delay(2000).fadeOut();
      $("#secondary_mobile_error").text("Please Enter Secondary Mobile Number.");
    }
    }
    });
    }
    function verifyOTPAction(){
    var formdata = $('#verifyOTP').serialize();
    
    $.ajax({
    type:'POST',
    data:formdata,
    url:"visitor-covid-report-upload-ajax.php",
    dataType: "json",
    beforeSend: function(){
    $('.loaderWrapper').show();
    },
    success:function(data){
    
    if(data['status'] == "success"){
    
    redirecSecondStep();
    }else if(data['status'] == "fail"){
      $('.loaderWrapper').delay(1000).fadeOut();
    $("#notMatch").text("OTP not matched");
    $("#otpSuccess").text("");
    }
    }
    });
    }    

    $(document).ready(function(){
      $('#resendOtp').click(function(){
        var mobile_no = $('#mobile_no_otp').val();
    
    $.ajax({
    type:'POST',
    data:{mobile_no:mobile_no},
    url:"resendOtp.php",
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
    $("#mobile_no_otp").val(data.mobile_no);
    $("#otpSuccess").text("OTP Sent Successfully");
    $("#otpError").text("");
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
   
      });

    });
    </script>
<style type="text/css">
/*  .formwrapper2{display: flex;
    justify-content: space-between;
} */
.form-notes{
  border: 1px solid#000;
  padding: 10px;
}
</style>
  </head>
  <body>
  	<noscript><img height="1" width="1" style="display:none"
	  src="https://www.facebook.com/tr?id=398834417477910&ev=PageView&noscript=1"
	/></noscript>
    <div class="wrapper">
    <div class="header">
		<?php include('header1.php'); ?>
		<div class="clear"> </div>
	</div>
    <div class="clear"> </div>
	<div class="clear"> </div>
       <!--<div class="new_banner">
        <img src="images/iijs-virtual-1.jpg">
      </div> -->

      <!--container starts-->
      <div class="container_wrap">
        <div class="container">
     
          <div class="bold_font text-center">
              <div class="d-block">
                  <img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
              </div>
            VISITOR VACCINATION CERTIFICATE UPLOAD
          </div>
		  <p><span class='blink d-block'>2 Vaccine Doses Mandatory For Entry</span> </p>
          <div id="loginForm">
            <div class="box-shadow">

              <div class="loaderWrapper">
                <div class="formLoader">
                  <img src="images/formloader.gif" alt="">
                  <p> Please Wait....</p>
                </div>
              </div>

              <!-- <div class="formwrapper2 d-table"> -->
                 <!--<div style="text-align: center;"><h1 style="font-size: 30px;text-align: center;">Registration has been closed for IIJS PREMIERE 2021</h1></div>-->

                 <form method="POST"  id="panForm" autocomplete="off" >

                    <div class="row">

                      <div class="form-group col-md-6">
                        <label><strong>Login with your personal PAN card</strong></label>
                        <input type="text" class="form-control pan_no w-100 " id="pan_no" name="pan_no" value="" maxlength="10" autocomplete="off"/>
                        <p id="chkPendingPANStatus" class="fail"></p>
                      </div>

                      <div class="form-group col-12">
                        <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-submit" >
                        <input type="hidden" name="action" value="pan_number">
                      </div>

                      <div class="col-12 form-group mb-0">

                        <div class="row nvv_btn">
                          
                          <div class="col-12 col-sm mb-3 mb-sm-0">
                            <a href="https://registration.gjepc.org/single_visitor.php" class="gold_text fade_anim">Domestic Visitor Registration</a>
                          </div>

                          <div class="col-12 col-sm mb-3 mb-sm-0">
                            <a href="login.php?visitor=international" class="gold_text fade_anim">International Visitor Registration</a>
                          </div>

                        </div>

                      </div>
                          
                        
                    </div>
                
                     <!-- <div class="d-flex flex-column">
                
                    <p style="font-size: 15px;display: block;">Domestic Visitor Registration <a href="https://registration.gjepc.org/single_visitor.php" class="gold_text">Click Here</a></p>
                    <p style="font-size: 15px;display: block;">International Visitor Registration <a href="login.php?visitor=international" class="gold_text">Click Here</a></p>
                                   
                  </div> -->
                
                </form> 
             
                            
                <form  method="POST" id="sendOTP" autocomplete="off" class="col-100">

                  <div class="row">

                      <div class="col-sm-6 col-md-4 form-group">
                        <label><strong>Company Name</strong></label>
                        <p id="company"></p>
                      </div>

                      <div class="col-sm-6 col-md-4 form-group">
                        <label><strong>Name</strong></label>
                        <p><span  id="name"></span> &nbsp;&nbsp;<span  id="lname"></span></p>  
                      </div>

                      <div class="col-sm-6 col-md-4 form-group">
                        <label><strong>Mobile No</strong></label>
                        <input type="text" class="form-control" id="mobile_no" name="mobile_no" maxlength="10" autocomplete="off" readonly/>
                        <p id="otpError" class="fail"></p>
                      </div>

                      <div class="col-sm-6 col-md-4 form-group">
                        <label><strong>Email-Id</strong></label>
                        <p id="email"></p>
                      </div>

                      <div class="col-sm-6 col-md-4 form-group">
                        <label><strong>Photo</strong></label>
                        <div id="photo">
                          <img id="images" src="" height="150px" width="auto">
                        </div>
                      </div>

                      <div class="col-12">
                        <input type="submit" name="send_otp" id="send_otp" value="Send OTP" class="btn btn-submit" disabled>
                        <input type="hidden" name="action" value="send_otp">
                      </div>
                      
                    </div>

                </form>

                <form  method="POST" class="w-100"  id="verifyOTP" autocomplete="off">

                  <div class="row">

                    <div class="col-12 form-group">
                      <h3 class="success mb-0 text-left">Please Check in your device for OTP Number</h3>  
                    </div>

                    <div class="col-md-6 form-group">                          
                      <label>OTP Number:</label>
                      <input type="text" class="form-control" id="otp_number" name="otp_number" maxlength="4" autocomplete="off"/>
                      <p id="otpSuccess" class="success"></p>                          
                      <p id="notMatch" class="fail"></p>
                    </div>
                      
                    <div class="col-12">
                      <input type="submit" name="submit" id="submit" value="Verify OTP" class="btn btn-submit" >
                      <input type="hidden" name="mobile_no_otp" id="mobile_no_otp" value="">
                      <input type="hidden" name="action" value="verifyOTP">
                    </div>

                  </div>
                  
                </form>
              
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