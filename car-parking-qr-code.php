<?php 
include('db.inc.php');
include('functions.php');
include './../phpqrcode/qrlib.php';
require_once('./../dompdf/autoload.inc.php');
use Dompdf\Dompdf;
use Dompdf\Options;
define("DOMPDF_ENABLE_REMOTE", false);

$hostname = "192.168.40.107";
$uname="appadmin";
$pwd= "G@k593#sgtk";
//$database="manual_iijs2021";
$database="manual_signature";

// Create connection
$conn = new mysqli($hostname, $uname, $pwd, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
	
}
$sql_exh = "SELECT * FROM iijs_exhibitor WHERE 1";
$result_all = $conn->query($sql_all);
while($row_all = $result_all->fetch_assoc()){
    //$EXHIBITOR_CODE = $_SESSION['EXHIBITOR_CODE'];
    $EXHIBITOR_CODE =$row_all['Exhibitor_Code'];
    $EXH_stall =$row_all['Exhibitor_StallNo1'];

    $sql_exh = "SELECT * FROM iijs_exhibitor WHERE Exhibitor_Code='$EXHIBITOR_CODE'";
    $result_exh = $conn->query($sql_exh);
    $row_exh = $result_exh->fetch_assoc();

    $company_name = $row_exh['Exhibitor_Name'];

    $url ='';
    $stall_no = $row_exh['Exhibitor_StallNo1'];
    $digits = 9;	
    $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
    $checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");
    $countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
    while($countUniqueIdentifier > 0) {
        $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
    }
    /*-------------------------------- GENERATE QR CODE START-----------------------------*/

    //file path
    $qr_file = $_SERVER['DOCUMENT_ROOT'].'/car-qr-code/images/qr_images/'.$EXHIBITOR_CODE.".png";
    
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    </head>
    <body style="margin: 0;">


    <table cellspacing="0" width="100%" align="center" style="font-family: Open Sans, sans-serif; position:relative">
        <tr>
        <td valign="top" style="width:70%; background:#fedcba; padding: 30px;">
            <table width="100%">
            <tr>
                <td><h1 style="font-size:40px; line-height: 45px; font-weight: 500; color:#104644; margin-bottom:20px">Scan to <br> Save Contact</h1></td>
                <td><img src="./images/visiting_card_assets/scanIcon.png" alt=""></td>
            </tr>
            <tr>
                <td colspan="2">
                <img src="'.$qr_file.'" style="width:100%; text-align: center;  margin-bottom:20px" alt="">
                <h2 style="font-size:30px; line-height: 0; margin-bottom: 0; font-weight: 500; color:#104644; text-transform:uppercase">'.$company_name.'</h2>
                <h3 style="font-size:20px; font-weight: 500; margin-bottom: 0; color:#104644">stall number - '.$stall_no.'</h3>
                </td>
            </tr>
            </table>
        </td>
        <td style="width:30%; background:url(./images/visiting_card_assets/rightBg.png) right #124645; background-size: cover; position: relative;">
            <div style="position: absolute; top:20px; left:0; width:100%; text-align:center;"><img src="./images/visiting_card_assets/iijs-signature.png" alt=""></div>
            <div style="position: absolute; top:68%; left:0; width:100%; text-align:center;"><img src="./images/visiting_card_assets/gjepc.png" alt=""></div>
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
    // $customPaper = array(0,0,360,360);
    $dompdf->setPaper($customPaper);
    $dompdf->render();

    $dompdf->stream($filename, array("Attachment" => 1));
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/car-qr-code/images/qr_code/'.$filename.'.pdf', $dompdf->output());
    //$filePath = $_SERVER['DOCUMENT_ROOT'].'/manual_iijs/images/qr_code/'.$filename.'.pdf';
    $ids = $row_all['Exhibitor_ID'];
    $sql_all_update = "UPDATE iijs_exhibitor SET   isPdf='1'  WHERE Exhibitor_ID='$ids'";
    $conn->query($sql_all_update);
    $dompdf->clear();
}

?>