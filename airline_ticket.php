<?php include('header_include.php');?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Air Ticket Booking</title>
    <link rel="icon" href="https://gjepc.org/images/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="css/general.css" />
    <link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />
    <link rel="stylesheet" type="text/css" href="css/responsive.css" />
    <link rel="stylesheet" type="text/css" href="css/media_query.css" />
    <link rel="stylesheet" type="text/css" href="css/visitor_reg.css" />
    <link rel="stylesheet" type="text/css" href="css/new_style.css" /> 

    <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
   <!--NAV-->
	<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js"></script>
	<script src="js/common.js"></script> 
	<!--NAV-->
    <!-------------------------Form Validations------------------------------->
    <script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
    <script type="text/javascript">
	$(document).ready(function() {
		$("#otp_form").hide();
		$('#pan_number').change(function(){
			panLength=$('#pan_number').val().length;
			if(panLength>=10){
			var panVal = $('#pan_number').val();
			var regpan = /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/;
			if(!regpan.test(panVal)){
				$('#panEmpty').text("Invalid PAN No.");
		    } else {
				$('#panEmpty').text("");
				$.ajax({
					type:'POST',
					data:'actiontype=checkPanNo&pan_number='+panVal,
					url:'airTticketAjax.php',
					dataType: 'json',
				beforeSend: function(){
					$('.loaderWrapper').show();
				},
				success:function(data){ //alert(data);
					$('.loaderWrapper').hide();
					if(data['status']=="success"){
						$('#mobile').show();
						 mobile=data['mobile'];
						$("#mobile_no").val(mobile);
						$('#pan_number').attr('readonly', true); 
					}else if(data['status']=="notExistHistory"){
					    $('#mobile').hide();
						$("#mobile_no").val('');
						$('#pan_number').removeAttr("readonly");
						$('#panEmpty').text("Payment Not Done.");
				    }else if(data['status']=="notExist"){
					    $('#mobile').hide();
						$("#mobile_no").val('');
						$('#pan_number').removeAttr("readonly"); 
						$('#panEmpty').text("This PAN No. is not verified");
				    }	
				}
			  });
			}
		 }
	  });
	  
	  /*.............................Send Otp.................................*/
	  $('#otp_btn').click(function(){
			var mobile_no=$('#mobile_no').val();
				$.ajax({
					type:'POST',
					data:'actiontype=send_otp&mobile_no='+mobile_no,
					url:'airTticketAjax.php',
					dataType: 'json',
				beforeSend: function(){
					$('.loaderWrapper').show();
				},
				success:function(data){
					$('.loaderWrapper').hide();
					if(data['status']=="success"){
						$("#otp_form").show();
						$("#check_company_pan").hide();
					}			
				}
			  });
	  });
	  /*.............................Verify Otp.................................*/
	  $('#verify_otp').click(function(){ //alert('hi');
		var mobile_no=$('#mobile_no').val();
		var otp_number=$('#otp_number').val();
		var visitor_type=$("input[name='visitor_type']:checked").val()
		var pan_number=$('#pan_number').val();
				$.ajax({
					type:'POST',
					data:'actiontype=verify_otp&otp_number='+otp_number+'&mobile_no='+mobile_no+'&visitor_type='+visitor_type+'&pan_number='+pan_number,
					url:'airTticketAjax.php',
					dataType: 'json',
				beforeSend: function(){
					$('.loaderWrapper').show();
				},
				success:function(data){
				console.log(data); 
					$('.loaderWrapper').hide();
					if(data['status']=="success"){
						$('#otpEmpty').text("");
						window.location = "airline_ticket_registration.php";
						//$(location).attr('href', 'airline_ticket_registration.php');
					} else {
						$('#otpEmpty').text("Invalid OTP.");
					}			
				}
			  });
	  });
	  
	  /*.............................Resend Otp.................................*/
	  $('#resendotp_btn').click(function(){
			var mobile_no=$('#mobile_no').val();
				$.ajax({
					type:'POST',
					data:'actiontype=resend_otp&mobile_no='+mobile_no,
					url:'airTticketAjax.php',
					dataType: 'json',
				beforeSend: function(){
					$('.loaderWrapper').show();
				},
				success:function(data){
					$('.loaderWrapper').hide();
					if(data['status']=="success"){
						$("#otp_form").show();
						$("#check_company_pan").hide();
					}			
				}
			  });
	  });
	  
	});
    </script>
  </head>
  
