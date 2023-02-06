<?php

include('db.inc.php');
include('functions.php');
include 'phpqrcode/qrlib.php';
require_once('dompdf/autoload.inc.php');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
use Dompdf\Dompdf;
use Dompdf\Options;
define("DOMPDF_ENABLE_REMOTE", false);
// echo "<pre>";
// print_r($_POST);
// exit;
if(isset($_POST['action']) && $_POST['action'] == 'update'){
    $company_name = $_POST['update_name'];
    
    $adminId = $_POST['admin'];
    $status = $_POST['status'];
    $unique_code = $_POST['unique_code'];
    $gate_no = $_POST['gate'];
    $vehicle_number = strtoupper($_POST['vehicle_number']);
    $hall_no = $_POST['hall_no'];
    $ground_no = $_POST['ground_no'];
    $check_data = $conn->query("SELECT * FROM globalparking WHERE `unique_code`='$unique_code'");
    $count = $check_data->num_rows;
    if($count == 0){
        echo '<script language="javascript">';
        echo 'alert(Data Not Found)';  //not showing an alert box.
        echo '</script>';
        exit;
    } else {
        $update_at = date('Y-m-d H:i:s');
        $sql_update = "update globalparking set `name`='$company_name',  `admin_id`='$adminId',`gate_no`='$gate_no',ground_no='$ground_no',`hall_no`='$hall_no',`vehicle_no`='$vehicle_number',`status`='$status', `isDataPosted`='N',`updated_at`='$update_at' where `unique_code`='$unique_code' ";
        $update = $conn->query($sql_update);
        if($update == 1){
            echo '<script type="text/javascript">
                window.location = "https://www.gjepc.org/admin/car-passes.php?action=view"
            </script>';
        } else {
            die ("Mysql Insert Error: " . $conn->error);
        }
    }   
}
if(isset($_POST) && !empty($_POST) && $_POST['action'] == 'save'){
    $company_name = $_POST['name'];
    if(!isset($company_name) ){
        $company_name = '';
    }
    $category = $_POST['category'];
    $gate_no = $_POST['gate'];
    $ground_no = $_POST['ground_no'];
    $hall_no = $_POST['hall_no'];
    $status = $_POST['status'];
    $created_at = date('Y-m-d H:i:s');
    $adminId = $_POST['admin'];
    $digits = 9;	
    $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
    $checkUniqueIdentifier = $conn->query("SELECT * FROM globalparking WHERE `unique_code`='$uniqueIdentifier'");
    $countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
    while($countUniqueIdentifier > 0) {
        $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
    }
    $insert = "INSERT INTO globalparking SET post_date=NOW(), `unique_code`='$uniqueIdentifier',admin_id='$adminId',`name`='$company_name',`category`='$category',`gate_no`='$gate_no',car_pass='1',ground_no='$ground_no',`hall_no`='$hall_no',`status`='$status',`created_at`='$created_at'";
    //$insertGlobalParking = $conn->query($insert);
    //$insertGlobalParking = 1;
    if($insertGlobalParking = 1){
            
        $vcard = "$uniqueIdentifier | $company_name  | $hall_no | $gate_no";
    
        /*-------------------------------- GENERATE QR CODE START -----------------------------*/

        //file path
        $qr_file = "images/qr_code/".$uniqueIdentifier.".png";
        
        //other parameters
        $ecc = 'H';
        $pixel_size = 20;
        $frame_size = 1;

        // Generates QR Code and Save as PNG
        QRcode::png($vcard, $qr_file, $ecc, $pixel_size, $frame_size);
        if($hall_no == 3 || $hall_no == 7){
            $gate_no = 4;
        }
        if($agency_category == 'E'){
            $color_class = '#F9BBAD';
            $color_text = '#000000';
            $tag = 'Exhibitor';
            $bird_svg = 'exhibitorBird.svg';
            $logo = 'gjepcLogo.svg';
            $signature_logo = 'logo.svg';
            $igjme_logo = 'igjmeLogo.svg';
            $earth_logo = 'LogoUnits-black.png';
            $name_filed = '<tr>
                    <td>Company: '.$company_name.'</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Hall No.: '.$hall_no.'</td>
                    <td>&nbsp;</td>
                </tr>';
            $ground_head = '<h2 style="margin:0;font-size: 15pt;color: '.$color_text.';">'.$ground_no.'</h2>';     
        } else if($agency_category == 'G'){
            $color_class = '#B086A2';
            $color_text = '#ffff';
            $tag = 'Guest';
            $bird_svg = 'exhibitorBirdGuest.svg';
            $logo = 'guest-gjepcLogo.svg';
            $signature_logo = 'logo-white.svg';
            $igjme_logo = 'igjmeLogo-white.svg';
            $earth_logo = 'LogoUnits-white.png';
            $name_filed = '<tr>
                    <td></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td>&nbsp;</td>
                </tr>';
            $ground_head = '<h2 style="margin:0;font-size: 15pt;color: '.$color_text.';">'.$ground_no.'</h2>';     
        } else if($agency_category == 'VIP'){
            $color_class = '#0F7070';
            $color_text = '#ffff';
            $tag = 'VIP';
            $bird_svg = 'exhibitorBirdVip.svg';
            $logo = 'guest-gjepcLogo.svg';
            $signature_logo = 'logo-white.svg';
            $igjme_logo = 'igjmeLogo-white.svg';
            $earth_logo = 'LogoUnits-white.png';
            $name_filed = 'tr>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>';
            $ground_head = '<h2 style="margin:0;font-size: 15pt;color: '.$color_text.';">'.$ground_no.'</h2>';         
        } else if($agency_category == 'VVIP'){
            $color_class = '#B3AECE';
            $tag = 'Exhibitor';
            $color_text = '#000000';
            $tag = 'VVIP';
            $bird_svg = 'exhibitorBirdVip.svg';
            $logo = 'gjepcLogo.svg';
            $signature_logo = 'logo.svg';
            $igjme_logo = 'igjmeLogo.svg';
            $earth_logo = 'LogoUnits-black.png';
            $name_filed = '<tr>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>';
            $ground_head = '<h2 style="margin:0;font-size: 15pt;color: '.$color_text.';">'.$ground_no.'</h2>';         
        } else if($agency_category == 'O'){
            $color_class = '#82A8C8';
            $tag = 'Organiser';
            $color_text = '#000000';
            $bird_svg = 'exhibitorBirdGuest.svg';
            $logo = 'gjepcLogo.svg';
            $signature_logo = 'logo.svg';
            $igjme_logo = 'igjmeLogo.svg';
            $earth_logo = 'LogoUnits-black.png';
            $name_filed = '<tr>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>';
            $ground_head = '<h2 style="margin:0;font-size: 15pt;color: '.$color_text.';">'.$ground_no.'</h2>'; 
        } else if($agency_category == 'S'){
            $color_class = '#636363';
            $tag = 'Service';
            $color_text = '#fff';
            $bird_svg = 'exhibitorBirdGuest.svg';
            $logo = 'guest-gjepcLogo.svg';
            $signature_logo = 'logo-white.svg';
            $igjme_logo = 'igjmeLogo-white.svg';
            $earth_logo = 'LogoUnits-white.png';
            $name_filed = '
                    <tr>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>
                <tr>
                    <td></td>
                    <td>&nbsp;</td>
                </tr>';
            $ground_head = '<h2 style="margin:0;font-size: 15pt;">&nbsp;</h2>';    
        } 

        if($ground_no == "Ground 1"){
            $ground_no = "Ground-1";
        }
        if($ground_no == "Ground 3"){
            $ground_no = "Ground-3";
        }
        if($ground_no == "Ground 4"){
            $ground_no = "Ground-4";
        }
        if($ground_no == "Ground 5"){
            $ground_no = "Ground-5";
        }
        /*-------------------------------- GENERATE QR CODE END-------------------------------*/

        $html ='<!DOCTYPE html>
        <html style="margin:0; padding:0; box-sizing:border-box;">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title></title>
        </head>
        <body style="margin:0; padding:0; ">
            <div style=" width:100%;  height: 100%; padding:0 15px; font-family: Open Sans, sans-serif;  background:'.$color_class.'">
                <img src="./images_qr/'.$bird_svg.'" alt="" style="position: absolute; top: 0; left: 0; z-index: -1; width: 100%; height: 100%; object-fit: cover;">
                <table cellpadding="0" cellspacing="0" style=" width:100%; padding-top:15px">
                    <tr>
                        <td> 
                            <h1 style="margin:0;font-size: 18pt;color: '.$color_text.';">ENTRY GATE-'.$gate_no.'</h1>
                            '.$ground_head.'
                            <h3 style="margin:0 0 5px 0;display:table;font-size: 15pt;color: '.$color_text.';">'.$tag.' Parking <span style="width:100%; height: 2px; background:'.$color_text.';display: block;"></span></h3>
                            <table style="margin-bottom: 5px;font-size: 7pt;text-transform:uppercase">
                                '.$name_filed.'
                            </table>
                            <div style="width:80px; height:80px; background:'.$color_text.';margin-bottom: 5px;">
                                <img src="'.$qr_file.'?v=1.9" style="width:100%; text-align: center;" alt="">
                            </div>
                            <div style="width:45.284mm; height:6.265mm; border: 1px solid '.$color_text.';margin-bottom: 5px;">
                                <span style="color:'.$color_text.';">'.$unique_code.'</span>  
                            </div>
                            <div style="font-size:7pt;margin:0 0 5px 0; color:'.$color_text.';">
                                Parking on first-come first-serve basis
                            </div>
                            <div style="margin-bottom: 10px;">
                                <img src="images_qr/'.$signature_logo.'" style="width:31.018mm; height:18.059mm;" alt="">
                            </div>
                            
                            <div style="margin-bottom: 10px;"><img src="images_qr/'.$igjme_logo.'" style="width:21.553mm; height:12.006mm;" alt=""></div>
                            <div style="margin-bottom: 5px;"><img src="images_qr/'.$earth_logo.'" style="width:12.743mm; height:14.733mm;" alt=""></div>
                            <div><img src="images_qr/'.$logo.'" style="width:16.873mm; height:5.579mm" alt=""></div>
                        </td>
                    </tr>
                </table>
            </div>
        </body>
        </html>';
        echo $html;
        exit;
        $filename = $uniqueIdentifier;
        ob_get_clean();
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new DOMPDF($options);
        $dompdf->loadHtml($html);
        //$dompdf->setPaper('Legal', 'Landscape');
        $customPaper = array(0,0,178.583,396.85);
        $dompdf->setPaper($customPaper);
        $dompdf->render();
        $dompdf->stream($filename, array("Attachment" => 1));
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'images/qr_code/pdf/'.$filename.'.pdf', $dompdf->output());
        // $sql_all_update = "UPDATE globalparking SET isPdf='1'  WHERE `unique_code`='$uniqueIdentifier'";
        // $conn->query($sql_all_update);
        $parking_master_all_update = "UPDATE parking_master SET `isGenerated`='Y'  WHERE `uniqueIdentifier`='$uniqueIdentifier'";
        $conn->query($parking_master_all_update);
        $dompdf->clear();
    }
    if($insertGlobalParking){
        echo "<meta http-equiv=refresh content=\"0;url=car-passes.php?action=view\">";
    } else {
        die ("Mysql Insert Error: " . $conn->error);
    } 
} 

