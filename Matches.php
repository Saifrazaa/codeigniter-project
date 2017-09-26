<?php
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');
class Matches extends CI_Controller {

				public function __construct() {
				parent::__construct();
				
				$this->load->helper('form');
				$this->load->database();
				$this->load->library('form_validation');
                                $this->load->helper('url');
				$this->load->library('session');
	             
                                $this->load->model('admin/MatchRecord_model','matches');
	                 }
	
	                 public function index()
	                 {
					  
	                  }
					  public function addmatche(){
						  
						
                          $data['tournaments'] = $this->matches->showtournamentsnames();
                          $data['teams'] = $this->matches->showmatchteams();
                          $data['grounds'] = $this->matches->showgrounds();
						 
                          $this->load->view('admin/header');
						  $this->load->view('admin/addMatch',$data);
						  $this->load->view('admin/footer');
						  
						  }
						  public function deletematch()
						  {
						  	 
						 
                             //delete an existing match
						  	$matchdata['match']=$this->matches->allmatchesresult();
						  	$this->load->view('admin/header');
						  	$this->load->view('admin/deletematch',$matchdata);
						  	$this->load->view('admin/footer');
		                      
						  				  	}
                                          //delete selected match                     
						  				  	public function deleteselectedmatch($id)
						  				  	{
						  				  		//pass value to model
                                                $request=$this->matches->deleteselected($id);
                                                if($request==true)
                                                {  

                                                	$this->session->set_flashdata('message','Successfully Deleted The Match');
                                                	/*$this->load->view('admin/header');
                                                	$this->load->view('admin/deletematch');
                                                	$this->load->view('admin/footer');*/
                                                	redirect(base_url().'admin/matches/deletematch');
                                                }
						  				  	}
						  
					  public function updatePlayer(){
						  
						  }
                                                  
                                                  public function addmatch(){
                                                      
                                                      $posteddata  = $this->input->post();
                                                      $name_array = array();
                                                
														$count = count($_FILES['userfile']['size']);
														foreach($_FILES as $key=>$value)
														for($s=0; $s<=$count-1; $s++) {
														$_FILES['userfile']['name']=$value['name'][$s];
														$_FILES['userfile']['type']    = $value['type'][$s];
														$_FILES['userfile']['tmp_name'] = $value['tmp_name'][$s];
														$_FILES['userfile']['error']       = $value['error'][$s];
														$_FILES['userfile']['size']    = $value['size'][$s];   
													   
														$config['encrypt_name'] = TRUE;
														$config['upload_path'] = './uploads/';
														$config['allowed_types'] = 'gif|jpg|png';
														 $config['max_size']  = '1024';
														$config['max_width']  = '1024';
														$config['max_height'] = '768';
														$this->load->library('upload', $config);
														$this->upload->do_upload();
														$data = $this->upload->data();
														$name_array[] = $data['file_name'];
                                             }
                                    
                                             
                                             $names= implode(',', $name_array);
                                                      
                                                      
                                                      if(empty($names)){
                                                          
                                                        
                                                          
                                                           $data  =  $this->matches->Insertmatchrecord($posteddata);
                                                 
                                                            if($data) {

                                                                 $result =  $this->matches->Insertmatchrecordadmintable($posteddata);  
                                                                 
                                                                 if($result) {
                                                                 
                                                                 $this->session->set_flashdata('matchdetail','Your match Details has been Insered SuccessFully..!');
                                                                 redirect('admin/Matches/addmatche');
                                                            
                                                                     
                                                                     
                                                                 }
                                                                 }
                                                          
                                                      }
                                                      
                                                      else {
                                                          
                                                     

                                                          
                                             if ( ! $this->upload->do_upload('userfile')) {

                                                            $this->session->set_flashdata('ok','Please upload image size not more than 1MB');
                                                            redirect('admin/matches/addmatche'); 		
                                                            exit;						
                                                            }
                                                            
                                                            else {
                                                                
                                                                 $data  =  $this->matches->Insertmatchrecord($posteddata,$names);
                                                                if($data) {
                                                                    
                                                                      $result =  $this->matches->Insertmatchrecordadmintable($posteddata); 
                                                                    
                                                                      if($result)
                                                                      {
                                                                      
                                                                     $this->session->set_flashdata('matchdetail','Your match Details has been Inserted SuccessFully..!');
                                                                     redirect('admin/Matches/addmatche');
                                                               
                                                                          }
                                                                      }
                                                                
                                                                
                                                            }
                                             
                                             
                                             
                                             
                                                      }
                                                      
                                                      
                                                  } 
                                                      
                                                      
                                                      
                                                      
                                                      
                                                      
                                                      
                                                      
     
						  
					  	  
		              
	
			
	
}
