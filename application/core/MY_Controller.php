<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
	Date 			: 12/09/2017
	Developed By 	:	Pradip Dobariya 
	About Class		: This class will helps to develop master template concept easily
	Class	purpose	: This class contain most frequently usefull functions and template configuration,
						  This class will to helps achieve reuse concept.
						  
	How to use		:
			--For Beginner
						: step 1: Create new controller_name.php on application/controller
						  step 2: class Controller_name extends Template
						  step 3: //Template view call
						  			 $this->view('view_name',$data);
			--Upload Image
						: Just call upload_file()		 	 
			
*/


/********Base class..********/
class MY_Controller extends CI_Controller {

	public $_default_template_name = "template" ; 
	 
	//Initialize
	public function __construct()
	{
        	parent::__construct();
	}

	public function create_url_slug($string)
		{
			$slug=strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $string));
			return $slug;
		}
	
	public function update_stock_entry($data)
		{
			$result  = $this->db->query(" 
				SELECT ".$data['stock_column']."
				FROM ".$data['table_name']."  
				WHERE ".$data['where_column']."='".$data['where_value']."'") ; 
			if ($result->result_id->num_rows > 0)
			{
				$old_stock = $result->row_array()[$data['stock_column']];		
				$new_stock = $data['add_stock_qty']+$old_stock; 

				$this->db->where(
					array(
						$data['where_column']	=>	$data['where_value']  
					)
				); 
				
				$this->db->update(
					$data['table_name'],
					array(
						$data['stock_column']	=>	$new_stock
					)
				);

				return $new_stock;
			} 
		}
}


/********Derived class..********/
class Template extends MY_Controller {

	protected $_title			= "";
	protected $_footer		= array();
	protected $_header		= array();
	protected $_meta_keywords = "";
	protected $_meta_description = "";
	protected $_footer_path = "blocks/footer";
	protected $_header_path	="blocks/header";
	

	public function __construct()
	{
    	parent::__construct();
		
		$this->load->library('parser');
		$this->load->library('assets_load');
		$this->load->helper('message');
		$this->_title = $this->config->item("site_name");
		
	}

	public function status_changer($table_name, $column_name, $where_to_change, $input_data)
    {
    	$data = array( $column_name => $input_data );
	   	$where = array('id' => $where_to_change);
	   	$this->common_model->set_fields($data);
	   	$this->common_model->updateData($table_name, $where);
    }
    

	public function heading($head)
	{
		$this->session->set_flashdata("head",$head);
	}

	/* <optional>	Set browser Title*/
	public function set_title($title)	
	{
		if ( $title != '' )
		{
			$this->_title	= $title." | ".$this->config->item("site_name");
		}
	}
	
	/* <optional>	Set Another Template*/
	public function set_template($template_name)	
	{
		if ( $template_name != '' )
		{
			$this->_default_template_name	= $template_name;
		}
	}

	/* <optional>	Set another Footer*/
	public function set_footer_path ( $footer_path )
	{
		$this->_footer_path = $footer_path;
	}

	/*	<optional> Set Footer */
	public function set_footer ( $footer )
	{
		$this->_footer	= $footer;
	}
	
	
	
	/* <optional>	Set Header*/
	public function set_header_path ( $header_path )
	{
		$this->_header_path = $header_path;
	}

	/*	<optional> Set Header */
	public function set_header ( $header )
	{
		$this->_header	= $header;
	}
	
	public function set_meta_keywords($meta_keywords)
	{
		if($meta_keywords !='' )
		{
			$this->_meta_keywords	= $meta_keywords;
		}else{
			$this->_meta_keywords	= $this->config->item("meta_keywords");
		}
	}
	public function set_meta_description ($meta_description)
	{
		if($meta_description !='' )
		{
			$this->_meta_description	= $meta_description;
		}else{
			$this->_meta_description	= $this->config->item("meta_description");
		}
	}
	
	public function send_phone_message($mobile_number,$message)
	{
		$mobile_number=$query->row_array()['phone_no'];
		$otp=$query->row_array()['order_otp'];
	    $username="MGST-LITE";  
		$password="MGST-LITE@2019" ; 
		$message="OTP ".$otp." For Confirm Order no #".$query->row_array()['order_id'];  
		$sender="SHOPCL";  
		
		$url="encreta.bulksms5.com/sendmessage.php?user=".urlencode($username)."&password=".urlencode($password)."&mobile=".urlencode($mobile_number)."&message=".urlencode($message)."&sender=".urlencode($sender)."&type=".urlencode('3'); 
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$curl_scraped_page = curl_exec($ch);
		curl_close($ch); 
	}

