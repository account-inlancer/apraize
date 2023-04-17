<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends Template 
{ 
  public function __construct()
  {
    parent::__construct();
    $this->model('admin_model');
    $this->model('common_model');
  }


public function login()
  {
    // $_SESSION['DB_NAME']='';
    $this->set_title("Login | MyApp");
    $data=array();
    $this->load->view("authentication/login",$data);
  }

public function doLogin()
  {
    $fields = array ( "email","password");
    $data   = array();
    $error = "";  
    foreach( $fields as $field )
    {
      $data[$field] = trim($this->input->post($field));
    }

    $config = array(
          array(
                      'field'   => 'email', 
                      'label'   => 'User name', 
                      'rules'   => 'trim|required'
                  ),
                  array(
                      'field'   => 'password', 
                      'label'   => 'Password', 
                      'rules'   => 'trim|required'
                  )
              ); 

              $this->form_validation->set_rules($config);

        if ( $this->form_validation->run() == FALSE) 
        {
          $this->session->set_flashdata( "errors", validation_errors());  
          $this->session->set_flashdata( "login",$data);
          redirect('admin');
          return;
        }     
        else 
        {
          $data['password'] = hash('sha512',$data['password']);
          $this->admin_model->set_fields($data);
          $row = $this->admin_model->login();
          if ($row) 
            { 
              if($row['status'] == 0)
                {
                  $this->session->set_flashdata( "errors", "Your account is disable."); 
                  $this->session->set_flashdata( "login",$data);
                  redirect('login');     
                  return;   
                }           
              $this->session->set_userdata($row);
              redirect('main');
              return;
            }
            else
            {
              $this->session->set_flashdata("errors",get_message("authentication_login_error"));
              $this->session->set_flashdata("login",$data);
              redirect('login');
              return;
            }
          $this->session->set_userdata($row); 
          redirect('main');     
          return;
    // echo "<pre>"; print_r($row); exit;
        }
  }
  
public function logout()
  { 
    $this->load->dbutil(); 
        // Backup your entire database and assign it to a variable
        // $backup = $this->dbutil->backup(); 
        // Load the file helper and write the file to your server
        // $this->load->helper('file');
        // write_file('././assets/backup/mybackup'.date('m-d-Y_hia').'.zip', $backup);
    $this->session->sess_destroy();
    redirect("admin");  
  }

}
