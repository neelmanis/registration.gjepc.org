<?php
session_start(); 
ob_start();
include('../db.inc.php'); 
?>

<?php

$date=date("d_m_Y");

$query_string = "SELECT a.`Customer_No`,a.`Exhibitor_Name`,a.`Exhibitor_Contact_Person`,a.`Exhibitor_Designation`,a.`Exhibitor_Code`,a.`Exhibitor_City`,a.`Exhibitor_Mobile`,a.`Exhibitor_Phone`,a.`Exhibitor_Email`,a.`Exhibitor_DivisionNo`,a.`Exhibitor_Section`,a.`Exhibitor_Area`,a.`Exhibitor_StallNo1`,a.`Exhibitor_StallNo2`,a.`Exhibitor_StallNo3`,a.`Exhibitor_StallNo4`,a.`Exhibitor_StallNo5`,a.`Exhibitor_StallNo6`,a.`Exhibitor_StallType`,a.`Exhibitor_Region`,a.`Year`,b.`Catalog_ContactPerson`,b.`Catalog_Designation`,b.`Catalog_Address1`,b.`Catalog_Address2`,b.`Catalog_Address3`,b.`Catalog_City`,b.`Catalog_Pincode`,b.`Catalog_Phone`,b.`Catelog_mobile`,b.`Catalog_Fax`,b.`Catalog_Email`,b.Catalog_Website,b.`Catalog_ProductLogo`,b.`Catalog_CompanyLogo`,b.`Catalog_Brief`,b.`brand_names`,b.`Info_Approved`,b.`Info_Reason`,b.`ProductLogo_Approved`,b.`ProductLogo_Reason`,b.`CompanyLogo_Approved`,b.`CompanyLogo_Reason`,b.`Application_Complete`,b.`Create_Date` FROM `iijs_exhibitor` a,iijs_catalog b where a.`Exhibitor_Code`=b.`Exhibitor_Code` order by b.`Modify_Date` desc"; 

$export_filename = "CatalogFilled.xls";
$result = $conn ->query($query_string);
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
		$value = iconv("utf-8", "ascii//TRANSLIT//IGNORE", $value);
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

/*
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
  $filename = "CatalogFilled_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");
  
  $out = fopen("php://output", 'w');

$flag = false;
$sql="SELECT a.`Customer_No`,a.`Exhibitor_Name`,a.`Exhibitor_Contact_Person`,a.`Exhibitor_Designation`,a.`Exhibitor_Code`,a.`Exhibitor_City`,a.`Exhibitor_Mobile`,a.`Exhibitor_Phone`,a.`Exhibitor_Email`,a.`Exhibitor_DivisionNo`,a.`Exhibitor_Section`,a.`Exhibitor_Area`,a.`Exhibitor_StallNo1`,a.`Exhibitor_StallNo2`,a.`Exhibitor_StallNo3`,a.`Exhibitor_StallNo4`,a.`Exhibitor_StallNo5`,a.`Exhibitor_StallNo6`,a.`Exhibitor_StallType`,a.`Exhibitor_Region`,b.`Catalog_ContactPerson`,b.`Catalog_Designation`,b.`Catalog_Address1`,b.`Catalog_Address2`,b.`Catalog_Address3`,b.`Catalog_City`,b.`Catalog_Pincode`,b.`Catalog_Phone`,b.`Catelog_mobile`,b.`Catalog_Fax`,b.`Catalog_Email`,b.Catalog_Website,concat('https://registration.gjepc.org/manual_iijs/images/catalog/', "", a.Exhibitor_Code, '/' ,b.Catalog_ProductLogo)  as productlogo,concat('https://registration.gjepc.org/manual_iijs/images/catalog/', "", a.Exhibitor_Code, '/' ,b.Catalog_CompanyLogo)  as companylogo,b.`Catalog_CompanyLogo`,b.`Catalog_Brief`,b.`brand_names`,b.`Info_Approved`,b.`Info_Reason`,b.`ProductLogo_Approved`,b.`ProductLogo_Reason`,b.`CompanyLogo_Approved`,b.`CompanyLogo_Reason`,b.`Application_Complete`,b.`Create_Date` FROM `iijs_exhibitor` a,iijs_catalog b where a.`Exhibitor_Code`=b.`Exhibitor_Code` order by b.`Modify_Date` desc";
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

  */
  
/*  
 $table = $display = "";	
$fn = "Agency_vaccination_report_". date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Sr. No.</td>
<td>Exhibitor_Code</td>
<td>Catalog_Brief</td>
</tr>';

$sql="SELECT `Exhibitor_Code`,`Catalog_Brief`,`Exhibitor_Code` FROM iijs_catalog";
$result = $conn ->query($sql);
$i=1;
while($row = $result->fetch_assoc())
{	
$Exhibitor_Code=$row['Exhibitor_Code'];
$Exhibitor_Name = $row['Exhibitor_Name'];
$Catalog_Brief=$row['Catalog_Brief'];
	
$table .= '<tr>
<td>'.$i.'</td>
<td>'.$Exhibitor_Code.'</td>
<td>'.$newtitle.'</td>

</tr>';
$i++;	
}
 $table .= $display;
$table .= '</table>';

		header("Content-type: application/x-msdownload"); 
		# replace excelfile.xls with whatever you want the filename to default to
		header("Content-Disposition: attachment; filename=$fn.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $table;
exit;
*/
?>
