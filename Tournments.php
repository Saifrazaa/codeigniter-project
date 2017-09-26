<?php
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');
class Tournments extends CI_Controller {

				public function __construct() {
				parent::__construct();
				//load the tournament model
				$this->load->model('admin/Tournament_model','tmodel');
				
				// Load form helper library
                                $this->load->library('encrypt');
				$this->load->helper('form');
				$this->load->database();
				 //$this->load->helper(array('form', 'url'));
				// Load form validation library
				$this->load->library('form_validation');
				//load image of user
				
				// Load session library
	               $this->load->library('session');
	              $this->load->helper('url');
	               // Load database
	               //$this->load->model('Tournments','Tournmentsdata');
	                 }
	
	                 public function index()
	                 {
						$this->load->model('admin/Ground_model');
						$data['tgrounds'] = $this->Ground_model->totalGrounds();
						$this->load->model('admin/Team_model');
						$data['tteams'] = $this->Team_model->totalteams();
					  	$this->load->view('admin/header');
						$this->load->view('admin/addTournament',$data);
						$this->load->view('admin/footer');
	                  }
					  public function addTournament(){
						  $tournamentTeams['tteams'] = $this->input->post('tournament_teams');
						  $tournamentGrounds['tground'] = $this->input->post('tournament_grounds');
						  
						   $datas = array(
							"tournament_name"=> $_POST['name'],
				
							"tournament_type"=> $_POST['ttype'],
				
							"tournament_start"=> $_POST['startDate'],
				
							"tournament_end"=> $_POST['endDate'],
							
							"p_team_name"=> $tournamentTeams,
							
							"tg_name"=> $tournamentGrounds,
							
							"price_money"=> $_POST['price_money'],
							
							
							"tournament_desc"=> $_POST['tournament_desc']
						);
                                                   
                                                   
                                                   $image =$_FILES['tmt_img']['name'];
                                                   
                                                   if($image =='') {
                                                       
                                                 
                                                       				
						 $this->load->model('admin/Tournament_model');
						 $data =$this->Tournament_model->addtournament($datas,$image);
						
                                                   $tid = $data[0]['tournament_id']; 
                                                   
                                                     $encrypted_id = $this->encrypt->encode($tid);
                                                     $urisafe = strtr($encrypted_id, '+/=', '-_~');
                                                     $ACTIVATIONLINK = base_url('index.php/Organizematchs/organizetournamentruqest/'.$urisafe);
                                                 
                                                 
                                                 if($data) {
                                                     
                                                    foreach($data as $emails):
                                                        
                                                        $to_email= $emails['team_owneremail'];
                                                        $from_email = "info@cricketersdb.com"; 
                                                         
                                                        
                                                        $this->load->library('email');
                                                        $this->email->set_mailtype("html");
                                                        $this->email->from($from_email, 'Cricketers Database');
                                                        $this->email->to($to_email);
                                                        $this->email->subject('Cricket Tournament proposal');
                                                        //$this->email->message('<a href = "'.$ACTIVATIONLINK.'">"'.$ACTIVATIONLINK.'"</a>');
                                                        $this->email->message('<h1>WELCOME TO CRICKETERS DATABASE</h1><br>Hi' . $emails['team_owner'] . ' You are receiving this email because you are invited in the Tournament of <strong>' . $emails['tournament_name'] . ' </strong> If you are interested to play kindly Copy the Link  below and paste it in url <br><br>' . $ACTIVATIONLINK . '<br><br>Please contact us on info@cricketersdb.com if you have any problem<br><br>Thanks');
                                                        $this->email->send();
                    
                                                    endforeach;
                                                  $this->session->set_flashdata('tournamentadded','Tournamenet added Successfully');
						  redirect('admin/Tournments/');
						 exit;
                                                 }
                                                       
                                                   }
                                                   
                                                   else {
                                                       
                                                       
                                                        $config['encrypt_name'] = TRUE;
                                                        $config['upload_path'] = './uploads';
                                                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                                                        $config['max_size']  = '1024';
                                                        $config['max_width']  = '1024';
                                                        $config['max_height'] = '768';

                                                        $this->load->library('upload', $config);
                                                        
                                                        if ( ! $this->upload->do_upload('tmt_img')){

                                                        $this->session->set_flashdata('ok','Please upload image size not more than 1MB');
                                                        redirect('admin/Tournments'); 		
                                                        exit;						

                                                        }
                                                        
                                                        if ($this->upload->do_upload('tmt_img')) {

                                                            $data = array('upload_data' => $this->upload->data());
                                                            $image = $data['upload_data']['file_name'];
                                                            }
                                                   
                                                            
                                                            
										
						 $this->load->model('admin/Tournament_model');
						 $data =$this->Tournament_model->addtournament($datas,$image);
						
                                                   $tid = $data[0]['tournament_id']; 
                                                   
                                                     $encrypted_id = $this->encrypt->encode($tid);
                                                     $urisafe = strtr($encrypted_id, '+/=', '-_~');
                                                     $ACTIVATIONLINK = base_url('index.php/Organizematchs/organizetournamentruqest/'.$urisafe);
                                                 
                                                 
                                                 if($data) {
                                                     
                                                    foreach($data as $emails):
                                                        
                                                        $to_email= $emails['team_owneremail'];
                                                        $from_email = "info@cricketersdb.com"; 
                                                         
                                                        
                                                        $this->load->library('email');
                                                        $this->email->set_mailtype("html");
                                                        $this->email->from($from_email, 'Cricketers Database');
                                                        $this->email->to($to_email);
                                                        $this->email->subject('Cricket Tournament proposal');
                                                        //$this->email->message('<a href = "'.$ACTIVATIONLINK.'">"'.$ACTIVATIONLINK.'"</a>');
                                                        $this->email->message('<h1>WELCOME TO CRICKETERS DATABASE</h1><br>Hi' . $emails['team_owner'] . ' You are receiving this email because you are invited in the Tournament of <strong>' . $emails['tournament_name'] . ' </strong> If you are interested to play kindly Copy the Link  below and paste it in url <br><br>' . $ACTIVATIONLINK . '<br><br>Please contact us on info@cricketersdb.com if you have any problem<br><br>Thanks');
                                                        $this->email->send();
                    
                                                    endforeach;
                                                  $this->session->set_flashdata('tournamentadded','Tournamenet added Successfully');
						  redirect('admin/Tournments/');
						 exit;
                                                 }
                                                       
                                                       
                                                       
                                                       
                                                       
                                                       
                                                       
                                                       
                                                       
                                                       
                                                   }
                                                   
                                                   
						       
                                                 

						}//load the tournaments to delete
						public function canceltournament()
						{
							$this->load->model('admin/Tournament_model','tmodel');
							$data['tournament']=$this->tmodel->viewalltournament();
							$this->load->view('admin/header');
							$this->load->view('admin/deletetournament',$data);
							$this->load->view('admin/footer');
						}
                          //delete the requested tournament
						public function deletetournament($id)
						{
                            
                               $result=$this->tmodel->deleterequestedtournament($id);
                               if($result==true)
                               {
                               	$this->session->set_flashdata('message','Successfully Deleted Tournament !!');
                               	            //redirect(base_url().'admin/matches/deletematch');

                               	redirect(base_url().'admin/tournments/canceltournament');
                               }

                             }
						
