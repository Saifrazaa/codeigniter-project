<?php
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed'); 


class Organizematchs extends CI_Controller {
    
    function __construct() {
        
        parent::__construct();
            $this->load->database();
            $this->load->library('session');
            $this->load->helper('form');
            $this->load->helper('url');
            $this->load->library('encrypt');
            $this->load->helper('captcha');
            $this->load->model('Organizematch_model','Organizemodel');
        
    }
    
     public function index() {
             
            
        }
        
       
        public function organizem(){
			$data['ground']=$this->Organizemodel->organizem();
                        $data['teams']=$this->Organizemodel->organizteam();
			
            $this->load->view('teamdashboard/header');
                $this->load->view('Organizematch',$data);
                $this->load->view('teamdashboard/footer');
           //$this->load->view('Organizematchs');
        }
		
		public function Search($teamname)
		{
			
			$post=$this->input->post();
			$post['teamname'] = $teamname;
			if(!empty($post)){
			$data['grounds']=$this->Organizemodel->Search($post);
			$data['ground']=$this->Organizemodel->organizem();
			$this->load->view('teamdashboard/header');
                $this->load->view('Organizematch',$data);
                $this->load->view('teamdashboard/footer');
			}else{
				
				$data['ground']=$this->Organizemodel->organizem();
			
            $this->load->view('teamdashboard/header');
                $this->load->view('Organizematch',$data);
                $this->load->view('teamdashboard/footer');
				
				}
			}
			public function teamprofile($id){
			$base64 = strtr($id, '-_~', '+/=');
            $id = $this->encrypt->decode($base64);
			$data['freind']=$this->Organizemodel->freind($id);
			$data['ruqestsent']=$this->Organizemodel->ruqestsent($id);
			$data['acceptruqest']=$this->Organizemodel->acceptruqest($id);		
			$data['freinds']=$this->Organizemodel->freinds($id);		
			$data['teamprofile']=$this->Organizemodel->teamprofile($id);
			$data['grounds']=$this->Organizemodel->selectground();
			$this->load->view('teamdashboard/header');
			$this->load->view('Teamprofile',$data);
			$this->load->view('teamdashboard/footer');
			   
			   
			   }
			         public function orgnisematch($id){
						 $base64 = strtr($id, '-_~', '+/=');
                          $id = $this->encrypt->decode($base64);

						 $post=$this->input->post();
				         //echo "<pre>";
						// echo $id;
						 //print_r($post);
			         $data=$this->Organizemodel->orgnisematch($post,$id);
					 
					 
					 
					  
				  if($data){
					 
					  $data=$this->Organizemodel->teameamil($id);
					 
					  $to_email=$data[0]['team_owneremail'];
					     $from_email = "Cricket@gmail.com"; 
					     //$time=date('Y-m-j h:i:s');
						 //Load email library 
				       $this->load->library('email'); 
				       $username= $this->session->userdata('team_name');
					 $this->email->from($from_email, 'Cricket'); 
				 		 $this->email->to($to_email);
						 $this->email->subject('Ruqest For Match '); 
				 		 $this->email->message('Hello Captain  You Are Invited for playing Match with   '."\n\n".$username.' '.'Team if you Are Agree' ."\n\n". 'Then Go to Your  profile  And Accept The Match Ruqest'); 
				   
				// 		 Send mail 
				 		 $this->email->send();
					  $this->session->set_flashdata("orgnize"," Match Ruqest Is  Successfully Sent");
					    $encrypted_id = $this->encrypt->encode($id);	
                         $id = strtr ($encrypted_id, '+/=', '-_~');

					   redirect('Organizematchs/teamprofile/'.$id);
					  
					  }else{
						  
				$this->session->set_flashdata("orgnize","");
						  redirect('Organizematchs/teamprofile/'.$id);
						  
						  } 
				   
				   }
				   public function acceptmatchruqest($id){
					   $base64 = strtr($id, '-_~', '+/=');
                        $id = $this->encrypt->decode($base64);
					   
					    $data=$this->Organizemodel->acceptmatchruqest($id);
				  if($data){
					  $data=$this->Organizemodel->teameamil($id);
					  $to_email=$data[0]['team_owneremail'];
					     $from_email = "Cricket@gmail.com"; 
					     //$time=date('Y-m-j h:i:s');
						 //Load email library 
				       $this->load->library('email'); 
				       $username= $this->session->userdata('team_name');
					 $this->email->from($from_email, 'Cricket'); 
				 		 $this->email->to($to_email);
						 $this->email->subject('Accept your Ruqest '); 
				 		 $this->email->message('Hello Captain  Your Match Ruqest Is Accept By '."\n\n".$username); 
				   
				// 		 Send mail 
				 		 $this->email->send();
					  $this->session->set_flashdata("orgnize"," Match Ruqest Is  Successfully Accepted");
					  $encrypted_id = $this->encrypt->encode($id);	
                       $id = strtr ($encrypted_id, '+/=', '-_~');

					    redirect('Organizematchs/teamprofile/'.$id);
					  
					  } 
				   
				   }
				   public function organizematchruqest(){
					   
				$data['recivedmatchruqests']=$this->Organizemodel->recivedmatchruqests();
					   $this->load->view('teamdashboard/header');
					   $this->load->view('Recivedmatchruqests',$data);
					   $this->load->view('teamdashboard/footer');
					   
					   
					   }

