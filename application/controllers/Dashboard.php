<?php if ( ! defined('BASEPATH')) exit("No direct script access allowed");
class Dashboard extends CI_Controller {
	var $CI = NULL;
	public function __Construct(){
		$this->CI =& get_instance();
		parent ::__construct();
		$this->breadcrumbs->push('<i class="fa fa-dashboard"></i> Dashboard', "/dashboard");
	}
	public function index(){
		$login=$this->simple_login->cek_login();
		if($login==0){
			redirect(base_url('login'));
		}
		else{
			$this->load->model("main_model");
			$data=array("title"=>$this->main_model->title("Dashboard"),"content"=>"dashboard/dashboard_view");
			$this->load->view("dashboard/layout/wrapper",$data);
		}
	}
	public function fblogin(){
		
	}
	public function admin($sub=""){
		$login=$this->simple_login->cek_login();
		if($login==0){
			redirect(base_url('login'));
		}
		else{
			$this->breadcrumbs->push('Administrator', "/dashboard/admin");
			$data_user=$this->simple_login->user_login();
			foreach($data_user as $row){
				$role=$row->role;
				if($role==1){
					if(empty($sub) or $sub==""){
					}
					else{
						if($sub=="users"){
							$this->load->model("main_model");
							$this->breadcrumbs->push('Pengguna', "/dashboard/admin/users");
							if(isset($_GET["view"])){
								$view=$_GET["view"];
								unset($_GET["view"]);
								if($view=="add"){
									$this->breadcrumbs->push('Tambah Baru', "/dashboard/admin/users?view=add");
									$data=array("title"=>$this->main_model->title("Tambah Pengguna"),"content"=>"dashboard/admin/users/users_add_view");
								}
								elseif($view=="edit"){
									if(isset($_GET["id"])){
										$id=$_GET["id"];
										$this->breadcrumbs->push('Edit', "/dashboard/admin/users?view=edit&id=".$id);
										unset($_GET["id"]);
										if(empty($id) or $id==""){
										}
										else{
											$this->load->model("main_model");
											$data=array("title"=>$this->main_model->title("Edit Pengguna"),"content"=>"dashboard/admin/users/users_edit_view");
											$data["data_user"] = $this->main_model->user_single($id);
											$data["data_uid"]=$id;
										}
									}
								}
								elseif($view=="detail"){
									if(isset($_GET["id"])){
										$id=$_GET["id"];
										unset($_GET["id"]);
										if(empty($id) or $id==""){
										}
										else{
											$this->load->model("main_model");
											$data=array("title"=>$this->main_model->title("Detail Transaksi"),"content"=>"dashboard/admin/users/users_detail_view");
											$data["data_user"]=$this->main_model->user_single($id);
										}
									}
									else{
									}
								}
								else{
								}
							}
							elseif(isset($_GET["act"])){
								$act=$_GET["act"];
								unset($_GET["act"]);
								if($act=="add"){
									$this->load->model("main_model");
									$this->main_model->admin_user_add();
									redirect(base_url('dashboard/admin/users'));
								}
								elseif($act=="edit"){
									if(isset($_GET["id"])){
										$id=$_GET["id"];
										unset($_GET["id"]);
										$this->load->model("main_model");
										$this->main_model->admin_user_edit($id);
										redirect(base_url('dashboard/admin/users'));
									}
									else{
									}
								}
								elseif($act=="del"){
									$this->load->model("main_model");
									$this->main_model->admin_user_del();
									redirect(base_url('dashboard/admin/users'));
								}
								else{
								}
							}
							else{
								$this->load->model("main_model");
								$data=array("title"=>$this->main_model->title("Pengguna"),"content"=>"dashboard/admin/users/users_list_view");
							}
							$this->load->view("dashboard/layout/wrapper",$data);
						}
						else{
						}
					}
				}
				else{
					redirect(base_url('dashboard'));
				}
			}
		}
	}
	public function trx(){
		$this->load->model("main_model");
		$this->breadcrumbs->push('Transaksi', "/dashboard/trx");
		$login=$this->simple_login->cek_login();
		if($login==0){
			redirect(base_url('login'));
		}
		else{
			$data=array("title"=>"","content"=>"");
			if(isset($_GET["view"])){
				$view=$_GET["view"];
				unset($_GET["view"]);
				if($view=="add"){
					$this->breadcrumbs->push('Tambah Baru', "/dashboard/trx?view=add");
					$data=array("title"=>$this->main_model->title("Transaksi Baru"),"content"=>"dashboard/trx/trx_add_view");
				}
				elseif($view=="edit"){
					if(isset($_GET["id"])){
						$id=$_GET["id"];
						unset($_GET["id"]);
						if(empty($id) or $id==""){
						}
						else{
							$this->breadcrumbs->push('Edit', "/dashboard/trx?view=edit&id=".$id);
							$this->load->model("main_model");
							$data=array("title"=>$this->main_model->title("Edit Transaksi"),"content"=>"dashboard/trx/trx_edit_view","id"=>$id);
							$data["data_trx"] = $this->main_model->trx_single($id);
						}
					}
				}
				elseif($view=="detail"){
					if(isset($_GET["id"])){
						$id=$_GET["id"];
						unset($_GET["id"]);
						if(empty($id) or $id==""){
						}
						else{
							$this->load->model("main_model");
							$data=array("title"=>$this->main_model->title("Detail Transaksi"),"content"=>"dashboard/trx/trx_detail_view");
							$data["data_trx"]=$this->main_model->trx_single($id);
						}
					}
					else{
					}
				}
				elseif($view=="test"){
					$this->load->model("main_model");
					$data=array("title"=>$this->main_model->title("Detail Transaksi"),"content"=>"dashboard/trx/trx_test_view");
				}
			}
			elseif(isset($_GET["act"])){
				$act=$_GET["act"];
				unset($_GET["act"]);
				if($act=="add"){
					$this->load->model("main_model");
					$this->main_model->trx_add();
					redirect(base_url('dashboard/trx'));
				}
				elseif($act=="edit"){
					$this->load->model("main_model");
					$this->main_model->trx_edit();
					redirect(base_url('dashboard/trx'));
				}
				elseif($act=="del"){
					$this->load->model("main_model");
					$this->main_model->trx_del();
					redirect(base_url('dashboard/trx'));
				}
			}
			else{
				$this->load->model("main_model");
				$data=array("title"=>$this->main_model->title("Transaksi"),"content"=>"dashboard/trx/trx_list_view");
				$data["data_trx"] = $this->main_model->trx_list();
			}
			$this->load->view("dashboard/layout/wrapper",$data);
		}
	}
	public function invoice(){
		if(isset($_POST["start"])){
			$this->load->model("main_model");
			$start=$_POST["start"];
			unset($_POST["start"]);
			if(isset($_POST["end"])){
				$end=$_POST["end"];
				unset($_POST["end"]);
				$data=array("title"=>$this->main_model->title("Faktur (".$start." - ".$end.")"),"content"=>"dashboard/invoice/invoice_result_view");
				$data["start"]=$start;
				$data["end"]=$end;
			}
			else{
			}
		}
		else{
			$data=array("title"=>$this->main_model->title("Faktur"),"content"=>"dashboard/invoice/invoice_index_view");
		}
		$this->load->view("dashboard/layout/wrapper",$data);
	}
	public function setting(){
		$login=$this->simple_login->cek_login();
		if($login==0){
			redirect(base_url('login'));
		}
		else{
			$this->breadcrumbs->push('Setting', "/dashboard/setting");
			$this->load->helper("phpgangsta");
			$this->load->model("main_model");
			if(isset($_GET["view"])){
				$view=$_GET["view"];
				unset($_GET["view"]);
				if($view=="two-step-verification"){
					$this->breadcrumbs->push('Verifikasi 2 Langkah', "/dashboard/setting?view=two-step-verification");
					$this->load->helper("phpgangsta");
					$data["ga"]=new PHPGangsta_GoogleAuthenticator();
					if(isset($_GET["act"])){
						$act=$_GET["act"];
						unset($_GET["act"]);
						if($act=="save"){
							$data=array("title"=>$this->main_model->title(),"content"=>"");
							$this->load->model("main_model");
							$this->main_model->setting_account_two_step_save();
						}
					}
					else{
						$data=array("title"=>$this->main_model->title("Verifikasi 2 Langkah"),"content"=>"dashboard/setting/setting_2step_view");
					}
				}
				$data["ga"]=new PHPGangsta_GoogleAuthenticator();
			}
			elseif(isset($_GET["act"])){
				$act=$_GET["act"];
				unset($_GET["act"]);
				if($act=="update"){
					$this->main_model->setting_account_update();
					$data=array("title"=>$this->main_model->title(),"content"=>"");
					redirect(base_url('dashboard/setting/account'));
				}
			}
			else{
				$this->breadcrumbs->push('Akun', "/dashboard/setting/account");
				$data=array("title"=>"Dashboard - Sistem Laporan Keuangan Harian","content"=>"dashboard/setting/setting_account_view");
			}
			$this->load->view("dashboard/layout/wrapper",$data);
		}
	}
}