<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/controllers/Generic.php';
include ("html2pdf.php");
require_once APPPATH.'dompdf/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;
class Pdf extends Generic{
  
  function __construct() {
    parent::__construct();
  }

  function path(){
    echo $_SERVER['DOCUMENT_ROOT'].'<br>';
    echo APPPATH;
  }

  public function makePDF($data){
   
    $filename = $data['filename'];
    ob_get_clean();
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $dompdf = new DOMPDF($options);
    $html = $this->load->view($data['view'], $data, true);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream($filename, array("Attachment" => 1));
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/badges/'.$filename.'.pdf', $dompdf->output()); 
    $filePath = $_SERVER['DOCUMENT_ROOT'].'/badges/'.$filename.'.pdf';
    redirect(base_url("badges/".$data['filename']));
  }

  

  public function generatePDF($data){
    $this->load->library('html2pdf');
    $this->html2pdf->folder($data['path']);
    $this->html2pdf->filename($data['filename']);
    $this->html2pdf->paper('a4', 'portrait');
    $this->html2pdf->html($this->load->view($data['view'], $data, true));
    if($this->html2pdf->create('save')) {
      return TRUE;
    }else{
      return FALSE;
    }
  }

  
  
 
} 