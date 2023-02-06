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
            $("#captchaImg").attr("src","captcha_code_file.php?rand=<?php echo rand();?>");
            $("#email_check_loader").hide();
            $("#email_check").hide();

            $('#email').keyup(function (e) {
                e.preventDefault();
                $("#email_check").hide();
            var email = $(this).val();
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                if (emailReg.test(email)) 
                {
                    var action = "checkEmailAction";
                    $.ajax({
                        type:'POST',
                        data:{action:action,email:email},
                        url:"loginAction.php",
                        dataType: "json",
                        beforeSend: function()
                        {
                         $("#email_check_loader").show();
                        },
                        success:function(result){
                            $("#email_check").show();
                            $("#email_check_loader").hide();
                            if(result['status']=="success")
                            {  
                               $('label[for="email"]').html("");
                               $("#submit").attr("disable",false);
                            }else if(result['status']=="error")
                            {
                               $("#email_check").hide();
                               $('label[for="email"]').html(result.msg);
                               $("#submit").attr("disable",true); 
                            }else{
                               $("#email_check").hide(); 
                            }
                        }
                    });
                }else{
                    $("#email_check").hide();
                }
            });

            $("#loginForm").on("submit",function(e){
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
                
                
                }else if(result['status'] == "customError"){
                $(".error").css("display","block");
                $("label[for='"+result.label+"']").html(result.msg);
                $(".loader").fadeOut("slow");
                }else{
                $("#captcha").val("");    
                $("#captchaImg").attr("src","captcha_code_file.php?rand=<?php echo rand();?>");
                $.each(result, function(i, v) {
                $("label[for='"+v.label+"']").html(v.msg);
                });
                var keys = Object.keys(result);
                $(".error").css("display","block");
                 $(".loader").delay(1000).fadeOut("slow");
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
        <style>
           
        </style>
    </head>
    <body>
        <div class="loader"><p>loading please wait....</p></div>
        
            <div class="header">
                <?php include('header_test.php'); ?>   
            </div>  
            <div class="form_container">
                <div class="login_form">
                     <h3 class="title">LOGIN <span class="title-dash"></span></h3>
                    <form autocomplete="off" id="loginForm">
                        <div class="form_group">
                            <label>Email-Id:</label>
                            <div class="inputcontainer">
                                <input type="text" name="email" id="email" class="form_control" placeholder="Email-Id" >
                                <div class="icon-container">
                                   <i class="loader_input" id="email_check_loader"></i>
                                   <img src="images/check.png" id="email_check">
                                </div>
                            </div>
                            <label for="email" class="error"></label>
                            
                        </div>
                         <div class="form_group">
                            <label>PASSWORD:</label>
                            <input type="password" name="password" id="password" class="form_control" placeholder="PASSWORD" >
                            <label for="password" class="error"></label>
                            
                        </div>
                        <div class="captcha_input">
                        	<label>SECURITY CODE:</label>
                            <input type="text" name="captcha" id="captcha" class="form_control" placeholder="Enter code Here" >
                            <label for="captcha" class="error"></label>
                        </div>
                        <div class="captcha_input">
                            <img src="" id="captchaImg">
                        </div>
                         <div class="form_group">
                            <input type="hidden" name="action" value="loginFormAction">
                            <input type="submit" name="submit" id="submit" class="form_control btn_submit" value="LOGIN" >
                        </div>
                        <div class="links">
                        	<a href="single_visitor.php" class="link_btn">Login With Pan No</a>
                        	<a href="company_owner_login.php" class="link_btn">Login With Owners Mobile Number</a>
                        	<a href="domestic_user_registration_step1.php" class="link_btn">New Registration</a>
                        	<a href="forgot_password.php" class="link_btn">Forgot Password</a>
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