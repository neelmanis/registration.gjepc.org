<?php
session_start(); 
ob_start();
include('../db.inc.php');
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
$date=date("d_m_Y");
?>
<?PHP
  // filename for download
	/*$export_filename = "StallLayoutFilled_" . date('Ymd') . ".xls";
	$result = $conn ->query("SELECT a.`Customer_No`,a.`Exhibitor_Name`,a.`Exhibitor_Contact_Person`,a.`Exhibitor_Designation`,a.`Exhibitor_Code`,a.`Exhibitor_City`,a.`Exhibitor_Mobile`,a.`Exhibitor_Phone`,a.`Exhibitor_Email`,a.`Exhibitor_DivisionNo`,a.`Exhibitor_Section`,a.`Exhibitor_Area`,a.`Exhibitor_StallNo1`,a.`Exhibitor_StallNo2`,a.`Exhibitor_StallNo3`,a.`Exhibitor_StallNo4`,a.`Exhibitor_StallNo5`,a.`Exhibitor_StallNo6`,a.`Exhibitor_StallType`,a.`Exhibitor_Scheme`,a.`Exhibitor_Region`,b.`Stall_CustomizedLayout_Image`,b.`option`, IF(b.`Stall_Display_Light`=0,'White','Yellow') as `Stall_Display_Light(General)`,IF(b.`Stall_Display_Light_d`=0,'White','Yellow') as `Stall_Display_Light(Display)`,b.`Stall_Image_Layout_Type`,b.`Stall_Basic_Layout_Approved`,b.`Stall_Basic_Layout_Reason`,b.`Application_Complete`,b.`Create_Date` FROM `iijs_exhibitor` a,iijs_stall_master b where a.`Exhibitor_Code`=b.`Exhibitor_Code` order by b.`Modify_Date`  asc ") or die('Query failed!');
	//$result = $conn->query("SELECT a.`Customer_No`,a.`Exhibitor_Name`,a.`Exhibitor_Contact_Person`,a.`Exhibitor_Designation`,a.`Exhibitor_Code`,a.`Exhibitor_City`,a.`Exhibitor_Mobile`,a.`Exhibitor_Phone`,a.`Exhibitor_Email`,a.`Exhibitor_DivisionNo`,a.`Exhibitor_Section`,a.`Exhibitor_Area`,a.`Exhibitor_StallNo1`,a.`Exhibitor_StallNo2`,a.`Exhibitor_StallNo3`,a.`Exhibitor_StallNo4`,a.`Exhibitor_StallNo5`,a.`Exhibitor_StallNo6`,a.`Exhibitor_StallType`,a.`Exhibitor_Scheme`,a.`Exhibitor_Region`,b.`Stall_CustomizedLayout_Image`,b.`option`, IF(b.`Stall_Display_Light`=0,'White','Yellow') as `Stall_Display_Light(General)`,IF(b.`Stall_Display_Light_d`=0,'White','Yellow') as `Stall_Display_Light(Display)`,b.`Stall_Image_Layout_Type`,b.`Stall_Basic_Layout_Approved`,b.`Stall_Basic_Layout_Reason`,b.`Application_Complete`,b.`Create_Date` FROM `iijs_exhibitor` a left join iijs_stall_master b on a.`Exhibitor_Code`=b.`Exhibitor_Code` where a.`Exhibitor_Code`=b.`Exhibitor_Code` order by b.`Modify_Date` Asc ") or die('Query failed!');

	 $count = $result->num_rows;
	//$data = '';
	$header = '';
	for ($i = 0; $i < $count; $i++){
		// foreach(mysqli_fetch_fields($result) as $field){
		//   $header .= '"' . $field->name . '",';
		//   unset($field);
		// }

		$dataType = mysqli_fetch_field_direct($result, $i);

		if(isset($dataType->name)){
			$header .= $dataType->name."\t";
		}
	
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
  $filename = "StallLayoutFilled_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");
  
  $out = fopen("php://output", 'w');

	$flag = false;
	$sql="SELECT a.`Customer_No`,a.`Exhibitor_Name`,a.`Exhibitor_Contact_Person`,a.`Exhibitor_Designation`,a.`Exhibitor_Code`,a.`Exhibitor_City`,a.`Exhibitor_Mobile`,a.`Exhibitor_Phone`,a.`Exhibitor_Email`,a.`Exhibitor_DivisionNo`,a.`Exhibitor_Section`,a.`Exhibitor_Area`,a.`Exhibitor_StallNo1`,a.`Exhibitor_StallNo2`,a.`Exhibitor_StallNo3`,a.`Exhibitor_StallNo4`,a.`Exhibitor_StallNo5`,a.`Exhibitor_StallNo6`,a.`Exhibitor_StallType`,a.`Exhibitor_Scheme`,a.`Exhibitor_Region`,b.`Stall_CustomizedLayout_Image`,b.`option`, IF(b.`Stall_Display_Light`=0,'White','Yellow') as `Stall_Display_Light(General)`,IF(b.`Stall_Display_Light_d`=0,'White','Yellow') as `Stall_Display_Light(Display)`,b.`Stall_Image_Layout_Type`,b.`Stall_Basic_Layout_Approved`,b.`Stall_Basic_Layout_Reason`,b.`Application_Complete`,b.`Create_Date` FROM `iijs_exhibitor` a,iijs_stall_master b where a.`Exhibitor_Code`=b.`Exhibitor_Code` order by b.`Modify_Date`  asc ";
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
