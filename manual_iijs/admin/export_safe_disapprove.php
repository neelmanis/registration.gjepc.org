<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");
?>
<?PHP
  // filename for download
  $export_filename = "SafeRentalDisApproved_" . date('Ymd') . ".xls";

  $result = $conn ->query("SELECT a.`Customer_No` ,a.`Exhibitor_Name` ,a.`Exhibitor_Contact_Person` ,a.`Exhibitor_Designation` ,  a.`Exhibitor_Code` ,  a.`Exhibitor_Address1` ,  a.`Exhibitor_Address2` ,  a.`Exhibitor_Address3` , a.`Exhibitor_City` , a.`Exhibitor_Mobile` ,  a.`Exhibitor_Phone` ,  a.`Exhibitor_Email`,a.`Exhibitor_Website` , a.`Exhibitor_DivisionNo` ,  a.`Exhibitor_Section` ,  a.`Exhibitor_Area` ,  a.`Exhibitor_StallNo1` , a.`Exhibitor_StallNo2` ,  a.`Exhibitor_StallNo3` ,  a.`Exhibitor_StallNo4` , a.`Exhibitor_StallNo5` ,  a.`Exhibitor_StallNo6` ,  a.`Exhibitor_StallType` ,  a.`Exhibitor_Region` ,
  b.`gstin`,
SUM(CASE c.Safe_ID when 1 then c.Item_Quantity ELSE 0 END) as '26-Def PLUS'
,SUM(CASE c.Safe_ID when 2 then c.Item_Quantity ELSE 0 END) as '41-Def PLUS'
,SUM(CASE c.Safe_ID when 3 then c.Item_Quantity ELSE 0 END) as '61-Def PLUS'
FROM `iijs_safe_rental_items` c
inner join iijs_safe_rental b on b.Safe_Rental_ID=c.Safe_Rental_ID
inner join iijs_exhibitor a on a.`Exhibitor_Code`=b.Exhibitor_Code where b.Application_Complete='N'
group by c.Safe_Rental_ID") or die('Query failed!');
	$count = $result->num_rows;
	$header = '';
	for ($i = 0; $i < $count; $i++){
	$header .= mysqli_fetch_field_direct($result, $i)->name."\t";
	}
	while($row = $result->fetch_assoc()){
		$line = '';
		foreach($row as $value){
		if(!isset($value) || $value == ""){
		$value = "\t";
		}else{
		$value = str_replace('"', '""', $value);
		$value = stripslashes($value);
		$value = '"' . $value . '"' . "\t";
		}
		$line .= $value;
		}
		$data .= trim($line)."\n";
	}
	
$data = str_replace("\r", "", $data);
if ($data == "") {
$data = "\nNo Data Found\n";
}
// create table header showing to download a xls (excel) file
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$export_filename");
header("Cache-Control: public");
header("Content-length: ".strlen($data)); // tells file size
header("Pragma: no-cache");
header("Expires: 0");
// output data
echo $header."\n".$data;
?>
