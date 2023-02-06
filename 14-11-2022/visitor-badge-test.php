<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('db.inc.php');
include('functions.php');
include 'phpqrcode/qrlib.php';
require_once('dompdf/autoload.inc.php');

use Dompdf\Dompdf;
use Dompdf\Options;
define("DOMPDF_ENABLE_REMOTE", false);

// print_r($_SESSION);exit;
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





if($participant_Type =="" || $registration_id =="" || $visitor_id ==""){
   echo '<script>alert("Something went wrong")</script>';
}



/* ------------------------------ FETCH VISITOR DATA FROM GLOBAL START-------------------*/
$sql = "SELECT * FROM gjepclivedatabase.globalExhibition  WHERE participant_Type ='$participant_Type' AND visitor_id='$visitor_id' AND  registration_id='$registration_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$uniqueIdentifier = $row['uniqueIdentifier'];
$name = filter($row['fname']);
$mobile = filter($row['mobile']);
$pan_no = filter($row['pan_no']);
$designation = $row['designation'];
$company = $row['company'];
$photo_url = str_replace("https://registration.gjepc.org/","",trim($row['photo_url']));
$category = filter($row['participant_Type']);
$agency_category = filter($row['agency_category']);
$committee = filter($row['committee']);

$event = filter($row['event']);
$location = "";

/*=============================UPDATE GLOBAL TABLE WHEN BADGE IS SUCCESSFULLY GENERATED===============================================*/
$update_date = date("Y-m-d H:i:s");
$updateGlobal = "UPDATE gjepclivedatabase.globalExhibition SET `isGenerated`='1', modified_date='$update_date'   WHERE uniqueIdentifier ='$uniqueIdentifier'  ";
$resultUpdateGlobal = $conn->query($updateGlobal);

