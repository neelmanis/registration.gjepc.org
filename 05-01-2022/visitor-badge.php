<?php
error_reporting(E_ALL);
//ini_set('display_errors', 1);
session_start();
include('db.inc.php');
include('functions.php');
include 'phpqrcode/qrlib.php';
require_once('dompdf/autoload.inc.php');

use Dompdf\Dompdf;
use Dompdf\Options;

define("DOMPDF_ENABLE_REMOTE", false);
$action = $_REQUEST['action'];
if($action =="generateBadge"){
  $uniqueIdentifier = $_REQUEST['uniqueIdentifier'];
  $sqlGlobal = "SELECT * FROM gjepclivedatabase.globalExhibition  WHERE uniqueIdentifier ='$uniqueIdentifier'  ";
  $resultGlobal = $conn->query($sqlGlobal);
  $rowGlobal = $resultGlobal->fetch_assoc();

  $participant_Type = $rowGlobal['participant_Type'];
  $registration_id = $rowGlobal['registration_id'];
  $visitor_id = $rowGlobal['visitor_id'];


}else{
  $participant_Type = $_SESSION['participant_Type'];
  $registration_id = $_SESSION['registration_id'];
  $visitor_id = $_SESSION['visitor_id'];
}

//$isBadgeMobileVerified = $_SESSION['isBadgeMobileVerified'];

// if($participant_Type =="" || $registration_id =="" || $visitor_id ==""){
//    echo '<script>alert("Something went wrong")</script>';
// }



/* ------------------------------ FETCH VISITOR DATA FROM GLOBAL START-------------------*/
if($participant_Type == "CONTR" && $action =="generateBadge" ){
    $sql = "SELECT * FROM gjepclivedatabase.globalExhibition  WHERE participant_Type ='$participant_Type' AND visitor_id='$visitor_id' AND  registration_id='$registration_id' and uniqueIdentifier ='$uniqueIdentifier' ";
} else{
    $sql = "SELECT * FROM gjepclivedatabase.globalExhibition  WHERE participant_Type ='$participant_Type' AND visitor_id='$visitor_id' AND  registration_id='$registration_id' ";
}


$result = $conn->query($sql);
$row = $result->fetch_assoc();
$uniqueIdentifier = $row['uniqueIdentifier'];
$name = filter($row['fname']);
$mobile = filter($row['mobile']);
$pan_no = filter($row['pan_no']);
$designation = $row['designation'];
$company = str_replace(array('&amp;','&AMP;'), '&', $row['company']);
$photo_url = str_replace("https://registration.gjepc.org/","",trim($row['photo_url']));

$category = filter($row['participant_Type']);
$agency_category = filter($row['agency_category']);
$committee = filter($row['committee']);

$event = filter($row['event']);
$plant_status = filter($row['days_allow']);
$location = "";

/*=============================UPDATE GLOBAL TABLE WHEN BADGE IS SUCCESSFULLY GENERATED===============================================*/
$update_date = date("Y-m-d H:i:s");
$updateGlobal = "UPDATE gjepclivedatabase.globalExhibition SET `isGenerated`='1', modified_date='$update_date'   WHERE uniqueIdentifier ='$uniqueIdentifier'  ";
$resultUpdateGlobal = $conn->query($updateGlobal);


