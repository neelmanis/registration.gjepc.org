<?php
ob_start();
include('../db.inc.php');
$strNo = rand(1,1000000);
date_default_timezone_set('Asia/Calcutta');

//echo date_default_timezone_get();

$strCurDate = date('d-m-Y');
require_once 'TransactionRequestBean.php';
require_once 'TransactionResponseBean.php';
session_start();
$registration_id = $_SESSION['USERID'];
$visitor_id = $_SESSION['visitor_id'];
$orderId = $_SESSION['orderId'];

//if($_POST && isset($_POST['submit'])){
if(isset($registration_id) && $registration_id!="" && isset($visitor_id) && $visitor_id!="" &&  isset($orderId) && $orderId!="" ){
	
	$sqlx= "SELECT * FROM `visitor_lost_badges` WHERE regId='$registration_id' AND visitor_id='$visitor_id' AND orderId='$orderId' AND payment_status!='Y'";
	$resultx = mysql_query($sqlx);
	$rows = mysql_fetch_array($resultx);
	$mobNo = $rows['mobile'];
	$mobNo = preg_replace('~^[0\D]++|\D++~', '', $mobNo);
	$custname = $rows['name'];
	$custname = preg_replace("/[^a-zA-Z]/", " ", $custname);	
   // $total_payable = $rows['total_payable'];
    $total_payable = 600;

	$tpsl_txn_id ='TXN00'.rand(1,10000);	
	$tpslUpdate ="UPDATE visitor_lost_badges SET tpsl_txn_id_rand='$tpsl_txn_id', paymentThrough='online' WHERE orderId='$orderId' AND regId='$registration_id' AND visitor_id='$visitor_id'";
	$tpslResult = mysql_query($tpslUpdate);
	
	$mrctCode = "L278776";  // LIVE 
	//$mrctCode = "L278776";
	$tpvAccntNo = "";
	$itc = "NIC~TXN0001~122333~rt14154~8 mar 2014~Payment~forpayment";
	$reqType = "T";
	//$mrctTxtID = $strNo;
	$mrctTxtID = $orderId;
	$currencyType = "INR";
	$returnURL = "https://" . $_SERVER['HTTP_HOST']."/lost_badge_payment_success.php";
	$s2SReturnURL = "https://tpslvksrv6046/LoginModule/Test.jsp";
	$reqDetail = "FIRST_$total_payable.0_0.0";
	$txnDate = $strCurDate;
	//$bankCode = "470";
	$bankCode = "";
	//$tpsl_txn_id ='TXN00'.rand(1,10000);
	$custID = $registration_id;
	$cardID = "";
	$locatorURL = "https://www.tpsl-india.in/PaymentGateway/TransactionDetailsNew.wsdl";
	$mmid ="";
	$otp = "";
	$cardName = "";
	$cardNo = "";
	$cardCVV = "";
	$cardExpMM = "";
	$cardExpYY = "";
	$timeOut = "";
	
	$val = $_POST;
	$iv = "7944996633RXRYHY";
	$key = "4681267225TDBCEB";
	
    $_SESSION['iv']  = $iv;
    $_SESSION['key'] = $key;
	
//echo $sequence = $reqType."|".$mrctCode."|".$mrctTxtID."|".$currencyType."|".$total_payable."|".$itc."|".$reqDetail."|".$txnDate."|".$bankCode."|".$locatorURL."|".$s2SReturnURL."|".$tpsl_txn_id."|".$cardID."|".$custID."|".$custname."|".$timeOut."|".$mobNo."|".$key."|".$iv."|".$returnURL; exit; 

    $transactionRequestBean = new TransactionRequestBean();

    //Setting all values here
    $transactionRequestBean->setMerchantCode($mrctCode);
    $transactionRequestBean->setAccountNo($tpvAccntNo);
    $transactionRequestBean->setITC($itc);
    $transactionRequestBean->setMobileNumber($mobNo);
    $transactionRequestBean->setCustomerName($custname);
    $transactionRequestBean->setRequestType($reqType);
    $transactionRequestBean->setMerchantTxnRefNumber($mrctTxtID);
    $transactionRequestBean->setAmount($total_payable);
    $transactionRequestBean->setCurrencyCode($currencyType);
    $transactionRequestBean->setReturnURL($returnURL);
    $transactionRequestBean->setS2SReturnURL($s2SReturnURL);
    $transactionRequestBean->setShoppingCartDetails($reqDetail);
    $transactionRequestBean->setTxnDate($txnDate);
    $transactionRequestBean->setBankCode($bankCode);
    $transactionRequestBean->setTPSLTxnID($tpsl_txn_id);
    $transactionRequestBean->setCustId($custID);
    $transactionRequestBean->setCardId($cardID);
    $transactionRequestBean->setKey($key);
    $transactionRequestBean->setIv($iv);
    $transactionRequestBean->setWebServiceLocator($locatorURL);
    $transactionRequestBean->setMMID($mmid);
    $transactionRequestBean->setOTP($otp);
    $transactionRequestBean->setCardName($cardName);
    $transactionRequestBean->setCardNo($cardNo);
    $transactionRequestBean->setCardCVV($cardCVV);
    $transactionRequestBean->setCardExpMM($cardExpMM);
    $transactionRequestBean->setCardExpYY($cardExpYY);
    $transactionRequestBean->setTimeOut($timeOut);

   // $url = $transactionRequestBean->getTransactionToken();

    $responseDetails = $transactionRequestBean->getTransactionToken();
    $responseDetails = (array)$responseDetails;
    $response = $responseDetails[0];

    if(is_string($response) && preg_match('/^msg=/',$response)){
        $outputStr = str_replace('msg=', '', $response);
        $outputArr = explode('&', $outputStr);
        $str = $outputArr[0];

        $transactionResponseBean = new TransactionResponseBean();
        $transactionResponseBean->setResponsePayload($str);
        $transactionResponseBean->setKey($key);
        $transactionResponseBean->setIv($iv);

        $response = $transactionResponseBean->getResponsePayload();
        echo "<pre>";
        print_r($response);
        exit;
    }elseif(is_string($response) && preg_match('/^txn_status=/',$response)){
		echo "<pre>";
        print_r($response);
        exit;
	}

    echo "<script>window.location = '".$response."'</script>";
    ob_flush();

}else if($_POST){

    $response = $_POST;

    if(is_array($response)){
        $str = $response['msg'];
    }else if(is_string($response) && strstr($response, 'msg=')){
        $outputStr = str_replace('msg=', '', $response);
        $outputArr = explode('&', $outputStr);
        $str = $outputArr[0];
    }else {
        $str = $response;
    }

    $transactionResponseBean = new TransactionResponseBean();

    $transactionResponseBean->setResponsePayload($str);
    $transactionResponseBean->setKey($_SESSION['key']);
    $transactionResponseBean->setIv($_SESSION['iv']);

    $response = $transactionResponseBean->getResponsePayload();
    echo "<pre>";
    print_r($response);
    echo "<br><br><br><br>";

    session_destroy();?>
    <a href='<?php echo "http://".$_SERVER["HTTP_HOST"].$_SERVER['SCRIPT_NAME'];?>'>GO TO HOME</a>
    <?php
    exit;
}
?>