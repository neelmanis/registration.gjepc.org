<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");
ini_set('display_errors', 1);
    ini_set('error_reporting', E_ALL);

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
  $filename = "SafeRentalApproved_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");

  $out = fopen("php://output", 'w');

  $flag = false;
  /*$result = mysql_query("SELECT a.`Customer_No` ,a.`Exhibitor_Name` ,a.`Exhibitor_Contact_Person` ,a.`Exhibitor_Designation` ,  a.`Exhibitor_Code` ,  a.`Exhibitor_Address1` ,  a.`Exhibitor_Address2` ,  a.`Exhibitor_Address3` , a.`Exhibitor_City` , a.`Exhibitor_Mobile` ,  a.`Exhibitor_Phone` ,  a.`Exhibitor_Email`,a.`Exhibitor_Website` , a.`Exhibitor_DivisionNo` ,  a.`Exhibitor_Section` ,  a.`Exhibitor_Area` ,  a.`Exhibitor_StallNo1` , a.`Exhibitor_StallNo2` ,  a.`Exhibitor_StallNo3` ,  a.`Exhibitor_StallNo4` , a.`Exhibitor_StallNo5` ,  a.`Exhibitor_StallNo6` ,  a.`Exhibitor_StallType` ,  a.`Exhibitor_Region` ,
  b.`gstin`,
SUM(CASE c.Safe_ID when 1 then c.Item_Quantity ELSE 0 END) as '26-Def PLUS'
,SUM(CASE c.Safe_ID when 2 then c.Item_Quantity ELSE 0 END) as '41-Def PLUS'
,SUM(CASE c.Safe_ID when 3 then c.Item_Quantity ELSE 0 END) as '61-Def PLUS'
FROM `iijs_safe_rental_items` c
inner join iijs_safe_rental b on b.Safe_Rental_ID=c.Safe_Rental_ID
inner join iijs_exhibitor a on a.`Exhibitor_Code`=b.Exhibitor_Code where b.Application_Complete='Y'
group by c.Safe_Rental_ID") or die('Query failed!');
  while(false !== ($row = mysql_fetch_assoc($result))) {
    if(!$flag) {
      // display field/column names as first row
      fputcsv($out, array_keys($row), ',', '"');
      $flag = true;
    }
    array_walk($row, 'cleanData');
    fputcsv($out, array_values($row), ',', '"');
  }*/

  $sql="SELECT a.`Customer_No` ,a.`Exhibitor_Name` ,a.`Exhibitor_Contact_Person` ,a.`Exhibitor_Designation` ,  a.`Exhibitor_Code` ,  a.`Exhibitor_Address1` ,  a.`Exhibitor_Address2` ,  a.`Exhibitor_Address3` , a.`Exhibitor_City` , a.`Exhibitor_Mobile` ,  a.`Exhibitor_Phone` ,  a.`Exhibitor_Email`,a.`Exhibitor_Website` , a.`Exhibitor_DivisionNo` ,  a.`Exhibitor_Section` ,  a.`Exhibitor_Area` ,  a.`Exhibitor_StallNo1` , a.`Exhibitor_StallNo2` ,  a.`Exhibitor_StallNo3` ,  a.`Exhibitor_StallNo4` , a.`Exhibitor_StallNo5` ,  a.`Exhibitor_StallNo6` ,  a.`Exhibitor_StallType` ,  a.`Exhibitor_Region` ,
  b.`gstin`,
SUM(CASE c.Safe_ID when 1 then c.Item_Quantity ELSE 0 END) as '26-Def PLUS'
,SUM(CASE c.Safe_ID when 2 then c.Item_Quantity ELSE 0 END) as '41-Def PLUS'
,SUM(CASE c.Safe_ID when 3 then c.Item_Quantity ELSE 0 END) as '61-Def PLUS'
FROM `iijs_safe_rental_items` c
inner join iijs_safe_rental b on b.Safe_Rental_ID=c.Safe_Rental_ID
inner join iijs_exhibitor a on a.`Exhibitor_Code`=b.Exhibitor_Code where b.Application_Complete='Y'
group by c.Safe_Rental_ID";
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
