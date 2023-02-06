<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");
?>
<?php
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
  $filename = "BadgeTempMaster_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");
  
  $out = fopen("php://output", 'w');

$flag = false;
$sql="select  a.`Customer_No`,a.`Exhibitor_Name`,a.`Exhibitor_Contact_Person`,a.`Exhibitor_Designation`,a.`Exhibitor_Code`,a.`Exhibitor_City`,a.`Exhibitor_Mobile`,a.`Exhibitor_Phone`,a.`Exhibitor_Email`,a.`Exhibitor_DivisionNo`,a.`Exhibitor_Section`,a.`Exhibitor_Area`,a.`Exhibitor_StallNo1`,a.`Exhibitor_StallType`,a.`Exhibitor_Region`,t.Badge_Item_ID,t.Replace_Badge_Item_ID,t.Badge_Type,t.Badge_Name,t.Badge_Designation,t.Surcharge
from manual_signature.iijs_exhibitor a,manual_signature.iijs_badge_items_tmp t where a.`Exhibitor_Code`=t.`Exhibitor_Code`";
$result = $conn ->query($sql);
while($row = $result->fetch_assoc()) {
    if(!$flag){
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
