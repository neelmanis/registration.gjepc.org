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
    $this->load->model('Mdl_visitors');
    $this->load->library('ci_qr_code');
    $this->config->load('qr_code');
	}
  
  /**
   *  All Visitors listing page
  */
  function all_visitors(){
    $this->adminSession('super');
    $data["categories"] = $this->Mdl_visitors->retrieveByorder("category_master",array("status"=>"1"),"sort_order","ASC");
    $template = 'admin';
    $data['scriptFile'] = 'all-visitors';
    $data['viewFile'] = 'all-visitors';
    $data['module'] = "visitors";
    echo Modules::run('template/'.$template, $data);
  }
  
	

  /**
   *  Pending Images listing page
   */
  function pending_image(){
    $this->adminSession('super');
    $template = 'admin';
    $data['scriptFile'] = 'pendingImage';
    $data['viewFile'] = 'list';
    $data['module'] = "visitors";
    echo Modules::run('template/'.$template, $data);
  }

  /**
   *  Get records
  */
  public function getPendingImageRecords(){
    $records = $this->Mdl_visitors->get_datatables("pending_images");
    $data = array();
    $no = $_POST['start']; 
    $admin_session = $this->session->userdata('admin');
    $status_counter = $this->Mdl_visitors->countRecords('visitors',array('1'=>'1'));
    foreach ($records as $val){
      $row = array();
      $image = '<image src="'.base_url('public/images').'" />';
      $row[] = $image.' '.$val->name;
      $row[] = $val->company;
      $row[] = $val->category;
      $row[] = $val->	handover;
      
      if($val->status == '1'){
        $row[] = '<span class="badge badge-success">ACTIVE</span>';
      }elseif($val->status == 'D'){
        $row[] = '<span class="badge badge-danger">Disapproved</span>';
      }else{
        $row[] = '<span class="badge badge-danger">Pending</span>';
      }
      $row[] = '<a class="btn btn-circle btn-success mr-1" href="javascript:void(0);"><i class="ti-pencil-alt"></i></a><a class="btn btn-circle btn-info" href="javascript:void(0);"><i class="ti-eye"></i></a>';
      $row[] = date("d-m-Y",strtotime($val->post_date));
      $data[] = $row;
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Mdl_visitors->count_all("pending_images"),
      "recordsFiltered" => $this->Mdl_visitors->count_filtered("pending_images"),
      "data" => $data,
    );
    echo json_encode($output);
  }
  
  /**
   *  Get All Visitor records
  */
  public function getAllVisitorsRecords(){
    $records = $this->Mdl_visitors->get_datatables("all_visitors"); 

    $data = array();
    $no = $_POST['start']; 
    $admin_session = $this->session->userdata('admin');
    $status_counter = $this->Mdl_visitors->countRecords('visitors',array('1'=>'1'));

    // print_r($_POST);exit;
    foreach ($records as $val){
      $row = array();
      if($val->handover==1){
        $handover_btn = '<a class="btn btn-circle btn-success action_handover" data-id="'.$val->unique_code.'"  href="javascript:void(0);"><i class="ti-thumb-up"></i></a>';
      }else{
        $handover_btn = '<a class="btn btn-circle btn-info action_handover" data-id="'.$val->unique_code.'"  href="javascript:void(0);"><i class="ti-thumb-down"></i></a>';
      }

      if($val->company !==""){
        $getCategoryName = $this->Mdl_visitors->retrieve('category_master',array("short_name"=>$val->category));
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
	  
	  $url = base_url().'visitors/update/'.$val->id;	  
      $row[] = $visitor;
      $row[] = $val->company;
      $row[] = $category ;
      $row[] = $val->handover;
      if($val->status == 'Y'){
        $row[] = '<span class="badge badge-success">Active</span>';
      }elseif($val->status == 'D'){
        $row[] = '<span class="badge badge-danger">Disapproved</span>';
      }elseif($val->status == 'N'){
        $row[] = '<span class="badge badge-danger">Disapproved</span>';
      }else{
        $row[] = '<span class="badge badge-warning">Pending</span>';
      }
      $row[] = '<a class="btn btn-circle btn-info action_edit" href="'.$url.'"><i class="ti-pencil-alt"></i></a>
               
              
                 <a class="btn btn-circle btn-info " data-id="'.$val->unique_code.'"    href="'.base_url().'visitors/viewBadge/'.$val->unique_code.'" target="_blank"><i class="ti-printer"></i></a>
                
                 '.$handover_btn;
             
      $row[] = date("d-m-Y",strtotime($val->post_date));
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Mdl_visitors->count_all("all_visitors"),
      "recordsFiltered" => $this->Mdl_visitors->count_filtered("all_visitors"),
      "data" => $data,
    );
    //echo $this->db->last_query(); exit;
    
    echo json_encode($output);
  }
 
	public function handoverAction(){
    $admin_session = $this->session->userdata('admin');
    $content = $this->input->post();
    $unique_id = $content['unique_id'];
    $check_handover = $this->Mdl_visitors->retrieve("visitors",array("unique_code"=>$unique_id));
    if($check_handover !=="NA"){
      $handover = $check_handover[0]->handover;
      $update = $this->Mdl_visitors->update("visitors",  array("unique_code"=>$unique_id),array("handover"=>1) );
      
      if($update){
        echo json_encode(array("status" => "success", "title" => "Success", "icon" => "success", "message" => "Ticket has been handover successfully"));
      }
    }else{
      echo json_encode(array("status" => "alert", "title" => "Oops! an Error occured", "icon" => "error", "message" => "Something went wrong. Missing entry"));
    }
	}
	
	
	function add(){
    $admin = $this->session->userdata('admin');
    if($admin["is_superadmin"] == "N"  && $admin["admin_id"] == 6){
      $data['designation'] = $this->Mdl_visitors->customQuery("SELECT * FROM `category_master` WHERE `status` = 1 and cat_name = 'Press' ");
    } elseif($admin["is_superadmin"] == "N"  && $admin["admin_id"] == 7){
      $data['designation'] = $this->Mdl_visitors->customQuery("SELECT * FROM `category_master` WHERE `status` = 1 and cat_name = 'Overseas Visitor' ");
    }else {
      $data['designation'] = $this->Mdl_visitors->getByValue("category_master", "onspot_status", 1);
    }
		$data['scriptFile'] = 'all-visitors';
		$data['viewFile'] = 'add';
		$data['module'] = "visitors";
		$data['breadcrumb'] = "Add Onspot Visitor";
		$template = 'admin';		
		echo Modules::run('template/'.$template, $data); 
	}
	
	/*
  ** ADD ONSPOT ACTION
  */
  function addOnspotAction(){
    $content = $this->input->post();
    $category = $content['category'];

    // if(isset($content['nri_card_check'])){
    //   $nri_card_check = $content['nri_card_check'];
    // } else {
    //   $nri_card_check = false;
    // }
    $nri_card_check = $content['nri_card_check'];
    $this->form_validation->set_rules("category","category","trim|required|xss_clean",
    array(
      'required' => 'Please select category.'
    ));

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
      */

    $this->form_validation->set_rules("designation","Designation","trim|xss_clean",
    array(
      'required' => 'Designation is required.'
    ));

    $this->form_validation->set_rules("company","Company Name","trim|required|xss_clean",
    array(
      'required' => 'Company Name is required.'
    ));
    
    if($category == "OV"){
      //$this->form_validation->set_rules('pass_port', 'pass_port', 'callback_validate_file[pass_port,required,all]');
      $this->form_validation->set_rules('pass_port', 'pass_port', 'callback_validate_file[pass_port,required,all]');
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
		
		/*$digits = 9;	
		$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		$checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");
		$countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
		while($countUniqueIdentifier > 0) {
			$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		} */
		// echo "Hii";exit;
		$digits = 9;	
	    $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
	    $checkUniqueIdentifier =$this->Mdl_visitors->isExist("visitors", array("unique_code"=>$uniqueIdentifier));
	  
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
          echo json_encode(array("image"=>$img)); exit;
        }
    } else {
      echo json_encode(array("image"=>"Please select Photo file to upload")); exit;
    }

		if($this->session->userdata('admin')){
			$admin = $this->session->userdata('admin');
			$adminId = $admin['admin_id'];
			$name = $admin['name'];
		}
		
		$mobile = $content['mobile'];
		$registration_id = substr($mobile,0,4);
		$visitor_id = substr($mobile,0,4);
		$photo_url = base_url().'images/'.$imgName;
    ////////Nri Document Upload
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
          echo json_encode(array("image"=>$img)); exit;
        }
      } else {
        echo json_encode(array("image"=>"Please select Pass Port file to upload")); exit;
      }
      if(!empty($_FILES['business_card']['name'])){
        $filename = $_FILES['business_card']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
		    $business_card =  $uniqueIdentifier."_"."business_card";
        $img = $this-> uploadFile($business_card,"images","jpg|png|jpeg",'3000','','',"business_card");
        $business_card_imgName = $business_card.'.'.$ext;
        if($img !== 1){
          echo json_encode(array("image"=>$img)); exit;
        }
      } else {
        echo json_encode(array("image"=>"Please select Business Card file to upload")); exit;
      }
      if($nri_card_check == "true"){
        if(!empty($_FILES['nri_card']['name'])){
          $filename = $_FILES['nri_card']['name'];
          $ext = pathinfo($filename, PATHINFO_EXTENSION);
          $nri_card =  $uniqueIdentifier."_"."nri_card";
          $img = $this-> uploadFile($nri_card,"images","jpg|png|jpeg",'3000','','',"nri_card");
          $nri_card_imgName = $nri_card.'.'.$ext;
          if($img !== 1){
            echo json_encode(array("image"=>$img)); exit;
          }
        } else {
          echo json_encode(array("image"=>"Please select Nri Card file to upload")); exit;
        }
      }
      $pass_port_url = base_url().'images/'.$pass_port_imgName;
      $business_card_url = base_url().'images/'.$business_card_imgName;
      $nri_card_url = base_url().'images/'.$nri_card_imgName;
    }
    
		

      $data = array(
        'unique_code' => strip_tags($uniqueIdentifier),
        'registration_id' => strip_tags($registration_id),
        'category' => strip_tags($category),
        'visitor_id' => strip_tags($visitor_id),
		'user_id' => $adminId,
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
        'created_at' => date('Y-m-d H:i:s'),
        'status' => $content['status'],
        'created_by'=> $name
      );
      
      $insert = $this->Mdl_visitors->insert("visitors", $data);
      echo json_encode(array("status"=>"success")); exit;
    }
  }
  
  
  /*
  ** UPDATE Onspot
  */
  function update($id){
    $result = $this->Mdl_visitors->getByValue("visitors","id",$id);
	
    if($result == "No Data"){
      redirect('errors','refresh');
    } else {
      $admin = $this->session->userdata('admin');
      if($admin["is_superadmin"] == "N"  && $admin["admin_id"] == 6){
        $data['category'] = $this->Mdl_visitors->customQuery("SELECT * FROM `category_master` WHERE `status` = 1 and cat_name = 'Press' ");
      } elseif($admin["is_superadmin"] == "N"  && $admin["admin_id"] == 7){
        $data['category'] = $this->Mdl_visitors->customQuery("SELECT * FROM `category_master` WHERE `status` = 1 and cat_name = 'Overseas Visitor' ");
      }else {
        $data['category'] = $this->Mdl_visitors->getByValue("category_master", "status", 1);
      }
      //$data['category'] = $this->Mdl_visitors->getByValue("category_master", "status", 1);
      $data['onspot_visitor'] = $result;
      $data['breadcrumb'] = "Update Onspot Visitor";
      $data['viewFile'] = "edit";
      $data['scriptFile'] = "all-visitors";
      $data['module'] = "visitors";
      $template = 'admin';	  
      echo Modules::run('template/'.$template, $data);
    }
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

        if($this->session->userdata('admin')){
          $admin = $this->session->userdata('admin');
          $adminId = $admin['admin_id'];
		  $name = $admin['name'];
        }
        $result = $this->Mdl_visitors->getByValue("visitors","id",$content['id']);
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
        //echo $pass_port_url;
        //echo $business_card_url;exit;
        $data = array(
          'category' => strip_tags($content['category']),    
          'name' => strip_tags($content['fname']),	
		  'user_id' => $adminId,
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
          'updated_at' => date('Y-m-d H:i:s'),
          'status' => $content['status'],
          'created_by'=> $name
        );

      $update = $this->Mdl_visitors->update2("visitors","id",$content['id'],$data);
      echo json_encode(array("status"=>"success")); exit;
    }
  }

  public function viewBadge($unique_id){
    
    $vis = $this->Mdl_visitors->retrieve("visitors",array("unique_code"=>$unique_id));
    
    if($vis !=="NA"){
        $qr_code = $this->generate_qr($unique_id);
        $imgName = $vis[0]->photo_name;
        $photo_url =  base_url()."images/".$vis[0]->photo_name;
        $pdf_path = "badges/";
        $pdf_file_name = $unique_id;
        $getCategory = $this->Mdl_visitors->retrieve("category_master", array("short_name"=>$vis[0]->category));
        $category = $vis[0]->category;

        if($getCategory !=="NA"){
          $category_name = $getCategory[0]->cat_name;
          $color = $getCategory[0]->color;
          $color_text = $getCategory[0]->color_text;
          $html_rates_table = $getCategory[0]->html_rates_table;
          $html_show_timing = $getCategory[0]->html_show_timing;
          $html_rules = $getCategory[0]->html_rules;
        }

        $designation = $vis[0]->designation;
        $data = array(
          'view' => 'iijs-signature-2023',
          'path' => $pdf_path,
          'filename' => $pdf_file_name,
          "photo" =>  $vis[0]->photo_name,
          "qr_code" =>  $qr_code,
          "name" => strtoupper($vis[0]->name),
          "company" => strtoupper($vis[0]->company),
          "designation" => strtoupper($designation),
          "categoryDesc" => strtoupper($category_name),
          "color" => $color,
          "color_text" => $color_text,
          "category" => $category,
          "category_name" => $category_name,
          "rules" => $html_rules,
          "show_timing" => $html_show_timing,
          "rates_table" => $html_rates_table,
          "uniqueIdentifier" => $unique_id,
          "photo_url" => $photo_url,
        );
        // echo "<pre>";print_r($data);exit;
        $status = Modules::run('pdf/makePDF',$data);
    }else{
      echo "invalid access";
    }
  }
  public function gerenateBadges(){
    $all_visitors = $this->Mdl_visitors->customQuery("SELECT * FROM visitors where isGenerated='N' limit 25 ");
    if($all_visitors !=="NA"){
      foreach ($all_visitors as $vis) {
        if($vis->photo_name !==""){


        
          $qr_code = $this->generate_qr($vis->unique_code);
          $pdf_path = "badges/";
            $pdf_file_name = $vis->unique_code.'.pdf';
            $getCategory = $this->Mdl_visitors->retrieve("category_master", array("short_name"=>$vis->category));
            if($getCategory !=="NA"){
             $categoryDesc = $getCategory[0]->cat_name;
             $color = $getCategory[0]->color;
            }

            $description =   "This badge must be worn and clearly displayed
                              at all times. It is issued for access to specific
                              areas mentioned on this badge during the
                              event for specific function. This badge is not
                              transferable. The designated holder of this
                              badge waives all rights and titles to any legal
                              claims arising from any accident or damage
                              cause in conjunction with their presence at the
                              event. This badge is the property of The Gem &
                              Jewellery Export Promotion Council which
                              reserves the right to withdraw this badge
                              anytime at its sole discretion. ";
            $data = array(
              'view' => 'igjs-jaipur',
              'path' => $pdf_path,
              'filename' => $pdf_file_name,
              "photo" =>  $vis->photo_name,
              "qr_code" =>  $qr_code,
              "name" => $vis->name,
              "company" => $vis->company,
              "designation" => $vis->designation,
              "categoryDesc" => strtoupper($categoryDesc),
              "color" => $color,
              "description"=>$description
            );
            $status = Modules::run('pdf/generatePDF',$data);
            if($status){
              $this->Mdl_visitors->update("visitors",array("unique_code"=>$vis->unique_code),array("isGenerated"=>"Y"));
            }else{
               $this->Mdl_visitors->update("visitors",array("unique_code"=>$vis->unique_code),array("isGenerated"=>"N"));
            }
          }
      }
    }
    
  }


  public function loadBadgeAction(){
    $admin_session = $this->session->userdata('admin');
    $content = $this->input->post();
    $unique_id = $content['unique_id'];
    $getVisitor = $this->Mdl_visitors->retrieve("visitors",array("unique_code"=>$unique_id));
    if($getVisitor !=="NA"){
      $qr_code = $this->generate_qr($unique_id);
      $html = '';
       $html = '
       <div class="container"> 
   <div class="row mt-3">
   <div class="col-12 text-center">
    <a onClick="PrintContent();" class="btn input_bg cta fade_anim text-right mb-3 text-center btn-primary d-inline-block" target="_blank" style="cursor:pointer;color: #000;font-size:13px;">Print</a>
   </div>

        
    
   </div>
  </div>
    <div class="container page" id="divtoprint">
    <div style="display:flex;justify-content: center;">
      <div style="width:49%;border: 1px solid #000;">

      
      <div style="padding: 10px;">
        <div style="display:block; text-align: center;" class="img_container">
        <img src="'.base_url().'/assets/web/images/badges/ministry_GJEPC.jpg" style="max-width: 100%;" />
      </div>
        <div style="display:block;" class="img_container">
        <img src="'.base_url().'assets/web/images/badges/igjs00.png" style="max-width: 100%;" />
      </div>

      <div style="width:100%;">
        <div style="width: 49%; float: left;"  >
          <div style="height: 120px;text-align:center" class="img_container border ">
            <img src="'.base_url('images/'.$getVisitor[0]->photo_name).'" style="max-width: 100%;height:120px" />
          </div>

          <h3>'.$getVisitor[0]->name.'</h3>
          <p>'.$getVisitor[0]->company.'</p>
          <p>'.$getVisitor[0]->designation.'</p>
        </div>
        <div style="width: 49%;float: right;" >
          <div style="height: 120px;text-align:center" class="img_container border">
              <img src="'.$qr_code.'" style="max-width: 100%;height:120px"  />
          </div>
        
        </div>
        <div style="clear: both;"></div>
      </div>
      </div>
      <div style="width:100%;background: blue;padding: 20px 0px;text-align: center;">
        <span style="font-size:20px;font-weight: 700;color: #fff;">CHAIRMAN</span>
      </div>

    </div>
    <div style="width:49%;border: 1px solid #000;padding: 10px">
      <p style="line-height: 23px;">The show timings are as below:</p>
      <p style="line-height: 10px;">10th May 2022 – 10am – 6:30pm</p>
      <p style="line-height: 10px;">11th May 2022 – 10am – 6:30pm</p>
      <p style="line-height: 10px;">12th May 2022 – 10am – 6:30pm</p>
      <h3 style="font-weight: bold; color:#c08833;">JECC, JAIPUR</h3>
      <div style="border-bottom: 3px solid #c08833; height: 10px; width: 100%; margin-bottom: 15px;"></div>
        <div style="width: 49%;float: left;" >
            <p>Associates Partners</p>
            <img src="'.base_url().'assets/web/images/badges/gemifields.jpg" style="max-width: 100%;"  />
        </div>
        <div style="width: 49%;float: left;" >
             <p>Freight Forwarder</p>
            <img src="'.base_url().'assets/web/images/badges/sequal.jpg" style="max-width: 100%;"  />
        </div>
        <div style="clear: both;"></div>
        <div style="border-bottom: 3px solid #c08833; height: 10px; width: 100%; margin-bottom: 15px;"></div>
        <div>
          <p style="font-size: 13px;">This badge must be worn and clearly displayed
              at all times. It is issued for access to specific
              areas mentioned on this badge during the
              event for specific function. This badge is not
              transferable. The designated holder of this
              badge waives all rights and titles to any legal
              claims arising from any accident or damage
              cause in conjunction with their presence at the
              event. This badge is the property of The Gem &
              Jewellery Export Promotion Council which
              reserves the right to withdraw this badge
              anytime at its sole discretion. </p>
        </div>
    </div>
    </div>

  <div style="display:flex;justify-content: center;">
      <div style="width:49%;border: 1px solid #000;background-image: url(\'"./assets/web/images/badges/dots_top.jpg\'");background-repeat: no-repeat;background-position: left top;">
      <div style="width:100%;padding: 10px">

      <div style=" height: 100px; width: 100%;display: flex; justify-content: center;align-items: center;">
        <h3 style="text-align: center;color: #c08833;font-weight: 700;">BLOCK THE DATES</h3>
      </div>
      <div style="display: flex;justify-content: center;align-items: center;padding: 0px 50px;margin-bottom: 10px;">
        <div style="width:50%">
          <img src="'.base_url().'assets/web/images/badges/igjsLogo.jpg" style="max-width: 100%">
        </div>
        <div style="width:50%">
          <img src="'.base_url().'assets/web/images/badges/igjs01.jpg" style="max-width: 100%">
        </div>
      </div>
      <div style="display: flex;justify-content: center;align-items: center;padding: 0px 50px;margin-bottom: 10px;">
        <div style="width:50%">
          <img src="'.base_url().'assets/web/images/badges/igjsLogo.jpg" style="max-width: 100%">
        </div>
        <div style="width:50%">
          <img src="'.base_url().'assets/web/images/badges/igjs02.jpg" style="max-width: 100%">
        </div>
      </div>
      <div style="display: flex;justify-content: center;align-items: center;padding: 0px 50px;margin-bottom: 10px;">
        <div style="width:50%">
          <img src="'.base_url().'assets/web/images/badges/igjsLogo.jpg" style="max-width: 100%">
        </div>
        <div style="width:50%">
          <img src="'.base_url().'assets/web/images/badges/igjs03.jpg" style="max-width: 100%">
        </div>
      </div>
      
      </div>
      <div style="background-image: url("./assets/web/images/badges/dots_bottom.jpg");background-repeat: no-repeat;background-position: right bottom;height: 100px;">
    </div>

    </div>
    <div style="width:49%;border: 1px solid #000;padding: 10px">
        
          <div style="padding:10px">
            <div style="width: 49%;float: left;" >
            <h4 style="margin-top: 0px;">www.gjepc.org</h4>
          
          </div>
          <div style="width: 49%;float: right; text-align: right;" >
            
            <img src="'.base_url().'assets/web/images/badges/GJEPC_logo.jpg" style="max-width: 100%;"  >
          </div>
          <div style="clear: both;"></div>
          </div>
        <div style="width: 100%;text-align: center;margin-top: 5px;" >
            
            <img src="'.base_url().'assets/web/images/badges/01.jpg" style="max-width: 100%;"  >
        </div>
      
          <h2 style="font-size: 20px;text-align: center;">
            IF IT CAN’T BE <br>
            MADE ANYWHERE,<br>
            IT CAN BE MADE<br>
            IN INDIA.
          </h2>
        
        <div style="clear: both;"></div>

        <div style="width: 100%;text-align: center;margin-top: 5px;" >
            
            <img src="'.base_url().'assets/web/images/badges/02.jpg" style="max-width: 100%;"  >
        </div>
        <h4 style="margin-bottom: 15px;text-align:center;">INDIA.</h4>
        <h5 style="padding:0;font-size: 10px;text-align: center;">THE WORLD’S GEM & JEWELLERY DESTINATION.</h5>
        <h5 style="padding:0; font-size:10px;text-align:center">The Gem & Jewellery Export Promotion Council</h5>
        <p style="padding:0; font-size:10px;text-align:center">Sponsored by the Ministry of Commerce & Industry</p>
        <h4 style="margin-bottom:7px;text-align:center;"><span style="padding-right: 5px; font-size: 13px;">GJEPCindia</span><span style="padding-right: 5px; font-size: 13px;">GJEPCindia</span><span style=" font-size: 13px;">GJEPCindia</span></h4>

      

      
      
    </div> 
    </div>
  </div> ';

      echo json_encode(array("status" => "success", "output" => $html));
    }else{
      echo json_encode(array("status" => "alert", "title" => "Oops! an Error occured", "icon" => "error", "message" => "Something went wrong. Missing entry"));
    }
  }