//Generate Car Pass Unsing unique code

if(isset($_REQUEST) && $_REQUEST['action'] == 'generatePassOld'){
    $unique_code = trim($_REQUEST['unique_code']);
    if(!isset($unique_code) ){
        echo '<script>alert("Record Not Found...")</script>';
        exit;
    }
    $sqlGlobal = "SELECT * FROM gjepclivedatabase.globalparking  WHERE unique_code ='$unique_code' ";
    $resultGlobal = $conn->query($sqlGlobal);
    $insertGlobalParking = 1;
    $result_all = $conn->query($sql_exh);
    while($row_all = $resultGlobal->fetch_assoc()){
        
        $unique_code =$row_all['unique_code'];
        $company_name = $row_all['name'];
        $hall_no = $row_all['hall_no'];
        $gate_no = $row_all['gate_no'];
        $ground_no = $row_all['ground_no'];
        $agency_category = $row_all['agency_category'];
        
        $vcard = "$unique_code | $company_name  | $hall_no | $gate_no";
        
        /*-------------------------------- GENERATE QR CODE START -----------------------------*/
        
        //file path
        $qr_file = "images/qr_code/".$unique_code.".png";
        
        //other parameters
        $ecc = 'H';
        $pixel_size = 20;
        $frame_size = 1;
        // Generates QR Code and Save as PNG
        QRcode::png($vcard, $qr_file, $ecc, $pixel_size, $frame_size);
        if($hall_no == 3 || $hall_no == 7){
            $gate_no = 4;
        }
        if($agency_category == 'E'){
            $color_class = '#F9BBAD';
            $color_text = '#000000';
            $tag = 'Exhibitor';
            $bird_svg = 'exhibitorBird.svg';
            $logo = 'gjepcLogo.svg';
            $signature_logo = 'logo.svg';
            $igjme_logo = 'igjmeLogo.svg';
            $earth_logo = 'LogoUnits-black.png';
            $name_filed = '<tr>
                    <td>Company: '.$company_name.'</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Hall No.: '.$hall_no.'</td>
                    <td>&nbsp;</td>
                </tr>';
            $ground_head = '<h2 style="margin:0;font-size: 15pt;color: '.$color_text.';">'.$ground_no.'</h2>';     
        } else if($agency_category == 'G'){
            $color_class = '#B086A2';
            $color_text = '#ffff';
            $tag = 'Guest';
            $bird_svg = 'exhibitorBirdGuest.svg';
            $logo = 'guest-gjepcLogo.svg';
            $signature_logo = 'logo-white.svg';
            $igjme_logo = 'igjmeLogo-white.svg';
            $earth_logo = 'LogoUnits-white.png';
            $name_filed = '<tr>
                    <td></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td>&nbsp;</td>
                </tr>';
            $ground_head = '<h2 style="margin:0;font-size: 15pt;color: '.$color_text.';">'.$ground_no.'</h2>';     
        } else if($agency_category == 'VIP'){
            $color_class = '#0F7070';
            $color_text = '#ffff';
            $tag = 'VIP';
            $bird_svg = 'exhibitorBirdVip.svg';
            $logo = 'guest-gjepcLogo.svg';
            $signature_logo = 'logo-white.svg';
            $igjme_logo = 'igjmeLogo-white.svg';
            $earth_logo = 'LogoUnits-white.png';
            $name_filed = 'tr>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>';
            $ground_head = '<h2 style="margin:0;font-size: 15pt;color: '.$color_text.';">'.$ground_no.'</h2>';         
        } else if($agency_category == 'VVIP'){
            $color_class = '#B3AECE';
            $tag = 'Exhibitor';
            $color_text = '#000000';
            $tag = 'VVIP';
            $bird_svg = 'exhibitorBirdVip.svg';
            $logo = 'gjepcLogo.svg';
            $signature_logo = 'logo.svg';
            $igjme_logo = 'igjmeLogo.svg';
            $earth_logo = 'LogoUnits-black.png';
            $name_filed = '<tr>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>';
            $ground_head = '<h2 style="margin:0;font-size: 15pt;color: '.$color_text.';">'.$ground_no.'</h2>';         
        } else if($agency_category == 'O'){
            $color_class = '#82A8C8';
            $tag = 'Organiser';
            $color_text = '#000000';
            $bird_svg = 'exhibitorBirdGuest.svg';
            $logo = 'gjepcLogo.svg';
            $signature_logo = 'logo.svg';
            $igjme_logo = 'igjmeLogo.svg';
            $earth_logo = 'LogoUnits-black.png';
            $name_filed = '<tr>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>';
            $ground_head = '<h2 style="margin:0;font-size: 15pt;color: '.$color_text.';">'.$ground_no.'</h2>'; 
        } else if($agency_category == 'SV'){
            $color_class = '#636363';
            $tag = 'Service';
            $color_text = '#fff';
            $bird_svg = 'exhibitorBirdGuest.svg';
            $logo = 'guest-gjepcLogo.svg';
            $signature_logo = 'logo-white.svg';
            $igjme_logo = 'igjmeLogo-white.svg';
            $earth_logo = 'LogoUnits-white.png';
            $name_filed = '
                    <tr>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>
                <tr>
                    <td></td>
                    <td>&nbsp;</td>
                </tr>';
            $ground_head = '<h2 style="margin:0;font-size: 15pt;">&nbsp;</h2>';    
        } 

        if($ground_no == "Ground 1"){
            $ground_no = "Ground-1";
        }
        if($ground_no == "Ground 3"){
            $ground_no = "Ground-3";
        }
        if($ground_no == "Ground 4"){
            $ground_no = "Ground-4";
        }
        if($ground_no == "Ground 5"){
            $ground_no = "Ground-5";
        }
        /*-------------------------------- GENERATE QR CODE END-------------------------------*/
       
        $html ='<!DOCTYPE html>
        <html style="margin:0; padding:0; box-sizing:border-box;">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title></title>
        </head>
        <body style="margin:0; padding:0; ">
            <div style=" width:100%;  height: 100%; padding:0 15px; font-family: Open Sans, sans-serif;  background:'.$color_class.'">
                <img src="./images_qr/'.$bird_svg.'" alt="" style="position: absolute; top: 0; left: 0; z-index: -1; width: 100%; height: 100%; object-fit: cover;">
                <table cellpadding="0" cellspacing="0" style=" width:100%; padding-top:15px">
                    <tr>
                        <td> 
                            <h1 style="margin:0;font-size: 18pt;color: '.$color_text.';">ENTRY GATE-'.$gate_no.'</h1>
                            '.$ground_head.'
                            <h3 style="margin:0 0 5px 0;display:table;font-size: 15pt;color: '.$color_text.';">'.$tag.' Parking <span style="width:100%; height: 2px; background:'.$color_text.';display: block;"></span></h3>
                            <table style="margin-bottom: 5px;font-size: 7pt;text-transform:uppercase">
                                '.$name_filed.'
                            </table>
                            <div style="width:80px; height:80px; background:'.$color_text.';margin-bottom: 5px;">
                                <img src="'.$qr_file.'?v=1.9" style="width:100%; text-align: center;" alt="">
                            </div>
                            <div style="width:45.284mm; height:6.265mm; border: 1px solid '.$color_text.';margin-bottom: 5px;">
                                <span style="color:'.$color_text.';">'.$unique_code.'</span>  
                            </div>
                            <div style="font-size:7pt;margin:0 0 5px 0; color:'.$color_text.';">
                                Parking on first-come first-serve basis
                            </div>
                            <div style="margin-bottom: 10px;">
                                <img src="images_qr/'.$signature_logo.'" style="width:31.018mm; height:18.059mm;" alt="">
                            </div>
                            
                            <div style="margin-bottom: 10px;"><img src="images_qr/'.$igjme_logo.'" style="width:21.553mm; height:12.006mm;" alt=""></div>
                            <div style="margin-bottom: 5px;"><img src="images_qr/'.$earth_logo.'" style="width:12.743mm; height:14.733mm;" alt=""></div>
                            <div><img src="images_qr/'.$logo.'" style="width:16.873mm; height:5.579mm" alt=""></div>
                        </td>
                    </tr>
                </table>
            </div>
        </body>
        </html>';
            // echo $html;
            // exit;
            // <div style="font-size:4pt;margin:0 0 5px 0">
            //                     concurrent show
            //                 </div>
        $filename = $unique_code;
        ob_get_clean();
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new DOMPDF($options);
        $dompdf->loadHtml($html);
        //$dompdf->setPaper('Legal', 'Landscape');
        //$customPaper = array(0,0,178.583,396.85);
        $customPaper = array(0,0,178.583,396.85);
        $dompdf->setPaper($customPaper);
        $dompdf->render();
        $dompdf->stream($filename, array("Attachment" => 1));
        $parking_master_all_update = "UPDATE `gjepclivedatabase`.`globalparking` SET `isGenerated` = 'Y' WHERE `unique_code` = '$unique_code'";
        $conn->query($parking_master_all_update);
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'images/qr_code/pdf/'.$filename.'.pdf', $dompdf->output());
        $dompdf->clear();
        
    }
    if($insertGlobalParking){
        echo "<meta http-equiv=refresh content=\"0;url=car-passes.php?action=view\">";
    } else {
        die ("Mysql Insert Error: " . $conn->error);
    } 
} 

