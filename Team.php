<?php
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed'); 


class Team extends CI_Controller {
    
    function __construct() {
        
        parent::__construct();
            $this->load->database();
            $this->load->library('session');
            $this->load->helper('form');
            $this->load->helper('url');
            $this->load->library('encrypt');
            $this->load->helper('captcha');
            $this->load->model('Team_model','teammodel');
        
    }
    
     public function index() {
             
            
        }
        
        public function teamView() {
			
			$data['title'] = "Team ";
                //captcha image code start //
                $this->load->helper('captcha');
		$vals = array(
				'img_path'      => './captcha/',
				'img_url'       => base_url().'/captcha/'
		);

		$cap = create_captcha($vals);
		$data = array(
				'captcha_time'  => $cap['time'],
				'ip_address'    => $this->input->ip_address(),
				'word'          => $cap['word']
		);

		$query = $this->db->insert_string('captcha', $data);
		$querya  = $this->db->query($query);
                $data['capimg'] =  $cap['image'];
                
                //captcha image code ends //
                
                $data['title'] =  "Team Registration Form";
                $this->load->view('Header',$data);
                $this->load->view('Teamview');
                $this->load->view('Footer');
            
        }
        
        public function confirmAccount($id){
            
            $data = $this->teammodel->activeaccount($id);
            if($data) {

              $this->session->set_flashdata('confirmaccount', 'Your Account is active successfully please login to your account'); 
              redirect('Home/login');
             }
             else {
                 
                    $this->session->set_flashdata('notconfirm', 'Your Account has not been Activated'); 
               
                }
        }

                public function RegisterationTeam() {
         
                $post = $this->input->post();
                
				$post['password'] = md5($post['password']);
                
              if($post['checkbox'] =='check') {
                   
                $this->session->set_userdata('teamFillForm',$post);
                   $from_email ="info@cricketersdb.com";
                  $to_email = $this->input->post('email');       
                 
				$image =$_FILES['teamimg']['name'];
				$video =$_FILES['team_video']['name'];
                
              
               
                if($image ==''){
                           
                           $data = $this->teammodel->teamregister($post);
                            $id =$data;
                          $encrypted_id = $this->encrypt->encode($id);	
                           $urisafe = strtr ($encrypted_id, '+/=', '-_~');
                         
                          
                       $ACTIVATIONLINK = base_url('index.php/Team/confirmAccount/'.$urisafe);
                                  if($data){
                                      
                                        $this->load->library('email'); 
                                       $this->email->set_mailtype("html");
                                      $this->email->from($from_email,'Cricketers Database'); 
                                        $this->email->to($to_email);
                                        $this->email->subject('Activation Link'); 
                     
                                      $this->email->message('<h1>WELCOME TO CRICKETERS DATABASE</h1><br>Hi '.$post['owner'].' You are receiving this email because you recently created a new account at "<strong>Cricketers Database</strong>" please click on the following link to activate your team account <br><br>'.$ACTIVATIONLINK.'<br><br>After visiting the above link you can login on to Cricketers Database web site!<br><br>if you are unable to activate your team, please contact us on info@cricketersdb.com <br><br>Thanks'); 
                                       //Send mail 
                                        
                                        if($this->email->send()) {
											 $this->session->unset_userdata('teamFillForm');
                                             $this->session->set_flashdata('emailconfirmation', 'We have sent you an email which contains Activation Link please click on the activation link to activate your account.'); 
                                             redirect('Home/register');
                                                 }
                                    
                                        
                                    }
                    
                   
           }
                else {
                
			  $config['encrypt_name'] = TRUE;
              $config['upload_path']          = './uploads';
              $config['allowed_types']        = 'gif|jpg|png|jpeg|mp4';
              $config['max_size']  = '10240';
              $config['max_width']  = '1024';
              $config['max_height'] = '768';
              $this->load->library('upload',$config);
                
			
               if ( ! $this->upload->do_upload('teamimg')) {
				   
				   
				    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('ok',"Error in Uploading Image: ".$error['error']);
                     redirect('Team/teamView'); 		
                     exit;						
                                           }
                                          
                                          else {
				
				 if ($this->upload->do_upload('team_video')) {

                $data = array('upload_data' => $this->upload->data());
                $video = $data['upload_data']['file_name'];
            }

            if ($this->upload->do_upload('teamimg')) {

                $data = array('upload_data' => $this->upload->data());
                $image = $data['upload_data']['file_name'];
            }
											  
											  
            
             
                              $data = $this->teammodel->teamregister($post,$image,$video);
                                
                                $id =$data;
                              $encrypted_id = $this->encrypt->encode($id);	
                                $urisafe = strtr ($encrypted_id, '+/=', '-_~');
                              $ACTIVATIONLINK = base_url('index.php/Team/confirmAccount/'.$urisafe);
                                   if($data){
                                       
                                        $this->load->library('email'); 
                                        $this->email->set_mailtype("html");
                                      $this->email->from($from_email,'Cricketers Database'); 
                                      $this->email->to($to_email);
                                      $this->email->subject('Activation Link'); 
                      
                                       $this->email->message('<h1>WELCOME TO CRICKETERS DATABASE</h1><br>Hello '.$post['owner'].' You are receiving this email because you recently created a new account at "<strong>Cricketers Database</strong>" please click on the following link to activate your team account <br><br>'.$ACTIVATIONLINK.'<br><br>After visiting the above link you can login on to Cricketers Database web site!<br><br>if you are unable to activate your team, please contact us on info@cricketersdb.com<br><br>Thanks'); 
                                        //Send mail 
                                       
                                      if($this->email->send()) {
										 $this->session->unset_userdata('teamFillForm');
                                           $this->session->set_flashdata('emailconfirmation', 'We have sent you an email which contains Activation Link please click on the activation link to activate your account.'); 
                                             redirect('Home/register');
                                                   }
                                    }
                                           }
               
               
               
                }

             
               
               
           }
            
            
            else {
                
               $this->session->set_flashdata('agreementcheck','Please check on Cricketers Batabase to register');
                redirect('Team/teamView');
           }
           
        }
        
        
        public function deleteteam($id){
            $base64 = strtr($id, '-_~', '+/=');
            $id = $this->encrypt->decode($base64);
            
            $data = $this->teammodel->deleteteam($id);
            if($data){
                
                redirect('Home/login');
            }
        }
            
