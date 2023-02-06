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

$action = $_REQUEST['action'];
if($action == "generateDirect"){
  $sql_all = "SELECT Exhibitor_Code,Exhibitor_StallNo1,Exhibitor_ID FROM iijs_exhibitor WHERE  Exhibitor_Section !='machinery' and isPdf='0' limit 1";
}else{
  $EXHIBITOR_CODE = $_REQUEST['exihibitor_code'];
  $sql_all = "SELECT Exhibitor_Code,Exhibitor_StallNo1,Exhibitor_ID FROM iijs_exhibitor WHERE  Exhibitor_Section !='machinery' and EXHIBITOR_CODE = '$EXHIBITOR_CODE' limit 1";
}

$result_all = $conn->query($sql_all);
while($row_all = $result_all->fetch_assoc()){
 //$EXHIBITOR_CODE = $_SESSION['EXHIBITOR_CODE'];
  $EXHIBITOR_CODE =$row_all['Exhibitor_Code'];
  $EXH_stall =$row_all['Exhibitor_StallNo1'];



$sql_exh = "SELECT Exhibitor_Name,Exhibitor_StallNo1 FROM iijs_exhibitor WHERE Exhibitor_Code='$EXHIBITOR_CODE'";
$result_exh = $conn->query($sql_exh);
$row_exh = $result_exh->fetch_assoc();

$sql_catalogue =  "SELECT Catalog_ContactPerson,Catalog_Designation,Catalog_Phone,Catalog_Fax,Catalog_Email,Catalog_Address1,Catalog_City,Catalog_Pincode,Catalog_State FROM iijs_catalog WHERE Exhibitor_Code='$EXHIBITOR_CODE'";
$result_catalogue = $conn->query($sql_catalogue);
$row_catalogue = $result_catalogue->fetch_assoc();

$company_name = $row_exh['Exhibitor_Name'];
$name = $row_catalogue['Catalog_ContactPerson'];
$position = $row_catalogue['Catalog_Designation'];
$telephone = $row_catalogue['Catalog_Phone'];
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
$show_name = "IIJS SIGNATURE 2023";
$vcard = "BEGIN:VCARD\r\nVERSION:3.0\r\n
ORG:" . $company_name . "\r\n
N:" . $name . "\r\n
FN:" . $name . "\r\n
TITLE:" . $position . "\r\n
TEL;TYPE=work,voice:" . $telephone . "\r\n
TEL;TYPE=cell,voice:" . $cellno . "\r\n
TEL;TYPE=work,fax:" . $fax . "\r\n
URL;TYPE=work:" . $show_name . "\r\n
EMAIL;TYPE=internet,pref:" . $email . "\r\n
ADR;TYPE=work:" . $address . "\r\n
REV:" . date('Ymd') . "T195243Z\r\n
END:VCARD";
  
// Generates QR Code and Save as PNG
QRcode::png($vcard, $qr_file, $ecc, $pixel_size, $frame_size);


/*-------------------------------- GENERATE QR CODE END-------------------------------*/
$html ='<!DOCTYPE html>
<html style="margin:0; padding:0; box-sizing:border-box">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
</head>
<body style="margin:0; padding:0; font-family: Open Sans, sans-serif; box-sizing:border-box">

  <div style="width:450pt; height:450pt; position:relative; background:#fff; ">

    <div style="width:432pt; height:432pt; position:absolute; top:9pt; left:18pt;">

      <table cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top" style="width:332pt; height:432pt;">
            <div style="padding:10px 30px;">
              <img src="images/qr_code/assets/logos.svg" style="width:280px;margin-top:20px; " alt="">
              <h1 style="font-size:35px; line-height: 45px; font-weight: 700; margin-bottom:10px">Scan to <br> Save Contact</h1>
              <img src="'.$qr_file.'" style="text-align: center;width:200px;" alt="">
              <h2 style="font-size:22px;  margin-bottom: 0; font-weight: 700; text-transform:uppercase">'.$company_name.'</h2>
              <h3 style="font-size:20px; font-weight: 700; margin-bottom: 0;">Stall Number - '.$stall_no.'</h3>
            </div>
          </td>
          <td valign="top" style="width:100pt; height:432pt; position: relative;">
            <div style="position:absolute; top:-9pt; bottom:-9pt; left:0; width:100%; background:#AF86A2;">
              <div style="width:100%; padding-top:18pt; padding-left:10px">
                <img src="./images/qr_code/assets/earth.png" style="width:100px;" alt="">
              </div>
              <div>
                <img src="./images/qr_code/assets/bird.svg" style="width:100%;" alt="">
              </div>
              <div style="position: absolute; bottom:0; left:10px; width:100%;">
                <img src="./images/qr_code/assets/gjepcLogo.svg" style="width:100px" alt="">
              </div>
            </div>
          </td>
        </tr>
      </table>

    </div>

    
  </div>
</body>
</html>';

// echo $html;exit;
$filename = $EXH_stall;
ob_get_clean();
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new DOMPDF($options);
$dompdf->loadHtml($html);
$customPaper = array(0,0,450,450);
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
$conn->close();