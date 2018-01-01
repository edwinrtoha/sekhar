<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {
	public function index() {
		$login=$this->simple_login->cek_login();
		if($login==0){
			$data['custom_head']=array('<meta name="robots" content="noindex, nofollow">');
			if(isset($_GET['act'])){
				$act=$_GET['act'];
				unset($_GET['act']);
			}
			else{
				$this->load->model("main_model");
				$data=array('title'=>$this->main_model->title("LOGIN"),'content'  =>'login/login_index_view');
				$valid = $this->form_validation;
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$valid->set_rules('username','Username','required');
				// $valid->set_rules('password','Password','required');
				if($valid->run()){
					$password=md5($password);
					$query=$this->db->query("SELECT `id`,`secret_key`,`password` FROM `user` WHERE `username` = '$username' AND `password` = '$password'");
					if($query->num_rows()==1){
						foreach($query->result() as $row){
							if($row->secret_key!=""){
								$this->session->set_flashdata('uid',$row->id);
								redirect(base_url("login/checkpoint"));
							}
							else{
								$this->simple_login->login($username,$password, base_url('dashboard'), base_url('login'));
							}
						}
					}
					else{
					}
				}
				$this->load->view("login/layout/wrapper",$data);
			}
		}
		else{
			redirect(base_url('dashboard'));
		}
	}
	public function checkpoint(){
		$this->session->set_flashdata("uid",$this->session->flashdata("uid"));
		$this->load->model("main_model");
		if($this->session->flashdata("uid")){
			$data=array('title'=>$this->main_model->title("Checkpoint"),'content'  =>'login/login_checkpoint_view');
			$uid=$this->session->flashdata("uid");
			$valid = $this->form_validation;
			$otp = $this->input->post('otp');
			$valid->set_rules('otp','OTP','required');
			if($valid->run()){
				$this->load->helper("phpgangsta");
				$ga=new PHPGangsta_GoogleAuthenticator();
				$query=$this->db->query("SELECT * FROM `user` WHERE `id` = '$uid'");
				if($query->num_rows()==1){
					foreach($query->result() as $row){
						$username=$row->username;
						$password=$row->password;
						$secret=$row->secret_key;
						$check=$ga->verifyCode($secret, $otp);
						if($check){
							// $this->session->set_flashdata("uid",$uid);
							$this->simple_login->login($username,$password, base_url('dashboard'), base_url('login'));
						}
						else{
							$this->session->set_flashdata('sukses',"OTP salah");
							redirect(base_url("login/checkpoint"));
						}
					}
				}
				else{
					redirect(base_url("login/checkpoint"));
				}
				$this->CI->session->set_flashdata("uid",$uid);
				$this->simple_login->login($username,$password, base_url('dashboard'), base_url('login'));
			}
		}
		else{
			redirect(base_url("login"));
		}
		$this->load->view("login/layout/wrapper",$data);
	}
	public function oauth($method){
		$this->load->model("main_model");
		if($method=="connect"){
			$login=$this->simple_login->cek_login();
			if($login==0){
			}
			else{
				$this->load->model("main_model");
				$uid=$this->session->userdata('id');
				$provider=strtolower($this->uri->segment(4));
				if($provider=="facebook"){
					$app_id = "1777891955860386";
					$app_secret = "6decd2dce27efa10408cb89383c7188f";
					$provider	= $this->oauth2->provider($provider, array(
						'id' => $app_id,
						'secret' => $app_secret,
					));
				}
				elseif($provider=="google"){
					$app_id="147322293976-7u9isdmla52mk21fj4h5adng8d5le347.apps.googleusercontent.com";
					$app_secret="g2qdszxa4oKO2WSW1JxuiyUH";
					$provider=$this->oauth2->provider($provider, array(
						'id' => $app_id,
						'secret' => $app_secret,
					));
				}
				else{
				}
				if (!$this->input->get('code')){
					// By sending no options it'll come back here
					$provider->authorize();
					redirect('social?error');
				}
				else{
					// Howzit?
					try{
						$token = $provider->access($_GET['code']);
						$user = $provider->get_user_info($token);
					}
					catch (OAuth2_Exception $e){
						show_error('That didnt work: '.$e);
					}
					$oauth_uid=$user["uid"];
					// echo $oauth_uid;
					$this->db->query("UPDATE `user` SET `google_uid` = '$oauth_uid' WHERE `id` = '$uid'");
					redirect(base_url("dashboard/setting/account"));
				}
			}
		}
		else{
			$login=$this->simple_login->cek_login();
			if($login==0){
				$provider=$this->uri->segment(3);
				if($provider=="fb"){
				}
				elseif($provider=="google"){
					$app_id="147322293976-7u9isdmla52mk21fj4h5adng8d5le347.apps.googleusercontent.com";
					$app_secret="g2qdszxa4oKO2WSW1JxuiyUH";
					$provider=$this->oauth2->provider($provider, array(
						'id' => $app_id,
						'secret' => $app_secret,
						));
				}
				else{
				}
				if (!$this->input->get('code')){
						// By sending no options it'll come back here
						$provider->authorize();
						redirect('social?error');
				}
				else{
					// Howzit?
					try{
						$token = $provider->access($_GET['code']);
						$user = $provider->get_user_info($token);
					}
					catch (OAuth2_Exception $e){
						show_error('That didnt work: '.$e);
					}
					$oauth_uid=$user["uid"];
					// echo $oauth_uid;
					$query=$this->db->query("SELECT * FROM `user` WHERE `google_uid` = '$oauth_uid'");
					$num_rows=$query->num_rows();
					if(empty($num_rows) or $num_rows==""){
					}
					elseif($num_rows==1){
						$this->simple_login->login_oauth($oauth_uid, base_url('dashboard'), base_url('login'));
					}
				}
			}
			else{
			}
		}
	}
	public function logout() {
		$this->simple_login->logout();
	}
}