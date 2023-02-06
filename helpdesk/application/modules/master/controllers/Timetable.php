<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/controllers/Generic.php';

/**
 * 	Author : Amit Kashte
 */
class Timetable extends Generic{

	function __construct() {
		parent::__construct();
		$this->load->model('Mdl_master');	
  }

  /**
   *  Listing Page
   */
  function listPage(){
    $this->adminSession('4');

    $template = 'admin';
    $data['scriptFile'] = 'master-timetable';
    $data['viewFile'] = 'timetable/list';
    $data['module'] = "master";
    echo Modules::run('template/'.$template, $data);
  }

  /**
   *  Get records
   */
  function page(){
    $records = $this->Mdl_master->get_datatables("timetable");

    $data = array();
    $no = $_POST['start']; 
    
    $admin_session = $this->session->userdata('admin');
    $timetable_counter = $this->Mdl_master->countRecords('timetable_master',array('1'=>'1'));

    foreach ($records as $val){
      $row = array();

      $url = base_url().'master/timetable/update/'.$val->id;
      // if($admin_session['is_superadmin'] == 'yes'){
      //   $row[] = '<a class="btn btn-rounded btn-outline-success" href="'.$url.'"><i class="ti-pencil-alt"></i></a> <button class="btn btn-rounded btn-outline-danger" onclick="deleteRecord('.$val->id.')" ><i class="ti-trash"></i></button>';
      // }else{
      //   $row[] = '<a class="btn btn-rounded btn-outline-success" href="'.$url.'"><i class="ti-pencil-alt"></i></a>';
      // }

      $row[] = '<a class="btn btn-rounded btn-outline-success" href="'.$url.'"><i class="ti-pencil-alt"></i></a>';

      if($val->status == '1'){
        $row[] = '<span class="badge badge-success">ACTIVE</span>';
      }else{
        $row[] = '<span class="badge badge-danger">INACTIVE</span>';
      }

      $select = '<select name="serial" id="'.$val->id.'" onchange="orderChange(this.id)" ><option value="NA">Select</option>';
      if($timetable_counter !== "NA"){ 
        for($count=1; $count <= $timetable_counter; $count++){ 
          if($count == $val->serial){ 
            $select .= "<option value='$count' selected >$count</option>";
          }else{
            $select .= "<option value='$count' >$count</option>";
          }
        } 
      } 
      $select .= '</select>';
      $row[] = $select;
      
      $row[] = $val->title;
      
      $row[] = date("d-m-Y",strtotime($val->created_at));
      $data[] = $row;
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Mdl_master->count_all("timetable"),
      "recordsFiltered" => $this->Mdl_master->count_filtered("timetable"),
      "data" => $data,
    );

    echo json_encode($output);
  }

  /**
   *  Add Timetable
   */
  function add(){
    $this->adminSession('4');

    $template = 'admin';
    $data['viewFile'] = "timetable/add";
    $data['scriptFile'] = "master-timetable";
    $data['module'] = "master";
    
    echo Modules::run('template/'.$template, $data);
  }

  /**
   *  Add Action
   */
  function addAction(){
    $content = $this->input->post();

    $this->form_validation->set_rules('title','Title','trim|xss_clean|required',
    array(
      'required' => 'Title is required'
    ));

    if($this->form_validation->run($this) == FALSE){
      $errors = $this->form_validation->error_array();
      echo json_encode($errors); exit;
    }else{

      $admin_session = $this->session->userdata('admin');
      $counter = $this->Mdl_master->countRecords('timetable_master',array('1'=>'1'));

      $data = array(
        'serial' => $counter+1,
        'title' => strip_tags($content['title']),
        'admin_id' => $admin_session['admin_id'],
        'status' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'modified_at' => date('Y-m-d H:i:s')
      );
      $insert = $this->Mdl_master->insert("timetable_master", $data);

      echo json_encode(array("status"=>"success","title"=>"Success","icon"=>"success","message"=>'Timetable added successfully.',"redirect"=>'master/timetable/list')); exit;
    }
  }

  /**
   *  Update Status
   */
  function update($id){
    $this->adminSession('4');

    $result = $this->Mdl_master->retrieve("timetable_master",array("id"=>$id));

    if($result == "NA"){
      redirect('master/timetable/list','refresh');
    }else{

      $template = 'admin';
      $data['timetable'] = $result;
      $data['viewFile'] = "timetable/update";
      $data['scriptFile'] = "master-timetable";
      $data['module'] = "master";
      echo Modules::run('template/'.$template, $data);
    }
  }

