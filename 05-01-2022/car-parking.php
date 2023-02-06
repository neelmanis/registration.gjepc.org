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
define("DOMPDF_ENABLE_REMOTE", false);
echo "Hii";exit;
$sql_exh = "select * from exhibitor_car_parking_master where Exhibitor_Area = 1086";
//$sql_exh = "select * from globalparking where `area` = 9";//Exhibitor_Code = 'EXH902'
$result_all = $conn->query($sql_exh);
//print_r($result_all);exit;
while($row_all = $result_all->fetch_assoc()){
    
    $EXHIBITOR_CODE =$row_all['Exhibitor_Code'];
   
    $company_name = $row_all['Exhibitor_Name'];
    $Exhibitor_Code = $row_all['Exhibitor_Code'];
    $Exhibitor_Area = $row_all['Exhibitor_Area'];
    $Exhibitor_HallNo = $row_all['Exhibitor_HallNo'];
    $Gate_No = $row_all['Gate_No'];
    $registration_id = $row_all['Exhibitor_Registration_ID'];

    $sql_area = "SELECT * FROM car_parking_area_master WHERE area=$Exhibitor_Area and is_active = '1' ";
    
    $result_area = $conn->query($sql_area);
    if ($result_area->num_rows > 0) {
        while($row = $result_area->fetch_assoc()) {
            $car_pass = $row['pass'];
        }
    }
    $date = date('Y-m-d');
    if($car_pass > 1){
       
        for ($i = 1; $i <= $car_pass; $i++){
            $digits = 9;
            $j = $i;	
            $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
            $checkUniqueIdentifier = $conn->query("SELECT * FROM globalparking WHERE `unique_code`='$uniqueIdentifier'");
            $countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
            while($countUniqueIdentifier > 0) {
                $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
            }
            // $getGate = $conn->query("SELECT * FROM gate_master WHERE `gate_no`='$Gate_No'");
            // $gate_row = $getGate->fetch_assoc();
            // $gate = $gate_row['gate'];
            $insertParking = "INSERT INTO globalparking  SET `registration_id`='$registration_id',`unique_code`='$uniqueIdentifier',`name`='$company_name',`area`='$Exhibitor_Area',`hall_no`='$Exhibitor_HallNo',`car_pass`='$i',`category`='EXH',`created_at`='$date'";
            $insertParkingResult = $conn->query($insertParking);
            
            if($insertParkingResult == 1){
                // $vcard = "$uniqueIdentifier | $company_name | $registration_id | $Exhibitor_HallNo | $Gate_No";
            
                // /*-------------------------------- GENERATE QR CODE START -----------------------------*/

                // //file path
                // $qr_file = "images/qr_code/".$EXHIBITOR_CODE.".png";
                
                // //other parameters
                // $ecc = 'H';
                // $pixel_size = 20;
                // $frame_size = 1;

                // Generates QR Code and Save as PNG
                //QRcode::png($vcard, $qr_file, $ecc, $pixel_size, $frame_size);

                /*-------------------------------- GENERATE QR CODE END-------------------------------*/

                // $html ='<!DOCTYPE html>
                // <html>
                // <head>
                //     <meta charset="utf-8">
                //     <meta name="viewport" content="width=device-width, initial-scale=1">
                //     <title></title>
                // </head>
                // <body style="margin: 0;">
                
                
                //     <table width="320" cellpadding="0" cellspacing="0" align="center" style="font-family: Open Sans, sans-serif; padding: 20px; background: url(./images_qr/bg.png) no-repeat center right #F9BBAD">
                //         <tr>
                //             <td>
                //                 <p style="margin:0 0 10px 0; font-size: 12px;"><strong>Parking on ﬁrst-come ﬁrst-serve basis</strong></p>
                //                 <h1 style="margin:0;font-size: 20px;">ENTRY GATE-'.$Gate_No.'</h1>
                //                 <h2 style="margin:0 0 10px 0;font-size: 20px;">GR-1</h2>
                //                 <h3 style="margin:0 0 0 0;display:table;font-size: 20px;">Exhibitor Parking <span style="width:100%; height: 2px; background:#000;display: block;"></span></h3>
                //                 <table style="margin-bottom: 15px;font-size: 12px;">
                //                     <tr>
                //                         <td>Company:'.$company_name.'</td>
                //                         <td>&nbsp;</td>
                //                     </tr>
                //                     <tr>
                //                         <td>Hall No.:'.$Exhibitor_HallNo.'</td>
                //                         <td>&nbsp;</td>
                //                     </tr>
                //                 </table>
                //                 <div style="width:100px; height:100px; background:#fff;margin-bottom: 15px;">
                //                     <img src="'.$qr_file.'?v=1.9" style="width:100%; text-align: center;  margin-bottom:20px" alt="">
                //                 </div>
                //                 <div style="width:96%;  border: 2px solid #000;margin-bottom: 15px; padding: 2% ">
                //                     <span>'.$uniqueIdentifier.'</span>
                //                 </div>
                //                 <div style="margin-bottom: 15px;"><img src="images_qr/logo.png" alt=""></div>
                //                 <div style="margin-bottom: 15px;"><img src="images_qr/earthLogo.png" alt=""></div>
                //                 <div><img src="images_qr/gjepcLogo.png" alt=""></div>
                //             </td>
                //         </tr>
                //     </table>
                
                // </body>
                // </html>';
                
                // $filename = $uniqueIdentifier;
                // ob_get_clean();
                // $options = new Options();
                // $options->set('isRemoteEnabled', true);
                // $dompdf = new DOMPDF($options);
                // $dompdf->loadHtml($html);
                // $dompdf->setPaper('Legal', 'Landscape');

                // //$customPaper = array(0,0,360,360);
                // //$dompdf->setPaper($customPaper);
                // $dompdf->render();

                // $dompdf->stream($filename, array("Attachment" => 1));
                // file_put_contents($_SERVER['DOCUMENT_ROOT'].'/car-qr-code/images/qr_code/'.$filename.'.pdf', $dompdf->output());
                // //$filePath = $_SERVER['DOCUMENT_ROOT'].'/manual_iijs/images/qr_code/'.$filename.'.pdf';
                // $sql_all_update = "UPDATE parking_master SET is_qr_generated='1'  WHERE uniqueIdentifier='$uniqueIdentifier'";
                
                // $conn->query($sql_all_update);
                // $dompdf->clear();
            }
            
        }
    } 
    else {
        $digits = 9;	
        $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
        $checkUniqueIdentifier = $conn->query("SELECT * FROM parking_master WHERE `uniqueIdentifier`='$uniqueIdentifier'");
        $countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
        while($countUniqueIdentifier > 0) {
            $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
        }
        // $getGate = $conn->query("SELECT * FROM gate_master WHERE `gate_no`='$Gate_No'");
        // $gate_row = $getGate->fetch_assoc();
        // $gate = $gate_row['gate'];
        $insertParking = "INSERT INTO globalparking  SET `registration_id`='$registration_id',`unique_code`='$uniqueIdentifier',`name`='$company_name',`area`='$Exhibitor_Area',`hall_no`='$Exhibitor_HallNo',`car_pass`='1',`category`='EXH',`created_at`='$date'";
        $insertParkingResult = $conn->query($insertParking);
        echo $insertParkingResult;
        if ($insertParkingResult == 1) {
            // $vcard = ".$uniqueIdentifier." | ".$company_name." | ".$registration_id." | ".$Exhibitor_HallNo." | ".$Gate_No.";
            // /*-------------------------------- GENERATE QR CODE START -----------------------------*/

            // //file path
            // $qr_file = "images/qr_code/" . $EXHIBITOR_CODE . ".png";

            // //other parameters
            // $ecc = 'H';
            // $pixel_size = 20;
            // $frame_size = 10;

            // // Generates QR Code and Save as PNG
            // QRcode::png($vcard, $qr_file, $ecc, $pixel_size, $frame_size);


            /*-------------------------------- GENERATE QR CODE END-------------------------------*/

            // $html = '<!DOCTYPE html>
            // <html>
            // <head>
            //     <meta charset="utf-8">
            //     <meta name="viewport" content="width=device-width, initial-scale=1">
            //     <title></title>
            // </head>
            // <body style="margin: 0;">
            
            
            //     <table width="320" cellpadding="0" cellspacing="0" align="center" style="font-family: Open Sans, sans-serif; padding: 20px; background: url(./images_qr/bg.png) no-repeat center right #F9BBAD">
            //         <tr>
            //             <td>
            //                 <p style="margin:0 0 10px 0; font-size: 12px;"><strong>Parking on ﬁrst-come ﬁrst-serve basis</strong></p>
            //                 <h1 style="margin:0;font-size: 20px;">ENTRY GATE-' . $Gate_No . '</h1>
            //                 <h2 style="margin:0 0 10px 0;font-size: 20px;">GR-1</h2>
            //                 <h3 style="margin:0 0 0 0;display:table;font-size: 20px;">Exhibitor Parking <span style="width:100%; height: 2px; background:#000;display: block;"></span></h3>
            //                 <table style="margin-bottom: 15px;font-size: 12px;">
            //                     <tr>
            //                         <td>Company:' . $company_name . '</td>
            //                         <td>&nbsp;</td>
            //                     </tr>
            //                     <tr>
            //                         <td>Hall No.:' . $Exhibitor_HallNo . '</td>
            //                         <td>&nbsp;</td>
            //                     </tr>
            //                 </table>
            //                 <div style="width:100px; height:100px; background:#fff;margin-bottom: 15px;">
            //                     <img src=' . $qr_file . ' style="width:100%; text-align: center;  margin-bottom:20px" alt="">
            //                 </div>
            //                 <div style="width:96%;  border: 2px solid #000;margin-bottom: 15px; padding: 2%">
            //                     <span>'.$uniqueIdentifier.'</span>
            //                 </div>
            //                 <div style="margin-bottom: 15px;"><img src="images_qr/logo.png" alt=""></div>
            //                 <div style="margin-bottom: 15px;"><img src="images_qr/earthLogo.png" alt=""></div>
            //                 <div><img src="images_qr/gjepcLogo.png" alt=""></div>
            //             </td>
            //         </tr>
            //     </table>
            
            // </body>
            // </html>';

            // $filename = $uniqueIdentifier;
            // ob_get_clean();
            // $options = new Options();
            // $options->set('isRemoteEnabled', true);
            // $dompdf = new DOMPDF($options);
            // $dompdf->loadHtml($html);
            // // $customPaper = array(0,0,360,360);
            // $dompdf->setPaper($customPaper);
            // $dompdf->render();

            // $dompdf->stream($filename, array("Attachment" => 1));
            // file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/car-qr-code/images/qr_code/' . $filename . '.pdf', $dompdf->output());
            // //$filePath = $_SERVER['DOCUMENT_ROOT'].'/manual_iijs/images/qr_code/'.$filename.'.pdf';
            // $sql_all_update = "UPDATE parking_master SET is_qr_generated='1'  WHERE uniqueIdentifier='$uniqueIdentifier'";
            // $conn->query($sql_all_update);
            // $dompdf->clear();
        }    
    }
   

    
}

?>