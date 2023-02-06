<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");
?>
<?PHP
  // filename for download
  $export_filename = "BadgesList_" . date('Ymd') . ".xls";
  
	$result = $conn ->query("SELECT b.`Badge_Item_ID` as VisitorId,b.`Exhibitor_Code`,a.Exhibitor_Registration_ID,a.`Customer_No`,a.`Exhibitor_Name`,b.`Badge_Name`,b.`Badge_Designation`,b.`Badge_Mobile`,b.`Badge_Photo`,b.`Badge_IsKeyPerson`,b.`Badge_Type`,b.`Badge_Approved`,b.`Badge_Reason`,b.Replacement_ID,b.Create_Date,if(b.`Badge_Type`='E',b.Surcharge,'500') as Surcharge,a.Exhibitor_HallNo,a.Exhibitor_StallNo1,a.Exhibitor_StallNo2,a.Exhibitor_StallNo3,a.Exhibitor_StallNo4,a.Exhibitor_StallNo5,a.Exhibitor_StallNo6,a.Exhibitor_StallNo7,a.Exhibitor_StallNo8,d.Payment_Master_Approved,d.Payment_Master_Reason FROM `iijs_badge_items` b ,iijs_exhibitor a,iijs_badge c,iijs_payment_master d where a.Exhibitor_Code=b.Exhibitor_Code and c.Badge_ID=b.Badge_ID and d.Payment_Master_ID=c.Payment_Master_ID order by b.`Exhibitor_Code`") or die('Query failed!');
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

