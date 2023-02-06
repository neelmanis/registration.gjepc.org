<?php 
include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit;	}
?>
<?php 
$action=$_REQUEST['action'];
if($action=="send")
{   
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		
	$id=$_SESSION['USERID'];
	$old_password = filter($_REQUEST['old_password']);
	$new_password = filter($_REQUEST['new_password']);
		
	$query=$conn->query("select * from registration_master where id='$id'");
	$result=$query->fetch_assoc();
	$old_pass = $result['old_pass'];	
	if($old_password != $old_pass)
	{
		$_SESSION['succ_msg1']="You have entered wrong old password";
	}
	else
	{	
		$n_password = md5($new_password);
    	$query=$conn->query("update registration_master set company_secret='$n_password',old_pass='$new_password' where id='$id'");
		$_SESSION['succ_msg']="Your Password has been updated";
	}
	} else {
	 $_SESSION['succ_msg1']="Invalid Token Error";
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>GJEPC - Change Password</title>
<link rel="shortcut icon" href="images/fav.png" />
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>

<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>

<!--NAV-->
<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.flexnav.js?v=<?php echo $version;?>" type="text/javascript"></script>
<script src="js/common.js?v=<?php echo $version;?>"></script> 
<!--NAV-->
<script src="jsvalidation/jquery.validate.js?v=<?php echo $version;?>" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="css/rcmc.validation.css?v=<?php echo $version;?>" /> 
<script type="text/javascript">
$().ready(function() {
	$("#confirmPassword").validate();
	$("#form1").validate({
		rules: {  
			old_password: {
			required: true,
			},  
			new_password: {
				required: true,
			}, 
			confirm_password: {
				required: true,
				equalTo: "#new_password"
			},
		},
		messages: {   
			old_password: {
				required: "Please enter old password",
			},
			new_password: {
				required: "Please enter new password",
			},
			confirm_password: {
				required: "Confirm password should be same",
				equalTo: "Please enter the same password"
			},
	 }
	});
});
</script>
<!-- UItoTop plugin -->
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css?v=<?php echo $version;?>" />
<script src="js/easing.js?v=<?php echo $version;?>" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js?v=<?php echo $version;?>" type="text/javascript"></script>    
<script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuart' });        
    });
</script>
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
</head>

<body>

<div class="wrapper">

<div class="header"><?php include('header1.php'); ?></div>

<div class="inner_container">
 
    <div class="content_area">
    
     <div class="bold_font text-center">
    <div class="d-block">
        <img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
    </div>
  Change Password
</div>
    <?php 
	if(isset($_SESSION['succ_msg']) && $_SESSION['succ_msg']!=""){
	echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
	$_SESSION['succ_msg']="";
	}
	else
	echo "";
    ?>
     
    <?php 
	if(isset($_SESSION['succ_msg1']) && $_SESSION['succ_msg1']!=""){
	echo "<span class='notification n-attention'>".$_SESSION['succ_msg1']."</span>";
	$_SESSION['succ_msg1']="";
	}
	else
	echo "";
     ?>
    <div class="form_main box-shadow small_box">
    
    <form class="cmxform " method="POST" name="from1" id="form1">       
        <div class="field_box">
            <div class="field_name">Old Password <span>*</span> :</div>
            <div class="field_input"><input type="password" class="bgcolor" id="old_password" name="old_password" autocomplete="off"/></div>
            <div class="clear"></div>
        </div>
        <div class="field_box">
            <div class="field_name" >New Password <span>*</span> :</div>
            <div class="field_input"><input type="password" class="bgcolor" id="new_password" name="new_password" autocomplete="off"/></div>
            <div class="clear"></div>
        </div>
       
        <div class="field_box">
            <div class="field_name">Confirm Password <span>*</span> :</div>
            <div class="field_input"><input type="password" class="bgcolor" id="confirm_password" name="confirm_password" autocomplete="off"/></div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        
        <div class="field_box">
            <div class="field_name"></div>
            <div class="field_input">
            <input type="hidden" name="action" value="send"/>
			<?php token(); ?>
            <input type="submit" class="button" value="Change Password" />
            </div>
            <div class="clear"></div>
        </div>
	</form>       
    </div>       
    <div class="clear"></div>
	</div>

	
 

<div class="clear" style="height:80px;"></div>
</div>
<div class="footer"><?php include('footer.php'); ?><div class="clear"></div>
</div>

<div class="clear"></div>
</div>

</body>
</html>