            public function updateTeamProfile($id){
				
			  $data['title'] = "Update Team ";
              $base64 = strtr($id, '-_~', '+/=');
              $id = $this->encrypt->decode($base64);
           
              $data['updateTeamProfile'] = $this->teammodel->editteam($id);
              $data['totalgrounds']= $this->teammodel->totalgrounds();
                   
                   $this->load->view('teamdashboard/header',$data);
                   $this->load->view('teamdashboard/updateTeamProfile');
                   $this->load->view('teamdashboard/footer');
                
            }
            
            public function Updateteam($id){
				
				
			
				
                $base64 = strtr($id, '-_~', '+/=');
                $id = $this->encrypt->decode($base64);

                $post=$this->input->post();
               
                $config['encrypt_name'] = TRUE;
                $config['upload_path']          = './uploads';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = '';
                $config['max_width']='200000000';
                $config['max_height']='1000000000000';
                
                $this->load->library('upload',$config);
                
                    if($this->upload->do_upload('teamimg')){

                        $data = array('upload_data' => $this->upload->data());
                        $image = $data['upload_data']['file_name'];
                    }
                
                    
                    if($image == '') {
                        
                                $data= $this->teammodel->Updateteam($id,$post);
                
                                    if($data){

                                    $this->session->set_flashdata("teamupdatesuccess"," Team Is  Successfully Updated");
                                    redirect('home/login');
                                }
                        }
                    
                    else {
                        $data= $this->teammodel->Updateteam($id,$post,$image);
                
                                if($data){

                                $this->session->set_flashdata("teamupdatesuccess"," Team Is  Successfully Updated");
                                redirect('home/login');
                             
                                    }
                        
                    }
                
                 }
                 
                 
                 public function teamprofile($id){
                     $base64 = strtr($id, '-_~', '+/=');
                     $id = $this->encrypt->decode($base64);
                     
                     $data['teamprofile'] = $this->teammodel->teamprofile($id);
                    $data['title'] = "Team profile";
                    $this->load->view('teamdashboard/header',$data);
                    $this->load->view('teamdashboard/teamprofile');
                    $this->load->view('teamdashboard/footer');
                 }
        
                 public function Addplayers(){
                     
                         
                         $data['totalteams']= $this->teammodel->totalteams();
                         $data['title'] = "Add Players";
                         $this->load->view('teamdashboard/header',$data);
                         $this->load->view('teamdashboard/add-Players');
                         $this->load->view('teamdashboard/footer');
                 }
                 
                 
                 public function playersview(){
                     
                       $data['viewplyers']= $this->teammodel->totalplayers();
                         $data['title'] = "Players";
                         $this->load->view('teamdashboard/header',$data);
                         $this->load->view('teamdashboard/viewplayers');
                         $this->load->view('teamdashboard/footer');
                     
                     
                     
                 }
                 
