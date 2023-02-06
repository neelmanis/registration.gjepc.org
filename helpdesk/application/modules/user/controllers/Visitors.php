<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/controllers/Generic.php';

/**
 * 	Author : SANTOSH SHRIKHANDE
 */
require_once APPPATH.'dompdf/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Content;

class Visitors extends Generic{
	
	function __construct() {
		parent::__construct();
        $this->load->model('Mdl_user');
        
	}
	
	function add(){
      $user = $this->session->userdata('user');
      if( !isset($user["name"]) ||  !isset($user["uid"])){
          redirect('errors','refresh'); 
      } 
      $data['designation'] = $this->Mdl_user->customQuery("SELECT * FROM `category_master` WHERE `onspot_status` = 1  ");
      $data['country'] = $this->Mdl_user->retrieve("country_master", array());
      $data['state'] = $this->Mdl_user->retrieve("state_master", array());
      $data['scriptFile'] = 'all-visitors';
      $data['viewFile'] = 'visitor/add';
      $data['module'] = "user";
      $data['breadcrumb'] = "Add Onspot Visitor";
      $template = 'user';		
      echo Modules::run('template/'.$template, $data); 
	}
	
	/*
  ** ADD ONSPOT VISITOR ACTION
  */
    function addOnspotAction(){
        $this->userSession();
        $content = $this->input->post();
        $category = $content['category'];
//print_r($_SESSION); exit;

        $nri_card_check = $content['nri_card_check'];
        $this->form_validation->set_rules("category","category","trim|required|xss_clean",
        array(
            'required' => 'Please select category.'
        ));

        $this->form_validation->set_rules("fname","Name","trim|required|xss_clean",
        array(
            'required' => 'Name is required.'
        ));
        
        $this->form_validation->set_rules("email","E-mail ID","trim|required|xss_clean|valid_email",
        array(
            'required' => 'E-mail ID is required.'
        ));

        if($category != "OV"){
            $this->form_validation->set_rules("mobile","Mobile","trim|required|xss_clean");
        }

        $this->form_validation->set_rules("designation","Designation","trim|xss_clean",
        array(
            'required' => 'Designation is required.'
        ));

        $this->form_validation->set_rules("pan_no","Pan Number","trim|required|xss_clean",
        array(
            'required' => 'Pan number is required.'
        ));

        $this->form_validation->set_rules("company","Company Name","trim|required|xss_clean",
        array(
            'required' => 'Company Name is required.'
        ));
        
        $this->form_validation->set_rules("country","country","trim|required|xss_clean",
        array(
            'required' => 'Country is required.'
        ));

        if($content['country'] == "107"){
          $this->form_validation->set_rules("state_select","state","trim|required|xss_clean",
          array(
              'required' => 'State is required.'
          ));
        }else{
          $this->form_validation->set_rules("state_input","state","trim|required|xss_clean",
          array(
              'required' => 'State is required.'
          ));
        }

        $this->form_validation->set_rules("city","city","trim|required|xss_clean",
        array(
            'required' => 'City is required.'
        ));


        $this->form_validation->set_rules('visitor_photo', 'Visitor Photo', 'callback_validate_file[visitor_photo,required,all]');
        
        if($category == "OV"){
            $this->form_validation->set_rules('pass_port', 'Passport Photo', 'callback_validate_file[pass_port,required,all]');
            $this->form_validation->set_rules('business_card', 'Business Card', 'callback_validate_file[business_card,required,all]');
            if($nri_card_check == true){
                $this->form_validation->set_rules('nri_card', 'Nri Card', 'callback_validate_file[nri_card,required,all]');
            }
        }
        

        if ($this->form_validation->run($this) == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode($errors);
            exit;
        } else {
			
			
            $user_session = $this->session->userdata('user');
            $user_id = $user_session['uid'];
            $userId = $user_session['id'];
            $created_by = $user_session['name'];
            $check_uid =$this->Mdl_user->isExist("authentication", array("uid"=>$user_id));
            if(!$check_uid){
                echo json_encode(array("status"=>"alert","message"=>"Invalid User access found","title"=>"Warning","icon"=>"warning")); exit;
            }
        
  
            $digits = 9;	
            $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
            $checkUniqueIdentifier =$this->Mdl_user->isExist("visitors", array("unique_code"=>$uniqueIdentifier));
        
            while($checkUniqueIdentifier){
              $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
            } 
			  
            if(!empty($_FILES['visitor_photo']['name'])){
                $filename = $_FILES['visitor_photo']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $imagename_photo =  $uniqueIdentifier;

                $img = $this-> uploadFile($imagename_photo,"images","jpg|png|jpeg",'3000','','',"visitor_photo");
                $imgName = $imagename_photo.'.'.$ext;
                if($img !== 1){
                  echo json_encode(array("visitor_photo"=>$img)); exit;
                }
            } else {
              echo json_encode(array("visitor_photo"=>"Please select Photo file to upload")); exit;
            }
		
            $mobile = $content['mobile'];
            $registration_id = substr($mobile,0,4);
            $visitor_id = substr($mobile,0,4);
            $photo_url = base_url().'images/'.$imgName;
            ///Nri Document Upload
            $pass_port_url = '';
            $business_card_url = '';
            $nri_card_url = '';$pass_port_imgName='';$business_card_imgName='';$nri_card_imgName='';
            if($category == "OV"){
              if(!empty($_FILES['pass_port']['name'])){
                  $filename = $_FILES['pass_port']['name'];
                  $ext = pathinfo($filename, PATHINFO_EXTENSION);
                      $pass_port =  $uniqueIdentifier."_"."pass_port";

                  $img = $this-> uploadFile($pass_port,"images","jpg|png|jpeg",'3000','','',"pass_port");
                  $pass_port_imgName = $pass_port.'.'.$ext;
                  if($img !== 1){
                  echo json_encode(array("pass_port"=>$img)); exit;
                  }
              } else {
                  echo json_encode(array("pass_port"=>"Please select Pass Port file to upload")); exit;
              }
              if(!empty($_FILES['business_card']['name'])){
                  $filename = $_FILES['business_card']['name'];
                  $ext = pathinfo($filename, PATHINFO_EXTENSION);
                  $business_card =  $uniqueIdentifier."_"."business_card";
                  $img = $this-> uploadFile($business_card,"images","jpg|png|jpeg",'3000','','',"business_card");
                  $business_card_imgName = $business_card.'.'.$ext;
                  if($img !== 1){
                    echo json_encode(array("business_card"=>$img)); exit;
                  }
              } else {
                  echo json_encode(array("business_card"=>"Please select Business Card file to upload")); exit;
              }
              if($nri_card_check == "yes"){
                  if(!empty($_FILES['nri_card']['name'])){
                  $filename = $_FILES['nri_card']['name'];
                  $ext = pathinfo($filename, PATHINFO_EXTENSION);
                  $nri_card =  $uniqueIdentifier."_"."nri_card";
                  $img = $this-> uploadFile($nri_card,"images","jpg|png|jpeg",'3000','','',"nri_card");
                  $nri_card_imgName = $nri_card.'.'.$ext;
                  if($img !== 1){
                      echo json_encode(array("nri_card"=>$img)); exit;
                  }
                  } else {
                  echo json_encode(array("nri_card"=>"Please select Nri Card file to upload")); exit;
                  }
              }
              $pass_port_url = base_url().'images/'.$pass_port_imgName;
              $business_card_url = base_url().'images/'.$business_card_imgName;
              $nri_card_url = base_url().'images/'.$nri_card_imgName;
            }
            $country_id = $content['country'];
            $country_data =  $vis = $this->Mdl_user->retrieve("country_master",array("id"=>$country_id));
            if($country_data == "NA"){
              $country_name = "";
            }else{
              $country_name = $country_data[0]->country_name;
            }
    
            $state_name = '';
            $state_code = '';
            if($country_id == "107"){
              $state_code = $content['state_select'];
              $state_data =  $vis = $this->Mdl_user->retrieve("state_master",array("state_code"=>$content['state_select']));
              if($state_data == "NA"){
                $state_name = "";
              }else{
                $state_name = $state_data[0]->state_name;
              }
               
            }else{
              $state_name = $content['state_input'];
            }
    
            $data = array(
              'unique_code' => strip_tags($uniqueIdentifier),
              'registration_id' => strip_tags($registration_id),
              'category' => strip_tags($category),
              'visitor_id' => strip_tags($visitor_id),
              'user_id' => strip_tags($userId),
              'name' => strip_tags($content['fname']),
              'mobile' => strip_tags($content['mobile']),
              'email' => strip_tags($content['email']),
              'pan_no' => strip_tags($content['pan_no']),		
              'designation' => strip_tags($content['designation']),		
              'company' => strip_tags($content['company']),
              'photo_url' => $photo_url,
              'source' => 'onspot',
              'photo_name'=> strip_tags($imgName),
              "pass_port_url" => $pass_port_url,
              "business_card_url" => $business_card_url,
              "pass_port_name" => $pass_port_imgName,
              "business_card_name" => $business_card_imgName,
              "nri_card_name" => $nri_card_imgName,
              "nri_card_url" => $nri_card_url,
              "nri_card_check" => $nri_card_check,
              // "country_code" => $country_id,
              "country" => $country_name,
              // "state_code" => $state_code,
              "state" => $state_name,
              "city" => strip_tags($content['city']),
              'created_at' => date('Y-m-d H:i:s'),
              'status' => $content['status'],
              'created_by'=> $created_by
            );
        
            $insert = $this->Mdl_user->insert("visitors", $data);
            if($insert){
              echo json_encode(array("status"=>"redirect","message"=>"Visitor has been added successfuly","title"=>"Success","icon"=>"success","redirect"=>"user/visitors/visitor_list")); 
            } else {
              echo json_encode(array("status"=>"alert","message"=>"Opps something went wrong","title"=>"Failed","icon"=>"error")); 
            }
              }           
        
    }
  
  
  /*
  ** UPDATE Onspot
  */
  function update($id){
    $this->userSession();
    $result = $this->Mdl_user->retrieve("visitors",array("id"=>$id));
    if($result == "NA"){
      redirect('user/dashboard','refresh');
    }
      $data['category'] = $this->Mdl_user->getByValue("category_master", "onspot_status", 1);
      $data['country'] = $this->Mdl_user->retrieve("country_master", array());
      $data['state'] = $this->Mdl_user->retrieve("state_master", array());
      // echo "<pre>";print_r($result);exit;
      $data['onspot_visitor'] = $result;
      $data['breadcrumb'] = "Update Onspot Visitor";
      $data['viewFile'] = "visitor/edit";
      $data['scriptFile'] = "all-visitors";
      $data['module'] = "user";
      $template = 'user';	  
      echo Modules::run('template/'.$template, $data);
    
  }
	