if(isset($_REQUEST) && $_REQUEST['action'] == 'generatePass'){
    $unique_code = $_REQUEST['unique_code'];
    
    if(!isset($unique_code) ){
        echo '<script>alert("Record Not Found...")</script>';
        exit;
    }
    $sqlGlobal = "SELECT * FROM gjepclivedatabase.globalparking  WHERE unique_code ='$unique_code' ";
    $resultGlobal = $conn->query($sqlGlobal);
    $insertGlobalParking = 1;
    $result_all = $conn->query($sql_exh);
    while($row_all = $resultGlobal->fetch_assoc()){
        
        $unique_code =$row_all['unique_code'];
        $company_name = $row_all['name'];
        $hall_no = $row_all['hall_no'];
        $gate_no = $row_all['gate_no'];
        $ground_no = $row_all['ground_no'];
        $agency_category = $row_all['agency_category'];
        
        $vcard = "$unique_code | $company_name  | $hall_no | $gate_no";
        
        /*-------------------------------- GENERATE QR CODE START -----------------------------*/
        
        //file path
        $qr_file = "images/qr_code/".$unique_code.".png";
        
        //other parameters
        $ecc = 'H';
        $pixel_size = 20;
        $frame_size = 1;

        // Generates QR Code and Save as PNG
        QRcode::png($vcard, $qr_file, $ecc, $pixel_size, $frame_size);
        if($hall_no == 3 || $hall_no == 7){
            $gate_no = 4;
        }
        if($agency_category == 'E'){
            $color_class = '#F9BBAD';
            $color_text = '#000000';
            $tag = 'Exhibitor';
            $bird_svg = 'exhibitorBird.svg';
            $logo = 'gjepcLogo.svg';
            $signature_logo = 'logo.svg';
            $igjme_logo = 'igjmeLogo.svg';
            $earth_logo = 'LogoUnits-black.png';
            $name_filed = '<tr>
                    <td>Company: '.$company_name.'</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Hall No.: '.$hall_no.'</td>
                    <td>&nbsp;</td>
                </tr>';
            $ground_head = '<h2 style="margin:0;font-size: 15pt;color: '.$color_text.';">'.$ground_no.'</h2>';     
        } else if($agency_category == 'G'){
            $color_class = '#B086A2';
            $color_text = '#ffff';
            $tag = 'Guest';
            $bird_svg = 'exhibitorBirdGuest.svg';
            $logo = 'guest-gjepcLogo.svg';
            $signature_logo = 'logo-white.svg';
            $igjme_logo = 'igjmeLogo-white.svg';
            $earth_logo = 'LogoUnits-white.png';
            $name_filed = '<tr>
                    <td></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td>&nbsp;</td>
                </tr>';
            $ground_head = '<h2 style="margin:0;font-size: 15pt;color: '.$color_text.';">'.$ground_no.'</h2>';     
        } else if($agency_category == 'VIP'){
            $color_class = '#0F7070';
            $color_text = '#ffff';
            $tag = 'VIP';
            $bird_svg = 'exhibitorBirdVip.svg';
            $logo = 'guest-gjepcLogo.svg';
            $signature_logo = 'logo-white.svg';
            $igjme_logo = 'igjmeLogo-white.svg';
            $earth_logo = 'LogoUnits-white.png';
            $name_filed = 'tr>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>';
            $ground_head = '<h2 style="margin:0;font-size: 15pt;color: '.$color_text.';">'.$ground_no.'</h2>';         
        } else if($agency_category == 'VVIP'){
            $color_class = '#B3AECE';
            $tag = 'Exhibitor';
            $color_text = '#000000';
            $tag = 'VVIP';
            $bird_svg = 'exhibitorBirdVip.svg';
            $logo = 'gjepcLogo.svg';
            $signature_logo = 'logo.svg';
            $igjme_logo = 'igjmeLogo.svg';
            $earth_logo = 'LogoUnits-black.png';
            $name_filed = '<tr>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>';
            $ground_head = '<h2 style="margin:0;font-size: 15pt;color: '.$color_text.';">'.$ground_no.'</h2>';         
        } else if($agency_category == 'O'){
            $color_class = '#82A8C8';
            $tag = 'Organiser';
            $color_text = '#000000';
            $bird_svg = 'exhibitorBirdGuest.svg';
            $logo = 'gjepcLogo.svg';
            $signature_logo = 'logo.svg';
            $igjme_logo = 'igjmeLogo.svg';
            $earth_logo = 'LogoUnits-black.png';
            $name_filed = '<tr>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>';
            $ground_head = '<h2 style="margin:0;font-size: 15pt;color: '.$color_text.';">'.$ground_no.'</h2>'; 
        } else if($agency_category == 'SV'){
            $color_class = '#636363';
            $tag = 'Service';
            $color_text = '#fff';
            $bird_svg = 'exhibitorBirdGuest.svg';
            $logo = 'guest-gjepcLogo.svg';
            $signature_logo = 'logo-white.svg';
            $igjme_logo = 'igjmeLogo-white.svg';
            $earth_logo = 'LogoUnits-white.png';
            $name_filed = '
                    <tr>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>
                <tr>
                    <td></td>
                    <td>&nbsp;</td>
                </tr>';
            $ground_head = '<h2 style="margin:0;font-size: 15pt;">&nbsp;</h2>';    
        } 

        if($ground_no == "Ground 1"){
            $ground_no = "Ground-1";
        }
        if($ground_no == "Ground 3"){
            $ground_no = "Ground-3";
        }
        if($ground_no == "Ground 4"){
            $ground_no = "Ground-4";
        }
        if($ground_no == "Ground 5"){
            $ground_no = "Ground-5";
        }
        /*-------------------------------- GENERATE QR CODE END-------------------------------*/
       
        $html ='<!DOCTYPE html>
        <html style="margin:0; padding:0; box-sizing:border-box;">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title></title>
        </head>
        <body style="margin:0; padding:0; ">
            <div style=" width:100%;  height: 100%; padding:0 15px; font-family: Open Sans, sans-serif;  background:'.$color_class.'">
                <img src="./images_qr/'.$bird_svg.'" alt="" style="position: absolute; top: 0; left: 0; z-index: -1; width: 100%; height: 100%; object-fit: cover;">
                <table cellpadding="0" cellspacing="0" style=" width:100%; padding-top:15px">
                    <tr>
                        <td> 
                            <h1 style="margin:0;font-size: 18pt;color: '.$color_text.';">ENTRY GATE-'.$gate_no.'</h1>
                            '.$ground_head.'
                            <h3 style="margin:0 0 5px 0;display:table;font-size: 15pt;color: '.$color_text.';">'.$tag.' Parking <span style="width:100%; height: 2px; background:'.$color_text.';display: block;"></span></h3>
                            <table style="margin-bottom: 5px;font-size: 7pt;text-transform:uppercase">
                                '.$name_filed.'
                            </table>
                            <div style="width:80px; height:80px; background:'.$color_text.';margin-bottom: 5px;">
                                <img src="'.$qr_file.'?v=1.9" style="width:100%; text-align: center;" alt="">
                            </div>
                            <div style="width:45.284mm; height:6.265mm; border: 1px solid '.$color_text.';margin-bottom: 5px;">
                                <span style="color:'.$color_text.';">'.$unique_code.'</span>  
                            </div>
                            <div style="font-size:7pt;margin:0 0 5px 0; color:'.$color_text.';">
                                Parking on first-come first-serve basis
                            </div>
                            <div style="margin-bottom: 10px;">
                                <img src="images_qr/'.$signature_logo.'" style="width:31.018mm; height:18.059mm;" alt="">
                            </div>
                            
                            <div style="margin-bottom: 10px;"><img src="images_qr/'.$igjme_logo.'" style="width:21.553mm; height:12.006mm;" alt=""></div>
                            <div style="margin-bottom: 5px;"><img src="images_qr/'.$earth_logo.'" style="width:12.743mm; height:14.733mm;" alt=""></div>
                            <div><img src="images_qr/'.$logo.'" style="width:16.873mm; height:5.579mm" alt=""></div>
                        </td>
                    </tr>
                </table>
            </div>
        </body>
        </html>';
        // echo $html;
        // exit;
        $filename = $unique_code;
        ob_get_clean();
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new DOMPDF($options);
        $dompdf->loadHtml($html);
        //$dompdf->setPaper('Legal', 'Landscape');
        $customPaper = array(0,0,178.583,396.85);
        $dompdf->setPaper($customPaper);
        $dompdf->render();
        $dompdf->stream($filename, array("Attachment" => 1));
        //$parking_master_all_update = "UPDATE globalparking SET `isGenerated`='Y'  WHERE `unique_code`='$unique_code'";
        //$conn->query($parking_master_all_update);
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'images/qr_code/pdf/'.$filename.'.pdf', $dompdf->output());
        // $sql_all_update = "UPDATE globalparking SET isPdf='1'  WHERE `unique_code`='$uniqueIdentifier'";
        // $conn->query($sql_all_update);
        
        $dompdf->clear();
        
    }
    if($insertGlobalParking){
        echo "<meta http-equiv=refresh content=\"0;url=car-passes.php?action=view\">";
    } else {
        die ("Mysql Insert Error: " . $conn->error);
    } 
}

