<?php
include('header_include.php');
//echo '<pre>'; print_r($_SESSION); exit; 
if(!isset($_SESSION['EXHIBITOR_CODE'])){
$Exhibitor_Code = $_REQUEST['EXHIBITOR_CODE'];
} else { 
$Exhibitor_Code = $_SESSION['EXHIBITOR_CODE'];
}

$email = $_SESSION['EMAILID'];
$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$Exhibitor_Code'";
$result = $conn ->query($exhibitor_data);
$fetch_data = $result->fetch_assoc();

$Exhibitor_Name=$fetch_data['Exhibitor_Name'];
$Exhibitor_Contact_Person=$fetch_data['Exhibitor_Contact_Person'];
$Exhibitor_Email=$fetch_data['Exhibitor_Email'];

require_once 'ebs/TransactionRequestBean.php';
require_once 'ebs/TransactionResponseBean.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>STANDFITTING SERVICES</title>
<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="../css/manual.css"/>
</head>

<body>
<!-- header starts -->
<div class="header_wrap"><?php include ('header.php'); ?></div>
<!-- header ends -->
<div class="clear"></div>

<?php
$orderId=$_SESSION['Payment_Master_OrderNo'];
$Create_Date=date('Y-m-d h:i:s');
$transactionRequestBean = new TransactionRequestBean();
if(isset($_POST))
{
	if(!isset($_SESSION['EXHIBITOR_CODE'])){
	$EXHIBITOR_CODE = $_REQUEST['EXHIBITOR_CODE'];
	} else {
	$EXHIBITOR_CODE = $_SESSION['EXHIBITOR_CODE'];
	}
	
	$response = $_POST;
    if(is_array($response)){
        $str = $response['msg'];
    }else if(is_string($response) && strstr($response, 'msg=')){
        $outputStr = str_replace('msg=', '', $response);
        $outputArr = explode('&', $outputStr);
        $str = $outputArr[0];
    } else {
        $str = $response;
    }

    $transactionResponseBean = new TransactionResponseBean();

    $transactionResponseBean->setResponsePayload($str);
    $transactionResponseBean->key = '6601479866KJRBVG';
	$transactionResponseBean->iv = '2955127737GHMHLJ';

    $response = $transactionResponseBean->getResponsePayload();
 /*   echo "<pre>";
    print_r($response);
    echo "<br><br><br><br>"; 
	exit; */
	$pipeResponse = explode('|',$response);
	//echo "<pre>"; print_r($pipeResponse); exit;
	
	$txnStatus 	= $pipeResponse[0];
	$txnMsg    	= $pipeResponse[1];
	$txnErrMsg  = $pipeResponse[2];
	$clntTxnRef = $pipeResponse[3];
	$tpslTxnId = $pipeResponse[5];
	$tpsl_TrascTime = $pipeResponse[8];
	
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
		
		if($txn_status=='0300' || $_SESSION['ACCESS']=="ADMIN"){
			if($_SESSION['ACCESS']=="ADMIN")
				$msgs = 'P';
			else
				$msgs = 'Y';
			$saveSuccessMsg = "Transaction Success In Db";
		} else if($txn_status=='0392') {	
			$msgs = 'C';
			$saveSuccessMsg = "Cancelled_BY_User";
		} else if($txn_status=='0395') {	
			$msgs = 'C';
			$saveSuccessMsg = "User Aborted";
		} else if($txn_status=='0396') {	
			$msgs = 'P';
			$saveSuccessMsg = "AWAITED";
		} else if($txn_status=='0397') {	
			$msgs = 'C';
			$saveSuccessMsg = "ABORTED";
		} else if($txn_status=='0399') {	
			$msgs = 'C';
			$saveSuccessMsg = "FAILED";
		} else if($txn_status=='0400') {	
			$msgs = 'C';
			$saveSuccessMsg = "Refund Successful in Db";
		} else if($txn_status=='0499') {	
			$msgs = 'C';
			$saveSuccessMsg = "Refund Fail In Db";
		}else if($txn_status=='9999')	{	
			$msgs = 'C';
			$saveSuccessMsg = "Transaction Not Found In Db";
		}
		
	if(($txn_status=='0300' && $clnt_txn_ref!='') || $_SESSION['ACCESS']=="ADMIN")
	{
		if($_SESSION['ACCESS']=="ADMIN"){
			$txn_status='03111';
			$clnt_txn_ref=$_SESSION['Payment_Master_OrderNo'];
		}
			
		$chk = "SELECT Payment_Master_ID,Payment_Master_OrderNo FROM `iijs_payment_master` WHERE `Form_ID`='3' AND `Exhibitor_Code`='$Exhibitor_Code' AND Payment_Master_OrderNo='$clnt_txn_ref'";
		$chkresult = $conn ->query($chk);
		$getNewResult = $chkresult->fetch_assoc();
		$Payment_Master_ID = $getNewResult['Payment_Master_ID'];
		$Payment_Master_OrderNo = $getNewResult['Payment_Master_OrderNo'];
		
		$iijs_stand = $conn->query("insert into iijs_stand set Info_Approved='Y',Application_Complete='Y',Exhibitor_Code='$Exhibitor_Code',Payment_Master_ID='$Payment_Master_ID',orderId='$Payment_Master_OrderNo',Create_Date='$Create_Date'");
		if(!$iijs_stand) die ($conn->error);
		$Stand_ID = mysqli_insert_id($conn);
		
		$orderUpdate ="update iijs_payment_master set Payment_Master_Approved='$msgs',txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where `Form_ID`='3' AND Payment_Master_OrderNo='$clnt_txn_ref' AND Exhibitor_Code='$Exhibitor_Code'";
		$getResult = $conn->query($orderUpdate);
		if(!$getResult) die ($conn->error);
		
		$getapplication ="SELECT net_payable_amount FROM `iijs_payment_master` WHERE `Form_ID`='3' AND Exhibitor_Code='$Exhibitor_Code' AND Payment_Master_OrderNo='$clnt_txn_ref' AND Payment_Master_Approved='Y'";
		$getApplicationResult = $conn ->query($getapplication);
		$getApplicationRow = $getApplicationResult->fetch_assoc();
		$total_payable = $getApplicationRow['net_payable_amount'];
		//$total_payable_word = number_word_v($total_payable);
				
		$query=$conn ->query("SELECT * FROM `iijs_stand_items_tmp` WHERE `Exhibitor_Code`='$Exhibitor_Code'");
		while($result = $query->fetch_assoc())
		{ //echo '<pre>'; print_r($result1);
			$id=$result['id'];
			$Item_Master_ID=$result['Item_Master_ID'];
			$Item_Rate=$result['Item_Rate'];
			$Item_Quantity=$result['Item_Quantity'];
			
			$iijs_stand_items = $conn ->query("insert into iijs_stand_items set Stand_ID='$Stand_ID',Item_Master_ID='$Item_Master_ID',Item_Quantity='$Item_Quantity',Item_Rate='$Item_Rate',Create_Date='$Create_Date'");
			
			/*......................Get Stand Fitting Item Quantity...............................*/
			$qitem_quantity=$conn ->query("select Item_Quantity from iijs_stand_items_master where Item_ID='$Item_Master_ID'");
			$ritem_quantity =  $qitem_quantity->fetch_assoc();
			$tot_quantity=$ritem_quantity['Item_Quantity'];
			$remain_quantity=$tot_quantity-$Item_Quantity;

			$sqlx1 = "update iijs_stand_items_master set Item_Quantity='$remain_quantity' where Item_ID='$Item_Master_ID'";
			$result = $conn ->query($sqlx1);
			if($result){
			$conn ->query("delete from iijs_stand_items_tmp where id='$id'");
			}
			/* For Stall Layout  */
			$q=$conn ->query("select * from iijs_stall_master where Exhibitor_Code='$Exhibitor_Code'");
			$n=$q->num_rows;
			if($n>0)
			$iijs_stall_master = $conn ->query("update iijs_stall_master set Stall_Basic_Layout_Approved='N',Application_Complete='N',Stall_Basic_Layout_Reason='you have applied for extra standfitting. Kindly upload revised stall layout',Stall_Image_Layout_Type='' where Exhibitor_Code='$Exhibitor_Code'");
		}
		/*Send Email Receipt to Company */
	$message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
	<tr>
	<td style="padding:30px;">
	<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
	<tr>
	<td align="left" height="60px"><img src="https://gjepc.org/assets/images/logo.png" border="0" width="230" /></td>
	<td align="right" height="60px"><img src="https://registration.gjepc.org/manual_iijs/images/logo.png" width="120" border="0"/></td>
	</tr>
	<tr>
	<td></td>
	<td align="right"></td>
	</tr>
	
	<tr>
	<td align="right" colspan="2" height="30px"><hr /></td>
	</tr>
	<tr>
	<td colspan="2" style="font-size:13px; line-height:22px;">
	<p>Dear <strong>'.$Exhibitor_Contact_Person.',</strong> </p>
	<p>Company Name: <strong>'.$Exhibitor_Name.'</strong> </p>
	<p>Thank you for applying Online for <strong>STANDFITTING SERVICES.</strong> with Order No. : '.$clnt_txn_ref.'</p>
	
	<p>A system generated notification will be sent to you on successful approval/Disapproval of your application</p>
	
	<p>Kind regards, <br />	
	<strong>IIJS Web Team,</strong>
	</p>
	</td>
	</tr>
	<tr>
	<td colspan="2" align="center" style="font-size:13px; line-height:22px;">   
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</table>';
		
		$to = $Exhibitor_Email.',notification@gjepcindia.com';
		//$to = 'rohit@kwebmaker.com';
		$subject = "IIJS PREMIERE 2022 Exhibitor Manual - STANDFITTING SERVICES"; 
		$headers  = 'MIME-Version: 1.0' . "\n"; 
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		$headers .= 'From: IIJS PREMIERE 2022 <admin@gjepc.org>';			
		mail($to, $subject, $message, $headers);
		/*  Email End */
		$stall_query="SELECT * FROM `iijs_stall_master` WHERE Stall_Basic_Layout_Approved='Y' and Exhibitor_Code='$Exhibitor_Code'";
		$result_stall=$conn ->query($stall_query);
		$stall_cnt=$result_stall->num_rows;
		if($stall_cnt>0)
		{
			$stall_query1="update `iijs_stall_master` set Stall_Basic_Layout_Approved='N' WHERE Exhibitor_Code='$Exhibitor_Code'";
			$conn ->query($stall_query1);			
			echo "<script type='text/javascript'> alert('Order modified kindly upload revised Stall Layout');window.location.href='standfitting_services.php';</script>";			
		} else	{
			header('location:standfitting_services.php');
		}
		
		//header('Location: manual_list.php');
		header("Refresh: 5; url=https://" . $_SERVER['HTTP_HOST']."/manual_signature/manual_list.php");
		?>
		<div class="container_wrap">
		<div class="container" id="manualFormContainer">
		<h1 style="color:green;">PAYMENT SUCCESSFUL</h1>
		<div id="formWrapper">
		<p>Your transaction is successfully Completed. Thank you for your participation in IIJS-PREMIERE 2022.</p>
		<p>Your Transaction ID : <?php echo $tpsl_txn_id;?></p>
		</div>
		<div class="clear"></div>
		</div>
		</div>
		<?php
	} else if($txn_status=='0392') {
			echo $saveSuccessMsg = "Cancelled_BY_User";			
			$orderUpdate ="update iijs_payment_master set Payment_Master_Approved='$msgs',txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where Payment_Master_OrderNo='$clnt_txn_ref' AND Exhibitor_Code='$Exhibitor_Code'";
			$getResult = $conn ->query($orderUpdate);
		} else if($txn_status=='0395') {			
			echo $saveSuccessMsg = "User Aborted";
			$orderUpdate ="update iijs_payment_master set Payment_Master_Approved='$msgs',txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where Payment_Master_OrderNo='$clnt_txn_ref' AND Exhibitor_Code='$Exhibitor_Code'";
			$getResult = $conn ->query($orderUpdate);
		} else if($txn_status=='0396') {			
			echo $saveSuccessMsg = "AWAITED";
			$orderUpdate ="update iijs_payment_master set Payment_Master_Approved='$msgs',txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where Payment_Master_OrderNo='$clnt_txn_ref' AND Exhibitor_Code='$Exhibitor_Code'";
			$getResult = $conn ->query($orderUpdate);
		} else if($txn_status=='0397') {			
			echo $saveSuccessMsg = "ABORTED";
			$orderUpdate ="update iijs_payment_master set Payment_Master_Approved='$msgs',txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where Payment_Master_OrderNo='$clnt_txn_ref' AND Exhibitor_Code='$Exhibitor_Code'";
			$getResult = $conn ->query($orderUpdate);
		} else if($txn_status=='0399') {			
			echo $saveSuccessMsg = "FAILED";
			$orderUpdate ="update iijs_payment_master set Payment_Master_Approved='$msgs',txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where Payment_Master_OrderNo='$clnt_txn_ref' AND Exhibitor_Code='$Exhibitor_Code'";
			$getResult = $conn ->query($orderUpdate);
		} else if($txn_status=='0400') {			
			echo $saveSuccessMsg = "Refund Successful in Db";
		} else if($txn_status=='0499') {			
			echo $saveSuccessMsg = "Refund Fail In Db";
		} else if($txn_status=='9999') {			
			echo $saveSuccessMsg = "Transaction Not Found In Db";
		} else	{
			echo "<br>Security Error. Illegal access detected";		
		}
		
		//header('Location: manual_list.php');
		header("Refresh: 3; url=https://" . $_SERVER['HTTP_HOST']."/manual_iijs/manual_list.php");
		unset($_SESSION['orderId']);
		
}
?>
<div class="footer_wrap">
<?php include ('footer.php'); ?>
</div>
<!--footer ends-->
</body>
</html>