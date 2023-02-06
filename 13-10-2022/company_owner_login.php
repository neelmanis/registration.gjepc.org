<?php
include('header_include_test.php');
    if(isset($_SESSION['USERID'])){ header("location:my_dashboard.php"); exit;  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome to IIJS-PREMIERE</title>
        <link rel="shortcut icon" href="images/fav.png" />
        <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
        <link rel="stylesheet" type="text/css" href="css/general.css" />
        <link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />
        <link rel="stylesheet" type="text/css" href="css/responsive.css" />
        <link rel="stylesheet" type="text/css" href="css/media_query.css" />
        <link rel="stylesheet" type="text/css" href="css/login_form.css" />
        <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
        <!--NAV-->
        <link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js"></script>
        <script type="text/javascript" src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
        <script src="js/common.js"></script>
        <!--NAV-->
        <!-- Facebook Pixel Code -->
<script>
$(window).load(function() {
  $(".loader").fadeOut("slow");
});
$(document).ready(function(){
  $("#otp_loader").hide();
  $("#otp_sent_loader").hide();
  $("#loadCaptcha").attr("src","captcha_code_file.php?rand=<?php echo rand();?>");
	$("#resendOtp").css("display","none");
  $(".error").html("");
	$(".success").html("");
	$(".error").css("display","none");
  $('input[name="choice"]').on("click", function(){
  $("#pass").val("");
 	var val = $(this).val();
 	var mobile_number = $("#mobile_number").val();
 	if(mobile_number !=""){
   	$('label[for="mobile_number"]').html("");
   	$(".error").css("display","none");
   	if(val =="otp"){
      $("#ot_pass_label").text("OTP NUMBER");
      $('input[name="pass"]').attr('placeholder',"ENTER OTP NUMBER");
	    var action = "ownerMobileOtpSend";
	    $.ajax({
		    type:'POST',
		    data:{action:action,mobile_number:mobile_number},
		    url:"loginAction.php",
		    dataType: "json",
        beforeSend: function()
        {
         $("#otp_sent_loader").show();
        },
		    success:function(result){
                      $("#otp_sent_loader").fadeOut("slow");
			    if(result.status=="success")
			    {
            $(".error").html("");
            $('label[for="otp_sent_message"]').html(result.message);
            //$("#resendOtp").css("display","inline-block");
            //$("#otp").data('sent','Yes');
			    }else if(result.status=="error"){
            $("#resendOtp").css("display","none");
				   	$(".success").html("");
					  $(".error").css("display","block");
            $('label[for="mobile_number"]').html(result.message);
            $(this).prop('checked', false);
			   }
		    }
	    });
    }else if(val =="password"){
      $('label[for="otp_sent_message"]').html("");
      $("#pass").val("");
      $('input[name="pass"]').attr('placeholder',"ENTER PASSWORD");
      $("#ot_pass_label").text("PASSWORD");
   	}else{
      $("#pass").val("");
	      $('input[name="pass"]').attr('placeholder',"ENTER OTP/PASSWORD");
      $("#ot_pass_label").text("OTP / PASSWORD");
   		}
 	}else{
 		$(this).prop('checked', false);
 		$('input[name="mobile_number"]').focus();
 		$('label[for="mobile_number"]').html("Please Enter Mobile Number");
 		$(".error").css("display","block");
 		//$("#submit").attr("disable",true);
  }
});

$("#mobile_number").on("keyup", function(){
  var checkLength = $(this).val().length;
  $('input[name="choice"]').prop('checked', false);
  if(checkLength == 0){
   	$("#ot_pass_label").text("OTP / PASSWORD");
	    $('input[name="pass"]').attr('placeholder',"ENTER OTP/PASSWORD");
	    $('input[name="pass"]').val('');
   	$('input[name="mobile_number"]').focus();
 		$('label[for="mobile_number"]').html("Please Enter Mobile Number");
 		$(".error").css("display","block");
  }
});
$('.numeric').keypress(function (event) {
  var keycode = event.which;
  if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) 
  {
    event.preventDefault();
  }
});
$("#pass").on("keyup", function(){
$('.error').html("");
var otp = $(this).val(); 
var mobile = $("#mobile_number").val(); 
if($(this).val().length == 4 && $("#mobile_number").val().length > 9 && $("#otp").prop("checked")){
  var action = "otpCheck";
  $.ajax({
  type:'POST',
  data:{action:action,otp:otp,mobile:mobile},
  url:"loginAction.php",
  dataType: "json",
   beforeSend: function() {
   $("#otp_loader").show();
  },
  success:function(result){
    $("#otp_loader").fadeOut("slow");
    if(result.status=="success")
      {
        $(".error").html("");
        $('label[for="otp_sent_message"]').html(result.message);
      }else if(result.status=="error")
      {
        $('label[for="otp_sent_message"]').html("");
        $('label[for="password"]').html(result.message);
        $(".error").css("display","block");
       }
    }
  }); 
}else
{
    $(".loader_input").hide();
    return false;
}
});
$("#companyOwnerLogin").on("submit",function(e){

    e.preventDefault();
    $(".error").html("");
    $(".error").css("display","none");
    var formdata = $(this).serialize();
    $.ajax({
    type:'POST',
    data:formdata,
    url:"loginAction.php",
    dataType: "json",
    beforeSend: function() {
     $(".loader").show();
    },
    success:function(result){
     $(".loader").fadeOut("slow");
    if(result['status'] == "loggedIn")
    {
      $("#submit").attr("disable",true);    
      $(".loader").fadeOut("slow");
      swal({
        title: 'You Are Successfully Logged In',
        icon: 'success',
        timer: 2000,
        showCancelButton: false,
        showConfirmButton: false,
        closeOnClickOutside: false,
        confirmButtonColor: "#fff",
      }).then(function(){
        window.location.href="my_dashboard.php";  
      });
    }else{
    $("#captcha").val("");    
    $("#loadCaptcha").attr("src","captcha_code_file.php?rand=<?php echo rand();?>");
    $.each(result, function(i, v) {
    $("label[for='"+v.label+"']").html(v.msg);
    });
    var keys = Object.keys(result);
    $(".error").css("display","block");
    }
    }
    });
});
});
</script>
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
        <div class="loader"><p>loading please wait....</p></div>
        
            <div class="header">
                <?php include('header_test.php'); ?>   
            </div>  
            <div class="form_container">
                <div class="login_form">
                     <h3 class="title">COMPANY OWNER LOGIN <span class="title-dash"></span></h3>
                    <form id="companyOwnerLogin" autocomplete="off">
                        <div class="form_group">
                            <label>MOBILE NUMBER:</label>
                            <input type="text" name="mobile_number" id="mobile_number" maxlength="10"   class="form_control numeric" placeholder="MOBILE NUMBER" >
                            <label for="mobile_number" class="error"></label>
                        </div>
                        <div class="captcha_input">
                            <div class="inputcontainer">
                            	<label><input type="radio" name="choice" id="otp"  value="otp" data-sent="No">Login Via OTP</label>
                                    <div class="icon-container">
                                      <i class="loader_input" id="otp_sent_loader"></i>
                                    </div>
                            </div>
                        </div>
                        <div class="captcha_input ">
                        	<label><input type="radio" name="choice" id="password"  value="password">I HAVE A PASSWORD</label>
                        </div>
                        <label for="choice" class="error"></label>
                        <div class=" mb-15"></div>
                         <div class="form_group">
                            <label id="ot_pass_label" style="display: inline-block;">OTP / PASSWORD:</label><span id="resendOtp">RESEND OTP</span>
                            <div class="inputcontainer">
                            <input type="password"  name="pass" id="pass" class="form_control" placeholder="ENTER OTP / PASSWORD" >
                            <div class="icon-container">
                              <i class="loader_input" id="otp_loader"></i>
                            </div>
                            </div>
                            <label for="password" class="error"></label>
                            <label for="otp_sent_message" class="success"></label>

                        </div>
                        <div class="captcha_input">
                        	<label>SECURITY CODE:</label>
                            <input type="text" name="captcha" id="captcha" class="form_control" placeholder="ENTER CODE HERE" >
                            <label for="captcha" class="error"></label>
                        </div>
                        <div class="captcha_input">
                            <img src="" id="loadCaptcha">
                        </div>
                         <div class="form_group">
                            <input type="hidden" name="action" value="OwnerLogin">
                            <input type="submit" name="submit" id="submit" class="form_control btn_submit" value="LOGIN"  >
                        </div>
                    </form>
                </div>
                <div class="clear" style="height:10px;"></div>
            </div>
            <div class="clear"></div>
            <div class="footer">
                <?php include('footer.php'); ?>
                <div class="clear"></div>
            </div>

    </body>
</html>