	/* use this file for insert content on view
	*/
	public function view( $view_file_name, $data = array() )
	{
			
		$template_data = array();
		$template_data ['title'] 	= $this->_title;
		
		$template_data ['meta_keywords'] 	= $this->_meta_keywords;
		$template_data ['meta_description'] 	= $this->_meta_description;
	   	$template_data ["header"] 	= $this->load->view( $this->_header_path, array_merge( $data, $template_data ),TRUE );
		$template_data ["content"]  = $this->load->view( $view_file_name, array_merge( $data, $template_data ),TRUE );
		$template_data ['footer'] 	= $this->load->view ( $this->_footer_path, $this->_footer,TRUE );
					
		
		$this->parser->parse( $this->_default_template_name, $template_data );
	}
	
	
	/*
	* --Upload Image--
		arguments 
			1) Field name
			2) Upload path
	*/	
	public function upload_image($field_name,$file_clone_path = '/uploads/')
	{
		return $this->file_upload( $field_name, 'gif|jpg|png', $file_clone_path );
	} 
	
	public function get_post_values($keys)
	{
		$returnArray = array();
		foreach( $keys as $k => $field )
		{
			$returnArray[$field] = xss_clean( trim($this->input->post($field)) );
		}
		return $returnArray;
	} 
	
	//check and return 
	public function is_session_active( $redirect_enable = false )
	{
		
		if ( ! $this->session->userdata('id')  )
		{
			if ( $redirect_enable )
				redirect('');
			return false;
		}	
		return $this->session->userdata('id');
	}
	
	public function encrypt( $password )
	{
		//$str = do_hash($str); // SHA1
		
		return do_hash($password, 'SHA1'); // MD5 	
	} 

	/*Return  Json Encode Data With Url*/
	public function maro_jawab($status,$msg='',$url='')
		{   
			
			/*
				success=200
				failure=500
				error=500
				missing=404
			*/ 

			$array=array();
			$array['status']=$status; 
			$array['message']=$msg;
			$array['rtn_url']=$url;
			echo json_encode($array);
			return;
		}

	/*-----Upload Other file----
			arguments 
					1) Field name
					2) Upload path
	*/	
	public function upload_file($field_name,$file_clone_path = '/uploads/')
	{
		return $this->file_upload( $field_name, 'txt|pdf|doc', $file_clone_path );
	} 

	//After logout use this function to clear cache	
	public function clear_cache()
	{
		//$this->cache->clean();
		$this->db->cache_delete_all();
		
		header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");	
	}
		
	/*
	* Function for upload any types of file 
	*/
	private function file_upload( $field_name, $allowed_type='gif|jpg|png' ,$file_clone_path = '/uploads/' )
	{
		//Initailize
		$config['upload_path'] = $file_clone_path;
		$config['allowed_types'] = $allowed_type;
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		
		//Assign file name
		if ( $this->get_file_name ( $field_name ) )
		{
			$config ['file_name']  = $this->get_file_name ( $field_name ) ; 
		}
		return 	array("status"=>"404");	
		
		$this->load->library('upload', $config);

		//Uploading process
		if ( ! $this->upload->do_upload($field_name) ) //File upload fail
		{
			$error = array('error' => $this->upload->display_errors());

			return array_merge( array("status"=>"500"), $error );
		}
		else		//File upload success
		{
			return array_merge( array("status"=>"200"), $error );
			return $this->upload->data();
		}	
	}
	
	
	public function required_field(  $fields,$all=false )
	{
		$error = '';
		foreach( $fields as $field )
		{
				if ( trim( $this->input->post($field) )=='' )
				{
					$error = "<div>".$field ." field is required. </div>";
					if ( $all == false )
						break;
				} 			
		}	
		return $error;
	}
	

	public function required_field_advance_validation(  $fields, $pre_msg='', $post_msg=' is required.' )
	{
		//print_r( $fields ); 
		$error = '';
		foreach( $fields as $field )
		{
				//print_r( $field['field'] ); 
				if ( trim( $this->input->post( $field['field']  ) ) =='' )
				{
					$error .= "<div>".$pre_msg.$field['label'] .$post_msg."</div>";
				}			
		}
	
		return $error;

	}
	