function generate_qr($unique_id)
  {
    $data = array();
    $params =array();
    $badgeInfo = $this->Mdl_visitors->retrieve("visitors",array("unique_code"=>$unique_id));

  
    if($badgeInfo =='NA'){
        $response = array("status"=>"invalid","message"=>"Record not found");
        echo json_encode($response);exit;
    }
    $name = $badgeInfo[0]->name;
    $company = $badgeInfo[0]->company;
    $designation = $badgeInfo[0]->designation;
    $qr_code_config = array();
    $qr_code_config['cacheable'] = $this->config->item('cacheable');
    $qr_code_config['cachedir'] = $this->config->item('cachedir');
    $qr_code_config['imagedir'] = $this->config->item('imagedir');
    $qr_code_config['errorlog'] = $this->config->item('errorlog');
    $qr_code_config['ciqrcodelib'] = $this->config->item('ciqrcodelib');
    $qr_code_config['quality'] = $this->config->item('quality');
    $qr_code_config['size'] = $this->config->item('size');
    $qr_code_config['black'] = $this->config->item('black');
    $qr_code_config['white'] = $this->config->item('white');
    $this->ci_qr_code->initialize($qr_code_config);
    $image_name = $unique_id . ".png";
    // create user content
    $codeContents = "";
    $codeContents .= trim($unique_id);
    $codeContents .= " | ";
    $codeContents .= trim($badgeInfo[0]->category);
    $codeContents .= " | ";
    $codeContents .= trim($badgeInfo[0]->name);
    $codeContents .= " | ";
    $codeContents .= trim($badgeInfo[0]->company);
    $codeContents .= " | ";
    $codeContents .= trim($badgeInfo[0]->designation);
    $codeContents .= " | ";
    $params['data'] = $codeContents;
    $params['level'] = 'H';
    $params['size'] = 5;
    $params['savename'] = FCPATH . $qr_code_config['imagedir'] . $image_name;
    $this->ci_qr_code->generate($params);
    $file = $params['savename'];
    return base_url().$qr_code_config['imagedir'].$image_name;
  }

  // function getBatchDownload() {
  //   $content = $this->input->get('uniqueIdentifier', TRUE);
  //   $unique_id = $content[''];
  // }
  
}