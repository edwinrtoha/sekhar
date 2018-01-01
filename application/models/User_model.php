<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");
class user_model extends CI_Model{
	function semua_data_user(){
		$query=$this->db->query("SELECT * FROM trx");
		return $query->result();
	}
}