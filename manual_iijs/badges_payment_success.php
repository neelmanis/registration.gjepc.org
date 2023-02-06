<?php 
include('header_include.php');

$Exhibitor_Code = $_SESSION['EXHIBITOR_CODE'];
$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$Exhibitor_Code'";
$result = $conn ->query($exhibitor_data);
$fetch_data = $result->fetch_assoc();

$Exhibitor_Name = $fetch_data['Exhibitor_Name'];
$Exhibitor_Contact_Person = $fetch_data['Exhibitor_Contact_Person'];
$Exhibitor_Email = $fetch_data['Exhibitor_Email'];

require_once 'ebs/TransactionRequestBean.php';
require_once 'ebs/TransactionResponseBean.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BADGES SERVICES </title>
<link rel="stylesheet" type="text/css" href="../css/mystyle.css" />
<!--navigation script-->
<script type="text/javascript" src="../js/jquery_002.js"></script>
<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />
<script type="text/javascript" src="../js/ddsmoothmenu.js"></script>
<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
<link rel="stylesheet" type="text/css" href="../css/manual.css"/>
</head>

<body>
<!-- header starts -->
<div class="header_wrap">
	<?php include ('header.php'); ?>
</div>
<!-- header ends -->
<div class="clear"></div>

<?php
$orderId=$_SESSION['Payment_Master_OrderNo'];
$Create_Date=date('Y-m-d h:i:s');
$transactionRequestBean = new TransactionRequestBean();
if(isset($_POST))
{
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
		
	
	if($txn_status=='0300' && $clnt_txn_ref!='')
	{
		/*...................................Get Payment ID....................................................*/
		$chk = "SELECT Payment_Master_ID,Payment_Master_OrderNo FROM `iijs_payment_master` WHERE `Form_ID`='4' AND `Exhibitor_Code`='$Exhibitor_Code' AND Payment_Master_OrderNo='$clnt_txn_ref'";
		$chkresult = $conn ->query($chk);
		$getNewResult = $chkresult->fetch_assoc();
		$Payment_Master_ID = $getNewResult['Payment_Master_ID'];
		$Payment_Master_OrderNo = $getNewResult['Payment_Master_OrderNo'];
		
		/*...................................Get Badge ID....................................................*/
		$qbadgeId = $conn->query("select Badge_ID from iijs_badge where Payment_Master_ID='$Payment_Master_ID'");
		$rbadgeId = $qbadgeId->fetch_assoc();
		$Badge_ID = $rbadgeId['Badge_ID'];
		
		$orderUpdate ="update iijs_payment_master set Payment_Master_Approved='$msgs',txn_status='$txn_status',txn_msg='$txn_msg',payment_reason='$saveSuccessMsg',txn_err_msg='$txn_err_msg',clnt_txn_ref='$clnt_txn_ref',tpsl_txn_time='$tpsl_txn_time',tpsl_txn_id='$tpsl_txn_id' where `Form_ID`='4' AND Payment_Master_OrderNo='$clnt_txn_ref' AND Exhibitor_Code='$Exhibitor_Code'";
		$getResult = $conn->query($orderUpdate);
		if (!$getResult) die ($conn->error);
		
	$query = $conn ->query("SELECT * FROM `iijs_badge_items_tmp` WHERE `Exhibitor_Code`='$Exhibitor_Code'");
	while($result = $query->fetch_assoc())
	{
		$Badge_Item_ID=$result['Badge_Item_ID'];
		if($result['Replace_Badge_Item_ID']=="")
			$Replace_Badge_Item_ID=0;
		else
			$Replace_Badge_Item_ID=$result['Replace_Badge_Item_ID'];
			
		$Exhibitor_Code=$result['Exhibitor_Code'];
		$Badge_Type=$result['Badge_Type'];
		$Badge_Name=$result['Badge_Name'];
		$Badge_Designation=$result['Badge_Designation'];
		$Badge_Mobile=$result['Badge_Mobile'];
		$Badge_Photo=$result['Badge_Photo'];
		$Badge_Document=$result['Badge_Document'];
		
		$exhibitor_maintenance_charge=$result['exhibitor_maintenance_charge'];
		$Surcharge=$result['Surcharge'];
		
	$badge = $conn ->query("insert into iijs_badge_items set Exhibitor_Code='$Exhibitor_Code',Badge_ID='$Badge_ID',Badge_Name='$Badge_Name',Badge_Mobile='$Badge_Mobile',Badge_Designation='$Badge_Designation',Badge_Photo='$Badge_Photo',Badge_Document='$Badge_Document',Badge_Type='$Badge_Type',Replacement_ID='$Replace_Badge_Item_ID',Surcharge='$Surcharge',Waveoff_Reason='0',Create_Date='$Create_Date'");
	
	if($Replace_Badge_Item_ID!=0)
	$items = $conn ->query("update iijs_badge_items set Is_Repalced='Y' where Badge_Item_ID='$Replace_Badge_Item_ID'");
	
	$itemstmp = $conn ->query("delete from iijs_badge_items_tmp where Badge_Item_ID='$Badge_Item_ID'");
	}

		/*Send Email Receipt to Company */
	$message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
	<tr>
	<td style="padding:30px;">
	<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
	<tr>
		<td align="left" height="60px"><img src="https://gjepc.org/assets/images/logo.png" border="0" width="220"/></td>
		<td align="right" height="60px"><img src="https://registration.gjepc.org/manual_signature/images/logo.png" border="0"/></td>
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
	<p>Thank you for applying Online for <strong>Form No. 2. EXHIBITOR BADGES FORM</strong> with Order number '.$clnt_txn_ref.'</p>	
	<p>A  system generated notification will be sent to you on successful  approval/Disapproval of your application</p>
	
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
	
	<map name="Map" id="Map"><area shape="rect" coords="0,0,185,67" href="http://www.iijs-signature.org/"  target="_blank" style="outline:none;"/><area shape="rect" coords="82,58,83,71" href="#" /></map>
	
	<map name="Map2" id="Map2"><area shape="rect" coords="2,0,312,68" href="http://www.gjepc.org/"  target="_blank" style="outline:none;" /></map>
	</tr>
	</table>';
	
	$to =$Exhibitor_Email.',notification@gjepcindia.com';
	//$to ='mukesh@kwebmaker.com';
	$subject = "IIJS Premiere 2021 Exhibitor Manual - Form No. 2. EXHIBITOR BADGES FORM";	
	$headers  = 'MIME-Version: 1.0' . "\n";	
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
	$headers .= 'From:IIJS Premiere 2021 <admin@gjepc.org>';                            
	
	@mail($to, $subject, $message, $headers);
		/*  Email End */
		?>
		<div class="container_wrap">
		<div class="container" id="manualFormContainer">
		<h1 style="color:green;">PAYMENT SUCCESSFUL</h1>
		<div id="formWrapper">
		<p>Your transaction is successfully Completed. Thank you for your participation in IIJS Premiere 2021.</p>
		<p>Your Transaction ID : <?php echo $tpsl_txn_id;?></p>
		</div>
		<div class="clear"></div>
		</div>
		</div>
		<?php
		//header("location:exhibitors_badges.php");
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
		unset($_SESSION['orderId']);
		
}
?>
<hr/>
<a href="manual_list.php" class="button5" style="margin-left:500px;">Back To List</a>
<div class="footer_wrap">
<?php include ('footer.php'); ?>
</div>
<!--footer ends-->
</body>
</html>