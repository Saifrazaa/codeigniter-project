<?php
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');
class MatchRecord extends CI_Controller {

				public function __construct() {
				parent::__construct();
				
				
				  $this->load->helper('form');
				  $this->load->database();
				  $this->load->helper(array('form', 'url'));
				  $this->load->library('form_validation');
				  $this->load->library('upload');
				  $this->load->library('session');
				  $this->load->model('admin/MatchRecord_model','Matchdata');
	              $this->load->model('Player_model','players_m'); 
	              }
	
	                 public function index()
	                 {
					  
	                  }
				
				
				 public function matches(){
				
				
			   $data['teamplyers'] = $this->Matchdata->Matchrecord();
			   $data['teamid'] = $this->Matchdata->teamrecord($teamname);
			   $data['teamname'] = $this->Matchdata->trecord($teamnam);
					  
					
					 $this->load->view('admin/header');
					 $this->load->view('admin/view_matchRecord', $data);
					 $this->load->view('admin/footer');
					
			    }
				public function result(){
					
					
					$data['teamplyers'] = $this->Matchdata->get_Matchresult();
					
					
					$this->load->view('admin/header');
					 $this->load->view('admin/viewmatchRecord', $data);
					 $this->load->view('admin/footer');
					
					}
				  
				  public function playerView(){
					  
				  $id=$this->session->userdata("userid");
				  if ($id == NULL) {
				  redirect(base_url().'index.php/admin');
				  }else{
				  $post=$this->input->post();
				  if(!empty($post)){
				  $data['teamplyers'] = $this->palyersdata->teamplyers($post);
				  $data['allplayers'] = $this->palyersdata->totalteams();
				  $this->load->view('admin/header');
				  $this->load->view('admin/showplayers', $data);
				  $this->load->view('admin/footer');
				  
				  }	else{ 
				  $data['allplayers'] = $this->palyersdata->totalteams();
				  $this->load->view('admin/header');
				  $this->load->view('admin/showplayers', $data);
				  $this->load->view('admin/footer');
				  }}
				  }
				  public function insertplayermatchrecord($id){
					   $base64 = strtr($id, '-_~', '+/=');
                        $id = $this->encrypt->decode($base64);
				  
				  $data['userprofile'] = $this->palyersdata->userprofile($id);
				  $this->load->view('admin/header');
				  $this->load->view('admin/Player_profile', $data);
				  $this->load->view('admin/footer');
				  
				  
				  }
				  public function playerprofile($id){
					  
					  $record=explode("uid",$id);
					  
					  $player=$record[0];
					  $base64 = strtr($player, '-_~', '+/=');
                      $palyerID = $this->encrypt->decode($base64);
					     						 
                                       
                      $matchid=$record[1];
					  $base645 = strtr($matchid, '-_~', '+/=');
                      $match = $this->encrypt->decode($base645);
 
					  $teamid=$record[2];
					  $base646 = strtr($teamid, '-_~', '+/=');
                      $teamid = $this->encrypt->decode($base646);
					  
					  
					  //exit;
                                   
                      $data['teamid']=$teamid;
					  $data['matchid']=$match;
					  $data['playerid'] = $palyerID;
                                    
                      $data['playerprofileCheck'] = $this->Matchdata->playerprofileCheckIfadded($palyerID,$match); 
					  
					  
					  $data['getMatchData'] = $this->Matchdata->getMatchData($match); 
					  
					
					  
					  
					 $who_sent = $data['getMatchData'][0]['who_sent'];
					 $sent_to = $data['getMatchData'][0]['sent_to'];
					 
					 
					 $data['team_whoSentID'] = $who_sent;
					 $data['team_to_sent'] = $sent_to;
					 
					 $data['who_sent'] = $this->Matchdata->getPlayerList($who_sent); 
					 $data['sent_to'] = $this->Matchdata->getPlayerList($sent_to);  
					 
					
					  if(count($data['playerprofileCheck']) > 0){
							
							$this->load->view('admin/header');
							$this->load->view('admin/updateplayermatchrecord',$data);
							$this->load->view('admin/footer');
						  
						  
					  } else{
						  
						    $data['playerprofile'] = $this->Matchdata->playerprofile($palyerID);  
							$this->load->view('admin/header');
							$this->load->view('admin/insertplayermatchrecord',$data);
							$this->load->view('admin/footer');
						  
						  
					  }
							
                                         
				
					  
					  
					  }
					  
				   public function teamprofile($id)
				   
