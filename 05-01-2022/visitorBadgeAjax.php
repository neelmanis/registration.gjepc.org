<?php
include ("db.inc.php");
include ("functions.php");
session_start();

$action = $_REQUEST['action'];
if($action == 'pan_number'){
	$pan_number = trim($_REQUEST['pan_no']);
	$sql =  "SELECT * FROM visitor_directory WHERE pan_no='$pan_number' order by visitor_approval limit 1";
	$result = $conn ->query($sql); 
	$count = $result->num_rows;
  
    $data = array();
	if($count>0) 
	{
		$row = $result->fetch_assoc(); 
		$company = strtoupper(str_replace('&amp;', '&', getCompanyName($row['registration_id'],$conn)));
		$mobile = trim($row['mobile']);
		$email = $row['email'];
		$designation = getVisitorDesignationID($row['designation'],$conn);
		$name = $row['name'];
		$lname = $row['lname'];
		$photo = $row['photo'];
		$reg_id = $row['registration_id'];
		$status = $row['visitor_approval'];
		$combo = $row['combo'];
		$visitorID = $row['visitor_id']; 
		$visitorID = $row['visitor_id']; 
		$face_isApplied = $row['face_isApplied']; 
		$face_status = $row['face_status']; 

		$sql_event = "SELECT * FROM `visitor_event_master` WHERE `status` ='1' ";
		$result_event = $conn->query($sql_event);
		$count_event = $result_event->num_rows;
		if($count_event > 0){
			   $row_event = $result_event->fetch_assoc();
			   $shortcode = $row_event['shortcode'];
			   $event_name = $row_event['event_name'];
			   $year = $row_event['year'];
		}

       
		$registration_id = intval(filter($row['registration_id']));
	  	$sqlExhibitor = "select * from exh_reg_payment_details where uid='$registration_id' AND  (`show`='IIJS SIGNATURE 2023' OR `show`='IGJME') AND allow_visitor='N' order by payment_id desc limit 0,1";
        $ansExhibitor = $conn ->query($sqlExhibitor);
        $rowExhibitor=$ansExhibitor->num_rows;
        if($rowExhibitor>0){
	    echo json_encode($data = array("status"=>'exhibitor')); exit;
        }

		$sqlData = "select * from registration_master where id='$registration_id' AND approval_status='D'";
        $ansData = $conn ->query($sqlData);
        $rowData=$ansData->num_rows;
        if($rowData>0){
			$_SESSION['registration_id'] = $row['registration_id']; 
	    echo json_encode($data = array("status"=>'companyData')); exit;
        }
		
		$newx = "SELECT * from visitor_directory where pan_no='$pan_number' AND visitor_approval='Y'";
		$query=$conn ->query($newx);
		$lettersinDB = array();
			while($rows = $query->fetch_assoc()){
			array_push($lettersinDB,array('visitor_id'=>$rows['visitor_id'],'name'=>$rows['name']));
		}		

		//$checkHistory = "SELECT * FROM `visitor_order_history` WHERE visitor_id='$visitorID' AND (payment_made_for='6show' OR payment_made_for='5show' OR payment_made_for='4show' OR payment_made_for='3show' OR payment_made_for='2show' OR payment_made_for='1show' OR payment_made_for='combo' OR payment_made_for='iijs21') AND `status`='1' AND payment_status='Y'";

		
		/*=================== PAYMENT CHECK AND STOP CODE ================================*/
		$checkHistory = "SELECT * FROM `visitor_order_history` WHERE visitor_id='$visitorID' AND (payment_made_for='combo23' OR payment_made_for='signature23' OR payment_made_for='igjme23' OR payment_made_for='stcombo23')  AND `status`='1' AND payment_status='Y'";
		$getQuery = $conn ->query($checkHistory);
		$checkResult = $getQuery->num_rows;

		$gotcommaid = array();
		while($checkQuery = $getQuery->fetch_assoc()){	
			array_push($gotcommaid,explode(",",$checkQuery['visitor_id']));
		}

		$finalvisitoridarray = array();
		foreach($gotcommaid as $k => $v){
			$finalvisitoridarray = array_merge($finalvisitoridarray,$v);
		}

		foreach($lettersinDB as $option_value)
		{ 							
			if(!in_array($option_value['visitor_id'], $finalvisitoridarray)) {
				$data = array("status"=>'warning', "message"=>"You are not registered for any show. <a href='https://registration.gjepc.org/single_visitor.php' class='link' target='_blank' > click here </a> to register.");
				echo json_encode($data); exit;
			}
		}


		/*=====CHECK FACIAL STATUS ==========*/

		// if($face_isApplied =="N"){
		// 		$data = array("status"=>'warning', "message"=>"Your face recognition photo is not updated please <a href='https://registration.gjepc.org/visitor_photo_update.php' class='link' target='_blank' > click here </a> to update the same.");
		// 		echo json_encode($data); exit;
		// }

		// if($face_status !="Y"){
		// 		$data = array("status"=>'warning', "message"=>"Your face recognition photo approval is pending.");
		// 		echo json_encode($data); exit;
		// }

		/*CHECK ENTRY IN GLOBAL*/
		 $sqlGlobal = "SELECT * FROM gjepclivedatabase.globalExhibition  WHERE visitor_id='$visitorID' AND  registration_id='$registration_id' AND (participant_Type ='VIS' OR participant_Type ='IGJME')";
		$resultGlobal = $conn->query($sqlGlobal);
		$rowGlobal = $resultGlobal->fetch_assoc();
		$countGlobal = $resultGlobal->num_rows;
    if($countGlobal == 0){
				$data = array("status"=>'warning', "message"=>"Your data not found for any show.");
				echo json_encode($data); exit;
    }else{
    	$globalStatus = $rowGlobal['status'] ;
    	$participant_Type = $rowGlobal['participant_Type'];
    	$_SESSION['participant_Type'] = $participant_Type ;
	    // if($globalStatus !="Y"){
	    // 		$data = array("status"=>'warning', "message"=>"Vaccine certificate approval is pending. ");
					// echo json_encode($data); exit;
	    // }
    }

		

		

		/*=================== PAYMENT CHECK AND STOP CODE ================================*/

        /*================= CHECK PAYMENT AND SHOW RESPONSE START==================*/
       
        $showHistory = "";
    
        /*================= CHECK PAYMENT AND SHOW RESPONSE END==================*/

		if($status =='Y'){
		     $_SESSION['registration_id'] = $row['registration_id']; 
			    $_SESSION['visitor_id'] = $row['visitor_id'];
       	  $data = array("status"=>'success',"company"=>$company, "mobile"=>$mobile,"email"=>$email,"name"=>$name,"lname"=>$lname,"photo"=>$photo,"reg_id"=>$reg_id,"visitor_id"=>$visitorID,"designation"=>$designation,"showHistory"=>$showHistory);
    
		}else if($status =='D'){
       $data = array("status"=>'warning', "message"=>"Your data is disapproved.");
       	echo json_encode($data); exit;
		}else if($status =='P'){
		$data = array("status"=>'pending');	
		}else if($status =='U'){
		$data = array("status"=>'updated');	
		}
		
	} else {
		$data = array("status"=>'notExist');
	}	
	echo json_encode($data);
}

