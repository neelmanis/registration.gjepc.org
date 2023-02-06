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
<html style="margin: 0; padding: 0; box-sizing: border-box">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Scan To Save Contact</title>
  </head>
  <body style="margin: 0; padding: 0">
    <table
      cellpadding="0"
      cellspacing="0"
      style="
        width: 100%;
     
        font-family: Open Sans, sans-serif;
        
        font-weight: 600;
      ">
      <tr style="background-color: #072f3a;">
        <td "align="left">
          <div style="padding: 18px; width: 200px;">
            <img
              style="width: 100%"
              src="https://gjepc.org/assets/images/iijs-01-08.png"
              alt=""
            />
          </div>
          </td>
          <td align="right">
          <div style="padding: 18px; max-width: 200px; float: right">
            <img
              style="width: 100%"
              src="https://gjepc.org/assets/images/gjepc-01-08.png"
              alt=""
            />
          </div>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <h2
            style="
              text-align: center;
              text-transform: uppercase;
              margin-top: 1rem;
            "
          >
            SCAN TO SAVE CONTACT
          </h2>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: center">
          <img
            style="width: 180px; height: 180px"
            src="'.$qr_file.'"
            alt=""
          />
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <h2
            style="
              text-align: center;
              text-transform: uppercase;
              margin-bottom: 10px;
            "
          >
          '.$company_name.'
          </h2>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <p
            style="
              text-align: center;
              text-transform: uppercase;
              margin-top: 0px;
            "
          >
          STALL NUMBER - '.$stall_no.'
          </p>
        </td>
      </tr>
    </table>
  </body>
</html>';

$filename = $EXH_stall;
ob_get_clean();
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new DOMPDF($options);
$dompdf->loadHtml($html);
$customPaper = array(0,0,360,360);
$dompdf->setPaper($customPaper);
$dompdf->render();

 $dompdf->stream($filename, array("Attachment" => 1));
 file_put_contents($_SERVER['DOCUMENT_ROOT'].'/manual_iijs/images/qr_code/'.$filename.'.pdf', $dompdf->output());
 //$filePath = $_SERVER['DOCUMENT_ROOT'].'/manual_iijs/images/qr_code/'.$filename.'.pdf';
 $ids = $row_all['Exhibitor_ID'];
 $sql_all_update = "UPDATE iijs_exhibitor SET   isPdf='1'  WHERE Exhibitor_ID='$ids'";
 $conn->query($sql_all_update);
 $dompdf->clear();
 }