<?php

error_reporting(1);

defined('BASEPATH') OR exit('No direct script access allowed');



class Home extends CI_Controller {

	public function __construct() {
    parent::__construct();
    
            $this->load->database();
            $this->load->library('session');
            $this->load->helper('form');
            $this->load->helper('url');
            $this->load->model('Customization_Model','custom'); 
            $this->load->model('Login_model','login');
			$this->load->model('Player_model','allplayers');
			//$this->load->model('Player_model','teamplayer');
			
    // Load form helper library
		//$this->load->helper('form');
//		$this->load->database();
//		$this->load->helper(array('form', 'url'));
//		// Load form validation library
//		$this->load->library('form_validation');
//		//load image of user
//		$this->load->library('upload');
//		// Load session library
//		$this->load->library('session');
		//$this->load->helper('url');
		// Load database
		//$this->load->model('Contactforms');
              //$this->load->model('Players_model','palyersdata');
	}

	/**

	 * Index Page for this controller.

	 *

	 * Maps to the following URL

	 * 		http://example.com/index.php/welcome

	 *	- or -

	 * 		http://example.com/index.php/welcome/index

	 *	- or -

	 * Since this controller is set as the default controller in

	 * config/routes.php, it's displayed at http://example.com/

	 *

	 * So any other public methods not prefixed with an underscore will

	 * map to /index.php/welcome/<method_name>

	 * @see https://codeigniter.com/user_guide/general/urls.html

	 */

	

	/* Home Page */

	public function index()

	{
        

		$data['title'] = "Welcome to Cricketers Database, arrange matches, create team, players, cricket news, video and much more";
		
        $data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
		
      
        $overs   = $this->allplayers->get_loser_teamover();
        $winners = $this->allplayers->get_winner_teamover();
        foreach($winners as $w_over){
          
      foreach($overs as $l_over){
          
    if($l_over['teamid']==$w_over['teamid']){ 
     $totalovers = $l_over['totalovers'] + $w_over['totalovers'];
     $team_id = $w_over['teamid'];
     
     $w_over['teamid'] = '';
     $l_over['totalovers']=''; 
     $w_over['totalovers']='';
     $this->allplayers->get_win_loser_result($team_id,$totalovers);
    }
     
     
   } 
   
   
   
  }

  if(!empty($w_over['teamid']) && !empty($w_over['totalovers'])){
   $totalovers = $w_over['totalovers'];
   $team_id = $w_over['teamid'];
  }elseif(!empty($l_over['teamid']) && !empty($l_over['totalovers'])){
   $totalovers = $l_over['totalovers'];
   $team_id = $l_over['teamid'];
  }
   $this->allplayers->get_win_loser_result($team_id,$totalovers); 
        

       
        
        
        $this->load->view('Header',$data);
        $this->load->view('Home');
        $this->load->view('Footer');

	}

	

	/* Matches Page */

	public function matches()

	{	
		$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      		$data['title'] = "Upcoming Matches & Recent Matches results";
                $data['upcommatch'] = $this->allplayers->upcomingmatches();
                $data['helddmatches'] = $this->allplayers->heldmatches();
                
				
				$data['tt'] = $this->allplayers->heldmatches_time();
                $this->load->view('Header');
                
				
		$this->load->view('Matches',$data);
                $this->load->view('Footer');

	}
      
				public function addGroundFr(){
					
					$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      
        $overs   = $this->allplayers->get_loser_teamover();
        $winners = $this->allplayers->get_winner_teamover();
					
					$data['title'] = "Grounds";
						$this->load->helper('captcha');
        $vals = array(
            'img_path' => './captcha/',
            'img_url' => 'http://dev.smartwaress.com/cricket/captcha/'
        );

        $cap = create_captcha($vals);
        $data = array(
            'captcha_time' => $cap['time'],
            'ip_address' => $this->input->ip_address(),
            'word' => $cap['word']
        );

        $query = $this->db->insert_string('captcha', $data);
        $querya = $this->db->query($query);
        $data['capimg'] = $cap['image'];

						  
						  $this->load->view('Header');
						  $this->load->view('Ground_reg',$data);
						  $this->load->view('Footer');
							
						  }


	  
        public function matchesresult($id){
			
		$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      
            $base64 = strtr($id, '-_~', '+/=');
            $id = $this->encrypt->decode($base64);
			
            $data['winnerteam'] = $this->allplayers->matchresultwinnerteam($id);
            $data['looserteam'] = $this->allplayers->matchresultlooserteam($id);
         //   $data['bowler'] = $this->allplayers->bowlerprofile($id);
         //   $data['looserteambowler'] = $this->allplayers->looserbowlerprofile($id);
		 
		
		    $data['playersData'] = $this->allplayers->playersData($id);     
           
				$this->load->view('Header');
				$this->load->view('HeldMatchdetail',$data);
                $this->load->view('Footer');
            

        }
        
