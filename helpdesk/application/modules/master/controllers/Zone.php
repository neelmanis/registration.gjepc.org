<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'modules/generic/controllers/Generic.php';

class Zone extends Generic{
	
	function __construct(){
		parent::__construct();
		$this->load->model('Mdl_master');	
	}


	/******************************************* Zone Listing *******************************************/ 
	function lists(){

    if(!Modules::run('security/isAdmin')){
      redirect('admin/login','refresh');
    }

    $data['scriptFile'] = 'zone';
	$data['breadcrumb'] = "Manage Zone";
    $data['viewFile'] = 'zone/list-zone';
    $data['module'] = "master";
	$template = 'admin';
    echo Modules::run('template/'.$template, $data);
	}
	
	function getZoneLists()
	{	
	if(!Modules::run('security/isAdmin')){
      redirect('admin/login','refresh'); 
    }
	$list = $this->Mdl_master->get_datatables("zone_master");
    $data = array();
    $no = $_POST['start'];
	$admin_session = $this->session->userdata('admin');
    $rights_string = $admin_session['rights'];
    $rights_array = explode(',' , $rights_string); 
	$i=1;
    foreach ($list as $val) {
	$row = array();
	$row[] = $i;
	$row[] = $val->name;
	$row[] = $val->description;
	 
       if($val->status == '1'){
          $sattus = '<span class="badge badge-success">ACTIVE</span>';
        } else {
          $sattus = '<span class="badge badge-danger">DEACTIVE</span>';
        }
		$row[] = $sattus;		
	/*	if(in_array('30', $rights_array)){*/
        $url   = base_url().'master/zone/editZone/'.$val->id;
        $row[] = '<a class="btn btn-rounded btn-outline-success" href="'.$url.'">Edit</a>';
    /*    } else {
         $row[] = '';
		} */
        $data[] = $row;		
		$i++;
    }
	
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Mdl_master->count_all("zone_master"),
      "recordsFiltered" => $this->Mdl_master->count_filtered("zone_master"),
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
        $data['viewFile'] = 'zone/add-zone';
		$data['page'] = 'Zone';
		$data['scriptFile'] = "zone";
		$data['module'] = "master";
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
		
		if($this->form_validation->run($this) == FALSE){
			$errors = $this->form_validation->error_array();
			echo json_encode($errors); exit;
		  }else{
						
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
				
				$insert = $this->Mdl_master->insert("zones",$data); 
				if($insert){
					echo json_encode(array("status"=>"success","title"=>"Success","icon"=>"success","message"=>'Zone added successfully.',"redirect"=>'master/zone/lists')); exit;
				}else{
					echo json_encode(array("status"=>"alert","title"=>"ERROR","icon"=>"warning","message"=>'Server error')); exit;
				}
						
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
			$services = $this->Mdl_master->retrieve("zones",array("id"=>$id));
			if($services == "No Data"){
			  redirect('errors','refresh');
			} else {
			$data['getData'] = $services;			
			$data['viewFile'] = "zone/edit-zone";
			$data['breadcrumb'] = "Update Zone";
			$data['scriptFile'] = "zone";
			$data['module'] = "master";
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
		
		if($this->form_validation->run($this) == FALSE){
			$errors = $this->form_validation->error_array();
			echo json_encode($errors); exit;
		  }else{
								
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
				
				$update = $this->Mdl_master->update("zones", $data,array( "id"=>$content['id']) );
				if($update){
					echo json_encode(array("status"=>"success","title"=>"Success","icon"=>"success","message"=>'Zone updated successfully.',"redirect"=>'master/zone/lists')); exit;
				}else{
					echo json_encode(array("status"=>"alert","title"=>"ERROR","icon"=>"warning","message"=>'Server error')); exit;
				}
		}
	}

}