if($action == 'send_otp'){
	$mobile_no = trim($_REQUEST['mobile_no']);
	$secondary_mobile = trim($_REQUEST['secondary_mobile']);
	$is_secondary = trim($_REQUEST['is_secondary']);
    $_SESSION['is_secondary'] = $is_secondary;
	$datetime = date("Y-m-d H:i:s");
	$visitor_id =$_SESSION['visitor_id'];
	$registration_id = $_SESSION['registration_id'];

	if(isset($is_secondary) && $is_secondary == 'Y'){   
		$mobile_no = trim($_REQUEST['secondary_mobile']);
	} else {  
		$mobile_no = trim($_REQUEST['mobile_no']);
	}
    $otp = rand(1000,9999); // generate OTP	
	$email = getVisitorEmail($visitor_id,$conn);

	//  $sql_check_event = "SELECT * FROM visitor_event_master WHERE `isParentShow`='1' AND `status`='1' ";
	// $result_check_event= $conn->query($sql_check_event);
 //    $count_check_event = $result_check_event->num_rows;
	// if($count_check_event > 0){
	// 	$row_check_event = $result_check_event->fetch_assoc();
	//     $event_name = $row_check_event['event_name'];
	//     $show = $row_check_event['shortcode'];
	// 	$year = $row_check_event['year'];
	// 	$logo = $row_check_event['logo'];
		
	// }else{
	// 	echo json_encode(array('status'=>'error'));exit; 
	// }
	$updateOtpGlobal = $conn->query("UPDATE globalExhibition SET otp='$otp',isVerified ='0' WHERE  visitor_id='$visitor_id' AND registration_id = '$registration_id' and (participant_Type='VIS' OR participant_Type='IGJME') ");


    $messageEmail ='<table cellpadding="10" width="100%" style="margin: 0px auto; font-family: Roboto; background-color: #fff; padding: 30px; border-collapse: collapse; border: 1px solid #000;">
		<tr>
		        <td colspan="3" style="background-color: #a89c5d; padding: 3px;"></td>
		    </tr>
			<tr>
            <td align="left"><img id="ri" src="https://registration.gjepc.org/images/logo.png">
            <td align="center"> <img id="mi"> </td>
            <td align="right"></td>
            </td>                        
		</tr>
		  <tr style="background-color:#eeee;padding:30px;">
		  <td colspan="3">One Time Password for Visitor Verification is <b>'.$otp.'</b> </td></tr>
		  <tr><td colspan="3"> <p> For Any Queries : </p><b>Email us on :</b> visitors@gjepcindia.com
		 </td></tr> 
		   <tr><td colspan="3">       
			  <p>Kind Regards,<br>
			  <b>GJEPC Web Team,</b>
			  </p>
			 
			</td>
		  </tr>
		  
		</table>';
	  
		 $to = $email;
		 $subject = "Verification code to verify your account"; 
		 $headers  = 'MIME-Version: 1.0' . "\r\n"; 
		 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
		 $headers .= 'From: IIJS SHOW REGISTRATION <admin@gjepc.org>';				
		 
	if(isset($is_secondary) && $is_secondary == 'Y'){
		
		if(filter($_REQUEST['secondary_mobile']) =="" && empty(filter($_REQUEST['secondary_mobile'])) ){

         $data = array("status"=>'secondaryEmpty');
         echo json_encode($data);exit;
		}
		$sqlb =  "SELECT secondary_mobile FROM visitor_directory WHERE (secondary_mobile = '".$_REQUEST['secondary_mobile']."' OR mobile = '".$_REQUEST['secondary_mobile']."')";
		$resultb = $conn->query($sqlb); 
		$countb = $resultb->num_rows;
		if($countb>0) 
		{
		 $data = array("status"=>'errorAlready');
		  
		} else {
       
		/* $message = "One Time Password for Visitor Verification is ".$otp.", Regards GJEPC";
		$otp_sendStatus = get_data($message,$mobile_no); //Send OTP on mobile */
		
		//$message = "One Time Password for Pan Number Verification is ".$otp." Regards GJEPC";
		  $message = "One Time Password for Visitor Verification is ".$otp." , Regards GJEPC";
		
		$otp_sendStatus = send_sms($message,$mobile_no);
		
		mail($to, $subject, $messageEmail, $headers); //Send OTP ON E-Mail
		if($otp_sendStatus){
			$updateOtpGlobal = $conn->query("UPDATE globalExhibition SET otp='$otp',isVerified ='0' WHERE  visitor_id='$visitor_id' AND registration_id = '$registration_id' and (participant_Type='VIS' OR participant_Type='IGJME') ");
       
			$getMobile = "SELECT mobile_no FROM visitor_mobileotpverification WHERE mobile_no='$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id'";
			  $getMobileResult = $conn->query($getMobile);
			  $countMobile = $getMobileResult->num_rows;
			 /*echo "INSERT INTO visitor_mobileotpverification SET mobile_no='$mobile_no',otp='$otp',verified ='0',post_date='$datetime'";exit;*/
			if($countMobile>0){

			$UpdateMobileOtp = $conn->query("UPDATE visitor_mobileotpverification SET otp='$otp',verified ='0',modifiedDate='$datetime',isSecondary='$is_secondary' WHERE mobile_no='$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id'");
		    } else {
			 
			$InsertMobileOtp = $conn->query("INSERT INTO visitor_mobileotpverification SET mobile_no='$mobile_no',otp='$otp',verified ='0',post_date='$datetime',registration_id='$registration_id',visitor_id='$visitor_id',isSecondary='$is_secondary'");
			}
			$data = array("status"=>'successOtp',"mobile_no"=>"$mobile_no");
		}
		}
	} else {
    $sql =  "SELECT mobile FROM visitor_directory WHERE mobile = '$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id' ";
	$result = $conn->query($sql); 
	$count = $result->num_rows;
    $data = array();
		if($count>0) 
		{
			/*$message = "One Time Password for Visitor Verification is ".$otp.", Regards GJEPC";
			$otp_sendStatus = get_data($message,$mobile_no); // Send OTP */
			//$message = "One Time Password for Pan Number Verification is ".$otp." Regards GJEPC";
			  $message = "One Time Password for Visitor Verification is ".$otp." , Regards GJEPC";
			$otp_sendStatus = send_sms($message,$mobile_no);
			mail($to, $subject, $messageEmail, $headers); //Send OTP ON E-Mail
			if($otp_sendStatus){
				$getMobile = "SELECT mobile_no FROM visitor_mobileotpverification WHERE mobile_no='$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id'";
				$getMobileResult = $conn->query($getMobile);
				$countMobile = $getMobileResult->num_rows;
				if($countMobile>0){
	          $UpdateMobileOtp = $conn->query("UPDATE visitor_mobileotpverification SET otp='$otp',verified ='0',modifiedDate='$datetime',isSecondary='$is_secondary' WHERE mobile_no='$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id'");
				}else{
				$InsertMobileOtp = $conn->query("INSERT INTO visitor_mobileotpverification SET mobile_no='$mobile_no',otp='$otp',verified ='0',post_date='$datetime',registration_id='$registration_id',visitor_id ='$visitor_id',isSecondary='$is_secondary'");
				}
				$data = array("status"=>'successOtp',"mobile_no"=>"$mobile_no");
			}
			
		} else {
			$data = array("status"=>'error');
		}
}
echo json_encode($data);
}

if($action == 'verifyOTP'){
	$visitor_id =$_SESSION['visitor_id'];
	$registration_id = $_SESSION['registration_id'];
	$otpNumber = trim($_REQUEST['otp_number']);

	$mobile_no_otp = trim($_REQUEST['mobile_no_otp']);

	$post_date = date("Y-m-d H:i:s");
    $sql  = "SELECT * FROM visitor_mobileotpverification WHERE otp='$otpNumber' AND mobile_no='$mobile_no_otp' AND visitor_id='$visitor_id' AND registration_id = '$registration_id'";
    $result = $conn->query($sql); 
    $count = $result->num_rows;
    if($count==1){
    $otpUpdate = "UPDATE visitor_mobileotpverification SET verified='1', modifiedDate='$post_date' WHERE otp='$otpNumber' AND mobile_no='$mobile_no_otp' AND visitor_id='$visitor_id' AND registration_id = '$registration_id' ";
    $otpUpdateResult = $conn->query($otpUpdate);
   if($_SESSION['is_secondary'] =="Y"){
    $updateSecondary =  $conn->query("UPDATE visitor_directory SET secondary_mobile='$mobile_no_otp',`isSecondary`='Y' WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'");
   }else{
   	$updateSecondary =  $conn->query("UPDATE visitor_directory SET secondary_mobile='',`isSecondary`='N' WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'");
   }
   $updateGlobal = "UPDATE gjepclivedatabase.globalExhibition SET isVerified='1' WHERE visitor_id='$visitorID' AND  registration_id='$registration_id' AND (participant_Type ='VIS' OR participant_Type ='IGJME') AND (  event='combo23' OR event='stcombo23' OR event='igjme23' OR event='signature23')";
   	$resultUpdateGlobal = $conn->query($updateGlobal);
    $_SESSION['isBadgeMobileVerified'] = "YES";
    $data = array("status"=>'success',"redirect"=>"vis_registration");

    }else{
    $data = array("status"=>'fail');
    }
    echo json_encode($data); 
}



