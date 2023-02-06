
<?php

include 'phpqrcode/qrlib.php';

$EXHIBITOR_CODE = $_SESSION['EXHIBITOR_CODE'];
$sql_exh = "SELECT * FROM iijs_exhibitor WHERE Exhibitor_Code='$EXHIBITOR_CODE'";
$result_exh = $conn->query($sql_exh);
$row_exh = $result_exh->fetch_assoc();

$sql_catalogue =  "SELECT * FROM iijs_catalog WHERE Exhibitor_Code='$EXHIBITOR_CODE'";
$result_catalogue = $conn->query($sql_catalogue);
$row_catalogue = $result_catalogue->fetch_assoc();



$company_name = $row_catalogue['Exibitor_Name'];
$name = $row_catalogue['Catalog_ContactPerson'];
$position = $row_catalogue['Catalog_Designation'];
$telephone = $row_catalogue['Catalog_Phone'];
//$cellno = $row_exh['Exhibitor_Mobile'];
$cellno = '';
$fax = $row_catalogue['Catalog_Fax'];
$email = strtolower($row_catalogue['Catalog_Email']);
//$url = $row_exh['Exhibitor_Website'];
$url ='';
$stall_no = $row_catalogue['Catalog_StallNo'];
$address = $row_catalogue['Catalog_Address1'];

//file path
$qr_file = "images/qr_code/".$EXHIBITOR_CODE.".png";
  
//other parameters
$ecc = 'H';
$pixel_size = 20;
$frame_size = 10;

$vcard = "BEGIN:VCARD\r\nVERSION:3.0\r\n
ORG:" . $company_name . "\r\n
N:" . $name . "\r\n
FN:" . $name . "\r\n
TITLE:" . $position . "\r\n
TEL;TYPE=work,voice:" . $telephone . "\r\n
TEL;TYPE=cell,voice:" . $cellno . "\r\n
TEL;TYPE=work,fax:" . $fax . "\r\n
URL;TYPE=work:" . $url . "\r\n
EMAIL;TYPE=internet,pref:" . $email . "\r\n
ADR;TYPE=work:" . $address . "\r\n
REV:" . date('Ymd') . "T195243Z\r\n
END:VCARD";
  
// Generates QR Code and Save as PNG
QRcode::png($vcard, $qr_file, $ecc, $pixel_size, $frame_size);
  
// Displaying the stored QR code if you want
//echo "<div><img src='".$qr_file."?v=".time()."' style='width:300px'></div>";

?>