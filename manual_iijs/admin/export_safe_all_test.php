<?php
session_start(); 
ob_start();
include('../db.inc.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
$date=date("d_m_Y");
?>
<?php
  // filename for download
  $table = '';$display='';
  $export_filename = "SafeRentalALL_" . date('Ymd') . ".xls";
  $result = $conn ->query("SELECT a.`Customer_No`,a.`Exhibitor_Name`,a.`Exhibitor_Contact_Person`,a.`Exhibitor_Designation`,a.`Exhibitor_Code` ,
  						  a.`Exhibitor_Address1`,a.`Exhibitor_Address2`,a.`Exhibitor_Address3`, a.`Exhibitor_City`,a.`Exhibitor_Pincode`,
						  a.`Exhibitor_Mobile`,  a.`Exhibitor_Phone`,a.`Exhibitor_Email`,a.`Exhibitor_Website`,a.`Exhibitor_DivisionNo`, 
						  a.`Exhibitor_Section`,a.`Exhibitor_Area`,  a.`Exhibitor_StallNo1`,a.`Exhibitor_StallNo2`,a.`Exhibitor_StallNo3`,
						  a.`Exhibitor_StallNo4`,a.`Exhibitor_StallNo5`,a.`Exhibitor_StallNo6`,a.`Exhibitor_StallType`,a.`Exhibitor_Region`,
						  b.`Create_Date`,b.`gstin`,d.Payment_Master_Approved,
						  SUM(CASE c.Safe_ID when 1 then c.Item_Quantity ELSE 0 END) as '26-Def PLUS',
						  SUM(CASE c.Safe_ID when 2 then c.Item_Quantity ELSE 0 END) as '41-Def PLUS',
						  SUM(CASE c.Safe_ID when 3 then c.Item_Quantity ELSE 0 END) as '61-Def PLUS',b.Application_Complete 
						  FROM `iijs_safe_rental_items` c inner join iijs_safe_rental b on b.Safe_Rental_ID=c.Safe_Rental_ID 
						  inner join iijs_exhibitor a on a.`Exhibitor_Code`=b.Exhibitor_Code 
						  Join iijs_payment_master as d on d.Payment_Master_ID = b.Payment_Master_ID
						  group by c.Safe_Rental_ID") 
						  or die('Query failed!');

	
	$table .= '<table  border="0" cellpadding="0" cellspacing="0"><tr>
		<td><b>Customer No</b></td>
		<td><b>Exhibitor Code</b></td>
		<td><b>Exhibitor Name</b></td>
		<td><b>Exhibitor Contact Person</b></td>
		<td><b>Exhibitor Designation</b></td>
		<td><b>Exhibitor Address1</b></td>
		<td><b>Exhibitor Address2<b></td>
		<td><b>Exhibitor City<b></td>
		<td><b>Exhibitor Pincode<b></td>
		<td><b>Exhibitor Mobile<b></td>
		<td><b>Exhibitor Phone<b></td>
		<td><b>Exhibitor Email<b></td>
		<td><b>Exhibitor Website<b></td>
		<td><b>Exhibitor DivisionNo<b></td>
		<td><b>Exhibitor Section<b></td>
		<td><b>Exhibitor Area<b></td>
		<td><b>Exhibitor StallNo1<b></td>
		<td><b>Exhibitor StallNo2<b></td>
		<td><b>Exhibitor StallNo3<b></td>
		<td><b>Exhibitor StallNo4<b></td>
		<td><b>Exhibitor StallNo5<b></td>
		<td><b>Exhibitor StallNo6<b></td>
		<td><b>Exhibitor StallType<b></td>
		<td><b>Exhibitor Region<b></td>
		<td><b>Gstin<b></td>
		<td><b>Payment Master Approved<b></td>
		<td><b>Create Date<b></td>
		</tr>';

		while($rows=$result->fetch_assoc())
		{       
			$table .= '<tr>
			<td>'.$rows['Customer_No'].'</td>
			<td>'.$rows['Exhibitor_Code'].'</td>
			<td>'.$rows['Exhibitor_Name'].'</td>
			<td>'.$rows['Exhibitor_Contact_Person'].'</td>
			<td>'.$rows['Exhibitor_Designation'].'</td>
			<td>'.$rows['Exhibitor_Address1'].'</td>
			<td>'.$rows['Exhibitor_Address2'].'</td>
			<td>'.$rows['Exhibitor_City'].'</td>
			<td>'.$rows['Exhibitor_Pincode'].'</td>
			<td>'.$rows['Exhibitor_Mobile'].'</td>
			<td>'.$rows['Exhibitor_Phone'].'</td>
			<td>'.$rows['Exhibitor_Email'].'</td>
			<td>'.$rows['Exhibitor_Website'].'</td>
			<td>'.$rows['Exhibitor_DivisionNo'].'</td>
			<td>'.$rows['Exhibitor_Section'].'</td>
			<td>'.$rows['Exhibitor_Area'].'</td>
			<td>'.$rows['Exhibitor_StallNo1'].'</td>
			<td>'.$rows['Exhibitor_StallNo2'].'</td>
			<td>'.$rows['Exhibitor_StallNo3'].'</td>
			<td>'.$rows['Exhibitor_StallNo4'].'</td>
			<td>'.$rows['Exhibitor_StallNo5'].'</td>
			<td>'.$rows['Exhibitor_StallNo6'].'</td>
			<td>'.$rows['Exhibitor_StallType'].'</td>
			<td>'.$rows['Exhibitor_Region'].'</td>
			<td>'.$rows['gstin'].'</td>
			<td>'.$rows['Payment_Master_Approved'].'</td>
			<td>'.$rows['Create_Date'].'</td>
			
			</tr>';
		}
	$table .= $display;
	$table .= '</table>';	
	// create table header showing to download a xls (excel) file
	header("Content-type: application/x-msdownload"); 
	# replace excelfile.xls with whatever you want the filename to default to
	header("Content-Disposition: attachment; filename=$export_filename.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	echo $table;
?>
