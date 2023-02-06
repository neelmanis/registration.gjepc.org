<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/controllers/Generic.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

/**
 * 	Author : Amit Kashte
 */

class Email extends Generic{
  
  function __construct() {
    parent::__construct(); 
    $this->load->model('Mdl_email');	
  }

  function mailer($data){
    $message = $this->load->view($data['view_file'], $data, TRUE);

    if($this->global_variables['mail_env'] == 'local'){
      $to = 'santosh@kwebmaker.com';
      $cc = '';
      $bcc = '';
    }else{
      $mails = explode(",",$data['to']);
      $cc = $data['cc'];
      $bcc = $data['bcc'];
      $mails = explode(",","santosh@gmail.com");
      $cc = "";
      $bcc = "";
    }
    
    $subject = $data['subject'];

    try {
      $mail = new PHPMailer(true);
      $mail->isSMTP(); 
      $mail->CharSet = 'UTF-8';                                           
      $mail->SMTPAuth   = true;                                   
      
      $mail->Host       = $this->global_variables['mail_host']; 
      $mail->Username   = $this->global_variables['mail_username'];                     
      $mail->Password   = $this->global_variables['mail_password'];  
      $mail->Port       = $this->global_variables['mail_port'];  
  
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

      $mail->setFrom('info@adraas.com','Adraas');
      
      foreach($mails as $m){
        $mail->addAddress($m);
      }

      if( $cc !== ""){
        $mail->addCC($cc);
      }                               
      
      if( $bcc !== ""){
        $mail->addBCC($bcc);
      }   

      if( isset($data['isAttachment']) && $data['isAttachment'] ){
        $mail->addAttachment($data['attachment']);
      }

      // Content                          
      $mail->Subject = $subject;
      $mail->Body    = $message;
      $mail->isHTML(true); 

      if($mail->send()){
        return true;
      } else {
        return false;
      }
    } catch (Exception $e) {
      return false;
    }
  }

  function test(){
    $to = 'amit@kwebmaker.com';
    // echo "test"; exit;

    try {
      $mail = new PHPMailer(true);
      $mail->isSMTP(); 
      $mail->CharSet = 'UTF-8';                                           
      $mail->SMTPAuth   = true;                                   
      
      $mail->Host       = $this->global_variables['mail_host']; 
      $mail->Username   = $this->global_variables['mail_username'];                     
      $mail->Password   = $this->global_variables['mail_password'];  
      $mail->Port       = $this->global_variables['mail_port'];  
  
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

      $mail->setFrom('info@adraas.com','ADRAAS');
      $mail->addAddress($to);     

      // Content                          
      $mail->Subject = "Test mail";
      $mail->Body    = "Testing";
      // $mail->addAttachment('assets/pdf/invoice/21-RE-000001.pdf');
      // $mail->addAttachment('assets/pdf/invoice/21-RE-000002.pdf');
      // $mail->isHTML(true); 

      if( $mail->send() ){
        echo "Sent";
      } else {
        echo "Failed";
      }
    } catch (Exception $e) {
      echo $e;
    }
  }
}