<?php 

class Pricelist_master extends Template
{
	public function __construct()
		{
			parent::__construct();
      
	      	$this->db->cache_delete_all();
			header('Last-Modified: '.gmdate("D, d M Y H:i:s") . ' GMT');
			header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
			header("Pragma: no-cache");
			header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
	   
	      	$this->load->model('master/pricelist_model'); 	      	
	      	$this->load->model('master/department_model'); 
	      	$this->load->model('common_model');
	      
			if (!$this->session->userdata("id"))
			{
				redirect('login','refresh');
				exit;
			}	   
			
			$this->heading('pricelist Master');
			$this->set_title("pricelist");   
		}
	public function index()
		{
			$this->assets_load->add_css(array(base_url('wp-includes/vendors/dataTable/datatables.min.css')),"header");
			$this->assets_load->add_js(array(base_url('wp-includes/vendors/dataTable/datatables.min.js')),"footer"); 
	 		
			
			$this->assets_load->add_js(array(base_url('assets/js/jquery.form.js')),"header"); 

	     
			$this->set_title("Pricelist Master");
			$this->session->set_userdata("ADMIN_CURRENT_PAGE","Pricelist Master");
			$data = array();
			$data['active']="Pricelist";
			$data['sub']="Pricelist";


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
					'column_name'=>'Name',
					'column_style'=>'style=""',
					'column_width'=>'width="10%"',
					'column_class'=>'', 
					'column_sortable'=>'true',
					),
				array(
					'column_name'=>'Departments',
					'column_style'=>'style=""',
					'column_width'=>'width="10%"',
					'column_class'=>'', 
					'column_sortable'=>'true',
					),
				array(
					'column_name'=>'Unit',
					'column_style'=>'style=""',
					'column_width'=>'width="10%"',
					'column_class'=>'', 
					'column_sortable'=>'true',
					),
				array(
					'column_name'=>'MPR',
					'column_style'=>'style=""',
					'column_width'=>'width="10%"',
					'column_class'=>'', 
					'column_sortable'=>'true',
					),
				array(
					'column_name'=>'PTR',
					'column_style'=>'style=""',
					'column_width'=>'width="10%"',
					'column_class'=>'', 
					'column_sortable'=>'true',
					),
				array(
					'column_name'=>'PTS',
					'column_style'=>'style=""',
					'column_width'=>'width="10%"',
					'column_class'=>'', 
					'column_sortable'=>'true',
					),
				array(
					'column_name'=>'TAX',
					'column_style'=>'style=""',
					'column_width'=>'width="10%"',
					'column_class'=>'', 
					'column_sortable'=>'true',
					),
				array(
					'column_name'=>'HSN',
					'column_style'=>'style=""',
					'column_width'=>'width="10%"',
					'column_class'=>'', 
					'column_sortable'=>'true',
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
				'grid_name'  			=>'Pricelist',
				'grid_dt_url'			=>base_url('pricelist-list'),
				'grid_delete_url'		=>base_url('pricelist-delete/'),
				'grid_data_url'			=>base_url('pricelist-form/'),
				'grid_total_columns'	=>'3', 	
				'grid_columns'			=>$grid_columns,
				'grid_order_by'			=>'2',
				'grid_order_by_type'	=>'ASC',
				'grid_tbl_name'			=>'pricelist', 
				'grid_tbl_display_name'	=>'pricelist', 
				'grid_tbl_length'		=>'10', 
				'grid_tbl_style'		=>$table_style,
				'grid_tbl_class'		=>$table_class,

				);

			$data['grid']=$grid_data; 

			$data ["page_title"]	= "pricelist";
			$data ["department"] =  $this->department_model->get_all_department_list();