	/*
  ** UPDATE Onspot ACTION
  */
  function updateOnspotVisitorAction(){
    $content = $this->input->post();
    // print_r($content); exit;
    $category = $content['category'];
    $nri_card_check = $content['nri_card_check'];
    
    $this->form_validation->set_rules("fname","Name","trim|required|xss_clean",
    array(
      'required' => 'Name is required.'
    ));
    if($category != "OV"){
      $this->form_validation->set_rules("mobile","Mobile","trim|required|xss_clean");
    }
      /*
      $this->form_validation->set_rules("email","Email","trim|required|xss_clean|valid_email",
        array(
          'required' => 'Email is required.',
          'valid_email' => 'Email is invalid.'
        ));
      
        $this->form_validation->set_rules("pan_no","PAN No","trim|required|xss_clean",
        array(
          'required' => 'PAN is required.'
        ));
      
        $this->form_validation->set_rules("designation","Designation","trim|required|xss_clean",
        array(
          'required' => 'Designation is required.'
        ));
    */
    // if($category == "OV"){
    //   $this->form_validation->set_rules('pass_port', 'pass_port', 'callback_validate_file[pass_port,required,all]');
      
    //   $this->form_validation->set_rules('business_card', 'Business Card', 'callback_validate_file[business_card,required,all]');
    //   if($nri_card_check == true){
    //     $this->form_validation->set_rules('nri_card', 'Nri Card', 'callback_validate_file[nri_card,required,all]');
    //   }
    // }
    $this->form_validation->set_rules("country","country","trim|required|xss_clean",
    array(
        'required' => 'Country is required.'
    ));

    if($content['country'] == "107"){
      $this->form_validation->set_rules("state","state","trim|required|xss_clean",
      array(
          'required' => 'State is required.'
      ));
    }
    $this->form_validation->set_rules("city","city","trim|required|xss_clean",
    array(
        'required' => 'City is required.'
    ));
    
    $this->form_validation->set_rules("company","Company Name","trim|required|xss_clean",
    array(
      'required' => 'Company Name is required.'
    ));

    if($this->form_validation->run() == FALSE){
      $errors = $this->form_validation->error_array();
      echo json_encode($errors); exit;
    } else {
	  
        if(!empty($_FILES['visitor_photo']['name'])){

        $filename = $_FILES['visitor_photo']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $imagename_photo =  $content['unique_code'];
		    $unlink = unlink("images/".$imagename_photo.'.'.$ext); 
		
        $img = $this-> uploadFile($imagename_photo,"images","jpg|png|jpeg",'3000','','',"visitor_photo");
        $imgName = $imagename_photo.'.'.$ext;
        if($img !== 1){
          echo json_encode(array("image"=>$img)); exit;
        }
        } else {
            $imgName = $content['imgpath'];
        }
        $user = $this->session->userdata('user');
        $user_Id = $user['uid'];
		    $userId = $user_session['id'];
		    $created_by = $user_session['name'];
        
        $result = $this->Mdl_user->getByValue("visitors","id",$content['id']);
        $pass_port_url = $result[0]->pass_port_url;
        $business_card_url = $result[0]->business_card_url;
        $nri_card_url = $result[0]->nri_card_url;
        $pass_port_imgName=$result[0]->pass_port_name;
        $business_card_imgName=$result[0]->business_card_name;
        $nri_card_imgName=$result[0]->nri_card_name;
        $photo_url = base_url().'images/'.$imgName;
        if($category == "OV"){
          if(!empty($_FILES['pass_port']['name'])){
            $filename = $_FILES['pass_port']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $unlink = unlink("images/".$pass_port_imgName); 
            $pass_port =  $content['unique_code']."_"."pass_port_u";
    
            $img = $this-> uploadFile($pass_port,"images","jpg|png|jpeg",'3000','','',"pass_port");
            $pass_port_imgName = $pass_port.'.'.$ext;
            if($img !== 1){
              echo json_encode(array("image"=>$img)); exit;
            }
          } else {
            if(empty($pass_port_url)){
              echo json_encode(array("image"=>"Please select Pass Port file to upload")); exit;
            }
          }
          if(!empty($_FILES['business_card']['name'])){
            $filename = $_FILES['business_card']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $unlink = unlink("images/".$business_card_imgName); 
            $business_card =  $content['unique_code']."_"."business_card";
            $img = $this-> uploadFile($business_card,"images","jpg|png|jpeg",'3000','','',"business_card");
            $business_card_imgName = $business_card.'.'.$ext;
            if($img !== 1){
              echo json_encode(array("image"=>$img)); exit;
            }
          } else {
            if(empty($business_card_url)){
              echo json_encode(array("image"=>"Please select Business Card file to upload")); exit;
            }   
          }
          if($nri_card_check == "true"){
            if(!empty($_FILES['nri_card']['name'])){
              $filename = $_FILES['nri_card']['name'];
              $ext = pathinfo($filename, PATHINFO_EXTENSION);
              if(!empty($nri_card_imgName)){
                $unlink = unlink("images/".$nri_card_imgName); 
              }
              $nri_card =  $content['unique_code']."_"."nri_card";
              $img = $this-> uploadFile($nri_card,"images","jpg|png|jpeg",'3000','','',"nri_card");
              $nri_card_imgName = $nri_card.'.'.$ext;
              if($img !== 1){
                echo json_encode(array("image"=>$img)); exit;
              }
            } else {
              if(empty($nri_card_url)){
                echo json_encode(array("image"=>"Please select Nri Card file to upload")); exit;
              } 
            }
          }
          $pass_port_url = base_url().'images/'.$pass_port_imgName;
          $business_card_url = base_url().'images/'.$business_card_imgName;
          $nri_card_url = base_url().'images/'.$nri_card_imgName;
        }
        if($nri_card_check == "false"){
          $nri_card_url = '';
          $nri_card_imgName = '';
        }
        $country_id = $content['country'];
        $country_data =  $vis = $this->Mdl_user->retrieve("country_master",array("id"=>$country_id));
        if($country_data == "NA"){
          redirect('errors','refresh');
        }
        $country_name = $country_data[0]->country_name;
        $state_name = '';
        $state_code = '';
        if($country_id == "107"){
          $state_code = $content['state'];
          $state_data =  $vis = $this->Mdl_user->retrieve("state_master",array("state_code"=>$content['state']));
          if($state_data == "NA"){
            redirect('errors','refresh');
          }
          $state_name = $state_data[0]->state_name; 
        }
        //echo $pass_port_url;
        //echo $business_card_url;exit;
        $data = array(
          'category' => strip_tags($content['category']),    
          'name' => strip_tags($content['fname']),
		  'user_id' => strip_tags($userId),
          'company' => strip_tags($content['company']),
          'photo_url' => $photo_url,
          'photo_name'=> strip_tags($imgName),
          'source' => 'onspot',
          "pass_port_url" => $pass_port_url,
          "business_card_url" => $business_card_url,
          "pass_port_name" => $pass_port_imgName,
          "business_card_name" => $business_card_imgName,
          "nri_card_name" => $nri_card_imgName,
          "nri_card_url" => $nri_card_url,
          "nri_card_check" => $nri_card_check,
          "country_code" => $country_id,
          "country_name" => $country_name,
          "state_code" => $state_code,
          "state_name" => $state_name,
          "city" => strip_tags($content['city']),
          'updated_at' => date('Y-m-d H:i:s'),
          'status' => $content['status'],
          'updated_by'=> $created_by
        );

      $update = $this->Mdl_user->update2("visitors","id",$content['id'],$data);
      echo json_encode(array("status"=>"success")); exit;
    }
  }

