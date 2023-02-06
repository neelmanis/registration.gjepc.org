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
    $registration_id = intval(filter($row['registration_id']));
	  /*	$sqlExhibitor = "select * from exh_reg_payment_details where uid='$registration_id' and `year`='2019' AND allow_visitor='N' order by payment_id desc limit 0,1";
        $ansExhibitor = $conn ->query($sqlExhibitor);
        $rowExhibitor=$ansExhibitor->num_rows;
        if($rowExhibitor>0){
	    echo json_encode($data = array("status"=>'exhibitor')); exit;
        } */
		
		$quota = "select quota from registration_master where id='$registration_id'";
		$quotaQuery = $conn->query($quota);
		$quotaResult = $quotaQuery->fetch_assoc();
		$visitor_Badges_avail = $quotaResult['quota'];
		
		$temp = $conn->query("SELECT * FROM `visitor_order_temp` WHERE `registration_id`='$registration_id'");
		$Enum_temp = $temp->num_rows;
		
		$Equery = $conn->query("SELECT * FROM `visitor_order_history` WHERE registration_id='$registration_id' AND `status`='1' AND (payment_made_for='signature2') AND payment_status='Y'");
		$Enum_live = $Equery->num_rows;
		$Enum=$Enum_temp+$Enum_live;
		
		if($Enum!=0){ $visitor_Badges_taken=$Enum; } else { $visitor_Badges_taken=0; }
		//echo $visitor_Badges_avail."--".$visitor_Badges_taken;
		if($visitor_Badges_avail<=$visitor_Badges_taken)
		{
			echo json_encode($data = array("status"=>'quotafull')); exit;
		}	
		
		$sqlData = "select * from registration_master where id='$registration_id' AND approval_status='D'";
        $ansData = $conn ->query($sqlData);
        $rowData=$ansData->num_rows;
        if($rowData>0){
	    echo json_encode($data = array("status"=>'companyData')); exit;
        }
		
		$newx = "SELECT * from visitor_directory where pan_no='$pan_number' AND visitor_approval='Y'";
		$query=$conn ->query($newx);
		$lettersinDB = array();
			while($rows = $query->fetch_assoc()){
			array_push($lettersinDB,array('visitor_id'=>$rows['visitor_id'],'name'=>$rows['name']));
		}
		
		//$checkHistory = "SELECT * FROM `visitor_order_history` WHERE visitor_id='$visitorID' AND (`show`='iijs' OR `show`='signature')  AND `status`='1' AND payment_status='Y'";
		//$checkHistory = "SELECT * FROM `visitor_order_history` WHERE visitor_id='$visitorID' AND (`show`='signature2')  AND `status`='1' AND payment_status='Y'";
		$checkHistory = "SELECT * FROM `visitor_order_history` WHERE visitor_id='$visitorID' AND (payment_made_for='signature2') AND `status`='1' AND payment_status='Y'";
		$getQuery = $conn ->query($checkHistory);
		$checkResult = $getQuery->num_rows;
		$gotcommaid = array();
		while($checkQuery = $getQuery->fetch_assoc()){
		//$gotcommaid = explode(",",$checkQuery['visitor_id']);
			array_push($gotcommaid,explode(",",$checkQuery['visitor_id']));															
		}
		//print_r($gotcommaid);
		$finalvisitoridarray = array();
		foreach($gotcommaid as $k => $v){
			$finalvisitoridarray = array_merge($finalvisitoridarray,$v);
		}
		//print_r($finalvisitoridarray);
		//print_r($gotcommaid);
		foreach($lettersinDB as $option_value)
		{ //echo '<pre>'; print_r($option_value);								
			if(in_array($option_value['visitor_id'], $finalvisitoridarray)) {
				$data = array("status"=>'paymentAlreadyDone');
				echo json_encode($data); exit;
			}
		}
	//	if($combo=="N" || $combo==NULL){
		if($status =='Y'){
      
      $vaccine = $conn->query("SELECT `approval_status` FROM `visitor_lab_info` WHERE `visitor_id`='$visitorID' AND `registration_id`='$registration_id' AND `category_for`='VIS'");
   		$countVaccine = $vaccine->num_rows;
   		if($countVaccine>0){
   			$rowVaccine = $vaccine->fetch_assoc();
        $vaccineStatus = $rowVaccine['approval_status'];
        if($vaccineStatus=="U"){
        	$data = array("status"=>'warning',"message"=>"Your vaccination certificate approval is pending");
        }else{
          $_SESSION['registration_id'] = $row['registration_id']; 
					$_SESSION['visitor_id'] = $row['visitor_id'];
       	  $data = array("status"=>'success',"company"=>$company, "mobile"=>$mobile,"email"=>$email,"name"=>$name,"lname"=>$lname,"photo"=>$photo,"reg_id"=>$reg_id,"designation"=>$designation);
        }
   		}else{
   				$_SESSION['registration_id'] = $row['registration_id']; 
			    $_SESSION['visitor_id'] = $row['visitor_id'];
       	  $data = array("status"=>'success',"company"=>$company, "mobile"=>$mobile,"email"=>$email,"name"=>$name,"lname"=>$lname,"photo"=>$photo,"reg_id"=>$reg_id,"designation"=>$designation);
   		}

		}else if($status =='D'){
        $message = "Dear ".$name.", Kindly update your data";		
		//get_data($message,$mobile_no);
		$_SESSION['registration_id'] = $row['registration_id']; 
		$_SESSION['visitor_id'] = $row['visitor_id'];
        $data = array("status"=>'disapproved');
		}else if($status =='P'){
		$data = array("status"=>'pending');	
		}else if($status =='U'){
		$data = array("status"=>'updated');	
		}
	/*}else{
		$data = array("status"=>'combo');	
	} */
		
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
        $otp = rand(1000,9999); // generate OTP	
		$message = "One Time Password for Visitor Verification is ".$otp.", Regards GJEPC";
		$otp_sendStatus = get_data($message,$mobile_no); //Send OTP
		if($otp_sendStatus){
      
			$getMobile = "SELECT mobile_no FROM visitor_mobileotpverification WHERE mobile_no='$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id'";
			  $getMobileResult = $conn->query($getMobile);
			  $countMobile = $getMobileResult->num_rows;
			 /*echo "INSERT INTO visitor_mobileotpverification SET mobile_no='$mobile_no',otp='$otp',verified ='0',post_date='$datetime'";exit;*/
			 if($countMobile>0){

             $UpdateMobileOtp = $conn->query("UPDATE visitor_mobileotpverification SET otp='$otp',verified ='0',modifiedDate='$datetime',isSecondary='$is_secondary' WHERE mobile_no='$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id'");
		    
			 } else {
			 	// echo "INSERT INTO visitor_mobileotpverification SET mobile_no='$mobile_no',otp='$otp',verified ='0',post_date='$datetime',registration_id='$registration_id',visitor_id='$visitor_id',isSecondary='$is_secondary'";exit;
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

		$otp = rand(1000,9999); // generate OTP	
		$message = "One Time Password for Visitor Verification is ".$otp.", Regards GJEPC";
		$otp_sendStatus = get_data($message,$mobile_no); // Send OTP
		if($otp_sendStatus){
      
			 $getMobile = "SELECT mobile_no FROM visitor_mobileotpverification WHERE mobile_no='$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id'";
			  $getMobileResult = $conn->query($getMobile);
			  $countMobile = $getMobileResult->num_rows;
			 /*echo "INSERT INTO visitor_mobileotpverification SET mobile_no='$mobile_no',otp='$otp',verified ='0',post_date='$datetime'";exit;*/
			 if($countMobile>0){

             $UpdateMobileOtp = $conn->query("UPDATE visitor_mobileotpverification SET otp='$otp',verified ='0',modifiedDate='$datetime',isSecondary='$is_secondary' WHERE mobile_no='$mobile_no' AND visitor_id='$visitor_id' AND registration_id = '$registration_id'");
		    
			 }else{
               $InsertMobileOtp = $conn->query("INSERT INTO visitor_mobileotpverification SET mobile_no='$mobile_no',otp='$otp',verified ='0',post_date='$datetime',registration_id='$registration_id',visitor_id='$visitor_id',isSecondary='$is_secondary'");
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
    $updateSecondary =  $conn->query("UPDATE visitor_directory SET secondary_mobile='$mobile_no_otp' WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'");
   }

   /*GET VACCINE STATUS*/
  
   $vaccine = $conn->query("SELECT `approval_status` FROM `visitor_lab_info` WHERE `visitor_id`='$visitor_id' AND `registration_id`='$registration_id' AND `category_for`='VIS'");
   $countVaccine = $vaccine->num_rows;
   if($countVaccine>0){
     $rowVaccine = $vaccine->fetch_assoc();
     $vaccineStatus = $rowVaccine['approval_status'];
     $_SESSION['isMobileVerified'] = "YES";
     if($vaccineStatus =='Y'){

      $data = array("status"=>'success',"redirect"=>"vis_registration");
     }elseif($vaccineStatus =='N'){
     	$_SESSION['vaccineStatusMessage'] = "Your Vaccine/RT-PCR certificate is Disapproved Please upload again";
      $_SESSION['requestFor'] = "covid-report";
      $data = array("status"=>'success',"redirect"=>"covid-report");
     }elseif($vaccineStatus =='U'){
     
      $data = array("status"=>'error',"msg"=>"Your Vaccination certificate is not approved.");
     }else{
      $_SESSION['vaccineStatusMessage'] = "Your Vaccine/RT-PCR certificate is pending Please upload";
      $_SESSION['requestFor'] = "covid-report";
      $data = array("status"=>'success',"redirect"=>"covid-report");
          
     }
   }else{
   
    $_SESSION['requestFor'] = "covid-report";
    $_SESSION['vaccineStatusMessage'] = "Your Vaccine/RT-PCR certificate is pending Please upload";
    $data = array("status"=>'success',"redirect"=>"covid-report");
   }
    
   
        }else{
    $data = array("status"=>'fail');
    }
    echo json_encode($data); 
}

if($action == 'singleVisitorRegistration'){
$registration_id = $_SESSION['registration_id'];

if(empty($registration_id)){
  header("location:single_visitor.php");
}
$visitor_id = trim($_POST['visitor_id']);

$quota = "select quota from registration_master where id='$registration_id'";
$quotaQuery = $conn->query($quota);
$quotaResult = $quotaQuery->fetch_assoc();
$visitor_Badges_avail = $quotaResult['quota'];

$temp = $conn->query("SELECT * FROM `visitor_order_temp` WHERE `registration_id`='$registration_id'");
$Enum_temp = $temp->num_rows;

$Equery = $conn->query("SELECT * FROM `visitor_order_history` WHERE registration_id='$registration_id' AND `status`='1' AND (payment_made_for='signature2') AND payment_status='Y'");
$Enum_live = $Equery->num_rows;
$Enum=$Enum_temp+$Enum_live;

if($Enum!=0){ $visitor_Badges_taken=$Enum; } else { $visitor_Badges_taken=0; }
//echo $visitor_Badges_avail."--".$visitor_Badges_taken;
if($visitor_Badges_avail<=$visitor_Badges_taken)
{
	echo json_encode(array("status"=>"error","message"=>"Registration quota is already full for your company"));exit;
}
$payment_made_for = $_POST['payment_made_for'];
$amount = trim($_POST['participation_fee']);
$show = "signature2";
$year = "2021";
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
if($num<=0)
{ $orderId = 'vis1'; }
else
{
  $orderId='SIGN21'.$strNo;
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

	} else {
	$ins = "INSERT INTO `visitor_order_temp`(`registration_id`, `visitor_id`,`orderId`, `payment_made_for`, `amount`,`show`, `year`, `status`,`paymentThrough`) VALUES ('$registration_id','$visitor_id','$orderId','$payment_made_for','$amount','$show','$year','1','single')";
	$insert = $conn->query($ins);
	} 
}
}
	
	if(!is_numeric($amount) || !is_numeric($registration_id)){
		echo json_encode(array('status'=>'invalidAmount'));exit; 
	}
    	/* Check session_id and Amount start*/
	if(isset($registration_id) && $registration_id!="")
	{
	$sqlP = "select amount,payment_made_for from visitor_order_temp where registration_id='$registration_id' AND `show`='$show' AND `year`='$year' AND `orderId`='$orderId' AND paymentThrough='single'"; 
	$queryP = $conn->query($sqlP);
	$resultP = $queryP->fetch_assoc();
	$temp_total_amount = trim($resultP['amount']);
	$payment_made_for = trim($resultP['payment_made_for']);
	//echo $temp_total_amount."---".$total_payable;exit;
		
		if($temp_total_amount==$amount)
		{
		
		/* For Machinery Start
		if($payment_made_for=="igjme" && $temp_total_amount==0)
		{
		if(isset($delivery_id) && !empty($delivery_id)) {
				
		 $sqlx3 = "INSERT `visitor_order_detail` SET `type_of_member`='$type_of_member',`delivery_id`='$delivery_id',`billing_delivery_id`='$billing_delivery_id' , `regId`='$registration_id' , `orderId`='$orderId' , `paymentThrough`='single',`payment_type`='free',`total_payable`='$amount',`create_date`='$post_date',year='2020',event='$show'"; 
		$result2 = $conn->query($sqlx3);
		} else {
		echo json_encode(array('status'=>'emptyAddress'));exit; 
			
		}
		
		if($result2){ 
		echo json_encode(array('status'=>'machinerySuccess'));exit; 
		 }		
		// For Machinery End 
		} */ 
		
	/*	if($payment_made_for==$show && $temp_total_amount==0)
		{			
		$sqlx3 = "INSERT `visitor_order_detail` SET `type_of_member`='$type_of_member',`delivery_id`='$delivery_id',`billing_delivery_id`='$billing_delivery_id' , `regId`='$registration_id' , `orderId`='$orderId' , `paymentThrough`='single',`payment_type`='free',`total_payable`='$amount',`create_date`='$post_date',year='$year',event='$show',agree='$agree'"; 
		$result2 = $conn->query($sqlx3);		
		if($result2){ 
		echo json_encode(array('status'=>'vbsmSuccess'));exit; 
		} <!- For VBSM End -->		
		} */
		
		if($temp_total_amount==0)
		{			
		$sqlx3 = "INSERT `visitor_order_detail` SET `type_of_member`='$type_of_member',`delivery_id`='$delivery_id',`billing_delivery_id`='$billing_delivery_id', `regId`='$registration_id' , `orderId`='$orderId' , `paymentThrough`='single',`payment_type`='free',`total_payable`='$amount',`create_date`='$post_date',year='$year',event='$show',agree='$agree'"; 
		$result2 = $conn->query($sqlx3);		
		if($result2){ 
			$_SESSION['isFree'] = "yes";
		echo json_encode(array('status'=>'sign2Success'));exit; 
		}
		
		} else {
		/* For IIJS Start*/	
		if(isset($delivery_id) && !empty($delivery_id) && !empty($billing_delivery_id) && $delivery_id!='N') {
	    $sqlx2 = "insert into visitor_order_detail set orderId='$orderId',regId='$registration_id',payment_type='$payment_type',total_payable='$amount',create_date='$post_date', paymentThrough='single',year='$year',event='$show',agree='$agree'";
		$result2 = $conn->query($sqlx2);		
		
	   $sqlx3 = "UPDATE `visitor_order_detail` SET `type_of_member`='$type_of_member',`delivery_id`='$delivery_id',`billing_delivery_id`='$billing_delivery_id' WHERE `regId`='$registration_id' AND orderId='$orderId' AND paymentThrough='single' AND event='$show'"; 
		$result3 = $conn->query($sqlx3);
		} else {
		echo json_encode(array('status'=>'emptyAddress')); exit; 			
		}
		
		if($result2){
		echo json_encode(array('status'=>'signatureSuccess')); exit; 
		}
		}
		/* For IIJS End */	
		}  else {
		echo json_encode(array('status'=>'error'));exit; 
		}		
	} else {
		echo json_encode(array('status'=>'sessionExpired'));exit; 
	}
}


