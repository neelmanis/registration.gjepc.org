<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'modules/generic/controllers/Generic.php';

date_default_timezone_set('Asia/Kolkata');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET,PUT,DELETE");
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authtoken');
header("Access-Control-Max-Age: 86000");

class Visitors extends Generic{

  function __construct() {
    parent::__construct();
    $this->load->model('Mdl_api');	
  }

  public function addVisitors(){
    if(!$this->validateToken()){
      echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    }else{
      $uid = $this->validateToken();
    }
    $method = $this->input->method(TRUE);  
    if($method !== 'POST'){
        //json_output(400,array('status' => 400,'message' => 'Bad request.'));
    echo json_encode(array('status' => 400,'message' => 'Bad request.'));exit;
    } else {  

     
    $content = $this->input->post();

    
    $this->form_validation->set_data($content);
    $this->form_validation->set_rules('company','Company name','trim|xss_clean|required',array("required"=>"Company name is required"));
    $this->form_validation->set_rules('name','Full name','trim|xss_clean|required',array( "required" => "Full name  is required"));
    $this->form_validation->set_rules('email','Email','trim|xss_clean|valid_email',array("required" => "Email is required", "valid_email" => "Email is incorrect","is_unique" => "This email address is already in use"));
    $this->form_validation->set_rules('mobile','Mobile','trim|xss_clean',array("required" => "Mobile no is required"));
    $this->form_validation->set_rules('designation','Designation','trim|xss_clean|required',array( "required" => "Designation name  is required"));
    $this->form_validation->set_rules('photo','Photo file','callback_validate_file[photo,required,image]');
    $this->form_validation->set_rules('source','Source','trim|xss_clean|required',array( "required" => "Source is required"));
    $this->form_validation->set_rules('category','Category','trim|xss_clean|required',array( "required" => "Category is required"));
    $this->form_validation->set_rules('photo_id_type','Photo ID Type','trim|xss_clean',array( "required" => "%s is required"));
    $this->form_validation->set_rules('photo_id_value','Photo ID Value','trim|xss_clean',array( "required" => "%s is required"));
    $this->form_validation->set_rules('photo_id_file','photo ID file','callback_validate_file[photo_id_file,notRequired,image]');
    
    if($this->form_validation->run($this) == FALSE){
        $errors = $this->form_validation->error_array();
        echo json_encode(array('status'=>'error','errorData'=>$errors));exit;
    } else { 
      // Generate 9 digit unique ID
      $digits = 9;	
	    $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
	    $checkUniqueIdentifier =$this->Mdl_api->isExist("visitors", array("unique_code"=>$uniqueIdentifier));
	  
      while($checkUniqueIdentifier){
        $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
      } 
				
      $base_path = "images";
			

        if(isset($_FILES["photo"]['name']) && $_FILES["photo"]['name'] !== ""){
					$filename_photo = $_FILES['photo']['name'];
					$ext_photo = pathinfo($filename_photo, PATHINFO_EXTENSION);
					$imagename_photo =  $uniqueIdentifier;
					$img_photo = $this->uploadFile($imagename_photo,$base_path,"jpg|png|jpeg",'5120','3000','3000',"photo");
					$imgpath_photo = $imagename_photo.'.'.$ext_photo;
					if($img_photo !== 1){
						echo json_encode(array("photo"=>$img_photo)); exit;
					}
				}else{
          //echo json_encode(array("photo"=>"Select Photo ")); exit;
				}

        $base_path_docs = "documents/".$uniqueIdentifier ;
        if (!file_exists($base_path_docs)) {
          mkdir($base_path_docs, 0777);
        }

        if(isset($_FILES["photo_id_file"]['name']) && $_FILES["photo_id_file"]['name'] !== ""){
					$filename_photo_id_file = $_FILES['photo_id_file']['name'];
					$ext_photo_id_file = pathinfo($filename_photo_id_file, PATHINFO_EXTENSION);
					$imagename_photo_id_file =  $uniqueIdentifier."_".strtotime('now');
					$img_photo_id_file = $this->uploadFile($imagename_photo_id_file,$base_path_docs,"jpg|png|jpeg",'5120','3000','3000',"photo_id_file");
					$imgpath_photo_id_file = $imagename_photo_id_file.'.'.$ext_photo_id_file;
					if($img_photo_id_file !== 1){
						echo json_encode(array("photo_id_file"=>$img_photo_id_file)); exit;
					}
				}else{
          $imgpath_photo_id_file = "";
				}
        $photo_url = base_url()."images/".	$imgpath_photo;
        $data = array(
          "registration_id"=>0,
          "visitor_id"=>0,
          "unique_code"=>$uniqueIdentifier,
          "company"=>strip_tags($content['company']),
          "name"=>strip_tags($content['name']),
          "email"=>strip_tags($content['email']),
          "mobile"=>strip_tags($content['mobile']),
          "designation"=>strip_tags($content['designation']),
          "photo_url"=>$photo_url,
          "photo_name"=>$imgpath_photo,
          "source"=>$content['source'],
          "category"=>strip_tags($content['category']),
          "photo_id_type"=>strip_tags($content['photo_id_type']),
          "photo_id_value"=>strip_tags($content['photo_id_value']),
          "photo_id_file"=>$imgpath_photo_id_file,
          "created_by"=> $uid,
          "status"=> "Y",
          "created_at"=> date("Y-m-d H:i:s"),
          "updated_at"=> date("Y-m-d H:i:s"),

      );

      $result = $this->Mdl_api->insert("visitors",$data);

      if( $result){
        $response = array("status"=>"success","message"=>"Visitor has been registered successfully","result"=>array());
      }else{
        $response = array("status"=>"error","message"=>"Something went wrong","result"=>array());
      }
      echo  json_encode($response);exit;
 
      }
    }


  }

