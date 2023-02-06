<?php
ob_start();
include('../db.inc.php');
$strNo = rand(1,1000000);
date_default_timezone_set('Asia/Calcutta');

$strCurDate = date('d-m-Y');

require_once 'TransactionRequestBean.php';
require_once 'TransactionResponseBean.php';

session_start();
$Exhibitor_Code = $_SESSION['EXHIBITOR_CODE'];

//if($_POST && isset($_POST['submit'])){
if(isset($Exhibitor_Code) && $Exhibitor_Code!="")
{
	$orderId = $_SESSION['orderId'];
	
	$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$Exhibitor_Code'";
	$result=$conn ->query($exhibitor_data);
	$fetch_data=$result->fetch_assoc();
	$custname = $fetch_data['Exhibitor_Name'];
	$custname = preg_replace("/[^a-zA-Z]/", " ", $custname);
	$mobNo = $fetch_data['Exhibitor_Mobile'];

	$orderUpdate ="SELECT net_payable_amount FROM `iijs_housekeeping` WHERE orderId='$orderId' AND Exhibitor_Code='$Exhibitor_Code' AND Payment_Approved!='Y'";
	$getResult = $conn ->query($orderUpdate);
	if(!$getResult) die ($conn->error);
	$row = $getResult->fetch_assoc();
	$total_amount = $row['net_payable_amount'];
	$total_payable = substr($total_amount, 0,-3);
	//$total_payable = 1;
	
	$tpsl_txn_id ='TXN00'.rand(1,10000);	
	$tpslUpdate ="update iijs_housekeeping set tpsl_txn_id_rand='$tpsl_txn_id' WHERE orderId='$orderId' AND Exhibitor_Code='$Exhibitor_Code'";
	$tpslResult = $conn ->query($tpslUpdate);
	
	$mrctCode = "L290649";
	$tpvAccntNo = "";
	$itc = "NIC~TXN0001~122333~rt14154~8 mar 2014~Payment~forpayment";
	$reqType = "T";
	$mrctTxtID = $orderId;
	$currencyType = "INR";
	$returnURL = "https://" . $_SERVER['HTTP_HOST']."/manual_signature/housekeeping_payment_success.php";
	$s2SReturnURL = "https://tpslvksrv6046/LoginModule/Test.jsp";
	$reqDetail = "FIRST_$total_payable.0_0.0";
	$txnDate = $strCurDate;
	//$bankCode = "470";
	$bankCode = "";
	//$tpsl_txn_id ='TXN00'.rand(1,10000); above define
	$custID = $Exhibitor_Code;
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
	$iv = "2955127737GHMHLJ";
	$key = "6601479866KJRBVG";
	
    $_SESSION['iv']  = $iv;
    $_SESSION['key'] = $key;
	
//echo $sequence = $reqType."|".$mrctCode."|".$mrctTxtID."|".$currencyType."|".$total_payable."|".$itc."|".$reqDetail."|".$txnDate."|".$bankCode."|".$locatorURL."|".$s2SReturnURL."|".$tpsl_txn_id."|".$cardID."|".$custID."|".$custname."|".$timeOut."|".$mobNo."|".$key."|".$iv."|".$returnURL; exit; 

    $transactionRequestBean = new TransactionRequestBean();

    //Setting all values here
    $transactionRequestBean->merchantCode = $mrctCode;
    $transactionRequestBean->accountNo = $tpvAccntNo;
    $transactionRequestBean->ITC = $itc;
    $transactionRequestBean->mobileNumber = $mobNo;
    $transactionRequestBean->customerName = $custname;
    $transactionRequestBean->requestType = $reqType;
    $transactionRequestBean->merchantTxnRefNumber = $mrctTxtID;
    $transactionRequestBean->amount = $total_payable;
    $transactionRequestBean->currencyCode = $currencyType;
    $transactionRequestBean->returnURL = $returnURL . '?Exhibitor_Code=' . $Exhibitor_Code;
    $transactionRequestBean->s2SReturnURL = $s2SReturnURL;
    $transactionRequestBean->shoppingCartDetails = $reqDetail;
    $transactionRequestBean->txnDate = $txnDate;
    $transactionRequestBean->bankCode = $bankCode;
    $transactionRequestBean->TPSLTxnID = $tpsl_txn_id;
    $transactionRequestBean->custId = $custID;
    $transactionRequestBean->cardId = $cardID;
    $transactionRequestBean->key = $key;
    $transactionRequestBean->iv = $iv;
    $transactionRequestBean->webServiceLocator = $locatorURL;
    $transactionRequestBean->MMID = $mmid;
    $transactionRequestBean->OTP = $otp;
    $transactionRequestBean->cardName = $cardName;
    $transactionRequestBean->cardNo = $cardNo;
    $transactionRequestBean->cardCVV = $cardCVV;
    $transactionRequestBean->cardExpMM = $cardExpMM;
    $transactionRequestBean->cardExpYY = $cardExpYY;
    $transactionRequestBean->timeOut = (!empty($val['timeOut']) ? $val['timeOut'] : 30 );

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
        $transactionResponseBean->setKey($val['key']);
        $transactionResponseBean->setIv($val['iv']);

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