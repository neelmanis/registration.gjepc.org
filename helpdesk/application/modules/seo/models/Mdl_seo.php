<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/models/Mdl_generic.php';

/**
 * 	Author : Amit Kashte
 */

class Mdl_seo extends Mdl_generic {

  /** 
   *  SEO
   */
  var $table_seo = "seo";
  var $column_order_seo = array(null,"page","meta_title"); 
  var $column_search_seo = array("page","meta_title","meta_description","meta_keywords"); 
  var $order_seo = array("seo_id" => "asc"); 

	function __construct(){
		parent::__construct();
	}
  
  /**
   *  SEO
   */
  public function _get_datatables_query_seo(){
    $this->db->from($this->table_seo);
    $i = 0;
  
    foreach ($this->column_search_seo as $item){
      if($_POST['search']['value']){
        
        if($i===0){
          $this->db->group_start(); 
          $this->db->like($item, $_POST['search']['value']);
        }else{
          $this->db->or_like($item, $_POST['search']['value']);
        }

        if(count($this->column_search_seo) - 1 == $i) 
          $this->db->group_end(); 
      }
      $i++;
    }
    
    if(isset($_POST['order'])){
      $this->db->order_by($this->column_order_seo[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }else if(isset($this->order_seo)){
      $order = $this->order_seo;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }
}