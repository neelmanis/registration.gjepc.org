<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function test_redis()
	{
		$this->load->library('redis');
		$redis = $this->redis->config();


		/*
		* Check key is exist in redis server
		*/
		
		//echo $checkExist = $redis->exists('786458452');

		/*
     	** Set OR Update perticular key data 
     	*/
		//$get = $redis->set('key',"value");

 		/*
     	** Get perticular key data 
     	*/
		// $get = $redis->get('786458452');
		// $get = json_decode($get);
		// echo "<pre>"; print_r($get);
         
		/*
		** Print all keys
		*/ 
		$keys = $redis->keys('*');
		print_r($keys);
	
	}

}
