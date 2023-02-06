<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/models/Mdl_generic.php';

/**
 * 	Author : NEELMANI
 */

class Mdl_visitors extends Mdl_generic {
  function __construct() {
    parent::__construct();
  }

   /** 
   *  Pending Images List
   */
  var $table_all_visitors = "visitors";
  var $column_order_all_visitors = array("name","company","category","handover","status"); 
  var $column_search_all_visitors = array("company","name"); 
  var $order_all_visitors = array("created_at"=>"desc"); 
  
  public function _get_datatables_query_all_visitors(){
    $admin = $this->session->userdata('admin');
    $is_superadmin = $admin['is_superadmin'];
    $admin_id = $admin['admin_id'];

    if($this->input->post('vis_pan')){
      $this->db->like('pan_no', $this->input->post('vis_pan'));
    }

    if($this->input->post('vis_name')){
      $this->db->like('name', $this->input->post('vis_name'));
    }
    if($this->input->post('company_name')){
      $this->db->like('company', $this->input->post('company_name'));
    }
    if($this->input->post('category')){
      $this->db->where('category', $this->input->post('category'));
    }
    $this->db->from($this->table_all_visitors);
    $i = 0;
    if($is_superadmin == "N"  && $admin_id == 6){
      $this->db->where('category','P');
    } 
    if($is_superadmin == "N"  && $admin_id == 7){
      $this->db->where('category','OV');
    } 
    foreach ($this->column_search_all_visitors as $item){
      if($_POST['search']['value']){
        if($i===0){
          $this->db->group_start(); 
          $this->db->like($item, $_POST['search']['value']);
        }else{
          $this->db->or_like($item, $_POST['search']['value']);
        }
        if(count($this->column_search_all_visitors) - 1 == $i) 
          $this->db->group_end(); 
      }
      $i++;
    }
	
    if(isset($_POST['order'])){
      $this->db->order_by($this->column_order_all_visitors[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }else if(isset($this->order_all_visitors)){
      $order = $this->order_all_visitors;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }

  /** 
   *  Pending Images List
   */
  var $table_pending_images = "visitors";
  var $column_order_pending_images = array(null,"unique_code","company","name","post_date"); 
  var $column_search_pending_images = array("company","name"); 
  var $order_pending_images = array("post_date"=>"desc"); 

  public function _get_datatables_query_pending_images(){
    $this->db->from($this->table_pending_images);
    $i = 0;
    foreach ($this->column_search_pending_images as $item){
      if($_POST['search']['value']){
        if($i===0){
          $this->db->group_start(); 
          $this->db->like($item, $_POST['search']['value']);
        }else{
          $this->db->or_like($item, $_POST['search']['value']);
        }
        if(count($this->column_search_pending_images) - 1 == $i) 
          $this->db->group_end(); 
      }
      $i++;
    }
    if(isset($_POST['order'])){
      $this->db->order_by($this->column_order_pending_images[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }else if(isset($this->order_pending_images)){
      $order = $this->order_pending_images;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }


}