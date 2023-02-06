<?php 
session_start();
include ("db.inc.php");
include ("functions.php");

if(isset($_POST['actiontype']) && $_POST['actiontype']=="addFines")
{	//echo '<pre>'; print_r($_POST); exit;
	
	$exhibitor_code=$_SESSION['EXHIBITOR_CODE'];
	
	$checks = "select Exhibitor_Code from jewellery_fineness where Exhibitor_Code='$exhibitor_code'";
	$executeResult = $conn ->query($checks);
	$numResult1 = $executeResult->num_rows;
	if($numResult1==0){
	$sql_insert="insert into jewellery_fineness set Exhibitor_Code='$exhibitor_code',isDownload='Y',Create_Date=NOW()";
	$execute= $conn ->query($sql_insert);
	if(!$execute) die ($conn->error);
	}	
}
?>