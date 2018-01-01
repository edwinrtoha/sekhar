<?php
    if ( ! defined("BASEPATH")) exit("No direct script access allowed");
    class main_model extends CI_Model{
        var $CI = NULL;
        public function __construct() {
            $this->CI =& get_instance();
        }
        function semua_data_user(){
            $query=$this->db->query("SELECT * FROM trx");
            return $query->result();
        }
        function trx_list($limit=0,$offset=0){
            $uid=$this->session->userdata('id');
            if(isset($_POST['s'])){
                $s=$_POST['s'];
                unset($_POST['s']);
                if(!empty($s)){
                    // $query=$this->db->query("SELECT * FROM trx WHERE nama LIKE '%$s%' OR kode LIKE '%$s%' ORDER BY id ASC");
                    $query=$this->db->query("SELECT * FROM `trx` WHERE `uid` = '$uid' ORDER BY `trx_datetime` DESC");
                }
                else{
                    $query=$this->db->query("SELECT * FROM `trx` WHERE `uid` = '$uid' ORDER BY `trx_datetime` DESC");
                }
            }
            else{
                $query=$this->db->query("SELECT * FROM `trx` WHERE `uid` = '$uid' ORDER BY `trx_datetime` DESC, `input_datetime` DESC");
            }
            return $query;
        }
        function trx_single($id){
            $query=$this->db->query("SELECT * FROM `trx` WHERE id = '$id'");
            return $query->result();
        }
        function trx_add(){
            if($this->CI->session->userdata('id')){
                $uid=$this->CI->session->userdata('id');
            }
            else{
                $uid=0;
            }
            $site_key = '6LcuSBITAAAAAP8S4vp62u7WyJVeTxri2Kky3L7m'; // Diisi dengan site_key API Google reCapthca yang sobat miliki
            $secret_key = '6LcuSBITAAAAAH_fAQQ-2h5g-InHcfoEGSuewo6q'; // Diisi dengan secret_key API Google reCapthca yang sobat miliki

            if(isset($_POST['g-recaptcha-response'])){
                $api_url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response='.$_POST['g-recaptcha-response'];
                $response = @file_get_contents($api_url);
                $data = json_decode($response, true);
                if($data['success']){
                    $name=$_POST['name'];
                    $type=$_POST['type'];
                    $nominal=$_POST['nominal'];
                    $date=explode('/', $_POST['date']);
                    $date=$date[2]."-".$date[1]."-".$date[0]." "."00:00:00";
                    $desc=$_POST['desc'];
                    // proses penyimpananan dan lain-lain disini
                    // $success = true;
                    if(empty($name) or $name==""){
                        $name="-";
                        // echo "error1";
                    }
                    if(empty($uid) or $uid=="" or $uid==0){
                        redirect(base_url('login'));
                    }
                    elseif(empty($name) or $name==""){
                        $alert=array('type'=>'danger','icon'=>'ban','title'=>'Kesalahan','dismiss'=>'yes','value'=>'Form belum di isi dengan benar');
                        // echo "error2";
                    }
                    elseif(empty($type) or $type=="" or $type=="0"){
                        $alert=array('type'=>'danger','icon'=>'ban','title'=>'Kesalahan','dismiss'=>'yes','value'=>'Form belum di isi dengan benar');
                        // echo "error3";
                    }
                    elseif(empty($nominal) or $nominal=="" or $nominal<1){
                        $alert=array('type'=>'danger','icon'=>'ban','title'=>'Kesalahan','dismiss'=>'yes','value'=>'Form belum di isi dengan benar');
                        // echo "error4";
                    }
                    elseif(empty($date) or $date==""){
                        $alert=array('type'=>'danger','icon'=>'ban','title'=>'Kesalahan','dismiss'=>'yes','value'=>'Form belum di isi dengan benar');
                        // echo "error5";
                    }
                    else{
                        $this->db->query("INSERT INTO `trx` (uid,name,type,nominal,trx_datetime,description) VALUES('$uid','$name','$type','$nominal','$date','$desc')");
                        $alert=array('type'=>'success','icon'=>'check','title'=>'Berhasil','dismiss'=>'yes','value'=>'Transaksi berhasil');
                        // echo "error6";
                    }
                }
                else{
                    $alert=array('type'=>'danger','icon'=>'check','title'=>'Berhasil','dismiss'=>'yes','value'=>'Captcha belum benar');
                }
            }
            else{
                $success = false;
            }

            $this->CI->session->set_flashdata('alert','1');
            $this->CI->session->set_flashdata('alert_type',$alert['type']);
            $this->CI->session->set_flashdata('alert_icon',$alert['icon']);
            $this->CI->session->set_flashdata('alert_title',$alert['title']);
            $this->CI->session->set_flashdata('alert_dismiss',$alert['dismiss']);
            $this->CI->session->set_flashdata('alert_value',$alert['value']);
            // echo "error7";
        }
        function trx_edit(){
            if(isset($_GET['id'])){
                $id=$_GET['id'];
                unset($_GET['id']);
                if($this->CI->session->userdata('id')){
                    $uid=$this->CI->session->userdata('id');
                    $name=$_POST['name'];
                    $type=$_POST['type'];
                    $nominal=$_POST['nominal'];
                    $date=explode('/', $_POST['date']);
                    $date=$date[2]."-".$date[1]."-".$date[0]." "."00:00:00";
                    $desc=$_POST['desc'];
                    //$ketua=$_POST['ketua'];
                    if(empty($name) or $name==""){
                        $name="-";
                        // echo "error1";
                    }
                    if(empty($uid) or $uid=="" or $uid==0){
                        $this->CI->session->set_flashdata('sukses','Silahkan login dan ulangi proses sebelumnya');
                        redirect(base_url('login'));
                    }
                    elseif(empty($name) or $name==""){
                        $alert=array('type'=>'danger','icon'=>'ban','title'=>'Kesalahan','dismiss'=>'yes','value'=>'Form belum di isi dengan benar');
                        // echo "error2";
                    }
                    elseif(empty($type) or $type=="" or $type=="0"){
                        $alert=array('type'=>'danger','icon'=>'ban','title'=>'Kesalahan','dismiss'=>'yes','value'=>'Form belum di isi dengan benar');
                        // echo "error3";
                    }
                    elseif(empty($nominal) or $nominal=="" or $nominal<1){
                        $alert=array('type'=>'danger','icon'=>'ban','title'=>'Kesalahan','dismiss'=>'yes','value'=>'Form belum di isi dengan benar');
                        // echo "error4";
                    }
                    elseif(empty($date) or $date==""){
                        $alert=array('type'=>'danger','icon'=>'ban','title'=>'Kesalahan','dismiss'=>'yes','value'=>'Form belum di isi dengan benar');
                        // echo "error5";
                    }
                    else{
                        $this->db->query("UPDATE `trx` SET `name` = '$name' , `type` = '$type' , `nominal` = '$nominal' , `trx_datetime` = '$date' WHERE `id` = '$id' AND `uid` = '$uid'");
                        $alert=array('type'=>'success','icon'=>'check','title'=>'Berhasil','dismiss'=>'yes','value'=>'Jurusan berhasil di edit');
                    }
                    $this->CI->session->set_flashdata('alert','1');
                    $this->CI->session->set_flashdata('alert_type',$alert['type']);
                    $this->CI->session->set_flashdata('alert_icon',$alert['icon']);
                    $this->CI->session->set_flashdata('alert_title',$alert['title']);
                    $this->CI->session->set_flashdata('alert_dismiss',$alert['dismiss']);
                    $this->CI->session->set_flashdata('alert_value',$alert['value']);
                }
                else{
                    $this->session->sess_destroy();
                    $this->CI->session->set_flashdata('sukses','Proses gagal, silahkan login');
                    redirect(base_url('login'));
                }
            }
            else{
                unset($_GET['id']);
                $alert=array('type'=>'danger','icon'=>'ban','title'=>'Kesalahan','dismiss'=>'yes','value'=>'Jurusan tidak terdaftar');
            }
            $this->CI->session->set_flashdata('alert','1');
            $this->CI->session->set_flashdata('alert_type',$alert['type']);
            $this->CI->session->set_flashdata('alert_icon',$alert['icon']);
            $this->CI->session->set_flashdata('alert_title',$alert['title']);
            $this->CI->session->set_flashdata('alert_dismiss',$alert['dismiss']);
            $this->CI->session->set_flashdata('alert_value',$alert['value']);
        }
        function trx_del(){
            if(isset($_GET['id'])){
                $id=$_GET['id'];
                unset($_GET['id']);
                if($this->CI->session->userdata('id')){
                $uid=$this->CI->session->userdata('id');
                }
                else{
                    $uid=0;
                }
                $query=$this->db->query("SELECT * FROM `trx` WHERE `id` = '$id' AND `uid` = '$uid'");
                if($query->num_rows()==1){
                    $this->db->query("DELETE FROM `trx` WHERE `id` = '$id' AND `uid` = '$uid'");
                    $alert=array('type'=>'success','icon'=>'check','title'=>'Berhasil','dismiss'=>'yes','value'=>'Transaksi berhasil di hapus');
                }
                else{
                    $alert=array('type'=>'danger','icon'=>'ban','title'=>'Gagal','dismiss'=>'yes','value'=>'Data tidak temukan');
                }
                //alert
                $this->CI->session->set_flashdata('alert','1');
                $this->CI->session->set_flashdata('alert_type',$alert['type']);
                $this->CI->session->set_flashdata('alert_icon',$alert['icon']);
                $this->CI->session->set_flashdata('alert_title',$alert['title']);
                $this->CI->session->set_flashdata('alert_dismiss',$alert['dismiss']);
                $this->CI->session->set_flashdata('alert_value',$alert['value']);
            }
        }
        function setting_account_update(){
            if($this->CI->session->userdata('id')){
                $site_key = '6LcuSBITAAAAAP8S4vp62u7WyJVeTxri2Kky3L7m'; // Diisi dengan site_key API Google reCapthca yang sobat miliki
                $secret_key = '6LcuSBITAAAAAH_fAQQ-2h5g-InHcfoEGSuewo6q'; // Diisi dengan secret_key API Google reCapthca yang sobat miliki
                if(isset($_POST['g-recaptcha-response'])){
                    $api_url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response='.$_POST['g-recaptcha-response'];
                    $response = @file_get_contents($api_url);
                    $data = json_decode($response, true);

                    if($data['success']){
                        $uid=$this->CI->session->userdata('id');
                        $first_name=$_POST['first_name'];
                        $last_name=$_POST['last_name'];
                        $birth_place=$_POST['birth_place'];
                        $birth_date=explode('/', $_POST['birth_date']);
                        $birth_date=$birth_date[2]."-".$birth_date[1]."-".$birth_date[0]." "."00:00:00";
                        $address=$_POST['address'];
                        $email=$_POST['email'];
                        $username=$_POST['username'];
                        $password=$_POST['password'];
                        $repassword=$_POST['repassword'];
                        if(empty($password) or $password==""){
                        }
                        else{
                            $password=md5($password);
                            $repassword=md5($repassword);
                        }
                        $query=$this->db->query("SELECT * FROM `user` WHERE `id` = '$uid'");
                        $num_rows=$query->num_rows();
                        if(empty($num_rows) or $num_rows==0){
                            $this->session->sess_destroy();
                            $this->CI->session->set_flashdata('sukses','Proses gagal, silahkan login');
                            redirect(base_url('login'));
                        }
                        else{
                            if(empty($first_name) or $first_name==""){
                                $alert=array('type'=>'danger','icon'=>'ban','title'=>'Kesalahan','dismiss'=>'yes','value'=>'Form belum di isi dengan benar');
                            }
                            elseif(empty($last_name) or $last_name==""){
                                $alert=array('type'=>'danger','icon'=>'ban','title'=>'Kesalahan','dismiss'=>'yes','value'=>'Form belum di isi dengan benar');
                            }
                            elseif(empty($birth_place) or $birth_place==""){
                                $alert=array('type'=>'danger','icon'=>'ban','title'=>'Kesalahan','dismiss'=>'yes','value'=>'Form belum di isi dengan benar');
                            }
                            elseif(empty($birth_date) or $birth_date==""){
                                $alert=array('type'=>'danger','icon'=>'ban','title'=>'Kesalahan','dismiss'=>'yes','value'=>'Form belum di isi dengan benar');
                            }
                            elseif(empty($address) or $address==""){
                                $alert=array('type'=>'danger','icon'=>'ban','title'=>'Kesalahan','dismiss'=>'yes','value'=>'Form belum di isi dengan benar');
                            }
                            elseif(empty($email) or $email==""){
                                $alert=array('type'=>'danger','icon'=>'ban','title'=>'Kesalahan','dismiss'=>'yes','value'=>'Form belum di isi dengan benar');
                                echo "Error7";
                            }
                            elseif(empty($username) or $username==""){
                                $alert=array('type'=>'danger','icon'=>'ban','title'=>'Kesalahan','dismiss'=>'yes','value'=>'Form belum di isi dengan benar');
                            }
                            elseif((empty($password) or $password=="") and (empty($repassword) or $password=="")){
                                $this->db->query("UPDATE `user` SET `first_name` = '$first_name' , `last_name` = '$last_name' , `birth_place` = '$birth_place' , `birth_date` = '$birth_date' , `address` = '$address' , `email` = '$email' , `username` = '$username' WHERE `id` = '$uid'");
                                $alert=array('type'=>'success','icon'=>'check','title'=>'Berhasil','dismiss'=>'yes','value'=>'Informasi akun berhasil di update');
                            }
                            elseif($password!=$repassword){
                                $alert=array('type'=>'danger','icon'=>'ban','title'=>'Kesalahan','dismiss'=>'yes','value'=>'Form belum di isi dengan benar');
                                echo $password."\n".$repassword;
                            }
                            else{
                                $this->db->query("UPDATE `user` SET `first_name` = '$first_name' , `last_name` = '$last_name' , `birth_place` = '$birth_place' , `birth_date` = '$birth_date' , `address` = '$address' , `email` = '$email' , `username` = '$username' , `password` = '$password' WHERE `id` = '$uid'");
                                $alert=array('type'=>'success','icon'=>'check','title'=>'Berhasil','dismiss'=>'yes','value'=>'Informasi akun berhasil di update');
                            }
                        }
                    }
                    else{
                        $alert=array('type'=>'danger','icon'=>'check','title'=>'Berhasil','dismiss'=>'yes','value'=>'Captcha belum benar');
                    }
                }
                else{
                    $alert=array('type'=>'danger','icon'=>'check','title'=>'Berhasil','dismiss'=>'yes','value'=>'Captcha belum benar');
                }

            }
            else{
                $this->session->sess_destroy();
                $this->CI->session->set_flashdata('sukses','Proses gagal, silahkan login');
                redirect(base_url('login'));
            }
            $this->CI->session->set_flashdata('alert','1');
            $this->CI->session->set_flashdata('alert_type',$alert['type']);
            $this->CI->session->set_flashdata('alert_icon',$alert['icon']);
            $this->CI->session->set_flashdata('alert_title',$alert['title']);
            $this->CI->session->set_flashdata('alert_dismiss',$alert['dismiss']);
            $this->CI->session->set_flashdata('alert_value',$alert['value']);
        }
        function setting_account_two_step_save(){
            $ga=new PHPGangsta_GoogleAuthenticator();
            if($this->CI->session->userdata('id')){
                $uid=$this->CI->session->userdata('id');
                $secret=$_POST["secret"];
                $otp_valid=$ga->getCode($secret);
                $otp=$_POST["otp"];
                $password=md5($_POST["password"]);
                if(empty($secret) or $secret==""){
                    $alert=array('type'=>'danger','icon'=>'check','title'=>'Berhasil','dismiss'=>'yes','value'=>'Captcha belum benar');
                    echo "Secret kosong";
                }
                elseif(empty($otp) or $otp==""){
                    $alert=array('type'=>'danger','icon'=>'check','title'=>'Berhasil','dismiss'=>'yes','value'=>'Captcha belum benar');
                    echo "OTP kosong";
                }
                elseif($otp!=$otp_valid){
                    $alert=array('type'=>'danger','icon'=>'check','title'=>'Berhasil','dismiss'=>'yes','value'=>'Captcha belum benar');
                    echo "OTP tidak valid";
                }
                else{
                    $check=$this->db->query("SELECT * FROM `user` WHERE `id` = '$uid' AND `password` = '$password'");
                    if($check->num_rows()){
                        $this->db->query("UPDATE `user` SET `secret_key` = '$secret' WHERE `id` = '$uid' AND `password` = '$password'");
                        echo $secret." ".$otp." "."valid";
                        $alert=array('type'=>'danger','icon'=>'check','title'=>'Berhasil','dismiss'=>'yes','value'=>'Captcha belum benar');
                    }
                    else{
                        $alert=array('type'=>'danger','icon'=>'check','title'=>'Berhasil','dismiss'=>'yes','value'=>'Captcha belum benar');
                        echo "password salah";
                    }
                }
            }
            else{
                $this->session->sess_destroy();
                $this->CI->session->set_flashdata('sukses','Proses gagal, silahkan login');
                redirect(base_url('login'));
            }
            $this->CI->session->set_flashdata('alert','1');
            $this->CI->session->set_flashdata('alert_type',$alert['type']);
            $this->CI->session->set_flashdata('alert_icon',$alert['icon']);
            $this->CI->session->set_flashdata('alert_title',$alert['title']);
            $this->CI->session->set_flashdata('alert_dismiss',$alert['dismiss']);
            $this->CI->session->set_flashdata('alert_value',$alert['value']);
        }
    }
?>