			// $extra_pages=array();
			$extra_pages=array( 
			'master/pricelist/pricelist_add_modal'
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

		$aColumns		= array("c.id","c.name","c.unit","c.mrp","c.ptr","c.pts","c.netrate","c.tax","c.hsn","c.notes","d.d_name");
		$aColumns_where = array("c.id","c.name","c.unit","c.mrp","c.ptr","c.pts","c.netrate","c.tax","c.hsn","c.notes","d.d_name");
	
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
			
			$this->pricelist_model->set_fields(array('limit_start'=>$start_index,'limit_length'=>$end_index,'search_text'=>$sWhere,"order_by"=>$sOrder));		
	
			$pricelist_info 	= $this->pricelist_model->get_all_pricelist();
			
			$pricelist_results 		= $pricelist_info['result'];
			$data					= array();
			$row_dt				= array();
			$i=$this->input->get('iDisplayStart');

			foreach( $pricelist_results as $row )
			{
				++$i;	
				$row_dt   = array();
				$row_dt[] = $i;
				$row_dt[] =	$row->name;	   
				$row_dt[] =	$row->d_name;	   
				$row_dt[] =	$row->unit;	   
				$row_dt[] =	$row->mrp;	   
				$row_dt[] =	$row->ptr;	   
				$row_dt[] =	$row->pts;	   
				$row_dt[] =	$row->tax;	   
				$row_dt[] =	$row->hsn;	   
				 
				$statusEdit='<a  href="#" onclick="edit('.$row->id.')" title="Edit Pricelist"    style="overflow: hidden; position: relative;" class="btn btn-outline-primary waves-effect waves-light"><img style="height: 20px; width: 20px;" src="'.base_url("assets/icons/pen.svg").'" ></a>';

				$row_dt[] =$statusEdit.' &nbsp;<a href="#" onclick="myDelete('.$row->id.')"  title="Delete Pricelist" style="overflow: hidden; position: relative;" class="btn btn-outline-danger waves-effect waves-light"><img style="height: 20px; width: 20px;" src="'.base_url("assets/icons/trash.svg").'" ></a>';
				$data[] = $row_dt;
					
			}
		
			$response['iTotalRecords'] 			= $pricelist_info['total'];
			$response['iTotalDisplayRecords'] 	= $pricelist_info['total'];
			$response['aaData']					 	= $data;
			echo json_encode($response);
			// echo "<pre>";print_r($response);exit;

	}
	public function loadForm($id)
		{
			/*pricelist*/
			$this->pricelist_model->set_fields(array('id'=>$id)); 
			$data['pricelist_details'] = $this->pricelist_model->get_pricelist_detail(); 

			/*Department list*/	
	       	$data ["department"] =  $this->department_model->get_all_department_list();


		 	return $this->load->view('master/pricelist/pricelist_edit_modal',$data);
		}
 	
 	public function save()
 		{
 			$id=xss_clean(trim($this->input->post("id")));
			$mode=xss_clean(trim($this->input->post("mode")));
			$fields=array("name","unit","mrp","ptr","pts","netrate","tax","hsn","notes","department");
			$data=array();
			$error="";
			
			foreach ($fields as $field) 
			{
				$data[$field]=$this->input->post($field);
			}
			 
			$config=array(
						array(
							'field'=>'name',
							'label'=>'name',
							'rules'=>'trim|required'
						),
						array(
							'field'=>'unit',
							'label'=>'Unit',
							'rules'=>'trim|required'
						),
						array(
							'field'=>'mrp',
							'label'=>'M.R.P',
							'rules'=>'trim|required'
						),
						array(
							'field'=>'ptr',
							'label'=>'PTR',
							'rules'=>'trim|required'
						),
						array(
							'field'=>'netrate',
							'label'=>'Net Rate',
							'rules'=>'trim|required'
						),
						array(
							'field'=>'tax',
							'label'=>'Tax',
							'rules'=>'trim|required'
						),
						array(
							'field'=>'hsn',
							'label'=>'HSN',
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
					$pricelist_id = $this->common_model->save('pricelist');
					if ($pricelist_id) 
					{
						$array=array();
						$array['status']=200;
						$array['message']="Pricelist Added Successfully....";
						echo json_encode($array);
						exit;
					}
					else
					{
						$array=array();
						$array['status']=500;
						$array['message']="Pricelist Adding Failed....";
						echo json_encode($array);	
						exit;
					}
			  	}
				else
			  	{ 
			  		$this->pricelist_model->set_fields(['id'=>$id]);
			  		
				   	$where = array('id'=>$id);
				   	$this->common_model->set_fields($data);				   	
				   	$this->common_model->updateData('pricelist',$where);

				   	$array=array();
					$array['status']=200;
					$array['message']="Pricelist Updated Successfully...."; 
					echo json_encode($array);
					exit;
			  	}
			}
 		}	

 	public function delete_pricelist($id)
		{
			$this->common_model->set_fields(array('is_delete'=>1));
			$this->common_model->updateData('pricelist',array('id'=>$id));
			
			if( $this->input->is_ajax_request() )
			{
				$arr 					= array();
				$arr['status']			= 200;			
				$arr['message']		= "Pricelist Deleted Successfully";
				
				echo json_encode($arr);
				return;
			}
			else
			{
				$this->session->set_flashdata('success',"Pricelist Deleted Successfully.");
				redirect($_SERVER["HTTP_REFERER"]);
			}			
		}
}