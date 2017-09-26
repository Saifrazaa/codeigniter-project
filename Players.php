<?php

error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Players extends CI_Controller {

    public function __construct() {
        parent::__construct();


        $this->load->helper('form');
        $this->load->database();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session');
		$this->load->model('admin/Team_model','teamdata');	
        $this->load->model('admin/Players_model', 'palyersdata');
    }

    public function index() {
        
    }

    public function addPlayers() {

        $post = $this->input->post();
        $playerofteamid = $post['playerOfteam'];

        $data1=(explode(",",$playerofteamid));


        $config['encrypt_name'] = TRUE;
        $config['upload_path'] = './uploads';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']  = '1048576';
	    $config['max_width']  = '1024';
	    $config['max_height'] = '768';
        
		//$config['max_size'] = ' 1048576';
        //$config['max_width'] = '50';
        //$config['max_height'] = '50';

        $this->load->library('upload', $config);
         if ( ! $this->upload->do_upload('playerimg'))
            {
           
            $this->session->set_flashdata('ok','Please upload image size not more than 1MB');
            redirect('admin/teams/Addplayers'); 		
            exit;						
								
								}
        if ($this->upload->do_upload('playerimg')) {

            $data = array('upload_data' => $this->upload->data());
            $image = $data['upload_data']['file_name'];


            
            
            $data = array(
                "name" => $post['name'],
                "email" => $post['email'],
                "password" => md5($post['password']),
                "age" => $post['age'],
                "contact" => $post['contact'],
                "gender" => $post['gender'],
                "playedteam" => $post['playedteam'],
                "playertype" => $post['playertype'],
               "playerroll" => $post['playerroll'],
                "image" => $image
            );

             // "playerOfteam" => $post['playerOfteam'],
            $data = $this->palyersdata->addplayers($data,$data1);
            if ($data) {
                $data['totalteams'] = $this->palyersdata->totalteams();
                $this->session->set_flashdata("Record", "Player is Inserted Successfully.");

  // This code is added by Jamil to send email

                $this->load->library('email');
                    $this->email->set_mailtype('html');
                 //   $this->email->from($from_email, 'Cricketers Database');
                    $this->email->from('root@localhost', 'Cricketers Database');
                  //  $this->email->to($emailsend);
                    $this->email->to($post['email']);
                    $this->email->subject('Cricketers Database Admin has added your player account');

                    $this->email->message('<h1>WELCOME TO CCRICKETERS DATABASE</h1> <br> Hello <u>' . $post['name'] . '</u> You have received this email because Admin has added your player account. You can now login to https://www.cricketersdb.com and update your password and other details.
                        
                         <br> <br> <br>Please use details given below to login on to cricketersdb.com website!<br> <br> <br> Email:' .$post['email'].'<br> <br>Password:  '.$post['password'].'<br> <br> Please contact us on info@cricketersdb.com if you have any problem<br><br> Thanks');
                    $this->email->send();

    // End of Jamil's email code

                $this->load->view('admin/header');
                $this->load->view('admin/add-Players', $data);
                $this->load->view('admin/footer');
                //redirect('admin/add-players');
            } else {
                $this->session->set_flashdata("Record", "Player is Not Inserted .");
                $data['totalteams'] = $this->palyersdata->totalteams();
                $this->load->view('admin/header');
                $this->load->view('admin/add-Players', $data);
                $this->load->view('admin/footer');
            }
        } else {

            $data = $this->palyersdata->addplayers($post,$data1);
            if ($data) {

                $this->session->set_flashdata("Record", "Player is Inserted Successfully.");

 // This code is added by Jamil to send email

                $this->load->library('email');
                    $this->email->set_mailtype('html');
                 //   $this->email->from($from_email, 'Cricketers Database');
                    $this->email->from('root@localhost', 'Cricketers Database');
                  //  $this->email->to($emailsend);
                    $this->email->to($post['email']);
                    $this->email->subject('Cricketers Database Admin has added your player account');

                    $this->email->message('<h1>WELCOME TO CCRICKETERS DATABASE</h1> <br> Hello <u>' . $post['name'] . '</u> You have received this email because Admin has added your player account. You can now login to https://www.cricketersdb.com and update your password and other details.
                        
                         <br> <br> <br>Please use details given below to login on to cricketersdb.com website!<br> <br> <br> Email:' .$post['email'].'<br> <br>Password:  '.$post['password'].'<br> <br> Please contact us on info@cricketersdb.com if you have any problem<br><br> Thanks');
                    $this->email->send();

    // End of Jamil's email code

                $this->load->view('admin/header');
                $this->load->view('admin/add-Players', $data);
                $this->load->view('admin/footer');
            } else {
                $data['totalteams'] = $this->palyersdata->totalteams();
                $this->load->view('admin/header');
                $this->load->view('admin/add-Players', $data);
                $this->load->view('admin/footer');
            }
        }
    }

    public function playerView() {

        $id = $this->session->userdata("userid");
        if ($id == NULL) {
            redirect(base_url() . 'index.php/admin');
        } else {
            $post = $this->input->post();
            if (!empty($post)) {
                $data['teamplyers'] = $this->palyersdata->teamplyers($post);

               if(empty($data['teamplyers']))
                {
                    $this->session->set_flashdata('emptyplayer','No player Register with that Team');
                    redirect('admin/Players/playerView');
                }
                else {


                $data['allplayers'] = $this->palyersdata->totalteams();
                $this->load->view('admin/header');
                $this->load->view('admin/showplayers', $data);
                $this->load->view('admin/footer');
            }
            }
             else {
                $data['allplayers'] = $this->palyersdata->totalteams();
                $this->load->view('admin/header');
                $this->load->view('admin/showplayers', $data);
                $this->load->view('admin/footer');
            }
        }
    }
	
    public function Player_profile($id) {
        $base64 = strtr($id, '-_~', '+/=');
        $id = $this->encrypt->decode($base64);

        $data['userprofile'] = $this->palyersdata->userprofile($id);
        $this->load->view('admin/header');
        $this->load->view('admin/Player_profile', $data);
        $this->load->view('admin/footer');
    }
	
	
	  public function edit_profile($id) {
        $base64 = strtr($id, '-_~', '+/=');
        $id = $this->encrypt->decode($base64);
		$data['viewteams']= $this->teamdata->totalteams();
        $data['playerprofile'] = $this->palyersdata->userprofile($id);
        $this->load->view('admin/header');
        $this->load->view('admin/edit_player', $data);
        $this->load->view('admin/footer');
    }
	
	
	
	
	  public function update_player($id) {
        $base64 = strtr($id, '-_~', '+/=');
        $id = $this->encrypt->decode($base64);
        
        $previoussrofplayer = $this->palyersdata->getplayertotalrec($id);
        
        $playersr = $previoussrofplayer[0]['sr'];
        
        
        if($previoussrofplayer[0]['sr'] < 100.00){
            
            $totalpoints = 0.85;
            
           
        }
        if($previoussrofplayer[0]['sr'] >= 100.00){
            
            $totalpoints  = 1;
            
            
        }
            
            
		$post = $this->input->post();
		
		//Get Strike rate
		$totalovers =  $post['totalovers']*6; //Over Played or bowled get total balls
		$totalruns  =  $post['totalruns'];
		$totalwikets  =  $post['totalwikets'];
		
		
				
		if($post['playertype'] == 'Bowler'){
			
			$str = ($totalovers / $totalwikets); //
			
		}else{
			
			
			$str = ($totalruns / $totalovers)*100; //
			
		}

        $data = $this->palyersdata->update_player_rec($post,$id,$str,$totalpoints);
        if ($data) {
            $this->session->set_flashdata("keeper", " Record Is Successfully Updated.");
            $encrypted_id = $this->encrypt->encode($id);
            $id = strtr($encrypted_id, '+/=', '-_~');
            redirect('admin/Players/playerprofile/'. $id);
			exit;
        }else{
			$this->session->set_flashdata("keeper", " Record Not Updated Please Try Again.");
            $encrypted_id = $this->encrypt->encode($id);
            $id = strtr($encrypted_id, '+/=', '-_~');
            redirect('admin/Players/playerprofile/'. $id);
			exit;
		}
    }
	
	
	

    public function playerprofile($id) {
        $base64 = strtr($id, '-_~', '+/=');
        $id = $this->encrypt->decode($base64);

        $data['playerprofile'] = $this->palyersdata->playerprofile($id);
        $this->load->view('admin/header');
        $this->load->view('admin/playerprofile', $data);
        $this->load->view('admin/footer');
    }

    public function updatebatsmen($id) {
        $base64 = strtr($id, '-_~', '+/=');
        $id = $this->encrypt->decode($base64);
        $post = $this->input->post();
        $data = $this->palyersdata->updatebatsman($id, $post);
        if ($data) {
            $this->session->set_flashdata("keeper", " Record Is Successfully Updated.");
            $encrypted_id = $this->encrypt->encode($id);
            $id = strtr($encrypted_id, '+/=', '-_~');
            redirect('admin/Players/Player_profile/' . $id);
        }
    }

    public function updateWicketkeeper($id) {
        $base64 = strtr($id, '-_~', '+/=');
        $id = $this->encrypt->decode($base64);
        $post = $this->input->post();
        $data = $this->palyersdata->updateWicketkeeper($id, $post);
        if ($data) {
            $this->session->set_flashdata("keeper", " Record Is Successfully Updated.");
            redirect('admin/Players/Player_profile/' . $id);
        }
    }

    public function updateplyers($id) {
        $base64 = strtr($id, '-_~', '+/=');
        $id = $this->encrypt->decode($base64);



        $post = $this->input->post();
        $data = $this->palyersdata->updateprofile($id, $post);
        if ($data) {
            $this->session->set_flashdata("keeper", " Record Is Successfully Updated.");
            $encrypted_id = $this->encrypt->encode($id);
            $id = strtr($encrypted_id, '+/=', '-_~');
            redirect('admin/Players/Player_profile/' . $id);
            //$data['userprofile'] = $this->palyersdata->userprofile($id);
            //print_r($data['userprofile']);
            //$this->load->view('admin/header');
            //$this->load->view('admin/Player_profile', $data);
            //$this->load->view('admin/footer');
        }
    }

    public function forGotPassword() {
         
        $this->load->view('admin/forgotpassword');
         $this->load->view('admin/header');
    }

    public function send_mail() {

        $from_email = "seeking@gmail.com";
        $to_email = $this->input->post('email');

        $data = $this->palyersdata->getpassword($to_email);
        if ($data[0]) {
            $password = $data[0]['admin_password'];


            //Load email library 
            $this->load->library('email');
            $this->email->from($from_email, 'conversio');
            $this->email->to($to_email);
            $this->email->subject('Recover Password');
            $this->email->message('Your Account Password Is :' . $password);
            $emi = $this->email->send();
            //exit;
            //Send mail 
            if ($emi == 1)
                $this->session->set_flashdata("email_sent", "Email sent successfully.");
            else
                $this->session->set_flashdata("email_sent", "Error in sending Email.");
            redirect('admin/Superadmin/');
        }else {
            $this->session->set_flashdata("email_sent", " This Email is not Exits.");
            $this->load->view('admin/Superadmin/');
        }
    }

    public function viewplayers() {
        $data['viewplyers'] = $this->palyersdata->viewplayer();
        $this->load->view('admin/header');
        $this->load->view('admin/viewplayers', $data);
        $this->load->view('admin/footer');
    }

    public function deleteplyer($id) {
        $base64 = strtr($id, '-_~', '+/=');
        $id = $this->encrypt->decode($base64);

        $data = $this->palyersdata->deleteplyer($id);
        if ($data) {
            $this->session->set_flashdata("email_sent", " Record  is Successfully Deleted.");
            redirect('admin/Players/viewplayers');
        }
    }

    public function verifye($id) {
        $base64 = strtr($id, '-_~', '+/=');
        $id = $this->encrypt->decode($base64);

        $data = $this->palyersdata->verifyeprofile($id);
        if ($data) {
            $this->session->set_flashdata("email_sent", " Player Is Successfully Verified.");
            redirect('admin/Players/viewplayers');
        }
    }

    public function updatePlayerProfile($id) {
        $base64 = strtr($id, '-_~', '+/=');
        $id = $this->encrypt->decode($base64);

        $data['updatePlayerProfile'] = $this->palyersdata->updatePlayerProfile($id);
        $data['allplayers'] = $this->palyersdata->totalteams();
        $this->load->view('admin/header');
        $this->load->view('admin/updatePlayerProfile', $data);
        $this->load->view('admin/footer');
    }

    public function updaterecord($id) {
        $base64 = strtr($id, '-_~', '+/=');
        $id = $this->encrypt->decode($base64);

        $from_email = "info@cricketersdb.com";
        $post = $this->input->post();
        
        if($post['checked'] =='check'){
            
            $emailsend = $post['user_email'];
            $passwordsend = $post['user_password'];
           
                    $this->load->library('email');
                    $this->email->set_mailtype("html");
                    $this->email->from($from_email, 'Cricketers Database');
                    $this->email->to($emailsend);
                    $this->email->subject('Updated Email and password');

                    $this->email->message('<h1>WELCOME TO CCRICKETERS DATABASE</h1><br>Hello <u>' . $post['user_name'] . '</u> You are receiving this email because you recently changed your email or password  at "<strong>Cricketers Database</strong>" <br><br><br>Please use details given below to login on to cricketersdb.com website!<br><br><br>Email:' .$emailsend.'<br><br>Password:  '.$passwordsend.'<br><br>Please contact us on info@cricketersdb.com if you have any problem<br><br>Thanks');



                    //Send mail 
                    if ($this->email->send()) {
                          $data = $this->palyersdata->updaterecord($id, $post);

                        if ($data) {
                            
                             $this->session->set_flashdata("useremailupdate", "Your profile is updated and email has been sent to your email given");
                             redirect('admin/Players/viewplayers');
                                 }
                        }
            
           
        }
        
        else {
            
       
        $data = $this->palyersdata->updaterecord($id, $post);

        if ($data) {
            $this->session->set_flashdata("keeper", " Profile Record Is Successfully Updated.");
            $encrypted_id = $this->encrypt->encode($id);
            $id = strtr($encrypted_id, '+/=', '-_~');
            redirect('admin/Players/updatePlayerProfile/' . $id);
        }
         }
    }

    public function updatebatsmens($id) {
        $base64 = strtr($id, '-_~', '+/=');
        $id = $this->encrypt->decode($base64);
        $post = $this->input->post();
        $data = $this->palyersdata->updatebatsmans($id, $post);
        if ($data) {
            $this->session->set_flashdata("keeper", "  Cearer  Record Is Successfully Updated.");
            $encrypted_id = $this->encrypt->encode($id);
            $id = strtr($encrypted_id, '+/=', '-_~');
            redirect('admin/Players/updatePlayerProfile/' . $id);
        }
    }

    public function updateWicketkeepers($id) {
        $base64 = strtr($id, '-_~', '+/=');
        $id = $this->encrypt->decode($base64);
        $post = $this->input->post();
        $data = $this->palyersdata->updateWicketkeepers($id, $post);
        if ($data) {
            $this->session->set_flashdata("keeper", " Cearer Record Is Successfully Updated.");
            $encrypted_id = $this->encrypt->encode($id);
            $id = strtr($encrypted_id, '+/=', '-_~');
            redirect('admin/Players/updatePlayerProfile/' . $id);
        }
    }

    public function updateplyerss($id,$match_id,$team_id) {
        $base64 = strtr($id, '-_~', '+/=');
		$id = $this->encrypt->decode($base64);
		
		$base642 = strtr($team_id, '-_~', '+/=');
		$team_id = $this->encrypt->decode($base642);
		
		$base643 = strtr($match_id, '-_~', '+/=');
		$match_id = $this->encrypt->decode($base643);
		
        $post = $this->input->post();
		

        $data = $this->palyersdata->addPlayerMatchRecord($post,$id,$match_id,$team_id);
        if ($data) {
            $this->session->set_flashdata("keeper", " Cearer Record Is Successfully Inserted.");
            $encrypted_id = $this->encrypt->encode($id);
            $id = strtr($encrypted_id, '+/=', '-_~');
			
			$encrypted_id2 = $this->encrypt->encode($team_id);
            $teamid = strtr($encrypted_id2, '+/=', '-_~');
			
			$encrypted_id3 = $this->encrypt->encode($match_id);
            $matchid = strtr($encrypted_id3, '+/=', '-_~');

            redirect('admin/MatchRecord/playerprofile/'.$id.'uid'.$matchid.'uid'.$teamid);
			exit;
            
        }
    }
	
	
	 public function updatePlayerMatchRec($id,$match_id,$team_id) {
        $base64 = strtr($id, '-_~', '+/=');
        $id = $this->encrypt->decode($base64);
		
		$base642 = strtr($team_id, '-_~', '+/=');
        $team_id = $this->encrypt->decode($base642);
		
		$base643 = strtr($match_id, '-_~', '+/=');
        $match_id = $this->encrypt->decode($base643);
		
        $post = $this->input->post();
		
      $data = $this->palyersdata->updateMatchRecord($post,$id,$match_id,$team_id);
		
		
        if ($data >0) {
            
            
//            $this->session->set_flashdata("keeper", " Cearer Record Is Successfully Updated.");
//            
//			$encrypted_id = $this->encrypt->encode($id);
//            $id = strtr($encrypted_id, '+/=', '-_~');
//			
//			$encrypted_id2 = $this->encrypt->encode($team_id);
//            $teamid = strtr($encrypted_id2, '+/=', '-_~');
//			
//			$encrypted_id3 = $this->encrypt->encode($match_id);
//            $matchid = strtr($encrypted_id3, '+/=', '-_~');
//
//
//  
            //redirect('admin/MatchRecord/teamprofile/'.$id.'uid'.$matchid.'uid'.$teamid);
            //admin/MatchRecord/teamprofile/'.$sentto.'uid'.$matchid
//
//						exit;
            
             
           redirect('admin/MatchRecord/matches');
            
            
        }
    }
    
    public function playerimgup($id){
        
      $base64 = strtr($id, '-_~', '+/=');
        $id = $this->encrypt->decode($base64);

        
        $config['encrypt_name'] = TRUE;
        $config['upload_path'] = './uploads';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '';
        $config['max_width'] = '200000000';
        $config['max_height'] = '1000000000000';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('playerimg')) {

            $data = array('upload_data' => $this->upload->data());
            $image = $data['upload_data']['file_name'];
        }
       
        if(empty($image)){
            
            redirect('admin/Players/viewplayers');
        }
        else{
            
            $data = $this->palyersdata->uploadimage($image,$id);
           
        if($data) {
            
                
            $encrypted_id = $this->encrypt->encode($id);	
            $id = strtr ($encrypted_id, '+/=', '-_~');

            redirect('admin/Players/playerprofile/'.$id);
        }
            
            
        }
        
        
        
       
      
    }
    
    public function fetchrecordinserted($playermatchRecId){
       

       $data = $this->palyersdata->fetchrecordinserted($playermatchRecId);

       
       $matchid = $data[0]['match_id'];
       $teamid = $data[0]['team_id'];
          
      
        $playermatchrec=array
		(       
          'totalruns' => $data[0]['total_runs'],
          'balls' => $data[0]['balls'],
          'total_overs' => $data[0]['total_overs'],
          'catches' => $data[0]['catches'],
          'wickets' => $data[0]['wickets'],
          'stumps' => $data[0]['stumps'],
          'how_come_out' => $data[0]['how_come_out'],
          'how_got_out' => $data[0]['how_got_out'],
          'drop_catches' => $data[0]['drop_catches'],
          'wickets_taken_by' => $data[0]['wickets_taken_by'],
          'is_man_of_match' => $data[0]['is_man_of_match'],
          'fours' => $data[0]['fours'],
          'sixes' => $data[0]['sixes'],
          'no_balls' => $data[0]['no_balls'],
          'wide_balls' => $data[0]['wide_balls'],
          'player_type' => $data[0]['player_type'],
          'match_id' => $data[0]['match_id'],
          'team_id' => $data[0]['team_id'],
          'player_id' => $data[0]['player_id'],
		  'bowler_given_runs' => $data[0]['bowler_given_runs'],
		  
      );
  
      
      $this->session->set_userdata('playermatchrecord',$playermatchrec);

	  
      $playerid = $data[0]['player_id'];
      
      $playertotalrec = $this->palyersdata->getplayertotalrec($playerid);


      //$matchreciD=  $playertotalrec[0]['plyr_matchrec_id'];   
	   $resetedballs       =      $playertotalrec[0]['balls']  - $data[0]['balls'] ;
	   $resetedruns        =      $playertotalrec[0]['totalruns'] -  $data[0]['total_runs'];
	   $resetedovers       =      $playertotalrec[0]['totalovers'] - $data[0]['total_overs'];
	   $resetedcatches     =      $playertotalrec[0]['totalCatches'] - $data[0]['catches'];
	   $resetedwickets     =      $playertotalrec[0]['totalwikets'] -$data[0]['wickets'] ;
	   $resetedstuns       =      $playertotalrec[0]['totalstuns']  - $data[0]['stumps'];
	   $resetedfours       =      $playertotalrec[0]['totalfours'] - $data[0]['fours'] ;
	   $resetedsixes       =      $playertotalrec[0]['sixes'] - $data[0]['sixes'];
	   $resetednoballs     =      $playertotalrec[0]['total_no_balls']  -$data[0]['no_balls'];
	   $resetedwhiteballs  =      $playertotalrec[0]['total_white_balls'] - $data[0]['wide_balls'];
	   $resetedwhiteballs  =      $playertotalrec[0]['bowler_given_runs'] - $data[0]['bowler_given_runs'];
	  
		
		
	   if($playertotalrec[0]['how_come_out']  != "notout"){
		   
		   
		   $got_out = $data[0]['got_out']-1;
		   
	   }	
		
		
		
		

	 $totalfiftes     =      	  $data[0]['total_runs'];
	$totalhund     =      	  $data[0]['total_runs'];
	 
		if($totalfiftes < 50 && $totalfiftes >= 0){
			
			
			$totalfift = $totalfiftes-1;
			
		}
		
		if($totalhund >= 50 && $totalhund <= 100){
			
			
			$totalhunderd = $totalhund-1;
			
		}
		$totalMatchesplayed     =  $playertotalrec[0]['totalMatchesplayed']-1;
	    $resetedwhiteballs  =      $playertotalrec[0]['total_white_balls'] - $data[0]['wide_balls'];
     

	 
     $updatetotaldata =array(
     
         'balls'       =>    $resetedballs,
         'totalruns'   =>    $resetedruns,
         'totalovers'  =>    $resetedovers,
         'totalCatches'=>    $resetedcatches,
         'totalwikets' =>    $resetedwickets,
         'totalstuns'  =>    $resetedstuns,
         'totalfours'  =>    $resetedfours,
         'sixes'       =>    $resetedsixes,
		 'totalfiftes' =>	 $totalfift,
		 'totalhunderd' =>	 $totalhunderd,
         'total_no_balls' => $resetednoballs,
         'total_white_balls' =>$resetedwhiteballs,
		 'totalMatchesplayed' =>$totalMatchesplayed,
		 'bowler_given_runs' => $bowler_given_runs,
		 'got_out' => $got_out
       );
    
     $data  =   $this->palyersdata->updateplayertotalRecord($updatetotaldata,$playerid);

     if($data >0){
         
        $datadeleted = $this->palyersdata->deletematchrecord($playermatchRecId);
         
        
        if($datadeleted >0){
            
            $data = $this->session->userdata('playermatchrecord');
                   
            
           $matchid =$data['match_id'];
           $playerid =$data['player_id'];
           $teamid =$data['team_id]'];
           
           
           
         
            $encrypted_id1 = $this->encrypt->encode($playerid);	
            $id = strtr ($encrypted_id1, '+/=', '-_~');
            
            $encrypted_id = $this->encrypt->encode($matchid);	
            $matchid = strtr ($encrypted_id, '+/=', '-_~');
            
            
            $encrypted_id2 = $this->encrypt->encode($teamid);	
            $teamid = strtr ($encrypted_id2, '+/=', '-_~');
           
           
           redirect('admin/MatchRecord/playerprofile/'.$id.'uid'.$matchid.'uid'.$teamid);
          
        }
        
//        $this->load->view('admin/header');
//        $this->load->view('admin/updatePlayerProfile', $data);
//        $this->load->view('admin/footer');
         
     }
     
   
      
        
        
    }
    
    
     public function updatepassword(){
        $id = $this->session->userdata("aid");  
        $adminpass = $this->session->userdata("apass");  
        $post = $this->input->post();
     
        
        if($adminpass == $post['oldpassword'] && $post['oldpassword'] !=''){
            
            $data = $this->palyersdata->updatepass($post,$id);
            
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