	public function createPDF($fileName,$html) {
        ob_start(); 
        
        // Include the main TCPDF library (search for installation path).
         
        $this->load->library('Pdf');
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('MGST-LITE');
        $pdf->SetTitle('MGST-LITE');
        $pdf->SetSubject('MGST-LITE');
        $pdf->SetKeywords('MGST-LITE');
    
        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
    
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
    
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);
    
        // set auto page breaks
        //$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetAutoPageBreak(TRUE, 0);
    
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }       
    
        // set font
        $pdf->SetFont('dejavusans', '', 10);
    
        // add a page
        $pdf->AddPage();
    
        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');
    
        // reset pointer to the last page
        $pdf->lastPage();       
        ob_end_clean();
        //Close and output PDF document
        $pdf->Output($fileName, 'F');        
    }
	
	public function setemail()
    {
        $email="xyz@gmail.com";
        $subject="some text";
        $message="some text";
        $this->sendEmail($email,$subject,$message);
    }
    
    public function sendEmail($email,$subject,$message,$attachPath='')
    { 
    	$this->load->library('email');
        $this->email->set_header('MIME-Version', '1.0' . "\r\n");
        $this->email->set_header('Content-type', 'text/html; charset=iso-8859-1' . "\r\n");
        $this->email->set_newline("\r\n");
        $this->email->from('export@agrishfood.com'); 
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($message);

        if(isset($attachPath) && $attachPath!=''){
            $this->email->attach($attachPath);    
        } 
        if($this->email->send())
        {}
        else
        { show_error($this->email->print_debugger()); } 
    }

	/*Get current path*/
	
	public function get_current_url()
	{
		$protocol 		= ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		//$server_name 	= $_SERVER['HTTP_HOST'].'/'.ltrim($_SERVER['REQUEST_URI'], '/');
		$server_name 	= ltrim($_SERVER['REQUEST_URI'], '/');
		return 	($protocol.$server_name);
	}	
	
	
	/*
	* File name Generator  	
	*/
	private function get_file_name ( $field_name )
	{
		//$ext = end(explode(".", $_FILES [ $field_name ] ['name']));
		if( !file_exists( $_FILES[$field_name] ['tmp_name']) || !is_uploaded_file ( $_FILES[$field_name]['tmp_name']) )
		{
			return false;
		}
		return rand(0000,1111).$_FILES [ $field_name ] ['name'];	
	}
	
	public function sendTextOtp($mobile_no,$otp,$message,$type='3')
	{ 
	    $username="MGST-LITE";  
		$password="MGST-LITE@2019" ;  
		$sender="SHOPCL";   
		$url="encreta.bulksms5.com/sendmessage.php?user=".urlencode($username)."&password=".urlencode($password)."&mobile=".urlencode($mobile_number)."&message=".urlencode($message)."&sender=".urlencode($sender)."&type=".urlencode('3'); 
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$curl_scraped_page = curl_exec($ch);
		curl_close($ch);  
	}
	
	public function mres($value)
	{
	    $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
	    $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
	
	    return str_replace($search, $replace, $value);
	}

	public function model($model_name)
	{
		$this->load->model($model_name);
	}
	public function convert_number($number)
	{
		if (($number < 0) || ($number > 999999999)) {
			throw new Exception("Number is out of range");
		}
		$Gn = floor($number / 1000000);
		/* Millions (giga) */
		$number -= $Gn * 1000000;
		$kn = floor($number / 1000);
		/* Thousands (kilo) */
		$number -= $kn * 1000;
		$Hn = floor($number / 100);
		/* Hundreds (hecto) */
		$number -= $Hn * 100;
		$Dn = floor($number / 10);
		/* Tens (deca) */
		$n = $number % 10;
		/* Ones */
		$res = "";
		if ($Gn) {
			$res .= $this->convert_number($Gn) .  "Million";
		}
		if ($kn) {
			$res .= (empty($res) ? "" : " ") .$this->convert_number($kn) . " Thousand";
		}
		if ($Hn) {
			$res .= (empty($res) ? "" : " ") .$this->convert_number($Hn) . " Hundred";
		}
		$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
		$tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
		if ($Dn || $n) {
			if (!empty($res)) {
				$res .= " and ";
			}
			if ($Dn < 2) {
				$res .= $ones[$Dn * 10 + $n];
			} else {
				$res .= $tens[$Dn];
				if ($n) {
					$res .= "-" . $ones[$n];
				}
			}
		}
		if (empty($res)) {
			$res = "zero";
		}
		return $res;
	}


 






}

