<?php
include('header_include.php');
?>
<?php 



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $evt_name;?> VISITOR REGISTRATION</title>
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
	if(/[^a-zA-Z 0-9\-]+$/i.test(value)) {
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

    function panAction(){
      var formdata = $('#panForm').serialize();
      $("#send_otp").attr("disabled");
      $.ajax({
        type:'POST',
        data:formdata,
        url:"visitorEnquiryAjax.php",
        dataType: "json",
        
        beforeSend: function(){
        $('.loaderWrapper').show();
        },
        success:function(data){
          //  alert(data.status);
          if(data.status == 'success'){
          $('#panForm').hide();
          $('.form-notes').hide();
          $('#sendOTP').show();
          $('.loaderWrapper').delay(3000).fadeOut();
          $("#mobile_no").val(data.mobile);
          $("#visitor_id").val(data.visitor_id);
          $("#company").text(data.company);
          $("#email").text(data.email);
          $("#name").text(data.name);
          $("#lname").text(data.lname);
          $("#pan_number").val(data.pan_number);
          $("#designation").text(data.designation);
          /*  $("#photo").text(data.photo);*/
          $('#photo #images').attr('src','images/employee_directory/'+data.reg_id+'/photo/'+data.photo);
          $("#send_otp").removeAttr("disabled");
          }else if(data.status =='disapproved'){
          alert("Application Disapproved Kindly Update Your Data");
        //  window.location = "single_visitor_update.php";
          }else if(data.status =='notExist') {        
           $('.loaderWrapper').delay(1000).fadeOut();
          $("#chkPendingPANStatus").text("PAN No Not found");
          }else if(data.status =='pending') {
          $('.loaderWrapper').delay(1000).fadeOut();
          $("#chkPendingPANStatus").text("Your Application is Pending");
          
          }else if(data.status =='paymentAlreadyDone') {
          $('.loaderWrapper').delay(1000).fadeOut();
          $("#chkPendingPANStatus").html("This PAN No's Enquiry is already Done.Please try another PAN No.");
          
          }else if(data.status =='exhibitor'){
            $('.loaderWrapper').delay(300).fadeOut();
           $("#chkPendingPANStatus").html("You are Exhibitor");
          }else if(data.status =='quotafull'){
            $('.loaderWrapper').delay(300).fadeOut();
           $("#chkPendingPANStatus").html("Sorry Your company have already registered for 2 visitors.");
          }else if(data.status =='companyData'){
            $('.loaderWrapper').delay(300).fadeOut();
           $("#chkPendingPANStatus").html("Company Details Disapproved");
		   //  document.location.href = "single_visitor_company_update.php";
		  alert("Application Disapproved Kindly Update Your Data");
        //  window.location = "single_visitor_company_update.php";
          }else if(data.status =='updated'){
         $("#chkPendingPANStatus").text("Your Application is Updated");
               $('.loaderWrapper').delay(300).fadeOut();
          }else if(data.status =='combo'){
         $("#chkPendingPANStatus").text("You are already registered for this show.");
               $('.loaderWrapper').delay(300).fadeOut();
          }else if(data.status =='warning'){
           $("#chkPendingPANStatus").text(data.message);
          $('.loaderWrapper').delay(300).fadeOut();
     
          }
        }
      });
    }	
	
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
	
	function sendotpAction(){
    var formdata = $('#sendOTP').serialize();
       $("#enquiry_error").text("");
    $.ajax({
    type:'POST',
    data:formdata,
    url:"visitorEnquiryAjax.php",
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
	$("#otpSuccess").text("Thank You For Enquiry");
	setTimeout(function(){
        window.location = "enquiry.php";
    }, 4000);
		
  
    $("#otpError").text("");
    } else if(data.status == "errorAlready"){
    
    $('.loaderWrapper').delay(3000).fadeOut();
    $('#panForm').hide();
    $('#verifyOTP').hide();
    $('#sendOTP').show();
    $("#enquiry_error").text("This PAN No's Enquiry is already Done.Please try another PAN No");
 
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
    </script>
<script>
$().ready(function() {
$('.numeric').keypress(function (event) {
  var keycode = event.which;
  if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) 
  {
    event.preventDefault();
  }
});
});
</script>

<style type="text/css">
/*  .formwrapper2{display: flex;
    justify-content: space-between;
} */
.form-notes{
  border: 1px solid#000;
  padding: 20px 15px;
}

.form-notes p.gold_text {
font-size:16px;
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
      <div class="container_wrap my-5">
        <div class="container">
     
          <div class="bold_font text-center">
              <div class="d-block">
                  <img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
              </div>
         <?php //echo $evt_name; ?> VISITOR REGISTRATION
          </div>
          <div id="loginForm">
            <div class="box-shadow">

              <div class="loaderWrapper">
                <div class="formLoader">
                  <img src="images/formloader.gif" alt="">
                  <p> Please Wait....</p>
                </div>
              </div>
              
              <div class="formwrapper2">

                <!--<div style="text-align: center;"><h1 style="font-size: 30px;text-align: center;">Registration has been closed for IIJS PREMIERE 2021</h1></div>-->

                <form method="POST" id="panForm" autocomplete="off">

                <div class="row">

                    <div class="col-md-12 form-group">
                      <label><strong>Login with your personal PAN card</strong></label>
                      <input type="text" class="form-control pan_no" id="pan_no" name="pan_no" value="" maxlength="10" autocomplete="off"/>
                      <p id="chkPendingPANStatus" class="fail"></p>
                    </div>
                    
                    <div class="col-12 form-group">
                      <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-submit">
                      <input type="hidden" name="action" value="pan_number">
                    </div>
                      
                </div>                    
                </form> 
             
                <form class="" method="POST" id="sendOTP" autocomplete="off">
                  <div class="row">
					
                    <div class="col-sm-6 col-md-4 form-group">
                      <label><strong>Company Name</strong></label>
                      <p id="company" class="m-0"></p>
                    </div>

                    <div class="col-sm-6 col-md-4 form-group">
                      <label><strong>Name</strong></label>
                      <p class="m-0"><span id="name"></span> &nbsp;&nbsp;<span id="lname"></span></p>
                    </div>

                    <div class="col-sm-6 col-md-4 form-group">
                      <label><strong>Email-Id</strong></label>
                      <p id="email" class="m-0"></p>
                    </div>

                    <div class="col-sm-6 col-md-4 form-group">
                      <label><strong>Mobile No</strong></label>
                      <input type="text" class="form-control" id="mobile_no" name="mobile_no" maxlength="10" autocomplete="off" readonly/>
                      <p id="otpError" class="fail m-0"></p>                          
                    </div>
                     					
					<div class="col-sm-6 col-md-4 form-group">
                      <label><strong>Are you Visiting IIJS SIGNATURE 2022</strong></label>
                      <div class="row">
					    <div class="col-auto">
                          <label class="container_radio"><span class="check_text">Yes</span>
                            <input type="radio" id="visitng_show" name="visitng_show" checked="checked" value="YES">
                            <span class="checkmark_radio"></span>
                          </label>
                        </div>
					    <div class="col-auto">
                          <label class="container_radio"><span class="check_text">No</span>
                            <input type="radio" id="visitng_show" name="visitng_show" value="NO">
                            <span class="checkmark_radio"></span>
                          </label>
                        </div>
                      </div>
                    </div>
					
                    <div class="col-12 form-group">
                      <input type="submit" name="send_otp" id="send_otp" value="Submit" class="btn btn-submit" disabled>
                      <input type="hidden" name="action" value="send_otp">
                      <input type="hidden" name="pan_number" id="pan_number">
					   
                    </div>
					<p id="enquiry_error" class="error"></p>
					  
                  </div>
                </form>
				<p id="otpSuccess" class="success"></p>  
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