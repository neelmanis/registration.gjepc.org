<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");
?>
<?PHP
 
  // filename for download
  $export_filename = "StandfittingApproved_" . date('Ymd') . ".xls";

  $result = $conn ->query("SELECT a.`Exhibitor_Code`,d.`Exhibitor_Name`,d.`Exhibitor_Contact_Person`,d.`Exhibitor_Designation`,d.`Exhibitor_Code`,d.`Exhibitor_City`,
d.`Exhibitor_Mobile` ,d.`Exhibitor_Phone`,d.`Exhibitor_Email`,d.`Exhibitor_DivisionNo`,d.`Exhibitor_Section`,d.`Exhibitor_Area`,
d.`Exhibitor_StallNo1`,d.`Exhibitor_StallNo2`, d.`Exhibitor_StallNo3`,d.`Exhibitor_StallNo4`,d.`Exhibitor_StallNo5`,d.`Exhibitor_StallNo6`,
d.`Exhibitor_StallType`,d.`Exhibitor_Region`, a.`Info_Approved`,a.`Info_Reason`,a.`Application_Complete`,a.`Create_Date` ,
SUM(CASE c.Item_ID when 1 then b.Item_Quantity ELSE 0 END) as 'BI2-Top Glass Showcase in MDF varnish finish with LED Tube lighting (Yellow)' ,
SUM(CASE c.Item_ID when 2 then b.Item_Quantity ELSE 0 END) as 'BI2-Top Glass Showcase in MDF varnish finish with LED Tube lighting (White)' ,
SUM(CASE c.Item_ID when 3 then b.Item_Quantity ELSE 0 END) as 'BI2-Partition wall in wood & MDF paint finish' ,
SUM(CASE c.Item_ID when 4 then b.Item_Quantity ELSE 0 END) as 'BI2-Plug point 5/15 Amp' ,
SUM(CASE c.Item_ID when 5 then b.Item_Quantity ELSE 0 END) as 'BI2-Novia chair' ,
SUM(CASE c.Item_ID when 6 then b.Item_Quantity ELSE 0 END) as 'BI2-Table in aluminium frame with glass' ,
SUM(CASE c.Item_ID when 7 then b.Item_Quantity ELSE 0 END) as 'BI2-70W Metal halide (Yellow)' ,
SUM(CASE c.Item_ID when 8 then b.Item_Quantity ELSE 0 END) as 'BI2-70W Metal halide (White)' ,
SUM(CASE c.Item_ID when 9 then b.Item_Quantity ELSE 0 END) as 'BI2-Tall glass showcase with MDF paint finish LED spot & LED Tube (Yellow)' ,
SUM(CASE c.Item_ID when 10 then b.Item_Quantity ELSE 0 END) as 'BI2-Tall glass showcase with MDF paint finish LED spot & LED Tube (White)' ,
SUM(CASE c.Item_ID when 13 then b.Item_Quantity ELSE 0 END) as 'BI2-Tray storage' ,SUM(CASE c.Item_ID when 14 then b.Item_Quantity ELSE 0 END) as 'BI2-Novia Chair' ,
SUM(CASE c.Item_ID when 15 then b.Item_Quantity ELSE 0 END) as 'BI2-Bar Stools' ,SUM(CASE c.Item_ID when 16 then b.Item_Quantity ELSE 0 END) as 'BI2-Table (with 3 Side Close Panel)' ,
SUM(CASE c.Item_ID when 17 then b.Item_Quantity ELSE 0 END) as 'BI2-Desk Table with Lockable storage (octonorm)' ,
SUM(CASE c.Item_ID when 18 then b.Item_Quantity ELSE 0 END) as 'BI2-Glass Round Table' ,
SUM(CASE c.Item_ID when 19 then b.Item_Quantity ELSE 0 END) as 'BI2-Top Glass Showcase with 1m chanel LED Strip (2 Nos), 2arm / joota (COB LED) Lights & Lockable storage (Yellow)' ,
SUM(CASE c.Item_ID when 20 then b.Item_Quantity ELSE 0 END) as 'BI2-Top Glass Showcase with 1m chanel LED Strip (2 Nos), 2arm / joota (COB LED) Lights & Lockable storage (White)' ,
SUM(CASE c.Item_ID when 21 then b.Item_Quantity ELSE 0 END) as 'BI2-Tall Glass Showcase with 1m chanel LED strip (6 Nos), 6 arm/joota (COB LED) lights & lockable storage (Yellow)' ,
SUM(CASE c.Item_ID when 22 then b.Item_Quantity ELSE 0 END) as 'BI2-Tall Glass Showcase with 1m chanel LED strip (6 Nos), 6 arm/joota (COB LED) lights & lockable storage (White)' ,
SUM(CASE c.Item_ID when 23 then b.Item_Quantity ELSE 0 END) as 'BI2-Single Glass Shelf' ,SUM(CASE c.Item_ID when 24 then b.Item_Quantity ELSE 0 END) as 'BI2-Brochure Rack' ,
SUM(CASE c.Item_ID when 25 then b.Item_Quantity ELSE 0 END) as 'BI2-Maxima System Panel' ,SUM(CASE c.Item_ID when 26 then b.Item_Quantity ELSE 0 END) as 'Folding Door' ,
SUM(CASE c.Item_ID when 27 then b.Item_Quantity ELSE 0 END) as 'BI2-Dustbin' ,SUM(CASE c.Item_ID when 28 then b.Item_Quantity ELSE 0 END) as 'Plug Point' ,
SUM(CASE c.Item_ID when 29 then b.Item_Quantity ELSE 0 END) as 'BI2-Spiral CFL Lights 23 Watt for Stall Lighting (Yellow)' ,
SUM(CASE c.Item_ID when 30 then b.Item_Quantity ELSE 0 END) as 'BI2-Spiral CFL Lights 23 Watt for Stall Lighting (White)' ,
SUM(CASE c.Item_ID when 31 then b.Item_Quantity ELSE 0 END) as 'BI2-Table (without panel)' ,SUM(CASE c.Item_ID when 32 then b.Item_Quantity ELSE 0 END) as '70W Metal Halide (White)' ,
SUM(CASE c.Item_ID when 33 then b.Item_Quantity ELSE 0 END) as 'BI2-70W Metal Halide (Yellow)' ,SUM(CASE c.Item_ID when 34 then b.Item_Quantity ELSE 0 END) as 'BI2-100W Comptalux Spot - Yellow Lights',
SUM(CASE c.Item_ID when 35 then b.Item_Quantity ELSE 0 END) as 'Glass Shelves -ready mould glass shelves fixed on metal fixture', 
SUM(CASE c.Item_ID when 36 then b.Item_Quantity ELSE 0 END) as 'Brochure Rack', 
SUM(CASE c.Item_ID when 37 then b.Item_Quantity ELSE 0 END) as 'Eye Cutter (partition wall)', 
SUM(CASE c.Item_ID when 38 then b.Item_Quantity ELSE 0 END) as 'Curtain', 
SUM(CASE c.Item_ID when 39 then b.Item_Quantity ELSE 0 END) as '70-watt Metal Halide (white)',
SUM(CASE c.Item_ID when 40 then b.Item_Quantity ELSE 0 END) as '70-watt Metal Halide (yellow)', 
SUM(CASE c.Item_ID when 41 then b.Item_Quantity ELSE 0 END) as 'Tall Glass Unit (wide) (white)', 
SUM(CASE c.Item_ID when 42 then b.Item_Quantity ELSE 0 END) as 'Tall Glass Unit (wide) (yellow)', 
SUM(CASE c.Item_ID when 43 then b.Item_Quantity ELSE 0 END) as 'Window Glass Showcase (white)',
SUM(CASE c.Item_ID when 44 then b.Item_Quantity ELSE 0 END) as 'Window Glass Showcase (yellow)', 
SUM(CASE c.Item_ID when 45 then b.Item_Quantity ELSE 0 END) as 'Top Glass Unit (wide) (white)', 
SUM(CASE c.Item_ID when 46 then b.Item_Quantity ELSE 0 END) as 'Top Glass Unit (wide) (yellow)', 
SUM(CASE c.Item_ID when 47 then b.Item_Quantity ELSE 0 END) as 'Tall Glass Unit (thin) (white)', 
SUM(CASE c.Item_ID when 48 then b.Item_Quantity ELSE 0 END) as 'Tall Glass Unit (thin) (yellow)', 
SUM(CASE c.Item_ID when 49 then b.Item_Quantity ELSE 0 END) as 'Top Glass Unit (thin) (white)', 
SUM(CASE c.Item_ID when 50 then b.Item_Quantity ELSE 0 END) as 'Top Glass Unit (thin) (yellow)', 
SUM(CASE c.Item_ID when 51 then b.Item_Quantity ELSE 0 END) as 'Desk Table with three side panel in octornorm', 
SUM(CASE c.Item_ID when 52 then b.Item_Quantity ELSE 0 END) as 'Desk Table, lockable in octonorm', 
SUM(CASE c.Item_ID when 53 then b.Item_Quantity ELSE 0 END) as 'Meeting Table', 
SUM(CASE c.Item_ID when 54 then b.Item_Quantity ELSE 0 END) as 'Chair', 
SUM(CASE c.Item_ID when 55 then b.Item_Quantity ELSE 0 END) as 'Plug point 5/15 amp', 
SUM(CASE c.Item_ID when 56 then b.Item_Quantity ELSE 0 END) as 'Dustbin', 
SUM(CASE c.Item_ID when 57 then b.Item_Quantity ELSE 0 END) as 'Bar Stool' FROM `iijs_stand` a inner join iijs_stand_items b on a.`Stand_ID`=b.`Stand_ID` inner join iijs_stand_items_master c on b.Item_Master_ID=c.Item_ID inner join iijs_exhibitor d on a.`Exhibitor_Code`=d.`Exhibitor_Code` where a.`Application_Complete`='Y' group by a.`Exhibitor_Code`") or die('Query failed!');
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