/* link */
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
$show = "signature2";
$year = "2021";
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
/*============ Check session_id and Amount start=============*/
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
		/* For Machinery Start*/
		// 	if($payment_made_for=="igjme" && $temp_total_amount==0)
		// 	{
		// 	if(isset($delivery_id) && !empty($delivery_id)) {
		// /*	 $sqlx2 = "insert into visitor_order_detail set orderId='$orderId',regId='$registration_id',payment_type='free',total_payable='$amount',create_date='$post_date',paymentThrough='$type',type_of_member='$type_of_member'";
		// 	 		$result2 = mysql_query($sqlx2);*/
					
		// 	   $sqlx3 = "INSERT `visitor_order_detail` SET `type_of_member`='$type_of_member',`delivery_id`='$delivery_id',`billing_delivery_id`='$billing_delivery_id' , `regId`='$registration_id' , `orderId`='$orderId' , `paymentThrough`='$type',`payment_type`='free',`total_payable`='$amount',`create_date`='$post_date',year='$year',event='$show'"; 
		// 	$result2 = $conn->query($sqlx3);
		// 	} else {
		// 	echo json_encode(array('status'=>'emptyAddress'));exit; 
				
		// 	}
			
		// 	if($result2){ 
			
		// 	echo json_encode(array('status'=>'machinerySuccess'));exit; 
		// 	 }		
		
		// 	}else 
		if($payment_made_for==$show && $temp_total_amount==0)
		{
			$sqlx3 = "INSERT `visitor_order_detail` SET `type_of_member`='$type_of_member',`delivery_id`='$delivery_id',`billing_delivery_id`='$billing_delivery_id' , `regId`='$registration_id' , `orderId`='$orderId' , `paymentThrough`='$type',`payment_type`='free',`total_payable`='$amount',`create_date`='$post_date',year='$year',event='$show',agree='$agree'"; 
			$result2 = $conn->query($sqlx3);
			if($result2){ 
			    echo json_encode(array('status'=>'sign2Success'));exit; 
			}		
		/* For VBSM End */
		}else{
		/* For IIJS Start*/	
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
 $show = "signature2";
 $year = "2021";
 	
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
 $designationType = $row['degn_type'];

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
			 	echo json_encode(array('status'=>'photoFail'));exit; 
			 }elseif ($photo =="invalid") {
			 	echo json_encode(array('status'=>'photoInvalid'));exit; 
			 
			 }
		}
	}else{
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

   $updateSql ="UPDATE visitor_directory SET  mod_date='$mod_date',name='$first_name', lname='$last_name', gender='$gender', aadhar_no='$adhaar_no', mobile='$mobile_no',email='$email_id', pan_no='$pan_no',photo='$photo',salary_slip_copy='$salary',pan_copy='$pan_copy',partner='$partner',visitor_approval='U',isApplied='Y',shows='$show',year='$year',paymentThrough='single',status='1'  WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'";
   $updateResult = $conn->query($updateSql);
   if($updateResult ==TRUE){
   	$message = "Dear ".$first_name.", Welcome to IIJS SIGNATURE 2021, your data for Visitor has been updated successfully, you will be notified on approval/disapproval";
   $_SESSION['successMessage']=$message; 
   	//get_data($message,$mobile_no);
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

if($action == 'AddVisitor'){

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
 $show = "signature2";
 $year = "2021";
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
			if (!file_exists($create_photo)) {
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
			if (!file_exists($create_pan)) {
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
			  if ($salary =="fail") {
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
      $InsertSql = "INSERT visitor_directory SET post_date='$post_date',registration_id='$registration_id', degn_type='$designationType',designation='$designation', name='$first_name', lname='$last_name', gender='$gender', aadhar_no='$adhaar_no', mobile='$mobile_no',email='$email_id', pan_no='$pan_no',photo='$photo',salary_slip_copy='$salary',pan_copy='$pan_copy',isApplied='Y',shows='$show',year='$year',paymentThrough='single',status='1' ";

    }
   
   $InsertResult = $conn->query($InsertSql);
   // $visitor_id = $conn->insert_id;
   //  $insertlabInfo = "INSERT INTO `visitor_lab_info` (`registration_id`, `visitor_id`, `pan_no`, `mobile_no`, `via`,`lab_name`,`location`,`self_report`,`self_declaration`,`certificate`, `status`,`approval_status`) VALUES ('$registration_id', '$visitor_id', '$pan_no', '$mobile_no', 'self','','','$self_report','$self_declaration','$certificate','1','U')";
	  //   $ansData = $conn ->query($sqlx);

   if($InsertResult ==TRUE){

   	$message = "Dear ".$first_name.", Welcome to IIJS PREMIERE 2021, your data for Visitor badge has been updated successfully, you will be notified on approval/disapproval";
   $_SESSION['successMessage']=$message; 
   	//get_data($message,$mobile_no);
   	/*session_unset($registration_id);*/
    echo json_encode(array('status'=>'insertSuccess'));exit; 
   }
}
?>