<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require 'vendor/autoload.php';
require_once APPPATH.'modules/generic/controllers/Generic.php';

class Statuses extends Generic{
	
	function __construct(){
		parent::__construct();
		$this->load->model('Mdl_statuses');	
	}


	/******************************************* Zone Listing *******************************************/ 
	function lists(){
    if(!Modules::run('security/isAdmin')){
      redirect('admin/login','refresh');
    }

    $template = 'admin';
    $data['scriptFile'] = 'status';
	$data['breadcrumb'] = "Manage Status";
    $data['viewFile'] = 'list-status';
    $data['module'] = "statuses";
    echo Modules::run('template/'.$template, $data);
	}
	
	function getZoneLists()
	{	
	if(!Modules::run('security/isAdmin')){
      redirect('admin/login','refresh'); 
    }
	$list = $this->Mdl_statuses->get_datatabless("ticket_statuses");
    $data = array();
    $no = $_POST['start'];

	$i=1;
    foreach ($list as $val) {
	$row = array();
	$row[] = $i;
	$row[] = $val->name;
	 
       if($val->status == '1'){
          $sattus = '<span class="badge badge-success">ACTIVE</span>';
        } else {
          $sattus = '<span class="badge badge-danger">DEACTIVE</span>';
        }
		$row[] = $sattus;		
		
	/*	if(in_array('30', $rights_array)){ */
        $url   = base_url().'zone/editZone/'.$val->id;
        $row[] = '<a class="btn btn-rounded btn-outline-success" href="'.$url.'">Edit</a>';
      /*  } else {
         $row[] = '';
		} */

        $data[] = $row;		
		$i++;
    }
	
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Mdl_statuses->count_alls(),
      "recordsFiltered" => $this->Mdl_statuses->count_filtereds(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
	}
	
	/***************************************** Add Zone ***************************************/
	function add(){
		if(!Modules::run('security/isAdmin')){
		redirect('admin/login','refresh');
		}

		$data['breadcrumb'] = "Add Zone";
        $data['viewFile'] = 'add-zone';
		$data['page'] = 'zone';
		$data['scriptFile'] = "zone";
		$template = 'admin';
		echo Modules::run('template/'.$template, $data);
	} 


	/***************************************** Add Services Action ***************************************/
	function addZoneAction(){
		$content = $this->input->post();
		$token= $this->session->userdata("token");
        if($content["csrfToken"] == $token){

        $this->form_validation->set_rules("title","Title","required|xss_clean",array(
					'required'      => '<b>Title</b> field is required'
		));
		$this->form_validation->set_rules("shortDesc","Short Description","required",array(
					'required'      => '<b>Short Description</b> field is required'
		));
		
		$this->form_validation->set_rules('status','Status','trim|required|is_natural|xss_clean');
		
		if($this->form_validation->run() == FALSE){
			echo validation_errors();
		} else {
						
			if($this->session->userdata('admin')){
			$admin = $this->session->userdata('admin');
			$adminId = $admin['admin_id'];
			}
				$data = array(
					'name' => strip_tags($content['title']),
					'description'=>strip_tags($content['shortDesc']),
					'adminId' => $adminId,
					'status' => $content['status'],
					'created_at' =>date('Y-m-d H:i:s')
				);
				
				$insert = $this->Mdl_statuses->insert("zones",$data); 
				echo 1; exit;			
		}
	   } else {
		echo json_encode(array("status"=>"invalid")); exit;
	  }
	}
	
	/***************************************** Edit services ***************************************/
	function editZone($id){
		if(!Modules::run('security/isAdmin')){
		redirect('admin/login','refresh');
		}
		
		if(!empty($id)){
			$services = $this->Mdl_statuses->getByValue("zones","id",$id);
			if($services == "No Data"){
			  redirect('errors','refresh');
			} else {
			$data['getData'] = $services;			
			$data['viewFile'] = "edit-zone";
			$data['breadcrumb'] = "Update Zone";
			$template = 'admin';
			echo Modules::run('template/'.$template, $data);	
		}
		}
	}	

	/***************************************** Edit Blog Action ***************************************/
	function editZoneAction(){
		$content = $this->input->post();
		
		$this->form_validation->set_rules("title","Title","required|xss_clean",array(
					'required'      => '<b>Title</b> field is required'
		));
		
		$this->form_validation->set_rules("shortDesc","Short Description","required",array(
					'required'      => '<b>Short Description</b> field is required'
		));
		
		if($this->form_validation->run() == FALSE){
			echo validation_errors();
		} else {
								
				if($this->session->userdata('admin')){
				$admin = $this->session->userdata('admin');
				$adminId = $admin['admin_id'];
				}
				
				$data = array(
					'name' => $content['title'],
					'description'=>strip_tags($content['shortDesc']),
					'adminId' => $adminId,
					'status' => $content['status'],
					'updated_at' =>date('Y-m-d H:i:s')
				);
				
				$update = $this->Mdl_statuses->update2("zones","id",$content['id'],$data);
				echo 1; exit;
		}
	}

	 function redisCheck(){
     echo "test";exit;
    try{ 
      $redis = new Predis\Client([ 
        'scheme' => 'tcp', 
        'host' => 'scanapp-redis-node.kkquph.clustercfg.aps1.cache.amazonaws.com', 
        'port' => 6379 
      ]); 
    }catch(Exception $ex){ 
      echo $ex->getMessage(); 
    } 

    # working with simple string values 
    $redis->set("hello_world", "Hello Redis from php!"); 
    echo $redis->get("hello_world"); 
  }

}