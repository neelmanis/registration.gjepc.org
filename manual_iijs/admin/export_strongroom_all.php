<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");
?>
<?PHP
  // filename for download
  $export_filename = "StrongRoomAll_" . date('Ymd') . ".xls";
  $result = $conn ->query("SELECT a.`Exhibitor_Code`,d.`Exhibitor_Name`,d.`Exhibitor_Contact_Person`,d.`Exhibitor_Designation`,d.`Exhibitor_Code`,d.`Exhibitor_Address1`,d.`Exhibitor_Address2`,d.`Exhibitor_Address3`,d.`Exhibitor_City`,d.`Exhibitor_State`,d.`Exhibitor_Pincode`,d.`Exhibitor_Mobile`
,d.`Exhibitor_Phone`,d.`Exhibitor_Email`,d.`Exhibitor_HallNo`,d.`Exhibitor_DivisionNo`,d.`Exhibitor_Section`,d.`Exhibitor_Area`,d.`Exhibitor_StallNo1`,d.`Exhibitor_StallNo2`,
d.`Exhibitor_StallNo3`,d.`Exhibitor_StallNo4`,d.`Exhibitor_StallNo5`,d.`Exhibitor_StallNo6`,d.`Exhibitor_StallType`,d.`Exhibitor_Region`,
IF(a.StrongRoom_Taken='Y','Yes','No') as 'Strong Room Taken',b.Badge_Name as Keyperson1,c.Badge_Name as Keyperson2,
a.`Items_Approved`,a.`Items_Reason`,a.`Application_Complete`,a.`Create_Date`

FROM `iijs_strongroom` a inner join iijs_exhibitor d on a.`Exhibitor_Code`=d.`Exhibitor_Code` 
inner join iijs_badge_items b on b.Badge_Item_ID=a.keyperson1
inner join iijs_badge_items c on c.Badge_Item_ID=a.keyperson2 group by a.`Exhibitor_Code`") or die('Query failed!');
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