					   public function organizetournamentruqest($id){
					      $base64 = strtr($id, '-_~', '+/=');
                                              $id = $this->encrypt->decode($base64);
                                              base_url('index.php/Organizematchs/organizetournamentruqest/'.$urisafe);
                                             
                                              $link = base_url('index.php');
                                              $teamid = $this->session->userdata('team_id');
                                              
                                              if(isset($teamid) && $teamid !='') {
                                                  
                                                  $data['recivedmatchruqests']=$this->Organizemodel->recivedtournamentrequest($id);
                                                  
                                                  
                                                  $this->load->view('teamdashboard/header');
					          $this->load->view('Recivedtournamentruqests',$data);
					          $this->load->view('teamdashboard/footer');
                                                  
                                              }
                                              else {
                                                  
                                                  redirect($link);
                                              }
                                              
                                              
//                                            $data['recivedmatchruqests']=$this->Organizemodel->recivedmatchruqests();
//					   $this->load->view('teamdashboard/header');
//					   $this->load->view('recivedtournamentruqests',$data);
//					   $this->load->view('teamdashboard/footer');
					   
					   
					   }



					   public function rejectmatchruqest($id){
						    $base64 = strtr($id, '-_~', '+/=');
                           $id = $this->encrypt->decode($base64);
					   
					   $data=$this->Organizemodel->rejectmatchruqest($id);
					   if($data){
						   
						   redirect('Organizematchs/organizematchruqest/');
						   
						   
						   }
					   
					   }
				  public function playerprofile($id){
					  $base64 = strtr($id, '-_~', '+/=');
                                     $id = $this->encrypt->decode($base64);

				  $data['playerprofile'] = $this->Organizemodel->playerprofile($id);  
				  $this->load->view('teamdashboard/header');
				  $this->load->view('Playerprofile', $data);
				  $this->load->view('teamdashboard/footer');
					  
					  
					  }
                                          
                                             public function accepttournamruqest($id){
                                              $from_email = $this->session->userdata('team_name');
                                              $to_email = "Cricket@gmail.com"; 
                                                $base64 = strtr($id, '-_~', '+/=');
                                                $id = $this->encrypt->decode($base64);
                                                 $link = base_url('index.php');
                                                $data = $this->Organizemodel->accepttourreq($id);
                                              
                                                if($data){
                                                    $this->load->library('email');
                                            $this->email->from($from_email, 'USER TEAM OWNER');
                                            $this->email->to($to_email);
                                            $this->email->subject('Accepted Tournament Ruqest');
                                            $this->email->message('Hello Admin  Your Tournament Request approval Is Accepted by a Team Owner');
                                            $emi = $this->email->send();
                                            //exit;
                                            //Send mail 
                                            if ($emi == 1){
                                                
                                                redirect($link."/home/login");
                                            }
                                           
                                                   }
                                          }
                                          
                                          public function rejecttournsmentruqest($id){
                                              $from_email = $this->session->userdata('team_name');
                                              $to_email = "Cricket@gmail.com"; 
                                             $base64 = strtr($id, '-_~', '+/=');
                                             $id = $this->encrypt->decode($base64);
                                             $link = base_url('index.php');
                                             
                                             $data = $this->Organizemodel->rejecttourreq($id);
                                             if($data){
                                            $this->load->library('email');
                                            $this->email->from($from_email, 'USER TEAM OWNER');
                                            $this->email->to($to_email);
                                            $this->email->subject('Rejected Tournament Ruqest');
                                            $this->email->message('Hello Admin  Your Tournament Request approval Has benn Rejected  by a Team'.$from_email);
                                            $emi = $this->email->send();
                                            //exit;
                                            //Send mail 
                                            if ($emi == 1){
                                                
                                                redirect($link."/home/login");
                                                
                                                
                                            }
                                           
                                                   }
                                                 
                                              
                                          }
					   
					   

                
    
    
    
    
}


?>