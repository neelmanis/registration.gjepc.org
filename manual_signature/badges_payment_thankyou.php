<?php
include('header_include.php');
if(!isset($_SESSION['EXHIBITOR_CODE'])){ header("location:index.php");	exit; }
$Exhibitor_Code = $_SESSION['EXHIBITOR_CODE'];	
?>
<?php
//echo '<pre>'; print_r($_POST); exit;
if(isset($Exhibitor_Code) && $Exhibitor_Code!="")
{
	$Payment_Mode_ID="1";
	
	$exhibitor_data = "select * from iijs_exhibitor where Exhibitor_Code='$Exhibitor_Code'";
	$result = $conn ->query($exhibitor_data);
	$fetch_data = $result->fetch_assoc();
	
	$Exhibitor_Name=$fetch_data['Exhibitor_Name'];
	$Exhibitor_Contact_Person=$fetch_data['Exhibitor_Contact_Person'];
	$Exhibitor_Email=$fetch_data['Exhibitor_Email'];
	
	$Collection_Mode="C";

	$Payment_Master_Amount	   = $_POST['Payment_Master_Amount'];
	$Payment_Master_ServiceTax = $_POST['Payment_Master_ServiceTax'];
	$Payment_Master_AmountPaid = $_POST['Payment_Master_AmountPaid'];
	$tds_tax 				   = $_POST['tds_tax'];
	$tds_amount 			   = $_POST['tds_amount'];
	$net_payable_amount 	   = $_POST['net_payable_amount'];
	$Create_Date=date('Y-m-d h:i:s');

	$query = $conn ->query("select * from iijs_payment_master where Exhibitor_Code='$Exhibitor_Code' and Form_ID='4' AND Payment_Master_Approved='P'");
	$result = $query->fetch_assoc();
	
	$num = $query->num_rows;
	if($num > 0)
		{
		$Payment_Master_OrderNo=$_SESSION['Payment_Master_OrderNo'] = $result['Payment_Master_OrderNo'];
		
		$update = $conn->query("update iijs_payment_master set Form_ID='4',Exhibitor_Code='$Exhibitor_Code',Payment_Master_OrderNo='$Payment_Master_OrderNo',Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',tds_tax='$tds_tax',tds_amount='$tds_amount',net_payable_amount='$net_payable_amount',Modify_Date='$Create_Date' where Payment_Master_OrderNo='$Payment_Master_OrderNo'");
		header('Location: ebs/badges_techprocess.php');
		} else {
			$strNo = rand(1,1000000);
			$Payment_Master_OrderNo = 'BADGE'.$strNo;
			$_SESSION['Payment_Master_OrderNo'] = $Payment_Master_OrderNo;
			
		$update = $conn ->query("insert into iijs_payment_master set Form_ID='4',Exhibitor_Code='$Exhibitor_Code',Payment_Master_OrderNo='$Payment_Master_OrderNo',Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',tds_tax='$tds_tax',tds_amount='$tds_amount',net_payable_amount='$net_payable_amount',Create_Date='$Create_Date',Modify_Date='$Create_Date'");
		$Payment_Master_ID = mysqli_insert_id($conn);
		
		$query=$conn ->query("insert into iijs_badge set Exhibitor_Code='$Exhibitor_Code',Payment_Master_ID='$Payment_Master_ID',Collection_Mode='C',Create_Date='$Create_Date',Modify_Date='$Create_Date'");
		header('Location: ebs/badges_techprocess.php');
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