if($action == 'singleVisitorRegistration')
{
	$registration_id = $_SESSION['registration_id'];
	if(empty($registration_id)){
	  header("location:single_visitor.php");
	}
	$visitor_id = trim($_POST['visitor_id']);
	$payment_made_for = $_POST['payment_made_for'];
	$amount = trim($_POST['participation_fee']);
 if($amount < 1000){
		echo json_encode(array("status"=>"error","message"=>"Please check registration amount and confirm."));exit;
 }
	$payment_type = "online";
	$post_date = date('Y-m-d');
	$type = "single";
	$delivery_id = filter($_POST['address_shipping']);
	$billing_delivery_id = filter($_POST['address_billing']);
	if(isset($_POST['agree']) && $_POST['agree'] == 'YES'){   $agree = "YES"; } else {  $agree = "NO"; }
	$type_of_member	= filter($_POST['type_of_member']);
	$chks = "select * from visitor_order_detail order by id desc limit 1";
	$chkResult = $conn->query($chks);
	$row = $chkResult->fetch_assoc();
	$num=$chkResult->num_rows;
	$strNo = rand(1,10000000);
	//CHECK FOR ALREADY REGISTERED VISITOR
	$sql_history = "SELECT * FROM visitor_order_history WHERE visitor_id='$visitor_id' AND registration_id='$registration_id' AND payment_made_for='$payment_made_for' AND payment_status='Y'";
	$result_history = $conn->query($sql_history);
	$count_history = $result_history->num_rows;

	if($count_history >0){
		echo json_encode(array("status"=>"error","message"=>"Payment is already done for this show"));exit;
	}


	// IF PAID FOR COMBO
	$checkComboPayment = checkEventPayment($visitor_id,$registration_id,"combo23",$conn);
	if($checkComboPayment == true){
			echo json_encode(array("status"=>"error","message"=>"Payment is already done for the all show"));exit;
	}

	//IF PAID FOR PREMIERE
	$checkIijsPayment = checkEventPayment($visitor_id,$registration_id,"iijs22",$conn);
	if($checkIijsPayment ==true && $payment_made_for=='combo23'){
			echo json_encode(array("status"=>"error","message"=>"Payment is already done for IIJS PREMIERE 2022 show. You can not apply for Combo show."));exit;
	}
    // IF PAID FOR SIGNATURE
	$checkSignaturePayment = checkEventPayment($visitor_id,$registration_id,"signature23",$conn);
	if($checkSignaturePayment ==true && $payment_made_for=='combo23'){
			echo json_encode(array("status"=>"error","message"=>"Payment is already done for IIJS SIGNATURE 2023 show. You can not apply for Combo show."));exit;
	}
	// IF PAID FOR TRITIYA
	$checkTritiyaPayment = checkEventPayment($visitor_id,$registration_id,"iijstritiya23",$conn);
	if($checkTritiyaPayment ==true && $payment_made_for=='combo23'){
			echo json_encode(array("status"=>"error","message"=>"Payment is already done for IIJS TRITIYA 2023 show. You can not apply for Combo show."));exit;
	} 

	$sql_check_event = "SELECT * FROM visitor_event_master WHERE `shortcode` = '$payment_made_for' AND `status`='1' ";
	$result_check_event= $conn->query($sql_check_event);
    $count_check_event = $result_check_event->num_rows;
	if($count_check_event > 0){
		$row_check_event = $result_check_event->fetch_assoc();
	    $show = $_SESSION['show'] =  $row_check_event['shortcode'];
		$year = $_SESSION['year'] =  $row_check_event['year'];
		$order_prefix = $row_check_event['order_prefix'];
		$isMachinary = $row_check_event['isFree'];
	}else{
		echo json_encode(array("status"=>"error","message"=>"Sorry show registration is closed"));exit;
	}
	if($num<=0)
	{ 
		$orderId = 'vis1'; 
	}else
	{
	  $orderId=$order_prefix.$strNo;
	}
	$_SESSION['orderId']=$orderId;

	if(isset($registration_id) && $registration_id!=""){

		if($visitor_id!='0' && !empty($visitor_id) && !empty($payment_made_for) && !empty($show)){
			$checkVisitor = "SELECT * FROM `visitor_order_temp` WHERE visitor_id='$visitor_id' AND registration_id='$registration_id' AND `show`='$show' AND `year`='$year' AND `status`='1' AND paymentThrough='single'";
			$checkVisitorResult = $conn->query($checkVisitor);
			$getCountx = $checkVisitorResult->num_rows;
			if($getCountx > 0)
			{
			$updatex = "UPDATE `visitor_order_temp` SET `modified_date`=NOW(),`registration_id`='$registration_id',`visitor_id`='$visitor_id',`orderId`='$orderId',`payment_made_for`='$payment_made_for',`amount`='$amount',paymentThrough='single' WHERE `show`='$show' AND `year`='$year' AND `registration_id`='$registration_id' AND `visitor_id`='$visitor_id'"; 
			$getResultx = $conn->query($updatex);

			}else{
			$ins = "INSERT INTO `visitor_order_temp`(`registration_id`, `visitor_id`,`orderId`, `payment_made_for`, `amount`,`show`, `year`, `status`,`paymentThrough`) VALUES ('$registration_id','$visitor_id','$orderId','$payment_made_for','$amount','$show','$year','1','single')";
			$insert = $conn->query($ins);
			} 
		}
	}
	
	if(!is_numeric($amount) || !is_numeric($registration_id)){
		echo json_encode(array('status'=>'invalidAmount'));exit; 
	}

 // Check session_id and Amount start

if(isset($registration_id) && $registration_id!=""){

	$sqlP = "select amount,payment_made_for from visitor_order_temp where registration_id='$registration_id' AND `show`='$show' AND `year`='$year' AND `orderId`='$orderId' AND paymentThrough='single'"; 
	$queryP = $conn->query($sqlP);
	$resultP = $queryP->fetch_assoc();
	$temp_total_amount = trim($resultP['amount']);
	$payment_made_for = trim($resultP['payment_made_for']);

	// CHECK LAST YEAR 1SHOW,2SHOW,3SHOW,4SHOW,5SHOW,6SHOW PAYMENT
   
		    $checkHistory = "SELECT * FROM `visitor_order_history` WHERE registration_id='$registration_id' AND visitor_id='$visitor_id' AND payment_made_for='6show' AND `status`='1' AND payment_status='Y'";
		    $getQuery = $conn ->query($checkHistory);
		    $checkResult = $getQuery->num_rows;
		    if($checkResult > 0 ){
		    	$isFree = "yes";
		    } else {
		    	$isFree = "no";
		    }
	    	$_SESSION['isFree'] = $isFree;
		
	if($temp_total_amount==$amount)
	{
	// 	 For Machinery Start
		if($payment_made_for==$show && $temp_total_amount==0 && $isMachinary=="yes" )
		{
		//if(isset($delivery_id) && !empty($delivery_id)) {
				
		$sqlx3 = "INSERT `visitor_order_detail` SET `type_of_member`='$type_of_member',`delivery_id`='$delivery_id',`billing_delivery_id`='$billing_delivery_id' , `regId`='$registration_id' , `orderId`='$orderId' , `paymentThrough`='single',`payment_type`='free',`total_payable`='$amount',`create_date`='$post_date',year='$year',event='$show'"; 
		$result2 = $conn->query($sqlx3);
		if($result2){ 
			echo json_encode(array('status'=>'machinerySuccess'));exit; 
		}
		/* } else {
			echo json_encode(array('status'=>'emptyAddress'));exit; 
		} */
				
		// For Machinery End 
		} 
		elseif($temp_total_amount==0 && $isFree="yes")
		{			
			$sqlx3 = "INSERT `visitor_order_detail` SET `type_of_member`='$type_of_member',`delivery_id`='$delivery_id',`billing_delivery_id`='$billing_delivery_id', `regId`='$registration_id' , `orderId`='$orderId' , `paymentThrough`='single',`payment_type`='free',`total_payable`='$amount',`create_date`='$post_date',year='$year',event='$show',agree='$agree'"; 
			$result2 = $conn->query($sqlx3);		
			if($result2){				
				echo json_encode(array('status'=>'zeroPaymentSuccess'));exit; 
			}
		} 

		else {
			
		// For IIJS Start	
		if(isset($delivery_id) && !empty($delivery_id) && !empty($billing_delivery_id) && $delivery_id!='N')
		{
	    $sqlx2 = "insert into visitor_order_detail set orderId='$orderId',regId='$registration_id',payment_type='$payment_type',total_payable='$amount',create_date='$post_date', paymentThrough='single',year='$year',event='$show',agree='$agree'";
		$result2 = $conn->query($sqlx2);
		if($result2){
			echo json_encode(array('status'=>'success')); exit;				
		}
		
	    $sqlx3 = "UPDATE `visitor_order_detail` SET `type_of_member`='$type_of_member',`delivery_id`='$delivery_id',`billing_delivery_id`='$billing_delivery_id' WHERE `regId`='$registration_id' AND orderId='$orderId' AND paymentThrough='single' AND event='$show'"; 
		$result3 = $conn->query($sqlx3);
		} else {
		echo json_encode(array('status'=>'emptyAddress')); exit; 			
		}	
			
		}
	// For IIJS End 	
		}  else {
		echo json_encode(array('status'=>'error'));exit; 
		}		
	} else {
		echo json_encode(array('status'=>'sessionExpired'));exit; 
	}
}