  public function allVisitorsList(){
    if(!$this->validateToken()){
      echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    }
    $data = $this->Mdl_api->retrieve("visitors",array("1"=>"1"));
    if($data !=="NA"){
        $response = array("status"=>"success","message"=>"",array("result"=>$data));
        
    }else{
        $response = array("status"=>"error","message"=>"Visitors not found",array("result"=>array()));
    }
    echo json_encode($response);exit;

  }

  public function visitorLog($unique_code){
    if(!$this->validateToken()){
      echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    }
    if(!empty($unique_code)){
      $data = $this->Mdl_api->retrieve("scan_logs",array("unique_code"=>$unique_code));
      if($data !=="NA"){
          $response = array("status"=>"success","message"=>"",array("result"=>$data));
          
      }else{
          $response = array("status"=>"success","message"=>"visitor is not visited the show",array("result"=>array()));
      }

    }else{
      $response = array("status"=>"error","message"=>"Visitors id missing",array("result"=>array()));
    }
   
    echo json_encode($response);exit;

  }

  public function searchVistitor(){
    if(!$this->validateToken()){
      echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    }

    if(!$this->validateToken()){
      echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
    }else{
      $uid = $this->validateToken();
    }
    $method = $this->input->method(TRUE);  
    if($method !== 'POST'){
        //json_output(400,array('status' => 400,'message' => 'Bad request.'));
        $response =array('status' => 400,'message' => 'Bad request.',array("result"=>array()));
    } else {  
      $content = json_decode(file_get_contents('php://input'), TRUE);

      $page = $content['page'];
      $limit = $content['limit'];
      $start = ($page - 1) * $content['limit'];

      $name = trim($content['name']);
      $category = trim($content['category']);
      $status = trim($content['status']);
      $total_count = $this->Mdl_api->countRecords("visitors",array("1"=>"1"));
      $sql = "SELECT * FROM visitors WHERE 1 ";
      if($category !==""){
        $sql .=" AND category='$category'";
      }
      if($name !==""){
        $sql .=" AND (name like '%$name%' OR company like '%$name%')";
      }
      if($status !==""){
        $sql .=" AND status='$status'";
      }
    
      
      $sql .="ORDER BY  created_at  DESC  LIMIT $start , $limit ";
    
      $result = $this->Mdl_api->customQuery($sql);
      if($result !=="NA"){
        $filtered_count = count($result);
        $response = array("status"=>"success","message"=>"Records found","filtered_count"=>$filtered_count,"total_count"=>$total_count,array("result"=>$result));
      }else{
        $filtered_count = 0;
        $response = array("status"=>"success","message"=>"Records not found","filtered_count"=>$filtered_count,"total_count"=>$total_count,array("result"=>array()));
      }
      
    
     
    }

     
    
    echo json_encode($response);exit;

  }



}

