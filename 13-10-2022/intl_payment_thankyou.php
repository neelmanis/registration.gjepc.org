<?php include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit; }
$uid = $_SESSION['USERID'];
?>
<script>
	$(document).ready(function(){
		$(document).load(function(){
			localStorage.clear();
		});
	});
</script>
<?php
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
<?php
$payment_type = "online";
$post_date = date('Y-m-d');

if(isset($_POST['agree']) && $_POST['agree'] == 'YES'){   $agree = "YES"; } else {  $agree = "NO"; }
//print_r($_POST);exit;
	if(isset($uid) && $uid!=""){
	$ssx = "SELECT * FROM `ivr_registration_order_temp` WHERE `registration_id`='$uid' AND visitor_id!='0' AND paymentThrough='online'";
	$query_result=$conn->query($ssx);
	$count_v=$query_result->num_rows;
	if($count_v==0)
	{
		echo "<script type='text/javascript'> alert('Please Add Visitors');
		window.location.href='intl_visitor_registration.php';
		</script>";
		return;	exit;
	} else {
		$row_temp =  $query_result->fetch_assoc();
		$show = $_SESSION['show']  = $row_temp['show'];
		$year = $_SESSION['year']  = $row_temp['year'];
		$order_prefix = getVisOrderPrefix($show,$conn);
		$isFree = checkVisEventIsFree($show,$conn);
	}
	}
	/*
	$amount = convert_uudecode($_POST['amount']);
	$gst_amount   = convert_uudecode($_POST['gst_amount']);
	$total_payable  = convert_uudecode($_POST['total_payable']); */
	
	$amount = base64_decode($_POST['amount']);
	$gst_amount   = base64_decode($_POST['gst_amount']);
	$total_payable  = base64_decode($_POST['total_payable']); 
	
	/*if(!is_numeric($total_payable) || !is_numeric($uid)){
	echo '<script type="text/javascript">'; 
	echo 'alert("There is something went wrong..!! Kindly check with Admin");'; 
	echo 'window.location.href = "intl_visitor_registration.php"';
	echo '</script>';	
	exit;
	}*/

	/* Check session_id and Amount start*/
	if(isset($uid) && $uid!="")
	{		
		$ssx = "SELECT * FROM `ivr_registration_order_temp` WHERE `registration_id`='$uid' AND `show`='$show' AND `year`='$year' AND paymentThrough='online'";
		$query_result=$conn->query($ssx);
		while($result1=$query_result->fetch_assoc())
		{ //echo '<pre>'; print_r($result1);
			$visitor_id = $result1['visitor_id'];
			$payment_made_for = $result1['payment_made_for'];		
			$amount = $result1['amount'];
			$show = $result1['show'];
			$year = $result1['year'];
		
		$sqlx1 = "INSERT INTO `ivr_registration_history` set `registration_id`='$uid',`visitor_id`='$visitor_id',`payment_made_for`= '$payment_made_for', `amount`='0',`show`='$show',`year`='$year', `payment_status`='Y', `paymentThrough`='online', `status`='1'";
		$result = $conn->query($sqlx1);
		if($result){

	    /*Global Table Start */
		
		$name = getINTLVisitorName($visitor_id,$conn);
		$visitorPAN = '';
		$visitorMobile = getINTLVisitorMobile($visitor_id,$conn); 
		$visitorDesignation =  getINTLVisitorDesignation($visitor_id,$conn); 
		$visitorPhoto =  getINTLVisitorPhoto($visitor_id,$conn); 		 
		$photo_url = "https://registration.gjepc.org/images/ivr_image/photograph/".$visitorPhoto;
		
		$getCompany_name = trim(getCompanyName($uid,$conn));
		$company_name = str_replace('&amp;', '&', $getCompany_name);
  	    $isSecondary = "N"; 
		$email =  getINTLVisitorEmail($visitor_id,$conn); 
		
		$digits = 9;	
	    $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
	    $checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");
	    $countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
		while($countUniqueIdentifier > 0) {
		$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		} 
						
		$checkGlobalRecord = "SELECT * FROM globalExhibition WHERE `registration_id`='$uid' AND `visitor_id`='$visitor_id' AND `email`='$email' AND participant_Type='INTL' AND `event`='$shortcode'";
		$globalResult = $conn->query($checkGlobalRecord);
        $checkGlobalCount = $globalResult->num_rows;
	    if($checkGlobalCount>0){
		$updateGlobal = "UPDATE globalExhibition  SET `uniqueIdentifier`='$uniqueIdentifier',`fname`='$name',`mobile`='$visitorMobile',`secondary_mobile`='',`isSecondary`='$isSecondary',`designation`='$visitorDesignation',`company`='$company_name',`photo_url`='$photo_url',`covid_report_status`='pending',`status`='P' WHERE `registration_id`='$uid' AND `visitor_id`='$visitor_id' AND `email`='$email' AND `participant_Type`='INTL' AND `event`='$shortcode'";
		$updateGlobalResult = $conn->query($updateGlobal);
		} else { 
		$insertGlobal = "INSERT INTO globalExhibition  SET `uniqueIdentifier`='$uniqueIdentifier',`registration_id`='$uid',`visitor_id`='$visitor_id',`fname`='$name',`mobile`='$visitorMobile',`email`='$email',`secondary_mobile`='',`isSecondary`='$isSecondary',`designation`='$visitorDesignation',`company`='$company_name',`photo_url`='$photo_url',`participant_type`='INTL',`covid_report_status`='pending',`status`='P',`event`='$shortcode'";
		$insertGlobalResult = $conn->query($insertGlobal);
		}
		
		/*Global Table End */
		
		$updatx = "DELETE FROM `ivr_registration_order_temp` WHERE `registration_id`='$uid' AND `visitor_id` ='$visitor_id' AND `show`='$show' AND `year`='$year' AND paymentThrough='online'";
		$resultx = $conn->query($updatx);		
		
		$badgeDate = date("d-m-Y",strtotime($badge_date));
		$messagev = "Thank you for registering for $event_name.Your Unique ID number is $orderId. Generate your E-Badge from GJEPC App from $badgeDate onwards. Please note your E Badge will be only generated after approval of vaccination certificate. 2 dose of vaccines is compulsory to visit the show. Team GJEPC";
	//	send_sms($messagev,$visitorMobile);	
		/* Send SMS to Visitors Stop */			
		
		/*Send Email Receipt to Company */
		$message ='<table class="table2" width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">	
    <tbody>    
    	<tr>
            <td align="left"><img id="ri" src="https://registration.gjepc.org/images/logo.png"> </td>  
            <td align="center"> <img id="mi"> </td>
            <td align="right"><img id="ri" src="https://registration.gjepc.org/images/logo/'.$logo.'"></td> 
                                 
		</tr>
        <tr>
            <td align="center" colspan="3">
                <p style="line-height:25px;">
                    <h3 style="margin: 5px;">THE GEM JEWELLERY EXPORT PROMOTION COUNCIL</h3>
                    <b>GJEPC-H.O.-MUMBAI:1st Flr, Tower A,G Block, BDB, Bandra-Kurla Complex, Bandra(E)-400 051</b><br>
                    <b>GJEPC-E.X.-MUMBAI:G2-A, Trade Center, Bandra-Kurla Complex, Bandra(E)-400 051</b><br>
					<b>Toll Free Number :</b> 1800-103-4353, <b>Missed Call Number :</b> +91-7208048100<br>Website: '.$website.'  Email: visitors@gjepcindia.com</p>
            </td>
        </tr>      
        <tr><td colspan="3" height="30"><hr></td></tr>        
        <tr>           
        	<td colspan="3" id="content">
            	<table class="table1"width="100%" style="font-family:Arial, sans-serif; color:#333333; font-size:13px;">
                <tr>
                <td style="padding:0 10px;" align="left"></td>
                <td style="padding:0 60px;" align="right">Date: '.date("d-m-y").'</td>
                </tr>                    
                </table>

                <table class="table2"width="100%" style="font-family:Arial, sans-serif; color:#333333; font-size:13px;" cellpadding="10">
                <tr>
                    <td width="20%">Received with Thanks From M/s: </td>
                    <td width="75%">'.$_SESSION['COMPANYNAME'].'</td>
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
                    <h4 style="text-align: center; width: 100%; padding-top: 30px; margin: 0;">This is a computer generated receipt requires no signature. Invoice as per GST Format would be dispatched separately. </h4>
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
		$to ="neelmani@kwebmaker.com";
		//	$to =$email.',pvr@gjepcindia.com';
		$subject = "Thank you for registering at ".$event_name." Show"; 
		$headers  = 'MIME-Version: 1.0' . "\n"; 
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		$headers .= 'From: '.$event_name.' Show<admin@gjepc.org>';			
		mail($to, $subject, $message, $headers);
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
	