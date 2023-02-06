<?php include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit; }
$registration_id = $_SESSION['USERID'];
$email = $_SESSION['EMAILID'];
$ownerMobile = getOwnerVisitorMobile($_SESSION['USERID'],$conn);

date_default_timezone_set('Asia/Kolkata');
$sql_event = "SELECT * FROM `visitor_event_master` WHERE `status` ='1' AND `shortcode` = '".$_SESSION['show']."'";
$result_event = $conn->query($sql_event);
$count_event = $result_event->num_rows;
if($count_event > 0){
   $row_event = $result_event->fetch_assoc();
  $shortcode = $row_event['shortcode'];
   $year =      $row_event['year'];
   $event_name = $row_event['event_name'];
   $badge_date = $row_event['badge_date'];
   $logo = $row_event['logo'];
   $website = $row_event['website'];

}else{
	exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to GJEPC</title>
<link rel="shortcut icon" href="images/fav.png" />
	<link rel="stylesheet" type="text/css" href="css/mystyle.css?v=<?php echo $version;?>" />
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

</head>

<body>
<div class="wrapper">

<div class="header">
	<?php include('header1.php'); ?>
</div>
<!--container starts-->
<div class="inner_container">
  <div class="container">
    <div class="container_leftn">
<?php
$show = $shortcode;
$year = $year;
$orderId = $_SESSION['orderId'];
$post_date=date('Y-m-d');

	if(isset($registration_id) && $registration_id!="")
	{
		$orderUpdate ="update visitor_order_detail set payment_status='Y' where orderId='$orderId' AND regId='$registration_id' AND paymentThrough='online'";
		$getResult = $conn->query($orderUpdate);
		if(!$getResult) { die('Error: ' . $conn->error); }
		
		$ssx = "SELECT * FROM `visitor_order_temp` WHERE `registration_id`='$registration_id' AND `show`='$show' AND `year`='$year' AND paymentThrough='online'";
		$query_result=$conn->query($ssx);
		while($result1=$query_result->fetch_assoc())
		{ //echo '<pre>'; print_r($result1);
			$visitor_id = $result1['visitor_id'];
			$payment_made_for = $result1['payment_made_for'];		
			$amount = $result1['amount'];
			$show = $result1['show'];
			$year = $result1['year'];
			$visitorMobile = getVisitorMobile($visitor_id,$conn);
		
		$sqlx1 = "INSERT INTO `visitor_order_history`(`create_date`, `registration_id`,`orderId`, `visitor_id`, `payment_made_for`, `amount`,`show`, `year`,`payment_status`, `status`, `paymentThrough`) VALUES (NOW(),'$registration_id','$orderId','$visitor_id','$payment_made_for','$amount','$show','$year','Y','1','online')";
		$result = $conn->query($sqlx1);
		if($result){

	    /*Global Table Start */
		
		$name = getVisitorName($visitor_id,$conn);
		$visitorPAN = getVisitorPAN($visitor_id,$conn);
		$visitorMobile = getVisitorMobile($visitor_id,$conn);
		$designation = getVisitorDesignation($visitor_id,$conn);
		$visitorDesignation =  getVisitorDesignationID($designation,$conn); 
		$visitorPhoto =  getVisitorPhoto($visitor_id,$conn); 		 
		$photo_url = "https://registration.gjepc.org/images/employee_directory/".$registration_id."/photo/".$visitorPhoto;
		
		$getCompany_name = trim(getCompanyName($registration_id,$conn));
		$company_name = str_replace('&amp;', '&', $getCompany_name);
  	    $isSecondary = getVisitorSecondaryMobileStatus($visitor_id,$conn);
		$digits = 9;	
	    $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
	    $checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");
	    $countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
		while($countUniqueIdentifier > 0) {
		$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		} 
						
		$checkGlobalRecord = "SELECT * FROM globalExhibition WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `pan_no`='$visitorPAN' AND participant_Type='IGJME' AND `event`='$shortcode'";
		$globalResult = $conn->query($checkGlobalRecord);
        $checkGlobalCount = $globalResult->num_rows;
	    if($checkGlobalCount>0){
		$updateGlobal = "UPDATE globalExhibition  SET `uniqueIdentifier`='$uniqueIdentifier',`fname`='$name',`mobile`='$visitorMobile',`secondary_mobile`='$visitoSecondaryMobile',`isSecondary`='$isSecondary',`designation`='$visitorDesignation',`company`='$company_name',`photo_url`='$photo_url',`covid_report_status`='pending',`status`='P' WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `pan_no`='$visitorPAN' AND participant_Type='IGJME' AND `event`='$shortcode'";
			$updateGlobalResult = $conn->query($updateGlobal);
		} else { 
		$insertGlobal = "INSERT INTO globalExhibition  SET `uniqueIdentifier`='$uniqueIdentifier',`registration_id`='$registration_id',`visitor_id`='$visitor_id',`fname`='$name',`mobile`='$visitorMobile',`secondary_mobile`='$visitoSecondaryMobile',`isSecondary`='$isSecondary',`pan_no`='$visitorPAN',`designation`='$visitorDesignation',`company`='$company_name',`photo_url`='$photo_url',`participant_type`='IGJME',`covid_report_status`='pending',`status`='P',`event`='$shortcode'";
			$insertGlobalResult = $conn->query($insertGlobal);
		}
		
		/*Global Table End */
		
		$updatx = "DELETE FROM `visitor_order_temp` WHERE `registration_id`='$registration_id' AND `visitor_id` ='$visitor_id' AND `show`='$show' AND `year`='$year'AND paymentThrough='online'";
		$resultx = $conn->query($updatx);		
		
		/* Send SMS to Visitors Start */
		//$messagev = "Thank you for registration at IIJS Virtual Show 2020. Your Registration Number is $visitor_id for ORDER ID $orderId. Your badge will be dispatched shortly.";
	//	get_data($messagev,$visitorMobile); 	
		
		//$messageo = "Thank you for registration at IIJS Virtual Show 2020. Your ORDER ID for Visitor registration is $orderId.Your badge will be dispatched shortly.";
	//	get_data($messageo,$ownerMobile); 	
		$badgeDate = date("d-m-Y",strtotime($badge_date));
		$messagev = "Thank you for registering for $event_name.Your Unique ID number is $orderId. Generate your E-Badge from GJEPC App from $badgeDate onwards. Please note your E Badge will be only generated after approval of vaccination certificate. 2 dose of vaccines is compulsory to visit the show. Team GJEPC";
	//	send_sms($messagev,$visitorMobile);	
		/* Send SMS to Visitors Stop */			
		
		/*Send Email Receipt to Company */

		$message ='<table class="table2" width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">	
    <tbody>    
    	<tr>
            <td align="left"><img id="ri" src="https://registration.gjepc.org/images/logo.png"></td>
            <td align="center"> <img id="mi"> </td>
            <td align="right"></td>                        
		</tr>
        <tr>
            <td align="center" colspan="3">
                <p style="line-height:25px;">
                    <h3 style="margin: 5px;">THE GEM JEWELLERY EXPORT PROMOTION COUNCIL</h3>
                    <b>D2B, D-Tower, West Core Wing, Bharat Dimaond Bourse, Bandra Kurla Complex, Bandra (E) - 400 051</b><br>
					<b>Toll Free Number :</b> 1800-103-4353, <b>Missed Call Number :</b> +91-7208048100<br>Website: https://gjepc.org Email: visitors@gjepcindia.com</p>
            </td>
        </tr>         
        <tr><td colspan="3" height="30"><hr></td></tr>        
        <tr>           
        	<td colspan="3" id="content">
            	<table class="table1"width="100%" style="font-family:Arial, sans-serif; color:#333333; font-size:13px;">
                <tr>
                <td style="padding:0 10px;" align="left">Order ID: '.$orderId.' </td>
                <td style="padding:0 60px;" align="right">Date: '.date("d-m-y").'</td>
                </tr>                    
                </table>

                <table class="table2"width="100%" style="font-family:Arial, sans-serif; color:#333333; font-size:13px;" cellpadding="10">
                <tr>
                    <td width="20%">Received with Thanks From M/s: </td>
                    <td width="75%">'.$CompanyName.'</td>
                </tr>
                <tr>
                    <td width="20%">Rupees: </td>
                    <td width="75%">Free</td>
                </tr>
				<tr>
                    <td width="20%">Events: </td>
                    <td width="75%">'.$event_name.'</td>
                </tr>				
				<tr>
                 <td width="100%" colspan="2">
                    <p style="text-align: left; width: 100%; padding-top: 10px; margin: 0;">
                 Thank you for registering for IIJS MACHINERY SECTION 2022.Your Unique ID number is '.$orderId.'. Generate and print your Paper-Badge from 15th July onwards. Please note your Badge will be only generated to get printed after approval of vaccination certificate. TWO dose of vaccines is compulsory to visit the show. To upload the vaccine kindly click on https://registration.gjepc.org/single_visitor.php ; please ignore if your already uploaded earlier.</p>	
                  <p style="text-align: left; width: 100%; padding-top: 10px; margin: 0;">Team GJEPC</p>						
                </td>
				</tr>
                <tr>
                <td width="100%" colspan="2">
                    <h4 style="text-align: center; width: 100%; padding-top: 30px; margin: 0;">This is a computer generated receipt requires no signature. Invoice as per GST Format would be dispatched seperately. </h4>
                </td>
            </tr>
            </table>
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
		
		$to = $email;
		//$to ="santosh@kwebmaker.com";
		$subject = "Thank you for registering at ".$event_name."";
		$cc = "";
		$email_array = explode(",",$to);
		send_mailArray($email_array,$subject,$message,$cc);
	
		/*  Email End */
		
		header("Refresh: 2; url=https://registration.gjepc.org/my_dashboard.php");
		} else { echo "<script type='text/javascript'> alert('Invalid Response');
				window.location.href='visitor_registration.php';
				</script>";
				return;	exit; }	
		}
		?>
		<div class="container_wrap">
		<div class="container" id="manualFormContainer">
		<h1 style="color:green;">SUCCESSFUL</h1>
		<div id="formWrapper">
		<p>Thank you for your participation in <?php echo $event_name;?> Show.</p>
		</div>
		<div class="clear"></div>
		</div>
		</div>
	<?php	
	} else	{
		echo "<script type='text/javascript'> alert('Your session has been expired');
		window.location.href='https://registration.gjepc.org/employee_directory.php';
		</script>";
		return;	exit;
	}
	?>
 </div>
    </div>
  </div>

<div class="clear"></div>
<div class="footer_wrap">
<?php include ('footer.php'); ?>
</div>
</div>
<!--footer ends-->
</body>
</html>