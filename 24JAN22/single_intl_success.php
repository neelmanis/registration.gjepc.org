<?php include('header_include.php');
if(!isset($_SESSION['uid'])){ header("location:single_intl_registration.php");	exit; }
if(!isset($_SESSION['show']) && $_SESSION['show']==""){ header("location:single_intl_registration.php");	exit; }
$uid = $_SESSION['uid'];
$eid = $_SESSION['eid']; 
$email = $_SESSION['email']; 


//CHECK FOR  REGISTERED VISITOR
$sql_history = "SELECT * FROM ivr_registration_history WHERE visitor_id='$eid' AND registration_id='$uid' AND payment_made_for='".$_SESSION['show']."' AND payment_status='Y'";
$result_history = $conn->query($sql_history);
$count_history = $result_history->num_rows;
if($count_history == 0 ){
	header("location:single_intl_show_registration_test.php");	exit; 
}


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
<title>Welcome to <?php echo $event_name ; ?></title>
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
</head>

<body>
<div class="header"><?php include('header1.php'); ?></div>
<div class="wrapper my-5">
  
<!--container starts-->
	
<div class="container">
	
	<?php
		if(isset($uid) && $uid!="")
		{
			$fetch_data = "select * from ivr_registration_details where uid='$uid' AND eid='$eid'";	
			$result = $conn->query($fetch_data);
			if(!$result){
				die($conn->error);	
			}
			$data = $result->fetch_assoc();
            
            /*Global Table Start */
		
		$name = $data['first_name'].' '.$data['last_name'];
		$visitorPAN = '';
		$visitorMobile = $data['mob_no'];
		$designation = strtoupper($data['designation']);
		$visitorDesignation =  strtoupper($data['designation']);
		$visitorPhoto =  $data['photograph_fid']; 		 
		$photo_url = "https://registration.gjepc.org/images/employee_directory/".$uid."/photo/".$visitorPhoto;
		$getCompany_name = trim(getCompanyName($registration_id,$conn));
		$company_name = str_replace('&amp;', '&', $data['company_name']);
		$isSecondary = "N";
		$email = trim($data['email']);

		$digits = 9;	
	    $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
	    $checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");
	    $countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
		while($countUniqueIdentifier > 0) {
		$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		} 
						
		$checkGlobalRecord = "SELECT * FROM globalExhibition WHERE `registration_id`='$uid' AND `visitor_id`='$eid' AND `email`='$email' AND participant_Type='INTL' AND `event`='$shortcode'";
		$globalResult = $conn->query($checkGlobalRecord);
        $checkGlobalCount = $globalResult->num_rows;
	    if($checkGlobalCount>0){
		 $updateGlobal = "UPDATE globalExhibition  SET `uniqueIdentifier`='$uniqueIdentifier',`fname`='$name',`mobile`='$visitorMobile',
		 `secondary_mobile`='',`isSecondary`='$isSecondary',`designation`='$visitorDesignation',`company`='$company_name',`photo_url`='$photo_url',`covid_report_status`='pending' WHERE `registration_id`='$uid' AND `visitor_id`='$eid' AND `email`='$email' AND `participant_Type`='INTL' AND `event`='$shortcode' ";
		$updateGlobalResult = $conn->query($updateGlobal);	
		} else { 
		$insertGlobal = "INSERT INTO globalExhibition  SET `uniqueIdentifier`='$uniqueIdentifier',`registration_id`='$uid',`visitor_id`='$eid',`fname`='$name',`mobile`='$visitorMobile',`email`='$email',`isSecondary`='$isSecondary',`designation`='$visitorDesignation',`company`='$company_name',`photo_url`='$photo_url',`participant_type`='INTL',`covid_report_status`='pending',`status`='P',`event`='$shortcode'";
		$insertGlobalResult = $conn->query($insertGlobal);
		
		/*Start to check last year vaccination status */		
		$modified_at = date("Y-m-d H:i:s");
		$checkData = "SELECT * FROM visitor_lab_info WHERE registration_id='$uid' AND visitor_id='$eid'" ;
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
				$updateCovidStatus = "UPDATE globalExhibition SET `status`='$approval_status',`certificate`='$certificate',`dose2_status`='$dose2_status',`modified_date`='$modified_at' WHERE `registration_id`='$uid' AND `visitor_id`='$eid' AND `participant_Type`='INTL' AND `event`='$shortcode' ";
				$resultStatusUpdate = $conn->query($updateCovidStatus);
			
			}else if($certificate =='booster_dose'){
				$updateCovidStatus = "UPDATE globalExhibition SET `status`='$approval_status',`certificate`='$certificate',`booster_dose_status`='$booster_dose_status',`modified_date`='$modified_at' WHERE `registration_id`='$uid' AND `visitor_id`='$eid' AND `participant_Type`='INTL' AND `event`='$shortcode' ";
			}
			
		}else{
			$updateCovidStatus = "UPDATE globalExhibition SET `status`='P',`certificate`='',`dose2_status`='P',`modified_date`='$modified_at' WHERE `registration_id`='$uid' AND `visitor_id`='$eid' AND `participant_Type`='INTL' AND `event`='$shortcode' ";
		}
		
		}
		/*Global Table End */

			/*Send Email Receipt to Company */
			$message ='<table class="table2" width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">	
	   	 <tbody>    
	    	<tr>
            <td align="left"><img id="ri" src="https://gjepc.org/assets/images/logo.png"> </td>
            <td align="center"> <img id="mi"> </td>
                  <td align="right"><img id="ri" src="https://registration.gjepc.org/images/logo/'.$logo.'"></td> 
                                   
			</tr>
	            
	        <tr><td colspan="3" height="30"><hr></td></tr>        
	        <tr>           
	        	<td colspan="3" id="content">
					<p> Dear '.$data['title'].' '.$data['first_name'].' '.$data['last_name'].',</p>
					<p> Thank you for registering at '.$event_name.'. Your registration is completed.</p>
					<p> You can also check more details on '.$website.'</p>
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
			
		    $to ='santosh@kwebmaker.com';
			//$to = $data['email'];
			$subject = "Thank you for registering at ".$event_name." SHOW"; 
			$headers  = 'MIME-Version: 1.0' . "\n"; 
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
			$headers .= 'From: '.$event_name.' SHOW <admin@gjepc.org>';			
			mail($to, $subject, $message, $headers);
			/*  Email End */
			

			?>
			<div class="container  mb-4">
				<div id="manualFormContainer">
					<h1 style="color:green;text-align: center;font-weight: 900;">SUCCESSFUL</h1>
					<h2 style="text-align: center; font-size: 18px;" class="mb-4">Thank you for your participation in <?php echo $event_name; ?> SHOW</h2>
				</div>
				 <div class="card  ">
			    
			      <div class="card-body">
			        <?php include("include_intl_vaccine_upload.php");?>
			      </div>
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

<div class="footer">
	<?php include ('footer.php'); ?>
</div>

<!--footer ends-->
</body>
</html>