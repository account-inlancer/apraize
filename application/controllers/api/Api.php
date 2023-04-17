<?php 

class Api extends MY_Controller
{
	public function __construct()
		{
			parent::__construct();
      
	      	$this->db->cache_delete_all();
			header('Last-Modified: '.gmdate("D, d M Y H:i:s") . ' GMT');
			header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
			header("Pragma: no-cache");
			header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
	    	
		 	$this->load->model('api/api_model');
	      	$this->load->model('common_model');
	        
		}
 		
 		/*-----------------Login----------------*/
 		public function login()
 		{ 
			$fields=array("uname","password");
			$data=array();
			$error="";

			foreach ($fields as $field) 
			{
				$data[$field]=$this->input->post($field);
			}
			 
			$config=array(
						array(
							'field'=>'uname',
							'rules'=>'trim|required'
						),
						array(
							'field'=>'password',
							'rules'=>'trim|required'
						),
					);		
			$response=[]; 
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run()==FALSE) 
			{	 
			 	$status = ['data_code'=>2002];  
			}
			else 
			{   
				$status = ['data_code'=>2001]; 
			 	$data['login_api'] = $this->api_model->get_all_appusers_list();
			 	foreach ($data['login_api'] as $key => $value) {
			 		$id = $value->id;
			 		$a =$value->A;
			 		if($a==1){
						array_push($response,array('u_id'=>$id,'dept_id'=>'0'));
					}
					$b = $value->B;
					if($b==1){
						array_push($response,array('u_id'=>$id,'dept_id'=>'1'));
					}
					$c = $value->C;
					if($c==1){
						array_push($response,array('u_id'=>$id,'dept_id'=>'2'));
					}
					$d = $value->D;
					if($d==1){
						array_push($response,array('u_id'=>$id,'dept_id'=>'3'));
					}
			 	}
			}

			$return_data = [
				'response_code' 	=>$status,
				'response'			=>$response
			];	
			echo json_encode($return_data);
 		}

 		/*-----------------------pricelist-----------------*/
 		public function pricelist_api()
 		{ 
			$fields=array("name","unit","mrp","ptr","pts","netrate","tax","hsn","notes");
			$data=array();
			$error="";

			foreach ($fields as $field) 
			{
				$data[$field]=$this->input->post($field);
			}
			 
			$config=array(
						array(
							'field'=>'name',
							'rules'=>'trim|required'
						),
					);		
			$response=[]; 
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run()==FALSE) 
			{	 
			 	$status = ['data_code'=>2002];  
			}
			else 
			{   
				$status = ['data_code'=>2001]; 
			 	$data['pricelist_api'] = $this->api_model->get_all_pricelist_list();
			 	foreach ($data['pricelist_api'] as $key => $value) {
			 		array_push($response,array('id'=>$value->id,'name'=>$value->name,'unit'=>$value->unit,'mrp'=>$value->mrp,'ptr'=>$value->ptr,'pts'=>$value->pts,'netrate'=>$value->netrate,'tax'=>$value->tax,'hsn'=>$value->hsn,'notes'=>$value->notes));		 		
			 	}
			}

			$return_data = [
				'response_code' 	=>$status,
				'response'			=>$response
			];	
			echo json_encode($return_data);
 		}

 		/*-----------------------blog----------------------*/
 		public function blog_api()
 		{ 
			$fields=array("title","body","image");
			$data=array();
			$error="";

			foreach ($fields as $field) 
			{
				$data[$field]=$this->input->post($field);
			}
			 
			$config=array(
						array(
							'field'=>'title',
							'rules'=>'trim|required'
						),
					);		
			$response=[]; 
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run()==FALSE) 
			{	 
			 	$status = ['data_code'=>2002];  
			}
			else 
			{   
				$status = ['data_code'=>2001]; 
			 	$data['blog_api'] = $this->api_model->get_all_blog_list();
			 	foreach ($data['blog_api'] as $key => $value) {
			 		$img = base_url('assets/upload/blog/thumb/'.$value->post_image);
			 		array_push($response,array('id'=>$value->blog_id,'title'=>$value->title,'body'=>$value->body,'image'=>$img));
			 	}
			}

			$return_data = [
				'response_code' 	=>$status,
				'response'			=>$response
			];	
			echo json_encode($return_data);
 		}		

 		/*------------------------galleries----------------------*/
 		public function galleries_api()
 		{ 
			$fields=array("name","image");
			$data=array();
			$error="";

			foreach ($fields as $field) 
			{
				$data[$field]=$this->input->post($field);
			}
			 
			$config=array(
						array(
							'field'=>'name',
							'rules'=>'trim|required'
						),
					);		
			$response=[]; 
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run()==FALSE) 
			{	 
			 	$status = ['data_code'=>2002];  
			}
			else 
			{   
				$status = ['data_code'=>2001]; 
			 	$data['galleries_api'] = $this->api_model->get_all_galleries_list();
			 	foreach ($data['galleries_api'] as $key => $value) {
			 		$img = base_url('assets/upload/gallery/thumb/'.$value->file_name);
			 		array_push($response,array('id'=>$value->id,'name'=>$value->name,'image'=>$img));
			 	}
			}

			$return_data = [
				'response_code' 	=>$status,
				'response'			=>$response
			];	
			echo json_encode($return_data);
 		}	

 		/*------------------------dept----------------------*/
 		public function dept_api()
 		{ 
			$status = ['data_code'=>2001]; 
		 	$dept_api = $this->api_model->get_all_dept_list();

			$return_data = [
				'response_code' 	=>$status,
				'response'			=>$dept_api
			];	
			echo json_encode($return_data);
 		}	
	

 	 
}