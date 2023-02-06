<?php include('header_include.php');?>
<?php 
// Now Reset Password implementation
$action=$_REQUEST['action'];
$msg=$_SESSION['succ_msg'];
if($action=="send")
{  
	$email_id = filter($_REQUEST['email_id']);
    $query=$conn->query("select * from registration_master where (email_id='$email_id' OR company_pan_no='$email_id') ");
	$result=$query->fetch_assoc();	
	
	$num=$query->num_rows;
	 $status =  $result['status'];
	if($num>0 && $status =="1")
	{
		$query=$conn->query("select * from registration_master where (email_id='$email_id' OR company_pan_no='$email_id') and status=1");
		$update_result=$query->fetch_assoc();
		$email_id=$update_result['email_id'];
		$password=$update_result['company_secret'];
	
	/*.......................................Send mail to users mail id...............................................*/
   $message ='<table cellpadding="10" width="65%" style="margin:0px auto;font-family: Roboto; background-color:#eeee;padding:30px; border-collapse:collapse; ">
<tr><td style="background-color:#744F9E;padding:3px;"></td></tr>
  <tr><td align="left"><img src="https://gjepc.org/assets/images/logo.png"> </td></tr>
  <tr style="background-color:#eeee;padding:30px;">
  <td><h4 style="margin:0;">Your Password has been changed. </h4></td></tr>
  <tr style="background-color:#eeee;padding:30px; padding-bottom:0; padding-top:0;"><td style="padding-bottom:0; padding-top:0;"><strong>User Name :</strong> '. $email_id .'</td></tr>
  <tr style="background-color:#eeee;padding:30px; padding-bottom:0; padding-top:0;"><td style="padding-bottom:0; padding-top:0;"><strong>Password  :</strong> '. $password .'</td></tr>
   <tr><td>       
      <p>Kind Regards,<br>
      <b>GJEPC Web Team,</b>
      </p>
    </td>
  </tr>
</table>';
	 
	 $to =$email_id.',pvr@gjepcindia.com';
	 $subject = "Forgot Password Of GJEPC Member"; 
	 $headers  = 'MIME-Version: 1.0'."\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1'."\n"; 
	 $headers .= 'From: admin@gjepc.org';			
     @mail($to, $subject, $message, $headers);
		 
	 $_SESSION['succ_msg']="Your password has been sent to your email id <b>$email_id</b>, please Check your spam folder incase you do not receive our mails in your inbox.<br/> For Further Assistance Email to visitors@gjepcindia.com";
	 } else if ($num>0 && $status =="0") {
	 	  $_SESSION['succ_msg']="Account is Deactivated";
	 }else
	 {
	   $_SESSION['succ_msg']="Not Found";
	 }
} 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIJS - Forgot Password</title>
 <link rel="icon" href="https://gjepc.org/assets/images/fav_icon.png" type="image/x-icon"/>
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

<!-- UItoTop plugin -->
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css?v=<?php echo $version;?>" />
<script src="js/easing.js?v=<?php echo $version;?>" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js?v=<?php echo $version;?>" type="text/javascript"></script>    
<script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuart' });        
    });
</script>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="css/rcmc.validation.css" />

<script type="text/javascript">
$().ready(function() {
	// validate the comment form when it is submitted
	$("#commentForm").validate();
	// validate signup form on keyup and submit
	$("#form1").validate({
			//var member_id=$("#member_type_id").val();
		rules: {  
			email_id: {
				required: true
			}
		},
		messages: {
			email_id: {
				required: "Please enter a valid email id / PAN",
			}
	 }
	});
});
</script>


</head>

<body>
<div class="wrapper">
<div class="header">
	<?php include('header1.php'); ?>
</div>

<div class="new_banner">
<img src="images/banners/banner.jpg" />
</div>

<div class="inner_container">

	<div class="breadcrum"><a href="#">Home</a> > <a href="login.php">Login</a> > Forgot Password</div>    
    <div class="clear"></div>
    
    <div class="content_form_area">    
    <div class="pg_title">    
    <div class="title_cont">
        <span class="top">Forgot <img src="images/titles/joint.png" style="position:absolute; top:31px; right:0px;" /></span>   
        <span class="below"> Password</span>
        <div class="clear"></div>
    </div>
    
    </div> 
    <div class="clear"></div>
    
    <div class="form_main">
			<?php 
			if($_SESSION['succ_msg']!=""){
				echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
				$_SESSION['succ_msg']="";
			}
			else
				echo "";
       		?>
        <div class="field_box">Enter your E-mail / PAN. You'll be sent a new password immediately.</div>        
        <div class="clear" style="height:10px;"></div>
   
    <form class="cmxform" method="post" name="from1" id="form1">
        <div class="field_box">
            <div class="field_name" style="width:80px;">Email / Pan <span>*</span> :</div>
            <div class="field_input"><input type="text" class="bgcolor" id="email_id" name="email_id" placeholder="Email / PAN" autocomplete="off"/></div>
            <div class="clear"></div>
        </div>        
        <div class="clear" style="height:10px;"></div>
    
        <div class="field_box">
            <div class="field_name" style="width:80px;"></div>
            <div class="field_input">
            <input type="hidden" name="action" value="send" />
            <input type="submit" class="button" value="Submit" />
            </div>
            <div class="clear"></div>
        </div>
	</form>
	  
    <div class="clear" style="height:40px;"></div>
	</div>
	   
    <div class="clear"></div>
	</div><div class="clear" style="height:10px;"></div>
</div>

<div class="footer">
	<?php include('footer.php'); ?>
<div class="clear"></div>
</div>

<div class="clear"></div>
</div>

</body>
</html>