<body>

<div class="wrapper">
	
    <div class="header">
		<?php include('header1.php'); ?>
		<div class="clear"> </div>
	</div>
    <div class="clear"> </div>
    <div class="container_wrap">
    
    	<div class="container">
        
        	<span class="headtxt">IIJS Signature 2020 Airline Booking Form to get travel benefits</span>
            
          	<div id="loginForm">
            	
                <div id="formContainer">
              		
                    <div class="loaderWrapper">                		
                        <div class="formLoader"> <img src="images/formloader.gif" alt=""> <p> Please Wait....</p> </div>                        
              		</div>
                    <form method="POST" id="check_company_pan" autocomplete="off">
             			
                        <div class="d-flex">
                        
                            <div class="form-group" style="margin-right:15px;">
                            	<label class="container_radio">
                                    <span class="check_text">Are You Visitor?</span>
                                    <input type="radio" name="visitor_type" value="V">
                                    <span class="checkmark_radio"></span>
                                </label>
                            </div>
                        
                        	<div class="form-group">
                           		<label class="container_radio">
                                	<span class="check_text">Are You Exhibitor?</span>
                                    <input type="radio" name="visitor_type" value="E">
                           			<span class="checkmark_radio"></span>
                           		</label>
                           </div>
                            
                      	</div>  
                        
                        <div id="visitor_wrp">
                        
                        <div class="col-50 form-group">
                        <label>Enter Your PAN No</label>
                        <input type="text" class="form-control pan_no" name="pan_number" id="pan_number" maxlength="10"  />			
                        <p id="panEmpty" class="fail"></p>
                        </div>
                           
                      <div id="mobile" style="display:none;">   
                           <div class="col-50 form-group">
                              <label>Mobile No.</label>
                              <input type="text" class="form-control" name="mobile_no" id="mobile_no" maxlength="10" readonly="readonly" />
                           </div>
                           <div class="col-50 form-group">
                           		<input type="button" class="btn-submit" id="otp_btn" value="Send OTP"/>
                           		<input type="button" class="btn-submit" id="resendotp_btn" value="Resend OTP"/>
                           </div>
                       </div> 
                      <div class="clear"></div>    
                       </div>
              		</form>
                    
                    <form method="POST" id="otp_form" autocomplete="off">
                        <div class="col-50 form-group">
                        	<label>Enter OTP</label>
                            <input type="text" class="form-control" name="otp_number" id="otp_number"  maxlength='4'/>
                            <p id="otpEmpty" class="fail"></p>
                        </div>
                        
                        <div class="col-50 form-group">
                        	<label>&nbsp</label>
                            <input type="button" class="btn-submit" id="verify_otp" value="Verify OTP"/>
                        </div>
                    	<div class="clear"></div>
                    </form>       
             	</div>
            </div>
		</div>
        <div class="clear"></div>
	</div>
	<!--container ends-->

</div>

<!--footer starts-->
<div class="footer">
	<?php include ('footer.php'); ?>
</div>
<!--footer ends-->

<style>
#formContainer {padding:20px;}
	#visitor_wrp {display:none;}
	label {margin-bottom:10px; display:block;}
	.col-50 {float:left;}
	.form-group {padding:0;}
	.form-control:focus {
    border: 1px solid #222;
	}
	.btn-submit {box-shadow:none; border:0; height:32px; padding:0 15px; cursor:pointer;}
	#otp {display:none;}
</style>

<script>
$(document).ready(function(){
	$('input[name="visitor_type"]').change(function(){
		if(this.value=="V" || this.value=="E"){
			$("#visitor_wrp").show();
			$("#exhibitor_wrp").hide();
			}else{
				$("#visitor_wrp").hide();
				$("#exhibitor_wrp").show();
				
				}
		});
	});
</script>

</body>
</html>