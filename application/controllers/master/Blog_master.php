<?php 

class Blog_master extends Template
{
	public function __construct()
		{
			parent::__construct();
      
	      	$this->db->cache_delete_all();
			header('Last-Modified: '.gmdate("D, d M Y H:i:s") . ' GMT');
			header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
			header("Pragma: no-cache");
			header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
	   
	      	$this->load->model('master/blog_model'); 
	      	$this->load->model('master/department_model'); 
	      	$this->load->model('common_model');
	      
			if (!$this->session->userdata("id"))
			{
				redirect('login','refresh');
				exit;
			}	   
			
			$this->heading('Blog Master');
			$this->set_title("Blog");   
		}
	public function index()
		{
			$this->assets_load->add_css(array(base_url('wp-includes/vendors/dataTable/datatables.min.css')),"header");
			$this->assets_load->add_js(array(base_url('wp-includes/vendors/dataTable/datatables.min.js')),"footer"); 
	 		
			
			$this->assets_load->add_js(array(base_url('assets/js/jquery.form.js')),"header"); 

	     
			$this->set_title("Blog Master");
			$this->session->set_userdata("ADMIN_CURRENT_PAGE","Blog Master");
			$data = array();
			$data['active']="Blog";
			$data['sub']="blog";


			/*Here we will use grid's data for making it dynamic*/

			$grid_columns=array(
				array(
					'column_name'=>'No',
					'column_style'=>'style=""',
					'column_width'=>'width="5%"',
					'column_class'=>'class="text-center"', 
					'column_sortable'=>'false', 
					),
				array(
					'column_name'=>'Blog Title',
					'column_style'=>'style=""',
					'column_width'=>'width="20%"',
					'column_class'=>'', 
					'column_sortable'=>'true',
					),
				array(
					'column_name'=>'Department',
					'column_style'=>'style=""',
					'column_width'=>'width="20%"',
					'column_class'=>'', 
					'column_sortable'=>'true',
					),
				array(
					'column_name'=>'Image',
					'column_style'=>'style=""',
					'column_width'=>'width="20%"',
					'column_class'=>'', 
					'column_sortable'=>'false',
					),
				array(
					'column_name'=>'Action',
					'column_style'=>'style=""',
					'column_width'=>'width="10%"',
					'column_class'=>' ', 
					'column_sortable'=>'false',
					),
				);

			$table_style='border-collapse: collapse; border-spacing: 0; width: -webkit-fill-available;';
			$table_class='table table-striped nowrap table-bordered dt-responsive nowrap'; 
			$grid_data=array(
				'grid_name'  				=>'Blog',
				'grid_dt_url'				=>base_url('blog-list'),
				'grid_delete_url'			=>base_url('blog-delete/'),
				'grid_data_url'				=>base_url('blog-form/'),
				'grid_total_columns'		=>'3', 	
				'grid_columns'				=>$grid_columns,
				'grid_order_by'				=>'2',
				'grid_order_by_type'		=>'ASC',
				'grid_tbl_name'				=>'blog', 
				'grid_tbl_display_name'		=>'blog', 
				'grid_tbl_length'			=>'10', 
				'grid_tbl_style'			=>$table_style,
				'grid_tbl_class'			=>$table_class,
				);

			$data['grid']=$grid_data; 

			$data ["page_title"]	= "Blog";

		   	$data ["department"] = $this->department_model->get_all_department_list();
			// $extra_pages=array();
			$extra_pages=array( 
			'master/blog/blog_add_modal'
		);
			$data ["extra_pages"]=$extra_pages;
			$this->view('master/dt_master',$data);
		}

