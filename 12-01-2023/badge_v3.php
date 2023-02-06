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
<html>
  <head>
    <meta charset="utf-8">
    
    <title></title>
  </head>
  <body>
  
      
      <table cellpadding="20" style="margin-left: -46px;margin-top: -48px;margin-bottom: -100px;font-size:12px; font-family:Arial, Helvetica, sans-serif; width:113.1%;">
        <tbody>
          <tr>
            <td style="width: 50%!important;border-right:1px solid #000;border-bottom:1px solid #000;">
              <table style="width: 100%;">
                <tbody>
                  <tr>
                    <td  >
                      <div style="
    background: gray;
    height: 86px;
    width: 120.3%;
    margin-left: -23px;
    
    margin-top: -22px;padding:10px 10px 10px 10px">
    <img src="https://gjepc.org/iijs-premiere/assets/images/iijs_logo.png" style="max-width: 120px;margin-right: 10px; text-align:left">
   
                        
                      </div>
                     
                    </td>
                    <td  >
                      <div style="
    background: gray;
    height: 86px;
    width: 120.3%;
    margin-left: -30px;
   
    margin-top: -22px;text-align:right;padding:10px 10px 10px 10px" >
    
    <img src="https://gjepc.org/iijs-premiere/assets/images/gjepc_logo.png" style="max-width: 200px; text-align:right">
                        
                      </div>
                     
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <img src="/images/employee_directory/600865078/photo/1656312388-photo-451296.jpg" style="max-height:150px; max-width: auto;" alt="">
                    </td>
                    <td>
                      <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/qr-code.png" style="max-height:150px; max-width: auto;"  alt="">
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 50%;vertical-align: baseline;">
                        <h3 style="display: block; font-weight: 900; letter-spacing: 1px;font-size: 16px;color: #000;">ATHUL EASWARAN PARAMESWARAN</h3>
                        <h3 style="font-size: 14px;margin-bottom: 0px;padding-bottom:0px" >Ape Brothers Sisters & Sons Electronics Pvt. Ltd.</h3>
                        <h3 style="font-size: 14px;margin-bottom: 0px;padding-bottom:0px;">Chairman</h3>
                        <h3 style="font-size: 14px;margin-bottom: 20px;padding-bottom:0px;">Mumbai</h3>
                    </td>
                    <td style="width:50%;vertical-align: baseline;">
                      <h3 style="font-size: 13px;">000000001</h3>
                      <h3 style="color: #f58220;font-size: 14px;margin-bottom: 0px;padding-bottom:0px">Entry to the show</h3>
                      <h3 style="color: #f58220;font-size: 14px;margin-bottom: 0px;padding-bottom:0px"><b>4th to 8th August</b></h3>
                      <h3  style="font-size: 14px;margin-bottom: 10px;padding-bottom:0px" >Vaccination status</h3>
                      <div style="width:100%;display:flex;justify-content: start;align-items: center;">
                        <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/heart.jpg" style="width:40px;float:left;">
                       
                        <div style="clear:both"></div>
                      </div>
                    </td>
                  </tr>
                  

                  <tr >
                    
                    <td colspan="2" style="width: 100%;">
                      <div style="padding-left: 30px;padding-top: 1px;padding-bottom: 1px;
    background: gray;
    width: 104.5%;
   
    margin-left: -23px;
   text-align:center;margin-bottom:-21.5px">
                     <p style="font-size: 28px;color: #fff;;font-weight:bold;" >TRADE VISITOR</p></div>
                     
                      
                    </td>
                   
                  </tr>
                  
                </tbody>
              </table>
            </td>
            <td style="width: 50%!important;border-bottom:1px solid #000;" >
              <table style="width: 100%;">
                <tbody>
    
                  <tr>
                    <td style="text-align:center;"> <img src="https://gjepc.org/iijs-premiere/assets/images/iijs_logo.png" style="width: 130px;"></td>

                  </tr>
                  <tr >
                    <td style="text-align:center;">
                      <div  style=" margin-top: 10px">
              
              
                <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/01.png" style="width: 25px;height: auto;margin-left:5px" alt="">
              
              
                <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/02.png" style="width: 25px;height: auto;margin-left:5px" alt="">
              
              
                <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/03.png" style="width: 25px;height: auto;margin-left:5px" alt="">
              
              
                <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/04.png" style="width: 25px;height: auto;margin-left:5px" alt="">
              
              
                <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/05.png" style="width: 25px;height: auto;margin-left:5px" alt="">
              
            </div>
                    </td>
                  </tr>
                  <tr>
                      <td  >
                      <div style="padding: 5px;
                        background: #f97918;
                       
                        width: 109.6%;
                        margin-left: -22px;
                        text-align: center;"
                       >
                       <p style="font-size: 15px;margin: 0px; "><b>Toll Free Number: 1800-103-4353</b></p>
                       <p style="font-size: 15px;margin: 0px;"><b>Missed call Number: +91-72080048100</b></p>
                        
                      </div>
                     
                    </td>
                  </tr>
                  <tr>
                    
                    <td style="text-align:center"><h3 style="font-size:18px;margin: 0px;padding:5px">TWO COVID VACCINE IS MANDATORY <br> TO VISIT THE SHOW</h3></td>
                  </tr>
                  <tr>
                    
                    <td style="text-align:center">
                      
                      <table style="width:100%">
                        <tr>
                          <td  width="50%">
                            <h3 style="font-size:16px;margin: 4px;">SHOW HOURS</h3>
                            
                          </td>
                          <td>
                             <p style="margin:4px">4th – 8th August 2022</p>
                            <p style="margin:4px">10am – 7pm</p>
                          </td>
                        </tr>

                        <tr>
                          <td width="50%">
                            <h3 style="font-size:16px;margin: 4px;">ENTRY IN TO EXHIBITIONS HALLS</h3>
                          
                         </td>

                         <td> <p style="margin:4px">4th – 8th August 2022</p>
                            <p style="margin:4px">10am – 7pm</p></td>
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
            </td>
            
          </tr>
            <tr >
            <td style="border-right:1px solid #000;width: 50%;background: #f2f1f1;">
              
              <table style="width:100%;">
                <tbody style="text-align: center;">
                  <tr>
                    <td style="text-align:center">
                      <img src="https://www.gjepc.org/assets/images/gold_star.png" >
                      <h3>BLOCK THE DATES</h3>

                    </td>
                    

                  </tr>
                  
                  <tr>
                    <td>
                     <table style="width:100%;">
                       <tbody>
                         <tr >
                           <td style="border-left: 1px solid#000;
                                  border-top: 1px solid#000;
                                  border-bottom: 1px solid#000;
                                  border-top-left-radius: 11px;
                                  border-bottom-left-radius: 11px;
                                  background: #fff;text-align:center"    
