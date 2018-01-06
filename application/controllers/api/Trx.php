<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	require APPPATH . '/libraries/REST_Controller.php';
	use Restserver\Libraries\REST_Controller;

	class Trx extends REST_Controller {

		function __construct($config = 'rest') {
			parent::__construct($config);
			$this->load->database();
		}

		function index_get() {
			$id = $this->get('id');
			$uid = $this->get('uid');
			$type=$this->get('type');
			if ($id != '') {
				$this->db->where('id', $id);
			}
			if($uid!=''){
				$this->db->where('uid',$uid);
			}
			if($type!='' && (strtolower($type)=="masuk" || strtolower($type)=="keluar")){
				$this->db->where('type',strtolower($type));
			}
			$trx = $this->db->get('trx')->result();
			$this->response($trx, 200);
		}
		function index_post(){
			$uid=$this->post('uid');
			$name=$this->post('name');
			$desc=$this->post('desc');
			$type=strtolower($this->post('type'));
			$nominal=$this->post('nominal');
			$trx_datetime=$this->post('trx_datetime');
			$input_datetime=$this->post('input_datetime');
			$trx_number=$this->post('trx_number');
		}
	}
?>