                 public function teamimgup($id){
                      $base64 = strtr($id, '-_~', '+/=');
                      $id = $this->encrypt->decode($base64);
                     
                        $config['encrypt_name'] = TRUE;
                        $config['upload_path'] = './uploads';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $config['max_size'] = '';
                        $config['max_width'] = '200000000';
                        $config['max_height'] = '1000000000000';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('teamimg')) {

                    $data = array('upload_data' => $this->upload->data());
                    $image = $data['upload_data']['file_name'];
                }
                
                if($image =='') {
                        $encrypted_id = $this->encrypt->encode($id);	
                        $id = strtr ($encrypted_id, '+/=', '-_~');
                        redirect('Team/teamprofile/'.$id);
                }
                else {
                    
                    $data = $this->teammodel->teamimageupload($image,$id);
                    
                    if($data) {
                         $encrypted_id = $this->encrypt->encode($id);	
                         $id = strtr ($encrypted_id, '+/=', '-_~');
                         redirect('Team/teamprofile/'.$id);
                    }
                }
             
                 }
                 
                 public function updatepassword(){
                         
                       //$data['totalteams']= $this->teammodel->totalteams();
//                         $data['title'] = "Add Players";
                         $this->load->view('teamdashboard/header');
                         $this->load->view('teamdashboard/teamupdatepassword');
                         $this->load->view('teamdashboard/footer');
                         
                         
//                          $this->load->view('header');
////                         $this->load->view('teamdashboard/teamupdatepassword');
//                         $this->load->view('footer');
                     
                     
                 }
                 
                 public function updatepasswordteam(){
                     
                     $teamid =       $this->session->userdata('team_id');
                     $teampassword = $this->session->userdata('team_password');
                  
                     $post =  $this->input->post();
                     $post['oldpassword'] = md5($post['oldpassword']);
			
					 $post['password'] = md5($post['password']);
                     if($teampassword == $post['oldpassword'] && $post['oldpassword'] !=''){
                         
                         $data =  $this->teammodel->updatteampassword($post,$teamid);
                         
                     if($data){
                         
                         $this->session->set_flashdata("teamupdatepasswordsuccess","Your Password is Successfully Updated");
                         redirect('home/login');
                     }
                     
                     }
                     
                     else {
                         
                         $this->session->set_flashdata("passwordupdateerror","Your Password is entered wrong Please Enter your Old password again to Update");
                         redirect('Team/updatepassword');
                     }
                 }
                 //show all fixed matches to the team owner
                 //saif start code
                 public function acceptedmatches()
                 {
                     $team_id=$this->session->userdata('team_id');
                        //$data['ownteam']=$this->teammodel->myteam($team_id);
                        $data['opponent']=$this->teammodel->opponentteam($team_id);
                      
          
                       $this->load->view('teamdashboard/header');
                       $this->load->view('teamdashboard/acceptedmatches',$data);
                       $this->load->view('teamdashboard/footer');

                 }
                 //get feedback about why cancel name,
                 
            public function cancelfeedback($match_id)
            {

                    
                $value['id']=$match_id;
              $this->load->view('teamdashboard/header');
              $this->load->view('teamdashboard/cancelfeedback',$value);
             $this->load->view('teamdashboard/footer');


            }
            //delete match
         public function deletematch($match_id)
         {
         $data=$this->teammodel->deletematch($match_id);
         if($data==true)
         {
          $this->session->set_flashdata('message','Successfully Canceled The Match');
           redirect('/team/acceptedmatches');
         }
          
         }
         //dispaly tournamentslist in view file and drop button
         public function dropteamfromtournament()
         {
          $team_id=$team_id=$this->session->userdata('team_id');
         $data['tournament']= $this->teammodel->allfixedtournaments($team_id);
          $this->load->view('teamdashboard/header');
          $this->load->view('teamdashboard/dropteamfromtournament',$data);
          $this->load->view('teamdashboard/footer');
         }
         //show a confirm box to make sure
         public function showconfirmdropview($tourn_id)
         {
              $value['id']=$tourn_id;

              $this->load->view('teamdashboard/header');
              $this->load->view('teamdashboard/confirmdropbox',$value);
             $this->load->view('teamdashboard/footer');
 
         }
         public function confirmdrop($id)
         {
          $data=$this->teammodel->dropteam($id);
         if($data==true)
         {
          
          $this->session->set_flashdata('message','Successfully Withdraw From Tournament');
          echo redirect(base_url().'team/dropteamfromtournament');
         }
         }

         //saif end code
    
    
    
    
}


?>