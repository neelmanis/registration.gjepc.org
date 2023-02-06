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
<title>Badges Fill</title>
</head>

<html> 
<body>
<?php
function BadgeAddress($Exhibitor_Code,$conn)
{
	$query_sel = "SELECT BadgeAddres FROM  iijs_badge_address  where Exhibitor_Code='$Exhibitor_Code'";
	$result_sel = $conn ->query($query_sel);								
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['BadgeAddres'];
		
	}
}

function BadgeCountry($Exhibitor_Code,$conn)
{
	$query_sel = "SELECT BadgeCountry FROM  iijs_badge_address  where Exhibitor_Code='$Exhibitor_Code'";
	$result_sel = $conn ->query($query_sel);								
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['BadgeCountry'];
		
	}
}
function BadgeState($Exhibitor_Code,$conn)
{
	$query_sel = "SELECT BadgeState from  iijs_badge_address  where Exhibitor_Code='$Exhibitor_Code'";
	$result_sel = $conn ->query($query_sel);								
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['BadgeState'];
		
	}
}
function BadgeCity($Exhibitor_Code,$conn)
{
	$query_sel = "SELECT BadgeCity FROM  iijs_badge_address  where Exhibitor_Code='$Exhibitor_Code'";
	$result_sel = $conn ->query($query_sel);								
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['BadgeCity'];
		
	}
}
function BadgePincode($Exhibitor_Code,$conn)
{
	$query_sel = "SELECT BadgePincode FROM  iijs_badge_address  where Exhibitor_Code='$Exhibitor_Code'";
	$result_sel = $conn ->query($query_sel);								
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['BadgePincode'];
		
	}
}
function BadgeMobile($Exhibitor_Code,$conn)
{
	$query_sel = "SELECT BadgeMobile FROM  iijs_badge_address  where Exhibitor_Code='$Exhibitor_Code'";
	$result_sel = $conn ->query($query_sel);								
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['BadgeMobile'];
		
	}
}

$table = $display = "";	
$fn = "BadgesFilled";

/*$sql="SELECT  a.`Customer_No` ,a.Exhibitor_Name, a.`Exhibitor_Contact_Person` ,  a.`Exhibitor_Designation` , a.`Exhibitor_Code`,a.Exhibitor_Phone,a.Exhibitor_Fax,a.`Exhibitor_Email` ,  a.`Exhibitor_DivisionNo` , a.`Exhibitor_Section` ,  a.`Exhibitor_Area` ,  a.`Exhibitor_StallNo1` ,  a.`Exhibitor_StallNo2` ,  a.`Exhibitor_StallNo3` ,  a.`Exhibitor_StallNo4` ,  a.`Exhibitor_StallNo5` ,  a.`Exhibitor_StallNo6` ,  a.`Exhibitor_StallType` ,  a.`Exhibitor_Region`,SUM(CASE b.Badge_Type When 'E' Then 1 else 0 END) as E
,SUM(CASE b.Badge_Type When 'M' Then 1 else 0 END) as M
,SUM(CASE b.Badge_Type When 'S' Then 1 else 0 END) as S
,b.WaveOff,b.WaveOff_Reason,c.BadgeAddres,c.BadgeCountry,c.BadgeCity,c.BadgePincode,c.BadgeState,c.BadgeMobile,c.CarPass1,c.CarPass2,c.Info_Approved,c.Info_Reason,c.Application_Complete,c.Create_Date
FROM  `iijs_exhibitor` a 
inner join `iijs_badge_items` b on a.`Exhibitor_Code` =b.`Exhibitor_Code`
inner join iijs_badge c on a.`Exhibitor_Code` =c.`Exhibitor_Code`
inner join iijs_country_master d on d.Country_ID=a.Exhibitor_Country_ID 
group by b.`Exhibitor_Code`";*/

$sql="SELECT  a.`Customer_No` ,a.Exhibitor_Name, a.`Exhibitor_Contact_Person` ,  a.`Exhibitor_Designation` , a.`Exhibitor_Code`,a.Exhibitor_Phone,a.Exhibitor_Fax,a.`Exhibitor_Email` ,  a.`Exhibitor_DivisionNo` , a.`Exhibitor_Section` ,  a.`Exhibitor_Area` ,  a.`Exhibitor_StallNo1` ,  a.`Exhibitor_StallNo2` ,  a.`Exhibitor_StallNo3` ,  a.`Exhibitor_StallNo4` ,  a.`Exhibitor_StallNo5` ,  a.`Exhibitor_StallNo6` ,  a.`Exhibitor_StallType` ,  a.`Exhibitor_Region`,SUM(CASE b.Badge_Type When 'E' Then 1 else 0 END) as E
,SUM(CASE b.Badge_Type When 'M' Then 1 else 0 END) as M
,SUM(CASE b.Badge_Type When 'S' Then 1 else 0 END) as S
,b.WaveOff,b.WaveOff_Reason,b.`Badge_ID`
FROM  `iijs_exhibitor` a 
inner join manual_iijs2021.`iijs_badge_items` b on a.`Exhibitor_Code` =b.`Exhibitor_Code`
inner join manual_iijs2021.iijs_country_master d on d.country_code=a.Exhibitor_Country_ID 
group by b.`Exhibitor_Code`";

