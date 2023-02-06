<?php
include('header_include.php');
if(!isset($_SESSION['EXHIBITOR_CODE'])){ header("location:index.php");	exit; }
$Exhibitor_Code = $_SESSION['EXHIBITOR_CODE'];
//echo '<pre>'; print_r($_SESSION); exit;	
?>
<?php
	if(isset($Exhibitor_Code) && $Exhibitor_Code!="")
	{
			$query_cnt=$conn ->query("SELECT * FROM `iijs_wifi_items_tmp` WHERE `Exhibitor_Code`='$Exhibitor_Code'");
			$stand_cnt= $query_cnt->num_rows;
			if($stand_cnt==0)
			{
				echo "<script type='text/javascript'> alert('Please Add Items in order');
				window.location.href='wireless_internet_connection.php?action=ADD';
				</script>";
				return;	exit;
			}
			
			//$Payment_Master_Amount = base64_decode($_POST['Payment_Master_Amount']);
			$Payment_Master_Amount	   = $_POST['Payment_Master_Amount'];
			$Payment_Master_ServiceTax = $_POST['Payment_Master_ServiceTax'];
			$Payment_Master_AmountPaid = filter($_POST['Payment_Master_AmountPaid']);
			$tds_tax 				   = filter($_POST['tds_tax']);
			$tds_amount 			   = filter($_POST['tds_amount']);
			$net_payable_amount 	   = filter($_POST['net_payable_amount']);
			
			$Create_Date=date('Y-m-d h:i:s');
			
			if(!is_numeric($Payment_Master_AmountPaid)){
			echo '<script type="text/javascript">'; 
			echo 'alert("There is something went wrong..!! Kindly check with Admin");'; 
			echo 'window.location.href = "standfitting_services.php?action=ADD";';
			echo '</script>';	
			exit;
			}
	 
		if(isset($Payment_Master_AmountPaid) && !empty($Payment_Master_AmountPaid) AND isset($net_payable_amount) && !empty($net_payable_amount))
		{	
			$qorder=$conn ->query("select * from iijs_payment_master order by `Payment_Master_ID` desc limit 1");
			$num = $qorder->num_rows;
			$strNo = rand(1,1000000);
			if($num<=0)
			{ $Payment_Master_OrderNo = 'WIRELESS22'; }
			else
			{
			  $Payment_Master_OrderNo = 'WIRELESS22'.$strNo;
			}
			$_SESSION['Payment_Master_OrderNo'] = $Payment_Master_OrderNo;		
		
		$chk = "SELECT * FROM `iijs_payment_master` WHERE `Form_ID`='7' AND `Exhibitor_Code`='$Exhibitor_Code' AND Payment_Master_Approved='P'";
		$chkresult = $conn ->query($chk);	
		$countNum = $chkresult->num_rows;
		if($countNum > 0)
		{
			$updateQuery = "update iijs_payment_master set Payment_Master_OrderNo='$Payment_Master_OrderNo',Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',tds_tax='$tds_tax',tds_amount='$tds_amount',net_payable_amount='$net_payable_amount' WHERE `Form_ID`='7' AND Exhibitor_Code='$Exhibitor_Code' AND Payment_Master_Approved='P'";
			$result2 = $conn ->query($updateQuery);	
			
		} else {
		$sqlx2 = "insert into iijs_payment_master set Form_ID='7',Exhibitor_Code='$Exhibitor_Code',Payment_Master_OrderNo='$Payment_Master_OrderNo',Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',tds_tax='$tds_tax',tds_amount='$tds_amount',net_payable_amount='$net_payable_amount',Create_Date='$Create_Date',Modify_Date='$Create_Date'";
		$result2 = $conn ->query($sqlx2);	
		}
		
		$ssx1 = "UPDATE `iijs_wifi_items_tmp` SET `Payment_Master_OrderNo`='$Payment_Master_OrderNo' WHERE `Exhibitor_Code`='$Exhibitor_Code'";
		$query_result1=$conn ->query($ssx1);				
		if($result2){
		header('Location: ebs/wifi_techprocess.php');
		}
		
		}  else {
		echo "<script type='text/javascript'> alert('Error...');
		window.location.href='wireless_internet_connection.php?action=ADD';
		</script>";	return;	exit;
		}
	}
	else
	{
		echo "<script type='text/javascript'> alert('Your session has been expired');
		window.location.href='manual_list.php';
		</script>";
		return;	exit;
	}	
?>