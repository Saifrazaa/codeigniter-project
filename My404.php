<?php class My404 extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct(); 
			$this->load->database();
            $this->load->helper('form');
            $this->load->helper('url');
            $this->load->model('Customization_Model','custom'); 
            $this->load->model('Login_model','login');
			$this->load->model('Player_model','allplayers');
		
    } 

    public function index() 
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
	
       // $this->output->set_status_header('404'); 
        $data['title'] ="Sorry the page you are requested is not found"; // View name 
        $this->load->view('header',$data);
		$this->load->view('404.php');
		$this->load->view('footer');
    } 
}
?> 