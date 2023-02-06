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
$uniqueIdentifier = trim($_REQUEST['unique_id']);
$sql = "SELECT * FROM globalExhibition WHERE uniqueIdentifier='$uniqueIdentifier'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$name = $row['fname']. " ". $row['lname'] ; 
$uniqueIdentifier = $row['uniqueIdentifier'];
$photo = $row['photo_url'];
$company = $row['company'];
$designation = $row['designation'];

$html = '

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    
    <title></title>
  </head>
  <body>
  
      
      <table cellpadding="20" style="margin-left: -46px;margin-top: -46px;margin-bottom: -100px;font-size:12px; font-family:Arial, Helvetica, sans-serif; width:113%;">
        <tbody >
          <tr>
            <td style="width: 50%!important;border:1px solid #000;" >
              <table style="width: 100%;">
                <tbody>
                  <tr>
                    <td colspan="2" >
                      <div style="padding: 0px;
    background: gray;
    height: 65px;
    width: 112%;
    margin-left: -23px;
    margin-right: -35px;
    margin-top: -22px;">
                        
                      </div>
                     
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <img src="images/employee_directory/600879379/photo/600879379_9825030822_photo_2019854248img118.jpg" style="max-height:150px; max-width: auto;" alt="">
                    </td>
                    <td>
                      <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/qr-code.png" style="max-height:150px; max-width: auto;"  alt="">
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 50%;vertical-align: baseline;">
                        <h3 style="display: block; font-weight: 900; letter-spacing: 2px;font-size: 16px;color: #000;">'.$name.'</h3>
                        <h3 style="font-size: 14px;margin-bottom: 10px;" >'.$company.'</h3>
                        <h3 style="font-size: 14px;margin-bottom: 10px;">'.$designation.'</h3>
                        <h3 style="font-size: 14px;margin-bottom: 10px;">Mumbai</h3>
                    </td>
                    <td style="width:50%;vertical-align: baseline;">
                      <h3 style="font-size: 13px;">000000001</h3>
                      <h3 style="color: #f58220;font-size: 13px;margin-bottom: 0px;">Entry to the show</h3>
                      <h3 style="color: #f58220;font-size: 13px;margin-bottom: 0px;"><b>15th & 19th September</b></h3>
                      <h3  style="font-size: 15px;margin-bottom: 0px;" >Vaccination status</h3>
                      <div style="width:100%;display:flex;justify-content: start;align-items: center;">
                        <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/heart.jpg" style="width:50px">
                        <p  style="font-weight: 700;font-size: 15px;">Fully Vaccinated</p>
                      </div>
                    </td>
                  </tr>
                  <tr >
                    
                    <td style="width: 50%;">
                      <div style="padding-left: 30px;padding-top: 10px;padding-bottom: 10px;
    background: gray;
    width: 100%;
    height:80px;
    margin-left: -23px;
    margin-bottom: -23px;
    "><p style="font-size: 25px;font-weight: 900;color: #fff;margin-bottom: 0px;margin-top: 0px;">V</p>
                     <p style="font-size: 23px;color: #fff;padding-bottom:7px" >Visitor</p></div>
                     
                      
                    </td>
                    <td style="width: 50%;text-align:right;">
                      <div style="padding-left: 30px;padding-top: 10px;padding-bottom:10px;
    background: gray;
    width: 97%;
    height:80px;
    margin-right: -20px;
    margin-bottom: -23px;
  "> <img src="https://gjepc.org/iijs-premiere/assets/images/iijs_logo.png" style="width: 130px;margin-right: 10px;"></div>
                     
                    </td>
                  </tr>
                  
                </tbody>
              </table>
            </td>
            <td style="width: 50%!important;border:1px solid #000;" >
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
                      <h3 style="font-size:16px;margin: 4px;">SHOW HOURS</h3>
                      <p style="margin:4px">4<sup>th</sup> – 7<sup>th</sup> August 2022</p>
                      <p style="margin:4px">10am – 7pm</p>
                      <p style="margin:4px">8<sup>th</sup>  August 2022</p>
                      <pstyle="margin:4px">10am – 6:30pm</p>
                    </td>
                  </tr>
                  <tr>
                    <td style="text-align:center;">
                      <h3 style="font-size:16px;margin: 10px;">ENTRY IN TO EXHIBITION HALLS</h3>
                      <p style="font-size: 14px;margin: 5px;">Any time during the exhibition</p>
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
            <tr style="  -webkit-transform: rotateX( 180deg);
  -moz-transform: rotateX( 180deg);
  -o-transform: rotateX( 180deg);
  transform: rotateX( 180deg);">
            <td style="border:1px solid #000;width: 50%;background: #f2f1f1;">
              
              <table style="width:100%;">
                <tbody style="text-align: center;">
                  <tr>
                    <td style="text-align:center">
                      <img src="https://www.gjepc.org/assets/images/gold_star.png" >
                      <h3>BLOCK THE DATES</h3>

                    </td>
                    

                  </tr>
                  <tr>
                   <td style="text-align:center;"> <img src="https://gjepc.org/iijs-premiere/assets/images/iijs_logo.png" style="width: 130px;margin-bottom:10px"></td>
                    

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
><div><h3>5th <br><small>to</small><br> 8th <br> JAN 2023</h3></div></td>
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
            <td style="width: 50%;border:1px solid #000;">
              <table style="width: 100%; ">
                <tbody>
                <tr>
                <td style="text-align:center">
                
                <img src="https://gjepc.org/iijs-premiere/assets/images/iijs_logo.png">
                <div style="height:80px; border:1px solid#000;display:inline-block;margin-left:5px;margin-right:5px"></div>
                <img src="https://gjepc.org/iijs-premiere//assets/images/gjepc_logo.png"> 
     
      </td>
                </tr>
                <tr>
                <td>
                <h3 style="line-height: 50px;
    font-size: 20px;
    color: #a89c5d;
    font-family: "eloquent-jf-pro";
    letter-spacing: 1px;">India International Jewellery Show (IIJS) is India’s largest B2B gems and jewellery exhibition organised by the GJEPC</h3>
                </td>
                </tr>
                  <tr>
                    <td>
                       <img src="https://gjepc.org/assets/images/mobile_bg.png" width="100%">
                    </td>
                    <td>
                      
                    </td>
                   
                  </tr>
                </tbody>
              </table>
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
 