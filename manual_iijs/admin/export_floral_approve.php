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
  $filename = "FloralApproved_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");

  $out = fopen("php://output", 'w');

  $flag = false;
  $result = mysql_query("SELECT a.`Floral_ID`,a.`Exhibitor_Code`,d.`Exhibitor_Name`,d.`Exhibitor_Contact_Person`,d.`Exhibitor_Designation`,d.`Exhibitor_Code`,d.`Exhibitor_City`,d.`Exhibitor_Mobile`
,d.`Exhibitor_Phone`,d.`Exhibitor_Email`,d.`Exhibitor_DivisionNo`,d.`Exhibitor_Section`,d.`Exhibitor_Area`,d.`Exhibitor_StallNo1`,d.`Exhibitor_StallNo2`,
d.`Exhibitor_StallNo3`,d.`Exhibitor_StallNo4`,d.`Exhibitor_StallNo5`,d.`Exhibitor_StallNo6`,d.`Exhibitor_StallType`,d.`Exhibitor_Region`,
a.`Info_Approved`,a.`Info_Reason`,a.`Application_Complete`,a.`Create_Date`
,SUM(CASE b.Floral_Items_MasterID when 1 then b.Floral_Items_Quantity ELSE 0 END) as 'Ficus benjamina - pot size - 12, Height - 3 - 4'
,SUM(CASE b.Floral_Items_MasterID when 2 then b.Floral_Items_Quantity ELSE 0 END) as 'Areca palm - pot size - 14 , height - 4 - 5'
,SUM(CASE b.Floral_Items_MasterID when 12 then b.Floral_Items_Quantity ELSE 0 END) as 'Ficus variegated - pot size - 8 , height - 2'
,SUM(CASE b.Floral_Items_MasterID when 13 then b.Floral_Items_Quantity ELSE 0 END) as 'Dracaena Plant - 8 , height - 2 - 3 (per day) '
,SUM(CASE b.Floral_Items_MasterID when 14 then b.Floral_Items_Quantity ELSE 0 END) as 'Flower Arrangement of Roses - A'
,SUM(CASE b.Floral_Items_MasterID when 15 then b.Floral_Items_Quantity ELSE 0 END) as 'Flower Arrangement of Roses - B'
,SUM(CASE b.Floral_Items_MasterID when 16 then b.Floral_Items_Quantity ELSE 0 END) as 'Flower Arrangement of Carnations -A'
,SUM(CASE b.Floral_Items_MasterID when 17 then b.Floral_Items_Quantity ELSE 0 END) as 'Flower Arrangement of Carnations - B'
,SUM(CASE b.Floral_Items_MasterID when 18 then b.Floral_Items_Quantity ELSE 0 END) as 'Flower Arrangement of Lilium - A'
,SUM(CASE b.Floral_Items_MasterID when 19 then b.Floral_Items_Quantity ELSE 0 END) as 'Flower Arrangement of Lilium - B'
,SUM(CASE b.Floral_Items_MasterID when 20 then b.Floral_Items_Quantity ELSE 0 END) as 'Flower Arrangement of Anthurium - A'
,SUM(CASE b.Floral_Items_MasterID when 21 then b.Floral_Items_Quantity ELSE 0 END) as 'Flower Arrangement of Anthurium - B'
,SUM(CASE b.Floral_Items_MasterID when 22 then b.Floral_Items_Quantity ELSE 0 END) as 'Flower Arrangement of Orchids in a glass vase -A'
,SUM(CASE b.Floral_Items_MasterID when 23 then b.Floral_Items_Quantity ELSE 0 END) as 'Flower Arrangement of Orchids in a glass vase -B'
,SUM(CASE b.Floral_Items_MasterID when 24 then b.Floral_Items_Quantity ELSE 0 END) as 'Flower Arrangement of Birds Of Paradise -A'
,SUM(CASE b.Floral_Items_MasterID when 25 then b.Floral_Items_Quantity ELSE 0 END) as 'Flower Arrangement of Birds Of Paradise -B'
,SUM(CASE b.Floral_Items_MasterID when 26 then b.Floral_Items_Quantity ELSE 0 END) as '5 Feet Long Flower Arrangement (Pedestial)'
,SUM(CASE b.Floral_Items_MasterID when 27 then b.Floral_Items_Quantity ELSE 0 END) as '6 Feet Long Flower Arrangement (Pedestial)'
,SUM(CASE b.Floral_Items_MasterID when 28 then b.Floral_Items_Quantity ELSE 0 END) as 'Arrangement Of Assorted Normal Flowers - A'
,SUM(CASE b.Floral_Items_MasterID when 29 then b.Floral_Items_Quantity ELSE 0 END) as 'Arrangement Of Assorted Normal Flowers - B'
,SUM(CASE b.Floral_Items_MasterID when 30 then b.Floral_Items_Quantity ELSE 0 END) as 'Arrangement Of Assorted Exotic Flowers - A'
,SUM(CASE b.Floral_Items_MasterID when 31 then b.Floral_Items_Quantity ELSE 0 END) as 'Arrangement Of Assorted Exotic Flowers - B'
,SUM(CASE b.Floral_Items_MasterID when 32 then b.Floral_Items_Quantity ELSE 0 END) as 'Table top Arrangement - A'
,SUM(CASE b.Floral_Items_MasterID when 33 then b.Floral_Items_Quantity ELSE 0 END) as 'Table top Arrangement - B'
,SUM(CASE b.Floral_Items_MasterID when 34 then b.Floral_Items_Quantity ELSE 0 END) as 'Arrangement for Exotic Flowers-A'
,SUM(CASE b.Floral_Items_MasterID when 35 then b.Floral_Items_Quantity ELSE 0 END) as 'Arrangement for Exotic Flowers-B'
,SUM(CASE b.Floral_Items_MasterID when 36 then b.Floral_Items_Quantity ELSE 0 END) as 'Décor for stall- A (per feet)'
,SUM(CASE b.Floral_Items_MasterID when 37 then b.Floral_Items_Quantity ELSE 0 END) as 'Décor for stall- B (per feet)'
,SUM(CASE b.Floral_Items_MasterID when 38 then b.Floral_Items_Quantity ELSE 0 END) as 'Décor for stall- C (per feet)'
,SUM(CASE b.Floral_Items_MasterID when 39 then b.Floral_Items_Quantity ELSE 0 END) as 'Décor for stall- D (per feet)'


FROM `iijs_floral` a inner join iijs_floral_items b on a.`Floral_ID`=b.`Floral_ID` 
inner join iijs_exhibitor d on a.`Exhibitor_Code`=d.`Exhibitor_Code` where a.`Application_Complete`='Y'
group by a.`Exhibitor_Code`") or die('Query failed!');
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
