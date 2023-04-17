<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Template  {
		
		public function __construct()
			{
				parent::__construct();
		  
			  	$this->db->cache_delete_all();
				header('Last-Modified: '.gmdate("D, d M Y H:i:s") . ' GMT');
				header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
				header("Pragma: no-cache");
				header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
		    
			  	$this->load->model('common_model');
			  
				// if (!$this->session->userdata("id"))
				// {
				// 	redirect('login','refresh');
				// 	exit;
				// }	   
				
				$this->heading('Admin Master');
				$this->set_title("Admin");   
			}
	public function index()
	{
		$this->view('master/demo/demo');
	}
	public function privacy_policy()
	{
		$this->load->view('front/privacy_policy');
	}
}