$result=$conn ->query($sql);
			
$table .= '<table <table border="0" cellpadding="0" cellspacing="0"><tr>
<td><b>Customer No</b></td>
<td><b>Exhibitor Name</b></td>
<td><b>Exhibitor Contact Person</b></td>
<td><b>Exhibitor Designation</b></td>
<td><b>Exhibitor Code</b></td>
<td><b>Badge Address </b></td>
<td><b>Badge Country </b></td>
<td><b>Badge State </b></td>
<td><b>Badge City </b></td>
<td><b>Badge Pincode </b></td>
<td><b>Badge Phone </b></td>
<td><b>Exhibitor Fax</b></td>
<td><b>Exhibitor Email</b></td>
<td><b>Exhibitor DivisionNo</b></td>
<td><b>Exhibitor Section</b></td>
<td><b>Exhibitor Area</b></td>
<td><b>Exhibitor StallNo1</b></td>
<td><b>Exhibitor StallNo2</b></td>
<td><b>Exhibitor StallNo3</b></td>
<td><b>Exhibitor StallNo4</b></td>
<td><b>Exhibitor StallNo5</b></td>
<td><b>Exhibitor StallNo6</b></td>
<td><b>Exhibitor StallNo7</b></td>
<td><b>Exhibitor StallNo8</b></td>
<td><b>Exhibitor StallType</b></td>
<td><b>Exhibitor Region</b></td>
<td><b>Total Eligible Exhibitor Badges</b></td>
<td><b>Exhibitor Badges Taken</b></td>
<td><b>Exhibitor Badges Available</b></td>
<td><b>Total Eligible Additional Badges</b></td>
<td><b>Additional Badges Taken</b></td>
<td><b>Additional Badges Available</b></td>
<td><b>Total Eligible Temporary Badges</b></td>
<td><b>Temporary Badges Taken</b></td>
<td><b>Temporary Badges Available</b></td>
<td><b>CarPass1</b></td>
<td><b>CarPass2</b></td>
<td><b>WaveOff</b></td>
<td><b>WaveOff Reason</b></td>
<td><b>Info Approve</b></td>
<td><b>Info Reason</b></td>
<td><b>Application Complete</b></td>
<td><b>Application Date</b></td>
</tr>';

while($rows=$result->fetch_assoc())
{
	$sql1="SELECT * FROM  `iijs_badge_master` where Stall_Area='$rows[Exhibitor_Area]'";
	$result1=$conn ->query($sql1);
	$rows1=$result1->fetch_assoc();
	$EBA=$rows1['Exhibitor_Badges']-$rows['E'];
	$MBA=$rows1['Management_Badges']-$rows['M'];
	$SBA=$rows1['Service_Badges']-$rows['S'];
$table .= '<tr>
<td>'.$rows['Customer_No'].'</td>
<td>'.$rows['Exhibitor_Name'].'</td>
<td>'.$rows['Exhibitor_Contact_Person'].'</td>
<td>'.$rows['Exhibitor_Designation'].'</td>
<td>'.$rows['Exhibitor_Code'].'</td>
<td>'.BadgeAddress($rows['Exhibitor_Code'],$conn).'</td>
<td>'.BadgeCountry($rows['Exhibitor_Code'],$conn).'</td>
<td>'.BadgeState($rows['Exhibitor_Code'],$conn).'</td>
<td>'.BadgeCity($rows['Exhibitor_Code'],$conn).'</td>
<td>'.BadgePincode($rows['Exhibitor_Code'],$conn).'</td>
<td>'.BadgeMobile($rows['Exhibitor_Code'],$conn).'</td> 
<td>'.$rows['Exhibitor_Fax'].'</td>
<td>'.$rows['Exhibitor_Email'].'</td>
<td>'.$rows['Exhibitor_DivisionNo'].'</td>
<td>'.$rows['Exhibitor_Section'].'</td>
<td>'.$rows['Exhibitor_Area'].'</td>
<td>'.$rows['Exhibitor_StallNo1'].'</td>
<td>'.$rows['Exhibitor_StallNo2'].'</td>
<td>'.$rows['Exhibitor_StallNo3'].'</td>
<td>'.$rows['Exhibitor_StallNo4'].'</td>
<td>'.$rows['Exhibitor_StallNo5'].'</td>
<td>'.$rows['Exhibitor_StallNo6'].'</td>
<td>'.$rows['Exhibitor_StallNo7'].'</td>
<td>'.$rows['Exhibitor_StallNo8'].'</td>
<td>'.$rows['Exhibitor_StallType'].'</td>
<td>'.$rows['Exhibitor_Region'].'</td>
<td>'.$rows1['Exhibitor_Badges'].'</td>
<td>'.$rows['E'].'</td>
<td>'.$EBA.'</td>
<td>'.$rows1['Management_Badges'].'</td>
<td>'.$rows['M'].'</td>
<td>'.$MBA.'</td>
<td>'.$rows1['Service_Badges'].'</td>
<td>'.$rows['S'].'</td>
<td>'.$SBA.'</td>
<td>'.$rows['CarPass1'].'</td>
<td>'.$rows['CarPass2'].'</td>
<td>'.$rows['WaveOff'].'</td>
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