				   {
                         
						 $record = explode("uid",$id);
						  
						 $base64 = strtr($record[0], '-_~', '+/=');
						 $id = $this->encrypt->decode($base64);
						 
                         $base64 = strtr($record[1], '-_~', '+/=');
                         $matchid = $this->encrypt->decode($base64);  
						  
                         $data['matchid']=$matchid;   
						 $data['playermatchrecord']=$this->Matchdata->get_playermatchrecord($id);
						  
						 $data['currentMatchDataWinner']=$this->Matchdata->currentMatchDataWinner($matchid);
						 $data['currentMatchDataLoser']=$this->Matchdata->currentMatchDataLoser($matchid);
						// $team=$this->Matchdata->getTeams($id);
					//	 $data['MatchRecord']=$this->Matchdata->currentMatchDataWinner($matchid, $team[0]['team_id']);
						 $data['teamprofile']=$this->Matchdata->teamprofile($id);
						 $this->load->view('admin/header');
						 $this->load->view('admin/teamprofileformatch',$data);
						 $this->load->view('admin/footer');
						
			   
					}					   
					
					public function updateWicketkeeper($id){
						    $base64 = strtr($id, '-_~', '+/=');
                        $id = $this->encrypt->decode($base64);
					  $post=$this->input->post();
					  $data = $this->palyersdata->updateWicketkeeper($id,$post);
					   if($data){
				$this->session->set_flashdata("keeper"," Record Is Successfully Updated.");
				  redirect('admin/Players/Player_profile/'.$id);}
					  
					  
					  }
				  public function updateplyers($id){
					  $base64 = strtr($id, '-_~', '+/=');
                        $id = $this->encrypt->decode($base64);

				  
				  
				  $post=$this->input->post();
				  $data = $this->palyersdata->updateprofile($id,$post);
				  if($data){
				$this->session->set_flashdata("keeper"," Record Is Successfully Updated.");
				$encrypted_id = $this->encrypt->encode($id);	
                   $id = strtr ($encrypted_id, '+/=', '-_~');
				  redirect('admin/Players/Player_profile/'.$id);	
				  //$data['userprofile'] = $this->palyersdata->userprofile($id);
				  //print_r($data['userprofile']);
				  //$this->load->view('admin/header');
				  //$this->load->view('admin/Player_profile', $data);
				  //$this->load->view('admin/footer');
				  
				  }
				  }
				  public function forGotPassword(){
				  
				  $this->load->view('admin/forgotpassword');
				  }
				  