        public function singlePlayerdetail($id){
			
			$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      
            
            $data['players'] = $this->allplayers->singleplayer($id);
                   $this->load->view('Header');
                   $this->load->view('Playershow',$data);
                   $this->load->view('Footer');
            
        }




        /* Players Page */

	public function players()

	{
		      $data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
        $data['sociallink'] = $this->custom->get_social_links_model();
        $data['contact_info'] = $this->custom->get_contact_information_post_model();
        
      
        $overs   = $this->allplayers->get_loser_teamover();
        $winners = $this->allplayers->get_winner_teamover();
        
        $data['title'] = "Players";
        $data['playersverified']= $this->allplayers->playersverified();
        $this->load->view('Header',$data);
        $this->load->view('Players');
        $this->load->view('Footer');


	}
        
        public function getTeamPlayer(){
			
			$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      
        $overs   = $this->allplayers->get_loser_teamover();
        $winners = $this->allplayers->get_winner_teamover();
            
            $check=$this->input->post('teamidd');
            
            //echo "Controller".$check['teamidd'];
            
             $teamplayers=$this->allplayers->getTeamPlayers($check);
             echo json_encode($teamplayers);
            
            
        }
        
        public function getallTeamPlayer(){
			
			$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      
        $overs   = $this->allplayers->get_loser_teamover();
        $winners = $this->allplayers->get_winner_teamover();
            
              $checkss=$this->input->post('teamname');
            
              
              
             $teamplayers=$this->allplayers->getallTeamPlayer($checkss);
             echo json_encode($teamplayers);
            
        }

        public function teamplayers()

	{
		
		$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      
        $overs   = $this->allplayers->get_loser_teamover();
        $winners = $this->allplayers->get_winner_teamover();
		//echo "hellllo";
		$data = array(
           'id'=>$this->input->post('id'),
		  );
		  if(isset($data)){
			$getRecords =  $this->load->model('Player_model');
			$playmain = $this->Player_model->mainPlay($data);
			// set text compatible IE7, IE8
  			header('Content-type: text/plain'); 
  			// set json non IE
  			header('Content-type: application/json'); 

 	 		echo json_encode($playmain);
			//print_r($data);
			//$this->load->view('header');
			//$this->load->view('players',$data);
			//$this->load->view('footer');
			//echo "success";
		}
		//print_r($tid);
		//echo "yes";
		//echo $pid;
		//$data['playersverified']= $this->teamplayer->mainPlay($data);
//		$this->load->view('header');
//		$this->load->view('players',$data);
//		$this->load->view('footer');

	}

	

	/* Teams Page */

	public function teams()

	{
		
		$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      
	 $data['title'] = "Teams";	
     $data['playersverified'] = $this->login->totalverifyteams();
		
     
     $this->load->view('Header',$data);
     $this->load->view('Teams');
     $this->load->view('Footer');

	}

	

	/* Tournaments Page */

	public function tournaments()

	{
		
		$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      
       
		 $data['title'] = "Tournaments";
		
                $data['tournamentsmatches'] = $this->allplayers->tournaments();
                
		$this->load->view('Header',$data);
		$this->load->view('Tournaments');
		$this->load->view('Footer');
                

	}
        
