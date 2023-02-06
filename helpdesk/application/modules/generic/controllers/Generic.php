<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
/**
 * 	Author : Amit Kashte
 */

class Generic extends MX_Controller{

  public $global_variables;
  
  function __construct() {
    parent::__construct();  

    $this->global_variables = array(
    
      'jwt_key'=>'9fThWmZq4t7w!z%C*F-JaNdRgUkXn2r7',

      'encrypt_method'=>'aes-256-cbc',
      'secret_key'=>'9fThWmZq4t7w!z%C*F-JaNdRgUkXn2r7',
      "secret_iv" => "H-T4t7w!z%C*F-Ja",


      // PAGINATION
      'limit_per_page' => 10,

      'web_assets' => base_url().'assets/web/',
      'pdf_upload' => $_SERVER['DOCUMENT_ROOT'].'/adraas/',
      'upload_path' =>  base_url().'web_uploads/',
      'version'    => 'v=1.141',

      'expiry_time' => '+10 minutes',

      // 'mail_env'       => 'local',
      // 'mail_host'      => 'smtp.googlemail.com', 
      // 'mail_username'  => 'shrikhandesantosh56@gmail.com',                    
      // 'mail_password'  => 'Santosh@9623',
    
    );
  }

  /**
   *  Verify Exhibitor Session
   */
  function exhibitorSession(){
    if(! Modules::run('security/isExibitor')){
      redirect('/exhibitor-login','refresh');
    }
  }

  /**
   *  Verify User Session
   */
  function userSession(){
    if(! Modules::run('security/isUser')){
      redirect('/login','refresh');
    }
  }

  /**
   *  Verify Admin session
   */
  function adminSession($access){
    if(! Modules::run('security/isAdmin')){
      redirect('admin','refresh');
    }

    $admin = $this->session->userdata('admin');
    $is_superadmin = $admin['role'];
    $admin_id = $admin['admin_id'];
    if($is_superadmin == "N"  && $admin_id == 6){
      return true;
    } 
    if($is_superadmin == "N"  && $admin_id == 7){
      return true;
    }
    if($is_superadmin == "N"  && $admin_id == 8){
      return true;
    }
    if($is_superadmin == "N"  && $admin_id == 10){
      return true;
    }
    if($is_superadmin == "N" ){
      $arr = $admin['rights'];
      $rights = explode(",",$arr);
      if(! in_array($access,$rights)){
        redirect('admin/dashboard','refresh');
      }
    }
  }

  

  /**
   *  Upload File
   */
  function uploadFile($imageName,$uploadPath,$allowedTypes,$maxSize,$maxWidth,$maxHeight,$key){
    $config['file_name'] = $imageName;
    $config['upload_path'] = FCPATH.$uploadPath;
    $config['allowed_types'] = $allowedTypes;
    $config['max_size']  = "5000"; //100MB
    $config['overwrite'] = true;
    // $config['max_width']  = $maxWidth;
    // $config['max_height']  = $maxHeight;
    $this->load->library('image_lib', $config);
    $this->load->library('upload',$config);
    $this->upload->initialize($config);
    if (!$this->upload->do_upload($key)){
      return $this->upload->display_errors();
    }else{
        $uploadedImage = $this->upload->data();
        $this->resizeImage($uploadedImage['file_name']);
        return 1;
    }
  }



