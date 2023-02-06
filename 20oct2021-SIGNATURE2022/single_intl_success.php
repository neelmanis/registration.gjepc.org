<?php include('header_include.php');
if(!isset($_SESSION['uid'])){ header("location:single_intl_registration.php");	exit; }
$uid = $_SESSION['uid'];
$eid = $_SESSION['eid']; 
$email = $_SESSION['email']; 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to IIJS PREMIERE 2021</title>
<link rel="shortcut icon" href="images/fav.png" />
 <link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/mystyle.css?v=<?php echo $version;?>" />
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
	<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
	 
	<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
	 <link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
	<script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>

	<!--NAV-->
	<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="js/jquery.flexnav.js?v=<?php echo $version;?>" type="text/javascript"></script>
	<script src="js/common.js?v=<?php echo $version;?>"></script> 
	<!--NAV-->
	<script src="jsvalidation/jquery.validate.js?v=<?php echo $version;?>" type="text/javascript"></script>

	<!-- UItoTop plugin -->
	<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css?v=<?php echo $version;?>" />
	<script src="js/easing.js?v=<?php echo $version;?>" type="text/javascript"></script>
	<script src="js/jquery.ui.totop.js?v=<?php echo $version;?>" type="text/javascript"></script>    
	<script type="text/javascript">
		$(document).ready(function() {        
			$().UItoTop({ easingType: 'easeOutQuart' });        
		});
	</script>
	<style type="text/css">
		
	</style>

</head>

<body>
<div class="wrapper">

			<div class="header">
						<div class="head_main">
							<div class="logo_setup">
								<div class="logo"><a href="#"><img src="https://registration.gjepc.org/images/IIJS-Premiere-2021-logo.png" title="GJEPC" class="logo_img" style="width: 150px;"></a></div>
								<div class="logo2">
								<a href="https://www.gjepc.org/"><img src="https://gjepc.org/images/gjepc_logon.png" title="GJEPC" style="width:140px;" class="logo_img"></a>
								</div>
							</div>
						</div>
			</div>
			<div class="clear"></div>
<!--container starts-->
<div class="inner_container">
  <div class="container">
    <div class="container_leftn">
	<?php
	if(isset($uid) && $uid!="")
	{
		$fetch_data = "select * from ivr_registration_details where uid=".$_SESSION['uid']." AND eid='$eid'";	
		$result = $conn->query($fetch_data);
		if(!$result){
			die($conn->error);	
		}
		$data = $result->fetch_assoc();

		/*Send Email Receipt to Company */
		$message ='<table class="table2" width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">	
    <tbody>    
    	<tr>
            <td align="left"><img id="ri" src="https://registration.gjepc.org/images/logo.png">
            <td align="center"> <img id="mi"> </td>
            <td align="right"><img id="ri" src="https://registration.gjepc.org/images/IIJS-Premiere-2021-logo.png"></td>
            </td>                        
		</tr>
            
        <tr><td colspan="3" height="30"><hr></td></tr>        
        <tr>           
        	<td colspan="3" id="content">
				<p> Dear '.$data['title'].' '.$data['first_name'].' '.$data['last_name'].',</p>
				<p> Thank you for registering at IIJS PREMIERE 2021 SHOW. Your registration is completed.</p>
				<p> You can also check more details on https://gjepc.org/iijs-premiere/</p>
		</td>            
        </tr>   
           <style type="text/css">
           .table2 input{width: 80%;border-left: none; border-right: none; border-top: none; border-bottom: 1px solid #000;}
               .table1 input{border-left: none; border-right: none; border-top: none; border-bottom: 1px solid #000; width: 150px;}
           }          
            .table2 h4{text-align: center;}
           </style>
	</tbody>
	</table>';
		
	//	$to ='neelmani@kwebmaker.com';
		$to = $data['email'];
		$subject = "Thank you for registering at IIJS PREMIERE 2021 SHOW"; 
		$headers  = 'MIME-Version: 1.0' . "\n"; 
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		$headers .= 'From: IIJS PREMIERE 2021 SHOW <admin@gjepc.org>';			
		mail($to, $subject, $message, $headers);
		/*  Email End */
		
		//	header("Refresh: 2; url=https://registration.gjepc.org/single_intl_registration.php");
	//	unset($_SESSION['uid']);
	//	unset($_SESSION['eid']);		
	//	unset($_SESSION['registration_id']);		
	//	unset($_SESSION['visitor_id']);		
		?>
		<div class="container_wrap">
		<div class="container" id="manualFormContainer">
		<h1 style="color:green;text-align: center;">SUCCESSFUL</h1>
		<div >
		<p style="text-align: center;">Thank you for your participation in IIJS PREMIERE 2021 SHOW</p>
		</div>
		<div class="clear"></div>
		</div>
		</div>
	<?php
	} else	{
		echo "<script type='text/javascript'> alert('Your session has been expired');
		window.location.href='https://registration.gjepc.org/login.php';
		</script>";
		return;	exit;
	}
	?>
 </div>
    </div>
	    <?php include("include_intl_vaccine_upload.php");?>
  </div>

<div class="clear"></div>
<?php include ('footer.php'); ?>
</div>
<!--footer ends-->
</body>
</html>