  /**
   *  Update Status Action
   */
  function updateAction(){
    $content = $this->input->post();

    $this->form_validation->set_rules('title','Title','trim|xss_clean|required',
    array(
      'required' => 'Title is required'
    ));

    $this->form_validation->set_rules('status','Status','trim|xss_clean|required',
    array(
      'required' => 'Status is required'
    ));

    if($this->form_validation->run($this) == FALSE){
      $errors = $this->form_validation->error_array();
      echo json_encode($errors); exit;
    }else{

      $admin_session = $this->session->userdata('admin');
      $data = array(
        'title' => strip_tags($content['title']),
        'admin_id' => $admin_session['admin_id'],
        'status' => strip_tags($content['status']),
        'modified_at' => date('Y-m-d H:i:s')
      );

      $update = $this->Mdl_master->update("timetable_master", array("id"=>$content['timetableId']), $data);

      echo json_encode(array("status"=>"success","title"=>"Success","icon"=>"success","message"=>'Timetable updated successfully.',"redirect"=>'master/timetable/list')); exit;
    }
  }

  /**
   *  Update Order
   */
  function orderChangeAction(){
    $content = $this->input->post();
    $entityId = $content['id'];
    $newPosition = $content['position'] == "NA" ? null : $content['position'];

    $entity = $this->Mdl_master->retrieve("timetable_master",array("id"=>$entityId));

    if($entity !== "NA"){
      $oldPosition = $entity[0]->serial;
      if(is_null($oldPosition)){
        if(is_null($newPosition)){
         
        }else{
          if($this->Mdl_master->isExist("timetable_master",array("serial"=>$newPosition))){
            $get_entities = "SELECT * FROM timetable_master WHERE serial >= $newPosition AND  serial IS NOT null ";
            $entityArr = $this->Mdl_master->customQuery($get_entities);
    
            if($entityArr !== 'NA'){
              foreach($entityArr as $en){
                $updateData = array(
                  'serial' => $en->serial + 1
                );
                $updateRec = $this->Mdl_master->update("timetable_master",array("id"=>$en->id),$updateData); 
              }
            }
          }
          
          $updateData = array(
            'serial' => $newPosition,
          );
          $updateRec = $this->Mdl_master->update("timetable_master",array("id"=>$entityId),$updateData);
        }

      }else{
        if(is_null($newPosition)){
          $get_entities = "SELECT * FROM timetable_master WHERE serial > $oldPosition AND  serial IS NOT null ";
          $entityArr = $this->Mdl_master->customQuery($get_entities);
    
          if($entityArr !== 'NA'){
            foreach($entityArr as $en){
              $updateData = array(
                'serial' => $en->serial - 1
              );
              $updateRec = $this->Mdl_master->update("timetable_master",array("id"=>$en->id),$updateData); 
            }
          }
          
          $updateData = array(
            'serial' => $newPosition,
          );
          $updateRec = $this->Mdl_master->update("timetable_master",array("id"=>$entityId),$updateData);
        }else{
          if($oldPosition > $newPosition){
            $get_entities = "SELECT * FROM timetable_master WHERE serial >= $newPosition AND serial < $oldPosition AND  serial IS NOT null ";
            $entityArr = $this->Mdl_master->customQuery($get_entities);
      
            if($entityArr !== 'NA'){
              foreach($entityArr as $en){
                $updateData = array(
                  'serial' => $en->serial + 1
                );
                $updateRec = $this->Mdl_master->update("timetable_master",array("id"=>$en->id),$updateData); 
              }
            }
          }else{
            $get_entities = "SELECT * FROM timetable_master WHERE serial > $oldPosition AND serial <= $newPosition AND  serial IS NOT null ";
            $entityArr = $this->Mdl_master->customQuery($get_entities);
      
            if($entityArr !== 'NA'){
              foreach($entityArr as $en){
                $updateData = array(
                  'serial' => $en->serial - 1
                );
                $updateRec = $this->Mdl_master->update("timetable_master",array("id"=>$en->id),$updateData); 
              }
            }
          }

          $updateData = array(
            'serial' => $newPosition,
          );
          $updateRec = $this->Mdl_master->update("timetable_master",array("id"=>$entityId),$updateData);
        }
      }
    }
        
    echo json_encode(array("status"=>"success")); exit;
  }

  /**
   *  Delete Action
   */
  function deleteAction(){
    $entityId =$this->input->post('id');

    $entity = $this->Mdl_master->retrieve("timetable_master",array("id"=>$entityId));
    if($entity !== "NA"){
      if($entity[0]->serial !== null){
        $position = $entity[0]->serial;
        $get_entities = "SELECT * FROM timetable_master WHERE serial > $position AND serial IS NOT null ";
        $entityArr = $this->Mdl_master->customQuery($get_entities);

        if( $entityArr !== "NA" ){
          foreach($entityArr as $en){
            $updateData = array(
              'serial' => $en->serial - 1
            );
            $updateRec = $this->Mdl_master->update("timetable_master",array("id"=>$en->id),$updateData); 
          }
        }
      }
    
      $this->Mdl_master->delete('timetable_master',array("id"=>$entityId));
    }
    echo json_encode(array("status"=>"success")); exit;
  }
}
