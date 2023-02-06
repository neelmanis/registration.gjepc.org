<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");
?>
<?PHP
  // filename for download
  $export_filename = "StandfittingAll_" . date('Ymd') . ".xls";
 
  $result = $conn ->query("SELECT a.`Exhibitor_Code`,d.`Exhibitor_Name`,d.`Exhibitor_Contact_Person`,d.`Exhibitor_Designation`,d.`Exhibitor_City`,d.`Exhibitor_Mobile`
,d.`Exhibitor_Phone`,d.`Exhibitor_Email`,d.`Exhibitor_DivisionNo`,d.`Exhibitor_Section`,d.`Exhibitor_Area`,d.`Exhibitor_StallNo1`,d.`Exhibitor_StallNo2`,
d.`Exhibitor_StallNo3`,d.`Exhibitor_StallNo4`,d.`Exhibitor_StallNo5`,d.`Exhibitor_StallNo6`,d.`Exhibitor_StallType`,d.`Exhibitor_Scheme`,d.`Exhibitor_Region`,
a.`Info_Approved`,a.`Info_Reason`,a.`Application_Complete`,a.`Create_Date`,
SUM(CASE c.Item_ID when 2 then b.Item_Quantity ELSE 0 END) as 'Track Lights of 50 watt - Yellow' ,
SUM(CASE c.Item_ID when 3 then b.Item_Quantity ELSE 0 END) as 'Bar Stools',
SUM(CASE c.Item_ID when 5 then b.Item_Quantity ELSE 0 END) as 'Desk Table with Lockable storage (Maxima)' ,
SUM(CASE c.Item_ID when 6 then b.Item_Quantity ELSE 0 END) as 'Top Glass showcase - White' ,
SUM(CASE c.Item_ID when 7 then b.Item_Quantity ELSE 0 END) as '50 W LED - White' ,
SUM(CASE c.Item_ID when 8 then b.Item_Quantity ELSE 0 END) as '50 W LED - Yellow' ,
SUM(CASE c.Item_ID when 12 then b.Item_Quantity ELSE 0 END) as 'Brochure Rack' ,
SUM(CASE c.Item_ID when 15 then b.Item_Quantity ELSE 0 END) as 'Storage Unit with 2 shelves' ,
SUM(CASE c.Item_ID when 16 then b.Item_Quantity ELSE 0 END) as 'Plug Point' ,
SUM(CASE c.Item_ID when 17 then b.Item_Quantity ELSE 0 END) as 'Window show case 2M - White ',
SUM(CASE c.Item_ID when 18 then b.Item_Quantity ELSE 0 END) as 'Window showcase 1M - White',
SUM(CASE c.Item_ID when 19 then b.Item_Quantity ELSE 0 END) as 'Window showcase 1M - Yellow',
SUM(CASE c.Item_ID when 20 then b.Item_Quantity ELSE 0 END) as 'Tall glass unit - Yellow',
SUM(CASE c.Item_ID when 21 then b.Item_Quantity ELSE 0 END) as 'Chair - BLACK cushion leather',
SUM(CASE c.Item_ID when 22 then b.Item_Quantity ELSE 0 END) as 'Track Lights of 50 watt - white',
SUM(CASE c.Item_ID when 23 then b.Item_Quantity ELSE 0 END) as 'Maxima System Panel',
SUM(CASE c.Item_ID when 31 then b.Item_Quantity ELSE 0 END) as 'Folding Door',
SUM(CASE c.Item_ID when 35 then b.Item_Quantity ELSE 0 END) as 'Dustbin with Lid ',
SUM(CASE c.Item_ID when 37 then b.Item_Quantity ELSE 0 END) as 'Window show case 2M - Yellow',
SUM(CASE c.Item_ID when 38 then b.Item_Quantity ELSE 0 END) as 'Table (without panel)',
SUM(CASE c.Item_ID when 39 then b.Item_Quantity ELSE 0 END) as 'Tall glass unit - White',
SUM(CASE c.Item_ID when 40 then b.Item_Quantity ELSE 0 END) as 'Single Glass shelf',
SUM(CASE c.Item_ID when 41 then b.Item_Quantity ELSE 0 END) as 'Information Table without Lock (Maxima) ',
SUM(CASE c.Item_ID when 66 then b.Item_Quantity ELSE 0 END) as 'Top Glass showcase Yellow',
SUM(CASE c.Item_ID when 67 then b.Item_Quantity ELSE 0 END) as 'Glass Round Table',

SUM(CASE c.Item_ID when 42 then b.Item_Quantity ELSE 0 END) as '50W LED light Metal - Yellow',
SUM(CASE c.Item_ID when 43 then b.Item_Quantity ELSE 0 END) as '50W LED light Metal - White' ,
SUM(CASE c.Item_ID when 45 then b.Item_Quantity ELSE 0 END) as 'Brochure Rack' ,
SUM(CASE c.Item_ID when 46 then b.Item_Quantity ELSE 0 END) as 'Bar Stools' ,
SUM(CASE c.Item_ID when 47 then b.Item_Quantity ELSE 0 END) as 'Chair - BLACK' ,
SUM(CASE c.Item_ID when 48 then b.Item_Quantity ELSE 0 END) as 'Glass Round Table' ,
SUM(CASE c.Item_ID when 49 then b.Item_Quantity ELSE 0 END) as 'Top Glass Showcase with 2arm / joota (COB LED) Lights & Lockable storage (White)' ,
SUM(CASE c.Item_ID when 50 then b.Item_Quantity ELSE 0 END) as 'Top Glass Showcase with 2arm / joota (COB LED) Lights & Lockable storage (Yellow)' ,
SUM(CASE c.Item_ID when 51 then b.Item_Quantity ELSE 0 END) as 'Tall Glass Showcase with 6 arm/joota (COB LED) lights & lockable storage (White)' ,
SUM(CASE c.Item_ID when 52 then b.Item_Quantity ELSE 0 END) as 'Tall Glass Showcase with 6 arm/joota (COB LED) lights & lockable storage (Yellow)' ,
SUM(CASE c.Item_ID when 54 then b.Item_Quantity ELSE 0 END) as 'Single Glass Shelf' ,
SUM(CASE c.Item_ID when 55 then b.Item_Quantity ELSE 0 END) as 'Folding Door' ,
SUM(CASE c.Item_ID when 56 then b.Item_Quantity ELSE 0 END) as 'System Panel' ,
SUM(CASE c.Item_ID when 58 then b.Item_Quantity ELSE 0 END) as 'Dustbin' ,
SUM(CASE c.Item_ID when 59 then b.Item_Quantity ELSE 0 END) as 'Plug Point' ,
SUM(CASE c.Item_ID when 60 then b.Item_Quantity ELSE 0 END) as 'Table (with 3 Side Close Panel)' ,
SUM(CASE c.Item_ID when 61 then b.Item_Quantity ELSE 0 END) as 'Desk Table with Lockable storage (Maxima)' ,
SUM(CASE c.Item_ID when 64 then b.Item_Quantity ELSE 0 END) as 'Table (without panel)' ,
SUM(CASE c.Item_ID when 68 then b.Item_Quantity ELSE 0 END) as '16 W LED - White' ,
SUM(CASE c.Item_ID when 69 then b.Item_Quantity ELSE 0 END) as '16 W LED - Yellow' 


FROM `iijs_stand` a inner join iijs_stand_items b on a.`Stand_ID`=b.`Stand_ID` 
inner join iijs_stand_items_master c on b.Item_Master_ID=c.Item_ID
inner join iijs_exhibitor d on a.`Exhibitor_Code`=d.`Exhibitor_Code` group by a.`Exhibitor_Code`") or die('Query failed!');
	$count = $result->num_rows;
	$header = '';
	for ($i = 0; $i < $count; $i++){
	$header .= mysqli_fetch_field_direct($result, $i)->name."\t";
	}
	//echo "<pre>"; print_r($result->fetch_assoc());exit;
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
