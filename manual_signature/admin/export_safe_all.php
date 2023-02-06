<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");
?>
<?php

  // filename for download
//   $export_filename = "SafeRentalALL_" . date('Ymd') . ".xls";
//   $result = $conn ->query("SELECT a.`Customer_No`,a.`Exhibitor_Name`,a.`Exhibitor_Contact_Person`,a.`Exhibitor_Designation`,a.`Exhibitor_Code` ,  a.`Exhibitor_Address1`,a.`Exhibitor_Address2`,a.`Exhibitor_Address3`, a.`Exhibitor_City`,a.`Exhibitor_Pincode`,a.`Exhibitor_Mobile`,  a.`Exhibitor_Phone`,a.`Exhibitor_Email`,a.`Exhibitor_Website`,a.`Exhibitor_DivisionNo`, a.`Exhibitor_Section`,a.`Exhibitor_Area`,  a.`Exhibitor_StallNo1`,a.`Exhibitor_StallNo2`,a.`Exhibitor_StallNo3`,a.`Exhibitor_StallNo4`,a.`Exhibitor_StallNo5`,a.`Exhibitor_StallNo6` ,  a.`Exhibitor_StallType`,a.`Exhibitor_Region`, b.`Create_Date`,b.Layout_Received,b.Layout_Approve,b.`gstin`,
// SUM(CASE c.Safe_ID when 1 then c.Item_Quantity ELSE 0 END) as '26-Def PLUS'
// ,SUM(CASE c.Safe_ID when 2 then c.Item_Quantity ELSE 0 END) as '41-Def PLUS'
// ,SUM(CASE c.Safe_ID when 3 then c.Item_Quantity ELSE 0 END) as '61-Def PLUS',b.Info_Approved,b.Application_Complete
// FROM `iijs_safe_rental_items` c
// inner join iijs_safe_rental b on b.Safe_Rental_ID=c.Safe_Rental_ID
// inner join iijs_exhibitor a on a.`Exhibitor_Code`=b.Exhibitor_Code group by c.Safe_Rental_ID") or die('Query failed!');
// 	$count = $result->num_rows;
// 	$header = '';
// 	for ($i = 0; $i < $count; $i++){
// 	$header .= mysqli_fetch_field_direct($result, $i)->name."\t";
// 	}
// 	while($row = $result->fetch_assoc()){
// 		$line = '';
// 		foreach($row as $value){
// 		if(!isset($value) || $value == ""){
// 		$value = "\t";
// 		}else{
// 		$value = str_replace('"', '""', $value);
// 		$value = stripslashes($value);
// 		$value = '"' . $value . '"' . "\t";
// 		}
// 		$line .= $value;
// 		}
// 		$data .= trim($line)."\n";
// 	}
	
// $data = str_replace("\r", "", $data);
// if ($data == "") {
// $data = "\nNo Data Found\n";
// }
// // create table header showing to download a xls (excel) file
// header("Content-type: application/octet-stream");
// header("Content-Disposition: attachment; filename=$export_filename");
// header("Cache-Control: public");
// header("Content-length: ".strlen($data)); // tells file size
// header("Pragma: no-cache");
// header("Expires: 0");
// // output data
// echo $header."\n".$data;


function cleanData(&$str)
  {
    if($str == 't') $str = 'TRUE';
    if($str == 'f') $str = 'FALSE';
    if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
      $str = "'$str";
    }
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // filename for download
  $filename = "SafeRentalALL_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");
  
  $out = fopen("php://output", 'w');

$flag = false;
$sql="SELECT a.`Customer_No`,a.`Exhibitor_Name`,a.`Exhibitor_Contact_Person`,a.`Exhibitor_Designation`,a.`Exhibitor_Code` ,  a.`Exhibitor_Address1`,a.`Exhibitor_Address2`,a.`Exhibitor_Address3`, a.`Exhibitor_City`,a.`Exhibitor_Pincode`,a.`Exhibitor_Mobile`,  a.`Exhibitor_Phone`,a.`Exhibitor_Email`,a.`Exhibitor_Website`,a.`Exhibitor_DivisionNo`, a.`Exhibitor_Section`,a.`Exhibitor_Area`,  a.`Exhibitor_StallNo1`,a.`Exhibitor_StallNo2`,a.`Exhibitor_StallNo3`,a.`Exhibitor_StallNo4`,a.`Exhibitor_StallNo5`,a.`Exhibitor_StallNo6` ,  a.`Exhibitor_StallType`,a.`Exhibitor_Region`, b.`Create_Date`,b.Layout_Received,b.Layout_Approve,b.`gstin`,b.utr_no,
		SUM(CASE  when c.Safe_ID = 1 or c.Safe_ID=4	then c.Item_Quantity  ELSE 0 END) as '26-Def PLUS'
		,SUM(CASE  when c.Safe_ID=2 or c.Safe_ID=5 then c.Item_Quantity ELSE 0 END) as '41-Def PLUS'
		,SUM(CASE  when c.Safe_ID=3 or c.Safe_ID=6 then c.Item_Quantity ELSE 0 END) as '61-Def PLUS',b.Info_Approved,b.Application_Complete
		FROM `iijs_safe_rental_items` c
		inner join iijs_safe_rental b on b.Safe_Rental_ID=c.Safe_Rental_ID
		inner join iijs_exhibitor a on a.`Exhibitor_Code`=b.Exhibitor_Code group by c.Safe_Rental_ID";
$result = $conn ->query($sql);
while($row = $result->fetch_assoc()) {
    if(!$flag) {
      // display field/column names as first row
      fputcsv($out, array_keys($row), ',', '"');
      $flag = true;
    }
    array_walk($row, 'cleanData');
    fputcsv($out, array_values($row), ',', '"');
  }

  fclose($out);
  exit;

?>