    /**
   *  All Visitors listing page
  */
  function visitor_list(){
    $this->userSession();
    $data["categories"] = $this->Mdl_user->retrieveByorder("category_master",array("status"=>"1"),"sort_order","ASC");
    $template = 'user';
    $data['scriptFile'] = 'all-visitors';
    $data['viewFile'] = 'visitor/all-visitors';
    $data['module'] = "user";
    echo Modules::run('template/'.$template, $data);
  }

  /**
   *  Get All Visitor records
  */
  public function getAllVisitorsRecords(){
    $records = $this->Mdl_user->get_datatables("all_visitors"); 

    $data = array();
    $no = $_POST['start']; 
    $admin_session = $this->session->userdata('admin');
    $status_counter = $this->Mdl_user->countRecords('visitors',array('1'=>'1'));

    // print_r($_POST);exit;
    foreach ($records as $val){
      $row = array();
      
      if($val->company !==""){
        $getCategoryName = $this->Mdl_user->retrieve('category_master',array("short_name"=>$val->category));
        if($getCategoryName !=="NA"){
          $category = $getCategoryName[0]->cat_name;
        }
      }
      $visitor = '<div class="d-flex">
      <div class="mr-3">
          <img width="40" height="40" class="img-circle" src="'.base_url('images/'.$val->photo_name).'" alt="" >
      </div>
      <div class="text-left">
          <p class="mb-0">'.$val->name.'</p>
          <p class="">
              '.$val->designation.'
          </p>
      </div>
      </div>';
      $status  = "";
      if($val->status == 'Y'){
        $status = '<span class="badge badge-success">Active</span>';
      }elseif($val->status == 'D'){
        $status = '<span class="badge badge-danger">Disapproved</span>';
      }elseif($val->status == 'N'){
        $status = '<span class="badge badge-danger">Disapproved</span>';
      }else{
        $status = '<span class="badge badge-warning">Pending</span>';
      }  
      $url = base_url().'user/visitors/update/'.$val->id;    
      
      $row[] = $visitor;
      $row[] = $val->company;
      $row[] = $category ;
      $row[] = $status ;
      $row[] = '<a class="btn btn-circle btn-info action_edit" href="'.$url.'"><i class="ti-pencil-alt"></i></a>';
      $data[] = $row;

    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Mdl_user->count_all("all_visitors"),
      "recordsFiltered" => $this->Mdl_user->count_filtered("all_visitors"),
      "data" => $data,
    );
    //echo $this->db->last_query(); exit;
    
    echo json_encode($output);
  }
  
}