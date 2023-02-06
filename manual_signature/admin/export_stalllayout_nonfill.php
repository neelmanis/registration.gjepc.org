<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");
?>
<?PHP
  // filename for download
  /*$export_filename = "StallLayoutNonFilled_" . date('Ymd') . ".xls";
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
*/

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
  $filename = "StallLayoutNonFilled_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");
  
  $out = fopen("php://output", 'w');

	$flag = false;
	$sql="SELECT `Customer_No`,`Exhibitor_Name`,`Exhibitor_Contact_Person`,`Exhibitor_Designation`,`Exhibitor_Code`,`Exhibitor_City`,`Exhibitor_Mobile`,`Exhibitor_Phone`,`Exhibitor_Email`,`Exhibitor_DivisionNo`,`Exhibitor_Section`,`Exhibitor_Area`,`Exhibitor_StallNo1`,`Exhibitor_StallNo2`,`Exhibitor_StallNo3`,`Exhibitor_StallNo4`,`Exhibitor_StallNo5`,`Exhibitor_StallNo6`,`Exhibitor_StallType`,`Exhibitor_Region` FROM `iijs_exhibitor` WHERE   `Exhibitor_Code` NOT IN (SELECT Exhibitor_Code FROM  `iijs_stall_master`)";
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