/* ------------------------------ FETCH VISITOR DATA FROM GLOBAL END-------------------*/
/*--------------------------------SET CATEGORY------------------------*/
  $isWhite = "N";
  $show_timing= '<p style="margin:0 0 10px 0"><strong>SHOW TIMINGS - </strong>10 am - 07 pm</p><br/> <table cellpadding="8" cellspacing="0" align="center" style="background:#f2f2f2; padding:10px 15px; "> <tr> <td align="center" colspan="2"> <h3 style="font-size:16px;margin: 0;">ENTRY INTO EXHIBITION HALL</h3> </td></tr><tr> <td><strong>4<sup>th</sup> - 7<sup>th</sup> August 2022</strong></td><td>10 am - 6.30 pm</td></tr><tr> <td><strong>8<sup>th</sup> August 2022</strong></td><td>10 am - 6.00 pm</td></tr></table>';
  switch ($category) {
      case 'VIS':
            $category = "V";
            $category_name = "Trade Visitor";
            $color_code ="#BFCDCA";
            $rules = '<ul style="font-size:10px; margin-bottom:0; padding:0 20px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
      break;
      case 'IGJME':
            $category = "MV";
            $category_name = "Machinery Trade Visitor";
            $color_code ="#FEEA3D";
             $rules = ' <ul style="font-size:10px; margin-bottom:0; padding: 0 20px"> <li>The badge holder must follow and adhere the rules & regulations & security procedures set by GJEPC to enter the exhibition halls.</li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claims whatsoever in this regard.</li><li>Visitor needs to display the physical badge all the times during the exhibition as and when requested by authorities.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any other categories of badges for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitor&apos;s badges have been issued and paid for the show.</li><li>Person under the age of 18 years and above 65 years are not permitted to enter the show nor be the booth attendant/technicians/workers.</li><li>In case if any visitor(s) does not follow the protocols as may be prescribed by GJEPC considering the safety and security norms, then the visitor badge of the visitor will be blocked, and the said visitor will not be allowed to visit any shows of GJEPC in the future.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)".</li><li>Only Jewellery and Machinery businesspeople can register, associate, non-jewellers are not allowed.</li><li>Visitor Badge will not be issued to the Participant Companies at IIJS Premiere Show 2022.</li><li>If your company becomes exhibitor for any show, then your visitor registration for that show will get automatically cancelled.</li><li>Photography/Videography inside the exhibition is strictly prohibited. Council&apos;s officials reserve the right to confiscate the camera/phone and further, if deemed fit cancel your registration. </li></ul>';
      break;
      case 'INTL':
            $category = "OV";
            $category_name = "Overseas Visitor";
            $color_code ="#287194";
             $rules = '<ul style="font-size:10px; margin-bottom:0; padding: 0 20px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitor&apos;s badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC&apos;s any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>Visitor should abide by the terms and conditions applicable for registration of international visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)".</li><li>Photography/Videography inside the exhibition is strictly prohibited. GJEPC&apos;s officials reserve the right to confiscate the camera/phone.</li></ul>';
      break;
      case 'EXH':

            if($designation == "CHAIRMAN" || $designation == "PROPRIETOR" || $designation =="DIRECTOR" || $designation == "PARTNER" || $designation == "CEO" || $designation == "MANAGING DIRECTOR" )
            {

                $category = "OE";
                $category_name = "Owner Exhibitor";
            }else{
                $category = "E";
                $category_name = "Exhibitor";
            }
            
           
            $color_code ="#19938A";
            $rules = '<ul style="font-size:10px; margin-bottom:0; padding:0 20px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall.</li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitor&apos;s badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Exhibitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC&apos;s any shows in the future.</li><li>Photography/Videography inside the exhibition is strictly prohibited. Council&apos;s officials reserve the right to confiscate the camera/phone.</li></ul>';
            $show_timing= '<p style="margin:0 0 10px 0"><strong>SHOW TIMINGS - </strong>10 am - 07 pm</p><br/> <table cellpadding="8" cellspacing="0" align="center" style="background:#f2f2f2; padding:10px 15px"> <tr> <td colspan="2" align="center"> <h3 style="font-size:16px;margin: 0;">ENTRY INTO EXHIBITION HALL</h3> </td></tr><tr> <td><strong>3<sup>rd</sup> August 2022</strong></td><td>10 am - 06 pm</td></tr><tr> <td><strong>4<sup>th</sup> August 2022</strong></td><td>07 am - 08 pm</td></tr><tr> <td><strong>5<sup>th</sup> - 8<sup>th</sup> August 2022</strong></td><td>08 am - 08 pm</td></tr></table>';

      break;
      case 'EXHM':
            $category = "ME";
            $category_name = "Machinery Exhibitor";
            $color_code ="#FEEA3D";
            $rules = '<ul style="font-size:10px; margin-bottom:0; padding:0 20px"> <li style="margin-bottom:4px">The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall.</li><li style="margin-bottom:4px">GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li style="margin-bottom:4px">This card must always be worn around the neck and clearly displayed.</li><li style="margin-bottom:4px">GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitor&apos;s badges have been issued and paid for the show.</li><li style="margin-bottom:4px">Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li style="margin-bottom:4px">Exhibitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC&apos;s any shows in the future.</li><li>Photography/Videography inside the exhibition is strictly prohibited. Council&apos;s officials reserve the right to confiscate the camera/phone.</li></ul>';
            $show_timing= '<p style="margin:0 0 10px 0"><strong>SHOW TIMINGS - </strong>10 am - 07 pm</p><br/> <table cellpadding="8" cellspacing="0" align="center" style="background:#f2f2f2; padding:10px 15px"> <tr> <td colspan="2" align="center"> <h3 style="font-size:16px;margin: 0;">ENTRY INTO EXHIBITION HALL</h3> </td></tr><tr> <td><strong>3<sup>rd</sup> August 2022</strong></td><td>10 am - 06 pm</td></tr><tr> <td><strong>4<sup>th</sup> August 2022</strong></td><td>07 am - 08 pm</td></tr><tr> <td><strong>5<sup>th</sup> - 8<sup>th</sup> August 2022</strong></td><td>08 am - 08 pm</td></tr></table>';

      break;
      case 'CONTR':

            $category = "ME";
             if($agency_category =="CM"){
                $isWhite ="Y";
             $show_timing = ' <table cellpadding="8" cellspacing="0" align="center" style="background:#f2f2f2; padding:10px 15px; "> <tr> <td align="center" colspan="2"> <h3 style="font-size:16px;margin: 0;">ENTRY INTO EXHIBITION HALL</h3> </td></tr><tr> <td align="center" colspan="2"> <p style="margin:0 0 4px 0">Any time during the exhibition</p></td></tr></table>';
              if($committee =="C"){
                $category = "C";
                $category_name = "CHAIRMAN";
                $color_code ="#013247";
                $rules = ' <ul style="font-size:10px; margin-bottom:0; padding:0 20px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
              }elseif($committee =="VC"){
                $category = "VC";
                $category_name = "VICE CHAIRMAN";
                $color_code ="#013247";
                
                $rules = '<ul style="font-size:10px; margin-bottom:0; padding:0 20px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
              }elseif($committee =="CO"){
                $category = "CO";
                $category_name = "CONVENER";
                $color_code ="#013247";
                $rules = '<ul style="font-size:10px; margin-bottom:0; padding:0 20px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
              }elseif($committee =="CC"){
                $category = "CC";
                $category_name = "CO-CONVENER";
                $color_code ="#013247";
                $rules = ' <ul style="font-size:10px; margin-bottom:0; padding:0 20px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
              }elseif($committee =="CM"){
                $category = "CM";
                $category_name = "COMMITTEE MEMBER";
                $color_code ="#013247";
                $rules = '<ul style="font-size:10px; margin-bottom:0; padding:0 20px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
              }elseif($committee =="COA"){
                $category = "COA";
                $category_name = "COMMITTEE OF ADMINISTRATION";
                $color_code ="#013247";
                $rules = '<ul style="font-size:10px; margin-bottom:0; padding:0 20px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
              }
            }elseif($agency_category =="O"){
               
                $category = "O";
                $category_name = "Organizer";
                $color_code ="#5C6E71"; 
                $rules = '<ul style="font-size:10px; margin-bottom:0; padding:0 20px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
                $show_timing = ' <table cellpadding="8" cellspacing="0" align="center" style="background:#f2f2f2; padding:10px 15px; "> <tr> <td align="center" colspan="2"> <h3 style="font-size:16px;margin: 0;">ENTRY INTO EXHIBITION HALL</h3> </td></tr><tr> <td align="center" colspan="2"> <p style="margin:0 0 4px 0">Any time during the exhibition</p></td></tr></table>';

            }elseif($agency_category =="OA"){
              $category = "OA";
              $category_name = "OFFICIAL AGENCY";
              $color_code ="#D4B5A6";
              $rules = '<ul style="font-size:10px; margin-bottom:0; padding:0 20px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
              $show_timing = ' <table cellpadding="8" cellspacing="0" align="center" style="background:#f2f2f2; padding:10px 15px; "> <tr> <td align="center" colspan="2"> <h3 style="font-size:16px;margin: 0;">ENTRY INTO EXHIBITION HALL</h3> </td></tr><tr> <td align="center" colspan="2"> <p style="margin:0 0 4px 0">Any time during the exhibition</p></td></tr></table>';
            }elseif($agency_category =="SV"){
              $category = "SV";
              $category_name = "SERVICE";
              $color_code ="#ea80fc";
              $rules = '<ul style="font-size: 10px; margin-bottom: 0; padding: 0 20px;"> <li>This badge is not allowed to enter any exhibition hall</li><li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC </li><li>This card must always be worn around the neck and clearly displayed.</li><li> GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors, or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show. </li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Badge holder who was blocked due to a breach of security norms will not be allowed to visit GJEPC’s any shows in the future.</li><li>Photography/Videography inside the exhibition is strictly prohibited. GJEPC’s officials reserve the right to confiscate the camera/phone.</li></ul>';
              $show_timing = '<div style="margin-top:150px; text-align:center ">
                <p style="font-size:20px text-align: center; margin:20px  0;"><strong>No Entry Into Any Exhibition Hall</strong></p>
              </div>';
            }elseif($agency_category =="G"){
              $category = "G";
              $category_name = "GUEST";
              $color_code ="#D3D4CE";
              $rules = '<ul style="font-size:10px; margin-bottom:0; padding: 0 20px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
            }elseif($agency_category =="VV"){
              $category = "VVIP";
              $category_name = "TRADE VISITOR";
              $color_code ="#BFCDCA";
              $rules = '<ul style="font-size:10px; margin-bottom:0; padding: 0 20px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';

      

            

            }elseif($agency_category =="VIP"){

              $category = "VIP";
              $category_name = "TRADE VISITOR";
              $color_code ="#BFCDCA";
              $rules = '<ul style="font-size:10px; margin-bottom:0; padding: 0 20px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';
            }elseif($agency_category =="P"){
              
              $category = "P";
              $category_name = "PRESS";
              $color_code ="#19938A";
              $rules = '<ul style="font-size:10px; margin-bottom:0; padding-left:15px"> <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li><li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li><li>This card must always be worn around the neck and clearly displayed.</li><li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li><li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li><li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li><li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li><li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li><li>In case the visitor misplaces/damages badges duplicate badge charges will be Rs. 600 inclusive of GST</li><li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li><li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li><li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li><li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li></ul>';

            }elseif($agency_category =="S"){
              $category = "S";
              $category_name = "STUDENT";
              $color_code ="#19938A";
              $rules = '';
              
            }elseif($agency_category =="ED"){
              $category = "ED";
              $category_name = "Executive Director";
              $color_code ="#19938A";
              $rules = '';
            }
            

      break;
      default:
            $category_name = "XX";
            $color_code ="#FEEA3D";
            $rules = 'XX';
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


$title_iijs = "";

if($category !=="SV"){
    $title_iijs =' <p style="font-size:20px text-align: center; margin:20px  0;"><strong> IIJS WHERE BUSINESS HAPPENS</strong></p>';
}

$icons_images ="";
if($category !=="SV"){
 $icons_images ='<table cellpadding="8" cellspacing="0" style="width: 100%;">
                      <tbody>
                       
                        <tr>
                          <td colspan="2" style="text-align:center;">
                            <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/01.png" style="width: 25px;height: auto;margin-left:5px" alt="">
                            <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/02.png" style="width: 25px;height: auto;margin-left:5px" alt="">
                            <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/03.png" style="width: 25px;height: auto;margin-left:5px" alt="">
                            <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/04.png" style="width: 25px;height: auto;margin-left:5px" alt="">
                            <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/05.png" style="width: 25px;height: auto;margin-left:5px" alt="">
                          </td>
                        </tr>      
                       
                      </tbody>
                    </table>';
}
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
// echo $isWhite."_".$color_text;exit;
$html = '

<!doctype html>
<html style="margin:0; padding:0; box-sizing:border-box;">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>

  <body style="margin:0; padding:0; ">
    
    <table cellpadding="0" cellspacing="0" width="100%" style="font-size:12px; font-family:Arial, Helvetica, sans-serif;">

      <tbody style="height:100%">
        
        <tr>
          <td style="width: 50%; border:5px solid '.$color_code.';height:553.7px;overflow:hidden;" valign="top">
            <div style="height:553.7px; position:relative">
              <table cellpadding="8" cellspacing="0" style="width: 100%;">
                <tbody>
                  <tr style="background:#f2f2f2; height: 50px;">
                    <td align="left">
                      <img src="https://gjepc.org/iijs-premiere/assets/images/iijs_logo.png" style="max-width: 100px;">
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
                        <h3 style="font-weight: bold; letter-spacing: 1px; font-size: 16px; color: #000;">
                          '.strtoupper($name).'</h3>
                        <p style="font-size: 14px; font-weight: bold;">'.strtoupper($company).'</p>
                        <p style="font-size: 13px; font-weight: bold;">'.strtoupper($designation).'</p>
                        <p style="font-size: 13px; font-weight: bold;">'.strtoupper($location).'</p>
                    </td>
                    <td style="width:50%;vertical-align: baseline;">
                      <h3 style="font-size: 13px;">'.strtoupper($uniqueIdentifier).'</h3>
                      
                      <p style="font-size: 13px;"><b>Vaccination status<b></p>
                      <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/heart.jpg" style="width:40px;">
                    </td>
                  </tr>
                  
                  
                </tbody>
              </table>
              '.$no_entry_title.'

             
                <div style="background: '.$color_code.'; width:100%; color:'.$color_text.'; padding:10px 0; position:absolute; bottom:0; text-align:center">
                  <strong style="font-size: 30px;">'.strtoupper($category).'</strong><br>
                  <p style="font-size: 28px; margin: 0; font-size: 20px; ">'.strtoupper($category_name).'</p>
                </div>
                
             

            </div>
          </td>
          <td style="width: 50%; height:553.7px; border:5px solid '.$color_code.';">
            <div style="height:553.7px; position:relative">

              <table cellpadding="8" cellspacing="0" style="width: 100%;">
                <tr style="background:#f2f2f2; height: 50px;">
                  <td align="left">
                    <img src="https://gjepc.org/iijs-premiere/assets/images/iijs_logo.png" style="max-width: 100px;">
                  </td>
                  <td align="right">
                    <img src="https://gjepc.org/iijs-premiere/assets/images/gjepc_logo.png" style="max-width: 85px;">
                  </td>
                </tr>
              </table>

              <div style="margin-top:30px; text-align:center ">

            

              '.$show_timing.'
   
                     '.$title_iijs.'
                     '.$icons_images.'

                      
              </div>

              
             

              <div style="background: '.$color_code.'; width:100%; color:'.$color_text.'; padding:22.5px 0; position:absolute; bottom:0; text-align:center">
                <p style="font-size: 15px;margin: 0px;"><b>Toll Free Number: 1800-103-4353</b></p>
                <p style="font-size: 15px;margin: 0px;"><b>Missed call Number: +91-7208048100</b></p>
              </div>


            </div>
          </td>
        </tr>
        
        <tr>

          <td align="center" style="width: 50%; border:5px solid '.$color_code.'; height:553.7px; overflow:hidden" valign="middle">

            <div style="overflow:hidden;">
              <img src="https://gjepc.org/assets/images/gold_star.png"/>
              <h3>BLOCK THE DATES</h3>
              <img src="images/SHOWLOGOS.jpg" style="width:350px; margin:0 auto; display:table; text-align:center">
              
              

              <h3 style="color:#a89c5d; font-size: 18px;">GET THE APP</h3>

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

          </td>

          <td style="width: 50%; border:5px solid '.$color_code.'; height:549px" valign="top">

            <div>

              <table width="100%" cellspacing="0" cellpadding="10">

                <tr>
                  <td>
                    <h3 style="font-size: 18px;color: #a89c5d; margin-bottom:0px;padding:0px;">Rules & Regulations</h3>
                  </td>
                  <td align="right"><img src="images/rules_qr.jpeg" style="width:70px;">
                  <p style="font-size:10px; display:table; margin: 0 0 0 auto; text-align:center">Scan QR Code</p></td>
                </tr>

                
              
              </table>
              '.$rules.'

            </div>
          
          </td>

        </tr> 
    
      </tbody>
        
    </table>
    
  </body>

</html>';

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
 