<?php 

class Department_master extends Template
{
	public function __construct()
		{
			parent::__construct();
      
	      	$this->db->cache_delete_all();
			header('Last-Modified: '.gmdate("D, d M Y H:i:s") . ' GMT');
			header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
			header("Pragma: no-cache");
			header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
	   
	      	$this->load->model('master/department_model'); 
	      	$this->load->model('common_model');
	      
			if (!$this->session->userdata("id"))
			{
				redirect('login','refresh');
				exit;
			}	   
			
			$this->heading('Department Master');
			$this->set_title("Department");   
		}
	public function index()
		{
			$this->assets_load->add_css(array(base_url('wp-includes/vendors/dataTable/datatables.min.css')),"header");
			$this->assets_load->add_js(array(base_url('wp-includes/vendors/dataTable/datatables.min.js')),"footer"); 
	 		
			
			$this->assets_load->add_js(array(base_url('assets/js/jquery.form.js')),"header"); 

	     
			$this->set_title("Department Master");
			$this->session->set_userdata("ADMIN_CURRENT_PAGE","department Master");
			$data = array();
			$data['active']="Department";
			$data['sub']="Department";


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
					'column_name'=>'Department Name',
					'column_style'=>'style=""',
					'column_width'=>'width="30%"',
					'column_class'=>'', 
					'column_sortable'=>'true',
					),
				array(
					'column_name'=>'Department shortname',
					'column_style'=>'style=""',
					'column_width'=>'width="30%"',
					'column_class'=>'', 
					'column_sortable'=>'true',
					),
				array(
					'column_name'=>'Action',
					'column_style'=>'style=""',
					'column_width'=>'width="25%"',
					'column_class'=>' ', 
					'column_sortable'=>'false',
					),
				);

			$table_style='border-collapse: collapse; border-spacing: 0; width: -webkit-fill-available;';
			$table_class='table table-striped nowrap table-bordered dt-responsive nowrap'; 
			$grid_data=array(
				'grid_name'  			=>'Department',
				'grid_dt_url'			=>base_url('department-list'),
				'grid_delete_url'		=>base_url('department-delete/'),
				'grid_data_url'			=>base_url('department-form/'),
				'grid_total_columns'	=>'3', 	
				'grid_columns'			=>$grid_columns,
				'grid_order_by'			=>'2',
				'grid_order_by_type'	=>'ASC',
				'grid_tbl_name'			=>'department', 
				'grid_tbl_display_name'	=>'Department', 
				'grid_tbl_length'		=>'10', 
				'grid_tbl_style'		=>$table_style,
				'grid_tbl_class'		=>$table_class,

				);

			$data['grid']=$grid_data; 

			$data ["page_title"]	= "department";

			// $extra_pages=array();
			$extra_pages=array( 
			'master/department/department_add_modal'
		);
			$data ["extra_pages"]=$extra_pages;

			$this->view('master/department/dt_master',$data);
		}

	public function dt_list( $id = -1 )
	{
			
	   	$start_index 	= $this->input->get('iDisplayStart')!=null?xss_clean(trim($this->input->get('iDisplayStart'))):0;
		$end_index		= $this->input->get('iDisplayLength')?xss_clean(trim($this->input->get('iDisplayLength'))):10;		
		$search_text	= $this->input->get('sSearch')?xss_clean(trim($this->input->get('sSearch'))):''; 
		$sOrder 			= "";

		$aColumns		= array("c.d_id ","c.d_name","shortname");
		$aColumns_where = array("c.d_id","c.d_name","shortname");
	
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
			
			$this->department_model->set_fields(array('limit_start'=>$start_index,'limit_length'=>$end_index,'search_text'=>$sWhere,"order_by"=>$sOrder));		
	
			$department_info 	= $this->department_model->get_all_department();
			
			$department_results 		= $department_info['result'];
			$data					= array();
			$row_dt				= array();
			$i=$this->input->get('iDisplayStart');

			foreach( $department_results as $row )
			{
				++$i;	
				$row_dt   = array();
				$row_dt[] = $i;
				$row_dt[] =	$row->d_name;	   
				$row_dt[] =	$row->shortname;	   
				 
				$statusEdit='<a  href="#" onclick="edit('.$row->d_id.')" title="Edit department"    style="overflow: hidden; position: relative;" class="btn btn-outline-primary waves-effect waves-light"><img style="height: 20px; width: 20px;" src="'.base_url("assets/icons/pen.svg").'" ></a>';

				$row_dt[] =$statusEdit.' &nbsp;<a href="#" onclick="myDelete('.$row->d_id.')"  title="Delete department" style="overflow: hidden; position: relative;" class="btn btn-outline-danger waves-effect waves-light"><img style="height: 20px; width: 20px;" src="'.base_url("assets/icons/trash.svg").'" ></a>';
				$data[] = $row_dt;
					
			}
		
			$response['iTotalRecords'] 			= $department_info['total'];
			$response['iTotalDisplayRecords'] 	= $department_info['total'];
			$response['aaData']					 	= $data;
			echo json_encode($response);
			// echo "<pre>";print_r($response);exit;

	}
	public function loadForm($id)
		{
			$this->department_model->set_fields(array('id'=>$id)); 
			$data['department_details'] = $this->department_model->get_department_detail(); 

		 	return $this->load->view('master/department/department_edit_modal',$data);
		}
 	
 	public function save()
 		{
 			$id=xss_clean(trim($this->input->post("id")));
			$mode=xss_clean(trim($this->input->post("mode")));
			$fields=array("d_name","shortname");
			$data=array();
			$error="";
			
			foreach ($fields as $field) 
			{
				$data[$field]=$this->input->post($field);
			}
			 
			$config=array(
						array(
							'field'=>'d_name',
							'label'=>'name',
							'rules'=>'trim|required'
						),
						array(
							'field'=>'shortname',
							'label'=>'shortname',
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
				// $data['slug'] = $this->create_url_slug($data['title']); //for slug 
	            
				if($mode == 'add')
			 	{ 
			 		 
			  		$this->common_model->set_fields($data);
					$department_id = $this->common_model->save('department');
					if ($department_id) 
					{
						$array=array();
						$array['status']=200;
						$array['message']="department Added Successfully....";
						echo json_encode($array);
						exit;
					}
					else
					{
						$array=array();
						$array['status']=500;
						$array['message']="department Adding Failed....";
						echo json_encode($array);	
						exit;
					}
			  	}
				else
			  	{ 
			  		$this->department_model->set_fields(['d_id'=>$id]);
			  		
				   	$where = array('d_id'=>$id);
				   	$this->common_model->set_fields($data);				   	
				   	$this->common_model->updateData('department',$where);

				   	$array=array();
					$array['status']=200;
					$array['message']="Department Updated Successfully...."; 
					echo json_encode($array);
					exit;
			  	}
			}
 		}	

 	public function delete_department($id)
		{
			$this->common_model->set_fields(array('is_delete'=>1));
			$this->common_model->updateData('department',array('d_id'=>$id));
			
			if( $this->input->is_ajax_request() )
			{
				$arr 					= array();
				$arr['status']			= 200;			
				$arr['message']		= "department Deleted Successfully";
				
				echo json_encode($arr);
				return;
			}
			else
			{
				$this->session->set_flashdata('success',"Department Deleted Successfully.");
				redirect($_SERVER["HTTP_REFERER"]);
			}			
		}
}