	public function dt_list( $id = -1 )
	{
			
	   	$start_index 	= $this->input->get('iDisplayStart')!=null?xss_clean(trim($this->input->get('iDisplayStart'))):0;
		$end_index		= $this->input->get('iDisplayLength')?xss_clean(trim($this->input->get('iDisplayLength'))):10;		
		$search_text	= $this->input->get('sSearch')?xss_clean(trim($this->input->get('sSearch'))):''; 
		$sOrder 			= "";

		$aColumns		= array("c.blog_id ","c.title","c.post_image","d.d_name");
		$aColumns_where = array("c.blog_id","c.title","c.post_image","d.d_name");
	
		if (  $this->input->get('iSortCol_0') !== FALSE )
		{		
			for ( $i=0 ; $i<intval( $this->input->get('iSortingCols') ) ; $i++ )
			{
				if ( $this->input->get( 'bSortable_'.intval($this->input->get('iSortCol_'.$i)) ) == "true" )
				{
					$sOrder .= $aColumns[ intval( ( $_GET['iSortCol_'.$i] ) ) ]."
					 	".$this->mres( $_GET['sSortDir_'.$i] ) .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
		}
		

		$sWhere 	= " ";
		for ( $i=0 ; $i<count($aColumns_where) ; $i++ )
		{
			if ( isset($_GET['bSearchable_'.$i])  && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
			{
				if( $sWhere != '' )
				{
					$sWhere .= " AND ";
				}
				$sWhere .= $aColumns_where[$i]." = '".$this->mres($_GET['sSearch_'.$i])."' ";
			}
		}
		
		if( isset($_GET['sSearch'])  )
		{					
			$sWhere .= ' AND ( ';	
			$or		= '';
			foreach( $aColumns_where as $row )
			{					
				$sWhere .= $or.$row." LIKE '%".str_replace("'","\\\\\''",$this->mres($_GET['sSearch']))."%'";
				if( $or == ''  )
				{
					$or 		= ' OR ';
				}
				
			}	
			$sWhere .= ')';
		}

		if(!empty($_GET['dep_id'])){
			$sWhere .= " AND department = ".$_GET['dep_id'];
		}
			
			$this->blog_model->set_fields(array('limit_start'=>$start_index,'limit_length'=>$end_index,'search_text'=>$sWhere,"order_by"=>$sOrder));		
	
			$blog_info 	= $this->blog_model->get_all_blog();
			
			$blog_results 		= $blog_info['result'];
			$data					= array();
			$row_dt				= array();
			$i=$this->input->get('iDisplayStart');
			// echo "<pre>";print_r($blog_info);exit;
			foreach( $blog_results as $row )
			{
				++$i;	
				$row_dt   = array();
				$row_dt[] = $i;
				$row_dt[] =	$row->title;	
				$row_dt[] =	$row->d_name;	

				$image_url=base_url('assets/upload/blog/thumb/'.$row->post_image); 
				if(@is_array(getimagesize($image_url))){
		            $blog_image = $image_url;
		        } else {
		            $blog_image = base_url('assets/logo.svg');   
		        }
		        $org_img = base_url('assets/upload/blog/original/'.$row->post_image);
		        $row_dt[] = '<a href="'.$org_img.'" target="_blank" > <img class="find_center" src="'.$blog_image.'"  style="height: 70px;border-radius:10px" ><a href="'.$org_img.'" target="_blank" > View Image </a>';  
         
				 
				$statusEdit='<a  href="#" onclick="edit('.$row->blog_id.')" title="Edit Blog"    style="overflow: hidden; position: relative;" class="btn btn-outline-primary waves-effect waves-light"><img style="height: 20px; width: 20px;" src="'.base_url("assets/icons/pen.svg").'" ></a>';

				$row_dt[] =$statusEdit.' &nbsp;<a href="#" onclick="myDelete('.$row->blog_id.')"  title="Delete Blog" style="overflow: hidden; position: relative;" class="btn btn-outline-danger waves-effect waves-light"><img style="height: 20px; width: 20px;" src="'.base_url("assets/icons/trash.svg").'" ></a>';
				$data[] = $row_dt;
			}
		
			$response['iTotalRecords'] 			= $blog_info['total'];
			$response['iTotalDisplayRecords'] 	= $blog_info['total'];
			$response['aaData']					 	= $data;
			echo json_encode($response);
			// echo "<pre>";print_r($response);exit;

	}
	public function loadForm($id)
		{
			/*blog detials*/
			$this->blog_model->set_fields(array('id'=>$id)); 
			$data['blog_details'] = $this->blog_model->get_blog_detail(); 

			/*department Details*/
	       	$data ["department"] =  $this->department_model->get_all_department_list();

			/* For Image */
			if(!empty($data['blog_details']['post_image'])){
			    $data['blog_details']['post_image_url'] = base_url('assets/upload/blog/thumb/'.$data['blog_details']['post_image']);
			    // echo "<pre>";print_r($data['blog_details']['post_image_url']);exit;
			} else {
			    $data['blog_details']['post_image_url'] = base_url('assets/icona.png');  
			}
			
		 	return $this->load->view('master/blog/blog_edit_modal',$data);
		}
 	
 	public function save()
 		{
 			$id=xss_clean(trim($this->input->post("id")));
			$mode=xss_clean(trim($this->input->post("mode")));
			$fields=array("title","slug","body","department");
			$data=array();
			$error="";
			
			foreach ($fields as $field) 
			{
				$data[$field]=$this->input->post($field);
			}
			 
			$config=array(
						array(
							'field'=>'title',
							'label'=>'title',
							'rules'=>'trim|required'
						),
						
					);		
			 

			$this->form_validation->set_rules($config);
			if ($this->form_validation->run()==FALSE) 
			{	 
				$array=array();
				$array['status']=500; 
				$array['message']= validation_errors();
				echo json_encode($array);
				exit;
			}
			else 
			{   

				/*For Image */
				if(!empty($_FILES) && array_key_exists("post_image", $_FILES) && $_FILES['post_image']["name"] !='')
				{
					$images_details = @getimagesize($_FILES["post_image"]["tmp_name"]);
	    			if($images_details[0] < 370)
	    			{
	    				$array=array();
						$array['status']=500; 
						$array['message']= "Image maximum width is 370";
						echo json_encode($array);
						exit;
	    			}
					$path = FCPATH.'/assets/upload/blog/original/';
					$this->file_uploader->set_default_upload_path($path);				   
			 	 	if( $_FILES['post_image']['type'] == 'image/gif' ||  $_FILES['post_image']['type'] == 'image/jpg' || $_FILES['post_image']['type'] == 'image/jpeg' ||  $_FILES['post_image']['type'] == 'image/png')	 	
				 	{
				 		$_FILES['post_image']["name"] = str_replace(' ','_',$_FILES['post_image']["name"]);
						$post_image = $this->file_uploader->upload_image('post_image');
							
						if($post_image['status'] == 200)
						{
							$thumb_name = explode("/", $post_image [ "data" ]);
							if(!file_exists(FCPATH.'/assets/upload/blog/thumb/'.$thumb_name[0]))
	   						{
	      						mkdir(FCPATH.'/assets/upload/blog/thumb/'.$thumb_name[0]);
	      						chmod(FCPATH.'/assets/upload/blog/thumb/'.$thumb_name[0],0777);
	   						}

	   						$this->load->library('image_lib');
							$config_manip = array(
				                  	'image_library' =>'gd2',
				                  	'library_path'  => '/usr/X11R6/bin/',
				                  	'source_image'  => FCPATH.'/assets/upload/blog/original/'.$post_image [ "data" ],
				                  	'new_image'     => FCPATH.'/assets/upload/blog/thumb/'.$thumb_name[0]."/".$thumb_name[1],
				                  	'maintain_ratio'=> true ,
				                  	'create_thumb'  => false ,
				                  	'width'         => 370,     	
			                ); 

				        	if(isset($_POST['current_picture']) && $_POST['current_picture'] != "")
		                  	{
		                  	    @unlink(FCPATH.'/assets/upload/blog/original/'.$_POST['current_picture']);
		                  	    @unlink(FCPATH.'/assets/upload/blog/thumb/'.$_POST['current_picture']);
		                  	}   
			                $this->image_lib->initialize($config_manip);
	   					  	$this->image_lib->resize();
	   				     	$errors = $this->image_lib->display_errors();
	   				     	$data['post_image'] = $post_image['data']; 	  	
						}
					}		 	
					else
					{  
						$error=get_message("valid_profile_image");
						$array=array();
						$array['status']=500; 
						$array['message']=  $error;
						echo json_encode($array);
						exit;
					}
				}
				/*End*/
 
		
			    	
				$data['slug'] = $this->create_url_slug($data['title']); //for slug 
	            
				if($mode == 'add')
			 	{ 
			 		 
			  		$this->common_model->set_fields($data);
					$blog_id = $this->common_model->save('blog');
					if ($blog_id) 
					{
						$array=array();
						$array['status']=200;
						$array['message']="Blog Added Successfully....";
						echo json_encode($array);
						exit;
					}
					else
					{
						$array=array();
						$array['status']=500;
						$array['message']="Blog Adding Failed....";
						echo json_encode($array);
						exit;
					}
			  	}
				else
			  	{ 
			  		$this->blog_model->set_fields(['id'=>$id]);
			  		
				   	$where = array('blog_id'=>$id);
				   	$this->common_model->set_fields($data);				   	
				   	$this->common_model->updateData('blog',$where);

				   	$array=array();
					$array['status']=200;
					$array['message']="Blog Updated Successfully...."; 
					echo json_encode($array);
					exit;
			  	}
			}
 		}	

 	public function delete_blog($id)
		{
			$this->common_model->set_fields(array('is_delete'=>1));
			$this->common_model->updateData('blog',array('blog_id'=>$id));
			
			if( $this->input->is_ajax_request() )
			{
				$arr 					= array();
				$arr['status']			= 200;			
				$arr['message']		= "Blog Deleted Successfully";
				
				echo json_encode($arr);
				return;
			}
			else
			{
				$this->session->set_flashdata('success',"Blog Deleted Successfully.");
				redirect($_SERVER["HTTP_REFERER"]);
			}			
		}
}