<?php
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed'); 


class Records extends CI_Controller {
    
    function __construct() {
        
        parent::__construct();
            $this->load->database();
            $this->load->library('session');
            $this->load->helper('form');
            $this->load->helper('url');
            $this->load->library('encrypt');
     //       $this->load->helper('captcha');
            $this->load->model('Records_model','recordmodel');
        
    }
    
     public function index() {
             
            
        }
        
        public function recordView() {
			
			          $data['title'] = "Records";
                $this->load->view('header',$data);
                $this->load->view('teamview');
                $this->load->view('footer');
            
        }
        
    
        }


?>