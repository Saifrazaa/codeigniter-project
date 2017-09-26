<?php

error_reporting(1);

defined('BASEPATH') OR exit('No direct script access allowed');



class Searchp extends CI_Controller { 
    
    public function __construct() {
    parent::__construct();
    
            $this->load->database();
            $this->load->library('session');
            $this->load->helper('form');
            $this->load->helper('url');
            $this->load->model('Search_model','searchmodel');
    }
    
    
    
    
  
    public function searchplayer() {
        
       $post = $this->input->post();
       $data['values'] =$this->searchmodel->getplayer($post);
        
 
       
                $this->load->view('Header');
		$this->load->view('Searchview',$data);
                $this->load->view('Footer');
       
       
       
            }
    
    
    
}

?>