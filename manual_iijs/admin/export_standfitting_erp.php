<?php
session_start(); 
ob_start();
include('../db.inc.php'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
<title>StandFitting ERP Fill</title>
</head>

<html>
<body>



<?php

$table = $display = "";	
$fn = "Signature_2017_Standfiting_Report";

$sql="SELECT a.Customer_No,b.Exhibitor_Code,a.Exhibitor_Name,a.`Exhibitor_Section`,c.`Item_Master_ID`,c.`Item_Quantity`,c.`Item_Rate`,b.Stand_OrderNo,
b.Create_Date,b.Items_Approved,b.Application_Complete
FROM iijs_stand b left join iijs_exhibitor a on a.Exhibitor_Code=b.Exhibitor_Code 
left join iijs_stand_items c on b.Stand_ID=c.Stand_ID where b.Application_Complete='Y' or b.Application_Complete='N' or b.Application_Complete='P'";

$result=mysql_query($sql);
			
$table .= '<table <table border="0" cellpadding="0" cellspacing="0"><tr>
<td><b>Customer Name</b></td>
<td><b>Exhibitor Code</b></td>
<td><b>Exhibitor Name</b></td>
<td><b>Exhibitor Section</b></td>
<td><b>Item Name</b></td>
<td><b>Item ERP Code</b></td>
<td><b>Item Quantity</b></td>
<td><b>Item Rate</b></td>
<td><b>Payment Master Surcharge</b></td>
<td><b>Create Date</b></td>
<td><b>Stand Order No</b></td>
<td><b>Item Approved</b></td>
<td><b>Payment Master Approved</b></td>
</tr>';

while($rows=mysql_fetch_array($result))
{
	$sql1="SELECT a.`Item_Master_ID` , b.Item_Description, b.Item_ERPCode
FROM  `iijs_stand_items` a
LEFT JOIN iijs_stand_items_master b ON a.Item_Master_ID = b.Item_ID
 where a.Item_Master_ID='$rows[Item_Master_ID]'";
	$result1=mysql_query($sql1);
	$rows1=mysql_fetch_array($result1);
	
$table .= '<tr>
<td>'.$rows['Customer_No'].'</td>
<td>'.$rows['Exhibitor_Code'].'</td>
<td>'.$rows['Exhibitor_Name'].'</td>
<td>'.$rows['Exhibitor_Section'].'</td>
<td>'.$rows1['Item_Description'].'</td>
<td>'.$rows1['Item_ERPCode'].'</td>
<td>'.$rows['Item_Quantity'].'</td>
<td>'.$rows['Item_Rate'].'</td>
<td>0</td>
<td>'.$rows['Create_Date'].'</td>
<td>'.$rows['Stand_OrderNo'].'</td>
<td>'.$rows['Application_Complete'].'</td>
<td>'.$rows['Application_Complete'].'</td>
</tr>';
}
$table .= $display;
$table .= '</table>';

		header("Content-type: application/x-msdownload"); 
		# replace excelfile.xls with whatever you want the filename to default to
		header("Content-Disposition: attachment; filename=$fn.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $table;
?>
</body>
</html>