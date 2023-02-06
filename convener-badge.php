<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('db.inc.php');
include('functions.php');
require_once('dompdf/autoload.inc.php');
use Dompdf\Dompdf;
use Dompdf\Options;
define("DOMPDF_ENABLE_REMOTE", false);
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
          <td style="width: 50%;">
            <div style="border:5px solid #013247;height:551px;overflow:hidden;">
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
                        <img src="images/portrait-dummy.jpg" style="max-height:160px; max-width: auto; display:table; margin:0 auto;" alt="">
                    </td>
                    <td>
                      <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/qr-code.png" style="max-height:128px; max-width: auto;" alt="">
                    </td>
                  </tr>
                  <tr>
                    <td style="width:50%;">
                        <h3 style="font-weight: bold; letter-spacing: 1px; font-size: 16px; color: #000;">
                          ATHUL EASWARAN PARAMESWARAN</h3>
                        <p style="font-size: 14px; font-weight: bold;">Ape Brothers Sisters & Sons Electronics Pvt. Ltd.</p>
                        <p style="font-size: 13px; font-weight: bold;">Chairman</p>
                        <p style="font-size: 13px; font-weight: bold;">Mumbai</p>
                    </td>
                    <td style="width:50%;vertical-align: baseline;">
                      <h3 style="font-size: 13px;">000000001</h3>
                      
                      <p style="font-size: 13px;"><b>Vaccination status<b></p>
                      <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/heart.jpg" style="width:40px;">
                    </td>
                  </tr>
                  
                  <tr>
                      
                      <td colspan="2" align="center" >
                      <div style="background:#013247; padding:10px 0;  color: #fff; margin:21px -8px 0 -8px">
                      <strong style="font-size: 30px;">CO</strong><br>
                      <p style="font-size: 28px; margin: 0; font-size: 20px; ">CONVENER</p>
                      </div>
                      
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </td>
          <td style="width: 50%;" valign="middle">
          <div style=" border:5px solid #013247; height:551px">
              <table cellpadding="8" cellspacing="0" style="width: 100%;">
                <tbody>
                  <tr>
                    <td style="text-align:center;"> 
                      <img src="https://gjepc.org/iijs-premiere/assets/images/iijs_logo.png" style="width: 130px;">
                    </td>
                  </tr>
                  <tr>
                    <td style="text-align:center;">
                      <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/01.png" style="width: 25px;height: auto;margin-left:5px" alt="">
                      <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/02.png" style="width: 25px;height: auto;margin-left:5px" alt="">
                      <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/03.png" style="width: 25px;height: auto;margin-left:5px" alt="">
                      <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/04.png" style="width: 25px;height: auto;margin-left:5px" alt="">
                      <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/05.png" style="width: 25px;height: auto;margin-left:5px" alt="">
                    </td>
                  </tr>
                  <tr>
                    <td  align="center" style="background: #013247; color:#fff">
                      <p style="font-size: 15px;margin: 0px;"><b>Toll Free Number: 1800-103-4353</b></p>
                      <p style="font-size: 15px;margin: 0px;"><b>Missed call Number: +91-7208048100</b></p>
                    </td>
                  </tr>
                  <tr>
                    <td style="text-align:center">
                      <h3 style="font-size:16px;margin: 0px;padding:0; line-height:22px">TWO COVID VACCINE IS MANDATORY <br> TO VISIT THE SHOW</h3>
                    </td>
                  </tr>
                  <tr>
                    

                    <td style="text-align:center">
                      <p style="margin:0"><strong>SHOW TIMINGS - </strong>10 am - 07 pm</p> <br/>
                      <table cellpadding="8" cellspacing="0" align="center" style="background:#f2f2f2; padding:10px 15px">

                        <tr>
                          <td align="center">
                            <h3 style="font-size:16px;margin: 0 0 10px 0;">ENTRY INTO EXHIBITION HALL</h3>
                            Any time during the exhibition
                          </td>
                        </tr>
                      </table>
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

          <td align="center" style="width: 50%;" valign="middle">

          <div style=" border:5px solid #013247; height:551px">

              <img src="https://gjepc.org/assets/images/gold_star.png"/>
              <h3>BLOCK THE DATES</h3>
              <img src="images/SHOWLOGOS.jpg" style="width:100%">
              
              <p style="margin:0;"><b>TWO COVID VACCINE IS MANDATORY TO VISIT THE SHOW</b></p>

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

          <td style="width: 50%;">

            <div style=" border:5px solid #013247; height:551px">

              <table width="100%" cellspacing="0" cellpadding="10">

                <tr>
                  <td>
                    <h3 style="font-size: 18px;color: #a89c5d; margin-bottom:0px;padding:0px;">Rules & Regulations</h3>
                  </td>
                  <td align="right"><img src="images/rules_qr.jpeg" style="width:70px;"/></td>
                </tr>

                <tr>

                  <td colspan="2">

                    <ul style="font-size:10px; margin-bottom:0; padding-left:15px">

                      <li>The badge holder must follow the rules & regulations & security procedures set by the GJEPC to enter the exhibition hall. </li>

                      <li>GJEPC reserves the right to postpone or cancel or transfer or change date, time, and the location of the Exhibition, and shall have no claim whatsoever in this regard.</li>

                      <li>This card must always be worn around the neck and clearly displayed.</li>

                      <li>GJEPC reserves the right to refuse admission/suspend entry to the show of any visitors, exhibitors or their representative and any categories of badge for security reasons and/or creating disturbance or discomfort of any kind to the show, also GJEPC reserves the right to admit any pre-registered visitor as per its discretion, even if the visitors badges have been issued and paid for the show.</li>

                      <li>Person under the age of 18 is NOT allowed to enter the show nor be the booth attendant/technicians/workers.</li>

                      <li>Visitors fees once submitted will be non-refundable/not transferable under any circumstances. Reasons like change of employment, transfer in service, cancellation of visit etc., will not be entertained.</li>

                      <li>Visitor badge which was blocked due to breach of security norms will not be allowed to visit GJEPC any shows in the future.</li>

                      <li>For security reasons, luggage should be deposited at the baggage counter located near Registration Hall.</li>

                      <li>In case the visitor misplaces/damages badges duplicate badge charges will be Rs. 600 inclusive of GST</li>

                      <li>The Visitor registration charges mentioned includes the charges for machinery Section also.</li>

                      <li>The above-mentioned charges are inclusive of GST and the invoice will be issued after the show to the applicant company/firm as provided in the application.</li>

                      <li>Visitor should abide by the terms and conditions applicable for registration of National visitors set by "The Gem & Jewellery Export Promotion Council (GJEPC)". </li>

                      <li>Photography/Videography inside the exhibition is strictly prohibited. Council officials reserve the right to confiscate the camera/phone.</li>

                    </ul>

                  </td>

                </tr>
              
              </table>

            </div>
          
          </td>
        </tr> 
    
      </tbody>
        
    </table>
    
  </body>

</html>';

$filename = "454445454";
ob_get_clean();
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new DOMPDF($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream($filename, array("Attachment" => 1));
file_put_contents($_SERVER['DOCUMENT_ROOT'].'/images/employee_directory/600714127/photo/'.$filename.'.pdf', $dompdf->output()); 

$filePath = $_SERVER['DOCUMENT_ROOT'].'/images/employee_directory/600714127/photo/'.$filename.'.pdf';
 