        public function tournamentsdetails($id){
			
			$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      
           $base64 = strtr($id, '-_~', '+/=');
            $id = $this->encrypt->decode($base64);
            
            
               $data['tournamentDetails'] = $this->allplayers->tournamentsdetails($id);
               $data['grounds'] = $this->allplayers->tournamentgrounds($id);
               $data['teams'] = $this->allplayers->tournamentteams($id);
               $data['Allteams'] = $this->allplayers->teamplayers();
               $data['matchdetails'] = $this->allplayers->matchdetailsold($id);
               $data['matchresult'] = $this->allplayers->matchesresult($id);
                
				$this->load->view('Header');
				$this->load->view('Tournamentdetail',$data);
				$this->load->view('Footer');
       }
       
//         public function tournamentgrounds(){
//           
//                $post=$this->input->post('tourna');
//                $grounds = $this->allplayers->tournamentgrounds($post);
//                echo json_encode($grounds);
//               
//           
//           
//       }
       
//       public function tournamentteams(){
//                $post=$this->input->post('teamidd');
//                $teams = $this->allplayers->tournamentteams($post);
//                echo json_encode($teams);
//           
//       }

              public function tournamentTeamplayers(){
				  
				  $data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      
          
           $post = $this->input->post();
           $tournplayers = $this->allplayers->tournamentTeamplayers($post);
           echo json_encode($tournplayers);
       }




       /* Grounds Page */

	public function grounds()

	{
		
		$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      
       $data['title'] = "Grounds";
		$this->load->model('Maingrounds');
		$data['grounds'] = $this->Maingrounds->viewgrounds();
		//print_r($data);
		$this->load->view('Header',$data);
		$this->load->view('Grounds');
		$this->load->view('Footer');

	}

// Jamil Ahmed code
// Change following code to add something in records page.

    public function records()

    {
        
        $data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
         $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
        $data['sociallink'] = $this->custom->get_social_links_model();
        $data['contact_info'] = $this->custom->get_contact_information_post_model();
        $data['playerrank']=$this->allplayers->batsmanranking();
        $data['bowlerrank']=$this->allplayers->bowlerranking();
      
        $overs   = $this->allplayers->get_loser_teamover();
        $winners = $this->allplayers->get_winner_teamover();
        $data['title'] = "Records";
        $this->load->model('Records_model');
        //$data['records'] = $this->Maingrounds->viewgrounds();
        
        $this->load->view('Header',$data);
        $this->load->view('Ranking');
        $this->load->view('Footer');

    }

// End of Jamil Ahmed code	

	/* Contact Page */

	public function contact()

	{
		$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      
        $data['title'] = "Contact us";
        $this->load->view('Header');
		$this->load->view('Contact',$data);
        $this->load->view('Footer');
	}

	

	/* Register Page */

	public function register()

	{
		$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      
       		$data['title'] = "Registrations Teams, Players";
                $this->load->view('Header',$data);
			    $this->load->view('Register');
                $this->load->view('Footer');

	}

	

	/* Login Page */

	public function login()

	{
		$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      $data['title'] = "Login to your account";
					
					$id = $this->session->userdata('user_id');
                 $teamid = $this->session->userdata('team_id');
         
                     if(isset($id) && $id != '') {
                   
                   $data['players'] = $this->login->getplayers($id);
                   $this->load->model('player_model','player');
                   $videourl=$this->player->getvideourl($id);
                   $this->load->view('Header',$data);
                   $this->load->view('Playershow');
                   $this->load->view('Footer');
             
             
         }
         elseif(isset ($teamid) && $teamid != '') {
                $teamownerdata['teamownerprofile'] =  $this->login->getTeamOwner($teamid);
                
                $this->load->view('Teamdashboard/Header');
                $this->load->view('Teamdashboard/TeamOwnerDashboard',$teamownerdata);
                $this->load->view('Teamdashboard/Footer');
             
         }
         
         else {
                $this->load->view('Header',$data);
			    $this->load->view('Login');
                $this->load->view('Footer');
         }

	}
        
        
        public function logout() {
			$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      
            
            $this->session->sess_destroy();
      
             redirect(base_url());

        }
        
