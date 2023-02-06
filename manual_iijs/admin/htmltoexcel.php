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
<title>BAND Function</title>
</head>

<html>
<body>



<?php

$table = $display = "";	
$fn = "nitin";

$sql="SELECT  a.`Exhibitor_Code` ,a.Exhibitor_Name,a.Exhibitor_Area,
SUM(CASE b.Badge_Type When 'E' Then 1 else 0 END) as E
,SUM(CASE b.Badge_Type When 'S' Then 1 else 0 END) as S
,c.CarPass1,c.CarPass2,c.Info_Approved,c.Info_Reason,c.Application_Complete,c.Create_Date
FROM  `iijs_exhibitor` a 
inner join `iijs_badge_items` b on a.`Exhibitor_Code` =b.`Exhibitor_Code`
inner join iijs_badge c on a.`Exhibitor_Code` =c.`Exhibitor_Code`
group by b.`Exhibitor_Code`";

$result=mysql_query($sql);
			
$table .= '<table <table border="0" cellpadding="0" cellspacing="0"><tr>
<td><b>Exhibitor Code</b></td>
<td><b>Exhibitor Name</b></td>
<td><b>Exhibitor Area</b></td>
<td><b>Total Eligible Exhibitor Badges</b></td>
<td><b>Exhibitor Badges Taken</b></td>
<td><b>Exhibitor Badges Available</b></td>
<td><b>Total Eligible Service Badges</b></td>
<td><b>Service Badges Taken</b></td>
<td><b>Service Badges Available</b></td>
<td><b>CarPass1</b></td>
<td><b>CarPass2</b></td>
<td><b>Info Approve</b></td>
<td><b>Info Reason</b></td>
<td><b>Application Complete</b></td>
<td><b>Application Date</b></td>
</tr>';

while($rows=mysql_fetch_array($result))
{
	$sql1="SELECT * FROM  `iijs_badge_master` where Stall_Area='$rows[Exhibitor_Area]'";
	$result1=mysql_query($sql1);
	$rows1=mysql_fetch_array($result1);
	$EBA=$rows1['Exhibitor_Badges']-$rows['E'];
	$SBA=$rows1['Service_Badges']-$rows['S'];
$table .= '<tr>
<td>'.$rows['Exhibitor_Code'].'</td>
<td>'.$rows['Exhibitor_Name'].'</td>
<td>'.$rows['Exhibitor_Area'].'</td>
<td>'.$rows1['Exhibitor_Badges'].'</td>
<td>'.$rows['E'].'</td>
<td>'.$EBA.'</td>
<td>'.$rows1['Service_Badges'].'</td>
<td>'.$rows['S'].'</td>
<td>'.$SBA.'</td>
<td>'.$rows['CarPass1'].'</td>
<td>'.$rows['CarPass2'].'</td>
<td>'.$rows['Info_Approved'].'</td>
<td>'.$rows['Info_Reason'].'</td>
<td>'.$rows['Application_Complete'].'</td>
<td>'.$rows['Create_Date'].'</td>
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