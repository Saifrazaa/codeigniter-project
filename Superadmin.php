<?php error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Superadmin extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		  $this->load->database();
          $this->load->library('session');
          $this->load->helper('form');
          $this->load->helper('url');

	}

	public function index() {
	
		 $email= $this->session->userdata("userid");
		if($email== ""){
			$this->session->flashdata('adminemail');
		$this->load->view('admin/pages-login');
		}else{
	    $this->load->model('admin/login');
		$data['totalteams'] = $this->login->totalteams($post);
		$data['totalplyers'] = $this->login->totalplyers($post);
		$data['totalgrounds'] = $this->login->totalgrounds($post);	
		$this->load->view('admin/header');
		$this->load->view('admin/index',$data);
		$this->load->view('admin/footer');
		}
	}
	public function login(){
		
		$post=$this->input->post();
		$admin_email = $post['admin_email'];
		$adminpass =  md5($post['admin_password']);
		$this->load->model('admin/login');
		$data = $this->login->singin($admin_email,$adminpass);
		
            $email = $data[0]['admin_email'];
            $password = $data[0]['admin_password'];
            $adminid = $data[0]['admin_id'];
            
	     if($admin_email== $email && $adminpass  == $password){
		
             
			
			 $this->session->set_userdata("userid",$email);
                         $this->session->set_userdata("apass",$password);
                         $this->session->set_userdata("aid",$adminid);
			//$this->index();
			
			$this->session->set_userdata("testSession",22);
						redirect('admin/Superadmin/');

			
			}
                        else {
                            
                            redirect('admin/Superadmin/');
                        }
		
		
		
		}
	public function suggestions() {
					
		
  //$this->load->view('admin/header');
  $this->load->model('Contactforms');
  $data['suggestions'] = $this->Contactforms->showsuggestions();
  $this->load->view('admin/header');
  $this->load->view('admin/suggestions',$data);
  $this->load->view('admin/footer');
 }
	public function suggestdelete($val) {
		
		$this->load->model('Contactforms');
		$this->Contactforms->deletesuggestion($val);
		redirect('admin/Superadmin/suggestions');
		//$this->load->view('admin/suggestions');
		//$this->load->view('admin/footer');
	}
	
                 public function logout(){

                $this->session->sess_destroy();
                redirect(base_url().'index.php/admin');
                                }
                                                   
                public function updatepassword(){

                 $this->load->view('admin/header');
                 $this->load->view('admin/updatepassword');
                 $this->load->view('admin/footer');

            }
			
	 public function admin_updatepassword(){
        $id = $this->session->userdata("aid");  
        $adminpass = $this->session->userdata("apass");  
        $post = $this->input->post();
     	$this->load->model('admin/login_model');
        
        if($adminpass == $post['oldpassword'] && $post['oldpassword'] !=''){
            
            $data = $this->login_model->update_adminPass($post,$id);
            
            if($data) {
                
                $this->session->set_flashdata("updatepasswordsuccess", "Your password has been updated Successfully");
                redirect(base_url() . 'index.php/admin');
            }
           
        }
        
        else {
                $this->session->set_flashdata("updatepassworderror", "Your previos password not matched if you forgot the password go into login panel click on recover password");
                redirect(base_url() . 'index.php/admin/Superadmin/updatepassword');
           
            
        }
        
        
    }
			
	
}


?>