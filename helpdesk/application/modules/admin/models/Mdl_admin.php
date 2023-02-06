<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/models/Mdl_generic.php';

/**
 * 	Author : Amit Kashte
 */

class Mdl_admin extends Mdl_generic {
  function __construct() {
    parent::__construct();
  }

  /**
   *  Admin master
   */
  var $table_admin = 'admin_master';
  var $column_order_admin = array(null,'status','contact_name','email_id','password','role',null); 
  var $column_search_admin = array('contact_name'); 
  var $order_admin = array("id" => "asc"); 

  public function _get_datatables_query_admin_master(){
    $this->db->from($this->table_admin);
    // $this->db->where("is_admin","N");
    
    $i = 0;
    foreach ($this->column_search_admin as $item){
      if($_POST['search']['value']){
        
        if($i===0){
          $this->db->group_start(); 
          $this->db->like($item, $_POST['search']['value']);
        }else{
          $this->db->or_like($item, $_POST['search']['value']);
        }

        if(count($this->column_search_admin) - 1 == $i) 
          $this->db->group_end(); 
      }
      $i++;
    }
  
    if(isset($_POST['order'])){
      $this->db->order_by($this->column_order_admin[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }else if(isset($this->order_admin)){
      $order = $this->order_admin;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }

  /**
   *  Admin role master
   */
  var $table_admin_roles = 'admin_roles_master';
  var $column_order_admin_roles = array(null,null,"name","created_at"); 
  var $column_search_admin_roles = array("name"); 
  var $order_admin_roles = array("created_at" => "desc"); 

  public function _get_datatables_query_admin_roles(){
    $this->db->from($this->table_admin_roles);
    
    $i = 0;

    foreach ($this->column_search_admin_roles as $item){
      if($_POST['search']['value']){
        
        if($i===0){
          $this->db->group_start(); 
          $this->db->like($item, $_POST['search']['value']);
        }else{
          $this->db->or_like($item, $_POST['search']['value']);
        }

        if(count($this->column_search_admin_roles) - 1 == $i) 
          $this->db->group_end(); 
      }
      $i++;
    }
  
    if(isset($_POST['order'])){
      $this->db->order_by($this->column_order_admin_roles[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }else if(isset($this->order_admin_roles)){
      $order = $this->order_admin_roles;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }
}