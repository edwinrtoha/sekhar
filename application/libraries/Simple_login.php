<?php if(! defined('BASEPATH')) exit('Akses langsung tidak diperbolehkan'); 

class Simple_login {
	// SET SUPER GLOBAL
	var $CI = NULL;
	public function __construct() {
		$this->CI =& get_instance();
	}
	// Fungsi login
	public function login($username, $password) {
		$query = $this->CI->db->get_where('user',array('username'=>$username,'password' => $password));
		if($query->num_rows() == 1) {
			$row 	= $this->CI->db->query('SELECT id FROM user where username = "'.$username.'"');
			$admin 	= $row->row();
			$id 	= $admin->id;
			$this->CI->session->set_userdata('username', $username);
			$this->CI->session->set_userdata('id_login', uniqid(rand()));
			$this->CI->session->set_userdata('id', $id);
			redirect(base_url('dashboard'));
		}
		else{
			$this->CI->session->set_flashdata('sukses','Oops... Username/password salah');
			redirect(base_url('login'));
		}
		return false;
	}
	// login with oauth
	public function login_oauth($oauth_uid){
		$query = $this->CI->db->get_where('user',array('google_uid'=>$oauth_uid));
		if($query->num_rows() == 1) {
			$row 	= $this->CI->db->query('SELECT * FROM user where google_uid = "'.$oauth_uid.'"');
			$admin 	= $row->row();
			$id 	= $admin->id;
			$this->CI->session->set_userdata('username', $admin->username);
			$this->CI->session->set_userdata('id_login', uniqid(rand()));
			$this->CI->session->set_userdata('id', $id);
			redirect(base_url('dashboard'));
		}
		else{
			$this->CI->session->set_flashdata('sukses','Oops... Username/password salah');
			redirect(base_url('login'));
		}
		return false;
	}
	// Proteksi halaman
	public function cek_login() {
		if($this->CI->session->userdata('username') == '') {
			// $this->CI->session->set_flashdata('login_status','0');
			return 0;
		}
		else{
			// $this->CI->session->set_flashdata('login_status','1');
			return 1;
		}
	}
	// Fungsi logout
	public function logout() {
		$this->CI->session->unset_userdata('username');
		$this->CI->session->unset_userdata('id_login');
		$this->CI->session->unset_userdata('id');
		$this->CI->session->set_flashdata('sukses','Anda berhasil logout');
		redirect(base_url('login'));
	}
	// Login Profil
	public function user_login(){
		if($this->CI->session->userdata('id')){
			$uid=$this->CI->session->userdata('id');
			$query=$this->CI->db->query("SELECT * FROM `user` WHERE `id` = '$uid'");
			return $query->result();
		}
	}
}