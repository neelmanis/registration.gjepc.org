<?php
ob_start();
session_start();
include('../../db.inc.php');
include('../../functions.php');


$strNo = rand(1,1000000);
date_default_timezone_set('Asia/Calcutta');
$strCurDate = date('d-m-Y');

require_once 'TransactionRequestBean.php';
require_once 'TransactionResponseBean.php';
$Create_Date=date('Y-m-d h:i:s'); 
$Current_Date=date('Y-m-d'); 

//$q=$conn->query("select * from manual_signature.iijs_payment_master where Form_ID='3' and Payment_Master_Approved='P'");

$Payment_Master_OrderNo=$_REQUEST['orderID'];
$sql="select * from manual_signature.iijs_payment_master where Form_ID='3' and Payment_Master_OrderNo='$Payment_Master_OrderNo'";
$q=$conn->query($sql);
while($r=$q->fetch_assoc()){

	$iv = "2955127737GHMHLJ";
	$key = "6601479866KJRBVG";
	
	/*.................................Get RegID......................................*/
	$Exhibitor_Code=$r['Exhibitor_Code'];
	$qregID=$conn->query("select * from iijs_exhibitor where Exhibitor_Code='$Exhibitor_Code'");
	$rregID=$qregID->fetch_assoc();
	$registration_id=$rregID['Exhibitor_Registration_ID'];	

    $_SESSION['iv'] = $iv;
    $_SESSION['key']   = $key;
	
    $transactionRequestBean = new TransactionRequestBean();
	
	$returnURL="http://".$_SERVER["HTTP_HOST"].$_SERVER['SCRIPT_NAME'];
	$s2SReturnURL="https://tpslvksrv6046/LoginModule/Test.jsp";
	
	//$tpsl_txn_id=$r['regId'];
	$mrctTxtID=$r['Payment_Master_OrderNo'];
	$orderId=$r['Payment_Master_OrderNo'];
	$tpsl_txn_id="";
	$txnDate=date('d-m-Y',strtotime($r['Create_Date']));
	
	$transactionRequestBean->merchantCode = "L290649";
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
    $transactionRequestBean->key = "6601479866KJRBVG";
    $transactionRequestBean->iv = "2955127737GHMHLJ";
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
	
	if(isset($txn_status)) 
	{ 
		if($txn_status=='0300'){
			$msgs = 'Y';
			$saveSuccessMsg = "Transaction Success In Db";
		} else if($txn_status=='0392') {	
			$msgs = 'P';
			$saveSuccessMsg = "Cancelled_BY_User";
		} else if($txn_status=='0395') {	
			$msgs = 'P';
			$saveSuccessMsg = "User Aborted";
		} else if($txn_status=='0396') {	
			$msgs = 'P';
			$saveSuccessMsg = "AWAITED";
		} else if($txn_status=='0397') {	
			$msgs = 'P';
			$saveSuccessMsg = "ABORTED";
		} else if($txn_status=='0399') {	
			$msgs = 'P';
			$saveSuccessMsg = "FAILED";
		} else if($txn_status=='0400') {	
			$msgs = 'P';
			$saveSuccessMsg = "Refund Successful in Db";
		} else if($txn_status=='0499') {	
			$msgs = 'P';
			$saveSuccessMsg = "Refund Fail In Db";
		}else if($txn_status=='9999')	{	
			$msgs = 'P';
			$saveSuccessMsg = "Transaction Not Found In Db";
		}
	}
	
	if($txn_status=='0300')
	{
			
		$chk = "SELECT Payment_Master_ID,Payment_Master_OrderNo FROM `iijs_payment_master` WHERE `Form_ID`='3' AND `Exhibitor_Code`='$Exhibitor_Code' AND Payment_Master_OrderNo='$orderId'";
		$chkresult = $conn->query($chk);
		$getNewResult = $chkresult->fetch_assoc();
		$Payment_Master_ID = $getNewResult['Payment_Master_ID'];
		$Payment_Master_OrderNo = $getNewResult['Payment_Master_OrderNo'];
		
		$conn->query("insert into iijs_stand set Info_Approved='Y',Application_Complete='Y',Exhibitor_Code='$Exhibitor_Code',Payment_Master_ID='$Payment_Master_ID',orderId='$Payment_Master_OrderNo',Create_Date='$Create_Date'");
		$Stand_ID=$conn->insert_id;
		
		$orderUpdate ="update iijs_payment_master set Payment_Master_Approved='$msgs',txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where `Form_ID`='3' AND Payment_Master_OrderNo='$orderId' AND Exhibitor_Code='$Exhibitor_Code'";
		$getResult = $conn->query($orderUpdate);
		if(!$getResult) { die('Error: ' . $conn -> error); }
		
		$getapplication ="SELECT net_payable_amount FROM `iijs_payment_master` WHERE `Form_ID`='3' AND Exhibitor_Code='$Exhibitor_Code' AND Payment_Master_OrderNo='$orderId' AND Payment_Master_Approved='Y'";
		$getApplicationResult = $conn->query($getapplication);
		$getApplicationRow = $getApplicationResult->fetch_assoc();
		$total_payable = $getApplicationRow['net_payable_amount'];
		//$total_payable_word = number_word_v($total_payable);
				
		$query=$conn->query("SELECT * FROM `iijs_stand_items_tmp` WHERE `Exhibitor_Code`='$Exhibitor_Code'");
		while($result=$query->fetch_assoc())
		{ //echo '<pre>'; print_r($result1);
			$id=$result['id'];
			$Item_Master_ID=$result['Item_Master_ID'];
			$Item_Rate=$result['Item_Rate'];
			$Item_Quantity=$result['Item_Quantity'];
			
			$conn->query("insert into iijs_stand_items set Stand_ID='$Stand_ID',Item_Master_ID='$Item_Master_ID',Item_Quantity='$Item_Quantity',Item_Rate='$Item_Rate',Create_Date='$Create_Date'");
			
			$qitem_quantity=$conn->query("select Item_Quantity from iijs_stand_items_master where Item_ID='$Item_Master_ID'");
			$ritem_quantity=$qitem_quantity->fetch_assoc();
			$tot_quantity=$ritem_quantity['Item_Quantity'];
			$remain_quantity=$tot_quantity-$Item_Quantity;

			$sqlx1 = "update iijs_stand_items_master set Item_Quantity='$remain_quantity' where Item_ID='$Item_Master_ID'";
			$result = $conn->query($sqlx1);
			if($result){
			 $conn->query("delete from iijs_stand_items_tmp where id='$id'");
			}
		}	
	} else if($txn_status=='0392') {
			echo $saveSuccessMsg = "Cancelled_BY_User";			
			$orderUpdate ="update iijs_payment_master set Payment_Master_Approved='$msgs',txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where Payment_Master_OrderNo='$clnt_txn_ref' AND Exhibitor_Code='$Exhibitor_Code'";
			$getResult = $conn->query($orderUpdate);
		} else if($txn_status=='0395') {			
			echo $saveSuccessMsg = "User Aborted";
			$orderUpdate ="update iijs_payment_master set Payment_Master_Approved='$msgs',txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where Payment_Master_OrderNo='$clnt_txn_ref' AND Exhibitor_Code='$Exhibitor_Code'";
			$getResult = $conn->query($orderUpdate);
		} else if($txn_status=='0396') {			
			echo $saveSuccessMsg = "AWAITED";
			$orderUpdate ="update iijs_payment_master set Payment_Master_Approved='$msgs',txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where Payment_Master_OrderNo='$clnt_txn_ref' AND Exhibitor_Code='$Exhibitor_Code'";
			$getResult = $conn->query($orderUpdate);
		} else if($txn_status=='0397') {			
			echo $saveSuccessMsg = "ABORTED";
			$orderUpdate ="update iijs_payment_master set Payment_Master_Approved='$msgs',txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where Payment_Master_OrderNo='$clnt_txn_ref' AND Exhibitor_Code='$Exhibitor_Code'";
			$getResult = $conn->query($orderUpdate);
		} else if($txn_status=='0399') {			
			echo $saveSuccessMsg = "FAILED";
			$orderUpdate ="update iijs_payment_master set Payment_Master_Approved='$msgs',txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where Payment_Master_OrderNo='$clnt_txn_ref' AND Exhibitor_Code='$Exhibitor_Code'";
			$getResult = $conn->query($orderUpdate);
		} else if($txn_status=='0400') {			
			echo $saveSuccessMsg = "Refund Successful in Db";
		} else if($txn_status=='0499') {			
			echo $saveSuccessMsg = "Refund Fail In Db";
		} else if($txn_status=='9999') {			
			echo $saveSuccessMsg = "Transaction Not Found In Db";
		} else	{
			echo "<br>Security Error. Illegal access detected";		
		}

	/*header('Content-type: application/json');
	echo json_encode(array("Response"=>$response));*/
	print_r($response);
    ob_flush();
}
?>