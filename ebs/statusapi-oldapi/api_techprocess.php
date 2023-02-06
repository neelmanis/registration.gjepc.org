<?php
ob_start();
session_start();
include('../../db.inc.php');
include('../../functions.php');
if($_SERVER['REQUEST_METHOD'] == "POST"){

$json = file_get_contents('php://input');
$obj = json_decode($json,True);
echo $orderId= $obj["orderId"];exit;

$strNo = rand(1,10000000);
date_default_timezone_set('Asia/Calcutta');
$strCurDate = date('d-m-Y');

require_once 'TransactionRequestBean.php';
require_once 'TransactionResponseBean.php';

$date=date("Y-m-d");

//$q=mysql_query("select * from visitor_order_detail where payment_status='P' AND regId='$registration_id'");
//$q=mysql_query("select * from visitor_order_detail where payment_status='P' and create_date='$date'");
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
	$show ="signature2";
	$year = 2021;
    //Setting all values here
    $transactionRequestBean->setMerchantCode("L278776");
    $transactionRequestBean->setAccountNo($val['tpvAccntNo']);
    $transactionRequestBean->setITC("NIC~TXN0001~122333~rt14154~8 mar 2014~Payment~forpayment");
    $transactionRequestBean->setMobileNumber();
    $transactionRequestBean->setCustomerName();
    $transactionRequestBean->setRequestType("O");
    $transactionRequestBean->setMerchantTxnRefNumber($mrctTxtID);
    $transactionRequestBean->setAmount();
    $transactionRequestBean->setCurrencyCode("INR");
    $transactionRequestBean->setReturnURL($returnURL);
    $transactionRequestBean->setS2SReturnURL($s2SReturnURL);
    $transactionRequestBean->setShoppingCartDetails("Test_1.0_0.0");
    $transactionRequestBean->setTxnDate($txnDate);
    $transactionRequestBean->setBankCode();
    $transactionRequestBean->setTPSLTxnID($tpsl_txn_id);
    $transactionRequestBean->setCustId($val['custID']);
    $transactionRequestBean->setCardId($val['cardID']);
    $transactionRequestBean->setKey("4681267225TDBCEB");
    $transactionRequestBean->setIv("7944996633RXRYHY");
    $transactionRequestBean->setWebServiceLocator("https://www.tpsl-india.in/PaymentGateway/TransactionDetailsNew.wsdl");
    $transactionRequestBean->setMMID();
    $transactionRequestBean->setOTP();
    $transactionRequestBean->setCardName();
    $transactionRequestBean->setCardNo();
    $transactionRequestBean->setCardCVV();
    $transactionRequestBean->setCardExpMM();
    $transactionRequestBean->setCardExpYY();
    $transactionRequestBean->setTimeOut();

    $url = $transactionRequestBean->getTransactionToken();

    $responseDetails = $transactionRequestBean->getTransactionToken();
    $responseDetails = (array)$responseDetails;
    $response = $responseDetails[0];
    if(is_string($response) && preg_match('/^msg=/',$response)){
        $outputStr = str_replace('msg=', '', $response);
        $outputArr = explode('&', $outputStr);
        $str = $outputArr[0];

        $transactionResponseBean = new TransactionResponseBean();
        $transactionResponseBean->setResponsePayload($str);
        $transactionResponseBean->setKey($val['key']);
        $transactionResponseBean->setIv($val['iv']);

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
	
	if($txn_status=="0300"){
	//if($txn_status=="mukesh"){
		$saveSuccessMsg = "Transaction Success In Db";
		$orderId=$clnt_txn_ref;
		echo $orderUpdate ="update visitor_order_detail set payment_status='Y',txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id',paymentThrough='API' where orderId='$clnt_txn_ref' AND regId='$registration_id'";
		echo "<br/>";
		$getResult = $conn->query($orderUpdate);
		if(!$getResult) { die('Error: ' . $conn->error); }
		
		$getapplication ="SELECT total_payable FROM `visitor_order_detail` WHERE `regId` = '$registration_id' AND orderId='$orderId' AND payment_status='Y'";
		$getApplicationResult = $conn->query($getapplication);
		$getApplicationRow = $getApplicationResult->fetch_assoc();
		$total_payable = $getApplicationRow['total_payable'];
		$total_payable_word = number_word_v($total_payable);
				
		$ssx = "SELECT * FROM `visitor_order_temp` WHERE `registration_id`='$registration_id' AND `show`='$show' AND orderId='$orderId' AND `year`='$year' AND `paymentThrough`='online'";
		$query_result=$conn->query($ssx);
		while($result1=$query_result->fetch_assoc())
		{ //echo '<pre>'; print_r($result1);
			$visitor_id = $result1['visitor_id'];
			$payment_made_for = $result1['payment_made_for'];		
			$amount = $result1['amount'];
			$show = $result1['show'];
			$year = $result1['year'];
		
		$sqlx1 = "INSERT INTO `visitor_order_history`(`create_date`, `registration_id`, `orderId`,`visitor_id`, `payment_made_for`, `amount`,`show`, `year`,`payment_status`, `status`) VALUES (NOW(),'$registration_id','$orderId','$visitor_id','$payment_made_for','$amount','$show','$year','Y','1')";
		$result = $conn->query($sqlx1);
		if($result){
		$updatx = "DELETE FROM `visitor_order_temp` WHERE `registration_id`='$registration_id' AND `visitor_id` ='$visitor_id' AND `show`='$show' AND `year`='$year' AND `paymentThrough`='online'";
		$resultx = $conn->query($updatx);
		} else { echo "something error"; }
		}
		if($resultx){
		/*Send Email Receipt to Company */
	$message ='<table class="table2" width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">	
    <tbody>    
    	<tr>
            <td align="left"><img id="ri" src="https://iijs-signature.org/images/gjepc_logo_resize.png">
            <td align="center"> <img id="mi"> </td>
            <td align="right"><img id="ri" src="https://registration.gjepc.org/images/mailer/iijslogo-2020.png"></td>
            </td>                        
		</tr>
        <tr>
            <td align="center" colspan="3">
                <p style="line-height:25px;">
                    <h3 style="margin: 5px;">THE GEM JEWELLERY EXPORT PROMOTION COUNCIL</h3>
                    <b>GJEPC-H.O.-MUMBAI:1st Flr, Tower A,G Block, BDB, Bandra-Kurla Complex, Bandra(E)-400 051</b><br>
                    <b>GJEPC-E.X.-MUMBAI:G2-A, Trade Center, Bandra-Kurla Complex, Bandra(E)-400 051</b><br>
					<b>Toll Free Number :</b> 1800-103-4353, <b>Missed Call Number :</b> +91-7208048100
<br>Website: https://iijs.org Email: visitors@gjepcindia.com</p>
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
                    <td width="75%">'.$company_name.'</td>
                </tr>
                <tr>
                    <td width="20%">Rupees: </td>
                    <td width="75%">'.$total_payable.' ('.$total_payable_word.')</td>
                </tr>
				<tr>
                    <td width="20%">Events: </td>
                    <td width="75%">IIJS PREMIERE</td>
                </tr>
                <tr>
                <td width="100%" colspan="2">
                    <h4 style="text-align: center; width: 100%; padding-top: 30px; margin: 0;">This is a computer generated receipt requires no signature. Invoice as per GST Format would be dispatched seperately.</h4>
                </td>
            </tr>
            </table>
		</td>            
        </tr>   
           <style type="text/css">
           .table2 input{width: 80%;border-left: none; border-right: none; border-top: none; border-bottom: 1px solid #000;}
               .table1 input{border-left: none; border-right: none; border-top: none; border-bottom: 1px solid #000; width: 150px;}         
            .table2 h4{text-align: center;}
           </style>
	</tbody>
	</table>';	
		
		//$to =$data['email'];
		//$to =$email.",visitors@gjepcindia.com";
		$subject = "Thank you for registering at IIJS PREMIERE 2020 Show"; 
		$headers  = 'MIME-Version: 1.0' . "\n"; 
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		$headers .= 'From: IIJS PREMIERE 2020 <admin@gjepc.org>';			
		mail($to, $subject, $message, $headers);
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
