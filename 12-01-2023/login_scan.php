<?php 
include('header_include.php');
if(isset($_SESSION['SCAN_USERID'])){ header("location:my_dashboard.php"); exit;	}
?>
<?php
if(isset($_REQUEST['action']) && $_REQUEST['action']=="login")
{  //echo '<pre>'; print_r($_SESSION); echo '---->'.$_SESSION['captcha_code']; exit;

    //validate Token
    if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
    
    if(empty($_SESSION['captcha_code'] ) ||  strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0)
    {
        $_SESSION['succ_msg']= "The captcha code does not match!";
    } else {
        
        $email_id = mysqli_real_escape_string($conn,trim($_POST['email_id']));  
        $password = mysqli_real_escape_string($conn,trim($_POST['password']));
        $email_id = str_replace(" ","",$email_id);
        //$password = str_replace(" ","",$password);
        $password= md5(str_replace(" ","",$password));
        $sql  = "select * from registration_master where email_id='$email_id' and company_secret='$password' and status=1";
        //echo $sql;exit;
        $query=$conn->query($sql);
        $result=$query->fetch_assoc();
        $num=$query->num_rows;
        if($num>0)
        {
          $_SESSION['SCAN_USERID']=$result['id'];
          $_SESSION['EMAILID']=$result['email_id'];
          $_SESSION['COMPANYNAME']=strtoupper($result['company_name']);
          $_SESSION['COUNTRY']=strtoupper($result['country']);
          $_SESSION['redirectLink']="";
          $conn->query("update registration_master set lastlogin_website='registration.gjepc.org',last_login=Now() where id=".$result['id']);     
          header('location:my_dashboard_scan.php');  
        } else {
         $_SESSION['succ_msg']="You have entered wrong username or password";
        }
    }
    } else {
     $_SESSION['succ_msg']="Invalid Token Error";
    }
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Welcome to IIJS</title>
<link rel="icon" href="https://gjepc.org/assets/images/fav_icon.png" type="image/x-icon"/>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />

<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>

<!--NAV-->
<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
<script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js?v=<?php echo $version;?>"></script>
<script src="js/common.js"></script> 
<!--NAV-->
  
<!-- colorbox -->
<link media="screen" rel="stylesheet" href="css/colorbox.css?v=<?php echo $version;?>" />
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
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=398834417477910&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<script src="js/jquery.colorbox-min.js?v=<?php echo $version;?>"></script>
<script>
	$(document).ready(function(){
		//Examples of how to assign the ColorBox event to elements
		$("a[rel='example1']").colorbox({transition:"elastic"});
		$(".example6").colorbox({iframe:true, innerWidth:640, innerHeight:480});
	});
</script>

<!-- UItoTop plugin -->
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css?v=<?php echo $version;?>" />
<script src="js/easing.js?v=<?php echo $version;?>" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js?v=<?php echo $version;?>" type="text/javascript"></script>    
<script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuad' });        
    });
</script>
<script type="text/javascript">
	$(window).load(function() {
		$(".loader").fadeOut("slow");
	});
</script>
<style>
.loader{
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url(../images/logo.png) 50% 50% no-repeat rgb(255, 255, 255);
    opacity: 1;
  }
  .loader p{
    position: fixed;
    left: 45%;
    top: 58%;
    width: 100%;
    height: 100%;
    z-index: 9999;
    opacity: .80; 
  }
/*  .content_area{background: #1a1a1a}
  .login_box{margin: 0}*/
</style>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="css/rcmc.validation.css" /> 
<script type="text/javascript">
$().ready(function() {
	// validate the comment form when it is submitted
	$("#commentForm").validate();
	// validate signup form on keyup and submit
	$("#form1").validate({
		rules: {  
			email_id: {
				required: true,
				email:true
			},  
			password:{
				required: true,
			},
			captcha_code:{
				required: true,
			},
		},
		messages: {
			email_id: {
				required: "Please enter a valid email id",
			},
			password: {
				required: "Please enter your password",
			},
			captcha_code:{
				required: "Please enter captcha code",
		}
	 }
	});
});
</script>
<style type="text/css">
	.price_table{width: 100%;margin: 0; overflow:scroll;}
	.content_area table {
    width: 94%;
    margin-left: 3%;
    margin-right: 2%;
    margin-bottom: 10px;
    /* margin: 0px 18px 15px; */
}
/*.loginform{width: 100%;float: left;}*/
.box-shadow {
   width: 50%;
   margin-left: 50%;
   transform: translate(-50%);
}
.login_box {
  
   padding: 0;
    margin: 0 auto;

}
</style>


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

</head>

<body>
<div class="loader"><p>loading please wait....</p></div>
<div class="wrapper">

<!-- <div class="header"><?php //include('header1.php'); ?></div> -->
<!--<div class="new_banner"><img src="https://registration.gjepc.org/images/iijs-virtual-1.jpg"/></div>-->


<div class="inner_container">

<div class="bold_font text-center">
    <div class="d-block">
        <img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
    </div>
   <?php if(isset($_REQUEST['visitor']) && $_REQUEST['visitor']=="international" ){?> 
           International Visitor Registration 
        <?php }else{?>
            Login
        <?php } ?>
</div>
    <div class="clear"></div>
    
    <div class="content_area">    
    
    <div class="clear"></div>



    <div class="login_box ">
        <div class="box-shadow" >
            <?php 
            if(isset($_SESSION['succ_msg']) && $_SESSION['succ_msg']!=""){
                echo "<span class='notification n-attention'>".$_SESSION['succ_msg']."</span>";
                $_SESSION['succ_msg']="";
            } ?>  
        

            <form class="loginform row" method="POST" name="from1" id="form1" >
                <?php token(); ?>
                <div class="col-12 form-group"><label> Username :</label><br /> <input type="text" class="text" id="email_id" name="email_id" autocomplete="off"  placeholder="Username" /></div>
                <div class="col-12 form-group"><label>Password :</label> <br /> <input type="password" class="text form-conrol" id="password" name="password" autocomplete="off" placeholder="Password"/ >
                <input type="hidden" name="action" value="login" />
                </div>
                <div class="col-12 form-group"><label>Captcha :</label><br />  <input type="text" class="text" value="" id="captcha_code" name="captcha_code" autocomplete="off" placeholder="Captcha Code" /></div>
                <div class="col-12 form-group"> <img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg'/></div>
                <div class="col-12 form-group"><input type="submit" value="Login" /></div>
                
                <div class="col-12">
                <br />
                        
                    <a href="https://gjepc.org/forgotpassword.php" style="color:#9c8c54;font-weight: bold;font-size: 16px"></a></div>    
                <div class="clear"></div>
            </form>

            <div class="clear"></div>
        </div>
    <!-- <div style="color:#F00;margin-left:30%;font-size:14px;">Dear Visitor, Registration is now closed for IIJS Virtual 2020</div> -->
    </div>

<div class="clear"></div>
</div>	
 
<div class="clear" style="height:10px;"></div>
</div>
<div class="footer"><?php include('footer.php'); ?><div class="clear"></div>
</div>

<div class="clear"></div>
</div>



</body>
</html>