/* link 
if($action == 'singleVisitorRegistrationForDirectPayment'){

$visitor_id = trim($_POST['visitor_id']);

$payment_made_for = $_POST['payment_made_for'];

if($_SESSION['member_type'] =="MEMBER"){
	$type_of_member = "M";
}else{
	$type_of_member = "NM";
}

$getVisitorFee="SELECT * FROM `visitor_fee_structure` WHERE min_date <=  NOW() AND max_date >=  NOW() AND type='$type_of_member'";
$resultVisitorFee =$conn->query($getVisitorFee);
$rowVisitorFee = $resultVisitorFee->fetch_assoc();


$checkHistory = "SELECT * FROM `visitor_order_history` WHERE  visitor_id='$visitor_id' AND (payment_made_for='6show' OR payment_made_for='5show' OR payment_made_for='4show' OR payment_made_for='3show') AND `status`='1' AND payment_status='Y'";

$getQuery = $conn ->query($checkHistory);

$checkResult = $getQuery->num_rows;	
if($checkResult > 0 ){
	$participation_fee = 0;
}else{
	$participation_fee=$rowVisitorFee['igjme_signature'];
}


$getVisitor = "SELECT * FROM visitor_directory WHERE visitor_id ='$visitor_id' AND visitor_approval ='Y' AND status ='1'" ;
$resultVisitor = $conn->query($getVisitor);
$rowVisitor = $resultVisitor->fetch_assoc();
$countVisitor = $resultVisitor->num_rows;

if($countVisitor >0){

$registration_id = $rowVisitor['registration_id'];


}else{
echo json_encode(array("status"=>"error","message"=>"Invalid Visitor access found"));exit;
}

$amount = trim($participation_fee);
//$amount = 1;
$show = "signature22";
$year = "2022";
$payment_type = "online";
$post_date = date('Y-m-d');
$type = "link";
$delivery_id = filter($_POST['address_shipping']);
$billing_delivery_id = filter($_POST['address_billing']);
// $secondary_mobile = filter($_POST['secondary_mobile']);

if(isset($_POST['agree']) && $_POST['agree'] == 'YES'){   $agree = "YES"; } else {  $agree = "NO"; }

$chks = "select * from visitor_order_detail order by id desc limit 1";
$chkResult = $conn->query($chks);
$row = $chkResult->fetch_assoc();
$num=$chkResult->num_rows;
$strNo = rand(1,10000000);
if($num<=0)
{ $orderId = 'vis1'; }
else
{
  $orderId='SIGN21'.$strNo;
}
 $_SESSION['orderId']=$orderId;
 $_SESSION['visitor_id'] = $visitor_id;
 $_SESSION['registration_id'] = $registration_id;

if(isset($registration_id) && $registration_id!=""){
   
	if($visitor_id!='0' && !empty($visitor_id) && !empty($payment_made_for) && !empty($show)){
		$checkVisitor = "SELECT * FROM `visitor_order_temp` WHERE visitor_id='$visitor_id' AND registration_id='$registration_id' AND `show`='$show' AND `year`='$year' AND `status`='1' AND paymentThrough='$type'";
		$checkVisitorResult = $conn->query($checkVisitor);
		$getCountx = $checkVisitorResult->num_rows;
		if($getCountx > 0)
		{
		    $updatex = "UPDATE `visitor_order_temp` SET `modified_date`=NOW(),`registration_id`='$registration_id',`visitor_id`='$visitor_id',`orderId`='$orderId',`payment_made_for`='$payment_made_for',`amount`='$amount',paymentThrough='$type' WHERE `show`='$show' AND `year`='$year' AND `registration_id`='$registration_id' AND `visitor_id`='$visitor_id'";
		    $getResultx = $conn->query($updatex);

		} else {
		    $ins = "INSERT INTO `visitor_order_temp`(`registration_id`, `visitor_id`,`orderId`, `payment_made_for`, `amount`,`show`, `year`, `status`,`paymentThrough`) VALUES ('$registration_id','$visitor_id','$orderId','$payment_made_for','$amount','$show','$year','1','$type')";
		    $insert = $conn->query($ins);
		} 
    }
}
	
	
if(!is_numeric($amount) || !is_numeric($registration_id)){
	echo json_encode(array('status'=>'invalidAmount'));exit; 
}
/*============ Check session_id and Amount start=============
if(isset($registration_id) && $registration_id!="")
{
    $sqlP = "select amount,payment_made_for from visitor_order_temp where registration_id='$registration_id' AND `show`='$show' AND `year`='$year' AND `orderId`='$orderId' AND paymentThrough='$type'"; 
	$queryP = $conn->query($sqlP);
	$resultP = $queryP->fetch_assoc();
	$temp_total_amount = trim($resultP['amount']);
	$payment_made_for = trim($resultP['payment_made_for']);
    //echo $temp_total_amount."---".$total_payable;exit;
	
	if($temp_total_amount==$amount)
	{
		// For Machinery Start
		 	if($payment_made_for=="igjme" && $temp_total_amount==0)
		 	{
		 	if(isset($delivery_id) && !empty($delivery_id)) {
		 //	 $sqlx2 = "insert into visitor_order_detail set orderId='$orderId',regId='$registration_id',payment_type='free',total_payable='$amount',create_date='$post_date',paymentThrough='$type',type_of_member='$type_of_member'";
			 		$result2 = mysql_query($sqlx2);
					
		   $sqlx3 = "INSERT `visitor_order_detail` SET `type_of_member`='$type_of_member',`delivery_id`='$delivery_id',`billing_delivery_id`='$billing_delivery_id' , `regId`='$registration_id' , `orderId`='$orderId' , `paymentThrough`='$type',`payment_type`='free',`total_payable`='$amount',`create_date`='$post_date',year='$year',event='$show'"; 
		 	$result2 = $conn->query($sqlx3);
		 	} else {
		 	echo json_encode(array('status'=>'emptyAddress'));exit; 
				
		 	}
			
		 	if($result2){ 
			
		 	echo json_encode(array('status'=>'machinerySuccess'));exit; 
		 	 }		
		
		 	}else 
		if($payment_made_for==$show && $temp_total_amount==0)
		{
			$sqlx3 = "INSERT `visitor_order_detail` SET `type_of_member`='$type_of_member',`delivery_id`='$delivery_id',`billing_delivery_id`='$billing_delivery_id', `regId`='$registration_id', `orderId`='$orderId', `paymentThrough`='$type',`payment_type`='free',`total_payable`='$amount',`create_date`='$post_date',year='$year',event='$show',agree='$agree'"; 
			$result2 = $conn->query($sqlx3);
			if($result2){ 
			    echo json_encode(array('status'=>'sign2Success'));exit; 
			}		
		// For VBSM End 
		}else{
		// For IIJS Start
			if(isset($delivery_id) && !empty($delivery_id) && !empty($billing_delivery_id) && $delivery_id!='N') {
		        $sqlx2 = "insert into visitor_order_detail set orderId='$orderId',regId='$registration_id',payment_type='$payment_type',total_payable='$amount',create_date='$post_date', paymentThrough='$type',year='$year',event='$show'";
			    $result2 = $conn->query($sqlx2);		
			    $sqlx3 = "UPDATE `visitor_order_detail` SET `type_of_member`='$type_of_member',`delivery_id`='$delivery_id',`billing_delivery_id`='$billing_delivery_id' WHERE `regId`='$registration_id' AND orderId='$orderId' AND paymentThrough='$type' AND  event='$show'"; 
                $result3 = $conn->query($sqlx3);
			} else {
			    echo json_encode(array('status'=>'emptyAddress'));exit; 
			}
			
			if($result2){
			echo json_encode(array('status'=>'signatureSuccess'));exit; 
			}
		}
	}else{
	    echo json_encode(array('status'=>'error'));exit; 
	}		
} else {
	echo json_encode(array('status'=>'sessionExpired'));exit; 
}
}
*/