        public function editprofile($id){
			
			$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      
        	
            $data['title'] = "Edit Profile";
            $base64 = strtr($id, '-_~', '+/=');
            $id = $this->encrypt->decode($base64);
             
             $data['userdata'] = $this->login->editprofile($id);
             $data['userdatateams'] = $this->login->getallteams();		

             $this->load->view('Header');
             $this->load->view('Editprofile',$data);
             $this->load->view('Footer');
        }




        /* Singleplayer Page */

	public function singlePlayer($id)

	{
		$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      
               $data['playerData']  = $this->allplayers->singleplayerprofile($id);
                $this->load->view('Header');
		$this->load->view('SinglePlayer',$data);
                $this->load->view('Footer');

	}

	

	/* Upcoming match Page */

	public function upcomingMatchdetail($id)

	{
		$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
              //$data['matchdetail']  = $this->allplayers->matchtdetailsold($id);
				$base64 = strtr($id, '-_~', '+/=');
        		$id = $this->encrypt->decode($base64);
                $data['matchdetail']  = $this->allplayers->matchtdetailsoldnew($id);
		
                
                $this->load->view('Header');
                $this->load->view('UpcomingMatchdetail',$data);
                $this->load->view('Footer');

	}
        
        public function upcomingMatchdetailresult($id){
			$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      
//                $data['matchdetail']  = $this->allplayers->matchtdetails($id);
//		$this->load->view('header');
//                $this->load->view('upcomingmatchresult',$data);
//                $this->load->view('footer');
             $data['winnerteam'] = $this->allplayers->matchresultwinnerteam($id);
            $data['looserteam'] = $this->allplayers->matchresultlooserteam($id);
         //   $data['bowler'] = $this->allplayers->bowlerprofile($id);
         //   $data['looserteambowler'] = $this->allplayers->looserbowlerprofile($id);
		 
		
		    $data['playersData'] = $this->allplayers->playersData($id);     
           
				$this->load->view('Header');
				$this->load->view('HeldMatchdetail',$data);
                $this->load->view('Footer');
            
        }




        /* held match Page */

	public function heldMatchdetail()

	{
		$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      
       
		$this->load->view('HeldMatchdetail');

	}

	

	/*registration*/

	

	public function registrationUser(){

		$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      
		//echo $d =$_POST["name"];

		

		//echo $post  = $this->input->post();

		$data = array(

			

			"user_name"=> $_POST['name'],

			"user_email"=> $_POST['email'],

			"user_country"=> $_POST['country'],

			"user_gender"=> $_POST['gender'],

			"user_password"=> $_POST['password'],

			"user_cpassword"=> $_POST['confirmpassword'],

		);

		

		//print_r($data);

		$this->load->model('registration');

		$this->registration->register($data);

	}
	
	/*Contact form submission*/
	