><div><h3>5th <br><small>to</small><br> 8th <br> JAN 2023</h3></div></td>
                           <td style="border: 1px solid#000;
    border-top-right-radius: 11px;
    border-bottom-right-radius: 11px;
    background: #cba15b;padding-left:15px"    ><div><h3><b> IIJS SIGNATURE</b> <hr><br><span>Bombay Exhibition Centre, NESCO, Mumbai</span></h3></div></td>
                         
                          
                         </tr>
                          <tr >
                            <td colspan="2" style="margin-top: 50px;"></td>
                          </tr>
                          <tr >
                           <td style="border-left: 1px solid#000;
                                  border-top: 1px solid#000;
                                  border-bottom: 1px solid#000;
                                  border-top-left-radius: 11px;
                                  border-bottom-left-radius: 11px;
                                  background: #fff;text-align:center"    
><div><h3>17th <br><small>to</small><br> 20th <br> MAR 2023</h3></div></td>
                           <td style="border: 1px solid#000;
    border-top-right-radius: 11px;
    border-bottom-right-radius: 11px;
    background: #cba15b;padding-left:15px"    ><div><h3><b> IIJS TRITIYA </b><hr><br><span>Bengaluru International Exhibition Centre, Bengaluru</span></h3></div></td>
                         
                          
                         </tr>
                         <tr>
                    <td colspan="2" style="text-align:center">
                      
                      <p style="margin-top:45px"><b>TWO COVID VACCINE IS MANDATORY
TO VISIT THE SHOW</b></p>

                    </td>
                    

                  </tr>
                       </tbody>
                     </table>
                    </td>
                  </tr>
                </tbody>
              </table>
              
              
            </td>

            <td style="width: 50%; solid #000; vertical-align:top">
            <div>
            <h3 style="font-size: 18px;color: #a89c5d; margin-bottom:0px;padding:0px;float:left">Rules & Regulations</h3>
            <img src="images/rules_qr.jpeg" style="width:70px;height:auto;float:right"/>
            <div style="clear:both"></div>
            </div>


               


          <ul style="font-size:11px; padding-left:0;">


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
 