<style type="text/css">
@media only screen and (max-width: 600px) {
	.box-shadow{
		width: 100%;
	}
}
</style>
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
    $query=$conn->query($sql);
	$result=$query->fetch_assoc();
    $num=$query->num_rows;
	if($num>0)
	{
	  $_SESSION['USERID']=$result['id'];
	  $_SESSION['EMAILID']=$result['email_id'];
	  $_SESSION['COMPANYNAME']=strtoupper($result['company_name']);
	  $_SESSION['COUNTRY']=strtoupper($result['country']);
	  $_SESSION['redirectLink']="institute";
	  $conn->query("update registration_master set lastlogin_website='registration.gjepc.org',last_login=Now() where id=".$result['id']);	  
	  header('location:institute_dashboard.php');	
	} else {
	 $_SESSION['succ_msg']="You have entered wrong username or password";
	}
    }
	} else {
	 $_SESSION['succ_msg']="Invalid Token Error";
	}
} 
?>

	<div class="login_box ">
    <div class="box-shadow" >
	<?php 
	if(isset($_SESSION['succ_msg']) && $_SESSION['succ_msg']!=""){
	echo "<span class='notification n-attention'>".$_SESSION['succ_msg']."</span>";
	$_SESSION['succ_msg']="";
	} ?>  
    <p style="color:#9c8c54;font-weight: bold;font-size: 16px; text-align: center;"><u>Institute Login</u></p>
	<form class="loginform row" method="POST" name="from1" id="form1" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
	<?php token(); ?>
    <div class="col-12 form-group"><label> Username :</label><br /> <input type="text" class="text" id="email_id" name="email_id" autocomplete="off"  placeholder="Username" /></div>
    <div class="col-12 form-group"><label>Password :</label> <br /> <input type="password" class="text form-conrol" id="password" name="password" autocomplete="off" placeholder="Password"/ >
    <input type="hidden" name="action" value="login" />
    </div>
	<div class="col-12 form-group"><label>Captcha :</label><br />  <input type="text" class="text" value="" id="captcha_code" name="captcha_code" autocomplete="off" placeholder="Captcha Code" maxlength="10"/></div>
	<div class="col-12 form-group"> <img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg'/></div>
    <div class="col-12 form-group"><input type="submit" value="Login" /></div>
    
    <div class="col-12">
    <br />
    <a href="https://gjepc.org/forgotpassword.php" style="color:#9c8c54;font-weight: bold;font-size: 16px">Forgot Password</a></div>    
    <div class="clear"></div>
    </form>
  
<div class="clear"></div>
    </div>
    </div>