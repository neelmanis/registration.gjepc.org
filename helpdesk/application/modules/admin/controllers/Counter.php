<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'modules/generic/controllers/Generic.php';

/**
 * 	Author : NEEL
 */
class Counter extends Generic{
	function __construct() {
		parent::__construct();
		$this->load->model('Mdl_admin');
	}

  /**
   *  Total Ticket count
   */
	function tickets($param=""){ 
    if($param){ 
      $tickets = $this->Mdl_admin->countRecords("tickets",array());
    } else {
      $tickets = $this->Mdl_admin->countRecords("tickets",array());
    }
	//echo $this->db->last_query(); exit;
    return $tickets;
	}

	/**
   *  Total Open Ticket count
   */
   
	function ticketStatus($param) {
	  if($param){
        $openTickets = $this->Mdl_admin->countRecords("tickets",array("status_id"=>$param));
      }else{
        $openTickets = $this->Mdl_admin->countRecords("tickets",array("1"=>"1"));
      }
      return $openTickets;
	}
	
	function getChartData(){
		$exportQuerys = "SELECT DATE(created_at) AS created_date FROM tickets group by created_at order by created_at ASC";	
		$dataTickets = $this->Mdl_admin->customQuery($exportQuerys);
		return $dataTickets;
			/*foreach ($dataTickets as $tkt){
				$date[] = $tkt->created_date;
				$totalCount[] = $tkt->totalCount;
			}
			
			$data = array(
				'date' => $date,
				'totalCount' => $totalCount
			);
			echo json_encode($data); */
	}
	
	function getOpenTicketData(){
		$exportQuerys = "SELECT count(*) as 'countx',DATE(created_at) AS created_date FROM tickets where status_id='1' group by created_at order by created_at ASC";	
		$openDataTickets = $this->Mdl_admin->customQuery($exportQuerys);
		return $openDataTickets;
	}
	
	function getPendingTicketData(){
		$exportQuerys = "SELECT count(*) as 'countx',DATE(created_at) AS created_date FROM tickets where status_id='2' group by created_at order by created_at ASC";	
		$openDataTickets = $this->Mdl_admin->customQuery($exportQuerys);
		return $openDataTickets;
	}
	
	function getResolvedTicketData(){
		$exportQuerys = "SELECT count(*) as 'countx',DATE(created_at) AS created_date FROM tickets where status_id='3' group by created_at order by created_at ASC";	
		$openDataTickets = $this->Mdl_admin->customQuery($exportQuerys);
		return $openDataTickets;
	}
	
	function getClosedTicketData(){
		$exportQuerys = "SELECT count(*) as 'countx',DATE(created_at) AS created_date FROM tickets where status_id='4' group by created_at order by created_at ASC";	
		$openDataTickets = $this->Mdl_admin->customQuery($exportQuerys);
		return $openDataTickets;
	}
	

}