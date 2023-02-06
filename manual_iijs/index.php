<?php 
include('header_include.php');
?>

<?php
$uid = filter($_REQUEST['uid']);
$gid = filter($_REQUEST['gid']);
$section = filter($_REQUEST['section']);

$query="select * from gjepclivedatabase.registration_master where id='$uid' and payment_defaulter='Y'";
$rquery = $conn ->query($query);
$count = $rquery->num_rows;
$result = $rquery->fetch_assoc();
$payment_defaulter_reason = $result['payment_defaulter_reason'];

/*if($count>0){
	echo '<script type="text/javascript">'; 
	echo 'alert("Please Apply  Compulsory Catalogue to access this form.");'; 
	echo 'window.location.href = "manual_list.php";';
	echo '</script>';
}*/

if(isset($_SESSION['EXHIBITOR_CODE'])){	header("location:manual_list.php");	exit; }

/*
if($section=='studded_jewellery')
{
	$Exhibitor_Section='Studded Jewellery';
}else if($section=='loose_stones')
{
	$Exhibitor_Section='Loose Stones';
}else if($section=='plain_gold')
{
	$Exhibitor_Section='Gold Jewellery';
}else if($section=='signature_club')
{
	$Exhibitor_Section='Signature Club';
}else if($section=='allied')
{
	$Exhibitor_Section='Allied';
}else if($section=='International Loose')
{
	$Exhibitor_Section='International Loose';
}else if($section=='International Jewellery')
{
	$Exhibitor_Section='International Jewellery';
}
*/


if($uid!="")
{
	$sqlquery="select * from iijs_exhibitor where Exhibitor_Registration_ID='$uid' and Exhibitor_Gid='$gid' and Exhibitor_IsActive='1'";
	$resultquery = $conn ->query($sqlquery);
	$rows_info = $resultquery->fetch_assoc();
	$no_of_rows = $resultquery->num_rows; 
	if($no_of_rows>0)
	{		
		$_SESSION['EXHIBITOR_CODE']=$rows_info['Exhibitor_Code'];
		$_SESSION['CUST_NO']=$rows_info['Customer_No'];
		$_SESSION['EMAILID']=$rows_info['Exhibitor_Email'];
		$_SESSION['EXHIBITOR_NAME']=$rows_info['Exhibitor_Name'];
		$_SESSION['Exhibitor_Country_ID']=$rows_info['Exhibitor_Country_ID'];
		$_SESSION['urls']="manual_list.php";
		header('location:manual_list.php');
		exit;
	}
	else
	{
	$sqlquery = "select * from iijs_exhibitor where Exhibitor_Registration_ID='$uid' and Exhibitor_Section='$Exhibitor_Section' and Exhibitor_IsActive='0'";		
	$resultquery = $conn ->query($sqlquery);
	$rows_info = $resultquery->fetch_assoc();		
		echo '<script language="javascript">';
		echo 'alert("Kinldy Clear Yor Balance Payment To Access The Form.");'; 
		//echo 'alert("Manual Coming Soon");'; 
		echo 'window.location.href = "https://registration.gjepc.org/my_dashboard.php";';
		echo '</script>';			
	}
}
?>
<?php
if(isset($_REQUEST['action']))
{
	$action=$_REQUEST['action'];	
	if($action=="login")
	{
		$exhibitor_login = filter($_REQUEST['exhibitor_login']);
		$exhibitor_password = filter($_REQUEST['exhibitor_password']);
		$login_query = "select * from iijs_exhibitor where Exhibitor_Login='$exhibitor_login' and Exhibitor_Password='$exhibitor_password'";
		$result = $conn ->query($login_query);		
		$fetch_info = $result->fetch_assoc();
		$num = $result->num_rows; 
		if($num>0)
		{				
			$_SESSION['EXHIBITOR_CODE']=$fetch_info['Exhibitor_Code'];
			$_SESSION['CUST_NO']=$fetch_info['Customer_No'];
			$_SESSION['EMAILID']=$fetch_info['Exhibitor_Email'];
			$_SESSION['EXHIBITOR_NAME']=$fetch_info['Exhibitor_Name'];
			$_SESSION['Exhibitor_Country_ID']=$fetch_info['Exhibitor_Country_ID'];
			$_SESSION['urls']="admin_manual_list.php";
			$_SESSION['auth']="admin";
			header('location:admin_manual_list.php');	exit;
		}	else
			$_SESSION['succ_msg']="You have entered wrong Username or password";
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Manual Login</title>
<link rel="shortcut icon" href="https://gjepc.org/assets/images/fav_icon.png">
<link rel="stylesheet" type="text/css" href="../css/mystyle.css" />
<!--navigation script-->
<script type="text/javascript" src="../js/jquery_002.js"></script>
<!-- place holder script for ie -->
<script type="text/javascript">
    $(function() {
        if (!$.support.placeholder) {
            var active = document.activeElement;
            
            $(':text').focus(function() {
                if ($(this).attr('placeholder') != '' && $(this).val() == $(this).attr('placeholder')) {
                    $(this).val('').removeClass('hasPlaceholder');
                }
            }).blur(function() {
                if ($(this).attr('placeholder') != '' && ($(this).val() == '' || $(this).val() == $(this).attr('placeholder'))) {
                    $(this).val($(this).attr('placeholder')).addClass('hasPlaceholder');
                }
            });
            $(':text').blur();
         
            $(active).focus();           
        }
    });
</script>   

<!--manual form css-->
<link rel="stylesheet" type="text/css" href="../css/manual.css"/>
<style>
	.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('https://gjepc.org/assets/images/logo.png') 50% 50% no-repeat rgb(249,249,249);
    opacity: .80;
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
	</style>
	
	<script type="text/javascript">
	$(window).load(function() {
		$(".loader").fadeOut("slow");
	});
	</script>
</head>

<body>
<div class="header_wrap">
	<?php include ('header.php'); ?>
</div>
<div class="loader"><p>Manual loading please wait....</p></div>
<!-- header ends -->
<div class="clear"></div>
<!--container starts-->
<div class="container_wrap">
	<div class="container">
    
      <div id="manual_login">
      <p class="error_msg"><?php if($_SESSION['succ_msg']!=""){echo $_SESSION['succ_msg'];} $_SESSION['succ_msg']=""; ?></p> 
      
        <form class="cmxform" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" name="form1" id="form1"> 
        <label>Username</label>
        <input name="exhibitor_login" type="text" class="textField" autocomplete="off" />           
        <label>Password</label>
        <input name="exhibitor_password" type="password" class="textField" autocomplete="off"/>        
        <div class="clear"></div>
        <input type="hidden" name="action" value="login"/>
        <input name="submit" type="submit" class="submitButton" value="Login" />
        <div class="bottomSpace"></div>        
        <!--<div class="link"><a href="../images/pdf/EXHIBITOR_MANUAL_SIGNATURE_2014.pdf" target="_blank">Read Exhibitor Manual <b>Click here</b></a></div> -->        
        </form>
      </div>
                
    <div class="clear"></div>
</div>     
</div>
<!--container ends-->
<!--footer starts-->
<div class="footer_wrap"><?php include ('footer.php'); ?></div>
<!--footer ends-->
</body>
</html>