		public function contactform()
		{
			$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      $this->load->library(array('session', 'email'));
		
		$contactMsg = array(

			"name"=> $_POST['name'],

			"email"=> $_POST['email'],

			"phone"=> $_POST['phone'],

			"suggestion"=> $_POST['suggestion'],

		);
		//print_r($contactMsg);

            $name = $this->input->post('name');
            $from_email = $this->input->post('email');
            $subject = $this->input->post('phone');
           $message = $this->input->post('suggestion');



$htmlmsg = "Name:".$name."\n\nFrom:".$from_email."\n\nPhone:".$subject."\n\nSuggestion:".$message;

            //set to_email id to which you want to receive mails
           $to_email = 'jamil_redhat@hotmail.com';

            //configure email settings
            			$from_email = "Info@cricketersdb.com"; 
				 		 //$to_email = $post['email']; 
				   
						 //Load email library 
				 		 $this->load->library('email'); 
				   
				 		 $this->email->from($from_email, 'Cricketers Database
'); 
				 		 $this->email->to($to_email);
				 		 $this->email->subject('Email '); 
				 		 $this->email->message($htmlmsg); 
				   
				// 		 Send mail 
			
            if ($this->email->send())
            {
                // mail sent
                $this->session->set_flashdata('msg','<div class="alert alert-success text-center">Your mail has been sent successfully!</div>');
                redirect('Home/contact');
            }
            else
            {
                //error
               $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">There is error in sending mail! Please try again later</div>');
                redirect('Home/contact');
            }
			
			$this->load->model('Contactforms');

			$this->Contactforms->contactdetail($contactMsg);
			
			
        }
		
		/* Ground Detail Page Controller*/
		   public function groundDetail($gid){
			   $data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      	$base64 = strtr($gid, '-_~', '+/=');
            $gid = $this->encrypt->decode($base64);
                        
            $data['grodundDetails'] = $this->login->getGround($gid);
            $data['hometeams'] = $this->login->hometeams($gid);
					
			$this->load->view('Header');
			$this->load->view('GroundDetail',$data);
			$this->load->view('Footer');
		}
                
                   
                public function viewallnews(){
					$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      
                    $total_rows = $this->allplayers->count_news();
					$this->load->library("pagination");
					$config = array();
					$config["base_url"] = base_url()."index.php/Home/viewallnews";
					$config["total_rows"] = $total_rows;
					$config["per_page"] = 10;
					$config["uri_segment"] = 3;
					$config['cur_tag_open'] = '<li class="active"><a>';
					$config['cur_tag_close'] = '</a></li>';
					$config['next_tag_open'] = '<li>';
					$config['next_tag_close'] = '</li>';
					$config['prev_tag_open'] = '<li>';
					$config['prev_tag_close'] = '</li>';
					$config['num_tag_open'] = '<li>';
					$config['num_tag_close'] = '</li>';
				    $this->pagination->initialize($config);
					$page = $this->uri->segment(3);
                    $data['allnews']  = $this->allplayers->getallnews($config['per_page'],$page);
					$data["title"] = 'Latest News';
					$data['links'] = $this->pagination->create_links();
                    $this->load->view('Header',$data);
                    $this->load->view('Getnews');
                    $this->load->view('Footer');
                }
                
                public function viewallvideos(){
					$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
      			$total_rows = $this->allplayers->count_Videos();
					$this->load->library("pagination");
					$config = array();
					$config["base_url"] = base_url()."index.php/Home/viewallvideos";
					$config["total_rows"] = $total_rows;
					$config["per_page"] = 6;
					$config["uri_segment"] = 3;
					$config['cur_tag_open'] = '<li class="active"><a>';
					$config['cur_tag_close'] = '</a></li>';
					$config['next_tag_open'] = '<li>';
					$config['next_tag_close'] = '</li>';
					$config['prev_tag_open'] = '<li>';
					$config['prev_tag_close'] = '</li>';
					$config['num_tag_open'] = '<li>';
					$config['num_tag_close'] = '</li>';
				    $this->pagination->initialize($config);
					$page = $this->uri->segment(3);
                    $data['videos']  = $this->allplayers->getallVideos($config['per_page'],$page);
					$data['links'] = $this->pagination->create_links();
					$data['title'] = "Video Gallery";
       				$this->load->view('Header',$data);
                    $this->load->view('Getallvideos');
                    $this->load->view('Footer');
                    
                    
                }
                
                public function updatepassword(){
					$data['topplayers'] = $this->allplayers->Topplayers();
        $data['matchrequests'] = $this->allplayers->upcomingevents();
        $data['leaderboard'] = $this->allplayers->leaderboard();
        $data['totalmatches'] = $this->allplayers->totalmatches();
        $data['tornaments'] = $this->allplayers->totaltournaments();
        $data['totalplayerssss'] = $this->allplayers->totalplayerscount();
        $data['totalteamsc'] = $this->allplayers->totalteamscount();
        $data['topteams'] = $this->allplayers->topteams();
        $data['recaddedpla'] = $this->allplayers->Recentaddedplayers();
        $data['recaddedTeam'] = $this->allplayers->Recentaddedteams();
        $data['about_usData'] = $this->custom->getAboutUsContent();
        $data['newsData'] = $this->custom->getNewsAll();
        $data['videos'] = $this->custom->getVideosAll();
		$data['sociallink'] = $this->custom->get_social_links_model();
		$data['contact_info'] = $this->custom->get_contact_information_post_model();
		
                 
                    $this->load->view('Header');
                    $this->load->view('Updatepasswordform');
                    $this->load->view('Footer');
                    
                    
                }
               
                
              
    }  