  /*
  ** IMAGE CALLBACK FUNCTION PFOFILE PHOTO UPLOAD
  */
  public function validate_file($photos,$param){
    $paramArr  = explode(",",$param);
    $name = $paramArr[0];
    if(isset($paramArr[1]) && $paramArr[1]=="required"){
      $required = "yes";
    }else{
      $required = "no";
    }
    if(isset($paramArr[2]) && $paramArr[2]=="image" ){
      $allowed_mime_type_arr = array("JPG","PNG","JPEG");
      $message = "Please select only JPG,PNG,JPEG file.";
    }else if(isset($paramArr[2]) && $paramArr[2]=="pdf"){
      $allowed_mime_type_arr = array('PDF');
      $message = "Please select only pdf file.";
    }else{
      $allowed_mime_type_arr = array('JPEG','JPG','PNG','PDF','DOC','DOCX','XLS','ZIP','ODS','XLSM','XLSX','PPT','PPTX');
      $message = "Please select recommended file tye.";
    }
    if(isset($_FILES[$name]['name']) && $_FILES[$name]['name'] !== ""){
      $filename = $_FILES[$name]['name'];
      $ext = pathinfo($filename, PATHINFO_EXTENSION);
    
      if(in_array(strtoupper($ext), $allowed_mime_type_arr)){
        return true;
      }else{
        $this->form_validation->set_message("validate_file", $message);
        return false;
      }
    }else{
      if($required =="yes"){
        $this->form_validation->set_message("validate_file", 'Please choose file to upload.');
        return false;
      }
     
    }
  }

   function encryptParam($payload){
    $key = hash('sha256', $this->global_variables['secret_key']);
    $iv = substr(hash('sha256', $this->global_variables['secret_iv']), 0, 16);
    $output = openssl_encrypt($payload, $this->global_variables['encrypt_method'], $key, 0, $iv);
    $output = base64_encode($output);
    return $output;
  }
  function decryptParam($payload){
    $key = hash('sha256', $this->global_variables['secret_key']);
    $iv = substr(hash('sha256', $this->global_variables['secret_iv']), 0, 16);
    $output = openssl_decrypt(base64_decode($payload), $this->global_variables['encrypt_method'], $key, 0, $iv);
    return $output;
  }

  
  
  
   /**
   *  Validate Token
   */

	public function validateToken(){

    $method = $_SERVER['REQUEST_METHOD'];
    $headers = $this->input->request_headers();
      if(isset($headers['Authtoken'])){
        $token = $headers['Authtoken'];
      }else{
        $token = $headers['authtoken'];
      }

      $check_token_validity = Modules::run('security/validateAuthToken',$token);
    
      if($check_token_validity['status'] === "valid"){
        	return $check_token_validity['uid'];
      }else{

        	echo json_encode(array('status' => 'fail'));exit;
          return false;
      } 
  }

  /**
   *  CURL FUNCTION
   */

  public function fetchCurlApi($payload,$request_url,$token=""){
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $request_url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>json_encode($payload),
      CURLOPT_HTTPHEADER => array(
        'Content-Type: text/plain'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
  }
  public function fetchCurlGetApi($request_url,$token=""){
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $request_url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authtoken: '.$token
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
  }

  public function fetchAuthCurlApi($payload,$request_url,$token=""){

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $request_url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>json_encode($payload),
      CURLOPT_HTTPHEADER => array(
        'Authtoken: '.$token,
        'Authorization: Bearer '.$token,
        'Content-Type: application/json',
      ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return $response;


  }

  function compressImage($source, $destination, $quality) 
  {
    $imgInfo = getimagesize($source); 
    $mime = $imgInfo['mime']; 
    switch($mime){ 
        case 'image/jpeg': 
            $image = imagecreatefromjpeg($source); 
            break; 
        case 'image/png': 
            $image = imagecreatefrompng($source); 
            break; 
        case 'image/jpg': 
            $image = imagecreatefromgif($source); 
            break; 
        default: 
            $image = imagecreatefromjpeg($source); 
    } 
    // Save image 
    imagejpeg($image, $destination, $quality); 
    // Return compressed image 
    return $destination; 
  }


  public function resizeImage($filename)
   {
      $source_path = $_SERVER['DOCUMENT_ROOT'] . '/images/' . $filename;
      $target_path = $_SERVER['DOCUMENT_ROOT'] . '/images/';
      $config_manip = array(
          'image_library' => 'gd2',
          'source_image' => $source_path,
          'new_image' => $target_path,
          'maintain_ratio' => TRUE,
          'width' => 500,
      );
   
      $this->load->library('image_lib', $config_manip);
      if (!$this->image_lib->resize()) {
          echo $this->image_lib->display_errors();
      }
   
      $this->image_lib->clear();
  }

  
  
}
