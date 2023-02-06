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
		$face_status = $row['visitor_approval'];
		$combo = $row['combo'];
		$visitorID = $row['visitor_id']; 

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
		/*
	  	$sqlExhibitor = "select * from exh_reg_payment_details where uid='$registration_id' AND  (`show`='iijs22' OR `show`='signature23' OR `show`='iijstritiya23' OR `show`='combo23' OR `show`='igjme22') AND `year`='$year' AND allow_visitor='N' order by payment_id desc limit 0,1";
        $ansExhibitor = $conn ->query($sqlExhibitor);
        $rowExhibitor=$ansExhibitor->num_rows;
        if($rowExhibitor>0){
	    echo json_encode($data = array("status"=>'exhibitor')); exit;
        } */

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
		
		$checkHistory = "SELECT * FROM `visitor_order_history` WHERE visitor_id='$visitorID' AND (payment_made_for='combo23' OR payment_made_for='iijs22' OR payment_made_for='iijssignature22' OR payment_made_for='igjme22' OR payment_made_for='iijstritiya23')  AND `status`='1' AND payment_status='Y'";
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
				$data = array("status"=>'warning', "message"=>"You are not registered for the show.");
				echo json_encode($data); exit;
			}
		} 

		/*=================== PAYMENT CHECK AND STOP CODE ================================*/

		if($status =='Y' || $status =='D'){
		$_SESSION['registration_id'] = $row['registration_id']; 
			    $_SESSION['visitor_id'] = $row['visitor_id'];
       	  $data = array("status"=>'success',"company"=>$company, "mobile"=>$mobile,"email"=>$email,"name"=>$name,"lname"=>$lname,"photo"=>$photo,"reg_id"=>$reg_id,"visitor_id"=>$visitorID,"designation"=>$designation,"showHistory"=>$showHistory);
    
		
		}else if($status =='P'){
		$data = array("status"=>'pending');	
		}else if($status =='U'){
		$data = array("status"=>'warning',"message"=>"Your details are updated please wait for approval.");	
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
				$UpdateMobileOtp = $conn->query("UPDATE visitor_mobileotpverification SET otp='$otp',verified ='0',modifiedDate='$datetime',isSecondary='N' WHERE mobile_no='$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id'");
				}else{
				$InsertMobileOtp = $conn->query("INSERT INTO visitor_mobileotpverification SET mobile_no='$mobile_no',otp='$otp',verified ='0',post_date='$datetime',registration_id='$registration_id',visitor_id='$visitor_id',isSecondary='N'");
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
    $_SESSION['isMobileVerified'] = "YES";
    $data = array("status"=>'success',"redirect"=>"vis_registration");

    } else {
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

	// IF PAID FOR PREMIERE
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
?>