<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MX_Exceptions extends CI_Exceptions {

  function show_404($page = '', $log_error = TRUE){
  
    $heading = "404 Page Not Found";
    $message = "The page you requested was not found.";

    // By default we log this, but allow a dev to skip it
    if ($log_error){
      log_message('error', '404 Page Not Found --&gt; '.$page);
    }

    // echo $this->show_error($heading, $message, 'error_404', 404);
    
    redirect('errors','refresh');
    
    exit;
  }
}