<?php
include('header_include.php');
$sql = "SELECT * FROM `visitor_event_master` WHERE `status` ='1'  order by `id` desc ";
$result = $conn->query($sql);
$count = $result->num_rows;
if($count > 0){
  $row = $result->fetch_assoc();
   $event_name = $row['event_name'];
   $registration_start_date = $row['registration_start_date'];
   $registration_close_date = $row['registration_close_date'];
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $evt_name;?> COMMITTEE/ AGENCY/ VIP/ VVIP BADGE GENERATE</title>
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
     fbq('track', 'Step1');
  </script>
  
<!-- End Facebook Pixel Code -->
    <script type="text/javascript">
    $(document).ready(function() {
      $('#badgeSuccess').hide();
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
        mobile_no:{
          required:true,
          minlength: 10,
          maxlength:10
        }
      },
      messages: {
        mobile_no:{
          required: "Mobile No is required",
          minlength:"Please Enter Correct Mobile No",
          maxlength:"Please Enter no more than {0} digit."
        }
      },
      submitHandler: panAction
    });
      $("#companyChangeForm").validate({
      rules: {
        company_pan_no:{
          required:true,
          minlength: 10,
          panno: true,
          maxlength:10
        }
      },
      messages: {
        company_pan_no:{
          required: "Pan No is required",
          minlength:"Please Enter Correct PAN NO",
          maxlength:"Please Enter no more than {0} digit."
        }
      },
      submitHandler: companyPanAction
    });

      $("#update_compant_btn").hide();
      $("#update_compant_btn").click(function(){
         let company_pan_no = $("#company_pan_no").val();
         let visitor_id = $("#visitor_id").val();
         if(confirm("Are you sure !")){
          $.ajax({
            type:'POST',
            data:{action:"updateVisitorCompany",company_pan_no:company_pan_no,visitor_id:visitor_id},
            url:"agencyBadgeAjax.php",
            dataType: "json",
            // beforeSend: function(){
            // $('.loaderWrapper').show();
            // },

            success:function(data){

              if(data.status=="success"){
                 $('label[for="company_pan_no"]').removeClass("text-danger").addClass("text-success").text(data.message);
                   $("#companyChangeForm")[0].reset();
                   alert(data.message);
                   $('#company-change-modal').modal('hide');
                   $("#company").html(data.company_name);
                   $('#photo #images').attr('src','images/employee_directory/'+data.reg_id+'/photo/'+data.photo);
                   window.location.href='https://registration.gjepc.org/single_visitor_update.php';
              }else{
                   $('label[for="company_pan_no"]').removeClass("text-success").addClass("text-danger").html(data.message);
                  
              }
            }
          });
         }else{
          return false;
         }
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
   
    company:
    {
    required:true,
    },
    mobile_no_x:
    {
    required:true,
    }
    },
    messages: {
    
    company:{
    required: "Company Name is required",
    },
    mobile_no_x:{
    required: "Mobile No. is required",
    }
    },
    submitHandler: sendotpAction
    });
    
    });
    function redirecSecondStep() {
    setTimeout(function(){
    window.location = "visitor-badge.php"; 
    }, 3000);
    }
    function redirectVaccionCertUpload() {
    setTimeout(function(){
    window.location = "visitor-covid-report-upload-step-2.php";
    }, 3000);
    }
    
     function companyPanAction(){
      var formdata = $('#companyChangeForm').serialize();
      $.ajax({
        type:'POST',
        data:formdata,
        url:"agencyBadgeAjax.php",
        dataType: "json",
        // beforeSend: function(){
        // $('.loaderWrapper').show();
        // },

        success:function(data){

          if(data.status=="success"){
             $('label[for="company_pan_no"]').removeClass("text-danger").addClass("text-success").html(data.message);
                $("#update_compant_btn").show();
                $("#submitCompanyPan").hide();
                $("#company_div").show();
                $("#fetchedCompanyName").html(data.company_name);


          }else{
              $('label[for="company_pan_no"]').removeClass("text-success").addClass("text-danger").html(data.message);
              $("#update_compant_btn").hide();
              $("#submitCompanyPan").show();
              $("#company_div").hide();
              $("#fetchedCompanyName").html("");
          }
        }
      });
    }
      
    function panAction(){
      var formdata = $('#panForm').serialize();
      $("#send_otp").attr("disabled");
      $.ajax({
        type:'POST',
        data:formdata,
        url:"agencyBadgeAjax.php",
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
          $("#mobile_no_x").val(data.mobile);
          $("#del_mobile_no").val(data.mobile);
		  $("#del_company").text(data.company);
		  $("#del_name").text(data.name);
		  $("#del_lname").text(data.lname);
          $("#visitor_id").val(data.visitor_id);
          $("#company").text(data.company);
         
          $("#name").text(data.name);
          $("#lname").text(data.lname);
          $("#designation").text(data.designation);
          /*  $("#photo").text(data.photo);*/
          $('#photo #images').attr('src',data.photo);
          $("#send_otp").removeAttr("disabled");
           $("#showHistory").html(data.showHistory);
          }else if(data.status =='disapproved'){
          alert("Application Disapproved Kindly Update Your Data");
          window.location = "single_visitor_update.php";
          }else if(data.status =='notExist') {        
          document.location.href = "single_visitor_add.php";
          }else if(data.status =='pending') {
          $('.loaderWrapper').delay(1000).fadeOut();
          $("#chkPendingPANStatus").text("Your Application is Pending");
          
          }else if(data.status =='paymentAlreadyDone') {
          $('.loaderWrapper').delay(1000).fadeOut();
          $("#chkPendingPANStatus").html(" <a href='https://registration.gjepc.org/visitor-covid-report-upload.php'>Click here</a>");
          
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
          window.location = "single_visitor_company_update.php";
          }else if(data.status =='updated'){
         $("#chkPendingPANStatus").text("Your Application is Updated");
               $('.loaderWrapper').delay(300).fadeOut();
          }else if(data.status =='combo'){
         $("#chkPendingPANStatus").text("You are already registered for this show.");
               $('.loaderWrapper').delay(300).fadeOut();
          }else if(data.status =='warning'){
           $("#chkPendingPANStatus").html(data.message);
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
    url:"agencyBadgeAjax.php",
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
    url:"agencyBadgeAjax.php",
    dataType: "json",
    beforeSend: function(){
    $('.loaderWrapper').show();
    $("#notMatch").text("");
    $("#otpSuccess").text("");
    },
    success:function(data){
    
    if(data['status'] == "success"){
      if(data.redirect =="vis_registration"){
        $('#verifyOTP').hide();
         $('.loaderWrapper').hide();
         $("#badgeSuccess").show();
       redirecSecondStep();
      }else{
      redirectVaccionCertUpload();
      }
    }else if(data['status'] == "fail"){
    $('.loaderWrapper').delay(1000).fadeOut();
    $("#notMatch").text("OTP not matched");
    $("#otpSuccess").text("");
    }else if(data['status']=="error"){
    $('.loaderWrapper').delay(1000).fadeOut()
    $("#notMatch").text(data['msg']);
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


<script>
$().ready(function() {
$('.numeric').keypress(function (event) {
  var keycode = event.which;
  if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) 
  {
    event.preventDefault();
  }
});

$("#delete_account").hide();
$('#to_delete').on("click",function (event) {
  event.preventDefault();
  
  $("#delete_account").delay(1000).slideDown();
  $("#sendOTP").slideUp();
});

$('#back').on("click",function (event) {
  event.preventDefault();
  
  $("#sendOTP").delay(1000).slideDown();
  $("#delete_account").slideUp();
});
});
  $(document).on("click","#get_company_update_form", function(e){
    e.preventDefault();
    // let visitor_id = $(this).data('visitor-id');
    // $.ajax({
    //         type : 'POST',
    //         data : {},
    //         url : 'agencyBadgeAjax.php',
    //         dataType: "json",
    //         success:function(result){
      
    //             $('#company-change-modal').modal({ backdrop: 'static', keyboard: false});
            
    //         }
    //       });
      $('#company-change-modal').modal({ backdrop: 'static', keyboard: false});

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
.link{
  text-decoration: underline;
  color: blue;
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
      






      <!--container starts-->
      <div class="container_wrap my-5">
        <div class="container">
     
          <div class="bold_font text-center">
              <div class="d-block">
                  <img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
              </div>
         GENERATE AGENCY/COMMITTEE/GUEST/VIP/VVIP BADGE 
          </div>
          <div id="loginForm">
            <div class="box-shadow">

              <div class="loaderWrapper">
                <div class="formLoader">
                  <img src="images/formloader.gif" alt="">
                  <p> Please Wait....</p>
                </div>
              </div>
              <?php if($count > 0){ ?>
              
              <div class="formwrapper2 d-block">

                <!--<div style="text-align: center;"><h1 style="font-size: 30px;text-align: center;">Registration has been closed for IIJS PREMIERE 2021</h1></div>-->

                <form method="POST" id="panForm" autocomplete="off">

                <div class="row">

                    <div class="col-md-5 form-group">
                      <label><strong>Login with your mobile no.</strong></label>
                      <input type="text" class="form-control pan_no" id="mobile_no" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" name="mobile_no" value="" maxlength="10" autocomplete="off"/>
                      <p id="chkPendingPANStatus" class="fail"></p>
                    </div>
                    
                    <div class="col-12 form-group">
                      <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-submit">
                      <input type="hidden" name="action" value="check_mobile_number">
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
                      <label><strong>Mobile No</strong></label>
                      <input type="text" class="form-control" id="mobile_no_x" name="mobile_no_x" maxlength="10" autocomplete="off" readonly/>
                      <p id="otpError" class="fail m-0"></p>                          
                    </div>

                  
                        
                       <div class="col-sm-6 col-md-4 form-group">
                      <label><strong>Photo</strong></label>
                      <div id="photo">
                        <img id="images" src="" height="150px" width="auto" style="border:1px solid #ddd">
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-8">
                      <div id="showHistory"></div>
                    </div>
                     
					<!--<div class="col-sm-6 col-md-4 form-group">
                      <label><strong>Do you want to delete your details from this Company</strong></label>
                      <div class="row">
					    <div class="col-auto">
                          <label class="container_radio"><span class="check_text">Yes</span>
                            <input type="radio" id="to_delete" name="to_delete" value="Y">
                            <span class="checkmark_radio"></span>
                          </label>
                        </div>
					    <div class="col-auto">
                          <label class="container_radio"><span class="check_text">No</span>
                            <input type="radio" id="to_delete" name="to_delete" checked="checked" value="N">
                            <span class="checkmark_radio"></span>
                          </label>
                        </div>
                      </div>
                    </div>-->
					
                    <div class="col-12 form-group">
                      <input type="submit" name="send_otp" id="send_otp" value="Send OTP" class="btn btn-submit" disabled>
                      <input type="hidden" name="action" value="send_otp">
                    </div>
                  </div>
                </form>
				
				<form method="POST" class="w-100" id="verifyOTP" autocomplete="off">                  
                  <h3 class="success">Please Check in your device for OTP Number</h3>  
                  
                  <div class="row">
                    <div class="col-md-5">                          
                      <label>Enter OTP</label>
                      <input type="text" class="form-control numeric" id="otp_number" name="otp_number" maxlength="4" autocomplete="off"/>
                      <p id="otpSuccess" class="success"></p>                          
                      <p id="notMatch" class="fail"></p>
                    </div>
                     
                    <div class="col-12">
                      <input type="submit" name="submit" id="submit" value="Verify OTP" class="btn btn-submit">                
                      <input type="hidden" name="mobile_no_otp" id="mobile_no_otp" value="">
                      <input type="hidden" name="action" value="verifyOTP">
                    </div>
                  </div>
                </form>

                <div id="badgeSuccess">
                  <p>Thank you for downloading your IIJS PREMIERE 2022 badge. <a href="https://registration.gjepc.org/visitor-badge.php" class="cta btn m-2"> Click here</a> if not downloaded automatically. </p>
                </div>
				
			
				
				<!--<form method="POST" class="w-100" id="delete_account" autocomplete="off">
                  <label><strong>Are you sure you want to delete</label></strong>
				  <p id="chkDeleteStatus" class="fail"></p>
                  <div class="row">
				    <div class="col-sm-6 col-md-4 form-group">
                      <label><strong>Company Name</strong></label>
                      <p id="del_company" class="m-0"></p>
                    </div>

                    <div class="col-sm-6 col-md-4 form-group">
                      <label><strong>Name</strong></label>
                      <p class="m-0"><span id="del_name"></span> &nbsp;&nbsp;<span id="del_lname"></span></p>
                    </div>
					
					<div class="col-sm-6 col-md-4 form-group">
                      <label><strong>Mobile No</strong></label>
                      <input type="text" class="form-control" id="del_mobile_no" name="del_mobile_no" maxlength="10" autocomplete="off" readonly/>
                      <p id="otpError" class="fail m-0"></p>                          
                    </div>
					
                   <div class="col-sm-12 form-group">                       
                      <label></label>
                      <input type="checkbox" id="agree_delete" name="agree_delete" value="Y"/>
					   I confirm the request to delete my employee account from the Company <label for="agree_delete" generated="true" style="display: none;" class="error"></label>
                    </div>
                     
                    <div class="col-12">
                      <input type="submit" name="submit" id="submit" value="Delete" class="btn btn-submit" onclick="return confirm('Are you sure you want to delete from this company')">                
                      <a href="javascript:void(0)" id="back" class="btn btn-submit">Back</a>
					   <input type="hidden" id="visitor_id" name="visitor_id">
                      <input type="hidden" name="action" value="delete_visitor">
                    </div>
                  </div>
                </form>-->
				               
              </div>







               

  
  
  


  <style>
    .date {background: #a89c5d; color: #fff; font-size: 12px; display: table; margin: 0 auto; line-height: inherit; padding: 5px 10px; font-weight: 700; border-radius: 100px;}
    p, .responsive_table {font-size: 15px; line-height: 26px;}
    .gold_clr {color: #a89c5d;}
    li a:hover {text-decoration: none; color: #000}
    .inner_under_listing li {font-size: 15px;}
    h2.title{font-size:16px;  color: #a89c5d; font-weight:bold; line-height: 28px;}

    @media (min-width: 768px){
      .responsive_table th, .responsive_table td {text-align: center; font-size: 14px; padding: 5px;}
    } 
    @media (max-width: 768px){
/*       h2.title {font-size: 18px;}
*/       .responsive_table th, .responsive_table td { font-size: 12px; padding-top: 5px; padding-bottom: 5px;}
    }     

    @media (min-width: 576px){
.modal-dialog {
    max-width: 450px;
}}

.close {color: #fff; text-shadow: none; opacity: 1;}

  </style>



        </div>
            <?php } else { ?>
            <div class="alert alert-light" role="alert">
              Currently there is no event for registration
            </div>
            <?php } ?>
               
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

<script src="https://gjepc.org/assets-new/js/bootstrap.min.js"></script>


</html>