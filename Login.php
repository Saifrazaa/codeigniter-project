<?php
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Login extends CI_Controller {
    
    
     function __construct() 
        {

            parent::__construct();
            
            $this->load->database();
            $this->load->library('session');
            $this->load->helper('form');
            $this->load->helper('url');
            $this->load->model('Login_model','login');
            //$this->load->model('Player_model','allplayers');
        }

   
        public function index() {
            
         $id = $this->session->userdata('user_id');
         
         if(isset($id) && $id != '') {
                   
                   $data['players'] = $this->login->getplayers($id);
                   
                   $this->load->view('header');
                   $this->load->view('playershow',$data);
                   $this->load->view('footer');
             
             
         }
         else {
                $this->load->view('header');
		$this->load->view('login');
                $this->load->view('footer');
         }
            
            
        }
        
        
        public function loginin(){
          
            $post = $this->input->post();
		//	$post['password'] = md5($post['password']);
            $data = $this->login->verifyemail($post);
			
			if(isset($data[0]['player_activation']) && $data[0]['player_activation'] != 1){
				
				$this->session->set_flashdata('invalidep','your account is not active.');
                redirect('Home/login');
				
				
			}
			
			
			if(isset($data[0]['team_activation']) && $data[0]['team_activation'] != 1){
				
				$this->session->set_flashdata('invalidep','your account is not active.');
                redirect('Home/login');
				
				
			}
			
            $team = $data[0]['team_id'];
		   
            $teamName = $data[0]['team_name'];
            $teampassword = $data[0]['team_ownerpass'];
            $teamlogo = $data[0]['team_logo'];
            $player = $data[0]['id'];
            
        
            $teamowneremail = $data[0]['team_owneremail'];
            $teamownerpass  = $data[0]['team_ownerpass'];
			$data['title'] = "Dashboard - ".$teamName." | Cricketers Database"; 
			
			
            if(isset($team) && $team !=''  ) {
               
                
            if($post['email'] == $teamowneremail && md5($post['password']) ==$teamownerpass){
                
                $this->session->set_userdata('team_id',$team);
                $this->session->set_userdata('team_name',$teamName);
                $this->session->set_userdata('team_password',$teampassword);
                $this->session->set_userdata('team_logo',$teamlogo);
                
                $teamownerdata['teamownerprofile'] =  $this->login->getTeamOwner($team);
                
                $this->load->view('teamdashboard/header',$data);
                $this->load->view('teamdashboard/teamOwnerDashboard',$teamownerdata);
                $this->load->view('teamdashboard/footer');
                
             } 
               
             else {echo "c";exit;
                        $this->session->set_flashdata('invalidep','Invalid email or password');
                        redirect('Home/login');
               
           }
                
                
                
            }
            
            else if(isset($player) && $player !=''){
                  
                $id = $this->session->set_userdata('user_id',$data[0]['id']);
                $this->session->set_userdata('user_password',$data[0]['user_password']);
                $email = $data[0]['user_email'];
                $password = $data[0]['user_password'];
                $playerid = $data[0]['id'];
                
                if($post['email'] == $email && $post['password'] == $password) {
                    
                    
//                 OLD sain sajid code
//                     $data['players'] = $this->login->getplayers($playerid);
//                   
//
//				             $data['players']   = $this->allplayers->singleplayerprofile($playerid);
//							$this->load->view('header');
//							$this->load->view('singlePlayer',$data);
//							$this->load->view('footer');
		  $data['players'] = $this->login->getplayers($playerid);
                   
                   $this->load->view('header');
                   $this->load->view('playershow',$data);
                   $this->load->view('footer');
				   
				   
				   
				   
                }
                else {
                     $this->session->set_flashdata('invalidep','your email or password is incorrect');
                        redirect('Home/login');
                }
                
           }
           
            else {
                
                $this->session->set_flashdata('activateacc','Activate your account First to Login in');
                redirect('Home/login');
                
                echo "activate your account first from your email given";
            }
           
            

            
        }
        
        public function updatepassword(){
            
            $useridd = $this->session->userdata('user_id');
            $userpassword = $this->session->userdata('user_password');
            $post = $this->input->post();
            
			$post['oldpassword'] = md5($post['oldpassword']);
			
			$post['password'] = md5($post['password']);
            
            if($userpassword ==$post['oldpassword'] && $post['oldpassword'] !='') {
                
                $data = $this->login->updatepassword($post,$useridd,$userpassword);
            
                if($data){
                    
                    $this->session->set_flashdata('upddatepasssuccess','Your password has Been updated Successfully');
                    redirect('Home/login');
                }
                
                }
            else {
                
                $this->session->set_flashdata('updatepassworderror','Your given old password is wrong');
                redirect('Home/updatepassword');
            }
        
            
            
            
        }

        
 
 
   }
?>