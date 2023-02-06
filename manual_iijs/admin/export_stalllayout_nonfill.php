<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");
?>
<?PHP
  // filename for download
  $export_filename = "StallLayoutNonFilled_" . date('Ymd') . ".xls";
  $result = $conn ->query("SELECT `Customer_No`,`Exhibitor_Name`,`Exhibitor_Contact_Person`,`Exhibitor_Designation`,`Exhibitor_Code`,`Exhibitor_City`,`Exhibitor_Mobile`,`Exhibitor_Phone`,`Exhibitor_Email`,`Exhibitor_DivisionNo`,`Exhibitor_Section`,`Exhibitor_Area`,`Exhibitor_StallNo1`,`Exhibitor_StallNo2`,`Exhibitor_StallNo3`,`Exhibitor_StallNo4`,`Exhibitor_StallNo5`,`Exhibitor_StallNo6`,`Exhibitor_StallType`,`Exhibitor_Region` FROM `iijs_exhibitor` WHERE   `Exhibitor_Code` NOT IN (SELECT Exhibitor_Code FROM  `iijs_stall_master`)") or die('Query failed!');
  
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
