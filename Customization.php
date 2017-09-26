<?php
	error_reporting(1);
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Customization extends CI_Controller {

			public function __construct() 
			
			{
				parent::__construct();
				$this->load->helper('form');
				$this->load->database();
				$this->load->helper(array('form', 'url'));
				$this->load->library('form_validation');
				$this->load->library('session');
				$this->load->model('Customization_Model','custom');
				
			}

			public function index()
			{
				
				//echo "Customization";

			}
			
			public function about_us()
			{
				$id=$this->session->userdata("userid");
				if ($id == NULL) {
				redirect(base_url().'index.php/admin');
				}else{
					
				$data['title'] = "About Us Edit";
				$data['about_usData'] = $this->custom->getAboutUsContent();
				
				$this->load->view('admin/header',$data);
				$this->load->view('admin/about_us');
				$this->load->view('admin/footer');

			}
			
			}
			
			public function update($pageName){
				
				
				if($pageName == "aboutUS"){
					
					$pageData = $this->input->post();
					
					$contents = str_replace("../../../",base_url(),$pageData['content']);
					$config['encrypt_name'] = TRUE;
					$config['upload_path'] = './uploads';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size'] = '';
					$config['max_width'] = '200000000';
					$config['max_height'] = '1000000000000';

					$this->load->library('upload', $config);

					if ($this->upload->do_upload('userfile')) {

						$data = array('upload_data' => $this->upload->data());
						$image = $data['upload_data']['file_name'];
					}
					
					if($image == ""){

						$dataAbout = array('page_content'=>$contents,'the_title'=>$pageData['title']);
						$data = $this->custom->updateAboutUsContent($dataAbout);
						
						if($data)
						{
							   $msg = '<div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Success!</strong> Page Content Updated 1
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							   redirect('admin/Customization/about_us');
							   exit;
						}else{
							
							   $msg = '<div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Error!</strong> There is problem updating page please try again in few minutes.
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							    redirect('admin/Customization/about_us');
							   exit;
							
							
						}
						
					}else{
						$dataAbout = array('page_content'=>$contents,'content_image'=>$image,'the_title'=>$pageData['title']);
						$data = $this->custom->updateAboutUsContent($dataAbout);
						
						if($data)
						{
							   $msg = '<div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Success!</strong> Page Content Updated 
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							    redirect('admin/Customization/about_us');
							   exit;
						}else{
							
							   $msg = '<div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Error!</strong> There is problem updating page please try again in few minutes.
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							    redirect('admin/Customization/about_us');
							   exit;
							
							
						}
						
					}
						
						
						
					}else{
						
						redirect('Customization/about_us');
						
					}
					
				
				
			}
			
			public function social_links(){
			
				
				$this->load->view('admin/header');
				$this->load->view('admin/social_links');
				$this->load->view('admin/footer');
				
			}
			
			public function social_links_post(){
			
				
				$id=$this->session->userdata("userid");
				if ($id == NULL )
					{
							redirect(base_url().'index.php/admin');
					}
				else{
				
					$sociallink = $this->input->post();
					$data = $this->custom->social_links_post_model($sociallink);
				if($data){
					
					$msg = '<div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Success!</strong> record has been added
                            </div>';
							   $this->session->set_flashdata("social_link",$msg);
				redirect(base_url().'index.php/admin/customization/social_links');
				}
				}
				
				
			}
			
			public function contact_information(){
				

					//$pageInfo = $this->input->post();
					$this->load->view('admin/header');
					$this->load->view('admin/contact_information');
					$this->load->view('admin/footer');
				
			}
			
			public function contact_information_post(){
				
				$id=$this->session->userdata("userid");
				if ($id == NULL ) {
				redirect(base_url().'index.php/admin');
				}
				else{
				
				$contactInfo = $this->input->post();
				$data = $this->custom->contact_information_post_model($contactInfo);
				if($data){
					
					$msg = '<div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Success!</strong> record has been added
                            </div>';
							   $this->session->set_flashdata("contact_information",$msg);
				redirect(base_url().'index.php/admin/customization/contact_information');
				}
				}
				
			}
			
			public function postVideo()
			{
		
				$id=$this->session->userdata("userid");
				if ($id == NULL ) {
				redirect(base_url().'index.php/admin');
				}else{
					
				$data['title'] = "Upload A Video";

				$this->load->view('admin/header',$data);
				$this->load->view('admin/post_video');
				$this->load->view('admin/footer');

			}
			
			}
			
			
			public function videoGallery()
			{
		
				$id=$this->session->userdata("userid");
				if ($id == NULL ) {
				redirect(base_url().'index.php/admin');
				}else{
					
				$data['title'] = "Video Gallery";
				$data['newsData'] = $this->custom->getVideosAll();

				$this->load->view('admin/header',$data);
				$this->load->view('admin/video_gallery');
				$this->load->view('admin/footer');

			}
			
			}
			
			public function upload_video()
			{
		
				$id=$this->session->userdata("userid");
				if ($id == NULL ) {
				redirect(base_url().'index.php/admin');
				}else{
					
					
					
					$pageData = $this->input->post();

					
					$contents = str_replace("../../../",base_url(),$pageData['content']);
					$config['encrypt_name'] = TRUE;
					$config['upload_path'] = './uploads';
					$config['allowed_types'] = 'mp4';
					$config['max_size'] = '';
					$config['max_width'] = '200000000';
					$config['max_height'] = '1000000000000';

					$this->load->library('upload', $config);

					if ($this->upload->do_upload('userfile')) {

						$data = array('upload_data' => $this->upload->data());
						$image = $data['upload_data']['file_name'];
					}
					
					if($image == ""){

						$dataAbout = array('video_path'=>$contents,'title'=>$pageData['title'],'upload_type'=>'embed');
						$data = $this->custom->post_aVideo($dataAbout);
						
						if($data)
						{
							   $msg = '<div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Success!</strong> Video Uploaded
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							   redirect('admin/customization/postVideo');
							   exit;
						}else{
							
							   $msg = '<div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Error!</strong> There is problem Uploading Video please try again in few minutes.
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							   redirect('admin/customization/postVideo');
							   exit;
							
							
						}
						
					}else{
						$dataAbout = array('video_path'=>$image,'title'=>$pageData['title'],'upload_type'=>'uploaded');
						$data = $this->custom->post_aVideo($dataAbout);
						
						if($data)
						{
							   $msg = '<div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Success!</strong> Video Uploaded
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							   redirect('admin/customization/postVideo');
							   exit;
						}else{
							
							   $msg = '<div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Error!</strong> There is problem Uploading video please try again in few minutes.
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							   redirect('admin/customization/postVideo');
							   exit;
							
							
						}
						
					}
				

			}
			
			
			
			}
			public function post_news()
			{
				$id=$this->session->userdata("userid");
				if ($id == NULL) {
				redirect(base_url().'index.php/admin');
				}else{
					
				$data['title'] = "Post A News";

				$this->load->view('admin/header',$data);
				$this->load->view('admin/news');
				$this->load->view('admin/footer');

			}
			
			}
			
			
			public function news_description($newsId = "")
			{
		
					
				$data['title'] = "Post A News";
				$data['newsData'] = $this->custom->getSingleNews($newsId);

				$this->load->view('header',$data);
				$this->load->view('single');
				$this->load->view('footer');

			
			}
			
			
			public function get_news()
			{
		
				$id=$this->session->userdata("userid");
				if ($id == NULL) {
				redirect(base_url().'index.php/admin');
				}else{
					
				$data['title'] = "News List";
				$data['newsData'] = $this->custom->getNewsAll();

				$this->load->view('admin/header',$data);
				$this->load->view('admin/get_news');
				$this->load->view('admin/footer');

			}
			
			}
			public function dlt_news($newsId)
			{
		
				$id=$this->session->userdata("userid");
				if ($id == NULL || $newsId == NULL) {
				redirect(base_url().'index.php/admin');
				}else{

				$result  = $this->custom->delete_aNews($newsId);
				
				if($result)
						{
							   $msg = '<div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Success!</strong> News Deleted
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							   redirect('admin/customization/get_news/'.$newsId);
							   exit;
						}else{
							
							   $msg = '<div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Error!</strong> There is problem deleting news please try again in few minutes.
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							   redirect('admin/customization/get_news/'.$newsId);
							   exit;
							
							
						}

			}
			
			}
			
			
			public function dlt_video($newsId)
			{
		
				$id=$this->session->userdata("userid");
				if ($id == NULL || $newsId == NULL) {
				redirect(base_url().'index.php/admin');
				}else{

				$result  = $this->custom->delete_Video($newsId);
				
				if($result)
						{
							   $msg = '<div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Success!</strong> Video Deleted
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							   redirect('admin/customization/videoGallery/');
							   exit;
						}else{
							
							   $msg = '<div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Error!</strong> There is problem deleting video please try again in few minutes.
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							   redirect('admin/customization/videoGallery/');
							   exit;
							
							
						}

			}
			
			}
			
			
			public function edit_news($newsId)
			{
		
				$id=$this->session->userdata("userid");
				if ($id == NULL || $newsId == NULL) {
				redirect(base_url().'index.php/admin');
				}else{
					
				$data['title'] = "Update A News";
				$data['about_usData'] = $this->custom->getSingleNews($newsId);

				$this->load->view('admin/header',$data);
				$this->load->view('admin/update_news');
				$this->load->view('admin/footer');

			}
			
			}
			
			
			public function edit_video($videoId)
			{
		
				$id=$this->session->userdata("userid");
				if ($id == NULL || $videoId == NULL) {
				redirect(base_url().'index.php/admin');
				}else{
					
				$data['title'] = "Update A Video";
				$data['newsData'] = $this->custom->getSingleVideo($videoId);
				
				

				$this->load->view('admin/header',$data);
				$this->load->view('admin/edit_video');
				$this->load->view('admin/footer');

			}
			
			}
			
			
			
			public function post_news_process(){
					
					$id=$this->session->userdata("userid");
					if ($id == NULL) {
					redirect(base_url().'index.php/admin');
					}
					
					$pageData = $this->input->post();
					$contents = str_replace("../../../",base_url(),$pageData['content']);
					$config['encrypt_name'] = TRUE;
					$config['upload_path'] = './uploads';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size'] = '';
					$config['max_width'] = '200000000';
					$config['max_height'] = '1000000000000';

					$this->load->library('upload', $config);

					if ($this->upload->do_upload('userfile')) {

						$data = array('upload_data' => $this->upload->data());
						$image = $data['upload_data']['file_name'];
					}
					
					if($image == ""){

						$dataAbout = array('news_content'=>$contents,'news_title'=>$pageData['title']);
						$data = $this->custom->post_aNews($dataAbout);
						
						if($data)
						{
							   $msg = '<div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Success!</strong> News Posted 
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							   redirect('admin/customization/post_news');
							   exit;
						}else{
							
							   $msg = '<div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Error!</strong> There is problem posting news please try again in few minutes.
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							   redirect('admin/customization/post_news');
							   exit;
							
							
						}
						
					}else{
						$dataAbout = array('news_content'=>$contents,'featured_image'=>$image,'news_title'=>$pageData['title']);
						$data = $this->custom->post_aNews($dataAbout);
						
						if($data)
						{
							   $msg = '<div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Success!</strong> News Posted
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							   redirect('admin/customization/post_news');
							   exit;
						}else{
							
							   $msg = '<div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Error!</strong> There is problem posting news please try again in few minutes.
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							   redirect('admin/customization/post_news');
							   exit;
							
							
						}
						
					}
						
					
				
				
			}
			
			
			
			public function update_news($newsID=""){
					
					$id=$this->session->userdata("userid");
					if ($id == NULL) {
					redirect(base_url().'index.php/admin');
					}
					
					$pageData = $this->input->post();
					$content = str_replace("../../../",base_url(),$pageData['content']);
					$contents = str_replace("../","",$content);
					$config['encrypt_name'] = TRUE;
					$config['upload_path'] = './uploads';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size'] = '';
					$config['max_width'] = '200000000';
					$config['max_height'] = '1000000000000';

					$this->load->library('upload', $config);

					if ($this->upload->do_upload('userfile')) {

						$data = array('upload_data' => $this->upload->data());
						$image = $data['upload_data']['file_name'];
					}
					
					if($image == ""){

						$dataAbout = array('news_content'=>$contents,'news_title'=>$pageData['title']);
						$data = $this->custom->update_aNews($dataAbout,$newsID);
						
						if($data)
						{
							   $msg = '<div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Success!</strong> News Updated 
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							   redirect('admin/customization/edit_news/'.$newsID);
							   exit;
						}else{
							
							   $msg = '<div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Error!</strong> There is problem updaing news please try again in few minutes.
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							   redirect('admin/customization/edit_news/'.$newsID);
							   exit;
							
							
						}
						
					}else{
						$dataAbout = array('news_content'=>$contents,'featured_image'=>$image,'news_title'=>$pageData['title']);
						$data = $this->custom->update_aNews($dataAbout,$newsID);
						
						if($data)
						{
							   $msg = '<div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Success!</strong> News Updated
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							   redirect('admin/customization/post_news/'.$newsID);
							   exit;
						}else{
							
							   $msg = '<div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Error!</strong> There is problem updating news please try again in few minutes.
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							   redirect('admin/customization/post_news/'.$newsID);
							   exit;
							
							
						}
						
					}
						
					
				
				
			}
			
			
			public function update_video($newsID){
				
				$id=$this->session->userdata("userid");
					if ($id == NULL || $newsID == "") {
					redirect(base_url().'index.php/admin');
					}
					
					$pageData = $this->input->post();
					$contents = str_replace("../../../",base_url(),$pageData['content']);
					$config['encrypt_name'] = TRUE;
					$config['upload_path'] = './uploads';
					$config['allowed_types'] = 'mp4';
					$config['max_size'] = '';
					$config['max_width'] = '200000000';
					$config['max_height'] = '1000000000000';

					$this->load->library('upload', $config);

					if ($this->upload->do_upload('userfile')) {

						$data = array('upload_data' => $this->upload->data());
						$image = $data['upload_data']['file_name'];
					}
					
					if($image == ""){

						$dataAbout = array('video_path'=>$contents,'title'=>$pageData['title']);
						$data = $this->custom->update_aVideo($dataAbout,$newsID);
						
						if($data)
						{
							   $msg = '<div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Success!</strong> Video Updated 
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							   redirect('admin/customization/edit_video/'.$newsID);
							   exit;
						}else{
							
							   $msg = '<div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Error!</strong> There is problem updaing Video please try again in few minutes.
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							   redirect('admin/customization/edit_video/'.$newsID);
							   exit;
							
							
						}
						
					}else{
						$dataAbout = array('video_path'=>$image,'title'=>$pageData['title']);
						$data = $this->custom->update_aVideo($dataAbout,$newsID);
						
						if($data)
						{
							   $msg = '<div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Success!</strong> Video Updated
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							   redirect('admin/customization/edit_video/'.$newsID);
							   exit;
						}else{
							
							   $msg = '<div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Error!</strong> There is problem updating Video please try again in few minutes.
                            </div>';
							   $this->session->set_flashdata("team",$msg);
							   redirect('admin/customization/edit_video/'.$newsID);
							   exit;
							
							
						}
						
					}
					
				
				
			}
			


	}
	
?>
