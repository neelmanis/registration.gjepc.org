<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");
?>
<?PHP
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
  $result = mysql_query("SELECT  `Customer_No` ,  `Exhibitor_Name` ,  `Exhibitor_Contact_Person` ,  `Exhibitor_Designation` ,  `Exhibitor_Code` ,Exhibitor_Address1,Exhibitor_Address2,Exhibitor_Address3,  `Exhibitor_City`,Exhibitor_State,Exhibitor_Pincode ,  `Exhibitor_Mobile` ,  `Exhibitor_Phone` ,  `Exhibitor_Email` ,  `Exhibitor_DivisionNo` , `Exhibitor_Section` ,  `Exhibitor_Area` ,  `Exhibitor_StallNo1` ,  `Exhibitor_StallNo2` ,  `Exhibitor_StallNo3` ,  `Exhibitor_StallNo4` ,  `Exhibitor_StallNo5` ,  `Exhibitor_StallNo6` ,  `Exhibitor_StallType` ,  `Exhibitor_Region` FROM  `iijs_exhibitor` WHERE  `Exhibitor_Code` NOT IN (SELECT Exhibitor_Code FROM  `iijs_badge` )") or die('Query failed!');
  while(false !== ($row = mysql_fetch_assoc($result))) {
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

