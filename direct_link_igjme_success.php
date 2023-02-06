<?php include('header_include.php');
if(!isset($_SESSION['registration_id'])){ header("location:login.php");	exit; }
$registration_id = $_SESSION['registration_id'];
$visitor_id = $_SESSION['visitor_id'];
$email = getVisitorEmail($visitor_id,$conn); 
$CompanyName = getCompanyName($registration_id,$conn); 
$visitorName = getVisitorName($visitor_id,$conn); 
$ownerMobile = getOwnerVisitorMobile($registration_id,$conn);
$visitorMobile = getVisitorMobile($visitor_id,$conn);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to IIJS</title>
<link rel="shortcut icon" href="images/fav.png" />
	<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
	<link rel="stylesheet" type="text/css" href="css/general.css" />
	<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />
	 
	<link rel="stylesheet" type="text/css" href="css/responsive.css" />
	<link rel="stylesheet" type="text/css" href="css/media_query.css" />
	<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>

	<!--NAV-->
	<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="js/jquery.flexnav.js" type="text/javascript"></script>
	<script src="js/common.js"></script> 
	<!--NAV-->

	<!-- UItoTop plugin -->
	<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css" />
	<script src="js/easing.js" type="text/javascript"></script>
	<script src="js/jquery.ui.totop.js" type="text/javascript"></script>    
	<script type="text/javascript">
		$(document).ready(function() {        
			$().UItoTop({ easingType: 'easeOutQuart' });        
		});
	</script>
	<style type="text/css">
		.container_wrap{ height: 380px;width: 100%; border: 1px solid#aa9e5f;display: flex;justify-content: center;align-items: center;}
	</style>

</head>

<body>
<div class="wrapper">

<div class="header">
						<div class="head_main">
							<div class="logo_setup">
								<div class="logo"><a href="#"><img src="https://registration.gjepc.org/images/iijslogo-2020.png" title="GJEPC"/ class="logo_img" style="width: 100px;"></a></div>
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
$show ="vbsm";
$year = 2020;
$orderId=$_SESSION['orderId'];
$post_date=date('Y-m-d');


	if(isset($registration_id) && $registration_id!="")
	{
		$orderUpdate ="update visitor_order_detail set payment_status='Y' where orderId='$orderId' AND regId='$registration_id'AND paymentThrough='link' ";
		$getResult = $conn->query($orderUpdate);
		if(!$getResult) { die($conn->error); }
		$ssx = "SELECT * FROM `visitor_order_temp` WHERE `registration_id`='$registration_id' AND `show`='$show' AND `year`='$year' AND paymentThrough='link' ";
		$query_result=$conn->query($ssx);
		while($result1=$query_result->fetch_assoc())
		{ //echo '<pre>'; print_r($result1);
			$visitor_id = $result1['visitor_id'];
			$payment_made_for = $result1['payment_made_for'];		
			$amount = $result1['amount'];
			$show = $result1['show'];
			$year = $result1['year'];
		
		$sqlx1 = "INSERT INTO `visitor_order_history`(`create_date`, `registration_id`,`orderId`, `visitor_id`, `payment_made_for`, `amount`,`show`, `year`,`payment_status`, `status`,`paymentThrough`) VALUES (NOW(),'$registration_id','$orderId','$visitor_id','$payment_made_for','$amount','$show','$year','Y','1','link')";
		$result = $conn->query($sqlx1);
		if($result){
		 $updatx = "DELETE FROM `visitor_order_temp` WHERE `registration_id`='$registration_id' AND `visitor_id` ='$visitor_id' AND `show`='$show' AND `year`='$year' AND paymentThrough='link'"; 
		$resultx = $conn->query($updatx);

		/* Send SMS to Visitors Start */
	//	$messagev = "Thank you for registration at Virtual IIJS SHOW. Your Registration Number is $visitor_id for ORDER ID $orderId. Your badge will be dispatched shortly.";
		$messagev = "Thank you for registration at IIJS Virtual Show 2020.We will send you login & password shortly on your registered email/ mobile to visit IIJS Virtual show 2020. For more details please visit https://gjepc.org/iijs-virtual/ We look forward to welcoming you at IIJS Virtual Show 2020";
		get_data($messagev,$visitorMobile); 	
		
	//	$messageo = "Thank you for registration at Virtual IIJS SHOW. Your ORDER ID for Visitor registration is $orderId.Your badge will be dispatched shortly.";
		$messageo = "Thank you for registration at IIJS Virtual Show 2020.We will send you login & password shortly on your registered email/ mobile to visit IIJS Virtual show 2020. For more details please visit https://gjepc.org/iijs-virtual/ We look forward to welcoming you at IIJS Virtual Show 2020";
		get_data($messageo,$ownerMobile); 		
		/* Send SMS to Visitors Ends */	
		
		/*Send Email Receipt to Company */ 
		$message ='<table class="table2" width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">	
    <tbody>    
    	<tr>
            <td align="left"><img id="ri" src="https://gjepc.org/assets/images/logo.png">
            <td align="center"> <img id="mi"> </td>
            <td align="right"><img id="ri" src="https://gjepc.org/emailer_gjepc/04.09.2020/iijs_virtual_white.jpg"></td>
            </td>                        
		</tr>
            
        <tr><td colspan="3" height="30"><hr></td></tr>        
        <tr>           
        	<td colspan="3" id="content">
				<p>Dear '.$visitorName.'</p>
				<p> Thank you for registering at IIJS Virtual Show 2020. Your registration is completed.</p>
				<p> Login and password will be sent shortly on your registered email / mobile to visit the show.</p>
				<p> You can also check more details on https://gjepc.org/iijs-virtual/</p>
                
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
		
		$to =$email;
		$subject = "Thank you for registering to visit IIJS Virtual Show 2020."; 
		$headers  = 'MIME-Version: 1.0' . "\n"; 
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		$headers .= 'From: IIJS Virtual Show 2020 <admin@gjepc.org>';			
		mail($to, $subject, $message, $headers);
		/*  Email End */
		
		//	header("Refresh: 2; url=https://registration.gjepc.org/direct_link_payment_thankyou.php");
		/*session_unset($_SESSION);exit;*/
		}		
		}
		?>
		<div class="container_wrap">
		<div class="container" id="manualFormContainer">
		<h1 style="color:green;text-align: center;">Successful Registration</h1>
		<div id="formWrapper">
		<p style="text-align: center;">Thank you for registering to visit IIJS Virtual Show 2020.</p>
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
  </div>

<div class="clear"></div>

<?php include ('footer.php'); ?>

</div>
<!--footer ends-->
</body>
</html>