function valid_email($str) {
return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}
if($action == 'UpdateVisitor'){
 $first_name = filter($_POST['first_name']);	
 $last_name = filter($_POST['last_name']);	
 $gender = filter($_POST['gender']);	
 $mobile_no = filter($_POST['mobile_no']);	
 $email_id = filter($_POST['email_id']);	
 $adhaar_no = filter($_POST['adhaar_no']);	
 $pan_no = filter($_POST['pan_no']);
 $mod_date	 = date('Y-m-d');
 $sql_event = "SELECT * FROM `visitor_event_master` WHERE `status` ='1' AND `isParentShow`='1' ";
 $result_event = $conn->query($sql_event);
 $count_event = $result_event->num_rows;
 if($count_event > 0){
   $row_event = $result_event->fetch_assoc();
   $show = $row_event['shortcode'];
   $year = $row_event['year'];
   $event_name = $row_event['event_name'];  
 } else {
 	$show = "iijs";
 	$year = date("Y");
    $event_name = "IIJS";
 }
 	
 if(empty($_POST['first_name'])){
  echo json_encode(array('status'=>'fnameEmpty'));exit; 
 }elseif (empty($_POST['last_name'])) {
 echo json_encode(array('status'=>'lnameEmpty'));exit; 	
 }elseif (empty($_POST['gender'])) {
 echo json_encode(array('status'=>'genderEmpty'));exit; 
 }elseif (empty($_POST['mobile_no'])) {
 echo json_encode(array('status'=>'mobileEmpty'));exit; 
 }elseif(!preg_match("/^[6-9][0-9]{9}$/", $mobile_no)) {
 echo json_encode(array('status'=>'invalidMobileNumber'));exit;
 }elseif (empty($_POST['email_id'])) {
 echo json_encode(array('status'=>'emailEmpty'));exit; 
 }
 /*elseif (empty($_POST['adhaar_no'])) {
 echo json_encode(array('status'=>'adhaarEmpty'));exit; 	
 }*/
 elseif (empty($_POST['pan_no'])) {
 echo json_encode(array('status'=>'panEmpty'));exit;	
}
if(!filter_var($email_id, FILTER_VALIDATE_EMAIL)){
 echo json_encode(array('status'=>'invalidEmail'));exit; 
}
if(!preg_match("/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/", strtoupper($pan_no))) {
    echo json_encode(array('status'=>'invalidPanNumber'));exit;
}
$registration_id = $_SESSION['registration_id'];
$visitor_id = $_SESSION['visitor_id'];
$slqPan = "SELECT pan_no FROM visitor_directory WHERE pan_no='$pan_no' AND visitor_id!='$visitor_id'";
$slqEmail = "SELECT email FROM visitor_directory WHERE email='$email_id' AND visitor_id!='$visitor_id'";
$slqMobile = "SELECT mobile FROM visitor_directory WHERE mobile='$mobile_no' AND visitor_id!='$visitor_id'";
 $sqlPanResult = $conn->query($slqPan);
 $sqlEmailResult = $conn->query($slqEmail);
 $sqlMobileResult = $conn->query($slqMobile);
 $panCount = $sqlPanResult->num_rows;
 $emailCount = $sqlEmailResult->num_rows;
 $mobileCount = $sqlMobileResult->num_rows;
 if ($panCount > 0) {
 	echo json_encode(array('status'=>'panExist'));exit; 
 }elseif ($emailCount > 0) {
 	echo json_encode(array('status'=>'emailExist'));exit; 
 } elseif ($mobileCount > 0) {
 	echo json_encode(array('status'=>'mobileExist'));exit; 
 }


$sql  = "SELECT photo,pan_copy,salary_slip_copy,partner,degn_type FROM visitor_directory WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'";
$result= $conn->query($sql);
$row = $result->fetch_assoc();
$get_photo = $row['photo'];
$get_pan_copy = $row['pan_copy'];
$get_salary = $row['salary_slip_copy'];
$get_partner = $row['partner'];
 $designationType = $_POST['designation'];
 $designation = $_POST['designationList'];

		$create_directory = 'images/employee_directory/'.$_SESSION['registration_id'];
		if(!file_exists($create_directory)) {
		mkdir($create_directory, 0777);
		}

	if(isset($_FILES['photo']) && $_FILES['photo']['name']!="")
	{
		/* passport picture */
		$photo_name=$_FILES['photo']['name'];
		$photo_temp=$_FILES['photo']['tmp_name'];
		$photo_type=$_FILES['photo']['type'];
		$photo_size=$_FILES['photo']['size'];
		/*$id = $_SESSION['visitor_id'];*/
		$attach="photo";
		if($photo_name!="")
		{
		     $create_photo = 'images/employee_directory/'.$_SESSION['registration_id'].'/'.$attach;
			if (!file_exists($create_photo)) {
			mkdir($create_photo, 0777);
			}
			 $photo=uploadSingleVIsitor($photo_name,$photo_temp,$photo_type,$photo_size,$visitor_id,$attach);
			 if ($photo =="fail") {
			 	echo json_encode(array('status'=>'photoFail')); exit; 
			 } elseif ($photo =="invalid") {
			 	echo json_encode(array('status'=>'photoInvalid')); exit; 			 
			 }
		}
	} else {
		if (!empty($get_photo) || $get_photo !="") {
			$photo =$get_photo ;
 	        
         }else{
            echo json_encode(array('status'=>'emptyPhoto'));exit; 
         }		
	}
	
	if(isset($_FILES['pan_copy']) && $_FILES['pan_copy']['name']!="")
	{
		/* pan picture */
		$pan_name=$_FILES['pan_copy']['name'];
		$pan_temp=$_FILES['pan_copy']['tmp_name'];
		$pan_type=$_FILES['pan_copy']['type'];
		$pan_size=$_FILES['pan_copy']['size'];
		$attach="pan_copy";
		$id = $_SESSION['visitor_id'];
		if($pan_name!="")
		{
			$create_pan = 'images/employee_directory/'.$_SESSION['registration_id'].'/'.$attach;
			if (!file_exists($create_pan)) {
			mkdir($create_pan, 0777);
			}
			$pan_copy=uploadSingleVIsitor($pan_name,$pan_temp,$pan_type,$pan_size,$visitor_id,$attach);
			 if ($pan_copy =="fail") {
			 	echo json_encode(array('status'=>'panCopyFail'));exit; 
			 }elseif ($pan_copy =="invalid") {
			 	echo json_encode(array('status'=>'panCopyInvalid'));exit;			 
			 }
		}
	}else{
		if (!empty($get_pan_copy) || $get_pan_copy !="") {
			$pan_copy = $get_pan_copy ;
 	        
         }else{
            echo json_encode(array('status'=>'emptyPanCopy'));exit; 
         }
	}	

	if($designationType == "Owner"){
   	if(isset($_FILES['gst_copy']) && $_FILES['gst_copy']['name']!="")
	{
		/* passport picture */
		$partner_name=$_FILES['gst_copy']['name'];
		$partner_temp=$_FILES['gst_copy']['tmp_name'];
		$partner_type=$_FILES['gst_copy']['type'];
		$partner_size=$_FILES['gst_copy']['size'];
		$attach="partner";
		$id = $_SESSION['visitor_id'];
		if($partner_name!="")
		{
			$create_partner = 'images/employee_directory/'.$_SESSION['registration_id'].'/'.$attach;
			if (!file_exists($create_partner)) {
			mkdir($create_partner, 0777);
			}
			$partner=uploadSingleVIsitor($partner_name,$partner_temp,$partner_type,$partner_size,$visitor_id,$attach);
			 if ($partner =="fail") {
			 	echo json_encode(array('status'=>'partnerFail'));exit; 
			 }elseif ($partner =="invalid") {
			 	echo json_encode(array('status'=>'partnerInvalid'));exit; 			 
			 }
		}
	}else{
		
		if (!empty($get_partner) || $get_partner !="") {
			$partner = $get_partner ;
 	        
         }else{
            echo json_encode(array('status'=>'emptyPartner'));exit; 
         }
	}
 }else if($designationType == "Employee"){
    	if(isset($_FILES['salary_slip']) && $_FILES['salary_slip']['name']!="")
	{
		/* passport picture */
		$salary_name=$_FILES['salary_slip']['name'];
		$salary_temp=$_FILES['salary_slip']['tmp_name'];
		$salary_type=$_FILES['salary_slip']['type'];
		$salary_size=$_FILES['salary_slip']['size'];
		$attach="salary";
		$id = $_SESSION['visitor_id'];
		if($salary_name!="")
		{
			$create_salary = 'images/employee_directory/'.$_SESSION['registration_id'].'/'.$attach;
			if (!file_exists($create_salary)) {
			mkdir($create_salary, 0777);
			}
			$salary=uploadSingleVIsitor($salary_name,$salary_temp,$salary_type,$salary_size,$visitor_id,$attach);
			 if ($salary =="fail") {
			 	echo json_encode(array('status'=>'salaryFail'));exit; 
			 }elseif ($salary =="invalid") {
			 	echo json_encode(array('status'=>'salaryInvalid'));exit; 			 
			 }
		}
	}else{
		
		if (!empty($get_salary) || $get_salary !="") {
			$salary = $get_salary ;
 	        
         }else{
            echo json_encode(array('status'=>'emptySalary'));exit; 
         }
	}
 }

   // $updateSql ="UPDATE visitor_directory SET  mod_date='$mod_date', designation='$designation',degn_type='$designationType', name='$first_name', lname='$last_name', gender='$gender', aadhar_no='$adhaar_no', mobile='$mobile_no',email='$email_id', pan_no='$pan_no',photo='$photo',salary_slip_copy='$salary',pan_copy='$pan_copy',partner='$partner',visitor_approval='U',isApplied='Y',shows='$show',year='$year',paymentThrough='single',status='1'  WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'";
   $updateSql ="UPDATE visitor_directory SET  mod_date='$mod_date', name='$first_name', lname='$last_name', gender='$gender', aadhar_no='$adhaar_no', mobile='$mobile_no',email='$email_id', pan_no='$pan_no',photo='$photo',salary_slip_copy='$salary',pan_copy='$pan_copy',partner='$partner',visitor_approval='U',isApplied='Y',shows='$show',year='$year',paymentThrough='single',status='1'  WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'";
   $updateResult = $conn->query($updateSql);
   if($updateResult ==TRUE){
   	//$message = "Dear ".$first_name.", Welcome to IIJS SIGNATURE 2022, your data for Visitor has been updated successfully, you will be notified on approval/disapproval";
   	$message = "Dear ".$first_name.", Thank you for showing your interest in visiting $event_name. Your documents are successfully uploaded for visitor registration, you will be notified shortly on approval/disapproval of documents. For any further query please contact $tollNumber GJEPC";

   $_SESSION['successMessage']= $message; 
   	
   	/*session_unset($registration_id);
   	session_unset($visitor_id);*/
    echo json_encode(array('status'=>'updateSuccess'));exit; 
   }
 
}
if($action == 'check_company_pan'){
	$company_pan_no = filter(strtoupper($_POST["company_pan_no"]));
	$sql =  "SELECT company_pan_no,id,company_name,status FROM registration_master WHERE company_pan_no='$company_pan_no' limit 1";
	$result = $conn->query($sql); 
	$row = $result->fetch_assoc();
	$status = $row['status'];
	$count = $result->num_rows;
    $data = array();
	if($count>0) 
	{
    if ($status =="0") {
      echo json_encode(array("status"=>'deActive'));exit;
		
	}		
	$registration_id = $row['id'];

	$company_type = $row['company_type'];
	$company_name = $row['company_name'];

	/*$sqlExhibitor = "select * from exh_reg_payment_details where uid='$registration_id' and `year`='2019'  AND allow_visitor='N' order by payment_id desc limit 0,1";
    $ansExhibitor = $conn->query($sqlExhibitor);
    $rowExhibitor=$ansExhibitor->num_rows;
    if($rowExhibitor>0){
	    echo json_encode($data = array("status"=>'exhibitor')); exit;
    } */
	$_SESSION['registration_id'] = $registration_id;
	$_SESSION['company_type'] = $company_type; 	
	echo json_encode(array("status"=>'exist','company_name'=>$company_name));exit;
		
	}else if($count<1){
		echo json_encode(array("status"=>'notExist'));exit;
	}	

}

