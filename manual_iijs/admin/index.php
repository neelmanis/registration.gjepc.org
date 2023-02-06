<?php
session_start(); 
include('../db.inc.php'); ?>
<?php 
$msg='';
$today = date('Y-m-d');
if(($_REQUEST['txtUsername']!='') && ($_REQUEST['txtPassword']!=''))
{
	$email_id = filter($_REQUEST['txtUsername']); 
	$password = filter($_REQUEST['txtPassword']); 
	$email_id = str_replace(" ","",$email_id);
	$password = str_replace(" ","",$password);

   		$query = "select * from admin_master where email_id = '$email_id' and password='$password' and status='1'";
		$result = $conn ->query($query);
		$count = $result->num_rows;
		$db_data = $result->fetch_assoc();
		$contact_name = $db_data['contact_name'];
		$email_id = $db_data['email_id'];
		$admin_id = $db_data['id'];
		$role = $db_data['role'];
		/*if($role=='Vendor')
		{
		  $role='Super Admin';	
		}*/
		$admin_access = $db_data['admin_access'];
		$region_name = $db_data['region_name'];
		$division_name = $db_data['division_name'];
		$section = $db_data['section'];
		$scheme = $db_data['scheme'];
		$hall = $db_data['hall'];
		$cc_tv_access = $db_data['cc_tv_access'];
		$vendor_access = $db_data['vendor_access'];
		if($count > 0)
		{
			$_SESSION['admin_contact_name']=$contact_name;
			$_SESSION['admin_email_id']=$email_id;
			$_SESSION['admin_login_id']=$admin_id;
			$_SESSION['admin_role']=$role;
			$_SESSION['admin_admin_access']=$admin_access;
			$_SESSION['admin_region_name']=$region_name;
			$_SESSION['admin_division_name']=$division_name;
			$_SESSION['admin_section']=$section;
			$_SESSION['admin_scheme']=$scheme;
			$_SESSION['admin_hall']=$hall;
			$_SESSION['cc_tv_access']=$cc_tv_access;
			$_SESSION['admin_vendor_access']=$vendor_access;
			
			echo"<meta http-equiv=refresh content=\"0;url=admin.php\">";
		}
		else 
		{ 
			$msg='Invalid login details';
		}
}	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome To Admin Control Panel || Signature ||</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script language="javascript">
function checkform()
{
	if(document.idpform.txtUsername.value=='')
	{
		alert("Please enter username")
		document.idpform.txtUsername.focus();
		return false;
	}
	if(document.idpform.txtPassword.value=='')
	{
		alert("Please enter password")
		document.idpform.txtPassword.focus();
		return false;
	}
	if(document.idpform.captcha_code.value=='')
	{
		alert("Please enter Security Code")
		document.idpform.captcha_code.focus();
		return false;
	}
}

</script>
<script language='JavaScript' type='text/javascript'>
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
</head>

<body>

<div id="header_wrapper">
	<div class="header">
     	<div class="logo"><img src="https://registration.gjepc.org/manual_iijs/images/logo.png" alt="" width="150" height="77" /></div>
      <div class="punch_line"></div>
      <div class="gjepc_logo" style="float:right;"><img src="https://gjepc.org/assets/images/logo.png" alt="" /></div>
      <div class="clear"></div>  
	</div>	
</div>

<div id="nav_wrapper"></div>

<div id="container">
		<div class="login_cont">
       	  <div class="head"><img src="images/lock.png" style="vertical-align:middle" /> Login</div>
            
			<form id="idpform" name="idpform" method="POST" action="" onSubmit="return checkform()"/>
            <table width="540" class="login">
                <tr>
                    <td height="21">&nbsp;</td>
                    <td colspan="2" class="error_msg"> <?php if($msg!=''){ echo $msg; }  ?></td>
                </tr>            
                <tr>
                    <td>&nbsp;</td>
                    <td width="174" class="txt3">Username</td>
                    <td width="333"><input type="text" name="txtUsername" id="txtUsername" class="input_txt" autocomplete="off"/></td>
                </tr>            
                <tr>
                    <td>&nbsp;</td>
                    <td class="txt3">Password</td>
                    <td><input type="password" name="txtPassword" id="txtPassword" class="input_txt" autocomplete="off"/></td>
                </tr>
            
                <!--<tr valign="top">
                    <td>&nbsp;</td>
                    <td class="txt3" valign="middle">Security Code&nbsp;&nbsp;:</td>
                    <td class="txt3" style="font-weight:normal">
                    <p>
                    <img src="captcha_code_file.php?rand=<?php //echo rand(); ?>" id='captchaimg' ><br>
                    <input id="captcha_code" name="captcha_code" type="text" class="input_txt"><br>
                    <small>Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh</small> </p>				</td>
                </tr>-->
            
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td ><input type="submit" value="Submit"  class="input_submit" /></td>
                </tr>
            
            </table>
            </form>
          </div>
	
</div>

<div id="footer_wrap">
	Developed by <a href="http://kwebmaker.com/" target="_blank">K Webmaker™</a>
</div>
</body>
</html>