				  public function send_mail() {
						
				  $from_email = "seeking@gmail.com"; 
				  $to_email = $this->input->post('email'); 
				  
				  $data= $this->palyersdata->getpassword($to_email);
				  if($data[0]){
				  $password=$data[0]['admin_password'];
				  
				  				   
				  //Load email library 
				  $this->load->library('email'); 
				  $this->email->from($from_email, 'conversio'); 
				  $this->email->to($to_email);
				  $this->email->subject('Recover Password'); 
				  $this->email->message('Your Account Password Is :'.$password); 
				  $emi =  $this->email->send();
				  //exit;
				  //Send mail 
				  if($emi == 1) 
				  $this->session->set_flashdata("email_sent","Email sent successfully.");
				  else 
				  $this->session->set_flashdata("email_sent","Error in sending Email."); 
				  redirect('admin/Superadmin/'); 
				  }else{
					  $this->session->set_flashdata("email_sent"," This Email is not Exits."); 
				  $this->load->view('admin/Superadmin/'); 
					  
					  }
				  }
				  
				  
				  public function viewplayers(){
					  $data['viewplyers']= $this->palyersdata->viewplayer();
					  $this->load->view('admin/header');
					  $this->load->view('admin/viewplayers',$data);
					  $this->load->view('admin/footer');
					  }
					  public function deleteplyer($id){
						   $base64 = strtr($id, '-_~', '+/=');
                            $id = $this->encrypt->decode($base64);
						  
						   $data= $this->palyersdata->deleteplyer($id);
						  if($data){
					$this->session->set_flashdata("email_sent"," Record  is Successfully Deleted.");
					 redirect('admin/Players/viewplayers');
							  
							  
							  }
							  
						  
						  }
						  public function verifye($id){
							  $base64 = strtr($id, '-_~', '+/=');
                                $id = $this->encrypt->decode($base64);
								

							  $data= $this->Matchdata->resultsubmited($id);
							 if($data){
								// $this->session->set_flashdata("email_sent"," Player Is Successfully Verified.");
								 redirect('admin/MatchRecord/view_matchRecord');
								 
								 }
							  
							  }
						  public function updatePlayerProfile($id){
							    $base64 = strtr($id, '-_~', '+/=');
                                $id = $this->encrypt->decode($base64);
							  
							   $data['updatePlayerProfile']= $this->palyersdata->updatePlayerProfile($id);
							   $data['allplayers'] = $this->palyersdata->totalteams();
							  $this->load->view('admin/header');
							  $this->load->view('admin/updatePlayerProfile',$data);
							  $this->load->view('admin/footer');
							  
							  }
							  public function updaterecord($id){
								  $base64 = strtr($id, '-_~', '+/=');
                                          $id = $this->encrypt->decode($base64);

								   $post=$this->input->post();
								  $data= $this->palyersdata->updaterecord($id,$post);
								 
								 if($data){
									  $this->session->set_flashdata("keeper"," Profile Record Is Successfully Updated.");
									  $encrypted_id = $this->encrypt->encode($id);	
                                      $id = strtr ($encrypted_id, '+/=', '-_~');
									 redirect('admin/Players/updatePlayerProfile/'.$id);
									 }
								  
								  }
		public function updatebatsmens($id){
			$record=explode("uid",$id);
			 
			 $id=$record[0];
			 $base64 = strtr($id, '-_~', '+/=');
             $id = $this->encrypt->decode($base64);
			
			 $teamid=$record[1];
			 $base64 = strtr($teamid, '-_~', '+/=');
           $teamid = $this->encrypt->decode($base64);
			
			 $matchid=$record[2];
			 
			 $base64 = strtr($matchid, '-_~', '+/=');
            $matchid = $this->encrypt->decode($base64);
		$post=$this->input->post();
		
		$data=array("totalruns"=>$post['totalruns'],
                    "totalCatches"=>$post['totalCatches'],
                    "totalfours"=>$post['totalfours'],
                   "totalhunderd"=>$post['totalhunderd'],
                   "totalfiftes"=>$post['totalfiftes'],
                    "sixes"=>$post['sixes'],
					"playedbowled"=>$post['playedbowled'],
					"missedbowled"=>$post['missedbowled'],
                    "playerid"=>$id,
					"teamid"=>$teamid,
					"matchid"=>$matchid);
		$data = $this->Matchdata->updatebatsmans($data);
		if($data){
		$this->session->set_flashdata("keeper","  Cearer  Record Is Successfully Updated.");
		$encrypted_id = $this->encrypt->encode($id);	
          $id = strtr ($encrypted_id, '+/=', '-_~');
		  
		  $encrypted_id = $this->encrypt->encode($id);	
          $teamid = strtr ($encrypted_id, '+/=', '-_~');
		  
		  $encrypted_id = $this->encrypt->encode($matchid);	
          $matchid = strtr ($encrypted_id, '+/=', '-_~');
		redirect('admin/MatchRecord/PlayerProfile/'.$id.'uid'.$teamid.'uid'.$matchid);}
		
		
		}
		public function updateWicketkeepers($id){
			 $base64 = strtr($id, '-_~', '+/=');
                        $id = $this->encrypt->decode($base64);
		$post=$this->input->post();
		$data = $this->palyersdata->updateWicketkeepers($id,$post);
		if($data){
		$this->session->set_flashdata("keeper"," Cearer Record Is Successfully Updated.");
		$encrypted_id = $this->encrypt->encode($id);	
          $id = strtr ($encrypted_id, '+/=', '-_~');
		redirect('admin/Players/updatePlayerProfile/'.$id);}
		
		
		}
		public function updateplyerss($id){
			 $base64 = strtr($id, '-_~', '+/=');
             $id = $this->encrypt->decode($base64);
		
		
		$post=$this->input->post();
		$data = $this->palyersdata->updateprofiles($id,$post);
		if($data){
		$this->session->set_flashdata("keeper"," Cearer Record Is Successfully Updated.");
		$encrypted_id = $this->encrypt->encode($id);	
          $id = strtr ($encrypted_id, '+/=', '-_~');

		redirect('admin/Players/updatePlayerProfile/'.$id);	
		//$data['userprofile'] = $this->palyersdata->userprofile($id);
		//print_r($data['userprofile']);
		//$this->load->view('admin/header');
		//$this->load->view('admin/Player_profile', $data);
		//$this->load->view('admin/footer');
		
		}
		}
		public function addteamrecordofmatch($id){
			$post=$this->input->post();
                        // echo "<pre>";
                        
                        // print_r($post);
			$record=explode("uid",$id);
			 
			 $id=$record[0];
			 $base64 = strtr($id, '-_~', '+/=');
             $matchid = $this->encrypt->decode($base64);
			
			 $teamid=$record[1];
			 $base64 = strtr($teamid, '-_~', '+/=');
      $teamid = $this->encrypt->decode($base64);
		  $post=array("total_runs"=>$post['totalruns'],"total_overplayed"=>$post['totalovers'],"totalWikets_lose"=>$post['wiketslose'],"winbyruns"=>$post['winlose'],"staus"=>$post['status'],"teamid"=>$teamid,"matchid"=>$matchid);
			
			 $data=$this->Matchdata->addteamrecordofmatch($post);
			if($data){
                           
            redirect('admin/MatchRecord/matches');
		
				}
			}
			
			
			public function updateTeamPoints($matchid){



				
				
			 $base64 = strtr($matchid, '-_~', '+/=');
             $matchid = $this->encrypt->decode($base64);	
			 
			 
			 $teamRank	=	$this->Matchdata->checkTeamRank('Winner',$matchid); 
			 
			 if(count($teamRank) >= 1){
				
				//Check wheather teams is in top 20 
				$topTwenty	=	$this->Matchdata->checkTeamInTopTwenty($teamRank[0]['looser_id']); 

				
				//Looser Exists in top 20
				if(count($topTwenty) >= 1){
					
					//Winner Team ID are in top 20
					$WinnerTeam	=	$this->Matchdata->checkTeamRank('Looser',$matchid);
					$teamIDWinner = $WinnerTeam[0]['winner_matchid'];
					$winner_winbyruns = $WinnerTeam[0]['winner_winbyruns'];
					$winner_teamid = $WinnerTeam[0]['winner_teamid'];


					$totalMatchOver		= $WinnerTeam[0]['winner_overplayed'];
					$over_played   = $WinnerTeam[0]['over_played'];


					//Get total over a team win before
					$overWinsBefore  = $totalMatchOver	- $over_played;

					//Earned 60 Pints because team In Top 20
					$totalEarnedPoints = 60;
					
					//Adding 5 Points if team win more than 28 runs margin
					if($winner_winbyruns >= 28){

						$totalEarnedPoints = $totalEarnedPoints+5;

					}

					//Add 5 Points if a team wins before total overs
					
					if($overWinsBefore >= 5){

						$totalEarnedPoints = $totalEarnedPoints+5;

					}

					//Update Team Points
					$winner_r	=	$this->Matchdata->updateTeamPoints($totalEarnedPoints,$winner_teamid,$teamIDWinner);
					$tea		=	$this->players_m->get_monthly_team_points($winner_teamid);
					$monthly_points 		= $tea[0]['monthly_points'];
					$overall_played_overs   = $tea[0]['overall_played_overs'];

					//Take Ranking Factor
					$rankingFactor = ($monthly_points / $overall_played_overs) * 10;

					$teamRF	=	$this->Matchdata->teamRF($winner_teamid,$rankingFactor); 

					
					if($teamRF){
                        $this->session->set_flashdata("team","Team Points Successfully Updated.");     
						redirect('admin/MatchRecord/matches');
						exit;
					}
					
					
				}else{
					 	
					//Winner Team ID Not in top 20
					$WinnerTeam	=	$this->Matchdata->checkTeamRank('Looser',$matchid);
					$teamIDWinner = $WinnerTeam[0]['winner_matchid'];
					$winner_winbyruns = $WinnerTeam[0]['winner_winbyruns'];
					$winner_teamid = $WinnerTeam[0]['winner_teamid'];


					$totalMatchOver		= $WinnerTeam[0]['winner_overplayed'];
					$over_played   = $WinnerTeam[0]['over_played'];


					//Get total over a team win before
					$overWinsBefore  = $totalMatchOver	- $over_played;

					//Earned 50 Pints because team not In Top 20
					$totalEarnedPoints = 50;
					
					//Adding 5 Points if team win more than 28 runs margin
					if($winner_winbyruns >= 28){

						$totalEarnedPoints = $totalEarnedPoints+5;

					}

					//Add 5 Points if a team wins before total overs
					
					if($overWinsBefore >= 5){

						$totalEarnedPoints = $totalEarnedPoints+5;

					}

					//Update Team Points
					$winner_r	=	$this->Matchdata->updateTeamPoints($totalEarnedPoints,$winner_teamid,$teamIDWinner);
					$tea		=	$this->players_m->get_monthly_team_points($winner_teamid);
					$monthly_points 		= $tea[0]['monthly_points'];
					$overall_played_overs   = $tea[0]['overall_played_overs'];
					
					//Take Ranking Factor
					$rankingFactor = ($monthly_points / $overall_played_overs) * 10;
					$teamRF	=	$this->Matchdata->teamRF($winner_teamid,$rankingFactor); 
						

					if($teamRF){
                        $this->session->set_flashdata("team","Team Points Successfully Updated.");   
						redirect('admin/MatchRecord/matches');
						exit;
		
					}
					
						
				}


				
			
				 
			 
				 
			 }
		     
			 
				
				
			}
			

				  
				  
				  
				  
				  }
?>