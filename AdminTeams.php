<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
		$this->load->view('home');
	}
	
	/* Matches Page */
	public function matches()
	{
		$this->load->view('Matches');
	}
	
	/* Players Page */
	public function players()
	{
		$this->load->view('players');
	}
	
	/* Teams Page */
	public function teams()
	{
		$this->load->view('teams');
	}
	
	/* Tournaments Page */
	public function tournaments()
	{
		$this->load->view('tournaments');
	}
	
	/* Grounds Page */
	public function grounds()
	{
		$this->load->view('grounds');
	}
	
	/* Contact Page */
	public function contact()
	{
		$this->load->view('contact');
	}
	
	/* Register Page */
	public function register()
	{
		$this->load->view('register');
	}
	
	/* Login Page */
	public function login()
	{
		$this->load->view('login');
	}
	
	/* Singleplayer Page */
	public function singlePlayer()
	{
		$this->load->view('singlePlayer');
	}
	
	/* Upcoming match Page */
	public function upcomingMatchdetail()
	{
		$this->load->view('upcomingMatchdetail');
	}
	
	/* held match Page */
	public function heldMatchdetail()
	{
		$this->load->view('heldMatchdetail');
	}
	
	/*registration*/
	
	public function registrationUser(){
		
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
}