if($action == 'AddVisitor')
{

/*print_r( $_POST);print_r($_FILES);exit;*/
 $designationType = filter($_POST['designationType']);	
 $designation = filter($_POST['designation']);	
 $first_name = filter($_POST['first_name']);	
 $last_name = filter($_POST['last_name']);	
 $gender = filter($_POST['gender']);	
 $mobile_no = filter($_POST['mobile_no']);	
 $email_id = filter($_POST['email_id']);	
 $adhaar_no = filter($_POST['adhaar_no']);	
 $pan_no = filter($_POST['pan_no']);	
 /*$pan_no = $_FILES['photo']['name'];*/
 $sql_event = "SELECT * FROM `visitor_event_master` WHERE `status` ='1' AND `isParentShow`='1' ";
 $result_event = $conn->query($sql_event);
 $count_event = $result_event->num_rows;
 if($count_event > 0){
   $row_event = $result_event->fetch_assoc();
   $show = $row_event['shortcode'];
   $year = $row_event['year'];
   $event_name = $row_event['event_name'];
   
 }else{
 	$show = "iijs";
 	$year = date("Y");
 	$event_name = "IIJS";
 }
 $post_date = date('Y-m-d');	
 	
 if(empty($_POST['designationType'])){
  echo json_encode(array('status'=>'designationTypeEmpty'));exit; 

 }elseif(empty($_POST['designation'])){
  echo json_encode(array('status'=>'designationEmpty'));exit; 

 }elseif(empty($_POST['first_name'])){
  echo json_encode(array('status'=>'fnameEmpty'));exit; 

 }elseif (empty($_POST['last_name'])) {
 echo json_encode(array('status'=>'lnameEmpty'));exit; 
 	
 }elseif (empty($_POST['gender'])) {
 echo json_encode(array('status'=>'genderEmpty'));exit; 
 	
 }elseif (empty($_POST['mobile_no'])) {
 echo json_encode(array('status'=>'mobileEmpty'));exit; 
 	
 }else if(!preg_match("/^[6-9][0-9]{9}$/", strtoupper($mobile_no))) {
    echo json_encode(array('status'=>'invalidMobileNumber'));exit;
 }else if (empty($_POST['email_id'])) {
 echo json_encode(array('status'=>'emailEmpty'));exit; 
 	
 }/*elseif (empty($_POST['adhaar_no'])) {
 echo json_encode(array('status'=>'adhaarEmpty'));exit; 
 	
 }*/elseif (empty($_POST['pan_no'])) {
 echo json_encode(array('status'=>'panEmpty'));exit; 
 	
 }elseif (empty($_FILES['photo']['name'])) {
 echo json_encode(array('status'=>'photoEmpty'));exit; 
 	
 }elseif (empty($_FILES['pan_copy']['name'])) {
 echo json_encode(array('status'=>'panCopyEmpty'));exit; 
 }
 //elseif (empty($_POST['certificate'])) {
 // echo json_encode(array('status'=>'error',"label"=>"certificateEmpty","message"=>"Please select certificate type"));exit; 
 // }
 
 if(!filter_var($_POST['email_id'], FILTER_VALIDATE_EMAIL)){
    echo json_encode(array('status'=>'invalidEmail'));exit; 
  }

 if(!preg_match("/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/", strtoupper($pan_no))) {
    echo json_encode(array('status'=>'invalidPanNumber'));exit;
 } 

 if($designationType == "Owner" && empty($_FILES['gst_copy']['name']) ){
    echo json_encode(array('status'=>'gstCopyEmpty'));exit; 
 }else if($designationType == "Employee" && empty($_FILES['salary_slip']['name'])){
    echo json_encode(array('status'=>'SalarySlipEmpty'));exit; 
 }

 $slqPan = "SELECT pan_no FROM visitor_directory WHERE pan_no='$pan_no'";
 $slqMobile = "SELECT mobile FROM visitor_directory WHERE mobile='$mobile_no'";
 $slqEmail = "SELECT email FROM visitor_directory WHERE email='$email_id '";
 $sqlPanResult = $conn->query($slqPan);
 $sqlMobileResult = $conn->query($slqMobile);
 $sqlEmailResult = $conn->query($slqEmail);
 $panCount = $sqlPanResult->num_rows;
 $mobileCount = $sqlMobileResult->num_rows;
 $emailCount = $sqlEmailResult->num_rows;

 if ($panCount > 0) {
 	 echo json_encode(array('status'=>'panExist'));exit; 
 }else if($mobileCount > 0){
    echo json_encode(array('status'=>'mobileExist'));exit;
 }else if ( $emailCount > 0) {
 	echo json_encode(array('status'=>'emailExist'));exit;
 }
$registration_id = $_SESSION['registration_id'];

		$create_directory = 'images/employee_directory/'.$_SESSION['registration_id'];
			if(!file_exists($create_directory)) {
			mkdir($create_directory, 0777);
		}

	if(isset($_FILES['photo']) && $_FILES['photo']['name']!="")
	{
		/* passport picture */
		$photo_name=$_FILES['photo']['name'];
		$photo_temp=$_FILES['photo']['tmp_name'];
		$photo_type=$_FILES['photo']['type'];
		$photo_size=$_FILES['photo']['size'];
		
		$attach="photo";
		if($photo_name!="")
		{
		    $create_photo = 'images/employee_directory/'.$_SESSION['registration_id'].'/'.$attach;
			if(!file_exists($create_photo)) {
			mkdir($create_photo, 0777);
			}
			$photo=uploadSingleVIsitorInsert($photo_name,$photo_temp,$photo_type,$photo_size,$mobile_no,$attach);
			if ($photo =="fail") {
			 	echo json_encode(array('status'=>'photoFail'));exit; 
			}elseif ($photo =="invalid") {
			 	echo json_encode(array('status'=>'photoInvalid'));exit; 
			}
		}
	}
	
	if(isset($_FILES['pan_copy']) && $_FILES['pan_copy']['name']!="")
	{
		/* pan picture */
		$pan_name=$_FILES['pan_copy']['name'];
		$pan_temp=$_FILES['pan_copy']['tmp_name'];
		$pan_type=$_FILES['pan_copy']['type'];
		$pan_size=$_FILES['pan_copy']['size'];
		$attach="pan_copy";
		
		if($pan_name!="")
		{
			$create_pan = 'images/employee_directory/'.$_SESSION['registration_id'].'/'.$attach;
			if(!file_exists($create_pan)) {
			mkdir($create_pan, 0777);
			}
			$pan_copy=uploadSingleVIsitorInsert($pan_name,$pan_temp,$pan_type,$pan_size,$mobile_no,$attach);
			if ($pan_copy =="fail") {
			 	echo json_encode(array('status'=>'panCopyFail'));exit; 
			}elseif ($pan_copy =="invalid") {
			 	echo json_encode(array('status'=>'panCopyInvalid'));exit; 
			}
		}
	}
	
	if(isset($_FILES['salary_slip']) && $_FILES['salary_slip']['name']!="")
	{
		/* passport picture */
		$salary_name=$_FILES['salary_slip']['name'];
		$salary_temp=$_FILES['salary_slip']['tmp_name'];
		$salary_type=$_FILES['salary_slip']['type'];
		$salary_size=$_FILES['salary_slip']['size'];
		$attach="salary";
		
		if($salary_name!="")
		{
			$create_salary = 'images/employee_directory/'.$_SESSION['registration_id'].'/'.$attach;
			if (!file_exists($create_salary)) {
			mkdir($create_salary, 0777);
			}
			$salary=uploadSingleVIsitorInsert($salary_name,$salary_temp,$salary_type,$salary_size,$mobile_no,$attach);
			if($salary =="fail") {
			 	echo json_encode(array('status'=>'salaryFail'));exit; 
			}elseif ($salary =="invalid") {
			 	echo json_encode(array('status'=>'salaryInvalid'));exit; 
			}
		}
	}
	
	if(isset($_FILES['gst_copy']) && $_FILES['gst_copy']['name']!="")
	{
		/* passport picture */
		$partner_name=$_FILES['gst_copy']['name'];
		$partner_temp=$_FILES['gst_copy']['tmp_name'];
		$partner_type=$_FILES['gst_copy']['type'];
		$partner_size=$_FILES['gst_copy']['size'];
		$attach="partner";
		
		if($partner_name!="")
		{
			$create_partner = 'images/employee_directory/'.$_SESSION['registration_id'].'/'.$attach;
			if (!file_exists($create_partner)) {
			mkdir($create_partner, 0777);
			}
			 $partner=uploadSingleVIsitorInsert($partner_name,$partner_temp,$partner_type,$partner_size,$mobile_no,$attach);
			  if ($partner =="fail") {
			 	echo json_encode(array('status'=>'partnerFail'));exit; 
			 }elseif ($partner =="invalid") {
			 	echo json_encode(array('status'=>'partnerInvalid'));exit; 
			 }
		}
	}
	 	// if(isset($_FILES['self_report']) && $_FILES['self_report']['name']!=""){
				
			// 	$self_report_name=$_FILES['self_report']['name'];
			// 	$self_report_temp=$_FILES['self_report']['tmp_name'];
			// 	$self_report_type=$_FILES['self_report']['type'];
			// 	$self_report_size=$_FILES['self_report']['size'];
			// 	/*$id = $_SESSION['visitor_id'];*/
			// 	$attach="self_report";
			// 	if($self_report_name!="")
			// 	{
			// 	     $create_self_report = 'images/covid/vis/'.$_SESSION['registration_id'].'/'.$attach;
			// 		if (!file_exists($create_self_report)) {
			// 		mkdir($create_self_report, 0777);
			// 		}
			// 		  $self_report=uploadSingleVIsitorCovid($self_report_name,$self_report_temp,$self_report_type,$self_report_size,$mobile_no,$attach);
			// 		 if ($self_report =="fail") {
			// 		 	echo json_encode(array('status'=>'error',"message"=>"Sorry, vaccine/RT-PCR certificate uploading has been failed on server.","label"=>"self_reportEmpty"));exit; 
			// 		 }elseif ($self_report =="invalid") {
			// 		 	echo json_encode(array('status'=>'error',"message"=>"Please Select valid file type","label"=>"self_reportEmpty","label"=>"self_reportEmpty"));exit; 
			// 		 }
			// 	}else{
			// 		echo json_encode(array("status"=>"error","message"=>"Please Select vaccine/RT-PCR certificate","label"=>"self_reportEmpty"));exit;
			// 	}
			// }else{
			// 	echo json_encode(array("status"=>"error","message"=>"Please Select vaccine/RT-PCR certificate","label"=>"self_reportEmpty"));exit;
			// }
  
    if($designationType == "Owner" ){
      $InsertSql ="INSERT visitor_directory SET post_date='$post_date',registration_id='$registration_id', degn_type='$designationType',designation='$designation', name='$first_name', lname='$last_name', gender='$gender', aadhar_no='$adhaar_no', mobile='$mobile_no',email='$email_id', pan_no='$pan_no',photo='$photo',pan_copy='$pan_copy',partner='$partner',isApplied='Y',shows='$show',year='$year',paymentThrough='single',status='1' ";

    }else if($designationType == "Employee"){
      $InsertSql = "INSERT visitor_directory SET post_date='$post_date',registration_id='$registration_id', degn_type='$designationType',designation='$designation', name='$first_name', lname='$last_name', gender='$gender', aadhar_no='$adhaar_no', mobile='$mobile_no',email='$email_id', pan_no='$pan_no',photo='$photo',salary_slip_copy='$salary',pan_copy='$pan_copy',isApplied='Y',shows='$show',year='$year',paymentThrough='single',status='1'";
    }
   
   $InsertResult = $conn->query($InsertSql);
    if($InsertResult ==TRUE){
	
	$tollNumber = "1800-103-4353";
// 	$message = "Dear ".$first_name.", Welcome to IIJS SIGNATURE 2022, your data for Visitor badge has been updated successfully, you will be notified on approval/disapproval";
	$message = "Dear ".$first_name.", Thank you for showing your interest in visiting $event_name. Your documents are successfully uploaded for visitor registration, you will be notified shortly on approval/disapproval of documents. For any further query please contact $tollNumber GJEPC";
	
    $_SESSION['successMessage']= $message; 
   	
   	/*session_unset($registration_id);*/
    echo json_encode(array('status'=>'insertSuccess'));exit; 
   }
}