/* ------------------------------ FETCH VISITOR DATA FROM GLOBAL END-------------------*/
/*--------------------------------SET CATEGORY------------------------*/
  $isWhite = "N";
  $textWhite = "Y";
  $rates_table = '<table border="1" cellpadding="5" align="center" cellspacing="0" style="border:1px solid #ddd; text-align:center; border-collapse:collapse; font-size:11px"> <thead> <tr> <th>Phase</th> <th>Dates</th> <th>Members</th> <th>Non-Members</th> </tr></thead> <tbody> <tr> <td>Phase 1</td><td>4th May 2022 - 10th Feb 2023</td><td>2000</td><td>2500</td></tr><tr> <td>Phase 2</td><td>11th Feb - 12th Mar 2023 </td><td>3500</td><td>4500</td></tr><tr> <td>Phase 3</td><td>13th - 20th Mar 2023</td><td>4000</td><td>5000</td></tr></tbody> </table>';

  $show_timing = '<table width="100%" cellpadding="5" cellspacing="0"> <tr> <td><strong>5<sup>th</sup> - 8<sup>th</sup> January 2023 </strong> </td><td>10:00 am to 6.30 pm</td></tr><tr> <td><strong>9<sup>th</sup> January 2023 </strong> </td><td>10:00 am to 6.00 pm</td></tr></table>';



  switch ($category) {
      case 'VIS':
            $category = "V";
            $category_name = "Trade Visitor";
            $color_code ="#900c3e";
            

            $rules = ' <ul style="font-size:10px; margin-bottom:0; padding-left:15px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
      break;
      case 'IGJME':
            $category = "MV";
            $category_name = "Machinery Trade Visitor";
            $color_code ="#feea3d";
            $textWhite = "N";
            $rules = '<ul style="font-size:10px; margin-bottom:0; padding-left:15px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
            $show_timing= '<table width="100%" cellpadding="5" cellspacing="0"> <tr> <td><strong>5<sup>th</sup> - 8<sup>th</sup> January 2023 </strong> </td><td>10:00 am to 6.30 pm</td></tr><tr> <td><strong>9<sup>th</sup> January 2023 </strong> </td><td>10:00 am to 6.00 pm</td></tr></table>';
      break;
      case 'INTL':
            $category = "OV";
            $category_name = "Overseas Visitor";
            $color_code ="#2e6d92";
            $rates_table = '';
             $rules = '<ul style="font-size:10px; margin-bottom:0; padding-left:15px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
      break;
      case 'EXH':
            $isWhite ="Y";
            $color_code ="#46b3a5";
            $rules = '<ul style="font-size:10px; margin-bottom:0; padding-left:15px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
            $show_timing= '<table width="100%" cellpadding="5" cellspacing="0"> <tr> <td><strong>3<sup>rd</sup> January 2023 </strong> </td><td>1:00 pm to 6.00 pm(only for exhibitors with 4 and above booths)</td></tr><tr> <td><strong>4<sup>th</sup> January 2023 </strong> </td><td>10:00 am to 6.00 pm</td></tr><tr> <td><strong>5<sup>th</sup>  January 2023 </strong> </td><td>7:00 am to 8.00 pm</td></tr><tr> <td><strong>6<sup>th</sup> - 9<sup>th</sup> January 2023 </strong> </td><td>8:00 am to 8.00 pm</td></tr></table>';
            if($designation == "CHAIRMAN" || $designation == "PROPRIETOR" || $designation =="DIRECTOR" || $designation == "PARTNER" || $designation == "CEO" || $designation == "MANAGING DIRECTOR" )
            {

                $category = "OE";
                $category_name = "Owner Exhibitor";
            }else{

                if($agency_category == "E" || $agency_category == "R"){
                    $category = "E";
                    $category_name = "Exhibitor";
                }else{
                    $category = "ES";
                    $category_name = "Exhibitor Services";
                    $show_timing= '<table width="100%" cellpadding="5" cellspacing="0"> <tr> <td><strong>3<sup>rd</sup> January 2023 </strong> </td><td>1:00 pm to 6.00 pm(only for exhibitors with 4 and above booths)</td></tr><tr> <td><strong>4<sup>th</sup> January 2023 </strong> </td><td>10:00 am to 6.00 pm</td></tr><tr> <td><strong>5<sup>th</sup>  January 2023 </strong> </td><td>7:00 am to 8.00 pm</td></tr><tr> <td><strong>6<sup>th</sup> - 9<sup>th</sup> January 2023 </strong> </td><td>8:00 am to 8.00 pm</td></tr></table>';
                }
               
            }

      break;

      case 'EXHM':
            $category = "ME";
            $category_name = "Machinery Exhibitor";
            $color_code ="#46b3a5";
            $rules = '<ul style="font-size:10px; margin-bottom:0; padding-left:15px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
            $show_timing= '<table width="100%" cellpadding="5" cellspacing="0"> <tr> <td><strong>3<sup>rd</sup> January 2023 </strong> </td><td>1:00 pm to 6.00 pm(only for exhibitors with 4 and above booths)</td></tr><tr> <td><strong>4<sup>th</sup> January 2023 </strong> </td><td>10:00 am to 6.00 pm</td></tr><tr> <td><strong>5<sup>th</sup> - 8<sup>th</sup> January 2023 </strong> </td><td>7:00 am to 8.00 pm</td></tr><tr> <td><strong>6<sup>th</sup> - 9<sup>th</sup> January 2023 </strong> </td><td>8:00 am to 8.00 pm</td></tr></table>';

      break;
      case 'CONTR':

            
            if($agency_category =="CM"){
            $isWhite ="Y";
            $color_code ="#1f295e";
            if($committee =="C"){
                $category = "C";
                $category_name = "CHAIRMAN";
            }elseif($committee =="VC"){
                $category = "VC";
                $category_name = "VICE CHAIRMAN";
            }elseif($committee =="CO"){
                $category = "CO";
                $category_name = "CONVENER";
            }elseif($committee =="CC"){
                $category = "CC";
                $category_name = "CO-CONVENER";
            }elseif($committee =="CM"){
                $category = "CM";
                $category_name = "COMMITTEE MEMBER";
            }elseif($committee =="COA"){
                $category = "COA";
                $category_name = "COMMITTEE OF ADMINISTRATION";
            }elseif($committee =="CE"){
                $category = "CE";
                $category_name = "CONVENER EVENT";
            }
            $show_timing = '<table cellpadding="0" cellspacing="0" align="center" style="background:#f2f2f2; padding:0 20px"> <tr> <td colspan="2" align="center">  <p style="margin-bottom:15px;font-size:14px;">Any time during the exhibition</p></td></tr></table>';
            $rules = '<ul style="font-size:10px; margin-bottom:0; padding-left:15px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
              
                  
            }elseif($agency_category =="O"){
               
                $category = "O";
                $category_name = "Organizer";
                $color_code ="#f6d68d"; 
                $rules = '<ul style="font-size:10px; margin-bottom:0; padding-left:15px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
                $show_timing = ' <table cellpadding="0" cellspacing="0" align="center" style="background:#f2f2f2; padding:0 20px"> <tr> <td colspan="2" align="center">  <p style="margin-bottom:15px;font-size:14px;">Any time during the exhibition</p></td></tr></table>';

            }elseif($agency_category =="OA"){
              $category = "OA";
              $category_name = "OFFICIAL AGENCY";
              $color_code ="#557d90";
              $rules = '<ul style="font-size:10px; margin-bottom:0; padding-left:15px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
              $show_timing = '<table cellpadding="0" cellspacing="0" align="center" style="background:#f2f2f2; padding:0 20px"> <tr> <td colspan="2" align="center">  <p style="margin-bottom:15px;font-size:14px;">Any time during the exhibition</p></td></tr></table>';
            }elseif($agency_category =="SV"){
              $category = "SV";
              $category_name = "SERVICE";
              $color_code ="#895637";
              $rules = '<ul style="font-size:10px; margin-bottom:0; padding-left:15px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
              $show_timing = '<table cellpadding="0" cellspacing="0" align="center" style="background:#f2f2f2; padding:0 20px"> <tr> <td colspan="2" align="center">  <p style="margin-bottom:15px;font-size:14px;">Any time during the exhibition</p></td></tr></table>';
            }elseif($agency_category =="G"){
              $category = "G";
              $category_name = "GUEST";
              $color_code ="#b69a3d";
              $rules = '<ul style="font-size:10px; margin-bottom:0; padding-left:15px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
            }elseif($agency_category =="VV"){
              $category = "VVIP";
              $category_name = "TRADE VISITOR";
              $color_code ="#900c3e";
              $rules = '<ul style="font-size:10px; margin-bottom:0; padding-left:15px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
            }elseif($agency_category =="VIP"){

              $category = "VIP";
              $category_name = "TRADE VISITOR";
              $color_code ="#900c3e";
              $rules = '<ul style="font-size:10px; margin-bottom:0; padding-left:15px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
            }elseif($agency_category =="P"){
              
              $category = "P";
              $category_name = "PRESS";
              $color_code ="#998257";
              $rules = '<ul style="font-size:10px; margin-bottom:0; padding-left:15px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';

            }elseif($agency_category =="S"){
              $isWhite ="Y";
              $category = "S";
              $category_name = "STUDENT";
              $color_code ="#f765a3";
              $rules = '<ul style="font-size:10px; margin-bottom:0; padding-left:15px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
              
            }elseif($agency_category =="SE"){
              $isWhite ="Y";
              $category = "SE";
              $category_name = "SECURITY";
              $color_code ="#000";
              $rules = '<ul style="font-size:10px; margin-bottom:0; padding-left:15px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
               $show_timing = '<table cellpadding="0" cellspacing="0" align="center" style="background:#f2f2f2; padding:0 20px"> <tr> <td colspan="2" align="center">  <p style="margin-bottom:15px;font-size:14px;">Any time during the exhibition</p></td></tr></table>';
              
            }elseif($agency_category =="ED"){
              $category = "ED";
              $category_name = "Executive Director";
              $color_code ="#1f295e";
              $rules = '<ul style="font-size:10px; margin-bottom:0; padding-left:15px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
               $show_timing = '<table cellpadding="0" cellspacing="0" align="center" style="background:#f2f2f2; padding:0 20px"> <tr> <td colspan="2" align="center">  <p style="margin-bottom:15px;font-size:14px;">Any time during the exhibition</p></td></tr></table>';
            }
            

      break;
      default:
            $category_name = "";
            $color_code ="";
            $rules = '';
      break;
    }

  // echo $show_timing;exit;

