<?php
if(isset($_REQUEST['action']) && $_REQUEST['action']=="login")
{  //echo '<pre>'; print_r($_SESSION); echo '---->'.$_SESSION['captcha_code']; exit;

	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	
	if(empty($_SESSION['captcha_code'] ) ||  strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0)
	{
		$_SESSION['succ_msg']= "The captcha code does not match!";
	} else {
		
	$email_id=mysql_real_escape_string(trim($_POST['email_id'])); 
	$password=mysql_real_escape_string(trim($_POST['password'])); 
	$email_id=str_replace(" ","",$email_id);
	$password=str_replace(" ","",$password);
	
    $query=mysql_query("select * from registration_master where email_id='$email_id' and company_secret='$password' and status=1");
	$result=mysql_fetch_array($query);
    $num=mysql_num_rows($query);
	if($num>0)
	{
	  $_SESSION['USERID']=$result['id'];
	  $_SESSION['EMAILID']=$result['email_id'];
	  $_SESSION['COMPANYNAME']=strtoupper($result['company_name']);
	  $_SESSION['COUNTRY']=strtoupper($result['country']);
	  
	  mysql_query("update registration_master set lastlogin_website='registration.gjepc.org',last_login=Now() where id=".$result['id']);	  
	  header('location:my_dashboard.php');
	
	} else	{
	 $_SESSION['succ_msg']="You have entered wrong username or password";
	}
  }
	} else {
	 $_SESSION['succ_msg']="Invalid Token Error";
	}
} 
?>

	<div class="login_box">
	<?php 
	if(isset($_SESSION['succ_msg']) && $_SESSION['succ_msg']!=""){
	echo "<span class='notification n-attention'>".$_SESSION['succ_msg']."</span>";
	$_SESSION['succ_msg']="";
	} ?>  
    
	<form class="cmxform" method="POST" name="from1" id="form1">
	<?php token(); ?>
    <div>USERNAME :<br /> <input type="text" class="text" id="email_id" name="email_id" autocomplete="off"/></div>
    <div>
    PASSWORD :<br /> <input type="password" class="text" id="password" name="password" autocomplete="off"/>
    <input type="hidden" name="action" value="login" />
    </div>
	<div><br />Captcha <input type="text" class="text" value="" id="captcha_code" name="captcha_code" autocomplete="off"/></div>
	<div><br /> <img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg'/></div>
    <div><input type="submit" value="Login" /></div>
    
    <div><a href="domestic_user_registration_step1.php">New Registration</a> / <a href="forgot_password.php">Forgot Password</a></div>    
    <div class="clear"></div>
    </form>
    </div>
    