if($action == 'delete_visitor')
{ 
	// print_r($_POST); exit;
	$registration_id = $_SESSION['registration_id'];
	$post_date = date("Y-m-d H:i:s");
	if(isset($registration_id) && $registration_id!="")
	{
	$visitor_id = $_POST['visitor_id'];
	$agree_delete = $_POST['agree_delete'];
	$visitorNAME = getVisitorName($visitor_id,$conn);
	$visitorPAN = getVisitorPAN($visitor_id,$conn);
 $visitorMobile = getVisitorMobile($visitor_id,$conn);
   $companyNAME = getCompanyName($registration_id,$conn);
   $companyEmail = getUserEmail($registration_id,$conn);
	
	$sqlc = "SELECT * FROM visitor_directory WHERE visitor_id='$visitor_id' AND registration_id = '$registration_id'";
    $result = $conn->query($sqlc); 
    $count = $result->num_rows;
    if($count>0){
	$check = "UPDATE visitor_directory SET `agree_delete`='Y',badge_id='$post_date' WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'";
	$updateStatus =  $conn->query($check);
    $data = array("status"=>'success');	
	if($updateStatus){
	$messageEmail='<table width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
<tbody>
	<tr>
            <td align="left"><img id="ri" src="https://registration.gjepc.org/images/logo.png">
            <td align="center"> <img id="mi"> </td>
            <td align="right"><img id="ri" src="https://registration.gjepc.org/images/signature-logo.png"></td>
            </td>                        
		</tr>
    <tr>
            <td align="center" colspan="3">
                <p style="line-height:25px;">
                    <h3 style="margin: 5px;">THE GEM JEWELLERY EXPORT PROMOTION COUNCIL</h3>
                    <b>GJEPC-H.O.-MUMBAI:1st Flr, Tower A,G Block, BDB, Bandra-Kurla Complex, Bandra(E)-400 051</b><br>
                    <b>GJEPC-E.X.-MUMBAI:G2-A, Trade Center, Bandra-Kurla Complex, Bandra(E)-400 051</b><br>
					<b>Toll Free Number :</b> 1800-103-4353, <b>Missed Call Number :</b> +91-7208048100<br>Website: https://gjepc.org/iijs-signature/ Email: visitors@gjepcindia.com</p>
            </td>
    </tr>
	<tr><td colspan="3" height="30"><hr></td></tr>  	
<!--	<tr><td align="center"><strong><u>Visitor Account Deletion Request</u></strong></td></tr>-->
	<tr>
    <td align="left"  style="text-align:justify;"><strong>Company Name :</strong> '. $companyNAME .' </td>
    </tr>
    <tr>
    <td colspan="3" id="content">
	<br><span style="background-color: rgb(255, 255, 255);"><br></span>
	<table style="border: 1px solid #ccc; border-collapse: separate; margin: 0; padding: 0; background: white; width: 100%; text-align:center; table-layout: fixed;">                
                <thead>
                  <tr style="background: #f8f8f8;border: 1px solid #ddd;padding: .35em;">
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54;">Name of Visitor</th>
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54;">Mobile No</th>
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54;">PAN No </th>                                       
                  </tr>
                </thead>
                <tbody>
                  <tr style="background: #f8f8f8;border: 1px solid #ddd; padding: .35em;">
                    <td data-label="Pattern Name" style="padding: .625em;text-align: center; padding: 10px 20px;">'.$visitorNAME.'</td>
                    <td data-label="SIZE" style="padding: .625em;text-align: center; padding: 10px 20px;">'.$visitorMobile.'</td>
                    <td data-label="Star Rating" style="padding: .625em;text-align: center; padding: 10px 20px;">'.$visitorPAN.'</td>                    
                  </tr>
                </tbody>
              </table>
    </tr>
    <tr>
	<td colspan="2"><br/>
	<p><strong>Regards</strong> <br/>
	GJEPC INDIA,</p>
	</td>
	</tr>	
      
</tbody>
</table>';
		// $to = $email;	
		$to = 'neelmani@kwebmaker.com';
		$subject = "Visitor Account Deletion Request"; 
		$cc = "";
		send_mail($to,$subject,$messageEmail,$cc);
	}
	echo json_encode(array('status'=>'success')); exit;
    } else {
    echo json_encode(array('status'=>'fail')); exit;
    }
	} else {
		echo json_encode(array('status'=>'sessionExpired')); exit; 
	}
}
if($action =="company_update"){

	$company_pan_no = filter($_POST['company_pan_no']);

	 $sql = "SELECT id,company_name FROM registration_master where company_pan_no ='$company_pan_no' order by id desc limit 0,1 ";
    $result = $conn->query($sql);
    $count = $result->num_rows;
    $rows = $result->fetch_assoc();
    if( $count > 0){
    	$company_name = $rows['company_name'];
    	$registration_id = $rows['id'];
		echo json_encode(array("status"=>"success","message"=>"Company found please confirm and update","company_name"=>$company_name,'registration_id'=>$registration_id));
    }else{
    	echo json_encode(array("status"=>"error","message"=>"Company not found with this pan number. </br><a class='text-dark blink text-bold' href='https://registration.gjepc.org/domestic_user_registration_step1.php' >Click here to register new company<a/>"));
    }


}
if($action =="updateVisitorCompany"){
	$current_time = date("Y-m-d H:i:s");

	$company_pan_no = filter($_POST['company_pan_no']);
	$visitor_id = filter($_POST['visitor_id']);

	$sql = "SELECT id,company_name FROM registration_master where company_pan_no ='$company_pan_no' ";
    $result = $conn->query($sql);
    $count = $result->num_rows;
    $rows = $result->fetch_assoc();
    if( $count > 0){
    	$company_name = $rows['company_name'];
    	$registration_id_new = $rows['id'];

    	

        /*==== GET VISITORS PREVIOUS INFO START ====*/
        $visitor_info = $conn->query("SELECT * FROM visitor_directory WHERE visitor_id='$visitor_id'");
        $visitor_count = $visitor_info->num_rows;
        $visitor_row = $visitor_info->fetch_assoc();
        $registration_id_old =  $visitor_row['registration_id'];
        $pan_no =  $visitor_row['pan_no'];
        $photo =  $visitor_row['photo'];
        /*==== GET VISITORS PREVIOUS INFO END ====*/

		/*=== INSERT DATA INTO VISITOR DELETD TABL START===*/
	     $ssx = "INSERT INTO visitor_directory_deleted
		SELECT * FROM  visitor_directory WHERE visitor_id = $visitor_id AND `registration_id`='$registration_id_old'";
			$queryData = $conn->query($ssx);
    	/*=== INSERT DATA INTO VISITOR DELETD TABL END===*/

        /*==== UPDATE COMPANY ID IN VISITOR DIRECTORY ====*/
		$sql_update = "UPDATE visitor_directory SET registration_id='$registration_id_new',isCoChange='Y', visitor_approval='D' where visitor_id='$visitor_id'";
       
		$result_update = $conn->query($sql_update);
		if($result_update){
			/*================== DELETE VC CERTIFICATE START =========================*/
			$chk_vc_sql = "SELECT visitor_lab_info WHERE   category_for='VIS' AND visitor_id='$visitor_id' ";
			$res_vc_sql = $conn->query($chk_vc_sql);
			$count_vc_sql = $res_vc_sql->num_rows;
			if($count_vc_sql > 0){
				  $sql_vc_del = "DELETE visitor_lab_info WHERE   category_for='VIS' AND visitor_id='$visitor_id' ";
          $result_vc_del = $conn->query($sql_vc_del);
			} 
    
			/*=================== DELETE VC CERTIFICATE END =========================*/

			/* === INSERT DATA IN VISITOR COMPANY LOG START === */
             $sql_log = "INSERT INTO visitor_company_log SET visitor_id='$visitor_id',pan_no='$pan_no',registration_id_old='$registration_id_old',registration_id_new='$registration_id_new',created_at='$current_time'";
            $result_log  = $conn->query($sql_log);
			/* === INSERT DATA IN VISITOR COMPANY LOG END === */



            $_SESSION['registration_id'] = $registration_id_new; 
			echo json_encode(array("status"=>"success","message"=>"Your company has been updated successfully","company_name"=>$company_name,"registration_id"=>$registration_id_new,"photo"=>$photo));
		}else{
			echo json_encode(array("status"=>"error","message"=>"Something went wrong."));
		}
    }else{
    	echo json_encode(array("status"=>"error","message"=>"Company not found with this pan number."));
    }


}