/*-------------------------------- GENERATE QR CODE START-----------------------------*/

//data to be stored in qr
    $codeContents = "";
    $codeContents .= trim($uniqueIdentifier);
    $codeContents .= " | ";
  
    $codeContents .= trim($category);
    $codeContents .= " | ";

    $codeContents .= trim($name);
    $codeContents .= " | ";
   
    $codeContents .= trim($company);
    $codeContents .= " | ";
  
    $codeContents .= trim($designation);
    $codeContents .= " | ";
  
//file path
$file = "images/badges/qr-code/".$uniqueIdentifier.".png";
  
//other parameters
$ecc = 'H';
$pixel_size = 20;
$frame_size = 5;
  
// Generates QR Code and Save as PNG
QRcode::png($codeContents, $file, $ecc, $pixel_size, $frame_size);

/*-------------------------------- GENERATE QR CODE END-------------------------------*/

$no_entry_title = "";

if($category=="SV"){
    $no_entry_title =' <div style="text-align:center;position:absolute; bottom:75px;width:100%">
              <p style="font-size: 18px;"><strong>No Entry Into Any Exhibition Hall</strong></p>
              </div>';
}

if($isWhite =="Y"){
    $color_text="#FFF";
}else{
    $color_text="#000";
}
if($textWhite =="Y"){
    $color_text="#FFF";
}else{
    $color_text="#000";
}

