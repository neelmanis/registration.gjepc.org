<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/controllers/Generic.php';

/**
 * 	Author : Amit Kashte
 */

class Roles extends Generic{
	
	function __construct() {
		parent::__construct();
		$this->load->model('Mdl_admin');
	}

  /**
   *  listing page
   */
  function listPage(){
    $this->adminSession('super');
    
    $template = 'admin';
    $data['scriptFile'] = 'admin-roles';
    $data['viewFile'] = 'roles/list';
    $data['module'] = "admin";
    echo Modules::run('template/'.$template, $data);
  }

  /**
   *  Get records
   */
  function getRecords(){
    $records = $this->Mdl_admin->get_datatables("admin_roles");
//print_r($records); exit;
    $data = array();
    $no = $_POST['start']; 
    
    $admin_session = $this->session->userdata('admin');

    $max_limit = sizeof($records);
    $counter = 1;

    foreach ($records as $val){
      $row = array();
      
      $url = base_url().'admin/roles/update/'.$val->role_id;
      $row[] = '<a class="btn btn-rounded btn-outline-success" href="'.$url.'">Update</a>';
      $row[] = '<button class="btn btn-rounded btn-outline-danger" onclick="deleteRecord('.$val->role_id.')" >Delete</button>';

      $row[] = $val->name;
      $row[] = date("d-m-Y",strtotime($val->created_at));

      $data[] = $row;
      $counter++;
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Mdl_admin->count_all_roll("admin_roles"),
      "recordsFiltered" => $this->Mdl_admin->count_filtered_role("admin_roles"),
      "data" => $data,
    );

    echo json_encode($output);
  }
	
  /**
   *  Add
   */
  function add(){
    $this->adminSession('super');
    $data['menu'] = $this->Mdl_admin->retrieveByOrder("menu_master",array(),"order_no","ASC");
    $template = 'admin';
    $data['viewFile'] = "roles/add";
    $data['scriptFile'] = "admin-roles";
    $data['module'] = "admin";
    
    echo Modules::run('template/'.$template, $data);
  }
	
  /**
   *  Add Action
   */
  function addAction(){
    $content = $this->input->post();
    
    $token= $this->session->userdata("token");
    if($content["csrfToken"] == $token){

      $this->form_validation->set_rules("name","Name","trim|xss_clean|required|is_unique[admin_roles_master.name]",
      array(
        'required' => "Name is required",
        'is_unique' => "Name already exist"
      ));

      $this->form_validation->set_rules("rights[]","Rights","trim|xss_clean|required",
      array(
        'required' => "Rights not selected"
      ));
      
      if($this->form_validation->run() == FALSE){
        $errors = $this->form_validation->error_array();
        echo json_encode($errors); exit;
      }else{

        $data = array(
          'name' => strip_tags($content['name']),
          'rights' => strip_tags(implode(",", $content['rights'])),
          'created_at' => date('Y-m-d H:i:s'),
          'modified_at' => date('Y-m-d H:i:s')
        );

        $insert = $this->Mdl_admin->insert('admin_roles_master',$data);  

        echo json_encode(array("status"=>"success","title"=>"Success","icon"=>"success","message"=>'Role added successfully',"redirect"=>'admin/roles/list')); exit;
      }
    }else{
      echo json_encode(array("status"=>"alert","title"=>"Oops! an Error occured","icon"=>"error","message"=>"Your session has expired. Please reload & try again.")); exit;
    }
  }

  /**
   *  Update
   */
  function update($id){
    $this->adminSession('super');

    $result = $this->Mdl_admin->retrieve("admin_roles_master",array("role_id"=>$id));

    if($result == "NA"){
      redirect('errors','refresh');
    }else{
      $template = 'admin';
      $data['role'] = $result;
      $data['viewFile'] = "roles/update";
      $data['scriptFile'] = "admin-roles";
      $data['module'] = "admin";
      echo Modules::run('template/'.$template, $data);
    }
  }

  /**
   *  Update Action
   */
  function updateAction(){
    $content = $this->input->post();

    $token= $this->session->userdata("token");
    if($content["csrfToken"] == $token){

      if($content["roleName"] !== $content["name"]){
        $this->form_validation->set_rules('name','Name','trim|xss_clean|required|is_unique[admin_roles_master.name]',
        array(
          'required' => 'Name is required',
          'is_unique' => 'Name already exist'
        ));
      }else{
        $this->form_validation->set_rules('name','Name','trim|xss_clean|required',
        array(
          'required' => 'Name is required'
        ));
      }

      $this->form_validation->set_rules("rights[]","Rights","trim|xss_clean|required",
      array(
        'required' => "Rights not selected"
      ));

      if($this->form_validation->run() == FALSE){
        $errors = $this->form_validation->error_array();
        echo json_encode($errors);
      }else{

        $data = array(
          'name' => strip_tags($content['name']),
          'rights' => strip_tags(implode(",", $content['rights'])),
          'modified_at' => date('Y-m-d H:i:s')
        );

        $update = $this->Mdl_admin->update("admin_roles_master",array("role_id"=>$content['role_id']),$data);

        echo json_encode(array("status"=>"success","title"=>"Success","icon"=>"success","message"=>'Role updated successfully',"redirect"=>'admin/roles/list')); exit;
      }
    }else{
      echo json_encode(array("status"=>"alert","title"=>"Oops! an Error occured","icon"=>"error","message"=>"Your session has expired. Please reload & try again.")); exit;
    }
  }

  function deleteAction(){
    $role_id =$this->input->post('id');
    $this->Mdl_admin->delete('admin_roles_master',array("role_id"=>$role_id));

    // $role = $this->Mdl_admin->retrieve("admin_roles_master",array("id"=>$roleId));
    // if($role !== "NA"){
    //   $admin_data = array(
    //     'role_id' => 0,
    //     'modified_date' => date("Y-m-d H:i:s")
    //   );
    //   $update_admin = $this->Mdl_admin->update("admin_master",array("role_id"=>$roleId),$admin_data);
    //   $this->Mdl_admin->delete('admin_roles_master',array("id"=>$roleId));
    // }
    echo json_encode(array("status"=>"success")); exit;
  }
}