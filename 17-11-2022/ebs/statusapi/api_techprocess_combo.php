<?php
ob_start();
session_start();
include('../../db.inc.php');
include('../../functions.php');
if($_SERVER['REQUEST_METHOD'] == "POST"){

$json = file_get_contents('php://input');
$obj = json_decode($json,True);
$orderId = $obj["orderId"];

$strNo = rand(1,10000000);
date_default_timezone_set('Asia/Calcutta');
$strCurDate = date('d-m-Y');

require_once 'TransactionRequestBean.php';
require_once 'TransactionResponseBean.php';

$date=date("Y-m-d");

$q=$conn->query("select * from visitor_order_detail where orderId='$orderId'");
while($r=$q->fetch_assoc()){

	$iv = "7944996633RXRYHY";
	$key = "4681267225TDBCEB";

    $_SESSION['iv'] = $iv;
    $_SESSION['key']   = $key;
	
    $transactionRequestBean = new TransactionRequestBean();
	
	$returnURL="http://".$_SERVER["HTTP_HOST"].$_SERVER['SCRIPT_NAME'];
	$s2SReturnURL="https://tpslvksrv6046/LoginModule/Test.jsp";
	
	//$tpsl_txn_id=$r['regId'];
	$mrctTxtID=$r['orderId'];
	$tpsl_txn_id="";
	$txnDate=date('d-m-Y',strtotime($r['create_date']));
	$registration_id=$r['regId'];
	
	$email=getUserEmail($registration_id,$conn);
	$company_name=getCompanyName($registration_id,$conn);
		
	//$show ="iijs22";
	//$year = 2022;
    //Setting all values here
    $transactionRequestBean->merchantCode = "L278776";
    $transactionRequestBean->accountNo = "";
    $transactionRequestBean->ITC = "NIC~TXN0001~122333~rt14154~8 mar 2014~Payment~forpayment";
    $transactionRequestBean->mobileNumber = "";
    $transactionRequestBean->customerName = "";
    $transactionRequestBean->requestType = "O";
	$transactionRequestBean->merchantTxnRefNumber = "$mrctTxtID";
    $transactionRequestBean->amount = "";
    $transactionRequestBean->currencyCode = "INR";
    $transactionRequestBean->returnURL = "$returnURL";
    $transactionRequestBean->s2SReturnURL = "$s2SReturnURL";
    $transactionRequestBean->shoppingCartDetails = "Test_1.0_0.0";
    $transactionRequestBean->txnDate = "$txnDate";
    $transactionRequestBean->bankCode = "";
    $transactionRequestBean->TPSLTxnID = "$tpsl_txn_id"; 
    $transactionRequestBean->custId = "";
    $transactionRequestBean->cardId = "600000000";
    $transactionRequestBean->key = "4681267225TDBCEB";
    $transactionRequestBean->iv = "7944996633RXRYHY";
    $transactionRequestBean->webServiceLocator = "https://www.tpsl-india.in/PaymentGateway/TransactionDetailsNew.wsdl";
    $transactionRequestBean->MMID = "";
    $transactionRequestBean->OTP = "";
    $transactionRequestBean->cardName = "";
    $transactionRequestBean->cardNo = "";
    $transactionRequestBean->cardCVV = "";
    $transactionRequestBean->cardExpMM = "";
    $transactionRequestBean->cardExpYY = "";
    $transactionRequestBean->timeOut = "";

    $url = $transactionRequestBean->getTransactionToken();
	//print_r($url);exit;

    $responseDetails = $transactionRequestBean->getTransactionToken();
    $responseDetails = (array)$responseDetails;
	//print_r($responseDetails);exit;
    $response = $responseDetails[0];
	//print_r($response); exit;
    if(is_string($response) && preg_match('/^msg=/',$response)){
        $outputStr = str_replace('msg=', '', $response);
        $outputArr = explode('&', $outputStr);
        $str = $outputArr[0];

        $transactionResponseBean = new TransactionResponseBean();
        $transactionResponseBean->setResponsePayload($str);
        $transactionResponseBean->setKey('4681267225TDBCEB');
        $transactionResponseBean->setIv('7944996633RXRYHY');

        $response = $transactionResponseBean->getResponsePayload();
    }elseif(is_string($response) && preg_match('/^txn_status=/',$response)){}
	
	
	/*echo "<pre>";
	echo $mrctTxtID;echo "<br/>";
	*/
	$pipeResponse = explode('|',$response);
	//echo "<pre>"; print_r($pipeResponse); exit;
	
	$txnStatus 	= $pipeResponse[0];
	$txnMsg    	= $pipeResponse[1];
	$txnErrMsg  = $pipeResponse[2];
	$clntTxnRef = $pipeResponse[3];
	$tpslTxnId = $pipeResponse[5];
	$tpsl_TrascTime = $pipeResponse[7];
	
	$txnStatusMsg = explode('=',$txnStatus);
	$txnMsgs 	  = explode('=',$txnMsg);
	$txnErr_Msg   = explode('=',$txnErrMsg);
	$clntTxnRef_Msg   = explode('=',$clntTxnRef);
	$tpslTxnId_Msg   = explode('=',$tpslTxnId);
	$tpsl_TrascTime_Msg   = explode('=',$tpsl_TrascTime);
	
	$txn_status   = $txnStatusMsg[1]; 
	$txn_msg 	  = $txnMsgs[1]; 
	$txn_err_msg  = $txnErr_Msg[1]; //if(failure) txn_err_msg=Cancelled_BY_User 	if(success)txn_err_msg=NA
	$clnt_txn_ref = $clntTxnRef_Msg[1]; //Merchant Reference Number i.e. orderID
	$tpsl_txn_id = $tpslTxnId_Msg[1]; 
	$tpsl_txn_time = $tpsl_TrascTime_Msg[1]; //Merchant Reference Number i.e. orderID
	$paydate = date_create($tpsl_txn_time);
	$paymentDate = date_format($paydate,"d-m-Y");
	
	
	if($txn_status=="0300"){
		$saveSuccessMsg = "Transaction Success In Db";
		$orderId=$clnt_txn_ref;
		$orderUpdate ="update visitor_order_detail set payment_status='Y',txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id',paymentThrough='API' where orderId='$clnt_txn_ref' AND regId='$registration_id'";
		$getResult = $conn->query($orderUpdate);
		if(!$getResult) { die('Error: ' . $conn->error); }
		
		$getapplication ="SELECT total_payable FROM `visitor_order_detail` WHERE `regId` = '$registration_id' AND orderId='$orderId' AND payment_status='Y' ";
		$getApplicationResult = $conn->query($getapplication);
		$getApplicationRow = $getApplicationResult->fetch_assoc();
		$total_payable = $getApplicationRow['total_payable'];
		$total_payable_word = number_word_v($total_payable);
				
		$ssx = "SELECT * FROM `visitor_order_temp` WHERE `registration_id`='$registration_id' AND orderId='$orderId' ";
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
		
		$company_name = trim(getCompanyName($registration_id,$conn));
		
		$digits = 9;	
	    $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
	    $checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");
	    $countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
		while($countUniqueIdentifier > 0) {
		$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		}
		
		$checkGlobalRecord = "SELECT * FROM globalExhibition WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `pan_no`='$visitorPAN' AND participant_Type='VIS'";
		$globalResult = $conn->query($checkGlobalRecord);
        $checkGlobalCount = $globalResult->num_rows;
	    if($checkGlobalCount>0){
			
		} else { 
		$insertGlobal = "INSERT INTO globalExhibition  SET `uniqueIdentifier`='$uniqueIdentifier',`registration_id`='$registration_id',`visitor_id`='$visitor_id',`fname`='$name',`mobile`='$visitorMobile',`pan_no`='$visitorPAN',`designation`='$visitorDesignation',`company`='$company_name',`photo_url`='$photo_url',`participant_type`='VIS',`covid_report_status`='pending',`days_allow`='$days_allow',`status`='P',`event`='$payment_made_for'";
		$insertGlobalResult = $conn->query($insertGlobal);
		
		/*Start to check last year vaccination status 		
		$modified_at = date("Y-m-d H:i:s");
		$checkData = "SELECT * FROM visitor_lab_info WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'" ;
		$resultData =$conn->query($checkData);
		$countData =  $resultData->num_rows;
		$rowx = $resultData->fetch_assoc();
		$certificate = $rowx['certificate'];
		
		$approval_status = $rowx['approval_status'];
		$dose2_status = $rowx['dose2_status'];
		if($dose2_status =="Y"){
		  $approval_status = "Y";
		} else {
		  $approval_status = "P";
		}
		
		$dose1_status = $rowx['dose1_status'];
		$dose2_status = $rowx['dose2_status'];
		
			if($countData > 0){
			if($certificate =='dose1'){
		
				$updateCovidStatus = "UPDATE globalExhibition SET `status`='P',`certificate`='$certificate',`dose1_status`='$dose1_status',`modified_date`='$modified_at' WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `participant_Type`='VIS' AND event='$payment_made_for' ";
			$resultStatusUpdate = $conn->query($updateCovidStatus);
			} else {				
				$updateCovidStatus = "UPDATE globalExhibition SET `status`='$approval_status',`certificate`='$certificate',`dose2_status`='$dose2_status',`modified_date`='$modified_at' WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `participant_Type`='VIS' AND event='$payment_made_for' ";
			$resultStatusUpdate = $conn->query($updateCovidStatus);
			}
			} 
		 Stop to check last year vaccination status */
		}
		/*Global Table End */

		
		$sqlx1 = "INSERT INTO `visitor_order_history`(`create_date`, `registration_id`, `orderId`,`visitor_id`, `payment_made_for`, `amount`,`show`, `year`,`payment_status`,`paymentThrough`,`status`) VALUES (NOW(),'$registration_id','$orderId','$visitor_id','$payment_made_for','$amount','$show','$year','Y','single','1')";
		$result = $conn->query($sqlx1);
		if($result){
		$updatx = "DELETE FROM `visitor_order_temp` WHERE `registration_id`='$registration_id' AND `visitor_id` ='$visitor_id' AND `show`='$show' AND `year`='$year'";
		$resultx = $conn->query($updatx);
		} else { echo "something error"; }
		}
		if($resultx){
		/*Send Email Receipt to Company */
		
		$sql_event = "SELECT * FROM `visitor_event_master` WHERE `status` ='1' AND `shortcode` = '".$payment_made_for."'";
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
	/*	
		$message ='<table class="table2" width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">	
    <tbody>    
    	<tr>
            <td align="left"><img id="ri" src="https://registration.gjepc.org/images/logo.png"></td>                       
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
                <td style="padding:0 60px;" align="right">Date: '.$paymentDate.'</td>
                </tr>                    
                </table>

                <table class="table2"width="100%" style="font-family:Arial, sans-serif; color:#333333; font-size:13px;" cellpadding="10">
                <tr>
                    <td width="20%">Received with Thanks From M/s: </td>
                    <td width="75%">'.$company_name.'</td>
                </tr>
                <tr>
                    <td width="20%">Rupees: </td>
                    <td width="75%">'.$total_payable.' ('.$total_payable_word.')</td>
                </tr>
				<tr>
                    <td width="20%">Events: </td>
                    <td width="75%">'.$event_name.'</td>
                </tr>
				<tr>
                 <td width="100%" colspan="2">
                    <p style="text-align: left; width: 100%; padding-top: 10px; margin: 0;">
                 <strong>We thank you for your visitor registration for '.$event_name.'. All the visitors visiting the exhibition should be fully vaccinated. 
					<br/>For further assistance you may please feel free to contact us on 1800-103-4353 / OR give us missed call on +91-7208048100; or write to us on visitors@gjepcindia.com.</strong></p>				
                </td>
				</tr>
                <tr>
                <td width="100%" colspan="2">
                    <h4 style="text-align: center; width: 100%; padding-top: 30px; margin: 0;">This is a computer generated receipt requires no signature. Invoice as per GST Format would be dispatched separately.</h4>
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
		
		//$to =$data['email']; 
		$to = 'neelmani@kwebmaker.com';
		$to = $email;
		$subject = "Thank you for registering at ".$event_name.""; 
		$cc = "";
		$email_array = explode(",",$to);
		send_mailArray($email_array,$subject,$message,$cc);
		*/
		/*  Email End */
		}	
  }
	header('Content-type: application/json');
	echo json_encode(array("Response"=>$response));
	//print_r($response);
    ob_flush();
}
}
?>
