<?php 
include('header_include.php');
if(isset($_SESSION['EXHIBITOR_CODE']))
{
	header("location:manual_list.php");
	exit;
}
?>

<?php
$Exhibitor_Code = $_REQUEST['Exhibitor_Code'];

if(isset($_REQUEST['action']))
{
	$action=$_REQUEST['action'];
	
	if($action=="admin_login")
	{
		$query="Select * from  iijs_exhibitor where Exhibitor_Code='$Exhibitor_Code'";
		$result=$conn ->query($query);
		$rows_info=$result->fetch_assoc();
		$cnt= $result->num_rows;
		if($cnt==1)
		{
			$_SESSION['EXHIBITOR_CODE']=$rows_info['Exhibitor_Code'];
			$_SESSION['CUST_NO']=$rows_info['Customer_No'];
			$_SESSION['EMAILID']=$rows_info['Exhibitor_Email'];
			$_SESSION['EXHIBITOR_NAME']=$rows_info['Exhibitor_Name'];
			$_SESSION['Exhibitor_Country_ID']=$rows_info['Exhibitor_Country_ID'];
			$_SESSION['ACCESS']="ADMIN";
			//header('location:manual_list.php');
			header('location:admin_manual_list.php');
			exit;
		}
		else
		{
			echo '<script type="text/javascript">'; 
			echo 'alert("Wrong EXHIBITOR CODE");'; 
			echo 'window.location.href = "http://iijs-signature.org/manual/index.php";';
			echo '</script>';
		}
		
	}else
	{
		echo '<script type="text/javascript">'; 
		echo 'alert("Wrong EXHIBITOR CODE");'; 
		echo 'window.location.href = "http://iijs-signature.org";';
		echo '</script>';
	}
	}
		

?>