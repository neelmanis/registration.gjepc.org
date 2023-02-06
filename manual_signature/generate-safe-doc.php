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

$EXHIBITOR_CODE = $_SESSION['EXHIBITOR_CODE'];
$sql_exh = "SELECT * FROM iijs_exhibitor WHERE Exhibitor_Code='$EXHIBITOR_CODE'";
$result_exh = $conn->query($sql_exh);
$row_exh = $result_exh->fetch_assoc();

$querySafe = $conn->query("SELECT Create_Date FROM iijs_payment_master WHERE Exhibitor_Code='$EXHIBITOR_CODE' AND Form_ID='5A'");
$row_safeResult = $querySafe->fetch_assoc();
$dates  = date("j M Y");

$Exhibitor_Contact_Person = $row_exh['Exhibitor_Contact_Person'];
$company_name = $row_exh['Exhibitor_Name'];
$Exhibitor_Address1 = $row_exh['Exhibitor_Address1'];
$Exhibitor_Address2 = $row_exh['Exhibitor_Address2'];
$Exhibitor_Address3 = $row_exh['Exhibitor_Address3'];
$Exhibitor_City = strtoupper($row_exh['Exhibitor_City']);

$address = $Exhibitor_Address1.', '.$Exhibitor_Address2.', '.$Exhibitor_Address3.', '.$Exhibitor_City;

$html ='
<!DOCTYPE html>
  <html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  </head>

  <body>
    <table width="100%" align="center" style="margin: 2% auto;border: 2px solid #ddd;font-family: Arial, sans-serif; color: #333;font-size: 14px;border-radius: 10px;padding: 10px;">
      <tbody>       
        <tr>
        <td>		  
		 <table width="100%">	
		  <tr>
          <td align="left" valign="center"><img src="https://gjepc.org/assets/images/logo.png" alt=""></td>
          <td align="right" valign="center"><img src="https://gjepc.org/iijs-signature/assets/images/SIGNATURE-LOGO-4.jpg" alt=""></td>
		  </tr>
		</table>
		 
		<hr/>		  
            <p style="line-height: 24px;">We / I, <strong>'.$Exhibitor_Contact_Person.',</strong>  an adult, Indian Inhabitants / Partnership / Proprietorship concern of <strong>'.$company_name.'</strong> having address at <strong>'.$address.'</strong>   hereby jointly and severally state on solemn affirmation as follows: -</p>
            <ol style="line-height: 24px;">
              <li>
                That an Agreement for temporary usage of safety lockers and safes has been entered into as we require the Fire resistant safes to secure the Valuables during the Show and therefore have requested the M/s Godrej and Boyce Mfg. Co. Ltd. to supply to us on temporary usage basis the safe for its use for period of four days from <strong>05 JAN 2023</strong>  to <strong>09 JAN 2023</strong> i.e. for the period of the exhibition.
              </li>
              <li>We as Exhibitors have independently insured our articles through our representative insurers against theft, fire public liability, damage to, personal injuries, third party loss, accidents natural calamities, act of Gods and such others risk normally insured against in case of Valuable. We are hereby aware that the FR safe supplied by M/s Godrej and Boyce Mfg. Co. Ltd as per exhibitor’s requirement is not a burglar resistant safe and M/s Godrej and Boyce Mfg. Co. Ltd. shall not be concerned in any manner whatsoever with regard to the same. In the event any claim arises in future it shall be the sole responsibility of the Exhibitors to settle the same directly with their respective Insurers. We therefore do hereby agree and undertake at all times hereafter indemnify and keep indemnified and save harmless against damages, actions or any claims to M/s Godrej & Boyce Mfg. Co. Ltd. </li>
              <li>We say that we are making this declaration for the limited purpose to enable Godrej & Boyce Mfg. co. ltd. to permit the temporary usage of Safety Lockers and Safes during the Exhibition Period.</li>
            </ol>
            <p style="line-height: 24px;">We say that whatever we have stated herein-above is true and correct to the best of our knowledge and belief.</p>
            <p style="line-height: 24px;"><strong>(AUTHORISED SIGNATORY NAME AND CONTACT) </strong> <br>
(PLACE: MUMBAI, '.$dates.')
</p>
          </td>
        </tr>
       
      </tbody>
    </table>
  

</body>
</html>';

$filename = $EXHIBITOR_CODE;
ob_get_clean();
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new DOMPDF($options);
$dompdf->loadHtml($html);

$dompdf->setPaper($customPaper);
$dompdf->render();

 $dompdf->stream($filename, array("Attachment" => 1));
 file_put_contents($_SERVER['DOCUMENT_ROOT'].'/manual_signature/images/safe/'.$filename.'.pdf', $dompdf->output());
 $sql_all_update = "UPDATE iijs_exhibitor SET isSafePdf='1' WHERE Exhibitor_Code='$EXHIBITOR_CODE'";
 $conn->query($sql_all_update);
 $dompdf->clear();