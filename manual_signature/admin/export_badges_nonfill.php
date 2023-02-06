<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");
?>
<?PHP
  // filename for download
  /*$export_filename = "BadgesNonFilled_" . date('Ymd') . ".xls";
  
	$result = $conn ->query("SELECT a.`Customer_No` ,a.`sale_order_number` , a.`Exhibitor_Name` , a.`Exhibitor_Contact_Person` , a.`Exhibitor_Designation` , a.`Exhibitor_Code` ,a.Exhibitor_Address1,a.Exhibitor_Address2,a.Exhibitor_Address3, a.`Exhibitor_City`,a.Exhibitor_State, a.`Exhibitor_Mobile` , a.`Exhibitor_Phone` ,a.Exhibitor_Fax, a.`Exhibitor_Email` , a.`Exhibitor_DivisionNo` , a.`Exhibitor_Section` , a.`Exhibitor_Area` , a.`Exhibitor_StallNo1` , a.`Exhibitor_StallNo2` , a.`Exhibitor_StallNo3` , a.`Exhibitor_StallNo4` , a.`Exhibitor_StallNo5` , a.`Exhibitor_StallNo6` , a.`Exhibitor_StallType` , a.`Exhibitor_Region` FROM manual_iijs2021.`iijs_exhibitor` a WHERE  `Exhibitor_Code` NOT IN (SELECT Exhibitor_Code FROM  `iijs_badge` )") or die('Query failed!');
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
echo $header."\n".$data;*/

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
  $filename = "BadgesNonFilled_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");
  
  $out = fopen("php://output", 'w');

	$flag = false;
	$sql="SELECT a.`Customer_No` ,a.`sale_order_number` , a.`Exhibitor_Name` , a.`Exhibitor_Contact_Person` , a.`Exhibitor_Designation` , a.`Exhibitor_Code` ,a.Exhibitor_Address1,a.Exhibitor_Address2,a.Exhibitor_Address3, a.`Exhibitor_City`,a.Exhibitor_State, a.`Exhibitor_Mobile` , a.`Exhibitor_Phone` ,a.Exhibitor_Fax, a.`Exhibitor_Email` , a.`Exhibitor_DivisionNo` , a.`Exhibitor_Section` , a.`Exhibitor_Area` , a.`Exhibitor_StallNo1` , a.`Exhibitor_StallNo2` , a.`Exhibitor_StallNo3` , a.`Exhibitor_StallNo4` , a.`Exhibitor_StallNo5` , a.`Exhibitor_StallNo6` , a.`Exhibitor_StallType` , a.`Exhibitor_Region` FROM manual_signature.`iijs_exhibitor` a WHERE  `Exhibitor_Code` NOT IN (SELECT Exhibitor_Code FROM  `iijs_badge` )";
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

