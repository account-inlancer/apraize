<?php 

class Gallery_master extends Template
{
	public function __construct()
		{
			parent::__construct();
      
	      	$this->db->cache_delete_all();
			header('Last-Modified: '.gmdate("D, d M Y H:i:s") . ' GMT');
			header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
			header("Pragma: no-cache");
			header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
	   
	      	$this->load->model('master/gallery_model'); 
	      	$this->load->model('master/department_model'); 
	      	$this->load->model('common_model');
	      
			if (!$this->session->userdata("id"))
			{
				redirect('login','refresh');
				exit;
			}	   
			
			$this->heading('Gallery Master');
			$this->set_title("Gallery");   
		}
	public function index()
		{
			$this->assets_load->add_css(array(base_url('wp-includes/vendors/dataTable/datatables.min.css')),"header");
			$this->assets_load->add_js(array(base_url('wp-includes/vendors/dataTable/datatables.min.js')),"footer"); 
	 		
			
			$this->assets_load->add_js(array(base_url('assets/js/jquery.form.js')),"header"); 

	     
			$this->set_title("Gallery Master");
			$this->session->set_userdata("ADMIN_CURRENT_PAGE","Gallery Master");
			$data = array();
			$data['active']="Gallery";
			$data['sub']="gallery";


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
					'column_name'=>'Gallery Name',
					'column_style'=>'style=""',
					'column_width'=>'width="30%"',
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
					'column_width'=>'width="30%"',
					'column_class'=>'', 
					'column_sortable'=>'false',
					),
				array(
					'column_name'=>'Action',
					'column_style'=>'style=""',
					'column_width'=>'width="15%"',
					'column_class'=>' ', 
					'column_sortable'=>'false',
					),
				);

			$table_style='border-collapse: collapse; border-spacing: 0; width: -webkit-fill-available;';
			$table_class='table table-striped nowrap table-bordered dt-responsive nowrap'; 
			$grid_data=array(
				'grid_name'  		=>'Gallery',
				'grid_dt_url'		=>base_url('gallery-list'),
				'grid_delete_url'	=>base_url('gallery-delete/'),
				'grid_data_url'		=>base_url('gallery-form/'),
				'grid_total_columns'	=>'3', 	
				'grid_columns'		=>$grid_columns,
				'grid_order_by'		=>'2',
				'grid_order_by_type'=>'ASC',
				'grid_tbl_name'=>'gallery', 
				'grid_tbl_display_name'=>'Gallery', 
				'grid_tbl_length'=>'10', 
				'grid_tbl_style'=>$table_style,
				'grid_tbl_class'=>$table_class,

				);

			$data['grid']=$grid_data; 

			$data ["page_title"]	= "Gallery";

		   	$data ["department"] = $this->department_model->get_all_department_list();
			// $extra_pages=array();
			$extra_pages=array( 
			'master/gallery/gallery_add_modal'
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

		$aColumns		= array("c.id ","c.name","file_name","department.d_name");
		$aColumns_where = array("c.id","c.name","file_name","department.d_name");
	
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
			
			$this->gallery_model->set_fields(array('limit_start'=>$start_index,'limit_length'=>$end_index,'search_text'=>$sWhere,"order_by"=>$sOrder));		
	
			$gallery_info 	= $this->gallery_model->get_all_gallery();
			
			$gallery_results 		= $gallery_info['result'];
			$data					= array();
			$row_dt				= array();
			$i=$this->input->get('iDisplayStart');
			// echo "<pre>";print_r($gallery_info);exit;
			foreach( $gallery_results as $row )
			{
				++$i;	
				$row_dt   = array();
				$row_dt[] = $i;
				$row_dt[] =	$row->name;	
				$row_dt[] =	$row->d_name;	
				$image_url=base_url('assets/upload/gallery/thumb/'.$row->file_name);
				// if(@is_array(getimagesize($image_url))){
		            $gallery_image = $image_url;
		      //  } else {
		          //  $gallery_image = base_url('assets/logo.svg');   
		      //  }
		        $org_img = base_url('assets/upload/gallery/original/'.$row->file_name);
		        $row_dt[] = '<a href="'.$org_img.'" target="_blank" ><img class="find_center" src="'.$gallery_image.'"  style="height: 70px;border-radius:10px" ><a href="'.$org_img.'" target="_blank" > View Image </a> </a>';
      
				 
				$statusEdit='<a  href="#" onclick="edit('.$row->id.')" title="Edit gallery"    style="overflow: hidden; position: relative;" class="btn btn-outline-primary waves-effect waves-light"><img style="height: 20px; width: 20px;" src="'.base_url("assets/icons/pen.svg").'" ></a>';

				$row_dt[] =$statusEdit.' &nbsp;<a href="#" onclick="myDelete('.$row->id.')"  title="Delete gallery" style="overflow: hidden; position: relative;" class="btn btn-outline-danger waves-effect waves-light"><img style="height: 20px; width: 20px;" src="'.base_url("assets/icons/trash.svg").'" ></a>';
				$data[] = $row_dt;
					
			}
		
			$response['iTotalRecords'] 			= $gallery_info['total'];
			$response['iTotalDisplayRecords'] 	= $gallery_info['total'];
			$response['aaData']					 	= $data;
			echo json_encode($response);
			// echo "<pre>";print_r($response);exit;

	}
	public function loadForm($id)
		{
			/*gallery detials*/
			$this->gallery_model->set_fields(array('id'=>$id)); 
			$data['gallery_details'] = $this->gallery_model->get_gallery_detail(); 
			
			/*department Details*/
	       	$data ["department"] =  $this->department_model->get_all_department_list();

			/* For Image */
			if(!empty($data['gallery_details']['file_name'])){
			    $data['gallery_details']['file_name_url'] = base_url('assets/upload/gallery/thumb/'.$data['gallery_details']['file_name']);
			    // echo "<pre>";print_r($data['gallery_details']['file_name_url']);exit;
			}
		 	return $this->load->view('master/gallery/gallery_edit_modal',$data);
		}
 	
 	public function save()
 		{
 			$id=xss_clean(trim($this->input->post("id")));
			$mode=xss_clean(trim($this->input->post("mode")));
			$fields=array("name","department");
			$data=array();
			$error="";
			
			foreach ($fields as $field) 
			{
				$data[$field]=$this->input->post($field);
			}
			 
			$config=array(
						array(
							'field'=>'name',
							'label'=>'Name',
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
				if(!empty($_FILES) && array_key_exists("file_name", $_FILES) && $_FILES['file_name']["name"] !='')
				{
					$images_details = @getimagesize($_FILES["file_name"]["tmp_name"]);
	    			if($images_details[0] < 370)
	    			{
	    				$array=array();
						$array['status']=500; 
						$array['message']= "Image maximum width is 370";
						echo json_encode($array);
						exit;
	    			}
					$path = FCPATH.'/assets/upload/gallery/original/';
					$this->file_uploader->set_default_upload_path($path);				   
			 	 	if( $_FILES['file_name']['type'] == 'image/gif' ||  $_FILES['file_name']['type'] == 'image/jpg' || $_FILES['file_name']['type'] == 'image/jpeg' ||  $_FILES['file_name']['type'] == 'image/png')	 	
				 	{
				 		$_FILES['file_name']["name"] = str_replace(' ','_',$_FILES['file_name']["name"]);
						$file_name = $this->file_uploader->upload_image('file_name');
							
						if($file_name['status'] == 200)
						{
							$thumb_name = explode("/", $file_name [ "data" ]);
							if(!file_exists(FCPATH.'/assets/upload/gallery/thumb/'.$thumb_name[0]))
	   						{
	      						mkdir(FCPATH.'/assets/upload/gallery/thumb/'.$thumb_name[0]);
	      						chmod(FCPATH.'/assets/upload/gallery/thumb/'.$thumb_name[0],0777);
	   						}

	   						$this->load->library('image_lib');
							$config_manip = array(
				                  	'image_library' =>'gd2',
				                  	'library_path'  => '/usr/X11R6/bin/',
				                  	'source_image'  => FCPATH.'/assets/upload/gallery/original/'.$file_name [ "data" ],
				                  	'new_image'     => FCPATH.'/assets/upload/gallery/thumb/'.$thumb_name[0]."/".$thumb_name[1],
				                  	'maintain_ratio'=> true ,
				                  	'create_thumb'  => false ,
				                  	'width'         => 370,     	
			                ); 

				        	if(isset($_POST['current_picture']) && $_POST['current_picture'] != "")
		                  	{
		                  	    @unlink(FCPATH.'/assets/upload/gallery/original/'.$_POST['current_picture']);
		                  	    @unlink(FCPATH.'/assets/upload/gallery/thumb/'.$_POST['current_picture']);
		                  	}   
			                $this->image_lib->initialize($config_manip);
	   					  	$this->image_lib->resize();
	   				     	$errors = $this->image_lib->display_errors();
	   				     	$data['file_name'] = $file_name['data']; 	  	
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
 
		
			    	
				// $data['slug'] = $this->create_url_slug($data['title']); //for slug 
	            
				if($mode == 'add')
			 	{ 
			  		$this->common_model->set_fields($data);
					$gallery_id = $this->common_model->save('galleries');
					if ($gallery_id) 
					{
						$array=array();
						$array['status']=200;
						$array['message']="gallery Added Successfully....";
						echo json_encode($array);
						exit;
					}
					else
					{
						$array=array();
						$array['status']=500;
						$array['message']="gallery Adding Failed....";
						echo json_encode($array);
						exit;
					}
			  	}
				else
			  	{ 
			  		$this->gallery_model->set_fields(['id'=>$id]);
			  		
				   	$where = array('id'=>$id);
				   	$this->common_model->set_fields($data);				   	
				   	$this->common_model->updateData('galleries',$where);

				   	$array=array();
					$array['status']=200;
					$array['message']="gallery Updated Successfully...."; 
					echo json_encode($array);
					exit;
			  	}
			}
 		}	

 	public function delete_gallery($id)
		{
			$this->common_model->set_fields(array('is_delete'=>1));
			$this->common_model->updateData('galleries',array('id'=>$id));
			
			if( $this->input->is_ajax_request() )
			{
				$arr 					= array();
				$arr['status']			= 200;			
				$arr['message']		= "gallery Deleted Successfully";
				
				echo json_encode($arr);
				return;
			}
			else
			{
				$this->session->set_flashdata('success',"gallery Deleted Successfully.");
				redirect($_SERVER["HTTP_REFERER"]);
			}			
		}
}