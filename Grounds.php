<?php
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');
class Grounds extends CI_Controller {

				public function __construct() {
				parent::__construct();
				
				// Load form helper library
				$this->load->helper('form');
				$this->load->database();
				 $this->load->helper(array('form', 'url'));
				// Load form validation library
				$this->load->library('form_validation');
				//load image of user
				// $this->load->library('upload');
				// Load session library
	               $this->load->library('session');
	              //$this->load->helper('url');
	               // Load database
	              $this->load->model('admin/Ground_model','groundsdata');
	                 }
	
	                 public function index()
	                 {
					  
	                  }
					  public function addGround(){
						  
						  $id=$this->session->userdata("userid");
                          if ($id == NULL) {
	                       redirect(base_url().'index.php/admin/');
                             }else{
						  
						  $data['teams']= $this->groundsdata->team();
						  $this->load->view('admin/header');
						  $this->load->view('admin/addGround',$data);
						  $this->load->view('admin/footer');
							 }
						  }
						  
					  public function location_state(){
						   $id=$this->session->userdata("userid");
                          if ($id == NULL) {
	                     redirect(base_url().'index.php/admin'); 
                             }else{
						  $this->load->view('admin/header');
						  $this->load->view('admin/location_state');
						  $this->load->view('admin/footer');
							 }
						  }
						  public function addlocation(){
							  $post  = $this->input->post();
							   $data= $this->groundsdata->addlocation($post);
							 
						   $this->load->view('admin/header');
						  $this->load->view('admin/location_state');
						  $this->load->view('admin/footer');
							  
							  }
							  
							   public function province(){
								    $id=$this->session->userdata("userid");
                          if ($id == NULL) {
	                     redirect(base_url().'index.php/admin'); 
                             }else{
						 
						  $this->load->view('admin/header');
						  $this->load->view('admin/province');
						  $this->load->view('admin/footer');
							 }
								  }
						      
							public function groundadd(){
									 
							$post  = $this->input->post();
							
                                                        
                                                        $image =$_FILES['groundimg']['name'];
                                                        
                                                   
                                                         if($image ==''){
                                                            $data= $this->groundsdata->groundadd($post);
							
                                                                if($data){
                                                                $this->session->set_flashdata("Record","Ground  is inserted Successfully.");
                                                                        redirect('admin/Grounds/ViewGround');
                                                                                 }else{
                                                                $this->session->set_flashdata("Record","please change the name of Ground  ! Ground is Already Exits With this name.");
                                                                        redirect('admin/Grounds/addGround');
                                                                                 }
                                                        }
                                                        else{
                                                            
                                                        $config['encrypt_name'] = TRUE;
                                                        $config['upload_path'] = './uploads';
                                                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                                        $config['max_size']  = '1024';
                                                        $config['max_width']  = '1024';
                                                        $config['max_height'] = '768';

                                                        $this->load->library('upload', $config);
                                                       
                                                         if ( ! $this->upload->do_upload('groundimg')) {

                                                            $this->session->set_flashdata('ok','Please upload image size not more than 1MB');
                                                            redirect('admin/Grounds/addGround'); 		
                                                            exit;						
                                                            }
                                                            
                                                        else {
                                                            
                                                            $data= $this->groundsdata->groundadd($post,$image);
							
                                                                if($data){
                                                                $this->session->set_flashdata("Record","Ground  is inserted Successfully.");
                                                                        redirect('admin/Grounds/ViewGround');
                                                                                 }else{
                                                                $this->session->set_flashdata("Record","please change the name of Ground  ! Ground is Already Exits With this name.");
                                                                        redirect('admin/Grounds/addGround');
                                                                                 }
                                                        
                                                        }                   
                                                                                 
                                                                                 
                                                                                 
                                                                                 }
                                                        
						 }
									 
						public function ViewGround(){
										 
						$this->load->view('admin/header');
						$data['totalGrounds']= $this->groundsdata->totalGrounds();
						$this->load->view('admin/ViewGround',$data);
						$this->load->view('admin/footer');
										 
						}
						public function deleteground($id){
							$base64 = strtr($id, '-_~', '+/=');
                                 $id = $this->encrypt->decode($base64);					 
						$data=$this->groundsdata->deleteground($id);
							if(isset($data)){
								$this->session->set_flashdata("Record","Ground record is deleted Successfully.");
								redirect('admin/Grounds/ViewGround');
								
								}					 
											 
						}
						public function verifye($id){
							$base64 = strtr($id, '-_~', '+/=');
                                 $id = $this->encrypt->decode($base64);
							$data=$this->groundsdata->verifye($id);
							if(isset($data)){
								
								$this->session->set_flashdata("Record","Ground  is verified Successfully.");
								redirect('admin/Grounds/ViewGround');
								
								
								}
							}
							
							public function updateground($id){
						 $base64 = strtr($id, '-_~', '+/=');
                                 $id = $this->encrypt->decode($base64);		
						  $data['teams']= $this->groundsdata->team();
						  $data['updateground']= $this->groundsdata->updateground($id);
						  $this->load->view('admin/header');
						  $this->load->view('admin/updateground',$data);
						  $this->load->view('admin/footer');
								
								
								}
						public function updategroundprofile($id)
						{
								$base64 = strtr($id, '-_~', '+/=');
                                                                 $id = $this->encrypt->decode($base64);
 
								$post=$this->input->post();								 
								$config['encrypt_name'] = TRUE;
								$config['upload_path'] = './uploads';
								$config['allowed_types'] = 'gif|jpg|png|jpeg';
								$config['max_size'] = '';
								$config['max_width'] = '200000000';
								$config['max_height'] = '1000000000000';

								$this->load->library('upload', $config);

								if ($this->upload->do_upload('groundimg')) {
									$data = array('upload_data' => $this->upload->data());
									$image = $data['upload_data']['file_name'];
								}
                                                                
								
							
								
								$data= $this->groundsdata->updategroundprofile($post,$id,$image);
								
								if($data)
								{
										$this->session->set_flashdata("Record","Ground Profile  is  Successfully Updated.");
										$encrypted_id = $this->encrypt->encode($id);	
										$id = strtr ($encrypted_id, '+/=', '-_~');
										redirect('admin/Grounds/updateground/'.$id);
								}
									
									
									}
									 
					  	  
		              
	
			
	
}