						/* View Tournament */
						public function viewTournament(){
						  
						  $this->load->model('admin/Tournament_model');
						  $data['viewtournament'] = $this->Tournament_model->viewalltournament();
						  $this->load->view('admin/header');
						  $this->load->view('admin/viewTournaments',$data);
						  $this->load->view('admin/footer');
						  
						 }
						 /*Tournament Detail*/
						public function viewTournamentdetail(){
						  
						  $this->load->model('admin/Tournament_model');
						  $data['viewtournaments'] = $this->Tournament_model->viewalltournament();
						  $data['viewtournamentsteam'] = $this->Tournament_model->viewalltournamentTeams();
						  $data['viewtournamentsground'] = $this->Tournament_model->viewalltournamentGrounds();
						  $this->load->view('admin/header');
						  $this->load->view('admin/viewTournamentDetail',$data);
						  $this->load->view('admin/footer');
						  
						  
						 }   //pass view to edit tournament
					  	public function edittournament($id){
						  $data['totalteams']=$this->tmodel->gettotalteams($id);
						  
						  $this->load->view('admin/header');
						  $this->load->view('admin/edittournament',$data);
						  $this->load->view('admin/footer');
						  
						}
						//show the confirm drop team box
						public function dropteamview($id)
						{
							$value['team_id']=$id;
						$this->load->view('admin/header');
						$this->load->view('admin/dropteamview',$value);
						$this->load->view('admin/footer');
						}
						//will drop team from tournament
						  public function dropteam($id)
						  {
                              $data=$this->tmodel->dropteamfromtournament($id);
                              if($data==true)
                              {
                              	$this->session->set_flashdata('message','Succuessfully Drop The Team From Tournament');
                              	echo redirect(base_url().'admin/Tournments/canceltournament');
                              }
						  }
					  	  
		              
	
			
	
}
