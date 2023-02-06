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
  $filename = "StandfittingAll_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");

  $out = fopen("php://output", 'w');

  $flag = false;
  $result = mysql_query("SELECT a.`Exhibitor_Code`,d.`Exhibitor_Name`,d.`Exhibitor_Contact_Person`,d.`Exhibitor_Designation`,d.`Exhibitor_Code`,d.`Exhibitor_City`,d.`Exhibitor_Mobile`
,d.`Exhibitor_Phone`,d.`Exhibitor_Email`,d.`Exhibitor_DivisionNo`,d.`Exhibitor_Section`,d.`Exhibitor_Area`,d.`Exhibitor_StallNo1`,d.`Exhibitor_StallNo2`,
d.`Exhibitor_StallNo3`,d.`Exhibitor_StallNo4`,d.`Exhibitor_StallNo5`,d.`Exhibitor_StallNo6`,d.`Exhibitor_StallType`,d.`Exhibitor_Region`,
a.`Info_Approved`,a.`Info_Reason`,a.`Application_Complete`,a.`Create_Date`
,SUM(CASE c.Item_Master_ID when 2 then b.Item_Quantity ELSE 0 END) as 'Fiber Chairs'
,SUM(CASE c.Item_Master_ID when 3 then b.Item_Quantity ELSE 0 END) as 'Bar Stools'
,SUM(CASE c.Item_Master_ID when 4 then b.Item_Quantity ELSE 0 END) as 'Table (With 3 side close Panel )'
,SUM(CASE c.Item_Master_ID when 5 then b.Item_Quantity ELSE 0 END) as 'Desk Table with Lockable storage'
,SUM(CASE c.Item_Master_ID when 6 then b.Item_Quantity ELSE 0 END) as 'Glass Round Table'
,SUM(CASE c.Item_Master_ID when 7 then b.Item_Quantity ELSE 0 END) as 'Top Glass Showcase with LED Strip & lockable storage  (Yellow)'
,SUM(CASE c.Item_Master_ID when 8 then b.Item_Quantity ELSE 0 END) as 'Top Glass Showcase with LED Strip, 2 LED Spot & lockable storage (Yellow)'
,SUM(CASE c.Item_Master_ID when 9 then b.Item_Quantity ELSE 0 END) as 'Tall Glass Showcase with LED Strip, 6 LED Spot & lockable storage (Yellow)'
,SUM(CASE c.Item_Master_ID when 10 then b.Item_Quantity ELSE 0 END) as 'Tall Glass Showcase with LED Strip, 12 LED Spot & lockable storage (Yellow)'
,SUM(CASE c.Item_Master_ID when 11 then b.Item_Quantity ELSE 0 END) as 'Single shelf - Glass'
,SUM(CASE c.Item_Master_ID when 12 then b.Item_Quantity ELSE 0 END) as 'Brochure Rack'
,SUM(CASE c.Item_Master_ID when 13 then b.Item_Quantity ELSE 0 END) as 'Maxima System Panel'
,SUM(CASE c.Item_Master_ID when 14 then b.Item_Quantity ELSE 0 END) as 'Folding Door(Octonorm)'
,SUM(CASE c.Item_Master_ID when 15 then b.Item_Quantity ELSE 0 END) as 'Dustbin'
,SUM(CASE c.Item_Master_ID when 16 then b.Item_Quantity ELSE 0 END) as 'Plug Point'
,SUM(CASE c.Item_Master_ID when 17 then b.Item_Quantity ELSE 0 END) as 'Track-light 1 set with 2 nos. (70W each) (Yellow)'
,SUM(CASE c.Item_Master_ID when 18 then b.Item_Quantity ELSE 0 END) as 'Spiral CFL Lights 23 Watt for Stall Lighting (Yellow)'
,SUM(CASE c.Item_Master_ID when 19 then b.Item_Quantity ELSE 0 END) as 'Spiral CFL Lights 23 Watt for Stall Lighting (White)'
,SUM(CASE c.Item_Master_ID when 20 then b.Item_Quantity ELSE 0 END) as 'Table(Without Panel)'
,SUM(CASE c.Item_Master_ID when 21 then b.Item_Quantity ELSE 0 END) as '70 W Metal Halide (Yellow)'
,SUM(CASE c.Item_Master_ID when 22 then b.Item_Quantity ELSE 0 END) as '70 W Metal Halide (White)'
,SUM(CASE c.Item_Master_ID when 23 then b.Item_Quantity ELSE 0 END) as '3W LED lights for Showcase (Yellow)'
,SUM(CASE c.Item_Master_ID when 24 then b.Item_Quantity ELSE 0 END) as 'Comptalux Spot - Yellow Lights'
,SUM(CASE c.Item_Master_ID when 34 then b.Item_Quantity ELSE 0 END) as 'Track-light 1 set with 2 nos. (70W each) (White)'
,SUM(CASE c.Item_Master_ID when 35 then b.Item_Quantity ELSE 0 END) as '3W LED lights for Showcase (White)'
,SUM(CASE c.Item_Master_ID when 36 then b.Item_Quantity ELSE 0 END) as 'Top Glass Showcase with LED Strip & lockable storage  (White)'
,SUM(CASE c.Item_Master_ID when 37 then b.Item_Quantity ELSE 0 END) as 'Top Glass Showcase with LED Strip, 2 LED Spot & lockable storage (white)'
,SUM(CASE c.Item_Master_ID when 38 then b.Item_Quantity ELSE 0 END) as 'Tall Glass Showcase with LED Strip, 6 LED Spot & lockable storage (white)'
,SUM(CASE c.Item_Master_ID when 39 then b.Item_Quantity ELSE 0 END) as 'Tall Glass Showcase with LED Strip, 12 LED Spot & lockable storage (white)'
,SUM(CASE c.Item_Master_ID when 42 then b.Item_Quantity ELSE 0 END) as 'Top Glass showcase in MDF varnish finish with LED strip lighting'
,SUM(CASE c.Item_Master_ID when 43 then b.Item_Quantity ELSE 0 END) as 'Partition wall in wood & MDF paint finish'
,SUM(CASE c.Item_Master_ID when 44 then b.Item_Quantity ELSE 0 END) as 'Plug point 5/15 Amp'
,SUM(CASE c.Item_Master_ID when 45 then b.Item_Quantity ELSE 0 END) as 'Novia chair'
,SUM(CASE c.Item_Master_ID when 46 then b.Item_Quantity ELSE 0 END) as 'Table in aluminum frame with glass'
,SUM(CASE c.Item_Master_ID when 47 then b.Item_Quantity ELSE 0 END) as 'Track light (2 Nos)'
,SUM(CASE c.Item_Master_ID when 48 then b.Item_Quantity ELSE 0 END) as 'Tall glass showcase thin with MDF paint finish LED spot & strip'
,SUM(CASE c.Item_Master_ID when 49 then b.Item_Quantity ELSE 0 END) as 'Tall glass showcase wide with MDF paint finish LED spot & strip'
,SUM(CASE c.Item_Master_ID when 50 then b.Item_Quantity ELSE 0 END) as 'Tray storage'
,SUM(CASE c.Item_Master_ID when 51 then b.Item_Quantity ELSE 0 END) as '70 W Metal Halide (Yellow---)'
,SUM(CASE c.Item_Master_ID when 52 then b.Item_Quantity ELSE 0 END) as '70 W Metal Halide (White---)'
FROM `iijs_stand` a inner join iijs_stand_items b on a.`Stand_ID`=b.`Stand_ID` 
inner join iijs_vendor_item_master c on b.Item_Master_ID=c.Vendor_Iteam_Master_ID
inner join iijs_exhibitor d on a.`Exhibitor_Code`=d.`Exhibitor_Code` group by a.`Exhibitor_Code`") or die('Query failed!');
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