if($action =="visitorDesignationChange"){
   $visitor_id = $_SESSION['visitor_id'];
   $type = $_POST['type'];
   $getVisitor = $conn->query("SELECT * FROM visitor_directory WHERE visitor_id='$visitor_id'");
   $rowVisitor = $getVisitor->fetch_assoc();
   $preDesgnation  = $rowVisitor['designation'];
   $html = "";
    $sqlx1= "SELECT * FROM `visitor_designation_master` WHERE type='$type'";
   $query1 = $conn->query($sqlx1);
   
   while($row1 = $query1->fetch_assoc()){
   	$id =$row1['id'];
   	$value = $row1['type_of_designation'];
      $html .='<option value="'.$id.'" >'.$value.'</option>';
   }

   echo json_encode(array("status"=>"success","output"=>$html));exit;



}

if($action == 'UpdateVisitorLink'){
	$registration_id = $_SESSION['registration_id'];
	$visitor_id = $_SESSION['visitor_id'];
	$email = filter($_POST['email']);
	$checkForOtp = filter($_POST['checkForOtp']);
 if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo json_encode(array('status'=>'error',"message"=>"Enter valid E-mail id "));exit; 
}
	$sqlEmail  = "SELECT email FROM visitor_directory WHERE email='$email' and visitor_id !='$visitor_id'";
	$resultEmail= $conn->query($sqlEmail);
	$countEmail = $resultEmail->num_rows;
	if($countEmail > 0 ){
		echo json_encode(array('status'=>'error',"message"=>"Email id is already exist. "));exit; 
	}

	/*OTP CHECK*/
	$sql_otp = $conn->query("SELECT * FROM visitor_directory where visitor_id='$visitor_id' and registration_id='$registration_id'");
  $result_otp = $sql_otp->fetch_assoc();
  $face_checkOtp =  $result_otp['face_checkOtp'];
  $face_emailOtp =  $result_otp['face_emailOtp'];
  if(	$checkForOtp  =="yes"){
  	if($_POST['email_otp'] ==""){
  		echo json_encode(array('status'=>'error',"message"=>"Enter OTP "));exit; 
  	}
  	$email = filter($_POST['email']);
  	$email_otp = $_POST['email_otp'];
  	if($face_emailOtp  != $email_otp ){
			echo json_encode(array('status'=>'error',"message"=>"OTP not matched "));exit; 
  	}
  	// else{
  	// 	$update_otp = $conn->query("UPDATE visitor_directory SET face_checkOtp ='0',face_emailVerified='1' ,email='$email' where visitor_id='$visitor_id' and registration_id='$registration_id'");
  	// 		echo json_encode(array('status'=>'success',"message"=>"E-mail has been updated successfully "));exit; 
		
  	// }


  }else{
  	$email =  $result_otp['email'];
  }
  
   
	
  
 	$sql_event = "SELECT * FROM `visitor_event_master` WHERE `status` ='1' AND `isParentShow`='1' ";
 	$result_event = $conn->query($sql_event);
 	$count_event = $result_event->num_rows;
 	if($count_event > 0){
   	$row_event = $result_event->fetch_assoc();
   	$show = $row_event['shortcode'];
   	$year = $row_event['year'];
   	$event_name = $row_event['event_name'];
  }else{
	 	$show = "iijs22";
	 	$year = date("Y");
	  $event_name = "IIJS22";

 	}
 





$sql  = "SELECT photo,pan_copy,salary_slip_copy,partner,degn_type FROM visitor_directory WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'";
$result= $conn->query($sql);
$row = $result->fetch_assoc();
$get_photo = $row['photo'];

 if($checkForOtp  =="yes"){
			if (empty($_POST['photo'])) {
		 		$photo =  $get_photo;
		 	}
    }else{
    	if (empty($_POST['photo'])) {
		 		echo json_encode(array('status'=>'error',"message"=>"Please first capture photo and submit form. "));exit; 
		 	}
    }


	if (!empty($_POST['photo'])) {
		$create_directory = 'images/employee_directory/'.$registration_id;
		if(!file_exists($create_directory)) {
		mkdir($create_directory, 0777);
		}

	  $img = $_POST['photo']; 
	  $img = str_replace('data:image/jpeg;base64,', '', $img);
	  $img = str_replace(' ', '+', $img);
	  $file_data = base64_decode($img);
	  $photo = time().'-photo-'.mt_rand(100000,999999).'.jpg';
	  $file_name = 'images/employee_directory/'.$_SESSION['registration_id'].'/photo/'.$photo;
	  $save_file = file_put_contents($file_name, $file_data);
	}
  $current_date =date("Y-m-d");
  $face_isApplied = "Y";
  $face_status = "U";
  $face_photo = $photo;
  $face_ip = $_SERVER['REMOTE_ADDR'];
  
    $updateSql ="UPDATE visitor_directory SET email='$email', face_date='$current_date', face_modify='$current_date', face_isApplied='$face_isApplied', face_status='$face_status', face_ip='$face_ip',face_photo='$face_photo' where visitor_id='$visitor_id' AND registration_id='$registration_id'";
   $updateResult = $conn->query($updateSql);

   if($updateResult ==TRUE){
   
   	$message = "Dear ".$first_name.", Thank you for showing your interest in visiting $event_name. Your documents are successfully uploaded for visitor registration, you will be notified shortly on approval/disapproval of documents. For any further query please contact $tollNumber GJEPC";

   	$_SESSION['successMessage']= $message; 

    echo json_encode(array('status'=>'updateSuccess'));exit; 
   }
 
}

if($action =="visitorEmailOtpAction"){
	$datetime = date("Y-m-d H:i:s");
	$visitor_id =$_SESSION['visitor_id'];
	$email =$_POST['email'];
	$registration_id = $_SESSION['registration_id'];
	$otp = rand(1000,9999); // generate OTP	
	// $email = getVisitorEmail($visitor_id,$conn);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	  echo json_encode(array('status'=>'error',"message"=>"Enter valid E-mail id "));exit; 
	}
	$sqlEmail  = "SELECT email FROM visitor_directory WHERE email='$email' and visitor_id !='$visitor_id'";
	$resultEmail= $conn->query($sqlEmail);
	$countEmail = $resultEmail->num_rows;
	if($countEmail > 0 ){
		echo json_encode(array('status'=>'error',"message"=>"Email id is already exist. "));exit; 
	}




    $messageEmail ='<table cellpadding="10" width="100%" style="margin: 0px auto; font-family: Roboto; background-color: #fff; padding: 30px; border-collapse: collapse; border: 1px solid #000;">
		<tr>
		        <td colspan="3" style="background-color: #a89c5d; padding: 3px;"></td>
		    </tr>
			<tr>
            <td align="left"><img id="ri" src="https://registration.gjepc.org/images/logo.png">
            <td align="center"> <img id="mi"> </td>
            <td align="right"></td>
            </td>                        
		</tr>
		  <tr style="background-color:#eeee;padding:30px;">
		  <td colspan="3">One Time Password for Visitor E-mail Verification is <b>'.$otp.'</b> </td></tr>
		  <tr><td colspan="3"> <p> For Any Queries : </p><b>Email us on :</b> visitors@gjepcindia.com
		 </td></tr> 
		   <tr><td colspan="3">       
			  <p>Kind Regards,<br>
			  <b>GJEPC Web Team,</b>
			  </p>
			 
			</td>
		  </tr>
		  
		</table>';
	  
		 $to = $email;
		 $subject = "Verification code to verify your account"; 
		 // $headers  = 'MIME-Version: 1.0' . "\r\n"; 
		 // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
		 // $headers .= 'From: IIJS SHOW REGISTRATION <admin@gjepc.org>';		
		 // mail($to, $subject, $messageEmail, $headers); //Send OTP ON E-Mail
    // Make verified status zero and update otp
		 $cc ="";
		 	send_mail($to,$subject,$messageEmail,$cc);

		 $update_otp = $conn->query("UPDATE visitor_directory	 SET face_emailOtp ='$otp', face_emailVerified='0', face_checkOtp='1' WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'");
     
		echo json_encode(array('status'=>'success',"message"=>"OTP ahs been sent successfully "));exit; 
		



}
?>