$one_earth = '';
if($plant_status =="Y"){
    $one_earth = '<td valign="top" style="width:50%;text-align:center" > <p style="font-size:10px"><strong>Proud Contributor</strong></p><p style="font-size:10px; margin-bottom:0;">AN <strong> IIJS </strong> INITIATIVE</p><img src="images/signature23_badge_assets/one-earth.jpg" style="width:50px;"> </td>';
}else{
    $one_earth = '';
}

if($category =="ME" ){
    $show_logo = "images/signature23_badge_assets/igjme-logo.png";
}else{
    $show_logo = "images/signature23_badge_assets/logo.png";
}



                    
$html = '<!doctype html>
<html style="margin:0; padding:0; box-sizing:border-box;">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>

  <body style="margin:0; padding:0; ">
    
    <table cellpadding="0" cellspacing="0" width="100%" style="font-size:12px; font-family:Arial, Helvetica, sans-serif;">

      <tbody style="height:100%">
        
        <tr>
          <td style="width: 50%;">
            <div style="border:5px solid '.$color_code.';height:551px;overflow:hidden; position:relative">
              <table cellpadding="8" cellspacing="0" style="width: 100%;">
                <tbody>
                  <tr style="background:#f1f1f1; height: 50px;">
                    <td align="left">
                      <img src="'.$show_logo.'" style="max-width: 200px;">
                    </td>
                    <td align="right">
                      <img src="https://gjepc.org/iijs-premiere/assets/images/gjepc_logo.png" style="max-width: 85px;">
                    </td>
                  </tr>
                  <tr>
                    <td align="center">
                        <img src="'.$photo_url.'" style="max-height:160px; max-width: auto; display:table; margin:0 auto;" alt="">
                    </td>
                    <td>
                      <img src="'.$file.'" style="max-height:128px; max-width: auto;" alt="">
                    </td>
                  </tr>
                  <tr>
                    <td style="width:50%;">
                        <h3 style="font-weight: bold; letter-spacing: 1px; font-size: 20px; color: #000;">
                        '.$name.'</h3>
                        <p style="font-size: 20px; font-weight: bold; text-transform:uppercase;">'.$company.'</p>
                        <p style="font-size: 13px; font-weight: bold; text-transform:uppercase;">'.$designation.'</p>
                        <h3 style="font-size: 13px;">'.$uniqueIdentifier.'</h3>
                        
                    </td>';
                  // ONE EARTH INITIATIVE  TABLE
                  $html .= $one_earth; 

                  $html .='</tr>
                  <tr>
                    <td colspan="2" align="center">
                    <div style="background:'.$color_code.'; padding:10px 0;  color: '.$color_text.'; width:100%; left:0; position:absolute; bottom:0;">
                      <strong style="font-size: 28px;">'.$category.'</strong><br>
                      <p style="font-size: 28px; margin: 0; font-size: 20px; text-transform:uppercase;">'.$category_name.'</p>
                    </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </td>
          <td style="width: 50%;">
            <div style="border:5px solid '.$color_code.'; height:551px; position:relative">
              <div style="width:100%; position:absolute; top:50%; transform:translateY(-50%)">
                <table cellpadding="8" cellspacing="0" style="width: 100%;">
                  <tbody>
                    <tr>
                      <td style="text-align:center;"> 
                        <img src="'.$show_logo.'" style="width: 250px;">
                      </td>
                    </tr>
                    <tr>
                      <td style="text-align:center;">
                        <div style="margin:10px 0">
                          <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/01.png" style="width: 25px;height: auto;margin-left:5px" alt="">
                          <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/02.png" style="width: 25px;height: auto;margin-left:5px" alt="">
                          <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/03.png" style="width: 25px;height: auto;margin-left:5px" alt="">
                          <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/04.png" style="width: 25px;height: auto;margin-left:5px" alt="">
                          <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/05.png" style="width: 25px;height: auto;margin-left:5px" alt="">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td align="center" style="background: '.$color_code.'; color:'.$color_text.'">
                        <p style="font-size: 15px;margin: 0px;"><b>Toll Free Number: 1800-103-4353</b></p>
                        <p style="font-size: 15px;margin: 0px;"><b>Missed call Number: +91-7208048100</b></p>
                      </td>
                    </tr>
                    <tr>
                      <td style="text-align:center">
                        <div style="margin-top:10px;">
                          <table cellpadding="0" cellspacing="0" align="center" style="background:#f2f2f2; padding:10px 20px">
                            <tr>
                              <td colspan="2" align="center">
                                <h3 style="font-size:14px; margin-bottom:10px">ENTRY INTO EXHIBITION HALL</h3>';
                                $html .= $show_timing;
                                $html .= '</td>
                            </tr>
                          </table>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td style="text-align:center">
                        <img src="https://gjepc.org/iijs-premiere/assets/images/gjepc_logo.png" style="max-width: 200px;">
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
          </td>
        </tr>
        <tr>
          <td align="center" style="width: 50%;">
            <div style="border:5px solid '.$color_code.'; height:551px; position:relative;">
              <div style="position:absolute; top:50%; left:10px; right:10px; transform:translateY(-50%)">
                <img src="https://gjepc.org/assets/images/gold_star.png"/>
                <h3>BLOCK THE DATES</h3>
                <img src="images/signature23_badge_assets/iijs-tritiya.jpg" style="width:150px; margin-bottom:15px;">';
                 // Rates Table
                $html .= $rates_table;
                $html .='<h3 style="color:#a89c5d; font-size: 18px;">GET THE APP</h3>
                <p style="color:#a89c5d">Scan the below QR code to download the GJEPC App</p>
                <table width="100%" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center">
                      <div style="margin-bottom:5px">
                        <img src="https://gjepc.org/assets/images/android.png">
                      </div>
                      <div>
                        <img src="https://gjepc.org/assets/images/ios.png">
                      </div>
                    </td>
                    <td><img src="https://gjepc.org/assets/images/qr.png" width="100px"/></td>
                  </tr>
                </table>
              </div>
            </div>
          </td>
          <td style="width: 50%;">
            <div style="border:5px solid '.$color_code.'; height:551px">
              <table width="100%" cellspacing="0" cellpadding="10">
                <tr>
                  <td>
                    <h3 style="font-size: 18px;color: #a89c5d; margin-bottom:0px;padding:0px;">Rules & Regulations</h3>
                  </td>
                  <td align="right"><img src="images/signature23_badge_assets/rules_qr.jpeg" style="width:70px;"/></td>
                </tr>
                <tr>
                  <td colspan="2">';
                    $html .=$rules;
                    $html .= '</td>
                </tr>
              </table>
            </div>
          </td>
        </tr> 
      </tbody>
    </table>
  </body>
</html>';
 // echo $html;exit;
$filename = $uniqueIdentifier;
ob_get_clean();
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new DOMPDF($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream($filename, array("Attachment" => 1));
file_put_contents($_SERVER['DOCUMENT_ROOT'].'/images/badges/'.$filename.'.pdf', $dompdf->output()); 
$filePath = $_SERVER['DOCUMENT_ROOT'].'/images/badges/'.$filename.'.pdf';
 