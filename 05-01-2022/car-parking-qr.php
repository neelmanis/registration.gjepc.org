<?php

include('db.inc.php');
include('functions.php');
include 'phpqrcode/qrlib.php';
require_once('dompdf/autoload.inc.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use Dompdf\Dompdf;
use Dompdf\Options;

exit;
define("DOMPDF_ENABLE_REMOTE", false);
    $gate_no = '4B';
    $hall_no = 7;
    // if(isset($_REQUEST['gate_no'])){
    //     $gate_no = $_REQUEST['gate_no'];
    // }
    // if(isset($_REQUEST['hall_no'])){
    //     $hall_no = $_REQUEST['hall_no'];
    // }
    $company_name = '';
    // if(isset($_REQUEST['company_name'])){
    //     $company_name = $_REQUEST['company_name'];
    // }
    $category = 'COTR';
    $agency_category = 'VIP';
    // if(isset($_REQUEST['category'])){
    //     $category = $_REQUEST['category'];
    // }
    for ($x = 1; $x <= 10; $x++) {
        $digits = 9;
        $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
        $checkUniqueIdentifier = $conn->query("SELECT * FROM globalparking WHERE `unique_code`='$uniqueIdentifier'");
        $countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
        while($countUniqueIdentifier > 0) {
            $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
        }

        $car_pass = '1';
        $date = date('Y-m-d');
    
        $insertGlobalParking = "INSERT INTO globalparking  SET `unique_code`='$uniqueIdentifier',`name`='$company_name',`hall_no`='$hall_no',`gate_no`='$gate_no',`car_pass`='$car_pass',`category`='$category',`agency_category`='$agency_category',`created_at`='$date'";
        $insertParkingResult = $conn->query($insertGlobalParking);
        echo $insertParkingResult = 1;
    }
    
    // echo 'Hiiiii'.$insertParkingResult;
    // exit;    
    
    // if ($insertParkingResult == 1) {
    //     $vcard = "$uniqueIdentifier | $company_name | $registration_id | $hall_no | $gate_no";

    //     /*-------------------------------- GENERATE QR CODE START -----------------------------*/

    //     //file path
    //     $qr_file = "images/qr_code/" . $uniqueIdentifier . ".png";

    //     //other parameters
    //     $ecc = 'H';
    //     $pixel_size = 20;
    //     $frame_size = 1;

    //     // Generates QR Code and Save as PNG
    //     QRcode::png($vcard, $qr_file, $ecc, $pixel_size, $frame_size);

    //     /*-------------------------------- GENERATE QR CODE END-------------------------------*/

    //     $html = '<!DOCTYPE html>
    //     <html>
    //     <head>
    //         <meta charset="utf-8">
    //         <meta name="viewport" content="width=device-width, initial-scale=1">
    //         <title></title>
    //     </head>
    //     <body style="margin: 0;">
        
        
    //         <table width="320" cellpadding="0" cellspacing="0" align="center" style="font-family: Open Sans, sans-serif; width:63.5mm; height:139.7mm; padding: 20px; background: url(./images_qr/bg.png) no-repeat center right #F9BBAD">
    //             <tr>
    //                 <td>
    //                     <p style="margin:0 0 10px 0; font-size: 12px;"><strong>Parking on first-come first-serve basis</strong></p>
    //                     <h1 style="margin:0;font-size: 20px;">ENTRY GATE-' . $gate_no . '</h1>
    //                     <h2 style="margin:0 0 10px 0;font-size: 20px;">GR-1</h2>
    //                     <h3 style="margin:0 0 0 0;display:table;font-size: 20px;">Exhibitor Parking <span style="width:100%; height: 2px; background:#000;display: block;"></span></h3>
    //                     <table style="margin-bottom: 15px;font-size: 12px;">
    //                         <tr>
    //                             <td>Company:' . $company_name . '</td>
    //                             <td>&nbsp;</td>
    //                         </tr>
    //                         <tr>
    //                             <td>Hall No.:' . $hall_no . '</td>
    //                             <td>&nbsp;</td>
    //                         </tr>
    //                     </table>
    //                     <div style="width:100px; height:100px; background:#fff;margin-bottom: 15px;">
    //                         <img src="' . $qr_file . '?v=1.9" style="width:100%; text-align: center;  margin-bottom:20px" alt="">
    //                     </div>
    //                     <div style="width:96%;  border: 2px solid #000;margin-bottom: 15px; padding: 2% ">
    //                         <span>' . $uniqueIdentifier . '</span>
    //                     </div>
    //                     <div style="margin-bottom: 15px;"><img src="images_qr/logo.png" alt=""></div>
    //                     <div style="margin-bottom: 15px;"><img src="images_qr/earthLogo.png" alt=""></div>
    //                     <div><img src="images_qr/gjepcLogo.png" alt=""></div>
    //                 </td>
    //             </tr>
    //         </table>
        
    //     </body>
    //     </html>';
    //     // echo $html;
    //     // exit;
    //     $filename = $uniqueIdentifier;
    //     ob_get_clean();
    //     $options = new Options();
    //     $options->set('isRemoteEnabled', true);
    //     $dompdf = new DOMPDF($options);
    //     $dompdf->loadHtml($html);
    //     $dompdf->setPaper('Legal', 'Landscape');
    //     $dompdf->render();
    //     $dompdf->stream($filename, array("Attachment" => 1));
    //     file_put_contents($_SERVER['DOCUMENT_ROOT'] . 'images/qr_code/pdf/' . $filename . '.pdf', $dompdf->output());
    //     $sql_all_update = "UPDATE globalparking SET isPdf='1'  WHERE `unique_code`='$uniqueIdentifier'";
    //     $conn->query($sql_all_update);
    //     $parking_master_all_update = "UPDATE parking_master SET `is_qr_generated`='1'  WHERE `uniqueIdentifier`='$uniqueIdentifier'";
    //     $conn->query($parking_master_all_update);
    //     $dompdf->clear();

    // }

//}
// function createPDF($pdf_content, $filename) {
//     $dompdf = new DOMPDF();
//     $dompdf->load_html($pdf_content);
//     $dompdf->render();
//     $output = $dompdf->output();
//     file_put_contents($filename, $output);
// }

?>