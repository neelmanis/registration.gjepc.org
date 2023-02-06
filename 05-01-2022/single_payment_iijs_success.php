<?php include('header_include.php');
if(!isset($_SESSION['registration_id'])){ header("location:single_visitor.php");	exit; }
if(!isset($_SESSION['isFree']) && $_SESSION['isFree']!="yes"){ header("location:single_visitor.php");	exit; }

$registration_id = $_SESSION['registration_id'];
$visitor_id = $_SESSION['visitor_id'];
$email = getVisitorEmail($visitor_id,$conn); 
$CompanyName = getCompanyName($registration_id,$conn); 
$visitorName = getVisitorName($visitor_id,$conn); 
$visitorMobile = getVisitorMobile($visitor_id,$conn);
$visitorPAN = getVisitorPAN($visitor_id,$conn);
$ownerMobile = getOwnerVisitorMobile($registration_id,$conn);
$visitoSecondaryMobile = getVisitorSecondaryMobile($visitor_id,$conn);

$sql_event = "SELECT * FROM `visitor_event_master` WHERE `status` ='1' AND `shortcode` = '".$_SESSION['show']."'";
$result_event = $conn->query($sql_event);
$count_event = $result_event->num_rows;
if($count_event > 0){
   $row_event = $result_event->fetch_assoc();
   $shortcode = $row_event['shortcode'];
   $year = $row_event['year'];
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
<title>Welcome to IIJS</title>
<link rel="shortcut icon" href="images/fav.png" />
	<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
	<link rel="stylesheet" type="text/css" href="css/general.css" />
	<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />
	 
	<link rel="stylesheet" type="text/css" href="css/responsive.css" />
	<link rel="stylesheet" type="text/css" href="css/media_query.css" />
	<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox.min.js?v=<?php echo $version;?>"></script>
	<!--NAV-->
	<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="js/jquery.flexnav.js" type="text/javascript"></script>
	<script src="js/common.js"></script> 
	<!--NAV-->
	 <script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>

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
		.container_wrap{  border: 1px solid#aa9e5f;}
		.error{color:red;}
	</style>

</head>

<body>
<div class="wrapper">

<div class="header">
	<?php include('header1.php'); ?>
</div>
<!--container starts-->

<?php
$show =$_SESSION['show'];
$year = $_SESSION['year'];

$orderId=$_SESSION['orderId'];
$post_date=date('Y-m-d');

	if(isset($registration_id) && $registration_id!="" )
	{
		
		$orderUpdate ="update visitor_order_detail set payment_status='Y' where orderId='$orderId' AND regId='$registration_id' AND paymentThrough='single' ";
		$getResult = $conn->query($orderUpdate);
		if(!$getResult) { die($conn->error); }
		$ssx = "SELECT * FROM `visitor_order_temp` WHERE `registration_id`='$registration_id' AND `show`='$show' AND `year`='$year' AND paymentThrough='single' AND orderId='$orderId'";
		$query_result=$conn->query($ssx);
		while($result1=$query_result->fetch_assoc())
		{ //echo '<pre>'; print_r($result1);
			$visitor_id = $result1['visitor_id'];
			$payment_made_for = $result1['payment_made_for'];		
			$amount = $result1['amount'];
			$show = $result1['show'];
			$year = $result1['year'];
		
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
						
		$checkGlobalRecord = "SELECT * FROM globalExhibition WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `pan_no`='$visitorPAN' AND participant_Type='VIS' AND `event`='$shortcode'";
		$globalResult = $conn->query($checkGlobalRecord);
        $checkGlobalCount = $globalResult->num_rows;
	    if($checkGlobalCount>0){
		 $updateGlobal = "UPDATE globalExhibition  SET `uniqueIdentifier`='$uniqueIdentifier',`fname`='$name',`mobile`='$visitorMobile',`secondary_mobile`='$visitoSecondaryMobile',`isSecondary`='$isSecondary',`designation`='$visitorDesignation',`company`='$company_name',`photo_url`='$photo_url',`covid_report_status`='pending',`status`='P' WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `pan_no`='$visitorPAN' AND participant_Type='VIS' AND `event`='$shortcode' ";
		$updateGlobalResult = $conn->query($updateGlobal);	
		} else { 
		$insertGlobal = "INSERT INTO globalExhibition  SET `uniqueIdentifier`='$uniqueIdentifier',`registration_id`='$registration_id',`visitor_id`='$visitor_id',`fname`='$name',`mobile`='$visitorMobile',`secondary_mobile`='$visitoSecondaryMobile',`isSecondary`='$isSecondary',`pan_no`='$visitorPAN',`designation`='$visitorDesignation',`company`='$company_name',`photo_url`='$photo_url',`participant_type`='VIS',`covid_report_status`='pending',`status`='P',`event`='$shortcode'";
		$insertGlobalResult = $conn->query($insertGlobal);
		
		/*Start to check last year vaccination status */		
		$modified_at = date("Y-m-d H:i:s");
		$checkData = "SELECT * FROM visitor_lab_info WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'" ;
		$resultData =$conn->query($checkData);
		$countData =  $resultData->num_rows;
		$rowx = $resultData->fetch_assoc();
		$certificate = $rowx['certificate'];
		
		$dose2_status = $rowx['dose2_status'];
		$booster_dose_status = $rowx['booster_dose_status'];
		if($dose2_status =="Y" ||  $booster_dose_status =="Y"){
		  $approval_status = "Y";
		}else{
		  $approval_status = "N";
		}
		
		$dose2_status = $rowx['dose2_status'];
		$booster_dose_status = $rowx['booster_dose_status'];
		
			if($countData > 0){
			if($certificate =='dose2'){
				$updateCovidStatus = "UPDATE globalExhibition SET `status`='$approval_status',`certificate`='$certificate',`dose2_status`='$dose2_status',`modified_date`='$modified_at' WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `participant_Type`='VIS' AND `event`='$shortcode' ";
				$resultStatusUpdate = $conn->query($updateCovidStatus);
			
			}else if($certificate =='booster_dose'){
				$updateCovidStatus = "UPDATE globalExhibition SET `status`='$approval_status',`certificate`='$certificate',`booster_dose_status`='$booster_dose_status',`modified_date`='$modified_at' WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `participant_Type`='VIS' AND `event`='$shortcode' ";
			}
			
		}else{
			$updateCovidStatus = "UPDATE globalExhibition SET `status`='P',`certificate`='',`dose2_status`='P',`modified_date`='$modified_at' WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `participant_Type`='VIS' AND `event`='$shortcode' ";
		}
		
		}
		/*Global Table End */
		
		$sqlx1 = "INSERT INTO `visitor_order_history`(`create_date`, `registration_id`,`orderId`, `visitor_id`, `payment_made_for`, `amount`,`show`, `year`,`payment_status`, `status`,`paymentThrough`) VALUES (NOW(),'$registration_id','$orderId','$visitor_id','$payment_made_for','$amount','$show','$year','Y','1','single')";
		$result = $conn->query($sqlx1);
		if($result){
		 $updatx = "DELETE FROM `visitor_order_temp` WHERE `registration_id`='$registration_id' AND `visitor_id` ='$visitor_id' AND `show`='$show' AND `year`='$year' AND paymentThrough='single'"; 
		$resultx = $conn->query($updatx);

		/* Send SMS to Visitors Start */
		// $badgeDate = date("d-m-Y",strtotime($badge_date));
		// $messagev = "Thank you for registering for $event_name.Your Unique ID number is $clnt_txn_ref. Generate your E-Badge from GJEPC App from $badgeDate onwards. Please note your E Badge will be only generated after approval of vaccination certificate. 2 dose of vaccines is compulsory to visit the show. Team GJEPC";
		if($isSecondary=='Y'){
			
			//send_sms($messagev,$visitoSecondaryMobile);
		}else{
		
			//send_sms($messagev,$visitorMobile);
		}
		
		
		/* First optin API After that Msg API */
	/*	$visitorMobiles = $visitorMobile;
		$apiurl = sendOPTIN($visitorMobiles);
		$getResult = json_decode($apiurl,true);
		if($getResult['response']['status']=="success")
		{
			foreach($getResult['data'] as $value)
			{
				$code = $value[0]['id'];
				$msg  = $value[0]['details'];
				$phone = $value[0]['phone'];
				
				$msgurl = visitor_covid_payment_success($visitorMobiles,$orderId);
				$getResults = json_decode($msgurl,true);
				if($getResults['response']['status']=="success")
				{
					//echo $getResults['response']['status'];
				} else { 
					//echo $getResults['response']['details'];
				}		
			}
		} else { 
			echo $getResult['response']['details'];
		} */
		
		
		if($_SESSION['visitor_id']=="Y"){
		/* Send SMS to Visitors Secondary Mobile */
		$messagev = "Thank you for registration at IIJS SIGNATURE Show.We request you to visit https://gjepc.org/iijs-premiere/ and login with your registered mobile number.";
	//	get_data($messagev,$visitoSecondaryMobile);
		}
		
		/*Send Email Receipt to Company */
		$message ='<table class="table2" width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">	
    <tbody>    
    	<tr>
            <td align="left"><img id="ri" src="https://gjepc.org/assets/images/logo.png"> </td>
            <td align="center"> <img id="mi"> </td>
                  <td align="right"><img id="ri" src="https://registration.gjepc.org/images/logo/'.$logo.'"></td> 
                                   
		</tr>
        <tr>
            <td align="center" colspan="3">
                <p style="line-height:25px;">
                    <h3 style="margin: 5px;">THE GEM JEWELLERY EXPORT PROMOTION COUNCIL</h3>
                    <b>GJEPC-H.O.-MUMBAI:1st Flr, Tower A,G Block, BDB, Bandra-Kurla Complex, Bandra(E)-400 051</b><br>
                    <b>GJEPC-E.X.-MUMBAI:G2-A, Trade Center, Bandra-Kurla Complex, Bandra(E)-400 051</b><br>
					<b>Toll Free Number :</b> 1800-103-4353, <b>Missed Call Number :</b> +91-7208048100<br>Website: '.$website.' Email: visitors@gjepcindia.com</p>
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
                    <td width="75%">0</td>
                </tr>
				<tr>
                    <td width="20%">Events: </td>
                    <td width="75%">'.$event_name.'</td>
                </tr>				
				<tr>
                 <td width="100%" colspan="2">
                    <p style="text-align: left; width: 100%; padding-top: 10px; margin: 0;">
                 <strong>We thank you for your visitor registration for '.$event_name.'.  
					Please download GJEPC app to get the E-Badge of the show. All the visitors visiting the exhibition should be fully vaccinated. Please Upload Your Vaccination Certificate. 
					<br/>For further assistance you may please feel free to contact us on 1800-103-4353 / OR give us missed call on +91-7208048100; or write to us on visitors@gjepcindia.com.</strong></p>				
                </td>
				</tr>
                <tr>
                <td width="100%" colspan="2">
                    <h4 style="text-align: center; width: 100%; padding-top: 30px; margin: 0;">This is a computer generated receipt requires no signature. Invoice as per GST Format would be dispatched separately.</h4>
                </td>
				</tr>
				<tr>
                <td width="100%" colspan="2">
                    <p>
            <strong>Disclaimer:</strong> <span style="font-size: 10px">This information contained in this circular are provided for the purpose of making application for the participation and visiting '.$event_name.' (the show). Please note that the Council reserves all the rights to postpone or cancel the show completely or partially without any prior intimation, subject to the changes in the Govt. rules and regulations and any such changes thereof for organising the show. In case of any delay or failure to organise the show which is caused by matters beyond reasonable control of the Council including, but not limited to the force majeure events, the Council shall not accept any responsibility or indemnity, whatsoever, and under no circumstance shall the Council have any liability to participants and visitors for any loss or damage of any kind incurred as a result of the postponement or cancellation of the show.</span> 
           </p>
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
		$subject = "Thank you for registering at ".$event_name." SHOW"; 
		$cc = "";
		$email_array = explode(",",$to);
		
		send_mailArray($email_array,$subject,$message,$cc);
		
	/*	$to =$email.',visitors@gjepcindia.com';
		$subject = "Thank you for registering at IIJS SIGNATURE 2022 SHOW"; 
		$headers  = 'MIME-Version: 1.0' . "\n"; 
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		$headers .= 'From: IIJS SIGNATURE 2022 SHOW <admin@gjepc.org>';			
		mail($to, $subject, $message, $headers);
		*/
		/*  Email End */
		//header("Refresh: 30; url=https://registration.gjepc.org/single_visitor.php");
		//unset($_SESSION['registration_id']);
		}		
		}

		unset($_SESSION['orderId']);	
		?>

	<?php
	} else	{
		echo "<script type='text/javascript'> alert('Your session has been expired');
		window.location.href='https://registration.gjepc.org/login.php';
		</script>";
		return;	exit;
	}
	?>
	<div class="container mt-5">
		<div class="row">
				<div class="col-12">
	             <h3 class="text-center font-weight-bold text-success">Registration Successful </h3>
	             <p class="mt-3 text-center">Thank you for your Visitor Registration in <?php echo $event_name; ?> SHOW.</p>
				</div>
		</div>
	</div>
	<?php include("include_vaccine_upload.php");?>
</div>
<?php include ('footer.php'); ?>
</body>
</html>