///pass generate by cron
//print_r($_REQUEST);
if(isset($_REQUEST) && $_REQUEST['action'] == 'downloadCarPass'){
    $hall_no = $_REQUEST['hall'];
    if(!isset($hall_no) ){
        echo '<script>alert("Record Not Found...")</script>';
        exit;
    }
    $sqlGlobal = "SELECT * FROM gjepclivedatabase.globalparking  WHERE hall_no ='$hall_no' and name != '' and `isGenerated`='N' order by id limit 1";
    $resultGlobal = $conn->query($sqlGlobal);
    $insertGlobalParking = 1;
    if ($resultGlobal->num_rows > 0) {
        while ($row_all = $resultGlobal->fetch_assoc()) {
            if ($insertGlobalParking == 1) {
                $unique_code = $row_all['unique_code'];

                $company_name = $row_all['name'];
                $hall_no = $row_all['hall_no'];
                $gate_no = $row_all['gate_no'];
                $ground_no = $row_all['ground_no'];
                $agency_category = $row_all['agency_category'];

                $vcard = "$unique_code | $company_name  | $hall_no | $gate_no";


                /*-------------------------------- GENERATE QR CODE START -----------------------------*/

                //file path
                $qr_file = "images/qr_code/" . $unique_code . ".png";

                //other parameters
                $ecc = 'H';
                $pixel_size = 20;
                $frame_size = 1;

                // Generates QR Code and Save as PNG
                QRcode::png($vcard, $qr_file, $ecc, $pixel_size, $frame_size);
                if ($hall_no == 3 || $hall_no == 7) {
                    $gate_no = 4;
                }
                if ($agency_category == 'E') {
                    $color_class = '#F9BBAD';
                    $tag = 'Exhibitor';
                } else if ($agency_category == 'G') {
                    $color_class = '#B086A2';
                    $tag = 'Guest';
                } else if ($agency_category == 'VIP') {
                    $color_class = '#0F7070';
                    $tag = 'VIP';
                } else if ($agency_category == 'VVIP') {
                    $color_class = '#B3AECE';
                    $tag = 'VVIP';
                } else if ($agency_category == 'O') {
                    $color_class = '#82A8C8';
                    $tag = 'Organiser';
                } else if ($agency_category == 'S') {
                    $color_class = '#636363';
                    $tag = 'Services';
                }

                if ($ground_no == "Ground 1") {
                    $ground_no = "Ground-1";
                }
                if ($ground_no == "Ground 3") {
                    $ground_no = "Ground-3";
                }
                if ($ground_no == "Ground 4") {
                    $ground_no = "Ground-4";
                }
                if ($ground_no == "Ground 5") {
                    $ground_no = "Ground-5";
                }
                /*-------------------------------- GENERATE QR CODE END-------------------------------*/

                $html = '<!DOCTYPE html>
                <html style="margin:0; padding:0; box-sizing:border-box;">
                <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title></title>
                </head>
                <body style="margin:0; padding:0; ">
                    <div style=" width:100%;  height: 100%; padding:0 15px; font-family: Open Sans, sans-serif; background: url(./images_qr/bg.png) no-repeat center right ' . $color_class . '">
                        <table cellpadding="0" cellspacing="0" style=" width:100%; padding-top:15px">
                            <tr>
                                <td> 
                                    <h1 style="margin:0;font-size: 18pt;">ENTRY GATE-' . $gate_no . '</h1>
                                    <h2 style="margin:0;font-size: 18pt;">' . $ground_no . '</h2>
                                    <h3 style="margin:0 0 5px 0;display:table;font-size: 15pt;">' . $tag . ' Parking <span style="width:100%; height: 2px; background:#000;display: block;"></span></h3>
                                    <table style="margin-bottom: 5px;font-size: 7pt;text-transform:uppercase">
                                        <tr>
                                            <td>Company: ' . $company_name . '</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>Hall No.: ' . $hall_no . '</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table>
                                    <div style="width:100px; height:100px; background:#fff;margin-bottom: 5px;">
                                        <img src="' . $qr_file . '?v=1.9" style="width:100%; text-align: center;" alt="">
                                    </div>
                                    <div style="width:45.284mm; height:6.265mm; border: 1px solid #000;margin-bottom: 5px;">
                                        <span>' . $unique_code . '</span>  
                                    </div>
                                    <p style="margin:0 0 5px 0; font-size: 7pt;"><span>Parking on first-come first-serve basis</span></p>
                                    <div style="margin-bottom: 10px;"><img src="images_qr/logo.svg" style="width:31.018mm; height:18.059mm;" alt=""></div>
                                    <div style="margin-bottom: 10px;"><img src="images_qr/logo.svg" style="width:21.553mm; height:12.006mm;" alt=""></div>
                                    <div style="margin-bottom: 10px;"><img src="images_qr/earthLogo.png" style="width:12.743mm; height:14.733mm;" alt=""></div>
                                    <div><img src="images_qr/gjepcLogo.svg" style="width:16.873mm; height:5.579mm" alt=""></div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </body>
                </html>';
                // echo $html;
                // exit;
                $filename = $unique_code;
                ob_get_clean();
                $options = new Options();
                $options->set('isRemoteEnabled', true);
                $dompdf = new DOMPDF($options);
                $dompdf->loadHtml($html);
                //$dompdf->setPaper('Legal', 'Landscape');
                $customPaper = array(0, 0, 178.583, 396.85);
                $dompdf->setPaper($customPaper);
                $dompdf->render();
                $dompdf->stream($filename, array("Attachment" => 1));
                $file_download = file_put_contents($_SERVER['DOCUMENT_ROOT'] . 'images/qr_code/pdf/' . $filename . '.pdf', $dompdf->output());

                // $sql_all_update = "UPDATE globalparking SET isPdf='1'  WHERE `unique_code`='$uniqueIdentifier'";
                // $conn->query($sql_all_update);
                if($file_download){
                    $parking_master_all_update = "UPDATE globalparking SET `isGenerated`='Y'  WHERE `unique_code`='$unique_code'";
                    $conn->query($parking_master_all_update);
                    $dompdf->clear();
                } else {
                    echo 'failed';
                    exit;
                }
                
            }
        }
    } else {
        echo "data not found";
    }  
    
} 
?>