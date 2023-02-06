<?php
//print_r($_SESSION);
if(isset($_SESSION['AGENCYID']) && $_SESSION['AGENCYID']!=''){ header("location:vendor-agency-dashboard.php");exit;	}
if(isset($_REQUEST['action']) && $_REQUEST['action']=="login")
{  //echo '<pre>'; print_r($_SESSION); echo '---->'.$_SESSION['captcha_code']; exit;

	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	
	if(empty($_SESSION['captcha_code'] ) ||  strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0)
	{
		$_SESSION['succ_msg']= "The captcha code does not match!";
	} else {
		
	$email = mysqli_real_escape_string($conn,trim($_POST['email']));	
	$password = mysqli_real_escape_string($conn,trim($_POST['password']));
	$email = str_replace(" ","",$email);
	//$password = str_replace(" ","",$password);
	$password= md5(str_replace(" ","",$password));
	$sql  = "select * from visitor_agency_master where `email`='$email' and `password`='$password' and `status`='1'";
    $query=$conn->query($sql);
	$result=$query->fetch_assoc();
    $num=$query->num_rows;
	if($num>0)
	{
	  $_SESSION['CATEGORYID']=$result['category'];
	  $_SESSION['AGENCYID']=$result['id'];
	  $_SESSION['EMAILID']=$result['email'];
	  $_SESSION['COMPANYNAME']=strtoupper($result['agency_name']);
	  $_SESSION['COMPANYTYPE']=strtoupper("AGENCY");
	  header('location:vendor-agency-dashboard.php');
	
	} else	{
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
    
	<form class="loginform row" method="POST" name="from1" id="form1" >
	<?php token(); ?>
    <div class="col-12 form-group"><label> Username :</label><br /> <input type="text" class="text" id="email" name="email" autocomplete="off"  placeholder="Username" /></div>
    <div class="col-12 form-group"><label>Password :</label> <br /> <input type="password" class="text form-conrol" id="password" name="password" autocomplete="off" placeholder="Password"/ >
    <input type="hidden" name="action" value="login" />
    </div>
	<div class="col-12 form-group"><label>Captcha :</label><br />  <input type="text" class="text" value="" id="captcha_code" name="captcha_code" autocomplete="off" placeholder="Captcha Code" /></div>
	<div class="col-12 form-group"> <img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg'/></div>
    <div class="col-12 form-group"><input type="submit" value="Login" /></div>
    
   
    <div class="clear"></div>
    </form>
    
<div class="clear"></div>
    </div>
    <!-- <div style="color:#F00;margin-left:30%;font-size:14px;">Dear Visitor, Registration is now closed for IIJS Virtual 2020</div> -->
    </div>
    <style>
    .login_box {
    width: 100%;
    padding:0;
    }
    </style>