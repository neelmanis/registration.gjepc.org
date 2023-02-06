<?php
include('header_include.php');
if(!isset($_SESSION['EXHIBITOR_CODE'])){ header("location:index.php");	exit; }
$Exhibitor_Code = $_SESSION['EXHIBITOR_CODE'];
$link = $_GET['link'];
?>
<?php
//echo '<pre>'; print_r($_POST); exit;
	if(isset($Exhibitor_Code) && $Exhibitor_Code!="")
	{
			/*
			$query_cnt = $conn ->query("SELECT * FROM `iijs_stand_items_tmp` WHERE `Exhibitor_Code`='$Exhibitor_Code'");
			$stand_cnt = $query_cnt->num_rows;
			if($stand_cnt==0)
			{
				echo "<script type='text/javascript'> alert('Please Add Items in order');
				window.location.href='standfitting_services.php?action=ADD';
				</script>";
				return;	exit;
			} */
			
			/* Check offline Payment */
			if(isset($link) && $link!="")
			{
			$Payment_Master_ID = $_REQUEST['Payment_Master_ID'];
			$manual = "select * from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID' AND Form_ID='3' AND Exhibitor_Code='$Exhibitor_Code'";
			$query_count = $conn ->query($manual);
			$stand_count = $query_count->num_rows;
			if($stand_count>0)
			{
				$result = $query_count->fetch_assoc();
				$Payment_Master_Amount = $result['Payment_Master_Amount'];
			$Payment_Master_ServiceTax = $result['Payment_Master_ServiceTax'];
			$Payment_Master_AmountPaid = filter($result['Payment_Master_AmountPaid']);
							  $tds_tax = $result['tds_tax'];
				           $tds_amount = $result['tds_amount'];				
				   $net_payable_amount = $result['net_payable_amount'];
			}
			
			} else {
				
			//$Payment_Master_Amount = base64_decode($_POST['Payment_Master_Amount']);
			$Payment_Master_Amount	   = $_POST['Payment_Master_Amount'];
			$Payment_Master_ServiceTax = $_POST['Payment_Master_ServiceTax'];
			$Payment_Master_AmountPaid = filter($_POST['Payment_Master_AmountPaid']);
			$tds_tax 				   = filter($_POST['tds_tax']);
			$tds_amount 			   = filter($_POST['tds_amount']);
			$net_payable_amount 	   = filter($_POST['net_payable_amount']);
			}
			
			
			$Create_Date=date('Y-m-d h:i:s');
			
			if(!is_numeric($Payment_Master_AmountPaid)){
			echo '<script type="text/javascript">'; 
			echo 'alert("There is something went wrong..!! Kindly check with Admin");'; 
			echo 'window.location.href = "standfitting_services.php?action=ADD";';
			echo '</script>';	
			exit;
			}
	 
		//if(!empty($Payment_Master_AmountPaid) && $Payment_Master_AmountPaid!=0)
		if(isset($Payment_Master_AmountPaid) && !empty($Payment_Master_AmountPaid) AND isset($net_payable_amount) && !empty($net_payable_amount))
		{	
			$qorder = $conn ->query("select * from iijs_payment_master order by `Payment_Master_ID` desc limit 1");
			$num = $qorder->num_rows;
			$strNo = rand(1,1000000);
			if($num<=0)
			{ $Payment_Master_OrderNo = 'STAND22'; }
			else
			{
			  $Payment_Master_OrderNo = 'STAND22'.$strNo;
			}
			$_SESSION['Payment_Master_OrderNo'] = $Payment_Master_OrderNo;		
		
	/*	$chk = "SELECT * FROM `iijs_payment_master` WHERE `Form_ID`='3' AND `Exhibitor_Code`='$Exhibitor_Code' AND Payment_Master_Approved='P' ";
		$chkresult = $conn ->query($chk);	
		$countNum = mysql_num_rows($chkresult);
		if($countNum > 0)
		{
			$updateQuery = "update iijs_payment_master set Payment_Master_OrderNo='$Payment_Master_OrderNo',Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',tds_tax='$tds_tax',tds_amount='$tds_amount',net_payable_amount='$net_payable_amount',Modify_Date='$Create_Date' WHERE `Form_ID`='3' AND Exhibitor_Code='$Exhibitor_Code' AND Payment_Master_Approved='P'";
			$result2 = $conn ->query($updateQuery);
			if(!$result2) {	die('Error Update: ' . mysql_error());	}			
		} else { */
		$sqlx2 = "insert into iijs_payment_master set Form_ID='3',Exhibitor_Code='$Exhibitor_Code',Payment_Master_OrderNo='$Payment_Master_OrderNo',Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',tds_tax='$tds_tax',tds_amount='$tds_amount',net_payable_amount='$net_payable_amount',Create_Date='$Create_Date'";
		$result2 = $conn ->query($sqlx2);
		if (!$result2) die ($conn->error);
		//}
		
		$ssx1 = "UPDATE `iijs_stand_items_tmp` SET `Payment_Master_OrderNo`='$Payment_Master_OrderNo' WHERE `Exhibitor_Code`='$Exhibitor_Code'";
		$query_result1=$conn ->query($ssx1);				
		if($result2){
			if($_SESSION['ACCESS']=="ADMIN")
				header('Location: standfitting_payment_success.php');
			else
				header('Location: ebs/standfitting_techprocess.php');
		}
		}  else {
		echo "<script type='text/javascript'> alert('Error...');
		window.location.href='standfitting_services.php?action=ADD';
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