<?php 

class Migration extends Template
{
	public function __construct()
		{
			parent::__construct();
      
	      	$this->db->cache_delete_all();
			header('Last-Modified: '.gmdate("D, d M Y H:i:s") . ' GMT');
			header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
			header("Pragma: no-cache");
			header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
	   
	      	$this->load->model('common_model');
	      	$this->load->model('migration_model');

	      
			if (!$this->session->userdata("id"))
			{
				redirect('login','refresh');
				exit;
			}	   
			
			$this->heading('Gallery Master');
			$this->set_title("Gallery");   
		}

		public function gallery($department)
		{
			$data['migration'] = $this->migration_model->get_gallery_data($department);
			// echo "<pre>";print_r($data['migration']);exit;
			foreach ($data['migration'] as $key => $value) {
				unset($value->id);
				$value->file_name = "0/".$value->file_name;

				$this->common_model->set_fields($value);
				$migration_id = $this->common_model->save('galleries');
			}
		}
		public function pricelist($department)
		{
			// echo "<pre>";print_r($department);exit;
			$data['migration_pricelist'] = $this->migration_model->get_pricelist_data($department);

			// echo "<pre>";print_r($data['migration_pricelist']);exit;

			foreach ($data['migration_pricelist'] as $key => $value) {
				unset($value->id);
				$result = $this->db->query('SELECT d_id FROM department WHERE shortname = "'.$department.'" AND is_delete = 0 ')->row();

				$value->department = $result->d_id;

				$this->common_model->set_fields($value);
				$this->common_model->save('pricelist');
			}
		}
		public function blog($department)
		{
			// echo "<pre>";print_r($department);exit;
			$data['migration_blog'] = $this->migration_model->get_blog_data($department);

			// echo "<pre>";print_r($data['migration_blog']);exit;

			foreach ($data['migration_blog'] as $key => $value) {
				unset($value->blog_id);
				$value->department = "1";
				// echo "<pre>";print_r($value->blog_id);exit;

				$this->common_model->set_fields($value);
				$this->common_model->save('blog');
			}
		}

		public function thumb_generation($page = 1)
		{
			$limit = 30;
			$offset = $limit * ($page - 1);

			$migration_thumb = $this->migration_model->get_all_gallery_data($limit,$offset);

			$error = [];

			foreach ($migration_thumb as $key => $value) {
				$this->load->library('image_lib');
				$config_manip = array(
	                  	'image_library' =>'gd2',
	                  	'library_path'  => '/usr/X11R6/bin/',
	                  	'source_image'  => FCPATH.'/assets/upload/gallery/original/'.$value->file_name,
	                  	'new_image'     => FCPATH.'/assets/upload/gallery/thumb/'.$value->file_name,
	                  	'maintain_ratio'=> true ,
	                  	'create_thumb'  => false ,
	                  	'width'         => 370,     	
	            );

				if(!file_exists(FCPATH.'/assets/upload/gallery/thumb/'.$value->file_name))
				{
		            $this->image_lib->initialize($config_manip);
				  	$this->image_lib->resize();
				}

		     	$error[] = $this->image_lib->display_errors();
			}

	     	echo '<pre>';
	     	print_r($error);
	     	exit;
		}
}