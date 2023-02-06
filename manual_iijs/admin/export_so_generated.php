<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
  // filename for download
  $export_filename = "SODATA_" . date('Ymd') . ".xls";
  $result = $conn ->query("SELECT a.*,b.Exhibitor_Name,b.Exhibitor_Country_ID FROM `iijs_payment_master` a,iijs_exhibitor b WHERE (a.`Form_ID`='3' || a.`Form_ID`='4' || a.`Form_ID`='7') AND a.txn_status='300' and a.Exhibitor_Code=b.Exhibitor_Code order by b.`Exhibitor_Code`") or die('Query failed!');
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
