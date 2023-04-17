<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class General extends Template{
	
public function __construct()
	{
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('dashboard/general_model');

		if (!$this->session->userdata("id"))
		{
			redirect('login','refresh');
			exit;
		}
		
	}

public function profile()
	{
		$this->set_title("Profile Management");
		$this->assets_load->add_js(array(base_url('assets/js/vendors/add.js')),"footer");
		$this->assets_load->add_js(array(base_url('assets/js/jquery.form.js')),"footer");
		$data = array();
		$data ["page_title"]= "Profile Management"; 
		$data['user_info']=$this->general_model->getProfileDetail();
		// echo "<pre>";print_r($data['user_info']);exit;
		
		$this->view('dashboard/profile',$data);
	}

public function saveNewPassword()
	{
		$id=xss_clean(trim($this->input->post("id")));
		$fields=array("old_password","password","confirm_password","email");
		$data=array();
		$error="";
		
		foreach ($fields as $field) 
		{
			$data[$field]=$this->input->post($field);
		}

		$config=array(
					array(
						'field'=>'old_password',
						'label'=>'Old Password',
						'rules'=>'trim|required'
					),
					array(
						'field'=>'password',
						'label'=>'New Password',
						'rules'=>'trim|required'
					),
					array(
						'field'=>'confirm_password',
						'label'=>'Confirm Password',
						'rules'=>'trim|required'
					)
				);

		$this->form_validation->set_rules($config);
		if ($this->form_validation->run()==FALSE) 
		{	
			// $this->session->set_flashdata("errors",validation_errors());
			$array=array();
			$array['status']=500;
			$error=validation_errors();
			$array['message']=$error;
			echo json_encode($array);
			exit;
		}
		else 
		{	
			$old_password = hash('sha512', $data["old_password"] );
			$this->general_model->set_fields(array("id"=>$id,"old_password"=>$old_password));
			$old_password = $this->general_model->isOldPasswordExists();
			if(!$old_password)
			{
				$array=array();
				$array['status']=500;
				$error="You have entered wrong password as Old Password";
				$array['message']=$error;
				echo json_encode($array);
				exit;		
			}

			if($data['password'] != $data['confirm_password'])
			{
				$array=array();
				$array['status']=500;
				$error="Your Confirm Password Is Not Matched";
				$array['message']=$error;
				echo json_encode($array);
				exit;		
			}
			
		   	$where = array('id'=>$id);
		   	$data["password"] = hash('sha512', $data["password"] );

		   	unset($data['old_password']);
		   	unset($data['confirm_password']);
		   	$this->common_model->set_fields($data);
		   	$this->common_model->updateData('users',$where);
		   	$array=array();
			$array['status']=200;
			$array['message']="Password Updated Successfully....";
			echo json_encode($array);
			exit;
			
		}
	}
}
?>