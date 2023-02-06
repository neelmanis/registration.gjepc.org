<?php
// echo $_SERVER['DOCUMENT_ROOT'];exit;
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('db.inc.php');
include('functions.php');
include './../phpqrcode/qrlib.php';
require_once('./../dompdf/autoload.inc.php');
use Dompdf\Dompdf;
use Dompdf\Options;
define("DOMPDF_ENABLE_REMOTE", false);


$sql_all = "SELECT * FROM iijs_exhibitor WHERE isPdf='0'  limit 1";
$result_all = $conn->query($sql_all);
while($row_all = $result_all->fetch_assoc()){
 //$EXHIBITOR_CODE = $_SESSION['EXHIBITOR_CODE'];
  $EXHIBITOR_CODE =$row_all['Exhibitor_Code'];
  $EXH_stall =$row_all['Exhibitor_StallNo1'];



$sql_exh = "SELECT * FROM iijs_exhibitor WHERE Exhibitor_Code='$EXHIBITOR_CODE'";
$result_exh = $conn->query($sql_exh);
$row_exh = $result_exh->fetch_assoc();

$sql_catalogue =  "SELECT * FROM iijs_catalog WHERE Exhibitor_Code='$EXHIBITOR_CODE'";
$result_catalogue = $conn->query($sql_catalogue);
$row_catalogue = $result_catalogue->fetch_assoc();

$company_name = $row_exh['Exhibitor_Name'];
$name = $row_catalogue['Catalog_ContactPerson'];
$position = $row_catalogue['Catalog_Designation'];
$telephone = $row_catalogue['Catalog_Phone'];
//$cellno = $row_exh['Exhibitor_Mobile'];
$cellno = '';
$fax = $row_catalogue['Catalog_Fax'];
$email = strtolower($row_catalogue['Catalog_Email']);

$url ='';
 $stall_no = $row_exh['Exhibitor_StallNo1'];
//$stall_no = $row_catalogue['Catalog_StallNo'];
$address = $row_catalogue['Catalog_Address1'].','.$row_catalogue['Catalog_City'].','.$row_catalogue['Catalog_Pincode'].','.$row_catalogue['Catalog_State'];

/*-------------------------------- GENERATE QR CODE START-----------------------------*/


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


/*-------------------------------- GENERATE QR CODE END-------------------------------*/
$html ='<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
</head>
<body style="margin: 0;">
  <table cellspacing="0" width="550px" align="center" style="font-family: Open Sans, sans-serif; border:1px solid #000">
    <tr>
      <td valign="top" style="width:70%; padding: 30px;">
        <img src="images/qr_code/assets/logo.png" alt="">
        <h1 style="font-size:40px; line-height: 45px; font-weight: 700; margin-bottom:20px">Scan to <br> Save Contact</h1>
        <img src="'.$qr_file.'" style="text-align: center;width:200px;" alt="" >
        <h2 style="font-size:30px;  margin-bottom: 0; font-weight: 500; text-transform:uppercase">'.$company_name.'</h2>
        <h3 style="font-size:20px; font-weight: 500; margin-bottom: 0;">Stall Number - '.$stall_no.'</h3>
      </td>
      <td style="width:30%; background:url(./images/qr_code/assets/rightBg.png) left #AF86A2 no-repeat;  position: relative;">
        <div style="position: absolute; top:20px; left:0; width:100%; text-align:center;"><img src="./images/qr_code/assets/earth.png" alt=""></div>
        <div style="position: absolute; top:470px; left:0; width:100%; text-align:center;"><img src="./images/qr_code/assets/gjepc.png" alt=""></div>
      </td>
    </tr>
  </table>
</body>
</html>';

// echo $html;exit;
$filename = $EXH_stall;
ob_get_clean();
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new DOMPDF($options);
$dompdf->loadHtml($html);
// $customPaper = array(0,0,360,360);
$dompdf->setPaper($customPaper);
$dompdf->render();

 $dompdf->stream($filename, array("Attachment" => 1));
 file_put_contents($_SERVER['DOCUMENT_ROOT'].'/manual_signature/images/qr_code/'.$filename.'.pdf', $dompdf->output());
 //$filePath = $_SERVER['DOCUMENT_ROOT'].'/manual_iijs/images/qr_code/'.$filename.'.pdf';
 $ids = $row_all['Exhibitor_ID'];
 $sql_all_update = "UPDATE iijs_exhibitor SET   isPdf='1'  WHERE Exhibitor_ID='$ids'";
 $conn->query($sql_all_update);
 $dompdf->clear();
 }