<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model{
       public function __construct()
        {
                parent::__construct();
               
        }
        
        public function verifyemail($data){
          $email =$data['email'];
          $password = md5($data['password']);
			
         
            $query = $this->db->get_where('users',array('user_email'=>$data['email'],'user_password'=>$password));

              //$query = $this->db->query("Select * from users Where user_email ='".$data['email']."'  && user_password = '".$password."'");
              $data= $query->result_array();
            
             
             if(empty($data)){

         $query=$this->db->get_where('teams',array('team_owneremail'=>$email,'team_ownerpass'=>$password));
			 //$query = $this->db->query("SELECT * FROM Teams WHERE team_owneremail ='".$email."'  && team_ownerpass = '".$password."'");
             $data= $query->result_array();
              
              
             if(!empty($data)){

               return $data;
            }
            else{
                $this->session->set_flashdata('invalidep','your email or password is incorrect');
                redirect('Home/login');
              }
             
             
            }else{
                
                 return $data;
                
            }
        }
        
        public function getplayers($playerid) {
            
            /*$this->db->select('user_name','user_email','contact','image','playertype','video','videourl')->from('users')->where('id',$playerid);
            $query=$this->db->get();*/
            $query=$this->db->get_where('users',['id'=>$playerid]);
            //$query = $this->db->query("SELECT user_name,user_email,contact,image,playertype,video,videourl,totalfours,sixes,totalruns,totalcatches,bestperformance,total FROM users WHERE id='".$playerid."'");
            return $query->result_array();
            
        }

        public function editprofile($id) {
             //$query = $this->db->get_where('users',array('id'=>$id));
            $query = $this->db->query("SELECT * FROM users WHERE id ='".$id."'");
            return $query->result_array();
        }
        
        public function getallteams() {
             $this->db->select('*')->from('teams');
             $query =$this->db->get();
           // $query = $this->db->query("SELECT team_id,team_name FROM Teams");
            return $query->result_array();
        }
        
        public function getTeamOwner($getTeamOwnerid) {
            $query = $this->db->get_where('teams',array('team_id'=>$getTeamOwnerid));

            //$query = $this->db->query("SELECT * FROM Teams WHERE team_id ='".$getTeamOwnerid."'");
            return $query->result_array();
        }
		public function totalverifyteams() {
           $this->db->select()->from('teams')->join('grounds','grounds.ground_id=teams.Grounds','LEFT')->where('teams.verify',1);
             $query=$this->db->get();
            //$query = $this->db->query("SELECT * FROM Teams LEFT JOIN Grounds ON Grounds.ground_id = Teams.Grounds WHERE Teams.verify ='1'");
            return $query->result_array();
        }
        
        public function getGround($id){
            $query = $this->db->get_where('grounds',array('ground_id'=>$id));

            //$query =$this->db->query("SELECT * FROM Grounds WHERE ground_id ='".$id."'");
            return $query->result_array();
            
        }
        public function hometeams($id){
             $this->db->select()->from('teams AS t')->join('grounds AS g','g.ground_id=t.Grounds','INNER')->where('t.grounds',$id);
             $query=$this->db->get();
             //$query =$this->db->query("SELECT * FROM Teams t INNER JOIN Grounds g ON g.ground_id = t.Grounds WHERE t.Grounds ='".$id."'");
             return $query->result_array();
        }
        
        public function updatepassword($post,$useridd,$userpassword){
            
            $data=array('user_password' =>$post['password']);
            $this->db->where('id',$useridd);
            return $this->db->update('users',$data);
            
        }
        
       
    
}
?>