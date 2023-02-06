<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");
?>
<?PHP
  // filename for download
  $export_filename = "StandfittingDisApproved_" . date('Ymd') . ".xls";

/*  $result = mysql_query("SELECT a.`Exhibitor_Code`,d.`Exhibitor_Name`,d.`Exhibitor_Contact_Person`,d.`Exhibitor_Designation`,d.`Exhibitor_Code`,d.`Exhibitor_City`,d.`Exhibitor_Mobile`
,d.`Exhibitor_Phone`,d.`Exhibitor_Email`,d.`Exhibitor_DivisionNo`,d.`Exhibitor_Section`,d.`Exhibitor_Area`,d.`Exhibitor_StallNo1`,d.`Exhibitor_StallNo2`,
d.`Exhibitor_StallNo3`,d.`Exhibitor_StallNo4`,d.`Exhibitor_StallNo5`,d.`Exhibitor_StallNo6`,d.`Exhibitor_StallType`,d.`Exhibitor_Region`,
a.`Info_Approved`,a.`Info_Reason`,a.`Application_Complete`,a.`Create_Date`
,SUM(CASE c.Item_Master_ID when 2 then b.Item_Quantity ELSE 0 END) as 'Fiber Chairs'
,SUM(CASE c.Item_Master_ID when 3 then b.Item_Quantity ELSE 0 END) as 'Bar Stools'
,SUM(CASE c.Item_Master_ID when 4 then b.Item_Quantity ELSE 0 END) as 'Information Table without Lock (octonorm)'
,SUM(CASE c.Item_Master_ID when 5 then b.Item_Quantity ELSE 0 END) as 'Desk Table with Lockable storage (octonorm)'
,SUM(CASE c.Item_Master_ID when 6 then b.Item_Quantity ELSE 0 END) as 'Glass Round Table'
,SUM(CASE c.Item_Master_ID when 7 then b.Item_Quantity ELSE 0 END) as 'Top Glass Showcase with 1W*5 led in brushed finish MS Tube(Yellow/White)'
,SUM(CASE c.Item_Master_ID when 8 then b.Item_Quantity ELSE 0 END) as 'Top  Glass Showcase with 1Q*5 LED in brushed finished Ms Tube (White / Yellow) With 2 LED Spot'
,SUM(CASE c.Item_Master_ID when 9 then b.Item_Quantity ELSE 0 END) as 'Tall Glass Showcase with lockable storage (octonorm Type) with 6 LED Lights'
,SUM(CASE c.Item_Master_ID when 10 then b.Item_Quantity ELSE 0 END) as 'Tall Glass Showcase with lockable storage (octonorm Type) with 12 LED Lights'
,SUM(CASE c.Item_Master_ID when 11 then b.Item_Quantity ELSE 0 END) as 'Single shelf - Glass'
,SUM(CASE c.Item_Master_ID when 12 then b.Item_Quantity ELSE 0 END) as 'Brochure Rack'
,SUM(CASE c.Item_Master_ID when 13 then b.Item_Quantity ELSE 0 END) as 'Maxima System Panel'
,SUM(CASE c.Item_Master_ID when 14 then b.Item_Quantity ELSE 0 END) as 'Door (Maxima)'
,SUM(CASE c.Item_Master_ID when 15 then b.Item_Quantity ELSE 0 END) as 'Dustbin'
,SUM(CASE c.Item_Master_ID when 16 then b.Item_Quantity ELSE 0 END) as 'Plug Point'
,SUM(CASE c.Item_Master_ID when 17 then b.Item_Quantity ELSE 0 END) as 'Tracklight 1 set with 2 nos. (50W) Light without maxima beam'
,SUM(CASE c.Item_Master_ID when 18 then b.Item_Quantity ELSE 0 END) as 'Spiral CFL Lights 23 Watt for Stall Lighting (Yellow)'
,SUM(CASE c.Item_Master_ID when 19 then b.Item_Quantity ELSE 0 END) as 'Spiral CFL Lights 23 Watt for Stall Lighting (White)'
,SUM(CASE c.Item_Master_ID when 20 then b.Item_Quantity ELSE 0 END) as 'Table'
,SUM(CASE c.Item_Master_ID when 21 then b.Item_Quantity ELSE 0 END) as '70 W Metal Halide (Yellow)'
,SUM(CASE c.Item_Master_ID when 22 then b.Item_Quantity ELSE 0 END) as '70 W Metal Halide (White)'
,SUM(CASE c.Item_Master_ID when 23 then b.Item_Quantity ELSE 0 END) as '3W LED lights for Showcase'
,SUM(CASE c.Item_Master_ID when 24 then b.Item_Quantity ELSE 0 END) as 'Comptalux Spot ? Yellow Lights'
,SUM(CASE c.Item_Master_ID when 25 then b.Item_Quantity ELSE 0 END) as 'Top Glass Showcase (With Lock & storage at bottom)'
,SUM(CASE c.Item_Master_ID when 26 then b.Item_Quantity ELSE 0 END) as 'Tall Glass Showcase (Wide)'
,SUM(CASE c.Item_Master_ID when 27 then b.Item_Quantity ELSE 0 END) as 'Tall Glass Showcase (Thin)'
,SUM(CASE c.Item_Master_ID when 28 then b.Item_Quantity ELSE 0 END) as 'Tray Storage'
,SUM(CASE c.Item_Master_ID when 29 then b.Item_Quantity ELSE 0 END) as 'Table (Club)'
,SUM(CASE c.Item_Master_ID when 30 then b.Item_Quantity ELSE 0 END) as 'Visitor Chair - Novia'
,SUM(CASE c.Item_Master_ID when 31 then b.Item_Quantity ELSE 0 END) as 'Movable Partition Wall'
,SUM(CASE c.Item_Master_ID when 32 then b.Item_Quantity ELSE 0 END) as 'Plug Point 15 Amps'
,SUM(CASE c.Item_Master_ID when 33 then b.Item_Quantity ELSE 0 END) as 'Tracklight 1 set with 2 nos. (50W) Light without maxima beam(Club)'
FROM `iijs_stand` a inner join iijs_stand_items b on a.`Stand_ID`=b.`Stand_ID` 
inner join iijs_vendor_item_master c on b.Item_Master_ID=c.Vendor_Iteam_Master_ID
inner join iijs_exhibitor d on a.`Exhibitor_Code`=d.`Exhibitor_Code` where a.`Application_Complete`='N'
group by a.`Exhibitor_Code`") or die('Query failed!');*/

$sqlx = "SELECT a.`Exhibitor_Code`,a.`Exhibitor_Name`,a.`Exhibitor_Contact_Person`,a.`Exhibitor_Designation`,a.`Exhibitor_Code`,a.`Exhibitor_City`,a.`Exhibitor_Mobile`
,a.`Exhibitor_Phone`,a.`Exhibitor_Email`,a.`Exhibitor_DivisionNo`,a.`Exhibitor_Section`,a.`Exhibitor_Area`,a.`Exhibitor_StallNo1`,a.`Exhibitor_StallNo2`,
a.`Exhibitor_StallNo3`,a.`Exhibitor_StallNo4`,a.`Exhibitor_StallNo5`,a.`Exhibitor_StallNo6`,a.`Exhibitor_StallType`,a.`Exhibitor_Region`,b.`Application_Complete`,b.`Create_Date`
FROM iijs_exhibitor a , `iijs_stand` b  where a.`Exhibitor_Code`=b.`Exhibitor_Code` and  b.`Application_Complete`='N'";

  $result = $conn ->query($sqlx);
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
